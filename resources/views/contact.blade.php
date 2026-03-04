<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  <title>Kapcsolat - LuxCar</title>

  @vite([
    'resources/css/navbar.css',
    'resources/css/style4.css',
    'resources/css/contact.css'
  ])
</head>
<body>

<x-navbar />

<section class="contact-hero">
  <div class="contact-inner">
    <h1>Kapcsolat</h1>
    <p>Elérhetőségeink az alábbiakban találhatók.</p>

    <div class="contact-grid">
      <div class="info-box">
        <h3>Email</h3>
        <p>luxcar0000@gmail.com</p>
      </div>

      <div class="info-box">
        <h3>Telefon</h3>
        <p>+36 20 281 25 95</p>
      </div>

      <div class="info-box">
        <h3>Cím</h3>
        <p>Pécs, efwfwe utca 1.</p>
      </div>

      <div class="info-box">
        <h3>Nyitvatartás</h3>
        <p>H–P: 09:00–17:00</p>
        <p>Szo: 10:00–14:00</p>
        <p>V: Zárva</p>
      </div>
    </div>
  </div>
</section>

<section class="map-section">
  <div class="contact-inner">
    <h2>Bemutatótermünk</h2>

    <div class="map-wrapper">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2769.7480434325475!2d18.214716075792985!3d46.03617569509494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4742b3b64547f9ff%3A0x81835de2edb802f1!2sBaranya%20V%C3%A1rmegyei%20SZC%20Simonyi%20K%C3%A1roly%20Technikum%20%C3%A9s%20Szakk%C3%A9pz%C5%91%20Iskola!5e0!3m2!1shu!2shu!4v1772046983852!5m2!1shu!2shu"
        allowfullscreen=""
        loading="lazy">
      </iframe>
    </div>
  </div>
</section>

<x-footer />
</body>
</html>