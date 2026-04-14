import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';

@Component({
  selector: 'app-ajanlatkeres',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule, NavbarComponent, FooterComponent],
  templateUrl: './ajanlatkeres.component.html',
  styleUrls: ['./ajanlatkeres.component.css']
})
export class AjanlatkeresComponent implements OnInit {
  urlap!: FormGroup;

  auto: any = null;
  sikerUzenet = '';
  hibaUzenet = '';
  kuldesFolyamatban = false;

  constructor(
    private formBuilder: FormBuilder,
    private aktivUtvonal: ActivatedRoute,
    private http: HttpClient
  ) {}

  ngOnInit(): void {
    this.urlap = this.formBuilder.group({
      nev: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      telefon: [''],
      uzenet: ['']
    });

    const autoAzonosito = this.aktivUtvonal.snapshot.paramMap.get('id');

    if (autoAzonosito) {
      this.autoBetoltese(autoAzonosito);
    }

    this.felhasznaloAdatokBetoltese();
  }

  autoBetoltese(id: string): void {
    this.http.get<any>(`/api/autok/${id}`).subscribe({
      next: (valasz) => {
        this.auto = valasz;
      },
      error: () => {
        this.hibaUzenet = 'Nem sikerült betölteni az autó adatait.';
      }
    });
  }

  felhasznaloAdatokBetoltese(): void {
    const token = localStorage.getItem('jwt_token');
    if (!token) return;

    const fejlecek = new HttpHeaders({
      Authorization: `Bearer ${token}`,
      Accept: 'application/json'
    });

    this.http.get<any>('/api/user', { headers: fejlecek }).subscribe({
      next: (felhasznalo) => {
        const teljesNev =
          `${felhasznalo.first_name || ''} ${felhasznalo.last_name || ''}`.trim();

        this.urlap.patchValue({
          nev: teljesNev || felhasznalo.username || '',
          email: felhasznalo.email || '',
          telefon: felhasznalo.phone || ''
        });
      },
      error: (hiba) => {
        console.error('Nem sikerült lekérni a felhasználó adatait:', hiba);
      }
    });
  }

  ajanlatKuldese(): void {
    this.sikerUzenet = '';
    this.hibaUzenet = '';

    if (this.urlap.invalid || !this.auto?.id) {
      this.urlap.markAllAsTouched();
      return;
    }

    this.kuldesFolyamatban = true;

    const kuldendoAdat = {
      name: this.urlap.value.nev,
      email: this.urlap.value.email,
      phone: this.urlap.value.telefon,
      message: this.urlap.value.uzenet
    };

    this.http.post(`/api/offers/${this.auto.id}`, kuldendoAdat).subscribe({
      next: (valasz: any) => {
        this.sikerUzenet = valasz?.message || 'Az ajánlatkérés sikeresen elküldve.';
        this.urlap.patchValue({
          uzenet: ''
        });
        this.kuldesFolyamatban = false;
      },
      error: (hiba) => {
        this.hibaUzenet =
          hiba?.error?.message ||
          'Hiba történt az ajánlatkérés elküldésekor.';
        this.kuldesFolyamatban = false;
      }
    });
  }
}