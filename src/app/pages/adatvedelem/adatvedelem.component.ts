import { Component } from '@angular/core';
import { NavbarComponent } from '../../navbar/navbar.component';
import { FooterComponent } from '../../footer/footer.component';

@Component({
  selector: 'app-adatvedelem',
  standalone: true,
  imports: [NavbarComponent, FooterComponent],
  templateUrl: './adatvedelem.component.html',
  styleUrl: './adatvedelem.component.css'
})
export class AdatvedelemComponent {

}