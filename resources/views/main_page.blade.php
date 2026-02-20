<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @vite([
    'resources/css/main_page.css',
    'resources/css/navbar.css',
])
    <title>LuxCar - Kezdőoldal</title>
</head>

<body>
   <x-navbar />
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
</div><br><br>
 
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

    <h1 class="webaruhaz_cim">Modern luxusautó webshop</h1> 
    <style>
        .webaruhaz_cim{
            font-size:40px;
            margin-bottom:5px;
        }
    </style>
</div>


<h2 class="cim1">Kiemelt autók:</h2>

<div class="carbox">
    @foreach($autok as $auto)
        <div class="carbox1">
            @if(!empty($auto->kep))
                <img src="{{ asset($auto->kep) }}" class="carsbox" alt="{{ $auto->marka }} {{ $auto->modell }}">
            @else
                <img src="{{ asset('images/no-image.png') }}" class="carsbox" alt="Nincs kép">
            @endif

            <div class="card-content">
                <p>{{ $auto->marka }} {{ $auto->modell }}</p>
                <p>{{ $auto->teljesitmeny }} LE • {{ $auto->uzemanyag }}</p>
                <p><b>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</b></p>

                <a class="yellowbutton" href="{{ route('autok.show', $auto->id) }}">
                    Érdekel
                </a>
            </div>
        </div>
    @endforeach
</div>

  <div class="about-section">
    <h2>Rólunk</h2>
    <p>
      Üdvözlünk a <span class="highlight">Márkanév</span>-nél, ahol a négy kerék nem csupán közlekedési eszköz, 
      hanem életstílus. Webshopunkban a világ legismertebb és legexkluzívabb márkáinak luxusautóit találod – 
      <span class="highlight">Ferrari</span>, <span class="highlight">Lamborghini</span>, 
      <span class="highlight">Aston Martin</span>, <span class="highlight">Bugatti</span> és még sok más ikonikus név.
    </p>
    <p>
      Célunk, hogy ügyfeleink számára elérhetővé tegyük az autózás legfelsőbb szintjét: a teljesítményt, 
      a kifinomultságot és a páratlan dizájnt. Nálunk nem csak autót vásárolsz, hanem egy élményt, 
      egy életérzést, amelyhez csak keveseknek van szerencséje.
    </p>
    <p>
      Legyen szó vadonatúj sportautóról vagy gondosan válogatott használt prémium modellről, 
      kínálatunk minden darabja a minőség és a luxus garanciája.
    </p> <br><br>
  
  </div>

  
  <script>
    const slides = document.querySelectorAll(".slider img");
    let current = 0;
    function showSlide(i) {
      slides.forEach(s => s.classList.remove("active"));
      slides[i].classList.add("active");
    }
    setInterval(() => {
      current = (current + 1) % slides.length;
      showSlide(current);
    }, 10000);
    showSlide(0);
  </script>

</body>


 