import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';
import { NavbarComponent } from '../../navbar/navbar.component';

type UserDto = {
  username?: string;
  first_name?: string;
  last_name?: string;
  email?: string;
  phone?: string;
  birthdate?: string;
  address?: string;
  created_at?: string;
  profile_image?: string | null;
};

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [CommonModule, RouterModule, NavbarComponent],
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css'],
})
export class ProfileComponent implements OnInit {
  loading = true;
  errorMsg = '';

  user: UserDto | null = null;

  uploadMsg = '';
  uploading = false;
  selectedFile: File | null = null;

  constructor(
    private http: HttpClient,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.loadUser();
  }

  private token(): string {
    return localStorage.getItem('jwt_token') || '';
  }

  private authHeaders(): HttpHeaders {
    return new HttpHeaders({
      Authorization: 'Bearer ' + this.token(),
      Accept: 'application/json',
    });
  }

  private kickToLogin(): void {
    localStorage.removeItem('jwt_token');
    this.router.navigate(['/login']);
  }

  loadUser(): void {
    const t = this.token();
    if (!t) {
      this.router.navigate(['/login']);
      return;
    }

    this.loading = true;
    this.errorMsg = '';

    this.http.get<UserDto>('/api/user', { headers: this.authHeaders() }).subscribe({
      next: (u) => {
        this.user = u;
        this.loading = false;
      },
      error: (err: HttpErrorResponse) => {
        this.loading = false;

        if (err.status === 401 || err.status === 403) {
          this.kickToLogin();
          return;
        }

        this.errorMsg = 'Nem sikerült betölteni a profilt.';
      },
    });
  }

  fullName(): string {
    const u = this.user;
    return `${u?.first_name ?? ''} ${u?.last_name ?? ''}`.trim() || '—';
  }

  createdAtHu(): string {
    const raw = this.user?.created_at;
    if (!raw) return '—';
    const d = new Date(raw);
    return isNaN(d.getTime()) ? '—' : d.toLocaleDateString('hu-HU');
  }

  profileImgSrc(): string {
    const p = this.user?.profile_image;
    return p ? `/storage/${p}` : '/assets/images/no-image.png';
  }

  onFileSelected(ev: Event): void {
    const input = ev.target as HTMLInputElement | null;
    const file = input?.files?.[0] ?? null;
    this.selectedFile = file;
    this.uploadMsg = '';
  }

  uploadProfileImage(): void {
    this.uploadMsg = '';

    const t = this.token();
    if (!t) {
      this.uploadMsg = 'Be kell jelentkezned! 🔒';
      this.router.navigate(['/login']);
      return;
    }

    if (!this.selectedFile) {
      this.uploadMsg = 'Válassz ki egy képet!';
      return;
    }

    this.uploading = true;
    this.uploadMsg = 'Feltöltés...';

    const fd = new FormData();
    fd.append('image', this.selectedFile);

    this.http.post<any>('/api/upload-profile-image', fd, {
      headers: new HttpHeaders({
        Authorization: 'Bearer ' + t,
        // Content-Type NE legyen megadva FormData-nál!
        Accept: 'application/json',
      }),
    }).subscribe({
      next: (data) => {
        // backend válasza: { path: "..." } vagy { message: "...", path: "..." }
        const path = data?.path;
        if (this.user && path) this.user.profile_image = path;

        this.uploadMsg = 'Profilkép frissítve! ✅';
        this.uploading = false;
        this.selectedFile = null;
      },
      error: (err: HttpErrorResponse) => {
        this.uploading = false;

        if (err.status === 401 || err.status === 403) {
          this.kickToLogin();
          return;
        }

        const msg = (err.error?.message as string) || 'Hálózati / feltöltési hiba!';
        this.uploadMsg = msg;
      },
    });
  }

  onImgError(ev: Event): void {
    const t = ev.target;
    if (!(t instanceof HTMLImageElement)) return;
    t.onerror = null;
    t.src = '/assets/images/no-image.png';
  }
}
