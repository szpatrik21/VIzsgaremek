import { Component, OnInit, OnDestroy, Renderer2 } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Router, RouterModule } from '@angular/router';
import { AdminNavbarComponent } from '../admin-navbar/admin-navbar.component';

@Component({
  selector: 'app-admin-carcreate',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    RouterModule,
    AdminNavbarComponent
  ],
  templateUrl: './admin-carcreate.component.html',
  styleUrls: ['./admin-carcreate.component.css', '../../../admin.css'],
})
export class AdminCarcreateComponent implements OnInit, OnDestroy {
  loading = false;
  msg = '';
  msgOk = false;

  image1: File | null = null;
  image2: File | null = null;

  brands = [
    'Alfa Romeo', 'Aston Martin', 'Audi', 'Bentley', 'BMW', 'Bugatti', 'Cadillac', 'Ferrari', 'Genesis', 'Infiniti',
    'Jaguar', 'Koenigsegg', 'Lamborghini', 'Land Rover', 'Lexus', 'Lotus', 'Maserati', 'Maybach', 'McLaren',
    'Mercedes-Benz', 'Pagani', 'Porsche', 'Range Rover', 'Rimac', 'Rolls-Royce', 'Tesla'
  ];

  form: FormGroup;

  private apiUrl = 'http://127.0.0.1:8080/api';

  constructor(
    private fb: FormBuilder,
    private http: HttpClient,
    private router: Router,
    private renderer: Renderer2
  ) {
    const token = this.adminToken();
    if (!token) {
      this.router.navigate(['/admin/login']);
    }

    this.form = this.fb.group({
      marka: ['', Validators.required],
      modell: ['', Validators.required],
      evjarat: [2020, [Validators.required, Validators.min(1900)]],
      kilometerora: [0, [Validators.required, Validators.min(0)]],
      ajtok_szama: [4, Validators.required],
      uzemanyag: ['Benzin', Validators.required],
      teljesitmeny: [0, [Validators.required, Validators.min(0)]],
      ar: [0, [Validators.required, Validators.min(0)]],

      kivitel: ['Kupé', Validators.required],
      allapot: ['Új', Validators.required],
      szemelyek_szama: [4, Validators.required],
      szin: ['Fekete', Validators.required],
      sebessegvalto: ['Automata', Validators.required],
      hengerurtartalom: [0, [Validators.required, Validators.min(0)]],
      raktaron: [1, [Validators.required, Validators.min(0)]],
      kiemelt: [0],
    });
  }

  ngOnInit(): void {
    this.renderer.addClass(document.body, 'admin-mode');
  }

  ngOnDestroy(): void {
    this.renderer.removeClass(document.body, 'admin-mode');
  }

  private adminToken(): string {
    return localStorage.getItem('admin_token') || '';
  }

  private setMsg(text: string, ok = false): void {
    this.msg = text;
    this.msgOk = ok;
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

    return 'Hiba történt feltöltés közben.';
  }

  onFile1(ev: Event): void {
    const input = ev.target as HTMLInputElement | null;
    this.image1 = input?.files?.[0] ?? null;
  }

  onFile2(ev: Event): void {
    const input = ev.target as HTMLInputElement | null;
    this.image2 = input?.files?.[0] ?? null;
  }

  submit(): void {
    this.setMsg('');

    const token = this.adminToken();
    if (!token) {
      this.router.navigate(['/admin/login']);
      return;
    }

    if (!this.image1 || !this.image2) {
      this.setMsg('Mindkét képet kötelező kiválasztani.');
      return;
    }

    if (this.form.invalid) {
      this.form.markAllAsTouched();
      this.setMsg('Kérlek tölts ki minden kötelező mezőt.');
      return;
    }

    this.loading = true;

    const fd = new FormData();
    fd.append('image1', this.image1);
    fd.append('image2', this.image2);

    const values = this.form.value as Record<string, any>;
    Object.keys(values).forEach((key) => {
      fd.append(key, String(values[key] ?? ''));
    });

    this.http.post<any>(`${this.apiUrl}/admin/cars`, fd, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    }).subscribe({
      next: (res) => {
        this.loading = false;
        this.setMsg(res?.message || 'Autó sikeresen feltöltve ✅', true);

        this.form.reset({
          marka: '',
          modell: '',
          evjarat: 2020,
          kilometerora: 0,
          ajtok_szama: 4,
          uzemanyag: 'Benzin',
          teljesitmeny: 0,
          ar: 0,
          kivitel: 'Kupé',
          allapot: 'Új',
          szemelyek_szama: 4,
          szin: 'Fekete',
          sebessegvalto: 'Automata',
          hengerurtartalom: 0,
          raktaron: 1,
          kiemelt: 0,
        });

        this.image1 = null;
        this.image2 = null;
      },
      error: (err: HttpErrorResponse) => {
        this.loading = false;

        if (err.status === 401 || err.status === 403) {
          localStorage.removeItem('admin_token');
          this.router.navigate(['/admin/login']);
          return;
        }

        this.setMsg(this.firstErrorMessage(err.error));
      },
    });
  }
}