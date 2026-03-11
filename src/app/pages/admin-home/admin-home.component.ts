import { Component, OnInit, OnDestroy, Renderer2 } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';
import { AdminNavbarComponent } from '../admin-navbar/admin-navbar.component';

type DashboardStats = {
  carsCount: number;
  featuredCars: number;
  usersCount: number;
  commentsCount: number;
};

type DashboardComment = {
  id: number;
  author: string;
  car_name: string;
  content: string;
  created_at: string;
  is_new: boolean;
};

@Component({
  selector: 'app-admin-home',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    HttpClientModule,
    AdminNavbarComponent
  ],
  templateUrl: './admin-home.component.html',
  styleUrls: ['./admin-home.component.css', '../../../admin.css']
})
export class AdminHomeComponent implements OnInit, OnDestroy {
  loading = false;
  errorMsg = '';

  stats: DashboardStats = {
    carsCount: 0,
    featuredCars: 0,
    usersCount: 0,
    commentsCount: 0
  };

  latestComments: DashboardComment[] = [];

  private apiUrl = 'http://127.0.0.1:8080/api/admin/dashboard';

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

    this.loadDashboard();
  }

  ngOnDestroy(): void {
    this.renderer.removeClass(document.body, 'admin-mode');
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

  private handleAuthError(err: HttpErrorResponse): boolean {
    if (err.status === 401 || err.status === 403) {
      localStorage.removeItem('admin_token');
      this.router.navigate(['/admin/login']);
      return true;
    }

    return false;
  }

  loadDashboard(): void {
    this.loading = true;
    this.errorMsg = '';

    this.http.get<any>(this.apiUrl, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        this.loading = false;
        this.stats = res?.stats || this.stats;
        this.latestComments = res?.latest_comments || [];
      },
      error: (err: HttpErrorResponse) => {
        this.loading = false;
        console.error('Dashboard betöltési hiba:', err);

        if (this.handleAuthError(err)) {
          return;
        }

        if (err.status === 0) {
          this.errorMsg = 'Nem érhető el a Laravel API. Ellenőrizd, hogy fut-e a backend és jó-e a port.';
          return;
        }

        this.errorMsg = err?.error?.message || 'Hiba történt a dashboard betöltése közben.';
      }
    });
  }

  formatDate(date: string): string {
    if (!date) return '-';

    const d = new Date(date);
    if (isNaN(d.getTime())) {
      return date;
    }

    return d.toLocaleString('hu-HU');
  }
}