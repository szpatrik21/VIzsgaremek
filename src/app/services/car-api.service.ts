import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

export type Auto = {
  id: number;
  marka?: string;
  modell?: string;
  teljesitmeny?: number;
  uzemanyag?: string;
  ar?: number;
  kep?: string;
  kep2?: string;
  url?: string;
  kiemelt?: number;
  raktaron?: number;
};

@Injectable({
  providedIn: 'root'
})
export class CarApiService {
  private apiBase = '/api';

  private jsonHeaders = new HttpHeaders({
    Accept: 'application/json'
  });

  constructor(private http: HttpClient) {}

  getFeaturedCars(): Observable<Auto[]> {
    return this.http.get<Auto[]>(`${this.apiBase}/featured-cars`, {
      headers: this.jsonHeaders
    });
  }

  getAllCars(): Observable<Auto[]> {
    return this.http.get<Auto[]>(`${this.apiBase}/api/admin/autok`, {
      headers: this.jsonHeaders
    });
  }

  createCar(formData: FormData): Observable<any> {
    return this.http.post(`${this.apiBase}/api/admin/autok`, formData, {
      headers: new HttpHeaders({
        Accept: 'application/json'
      })
    });
  }

  updateCar(id: number, data: { raktaron: number; kiemelt: number }): Observable<any> {
    return this.http.put(`${this.apiBase}/api/admin/autok${id}`, data, {
      headers: this.jsonHeaders
    });
  }

  deleteCar(id: number): Observable<any> {
    return this.http.delete(`${this.apiBase}/api/admin/autok${id}`, {
      headers: this.jsonHeaders
    });
  }

  getImageUrl(path?: string): string {
  const p = (path || '').trim();

  if (!p) {
    return '/assets/images/no-image.png';
  }

  if (p.startsWith('http://') || p.startsWith('https://') || p.startsWith('/')) {
    return p.replace(/\\/g, '/');
  }

  return '/' + p.replace(/\\/g, '/').replace(/^\/+/, '');
}
}