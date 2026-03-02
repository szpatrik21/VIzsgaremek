<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>LuxCar - Kezdőoldal</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  
  @vite([
    'resources/css/main_page.css',
    'resources/css/navbar.css',
  ])

  <style>
    :root{
      --gold:#d4af37;
      --gold-light:#ffd230;
      --text: rgba(255,255,255,.82);
      --muted: rgba(255,255,255,.65);
      --panel: rgba(15,15,15,.75);
      --border: rgba(255,255,255,.10);
    }

    /* =========================================
       STATS – HERO-RAÜLŐ BLOKK (EZ A LÉNYEG)
    ========================================== */
    .stats{
      background: transparent;
      border: 0;
      padding: 0;
      margin-top: -52px;      /* ✅ ráül a hero aljára */
      position: relative;
      z-index: 10;
    }

    .stats__inner{
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 24px;

      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
    }

    .stat-card{
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px 16px;
      box-shadow: 0 18px 60px rgba(0,0,0,.55);
      backdrop-filter: blur(10px);
      transition: transform .2s ease, border-color .2s ease, background .2s ease;
    }

    .stat-card:hover{
      transform: translateY(-3px);
      border-color: rgba(212,175,55,.22);
      background: rgba(212,175,55,.06);
    }

    .stat-card__num{
      font-family: "Playfair Display", serif;
      font-weight: 800;
      font-size: 34px;
      color: var(--gold);
      margin-bottom: 6px;
      letter-spacing: .3px;
      line-height: 1;
    }

    .stat-card__label{
      font-family: "Space Grotesk", system-ui, sans-serif;
      font-size: 13px;
      color: var(--muted);
      letter-spacing: .35px;
    }

    @media (max-width:980px){
      .stats{ margin-top: -40px; }
      .stats__inner{ grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width:520px){
      .stats{ margin-top: -28px; }
      .stats__inner{ grid-template-columns: 1fr; }
      .stat-card__num{ font-size: 32px; }
    }

    /* =========================================
       MÁRKÁK (MOBIL SCROLL)
    ========================================== */
    .markak{
      margin-top: 26px; /* ✅ hogy a stats után legyen levegő */
      display:flex;
      justify-content:center;
      gap: 44px;
      padding: 22px 0 10px;
      opacity: .95;
    }
    .wallpaper img{
      height: 26px;
      width: auto;
      opacity: .75;
      transition: .2s ease;
      filter: grayscale(100%);
    }
    .wallpaper img:hover{
      opacity: 1;
      filter: grayscale(0%);
    }

    @media (max-width:700px){
      .markak{
        justify-content:flex-start;
        gap:30px;
        overflow-x:auto;
        overflow-y:hidden;
        padding:20px 16px 8px;
        scroll-behavior:smooth;
        -webkit-overflow-scrolling:touch;
      }
      .markak::-webkit-scrollbar{ display:none; }
      .wallpaper{ flex:0 0 auto; }
      .wallpaper img{
        height: 22px;
        opacity:.65;
        filter: grayscale(100%);
      }
      .wallpaper img:active{ opacity:1; }
    }

    /* =========================================
       KIEMELT AUTÓK – RÁCS + KÁRTYA
    ========================================== */
    .carbox-grid{
      display:grid;
      grid-template-columns:repeat(4, 1fr);
      gap:24px;
      margin:32px 0 72px;
    }

    .carbox1{
      background:#191919;
      border-radius:18px;
      overflow:hidden;
      border:1px solid rgba(255,255,255,.06);
      box-shadow:0 20px 50px rgba(0,0,0,.55);
      transition:.25s ease;
    }
    .carbox1:hover{
      transform:translateY(-5px);
      border-color:rgba(212,175,55,.25);
      box-shadow:0 30px 70px rgba(0,0,0,.7);
    }

    .carsbox{
      width:100%;
      height:190px;
      object-fit:cover;
      display:block;
      transition: transform .25s ease;
    }
    .carbox1:hover .carsbox{
      transform: scale(1.03); /* ✅ kicsi prémium zoom */
    }

    .card-content{ padding:18px; }

    .card-title{
      font-family:"Playfair Display", serif;
      font-size:18px;
      font-weight:600;
      margin:0 0 6px;
      color:#fff;
    }
    .card-spec{
      font-size:14px;
      color:#bbb;
      margin:0 0 10px;
    }
    .card-price{
      font-size:17px;
      font-weight:700;
      margin:0 0 14px;
      color:#fff;
    }

    .yellowbutton{
      display:flex;
      align-items:center;
      justify-content:center;
      width:100%;
      padding:12px 0;
      border-radius:14px;
      background:#C9A16B;
      color:#000;
      text-decoration:none;
      font-weight:800;
      transition:.2s ease;
    }
    .yellowbutton:hover{ background:#d8b27c; }

    @media (max-width:1100px){
      .carbox-grid{ grid-template-columns:repeat(3,1fr); }
    }
    @media (max-width:850px){
      .carbox-grid{ grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:520px){
      .carbox-grid{
        grid-template-columns:1fr;
        padding:0 16px;
      }
      .carsbox{ height:170px; }
    }

    /* ===== KIEMELT AUTÓK – MOBIL HÚZHATÓ ===== */
    @media (max-width:700px){
      .cim1{
        margin-left:16px;
        font-size:26px;
        margin-bottom:18px;
      }

      .carbox--featured{
        display:flex;
        justify-content:flex-start;
        flex-wrap:nowrap;
        overflow-x:auto;
        overflow-y:hidden;
        gap:14px;

        padding:0 16px 12px;
        margin:0 0 40px;

        scroll-snap-type:x mandatory;
        -webkit-overflow-scrolling:touch;
      }
      .carbox--featured::-webkit-scrollbar{ display:none; }

      .carbox--featured .carbox1{
        flex:0 0 auto;
        width:240px;
        scroll-snap-align:start;
        border-radius:16px;
      }
      .carbox--featured .carsbox{
        height:150px;
        border-radius:16px 16px 0 0;
      }
      .carbox--featured .card-content{ padding:14px; }
      .carbox--featured .yellowbutton{
        padding:10px 0;
        border-radius:12px;
      }
    }
  </style>
</head>

<body>
  <x-navbar />

  <!-- HERO / SLIDER -->
  <div class="slider">
    <img src="{{ asset('images/porsche-4795517.jpg') }}" alt="porsche">
    <img src="{{ asset('images/13.jpg') }}" alt="car">
    <img src="{{ asset('images/11.jpg') }}" alt="car">
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

  <!-- ✅ STATS (hero-raül) -->
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
  <!-- KIEMELT -->
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

  <!-- RÓLUNK -->
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

      /* ===== COUNTUP (csak amikor látszik) ===== */
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