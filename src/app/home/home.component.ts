import { AfterViewInit, Component, OnDestroy, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';
import { Auto, CarApiService } from '../services/car-api.service';

type Advantage = {
  icon: string;
  title: string;
  text: string;
};

type ProcessStep = {
  number: string;
  title: string;
  text: string;
};

type AboutFact = {
  value: string;
  label: string;
};

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule, RouterLink, NavbarComponent, FooterComponent],
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit, AfterViewInit, OnDestroy {
  loading = true;
  featured: Auto[] = [];
  errorMsg = '';

  advantages: Advantage[] = [
    {
      icon: '01',
      title: 'Ellenőrzött prémium kínálat',
      text: 'Gondosan válogatott modellek, amelyek megjelenésben és minőségben is illenek a prémium kategóriához.'
    },
    {
      icon: '02',
      title: 'Gyors kapcsolatfelvétel',
      text: 'Az érdeklődéstől az ajánlatkérésig átlátható és gyors folyamat vár, felesleges körök nélkül.'
    },
    {
      icon: '03',
      title: 'Exkluzív megjelenés',
      text: 'A LuxCar célja nem csupán az autók bemutatása, hanem a luxus hangulat vizuális átadása is.'
    },
    {
      icon: '04',
      title: 'Letisztult élmény',
      text: 'Átgondolt felépítés, jól olvasható tartalom és erős vizuális fókusz minden fontos ponton.'
    }
  ];

  steps: ProcessStep[] = [
    {
      number: '01',
      title: 'Válassz modellt',
      text: 'Nézd át a kínálatot, hasonlítsd össze a prémium modelleket, és találd meg a hozzád illőt.'
    },
    {
      number: '02',
      title: 'Kérj ajánlatot',
      text: 'Pár kattintással jelezheted érdeklődésedet, és felveheted velünk a kapcsolatot.'
    },
    {
      number: '03',
      title: 'Lépj tovább',
      text: 'Segítünk a következő lépésben, hogy a kiválasztott autóhoz gyorsan és gördülékenyen közelebb kerülj.'
    }
  ];

  aboutFacts: AboutFact[] = [
    {
      value: '24h',
      label: 'Gyors visszajelzési cél prémium érdeklődések esetén'
    },
    {
      value: '8+',
      label: 'Luxus márka a kínálatban és a fókuszban'
    },
    {
      value: '100%',
      label: 'Prémium szemlélet a megjelenésben és a válogatásban'
    }
  ];

  private revealObserver?: IntersectionObserver;
  private countObserver?: IntersectionObserver;
  private sliderTimer?: number;

  constructor(private carApi: CarApiService) {}

  ngOnInit(): void {
    this.loadFeaturedCars();
  }

  ngAfterViewInit(): void {
    this.initRevealObserver();
    this.initSlider();
    this.initCountUp();
  }

  ngOnDestroy(): void {
    this.revealObserver?.disconnect();
    this.countObserver?.disconnect();

    if (this.sliderTimer) {
      window.clearInterval(this.sliderTimer);
    }
  }

  private initRevealObserver(): void {
    const reveals = Array.from(document.querySelectorAll<HTMLElement>('.reveal'));
    if (!reveals.length) return;

    this.revealObserver?.disconnect();

    this.revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            (entry.target as HTMLElement).classList.add('active');
          }
        });
      },
      { threshold: 0.15 }
    );

    reveals.forEach((el) => this.revealObserver?.observe(el));
  }

  private initSlider(): void {
    const slides = Array.from(document.querySelectorAll<HTMLImageElement>('.slider img'));
    if (!slides.length) return;

    let current = 0;

    const showSlide = (index: number) => {
      slides.forEach((slide) => slide.classList.remove('active'));
      slides[index]?.classList.add('active');
    };

    showSlide(0);

    this.sliderTimer = window.setInterval(() => {
      current = (current + 1) % slides.length;
      showSlide(current);
    }, 5000);
  }

  private initCountUp(): void {
    const counters = Array.from(document.querySelectorAll<HTMLElement>('.countup'));
    if (!counters.length) return;

    const runOnce = new WeakSet<Element>();

    const animateCount = (el: HTMLElement) => {
      const target = Number(el.dataset['target'] || 0);
      const suffix = el.dataset['suffix'] || '';
      const duration = 900;
      const startTime = performance.now();

      const step = (now: number) => {
        const progress = Math.min((now - startTime) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = Math.round(target * eased);

        el.textContent = value.toLocaleString('hu-HU') + suffix;

        if (progress < 1) {
          requestAnimationFrame(step);
        }
      };

      requestAnimationFrame(step);
    };

    this.countObserver?.disconnect();

    this.countObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;

          const el = entry.target as HTMLElement;
          if (runOnce.has(el)) return;

          runOnce.add(el);
          animateCount(el);
        });
      },
      { threshold: 0.35 }
    );

    counters.forEach((counter) => this.countObserver?.observe(counter));
  }

  private loadFeaturedCars(): void {
    this.loading = true;
    this.errorMsg = '';

    this.carApi.getFeaturedCars().subscribe({
      next: (autok: Auto[]) => {
        this.featured = Array.isArray(autok) ? autok : [];
        this.loading = false;

        setTimeout(() => {
          this.initRevealObserver();
        }, 0);
      },
      error: (err) => {
        console.error('Kiemelt autók betöltési hiba:', err);
        this.featured = [];
        this.loading = false;
        this.errorMsg = 'Nem sikerült betölteni a kiemelt autókat.';
      }
    });
  }

  formatFt(n?: number): string {
    return Number(n || 0).toLocaleString('hu-HU') + ' Ft';
  }

  autoUrl(a: Auto): string {
    return a.url || `/autok/${a.id}`;
  }

  autoKep(a: Auto): string {
    return this.carApi.getImageUrl(a.kep);
  }

  onImgError(event: Event): void {
    const img = event.target as HTMLImageElement;
    img.onerror = null;
    img.src = 'assets/images/no-image.png';
  }
}