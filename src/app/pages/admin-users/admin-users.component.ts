import { Component, OnInit, OnDestroy, Renderer2 } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';
import { AdminNavbarComponent } from '../admin-navbar/admin-navbar.component';

type UserItem = {
  id: number;
  profile_image?: string | null;
  username: string;
  first_name: string;
  last_name: string;
  email: string;
  phone?: string | null;
  birthdate?: string | null;
  address?: string | null;
  role: string;
  created_at: string;
};

@Component({
  selector: 'app-admin-users',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    HttpClientModule,
    AdminNavbarComponent
  ],
  templateUrl: './admin-users.component.html',
  styleUrls: ['./admin-users.component.css', '../../../admin.css'],
})
export class AdminUsersComponent implements OnInit, OnDestroy {
  users: UserItem[] = [];
  loading = false;
  msg = '';
  msgOk = false;

  currentPage = 1;
  pageSize = 10;

  private apiUrl = 'http://127.0.0.1:8080/api';

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

    this.loadUsers();
  }

  ngOnDestroy(): void {
    this.renderer.removeClass(document.body, 'admin-mode');
  }

  get totalPages(): number {
    return Math.ceil(this.users.length / this.pageSize) || 1;
  }

  get pagedUsers(): UserItem[] {
    const start = (this.currentPage - 1) * this.pageSize;
    return this.users.slice(start, start + this.pageSize);
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

  goToPage(page: number): void {
    if (page < 1 || page > this.totalPages) {
      return;
    }

    this.currentPage = page;
  }

  prevPage(): void {
    if (this.currentPage > 1) {
      this.currentPage--;
    }
  }

  nextPage(): void {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
    }
  }

  private adminToken(): string {
    return localStorage.getItem('admin_token') || '';
  }

  private getAuthHeaders(): HttpHeaders {
    const token = this.adminToken();

    return new HttpHeaders({
      Authorization: `Bearer ${token}`,
      Accept: 'application/json',
    });
  }

  private setMsg(text: string, ok = false): void {
    this.msg = text;
    this.msgOk = ok;
  }

  private firstErrorMessage(err: any): string {
    if (typeof err === 'string' && err.trim()) {
      return err;
    }

    if (err?.error?.message && typeof err.error.message === 'string') {
      return err.error.message;
    }

    if (err?.message && typeof err.message === 'string') {
      return err.message;
    }

    const errors = err?.error?.errors || err?.errors;
    if (errors && typeof errors === 'object') {
      const firstKey = Object.keys(errors)[0];
      const firstValue = errors[firstKey];

      if (Array.isArray(firstValue) && firstValue.length > 0) {
        return String(firstValue[0]);
      }

      if (typeof firstValue === 'string') {
        return firstValue;
      }
    }

    return 'Hiba történt.';
  }

  private extractUsers(res: any): UserItem[] {
    if (Array.isArray(res)) {
      return res;
    }

    if (Array.isArray(res?.data)) {
      return res.data;
    }

    if (Array.isArray(res?.users)) {
      return res.users;
    }

    return [];
  }

  private handleAuthError(err: HttpErrorResponse): boolean {
    if (err.status === 401 || err.status === 403) {
      localStorage.removeItem('admin_token');
      this.router.navigate(['/admin/login']);
      return true;
    }

    return false;
  }

  loadUsers(): void {
    if (!this.adminToken()) {
      this.router.navigate(['/admin/login']);
      return;
    }

    this.loading = true;
    this.setMsg('');

    this.http.get<any>(`${this.apiUrl}/admin/users`, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        this.loading = false;
        this.users = this.extractUsers(res);
        this.currentPage = 1;

        if (!this.users.length) {
          this.setMsg('Nincs megjeleníthető felhasználó, vagy az API nem a várt formában küldi az adatokat.');
        }

        console.log('Felhasználók API válasz:', res);
        console.log('Feldolgozott felhasználók:', this.users);
      },
      error: (err: HttpErrorResponse) => {
        this.loading = false;

        console.error('Felhasználók betöltési hiba:', err);

        if (this.handleAuthError(err)) {
          return;
        }

        if (err.status === 0) {
          this.setMsg('Nem érhető el a szerver. Ellenőrizd, hogy fut-e a Laravel backend és jó-e a port.');
          return;
        }

        this.setMsg(this.firstErrorMessage(err));
      },
    });
  }

imageUrl(image?: string | null): string {
  if (!image) return '';

  if (image.startsWith('http://') || image.startsWith('https://')) {
    return image;
  }

  return `http://127.0.0.1:8080/storage/${image}`;
}

  fullName(user: UserItem): string {
    return `${user.first_name || ''} ${user.last_name || ''}`.trim();
  }

  formatDate(date?: string | null): string {
    if (!date) return '-';

    const d = new Date(date);
    if (isNaN(d.getTime())) {
      return date;
    }

    return d.toLocaleDateString('hu-HU');
  }
}