<!DOCTYPE html>
<html lang="en">
<head>    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>LuxCar - Kezdőoldal</title>
    <link rel="icon" href="{{ asset('ChatGPT Image 2026. márc. 1. 13_20_49 (1).ico') }}">
    <meta charset="UTF-8">
    @vite([
      'resources/css/main_page.css',
      'resources/css/navbar.css',
    ])
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

    <!-- ✅ overlay, ettől nem üres -->
    <div class="hero-overlay">
      <h1>Luxusautók egy helyen</h1>
      <p>Válogass prémium modellek közül, nézd meg a részleteket, és kérj ajánlatot gyorsan, egyszerűen.</p>
      <div class="hero-actions">
        <a class="cta" href="{{ route('autok.index') }}">Autók megtekintése</a>
      </div>
    </div>
  </div>

  <!-- LOGÓK -->
  <br><br>

  <div class="markak">
    <div class="wallpaper">
      <img src="{{ asset('images/aston-martin-white-logo.webp') }}" alt="aston martin">
    </div>
    <div class="wallpaper">
      <img src="{{ asset('images/bentley-white-logo.webp') }}" alt="bentley">
    </div>
    <div class="wallpaper">
      <img src="{{ asset('images/bugatti-logo-new-1.webp') }}" alt="bugatti">
    </div>
    <div class="wallpaper">
      <img src="{{ asset('images/ferrari-logo.webp') }}" alt="ferrari">
    </div>
    <div class="wallpaper">
      <img src="{{ asset('images/Lamborghini_Shield-Logo_RGB_Gold-resized-home.webp') }}" alt="lamborghini">
    </div>
    <div class="wallpaper">
      <img src="{{ asset('images/maserati-white-logo.webp') }}" alt="maserati">
    </div>
    <div class="wallpaper">
      <img src="{{ asset('images/rimac-white-logo.webp') }}" alt="rimac">
    </div>


  </div>

<style>
@media (max-width:700px){

  .markak{
    display: flex;
    gap: 30px;
    overflow-x: auto;
    overflow-y: hidden;
    padding: 20px 16px;
    scroll-behavior: smooth;

    -webkit-overflow-scrolling: touch;
  }

  .markak::-webkit-scrollbar{
    display: none; /* eltünteti a scrollbar-t */
  }

  .wallpaper{
    flex: 0 0 auto; /* ne törjön új sorba */
  }

  .wallpaper img{
    width: 110px;
    height: auto;
    opacity: .8;
    transition: .2s ease;
  }

  .wallpaper img:active{
    opacity: 1;
  }

}
@media (max-width:700px){
  .wallpaper img{
    opacity: .65;
  }
}
</style>
<!-- KIEMELT -->
<div class="container">
  <h2 id="kiemelt" class="cim1">Kiemelt autók:</h2>

  <div class="carbox carbox-grid">
  @foreach($autok as $auto)
    <div class="carbox1">

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
        <p class="card-title">
          {{ $auto->marka }} {{ $auto->modell }}
        </p>

        <p class="card-spec">
          {{ $auto->teljesitmeny }} LE • {{ $auto->uzemanyag }}
        </p>

        <p class="card-price">
          {{ number_format($auto->ar, 0, ',', ' ') }} Ft
        </p>

        <a class="yellowbutton"
           href="{{ route('autok.show', $auto) }}">
          Érdekel
        </a>
      </div>

    </div>
  @endforeach
</div>


  <style>
/* ===== GYIK KÖZÉPRE IGAZÍTVA ===== */
.faq{
  padding: 80px 0;
  display: flex;
  justify-content: center;
}

.faq__inner{
  width: 100%;
  max-width: 900px;   /* keskenyebb, elegánsabb */
  padding: 0 24px;
  text-align: center; /* cím + alcím középen */
}

.faq__title{
  margin-bottom: 12px;
}

.faq__subtitle{
  margin: 0 auto 28px;
  max-width: 600px;
}

/* A kérdések maradjanak balra igazítva, hogy olvasható legyen */
.faq__list{
  text-align: left;
}

/* Mobil finomítás */
@media (max-width:700px){
  .faq{
    padding: 60px 0;
  }

  .faq__inner{
    padding: 0 16px;
  }
}
/* ===== KIEMELT RÁCS ===== */
.carbox-grid{
  display:grid;
  grid-template-columns: repeat(4, 1fr);
  gap:24px;
  margin:40px 0 80px;
}

/* ===== KÁRTYA ===== */
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

/* ===== KÉP ===== */
.carsbox{
  width:100%;
  height:190px;
  object-fit:cover;
  display:block;
}

/* ===== TARTALOM ===== */
.card-content{
  padding:18px;
}

.card-title{
  font-family:"Playfair Display", serif;
  font-size:18px;
  font-weight:600;
  margin-bottom:6px;
  color:#fff;
}

.card-spec{
  font-size:14px;
  color:#bbb;
  margin-bottom:10px;
}

.card-price{
  font-size:17px;
  font-weight:700;
  margin-bottom:14px;
  color:#fff;
}

/* ===== GOMB ===== */
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

.yellowbutton:hover{
  background:#d8b27c;
}

/* ===== RESPONSIVE ===== */
@media (max-width:1100px){
  .carbox-grid{
    grid-template-columns:repeat(3,1fr);
  }
}

@media (max-width:850px){
  .carbox-grid{
    grid-template-columns:repeat(2,1fr);
  }
}

@media (max-width:520px){
  .carbox-grid{
    grid-template-columns:1fr;
    padding:0 16px;
  }

  .carsbox{
    height:170px;
  }
}

    /* ===== KIEMELT AUTÓK – MOBILON PRÉMIUM SCROLL ===== */
@media (max-width:700px){

  .cim1{
    margin-left: 16px;         /* ne legyen 150px */
    font-size: 26px;
    margin-bottom: 18px;
  }

  .carbox--featured{
    justify-content: flex-start;
    flex-wrap: nowrap;
    overflow-x: auto;
    overflow-y: hidden;
    gap: 14px;

    padding: 0 16px 12px;
    margin-bottom: 40px;

    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
  }

  .carbox--featured::-webkit-scrollbar{
    display:none;
  }

  .carbox--featured .carbox1{
    flex: 0 0 auto;
    width: 240px;              /* kártya szélesség mobilon */
    scroll-snap-align: start;
    border-radius: 16px;
  }

  .carbox--featured .carsbox{
    height: 150px;
    border-radius: 16px 16px 0 0;
  }

  .carbox--featured .card-content{
    padding: 14px;
  }

  .carbox--featured .yellowbutton{
    width: 100%;
    text-align: center;
    padding: 10px 0;
    border-radius: 12px;
  }
}
  </style>
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

<style>
  
</style>


  <x-gyk />

  <script>
    const slides = document.querySelectorAll(".slider img");
    let current = 0;

    function showSlide(i) {
      slides.forEach(s => s.classList.remove("active"));
      slides[i].classList.add("active");
    }

    showSlide(0);

    setInterval(() => {
      current = (current + 1) % slides.length;
      showSlide(current);
    }, 5000);
  </script>


  <x-footer />
</body>


</html>