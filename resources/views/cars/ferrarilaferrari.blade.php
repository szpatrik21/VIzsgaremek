<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuxCar - Bentley Continental GT</title>
</head>
    @vite([
    'resources/css/auto.css',
    'resources/css/style3.css',
    'resources/css/navbar.css',
])
<body>
    <x-navbar />

<div class="egesz">
  <div class="kepauto">
    <div class="auto1">
      <img src="{{ asset('/images/Autok/Autok/Ferrari LaFerrari/laferrari1.jpg') }}" alt="porsche">
    </div>

    <div class="auto3">
      <img class="autocska"src="{{ asset('/images/Autok/Autok/Ferrari LaFerrari/laferrari2.jpg') }}" alt="porsche">
      <button>06 20 281 35 95</button>
      <button>Kérj árajánlatot</button>
      <p>Raktáron: 4 db</p>
    </div>
  </div>

  <div class="ar">
    <h3 class="ar1">Bentley Continental GT</h3>
    <div class="ar2">
      <p>52 000 000 Ft</p>
    </div>
  </div>

<!-- Felső 3 adat -->
<div class="autoadatok">
  <div>
    <p>Évjárat</p>
    <p>2014</p>
  </div>
  <div>
    <p>Tengerűrtartalom</p>
    <p>3220 CCM</p>
  </div>
  <div>
    <p>Teljesítmény</p>
    <p>320 LE</p>
  </div>
</div>

<!-- Jellemzők -->
<h3 class="jellemzok-cim">Jellemzők</h3>

<div class="jellemzok-container">

  <table class="jellemzok">
    <tr><td>Modell</td><td>Ranger</td></tr>
    <tr><td>Évjárat</td><td>2014</td></tr>
    <tr><td>Kilométeróra állás</td><td>206 000 km</td></tr>
    <tr><td>Ajtók száma</td><td>4</td></tr>
    <tr><td>Üzemanyag</td><td>Dízel</td></tr>
    <tr><td>Teljesítmény</td><td>300 LE</td></tr>
  </table>

  <table class="jellemzok">
    <tr><td>Márka</td><td>Ford</td></tr>
    <tr><td>Kivitel</td><td>Pickup</td></tr>
    <tr><td>Állapot</td><td>Megkímélt</td></tr>
    <tr><td>Szállítható személyek</td><td>5</td></tr>
    <tr><td>Szín</td><td>Piros</td></tr>
    <tr><td>Sebességváltó</td><td>Manuális</td></tr>
    <tr><td>Hengerűrtartalom</td><td>3200 cm</td></tr>
  </table>

</div>

</div>

</body>
</html>