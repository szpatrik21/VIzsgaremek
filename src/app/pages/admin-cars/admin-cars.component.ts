import { Component, OnInit, OnDestroy, Renderer2 } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';
import { AdminNavbarComponent } from '../admin-navbar/admin-navbar.component';

type AutoItem = {
  id: number;
  marka: string;
  modell: string;
  evjarat: number;
  teljesitmeny: number;
  uzemanyag: string;
  ar: number;
  kiemelt: number | boolean;
  raktaron: number;
  kep?: string | null;
};

@Component({
  selector: 'app-admin-cars',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    RouterModule,
    HttpClientModule,
    AdminNavbarComponent
  ],
  templateUrl: './admin-cars.component.html',
  styleUrls: ['./admin-cars.component.css', '../../../admin.css'],
})
export class AdminCarsComponent implements OnInit, OnDestroy {
  autok: AutoItem[] = [];
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

    this.loadCars();
  }

  ngOnDestroy(): void {
    this.renderer.removeClass(document.body, 'admin-mode');
  }

  get totalPages(): number {
    return Math.ceil(this.autok.length / this.pageSize) || 1;
  }

  get pagedAutok(): AutoItem[] {
    const start = (this.currentPage - 1) * this.pageSize;
    return this.autok.slice(start, start + this.pageSize);
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

  private extractCars(res: any): AutoItem[] {
    if (Array.isArray(res)) {
      return res;
    }

    if (Array.isArray(res?.data)) {
      return res.data;
    }

    if (Array.isArray(res?.autok)) {
      return res.autok;
    }

    if (Array.isArray(res?.cars)) {
      return res.cars;
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

  loadCars(): void {
    if (!this.adminToken()) {
      this.router.navigate(['/admin/login']);
      return;
    }

    this.loading = true;
    this.setMsg('');

    this.http.get<any>(`${this.apiUrl}/admin/cars`, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        this.loading = false;
        this.autok = this.extractCars(res);
        this.currentPage = 1;

        if (!this.autok.length) {
          this.setMsg('Nincs megjeleníthető autó, vagy az API nem a várt formában küldi az adatokat.');
        }

        console.log('Autók API válasz:', res);
        console.log('Feldolgozott autók:', this.autok);
      },
      error: (err: HttpErrorResponse) => {
        this.loading = false;

        console.error('Autók betöltési hiba:', err);

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

  updateCar(auto: AutoItem): void {
    if (!this.adminToken()) {
      this.router.navigate(['/admin/login']);
      return;
    }

    this.setMsg('');

    this.http.patch<any>(
      `${this.apiUrl}/admin/cars/${auto.id}`,
      {
        raktaron: Number(auto.raktaron),
        kiemelt: Number(auto.kiemelt),
      },
      {
        headers: this.getAuthHeaders(),
      }
    ).subscribe({
      next: (res) => {
        this.setMsg(res?.message || 'Autó frissítve.', true);
      },
      error: (err: HttpErrorResponse) => {
        console.error('Autó frissítési hiba:', err);

        if (this.handleAuthError(err)) {
          return;
        }

        this.setMsg(this.firstErrorMessage(err));
      },
    });
  }

  deleteCar(auto: AutoItem): void {
    const biztos = confirm(`Biztos törlöd ezt az autót? (${auto.marka} ${auto.modell})`);
    if (!biztos) {
      return;
    }

    if (!this.adminToken()) {
      this.router.navigate(['/admin/login']);
      return;
    }

    this.setMsg('');

    this.http.delete<any>(`${this.apiUrl}/admin/cars/${auto.id}`, {
      headers: this.getAuthHeaders(),
    }).subscribe({
      next: (res) => {
        this.autok = this.autok.filter(a => a.id !== auto.id);

        if (this.currentPage > this.totalPages) {
          this.currentPage = this.totalPages;
        }

        this.setMsg(res?.message || 'Autó törölve.', true);
      },
      error: (err: HttpErrorResponse) => {
        console.error('Autó törlési hiba:', err);

        if (this.handleAuthError(err)) {
          return;
        }

        this.setMsg(this.firstErrorMessage(err));
      },
    });
  }

  imageUrl(kep?: string | null): string {
    if (!kep) return '';

    if (kep.startsWith('http://') || kep.startsWith('https://')) {
      return kep;
    }

    return `http://127.0.0.1:8080/${kep}`;
  }
}