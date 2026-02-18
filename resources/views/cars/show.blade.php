<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $auto->marka }} - {{ $auto->modell }}</title>

  @vite([
      'resources/css/auto.css',
      'resources/css/style3.css',
      'resources/css/navbar.css',
  ])
</head>

<body>

<x-navbar />

<div class="egesz">

  <!-- KÉPEK AUTOMATIKUS BETÖLTÉSE -->
@php
    $folder = $auto->marka . ' ' . $auto->modell;
    $path = public_path('images/Autok/Autok/' . $folder);

    $imageUrls = [];

    if (is_dir($path)) {
        $files = scandir($path);

        foreach ($files as $file) {
            if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
                $imageUrls[] = 'images/Autok/Autok/' . $folder . '/' . $file;
            }
        }
    }
@endphp



  <div class="kepauto">

    <!-- Nagy kép -->
    <div class="auto1">
        @if(isset($imageUrls[0]))
            <img src="{{ asset($imageUrls[0]) }}" alt="{{ $auto->marka }}">
        @endif
    </div>

    <!-- Oldalsó kép -->
    <div class="auto3">
        @if(isset($imageUrls[1]))
            <img class="autocska" src="{{ asset($imageUrls[1]) }}" alt="{{ $auto->marka }}">
        @endif

        <button>06 20 281 35 95</button>
        <button>Kérj árajánlatot</button>

        <p>
          Raktáron: 
          @if($auto->raktaron > 0)
              {{ $auto->raktaron }} db
          @else
              Nincs raktáron
          @endif
        </p>
    </div>

  </div>

  <!-- Árak -->
  <div class="ar">
    <h3 class="ar1">{{ $auto->marka }} {{ $auto->modell }}</h3>
    <div class="ar2">
      <p>{{ number_format($auto->teljesitmeny * 100000, 0, ',', ' ') }} Ft</p>
    </div>
  </div>

  <!-- Felső három adat -->
  <div class="autoadatok">
    <div>
      <p>Évjárat</p>
      <p>{{ $auto->evjarat }}</p>
    </div>
    <div>
      <p>Hengerűrtartalom</p>
      <p>{{ $auto->hengerurtartalom }} ccm</p>
    </div>
    <div>
      <p>Teljesítmény</p>
      <p>{{ $auto->teljesitmeny }} LE</p>
    </div>
  </div>

  <!-- Jellemzők -->
  <h3 class="jellemzok-cim">Jellemzők</h3>

  <div class="jellemzok-container">

    <table class="jellemzok">
      <tr><td>Modell</td><td>{{ $auto->modell }}</td></tr>
      <tr><td>Évjárat</td><td>{{ $auto->evjarat }}</td></tr>
      <tr><td>Kilométeróra</td><td>{{ number_format($auto->kilometerora) }} km</td></tr>
      <tr><td>Ajtók száma</td><td>{{ $auto->ajtok_szama }}</td></tr>
      <tr><td>Üzemanyag</td><td>{{ $auto->uzemanyag }}</td></tr>
      <tr><td>Teljesítmény</td><td>{{ $auto->teljesitmeny }} LE</td></tr>
    </table>

    <table class="jellemzok">
      <tr><td>Márka</td><td>{{ $auto->marka }}</td></tr>
      <tr><td>Kivitel</td><td>{{ $auto->kivitel }}</td></tr>
      <tr><td>Állapot</td><td>{{ $auto->allapot }}</td></tr>
      <tr><td>Személyek száma</td><td>{{ $auto->szemelyek_szama }}</td></tr>
      <tr><td>Szín</td><td>{{ $auto->szin }}</td></tr>
      <tr><td>Sebességváltó</td><td>{{ $auto->sebessegvalto }}</td></tr>
      <tr><td>Hengerűrtartalom</td><td>{{ $auto->hengerurtartalom }} ccm</td></tr>
    </table>

  </div>
</div>

</body>
</html>
