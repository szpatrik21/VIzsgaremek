<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCar - Autók</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite([
      'resources/css/navbar.css',
      'resources/css/autok.css'
    ])
</head>
<body>

<x-navbar />

<div class="autok">

  <div class="container">
    <h2 class="autocim">Autók:</h2>
  </div>

  <div class="szuro">
    <form class="filters" method="GET" action="{{ route('autok.index') }}">
      <div class="filters-row">

        <div class="f">
          <label>Márka</label>
          <select name="marka">
            <option value="">Összes</option>
            @foreach($markak as $m)
              <option value="{{ $m }}" @selected(request('marka') === $m)>{{ $m }}</option>
            @endforeach
          </select>
        </div>

        <div class="f">
          <label>Állapot</label>
          <select name="allapot">
            <option value="">Összes</option>
            @foreach($allapotok as $a)
              <option value="{{ $a }}" @selected(request('allapot') === $a)>{{ $a }}</option>
            @endforeach
          </select>
        </div>

        <div class="f">
          <label>Kivitel</label>
          <select name="kivitel">
            <option value="">Összes</option>
            @foreach($kivitelek as $k)
              <option value="{{ $k }}" @selected(request('kivitel') === $k)>{{ $k }}</option>
            @endforeach
          </select>
        </div>

        <div class="f">
          <label>Szín</label>
          <select name="szin">
            <option value="">Összes</option>
            @foreach($szinek as $s)
              <option value="{{ $s }}" @selected(request('szin') === $s)>{{ $s }}</option>
            @endforeach
          </select>
        </div>

        <div class="f f-actions">
          <button type="submit" class="btn-filter">Szűrés</button>
          <a class="btn-reset" href="{{ route('autok.index') }}">Törlés</a>
        </div>

      </div>
    </form>
  </div>

  <div class="container">
    <div class="carbox">
      @forelse($autok as $auto)

        <div class="carbox1">

          @if(!empty($auto->kep))
            <img src="{{ asset($auto->kep) }}" class="carsbox" alt="{{ $auto->marka }} {{ $auto->modell }}">
          @else
            <img src="{{ asset('images/no-image.png') }}" class="carsbox" alt="Nincs kép">
          @endif

          <div class="card-content">
            <p><strong>{{ $auto->marka }} {{ $auto->modell }}</strong></p>
            <p>{{ $auto->teljesitmeny }} LE • {{ $auto->uzemanyag }}</p>
            <p><b>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</b></p>

            <a class="yellowbutton" href="{{ route('autok.show', $auto) }}">
              Érdekel
            </a>
          </div>

        </div>

      @empty
        <p class="no-results">Nincs találat a szűrésre.</p>
      @endforelse
    </div>
  </div>

</div>

<x-footer />

</body>
</html>