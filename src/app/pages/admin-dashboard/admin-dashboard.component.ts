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

  private apiUrl = 'http://127.0.0.1:8000/api/admin/stats';

  constructor(
    private http: HttpClient,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.loadStats();
  }

  private loadStats(): void {
    this.loading = true;
    this.errorMsg = '';

    this.http.get<AdminStats>(this.apiUrl).subscribe({
      next: (res) => {
        console.log('STAT API válasz:', res);

        this.stats = {
          usersCount: Number(res.usersCount ?? 0),
          carsCount: Number(res.carsCount ?? 0),
          availableCars: Number(res.availableCars ?? 0),
          adminsCount: Number(res.adminsCount ?? 0),
        };

        this.loading = false;
      },
      error: (err: HttpErrorResponse) => {
        console.error('STAT API hiba:', err);
        this.loading = false;
        this.errorMsg = `Nem sikerült betölteni az adatokat. Hibakód: ${err.status}`;
      },
    });
  }

  logout(): void {
    localStorage.removeItem('admin_token');
    this.router.navigate(['/admin/login']);
  }
}