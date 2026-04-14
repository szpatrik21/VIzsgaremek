import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from '../../navbar/navbar.component';
import { FooterComponent } from '../../footer/footer.component';

type FaqItem = {
  q: string;
  a: string;
  open?: boolean;
};

@Component({
  selector: 'app-gyik',
  standalone: true,
  imports: [CommonModule, NavbarComponent, FooterComponent],
  templateUrl: './gyik.component.html',
  styleUrls: ['./gyik.component.css'],
})
export class GyikComponent {
  faqs: FaqItem[] = [
    {
      q: 'Hogyan tudok autóra árajánlatot kérni?',
      a: 'Nyisd meg az autó adatlapját, majd kattints a „Kérj árajánlatot” gombra. Telefonon és emailben is elérsz minket.',
    },
    {
      q: 'Hogyan működik a szűrés az autók oldalán?',
      a: 'Válaszd ki a márkát/állapotot/kivitelt/színt, majd nyomj a „Szűrés” gombra. A „Törlés” visszaállít mindent.',
    },
    {
      q: 'Van lehetőség próbaútra?',
      a: 'Igen. Egyeztess időpontot telefonon vagy emailben, és segítünk.',
    },
    {
      q: 'Milyen fizetési lehetőségek vannak?',
      a: 'Átutalás, készpénz, illetve egyedi finanszírozási megoldások. Részletekért vedd fel velünk a kapcsolatot.',
    },
  ];

  toggle(i: number): void {
    this.faqs[i].open = !this.faqs[i].open;
  }
}