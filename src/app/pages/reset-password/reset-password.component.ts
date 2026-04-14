import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { NavbarComponent } from '../../navbar/navbar.component';

@Component({
  selector: 'app-reset-password',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink, NavbarComponent],
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.css'],
})
export class ResetPasswordComponent implements OnInit {
  loading = false;
  msg = '';
  msgType = '';

  token = '';
  email = '';

  form;

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private http: HttpClient,
    private router: Router
  ) {
    this.form = this.fb.group({
      password: ['', [Validators.required, Validators.minLength(8)]],
      password_confirmation: ['', [Validators.required]],
    });
  }

  ngOnInit(): void {
    this.route.queryParamMap.subscribe(params => {
      this.token = params.get('token') ?? '';
      this.email = params.get('email') ?? '';
    });
  }

  submit(): void {
    this.msg = '';
    this.msgType = '';

    if (!this.token || !this.email) {
      this.msg = 'Érvénytelen vagy hiányzó visszaállító link.';
      this.msgType = 'error';
      return;
    }

    if (this.form.invalid) {
      this.msg = 'Adj meg érvényes új jelszót!';
      this.msgType = 'error';
      this.form.markAllAsTouched();
      return;
    }

    if (this.form.value.password !== this.form.value.password_confirmation) {
      this.msg = 'A két jelszó nem egyezik.';
      this.msgType = 'error';
      return;
    }

    const payload = {
      token: this.token,
      email: this.email,
      password: this.form.value.password ?? '',
      password_confirmation: this.form.value.password_confirmation ?? '',
    };

    this.loading = true;

    this.http.post<any>('/api/reset-password', payload, {
      headers: { Accept: 'application/json' }
    }).subscribe({
      next: (res) => {
        this.loading = false;
        this.msg = res?.message || 'A jelszó sikeresen módosítva.';
        this.msgType = 'success';

        setTimeout(() => {
          this.router.navigateByUrl('/login');
        }, 1500);
      },
      error: (err) => {
        this.loading = false;

        const status = err?.status;

        if (status === 422) {
          this.msg = err?.error?.message || 'A link lejárt vagy hibás, esetleg a jelszó nem megfelelő.';
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
