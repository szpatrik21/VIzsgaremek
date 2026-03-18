import { Component, OnDestroy, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule, NavigationEnd } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { Subscription, filter } from 'rxjs';

type UserDto = {
  first_name?: string;
  last_name?: string;
  username?: string;
};

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css'],
})
export class NavbarComponent implements OnInit, OnDestroy {
  menuOpen = false;

  isLoggedIn = false;
  fullName = '';

  private sub?: Subscription;

  constructor(private http: HttpClient, private router: Router) {}

  ngOnInit(): void {
    this.refreshAuthState();

    this.sub = this.router.events
      .pipe(filter((e) => e instanceof NavigationEnd))
      .subscribe(() => this.refreshAuthState());
  }

  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }

  private getToken(): string {
    return localStorage.getItem('jwt_token') || localStorage.getItem('token') || '';
  }

  private refreshAuthState(): void {
    const token = this.getToken();
    this.isLoggedIn = !!token;

    if (!token) {
      this.fullName = '';
      localStorage.removeItem('user_full_name');
      return;
    }

    const cachedName = localStorage.getItem('user_full_name');
    if (cachedName) {
      this.fullName = cachedName;
    }

    this.http.get<UserDto>('/api/user', {
      headers: {
        Authorization: 'Bearer ' + token,
        Accept: 'application/json'
      }
    }).subscribe({
      next: (u) => {
        const name = `${u.first_name ?? ''} ${u.last_name ?? ''}`.trim();
        this.fullName = name || u.username || 'Profil';
        this.isLoggedIn = true;

        localStorage.setItem('user_full_name', this.fullName);
      },
      error: () => {
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('token');
        localStorage.removeItem('user_full_name');
        this.isLoggedIn = false;
        this.fullName = '';
      }
    });
  }

  toggleMenu(): void {
    this.menuOpen = !this.menuOpen;
  }

  closeMenu(): void {
    this.menuOpen = false;
  }

  logout(e?: Event): void {
    e?.preventDefault();
    localStorage.removeItem('jwt_token');
    localStorage.removeItem('token');
    localStorage.removeItem('user_full_name');
    this.isLoggedIn = false;
    this.fullName = '';
    this.closeMenu();
    this.router.navigate(['/login']);
  }
}
