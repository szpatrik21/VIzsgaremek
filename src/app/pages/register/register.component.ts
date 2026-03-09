import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NonNullableFormBuilder, Validators, ReactiveFormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { NavbarComponent } from '../../navbar/navbar.component';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, NavbarComponent],
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
})
export class RegisterComponent {
  loading = false;

  msg = '';
  msgType: 'error' | 'success' | '' = '';

  form;

  constructor(
    private fb: NonNullableFormBuilder,
    private http: HttpClient,
    private router: Router
  ) {
    this.form = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      username: ['', [Validators.required, Validators.minLength(2)]],
      last_name: ['', [Validators.required, Validators.minLength(2)]],
      first_name: ['', [Validators.required, Validators.minLength(2)]],
      password: ['', [Validators.required, Validators.minLength(6)]],
      phone: ['', [Validators.required, Validators.minLength(6)]],
      birthdate: ['', [Validators.required]],
      address: ['', [Validators.required, Validators.minLength(3)]],
    });
  }

  submit(): void {
    this.msg = '';
    this.msgType = '';

    if (this.form.invalid) {
      this.msg = 'Tölts ki minden mezőt rendesen.';
      this.msgType = 'error';
      this.form.markAllAsTouched();
      return;
    }

const v = this.form.getRawValue();

const payload = {
  email: v.email.trim(),
  username: v.username.trim(),
  last_name: v.last_name.trim(),
  first_name: v.first_name.trim(),
  password: v.password,
  phone: v.phone.trim(),
  birthdate: v.birthdate,
  address: v.address.trim(),
};

    this.loading = true;

    this.http.post<any>('/api/register', payload, { headers: { Accept: 'application/json' } }).subscribe({
      next: (data) => {
        this.loading = false;
        this.msg = data?.message || 'Sikeres regisztráció! ✅';
        this.msgType = 'success';
        this.form.reset();

        window.setTimeout(() => this.router.navigateByUrl('/login'), 1200);
      },
      error: (err: any) => {
        this.loading = false;

        const api = err?.error as any;
        const errors = api?.errors as Record<string, string[]> | undefined;

        if (errors && Object.keys(errors).length) {
          const firstKey = Object.keys(errors)[0];
          this.msg = errors[firstKey]?.[0] || 'Hiba történt a regisztrációnál!';
        } else {
          this.msg = api?.message || 'Hiba történt a regisztrációnál!';
        }
        this.msgType = 'error';
      }
    });
  }
}