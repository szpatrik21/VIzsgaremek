import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpParams } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

type AdminUser = {
  id: number;
  profile_image: string | null;
  username: string;
  first_name: string;
  last_name: string;
  email: string;
  phone: string | null;
  birthdate: string | null;
  address: string | null;
  role: string;
  created_at: string;
  updated_at: string;
};

type PaginatedUsersResponse = {
  current_page: number;
  data: AdminUser[];
  last_page: number;
  per_page: number;
  total: number;
};

@Component({
  selector: 'app-admin-users',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './admin-users.component.html',
  styleUrls: ['./admin-users.component.css']
})
export class AdminUsersComponent implements OnInit {
  loading = false;
  errorMsg = '';
  users: AdminUser[] = [];

  search = '';
  currentPage = 1;
  lastPage = 1;
  perPage = 10;
  total = 0;

  private apiUrl = 'http://127.0.0.1:8000/api/admin/users';

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers(page: number = 1): void {
    this.loading = true;
    this.errorMsg = '';

    let params = new HttpParams()
      .set('page', page)
      .set('per_page', this.perPage);

    if (this.search.trim()) {
      params = params.set('search', this.search.trim());
    }

    this.http.get<PaginatedUsersResponse>(this.apiUrl, { params }).subscribe({
      next: (res) => {
        this.users = res.data;
        this.currentPage = res.current_page;
        this.lastPage = res.last_page;
        this.perPage = res.per_page;
        this.total = res.total;
        this.loading = false;
      },
      error: (err) => {
        console.error(err);
        this.errorMsg = 'Nem sikerült betölteni a felhasználókat.';
        this.loading = false;
      }
    });
  }

  onSearch(): void {
    this.loadUsers(1);
  }

  prevPage(): void {
    if (this.currentPage > 1) {
      this.loadUsers(this.currentPage - 1);
    }
  }

  nextPage(): void {
    if (this.currentPage < this.lastPage) {
      this.loadUsers(this.currentPage + 1);
    }
  }

  fullName(user: AdminUser): string {
    return `${user.first_name ?? ''} ${user.last_name ?? ''}`.trim();
  }

  formatDate(value: string | null): string {
    if (!value) return '-';
    return new Date(value).toLocaleDateString('hu-HU');
  }

  imageUrl(path: string | null): string {
    if (!path) return 'https://via.placeholder.com/60x60?text=No+Image';
    return `http://127.0.0.1:8000/storage/${path}`;
  }
}