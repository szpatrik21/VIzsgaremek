import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-admin-navbar',
  standalone: true,
  templateUrl: './admin-navbar.component.html',
  styleUrls: ['./admin-navbar.component.css']
})
export class AdminNavbarComponent {

  constructor(private router: Router) {}

  logout() {
    localStorage.removeItem('admin_token');
    this.router.navigate(['/admin/login']);
  }

}