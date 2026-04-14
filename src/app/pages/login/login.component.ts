import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, Validators, ReactiveFormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router, RouterLink } from '@angular/router';
import { NavbarComponent } from '../../navbar/navbar.component';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink, NavbarComponent],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent {
  loading = false;

  msg = '';
  msgType = '';

  form;

  constructor(
    private fb: FormBuilder,
    private http: HttpClient,
    private router: Router
  ) {
    this.form = this.fb.group({
      username: ['', [Validators.required]],
      password: ['', [Validators.required]],
    });
  }

  submit(): void {
    this.msg = '';
    this.msgType = '';

    if (this.form.invalid) {
      this.msg = 'Hiányzó vagy hibás adatok!';
      this.msgType = 'error';
      this.form.markAllAsTouched();
      return;
    }

    const payload = {
      username: (this.form.value.username ?? '').trim(),
      password: this.form.value.password ?? '',
    };

    this.loading = true;

    this.http.post<any>('/api/login', payload, { headers: { Accept: 'application/json' } }).subscribe({
      next: (data) => {
        this.loading = false;

        const token = data?.token || data?.jwt_token || data?.access_token;
        if (token) localStorage.setItem('jwt_token', token);

        this.msg = 'Sikeres bejelentkezés!';
        this.msgType = 'success';

        setTimeout(() => {
          this.router.navigateByUrl('/');
        }, 1000);
      },
      error: (err: any) => {
        this.loading = false;

        const status = err?.status;

        if (status === 401) {
          this.msg = 'Hibás felhasználónév vagy jelszó!';
          this.msgType = 'error';
          return;
        }
        if (status === 422) {
          this.msg = 'Hiányzó vagy hibás adatok!';
          this.msgType = 'error';
          return;
        }
        if (status === 0) {
          this.msg = 'Nem érhető el a szerver.';
          this.msgType = 'error';
          return;
        }

        this.msg = `Szerverhiba (${status || 'ismeretlen'})`;
        this.msgType = 'error';
      }
    });
  }
}