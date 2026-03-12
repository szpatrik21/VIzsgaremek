import { Component, OnDestroy, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Subscription } from 'rxjs';
import { NavbarComponent } from '../../navbar/navbar.component';
import { FooterComponent } from '../../footer/footer.component';

type AutoDetails = {
  id: number;
  marka?: string;
  modell?: string;
  evjarat?: number;
  uzemanyag?: string;
  szin?: string;
  ar?: number;
  raktaron?: number;
  kep?: string;
  kep2?: string;
  kilometerora?: number;
  ajtok_szama?: number;
  teljesitmeny?: number;
  kivitel?: string;
  allapot?: string;
  szemelyek_szama?: number;
  sebessegvalto?: string;
  hengerurtartalom?: number;
  url?: string;
};

type CommentItem = {
  id?: number;
  content?: string;
  user?: {
    first_name?: string;
    last_name?: string;
    username?: string;
  };
};

@Component({
  selector: 'app-autok-reszletek',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule, NavbarComponent, FooterComponent],
  templateUrl: './autok-reszletek.component.html',
  styleUrls: ['./autok-reszletek.component.css'],
})
export class AutokReszletekComponent implements OnInit, OnDestroy {
  loadingCar = false;
  loadingComments = false;

  errorCar = '';
  errorComments = '';

  autoId!: number;
  auto: AutoDetails | null = null;

  comments: CommentItem[] = [];
  msgText = '';
  msgOk = false;

  commentForm!: FormGroup;

  private sub?: Subscription;

  constructor(
    private http: HttpClient,
    private route: ActivatedRoute,
    private fb: FormBuilder
  ) {
    this.commentForm = this.fb.group({
      content: ['', [Validators.required, Validators.minLength(2)]],
    });
  }

  ngOnInit(): void {
    this.sub = this.route.paramMap.subscribe((pm) => {
      const id = Number(pm.get('id'));

      if (!Number.isFinite(id) || id <= 0) {
        this.errorCar = 'Hibás autó azonosító az URL-ben.';
        this.auto = null;
        return;
      }

      this.autoId = id;
      this.loadCar();
      this.loadComments();
    });
  }

  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }

  formatFt(n?: number): string {
    return Number(n ?? 0).toLocaleString('hu-HU') + ' Ft';
  }

  formatKm(n?: number): string {
    return Number(n ?? 0).toLocaleString('hu-HU') + ' km';
  }

  titleText(): string {
    const t = `${this.auto?.marka ?? ''} ${this.auto?.modell ?? ''}`.trim();
    return t || 'Autó részletek';
  }

  subtitleText(): string {
    return `${this.auto?.evjarat ?? '—'} · ${this.auto?.uzemanyag ?? '—'} · ${this.auto?.szin ?? '—'}`;
  }

  heroImg(): string {
    return this.auto?.kep?.trim() ? this.auto!.kep! : '/assets/images/no-image.png';
  }

  miniImg(): string {
    return this.auto?.kep2?.trim() ? this.auto!.kep2! : '';
  }

  stockText(): string {
    const n = Number(this.auto?.raktaron ?? 0);
    return n > 0 ? `${n} db` : 'Nincs raktáron';
  }

  private getToken(): string {
    return localStorage.getItem('jwt_token') || localStorage.getItem('token') || '';
  }

  private setMsg(text: string, ok = false): void {
    this.msgText = text || '';
    this.msgOk = ok;
  }

  loadCar(): void {
    this.loadingCar = true;
    this.errorCar = '';

    this.http.get<AutoDetails>(`/api/autok/${this.autoId}`, {
      headers: { Accept: 'application/json' },
    }).subscribe({
      next: (a) => {
        this.auto = a;
        document.title = this.titleText();
        this.loadingCar = false;
      },
      error: () => {
        this.auto = null;
        this.errorCar = 'Nem sikerült betölteni az autót.';
        this.loadingCar = false;
      },
    });
  }

  loadComments(): void {
    this.loadingComments = true;
    this.errorComments = '';

    this.http.get<any>(`/api/autok/${this.autoId}/comments`, {
      headers: { Accept: 'application/json' },
    }).subscribe({
      next: (data) => {
        const arr = Array.isArray(data) ? data : (Array.isArray(data?.data) ? data.data : []);
        this.comments = arr;
        this.loadingComments = false;
      },
      error: () => {
        this.comments = [];
        this.errorComments = 'Nem sikerült betölteni a véleményeket.';
        this.loadingComments = false;
      },
    });
  }

  sendComment(): void {
    this.setMsg('');

    const token = this.getToken();

    if (!token) {
      this.setMsg('A folytatáshoz be kell jelentkezned. ');
      return;
    }

    if (this.commentForm.invalid) {
      this.setMsg('Írj legalább 2 karaktert.');
      return;
    }

    const content = String(this.commentForm.value?.content ?? '').trim();

    this.commentForm.disable();

    this.http.post<any>(
      `/api/autok/${this.autoId}/comments`,
      { content },
      {
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          Authorization: 'Bearer ' + token,
        },
      }
    ).subscribe({
      next: (res) => {
        this.setMsg(
          res?.message || 'A kommentet elmentettük. Az admin jóváhagyása után jelenik meg. ',
          true
        );
        this.commentForm.reset({ content: '' });
        this.commentForm.enable();
      },
      error: (err) => {
        if (err?.status === 401 || err?.status === 403) {
          localStorage.removeItem('jwt_token');
          localStorage.removeItem('token');
          this.setMsg('Jelentkezz be újra. ');
        } else if (err?.status === 422) {
          this.setMsg(err?.error?.message || 'A komment mentése sikertelen, ellenőrizd a mezőt.');
        } else {
          this.setMsg(err?.error?.message || err?.error?.error || 'Hiba a küldésnél.');
        }

        this.commentForm.enable();
      },
    });
  }

  onHeroImgError(ev: Event): void {
    const t = ev.target;
    if (!(t instanceof HTMLImageElement)) return;
    t.onerror = null;
    t.src = '/assets/images/no-image.png';
  }

  onMiniImgError(): void {
    if (this.auto) this.auto.kep2 = '';
  }

  displayName(c: CommentItem): string {
    const u = c.user || {};
    if (u.first_name && u.last_name) return `${u.first_name} ${u.last_name}`;
    return u.username || 'Felhasználó';
  }
}