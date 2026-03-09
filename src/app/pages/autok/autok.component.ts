import { Component, OnDestroy, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { Subscription } from 'rxjs';
import { NavbarComponent } from '../../navbar/navbar.component';
import { FooterComponent } from '../../footer/footer.component';


type Auto = {
  id: number;
  marka?: string;
  modell?: string;
  teljesitmeny?: number;
  uzemanyag?: string;
  ar?: number;
  kep?: string;
  url?: string;
};

@Component({
  selector: 'app-autok',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule, NavbarComponent, FooterComponent],
  templateUrl: './autok.component.html',
  styleUrls: ['./autok.component.css'],
})
export class AutokComponent implements OnInit, OnDestroy {
  loading = false;
  errorMsg = '';

  autok: Auto[] = [];

  markak: string[] = [];
  allapotok: string[] = [];
  kivitelek: string[] = [];
  szinek: string[] = [];

  filtersForm!: FormGroup;

  private sub?: Subscription;

  constructor(
    private fb: FormBuilder,
    private http: HttpClient,
    private route: ActivatedRoute,
    private router: Router
  ) {
    this.filtersForm = this.fb.group({
      marka: [''],
      allapot: [''],
      kivitel: [''],
      szin: [''],
    });
  }

  ngOnInit(): void {
    this.sub = this.route.queryParams.subscribe((q) => {
      this.filtersForm.patchValue(
        {
          marka: q['marka'] ?? '',
          allapot: q['allapot'] ?? '',
          kivitel: q['kivitel'] ?? '',
          szin: q['szin'] ?? '',
        },
        { emitEvent: false }
      );

      this.fetchCarsAndFilters();
    });
  }

  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }

  trackByAutoId(_index: number, item: Auto): number {
    return item.id;
  }

  applyFilters(): void {
    const v = this.filtersForm.value as any;

    const queryParams: any = {};
    if (v.marka) queryParams.marka = v.marka;
    if (v.allapot) queryParams.allapot = v.allapot;
    if (v.kivitel) queryParams.kivitel = v.kivitel;
    if (v.szin) queryParams.szin = v.szin;

    this.router.navigate(['/autok'], { queryParams });
  }

  resetFilters(e?: Event): void {
    e?.preventDefault();
    this.filtersForm.reset({ marka: '', allapot: '', kivitel: '', szin: '' });
    this.router.navigate(['/autok']);
  }

  fetchCarsAndFilters(): void {
    this.loading = true;
    this.errorMsg = '';

    const q = this.route.snapshot.queryParams;
    const params: any = {};
    if (q['marka']) params.marka = q['marka'];
    if (q['allapot']) params.allapot = q['allapot'];
    if (q['kivitel']) params.kivitel = q['kivitel'];
    if (q['szin']) params.szin = q['szin'];

    this.http
      .get<any>('/api/autok', { params, headers: { Accept: 'application/json' } })
      .subscribe({
        next: (json) => {
          const cars = Array.isArray(json)
            ? json
            : Array.isArray(json?.data)
              ? json.data
              : [];

          this.autok = cars;

          const filters = json?.filters || {};
          this.markak = filters.markak || json?.markak || [];
          this.allapotok = filters.allapotok || json?.allapotok || [];
          this.kivitelek = filters.kivitelek || json?.kivitelek || [];
          this.szinek = filters.szinek || json?.szinek || [];

          this.loading = false;
        },
        error: () => {
          this.loading = false;
          this.autok = [];
          this.errorMsg = 'Nem sikerült betölteni az autókat.';
        },
      });
  }

  formatFt(n?: number): string {
    return Number(n ?? 0).toLocaleString('hu-HU') + ' Ft';
  }

  autoUrl(a: Auto): string {
    return a.url || `/autok/${a.id}`;
  }

  autoKep(a: Auto): string {
    return a.kep?.trim() ? a.kep : '/assets/images/no-image.png';
  }

  // strict-safe: target típusa ellenőrzött
  onImgError(ev: Event): void {
    const target = ev.target;
    if (!(target instanceof HTMLImageElement)) return;

    target.onerror = null;
    target.src = '/assets/images/no-image.png';
  }
}