import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { NavbarComponent } from '../../navbar/navbar.component';
import { FooterComponent } from '../../footer/footer.component';

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

type MyCommentDto = {
  id: number;
  content: string;
  created_at?: string;
  auto_nev?: string;
};

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule,
    NavbarComponent,
    FooterComponent
  ],
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

  passwordLoading = false;
  passwordMsg = '';
  passwordMsgType = '';

  commentsLoading = false;
  commentMsg = '';
  commentMsgType = '';
  myComments: MyCommentDto[] = [];

  passwordForm;

  constructor(
    private http: HttpClient,
    private router: Router,
    private fb: FormBuilder
  ) {
    this.passwordForm = this.fb.group({
      current_password: ['', [Validators.required]],
      password: ['', [Validators.required, Validators.minLength(8)]],
      password_confirmation: ['', [Validators.required]],
    });
  }

  ngOnInit(): void {
    this.loadUser();
    this.loadMyComments();
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

  loadMyComments(): void {
    const t = this.token();
    if (!t) return;

    this.commentsLoading = true;
    this.commentMsg = '';
    this.commentMsgType = '';

    this.http.get<MyCommentDto[]>('/api/my-comments', { headers: this.authHeaders() }).subscribe({
      next: (data) => {
        this.myComments = data ?? [];
        this.commentsLoading = false;
      },
      error: (err: HttpErrorResponse) => {
        this.commentsLoading = false;

        if (err.status === 401 || err.status === 403) {
          this.kickToLogin();
          return;
        }

        this.commentMsg = 'Nem sikerült betölteni a kommenteket.';
        this.commentMsgType = 'error';
      },
    });
  }

  changePassword(): void {
    this.passwordMsg = '';
    this.passwordMsgType = '';

    if (this.passwordForm.invalid) {
      this.passwordMsg = 'Tölts ki minden mezőt helyesen.';
      this.passwordMsgType = 'error';
      this.passwordForm.markAllAsTouched();
      return;
    }

    const password = this.passwordForm.value.password ?? '';
    const passwordConfirmation = this.passwordForm.value.password_confirmation ?? '';

    if (password !== passwordConfirmation) {
      this.passwordMsg = 'A két új jelszó nem egyezik.';
      this.passwordMsgType = 'error';
      return;
    }

    this.passwordLoading = true;

    this.http.post<any>(
      '/api/change-password',
      {
        current_password: this.passwordForm.value.current_password ?? '',
        password,
        password_confirmation: passwordConfirmation,
      },
      { headers: this.authHeaders() }
    ).subscribe({
      next: (res) => {
        this.passwordLoading = false;
        this.passwordMsg = res?.message || 'A jelszó sikeresen módosítva.';
        this.passwordMsgType = 'success';
        this.passwordForm.reset();
      },
      error: (err: HttpErrorResponse) => {
        this.passwordLoading = false;

        if (err.status === 401 || err.status === 403) {
          this.kickToLogin();
          return;
        }

        this.passwordMsg = err.error?.message || 'Nem sikerült módosítani a jelszót.';
        this.passwordMsgType = 'error';
      },
    });
  }

  deleteComment(id: number): void {
    const ok = confirm('Biztosan törölni akarod ezt a kommentet?');
    if (!ok) return;

    this.commentMsg = '';
    this.commentMsgType = '';

    this.http.delete<any>(`/api/my-comments/${id}`, { headers: this.authHeaders() }).subscribe({
      next: (res) => {
        this.myComments = this.myComments.filter(c => c.id !== id);
        this.commentMsg = res?.message || 'Komment törölve.';
        this.commentMsgType = 'success';
      },
      error: (err: HttpErrorResponse) => {
        if (err.status === 401 || err.status === 403) {
          this.kickToLogin();
          return;
        }

        this.commentMsg = err.error?.message || 'Nem sikerült törölni a kommentet.';
        this.commentMsgType = 'error';
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

  formatDate(raw?: string): string {
    if (!raw) return '—';
    const d = new Date(raw);
    return isNaN(d.getTime()) ? '—' : d.toLocaleDateString('hu-HU');
  }

  profileImgSrc(): string {
    const p = this.user?.profile_image;
    return p ? `/storage/${p}` : '/assets/images/profilkep.jpg';
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
        Accept: 'application/json',
      }),
    }).subscribe({
      next: (data) => {
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
    t.src = '/assets/images/profilkep.jpg';
  }
}