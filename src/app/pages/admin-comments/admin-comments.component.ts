import { Component, OnInit, OnDestroy, Renderer2 } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';
import { AdminNavbarComponent } from '../admin-navbar/admin-navbar.component';

type AdminComment = {
  id: number;
  author: string;
  car_name: string;
  content: string;
  status: 'pending' | 'approved' | 'rejected';
  created_at: string;
};

type PaginatedCommentsResponse = {
  data: AdminComment[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
};

@Component({
  selector: 'app-admin-comments',
  standalone: true,
  imports: [CommonModule, RouterModule, HttpClientModule, AdminNavbarComponent],
  templateUrl: './admin-comments.component.html',
  styleUrls: ['./admin-comments.component.css', '../../../admin.css']
})
export class AdminCommentsComponent implements OnInit, OnDestroy {
  comments: AdminComment[] = [];
  loading = false;
  msg = '';
  msgOk = false;

  currentPage = 1;
  totalPages = 1;
  totalItems = 0;
  perPage = 10;

  private apiUrl = '/api';

  constructor(
    private http: HttpClient,
    private router: Router,
    private renderer: Renderer2
  ) {}

  ngOnInit(): void {
    this.renderer.addClass(document.body, 'admin-mode');

    if (!this.adminToken()) {
      this.router.navigate(['/admin/login']);
      return;
    }

    this.loadComments(1);
  }

  ngOnDestroy(): void {
    this.renderer.removeClass(document.body, 'admin-mode');
  }

  private adminToken(): string {
    return localStorage.getItem('admin_token') || '';
  }

  private getAuthHeaders(): HttpHeaders {
    return new HttpHeaders({
      Authorization: `Bearer ${this.adminToken()}`,
      Accept: 'application/json',
    });
  }

  private setMsg(text: string, ok = false): void {
    this.msg = text;
    this.msgOk = ok;
  }

  private handleAuthError(err: HttpErrorResponse): boolean {
    if (err.status === 401 || err.status === 403) {
      localStorage.removeItem('admin_token');
      this.router.navigate(['/admin/login']);
      return true;
    }

    return false;
  }

  loadComments(page = 1): void {
    this.loading = true;
    this.setMsg('');

    this.http.get<PaginatedCommentsResponse>(`${this.apiUrl}/admin/comments?page=${page}`, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        this.comments = res?.data || [];
        this.currentPage = res?.current_page || 1;
        this.totalPages = res?.last_page || 1;
        this.perPage = res?.per_page || 10;
        this.totalItems = res?.total || 0;
        this.loading = false;
      },
      error: (err: HttpErrorResponse) => {
        this.loading = false;

        if (this.handleAuthError(err)) {
          return;
        }

        if (err.status === 0) {
          this.setMsg('Nem érhető el a szerver. Ellenőrizd, hogy fut-e a Laravel backend.');
          return;
        }

        this.setMsg('Nem sikerült betölteni a kommenteket.');
        console.error(err);
      }
    });
  }

  approveComment(comment: AdminComment): void {
    this.setMsg('');

    this.http.patch<any>(`${this.apiUrl}/admin/comments/${comment.id}/approve`, {}, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        comment.status = 'approved';
        this.setMsg(res?.message || 'Komment jóváhagyva.', true);
      },
      error: (err: HttpErrorResponse) => {
        if (this.handleAuthError(err)) return;
        this.setMsg('Nem sikerült jóváhagyni a kommentet.');
        console.error(err);
      }
    });
  }

  rejectComment(comment: AdminComment): void {
    this.setMsg('');

    this.http.patch<any>(`${this.apiUrl}/admin/comments/${comment.id}/reject`, {}, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        comment.status = 'rejected';
        this.setMsg(res?.message || 'Komment elutasítva.', true);
      },
      error: (err: HttpErrorResponse) => {
        if (this.handleAuthError(err)) return;
        this.setMsg('Nem sikerült elutasítani a kommentet.');
        console.error(err);
      }
    });
  }

  deleteComment(comment: AdminComment): void {
    const biztos = confirm('Biztos törlöd ezt a kommentet?');
    if (!biztos) return;

    this.setMsg('');

    this.http.delete<any>(`${this.apiUrl}/admin/comments/${comment.id}`, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        this.setMsg(res?.message || 'Komment törölve.', true);

        if (this.comments.length === 1 && this.currentPage > 1) {
          this.loadComments(this.currentPage - 1);
        } else {
          this.loadComments(this.currentPage);
        }
      },
      error: (err: HttpErrorResponse) => {
        if (this.handleAuthError(err)) return;
        this.setMsg('Nem sikerült törölni a kommentet.');
        console.error(err);
      }
    });
  }

  goToPage(page: number): void {
    if (page < 1 || page > this.totalPages || page === this.currentPage) {
      return;
    }

    this.loadComments(page);
  }

  prevPage(): void {
    if (this.currentPage > 1) {
      this.loadComments(this.currentPage - 1);
    }
  }

  nextPage(): void {
    if (this.currentPage < this.totalPages) {
      this.loadComments(this.currentPage + 1);
    }
  }

  get visiblePages(): number[] {
    const maxVisible = 5;
    let start = Math.max(1, this.currentPage - 2);
    let end = Math.min(this.totalPages, start + maxVisible - 1);

    if (end - start < maxVisible - 1) {
      start = Math.max(1, end - maxVisible + 1);
    }

    return Array.from({ length: end - start + 1 }, (_, i) => start + i);
  }

  formatDate(date: string): string {
    if (!date) return '-';

    const d = new Date(date);
    if (isNaN(d.getTime())) return date;

    return d.toLocaleString('hu-HU');
  }
}