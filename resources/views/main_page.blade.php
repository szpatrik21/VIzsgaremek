<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>LuxCar - Kezdőoldal</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="icon" href="{{ asset('ChatGPT Image 2026. márc. 1. 13_20_49 (1).ico') }}">

  @vite([
    'resources/css/main_page.css',
    'resources/css/navbar.css',
  ])

</head>

<body>
  <x-navbar />

  <!-- Képek -->
  <div class="slider">

    <img src="{{ asset('images/14.jpg') }}" alt="car">
    <img src="{{ asset('images/16.jpg') }}" alt="car">
    <img src="{{ asset('images/17 (2).jpg') }}" alt="car">
    <img src="{{ asset('images/19.jpg') }}" alt="car">
    <img src="{{ asset('images/21.jpg') }}" alt="car">
    <img src="{{ asset('images/22.jpg') }}" alt="car">

    <div class="hero-overlay">
      <h1>Luxusautók egy helyen</h1>
      <p>Válogass prémium modellek közül, nézd meg a részleteket, és kérj ajánlatot gyorsan, egyszerűen.</p>
      <div class="hero-actions">
        <a class="cta" href="{{ route('autok.index') }}">Autók megtekintése</a>
      </div>
    </div>
  </div>

  <!-- Statisztika -->
  <section class="stats" id="stats">
    <div class="stats__inner">
      <div class="stat-card">
        <div class="stat-card__num">
          <span class="countup" data-target="20" data-suffix="+">0</span>
        </div>
        <div class="stat-card__label">Prémium modell</div>
      </div>

      <div class="stat-card">
        <div class="stat-card__num">
          <span class="countup" data-target="8">0</span>
        </div>
        <div class="stat-card__label">Luxus márka</div>
      </div>

      <div class="stat-card">
        <div class="stat-card__num">
          <span class="countup" data-target="120" data-suffix="+">0</span>
        </div>
        <div class="stat-card__label">Ajánlatkérés / hónap</div>
      </div>

      <div class="stat-card">
        <div class="stat-card__num">
          <span class="countup" data-target="100" data-suffix="%">0</span>
        </div>
        <div class="stat-card__label">Minőségellenőrzés</div>
      </div>
    </div>
  </section>


<br><br>
  <!-- Kiemelt autók -->
  <div class="container">
  <h2 id="kiemelt" class="cim1 reveal">Kiemelt autók:</h2>

  <div class="carbox carbox-grid carbox--featured">
    @foreach($autok as $auto)
      <div class="carbox1 reveal">
        @if(!empty($auto->kep))
          <img src="{{ asset($auto->kep) }}"
               class="carsbox"
               alt="{{ $auto->marka }} {{ $auto->modell }}">
        @else
          <img src="{{ asset('images/no-image.png') }}"
               class="carsbox"
               alt="Nincs kép">
        @endif

        <div class="card-content">
          <p class="card-title">{{ $auto->marka }} {{ $auto->modell }}</p>
          <p class="card-spec">{{ $auto->teljesitmeny }} LE • {{ $auto->uzemanyag }}</p>
          <p class="card-price">{{ number_format($auto->ar, 0, ',', ' ') }} Ft</p>

          <a class="yellowbutton" href="{{ route('autok.show', $auto) }}">
            Érdekel
          </a>
        </div>
      </div>
    @endforeach
  </div>
</div>

<style>
  .reveal{
  opacity: 0;
  transform: translateY(40px);
  transition: opacity .8s ease, transform .8s ease;
}

.reveal.active{
  opacity: 1;
  transform: translateY(0);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const reveals = document.querySelectorAll(".reveal");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        entry.target.classList.add("active");
      }
    });
  }, { threshold: 0.15 });

  reveals.forEach(el => observer.observe(el));
});
</script>

  <section class="about">
    <div class="container">
      <div class="about-section">
        <h2 class="section-title">Rólunk</h2>

        <p>
          Üdvözlünk a <span class="highlight">LuxCar</span>-nél, ahol a négy kerék nem csupán közlekedési eszköz,
          hanem életstílus. Webshopunkban a világ legismertebb és legexkluzívabb márkáinak luxusautóit találod –
          <span class="highlight">Ferrari</span>, <span class="highlight">Lamborghini</span>,
          <span class="highlight">Aston Martin</span>, <span class="highlight">Bugatti</span> és még sok más ikonikus név.
        </p>

        <p>
          Célunk, hogy ügyfeleink számára elérhetővé tegyük az autózás legfelsőbb szintjét: a teljesítményt,
          a kifinomultságot és a páratlan dizájnt.
        </p>

        <p>
          Legyen szó vadonatúj sportautóról vagy gondosan válogatott használt prémium modellről,
          kínálatunk minden darabja a minőség és a luxus garanciája.
        </p>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      /* ===== HERO SLIDER ===== */
      const slides = document.querySelectorAll(".slider img");
      if (slides.length) {
        let current = 0;

        const showSlide = (i) => {
          slides.forEach(s => s.classList.remove("active"));
          slides[i].classList.add("active");
        };

        showSlide(0);

        setInterval(() => {
          current = (current + 1) % slides.length;
          showSlide(current);
        }, 5000);
      }

      const counters = document.querySelectorAll(".countup");
      if (!counters.length) return;

      const runOnce = new WeakSet();

      const animateCount = (el) => {
        const target = Number(el.dataset.target || 0);
        const suffix = el.dataset.suffix || "";
        const duration = 900;

        const startTime = performance.now();

        const step = (now) => {
          const progress = Math.min((now - startTime) / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          const value = Math.round(target * eased);

          el.textContent = value.toLocaleString("hu-HU") + suffix;

          if (progress < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          const el = entry.target;
          if (runOnce.has(el)) return;

          runOnce.add(el);
          animateCount(el);
        });
      }, { threshold: 0.35 });

      counters.forEach(c => observer.observe(c));
    });
  </script>

  <x-footer />
</body>
</html>