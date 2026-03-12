import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';
import { NavbarComponent } from '../../navbar/navbar.component';
import { FooterComponent } from '../../footer/footer.component';

@Component({
  selector: 'app-kapcsolat',
  standalone: true,
  imports: [CommonModule, NavbarComponent, FooterComponent],
  templateUrl: './kapcsolat.component.html',
  styleUrls: ['./kapcsolat.component.css'],
})
export class KapcsolatComponent {
  email = 'luxcar0000@gmail.com';
  phone = '+36 20 281 25 95';
  address = 'Pécs, efwfwe utca 1.';

  hours = [
    'H–P: 09:00–17:00',
    'Szo: 10:00–14:00',
    'V: Zárva',
  ];

  mapSrc: SafeResourceUrl;

  constructor(private sanitizer: DomSanitizer) {
    this.mapSrc = this.sanitizer.bypassSecurityTrustResourceUrl(
      'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2769.7480434325475!2d18.214716075792985!3d46.03617569509494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4742b3b64547f9ff%3A0x81835de2edb802f1!2sBaranya%20V%C3%A1rmegyei%20SZC%20Simonyi%20K%C3%A1roly%20Technikum%20%C3%A9s%20Szakk%C3%A9pz%C5%91%20Iskola!5e0!3m2!1shu!2shu!4v1772046983852!5m2!1shu!2shu'
    );
  }
}