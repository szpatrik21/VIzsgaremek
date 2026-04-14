import { Component } from '@angular/core';
import { NavbarComponent } from '../../navbar/navbar.component';
import { FooterComponent } from '../../footer/footer.component';

@Component({
  selector: 'app-aszf',
  standalone: true,
  imports: [NavbarComponent, FooterComponent],
  templateUrl: './aszf.component.html',
  styleUrl: './aszf.component.css'
})
export class AszfComponent {

}