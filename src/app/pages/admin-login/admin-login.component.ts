import { Component, OnInit, OnDestroy, Renderer2 } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { HttpClient, HttpErrorResponse, HttpClientModule } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';

type AdminLoginResponse = {
  token?: string;
  access_token?: string;
  admin_token?: string;
  message?: string;
  errors?: Record<string, string[]>;
};

@Component({
  selector: 'app-admin-login',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule, HttpClientModule],
  templateUrl: './admin-login.component.html',
  styleUrls: ['./admin-login.component.css', '../../../admin.css'],
})
export class AdminLoginComponent implements OnInit, OnDestroy {
  loading = false;
  errorMsg = '';
  successMsg = '';
  form: FormGroup;

  private apiUrl = 'http://127.0.0.1:8080/api';

  constructor(
    private fb: FormBuilder,
    private http: HttpClient,
    private router: Router,
    private renderer: Renderer2
  ) {
    this.form = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]],
    });
  }

  ngOnInit(): void {
    this.renderer.addClass(document.body, 'admin-mode');
  }

  ngOnDestroy(): void {
    this.renderer.removeClass(document.body, 'admin-mode');
  }

  private firstErrorMessage(err: any): string {
    const msg = err?.message;
    if (typeof msg === 'string' && msg.trim()) {
      return msg;
    }

    const errors = err?.errors;
    if (errors && typeof errors === 'object') {
      const firstKey = Object.keys(errors)[0];
      const arr = errors[firstKey];
      if (Array.isArray(arr) && arr.length > 0) {
        return String(arr[0]);
      }
    }

    return 'Hibás email vagy jelszó.';
  }

  submit(): void {
    this.errorMsg = '';
    this.successMsg = '';

    if (this.form.invalid) {
      this.form.markAllAsTouched();
      this.errorMsg = 'Töltsd ki az emailt és a jelszót.';
      return;
    }

    this.loading = true;

    this.http.post<AdminLoginResponse>(
      `${this.apiUrl}/admin/login`,
      this.form.value,
      {
        headers: {
          Accept: 'application/json',
        },
      }
    ).subscribe({
      next: (res) => {
        const token = res?.token || res?.access_token || res?.admin_token || '';

        this.loading = false;

        if (!token) {
          this.errorMsg = res?.message || 'Nem érkezett token.';
          return;
        }

        localStorage.setItem('admin_token', token);
        this.successMsg = 'Sikeres bejelentkezés!';

        setTimeout(() => {
          this.router.navigate(['/admin']);
        }, 1200);
      },
      error: (e: HttpErrorResponse) => {
        this.loading = false;
        this.errorMsg = this.firstErrorMessage(e.error);
        console.error('Admin login hiba:', e);
      },
    });
  }
}