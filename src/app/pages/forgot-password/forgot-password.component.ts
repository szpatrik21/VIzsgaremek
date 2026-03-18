import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { RouterLink } from '@angular/router';
import { NavbarComponent } from '../../navbar/navbar.component';

@Component({
  selector: 'app-forgot-password',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink, NavbarComponent],
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.css'],
})
export class ForgotPasswordComponent {
  loading = false;
  msg = '';
  msgType = '';

  form;

  constructor(
    private fb: FormBuilder,
    private http: HttpClient
  ) {
    this.form = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
    });
  }

  submit(): void {
    this.msg = '';
    this.msgType = '';

    if (this.form.invalid) {
      this.msg = 'Adj meg egy érvényes email címet!';
      this.msgType = 'error';
      this.form.markAllAsTouched();
      return;
    }

    const payload = {
      email: (this.form.value.email ?? '').trim(),
    };

    this.loading = true;

    this.http.post<any>('/api/forgot-password', payload, {
      headers: { Accept: 'application/json' }
    }).subscribe({
      next: () => {
        this.loading = false;
        this.msg = 'Ha létezik ilyen fiók, elküldtük a jelszó-visszaállító linket.';
        this.msgType = 'success';
        this.form.reset();
      },
      error: (err: any) => {
        this.loading = false;

        const status = err?.status;

        if (status === 422) {
          this.msg = 'Adj meg egy érvényes email címet!';
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