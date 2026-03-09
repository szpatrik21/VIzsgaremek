import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';

type AdminStats = {
  usersCount: number;
  carsCount: number;
  availableCars: number;
  adminsCount: number;
};

@Component({
  selector: 'app-admin-dashboard',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './admin-dashboard.component.html',
  styleUrls: ['./admin-dashboard.component.css'],
})
export class AdminDashboardComponent implements OnInit {
  loading = true;
  errorMsg = '';

  stats: AdminStats = {
    usersCount: 0,
    carsCount: 0,
    availableCars: 0,
    adminsCount: 0,
  };

  constructor(
    private http: HttpClient,
    private router: Router
  ) {}

  ngOnInit(): void {
    // ha nincs token -> admin login
    const token = localStorage.getItem('admin_token') || '';
    if (!token) {
      this.router.navigate(['/admin/login']);
      return;
    }

    this.loadStats(token);
  }

  private loadStats(token: string): void {
    this.loading = true;
    this.errorMsg = '';

    // ✅ Endpoint: ha nálad más, itt cseréld
    this.http.get<AdminStats>('/api/admin/stats', {
      headers: {
        Authorization: 'Bearer ' + token,
        Accept: 'application/json',
      },
    }).subscribe({
      next: (s) => {
        this.stats = {
          usersCount: Number((s as any)?.usersCount ?? 0),
          carsCount: Number((s as any)?.carsCount ?? 0),
          availableCars: Number((s as any)?.availableCars ?? 0),
          adminsCount: Number((s as any)?.adminsCount ?? 0),
        };
        this.loading = false;
      },
      error: (err: HttpErrorResponse) => {
        this.loading = false;

        if (err.status === 401 || err.status === 403) {
          localStorage.removeItem('admin_token');
          this.router.navigate(['/admin/login']);
          return;
        }

        this.errorMsg = 'Nem sikerült betölteni az admin adatokat.';
      },
    });
  }

  logout(): void {
    // ha a backendnek is kell logout endpoint, azt itt lehet hívni
    localStorage.removeItem('admin_token');
    this.router.navigate(['/admin/login']);
  }
}