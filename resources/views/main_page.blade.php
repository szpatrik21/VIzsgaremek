<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuxCar - Kezdőoldal</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="icon" href="/images/favicon.ico">
    @vite([
      'resources/css/main_page.css',
      'resources/css/navbar.css',
      'resources/js/main.js'
    ])

  <!-- CSAK a main_page.css -->
  <link rel="stylesheet" href="/resources/css/main_page.css">

</head>
<x-navbar />
<body>

  <!-- HERO -->
  <div class="slider">
    <img src="/images/14.jpg" alt="car">
    <img src="/images/16.jpg" alt="car">
    <img src="/images/17 (2).jpg" alt="car">
    <img src="/images/19.jpg" alt="car">
    <img src="/images/21.jpg" alt="car">
    <img src="/images/22.jpg" alt="car">

    <div class="hero-overlay">
      <h1>Luxusautók egy helyen</h1>
      <p>Válogass prémium modellek közül, nézd meg a részleteket, és kérj ajánlatot gyorsan, egyszerűen.</p>
      <div class="hero-actions">
        <a class="cta" href="/autok">Autók megtekintése</a>
      </div>
    </div>
  </div>

  <!-- STATS -->
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

  <!-- KIEMELT AUTÓK -->
  <div class="container">
    <h2 id="kiemelt" class="cim1 reveal">Kiemelt autók:</h2>

    <div id="featuredCars" class="carbox carbox-grid carbox--featured">
      <div class="api-msg">Kiemelt autók betöltése...</div>
    </div>
  </div>

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

<x-footer />

</body>
</html>