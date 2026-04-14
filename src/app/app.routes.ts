import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ForgotPasswordComponent } from './pages/forgot-password/forgot-password.component';
import { ResetPasswordComponent } from './pages/reset-password/reset-password.component';

export const routes: Routes = [
  { path: '', component: HomeComponent, pathMatch: 'full' },

  {
    path: 'profile',
    loadComponent: () =>
      import('./pages/profile/profile.component').then(m => m.ProfileComponent),
  },

  {
    path: 'admin/cars',
    loadComponent: () =>
      import('./pages/admin-cars/admin-cars.component').then(m => m.AdminCarsComponent),
  },

  {
    path: 'admin/users',
    loadComponent: () =>
      import('./pages/admin-users/admin-users.component').then(m => m.AdminUsersComponent),
  },

  {
    path: 'login',
    loadComponent: () =>
      import('./pages/login/login.component').then(m => m.LoginComponent),
  },

  {
    path: 'forgot-password',
    component: ForgotPasswordComponent,
  },

  {
    path: 'reset-password',
    component: ResetPasswordComponent,
  },

  {
    path: 'autok/:id',
    loadComponent: () =>
      import('./pages/autok-reszletek/autok-reszletek.component')
        .then(m => m.AutokReszletekComponent),
  },

  {
    path: 'register',
    loadComponent: () =>
      import('./pages/register/register.component').then(m => m.RegisterComponent),
  },

  {
    path: 'kapcsolat',
    loadComponent: () =>
      import('./pages/kapcsolat/kapcsolat.component').then(m => m.KapcsolatComponent),
  },

  {
    path: 'autok',
    loadComponent: () =>
      import('./pages/autok/autok.component').then(m => m.AutokComponent),
  },

  {
    path: 'gyik',
    loadComponent: () =>
      import('./pages/gyik/gyik.component').then(m => m.GyikComponent),
  },

  {
    path: 'admin/login',
    loadComponent: () =>
      import('./pages/admin-login/admin-login.component').then(m => m.AdminLoginComponent),
  },

  {
    path: 'ajanlatkeres/:id',
    loadComponent: () =>
      import('./ajanlatkeres/ajanlatkeres.component').then(m => m.AjanlatkeresComponent),
  },

  {
    path: 'admin',
    loadComponent: () =>
      import('./pages/admin-home/admin-home.component').then(m => m.AdminHomeComponent),
  },

  {
    path: 'admin/comments',
    loadComponent: () =>
      import('./pages/admin-comments/admin-comments.component').then(m => m.AdminCommentsComponent),
  },

  {
    path: 'admin/carcreate',
    loadComponent: () =>
      import('./pages/admin-carcreate/admin-carcreate.component')
        .then(m => m.AdminCarcreateComponent),
  },

  {
    path: 'adatvedelem',
    loadComponent: () =>
      import('./pages/adatvedelem/adatvedelem.component').then(m => m.AdatvedelemComponent),
  },
  {
    path: 'aszf',
    loadComponent: () =>
      import('./pages/aszf/aszf.component').then(m => m.AszfComponent),
  },
  {
    path: 'adatkezelesi-nyilatkozat',
    redirectTo: 'adatvedelem',
  },
  {
    path: 'felhasznalasi-feltetelek',
    redirectTo: 'aszf',
  },

  { path: '**', redirectTo: '' },
];