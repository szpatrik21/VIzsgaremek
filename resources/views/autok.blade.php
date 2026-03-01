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
      'resources/css/navbar.css'
    ])
</head>
<body>

<x-navbar />

<style>
:root{
  --font-body: "Space Grotesk", system-ui, sans-serif;
  --font-display: "Playfair Display", serif;
  --gold:#d4af37;
}

/* ===== ALAP ===== */
body{
  font-family: var(--font-body);
  background:#000;
  color:#fff;
}

/* ===== KONTÉNER ===== */
.container{
  max-width:1200px;
  margin:0 auto;
  padding:0 24px;
}

/* ===== CÍM ===== */
.autocim{
  font-family:var(--font-display);
  font-size:34px;
  margin:90px 0 24px;
}

/* ===== FILTERS ===== */
.filters{
  max-width:1200px;
  margin:0 auto 24px;
  padding:0 24px;
}

.filters-row{
  display:grid;
  grid-template-columns: repeat(5, 1fr);
  gap:14px;
  align-items:end;
}

.f{
  display:flex;
  flex-direction:column;
  gap:6px;
}

.f label{
  font-size:14px;
  color:#ddd;
}

.f select{
  padding:10px 12px;
  border-radius:12px;
  border:1px solid #333;
  background:#111;
  color:#fff;
  outline:none;
}

.f select:focus{
  border-color:var(--gold);
  box-shadow:0 0 0 3px rgba(212,175,55,.12);
}

.f-actions{
  display:flex;
  gap:10px;
  justify-content:flex-end;
}

.btn-filter, .btn-reset{
  height:42px;
  padding:0 14px;
  border-radius:12px;
  text-decoration:none;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  white-space:nowrap;
}

.btn-filter{
  background:#caa36a;
  color:#111;
  font-weight:800;
  border:none;
}

.btn-reset{
  background:transparent;
  color:#ddd;
  border:1px solid #333;
}

/* ===== AUTÓK RÁCS ===== */
.carbox{
  display:grid;
  grid-template-columns: repeat(4, 1fr);
  gap:22px;
  margin:30px 0 80px;
}

.carbox1{
  background:#191919;
  border-radius:16px;
  overflow:hidden;
  border:1px solid rgba(255,255,255,.06);
  box-shadow:0 18px 45px rgba(0,0,0,.55);
  transition:.2s ease;
}

.carbox1:hover{
  transform:translateY(-4px);
  border-color:rgba(212,175,55,.2);
}

.carsbox{
  width:100%;
  height:180px;
  object-fit:cover;
}

.card-content{
  padding:16px;
}

.card-content strong{
  font-family:var(--font-display);
  font-size:17px;
}

.card-content p{
  margin:6px 0;
  color:#dcdcdc;
}

.card-content b{
  font-size:16px;
}

.yellowbutton{
  width:100%;
  margin-top:10px;
  padding:10px 0;
  border-radius:12px;
  background:#C9A16B;
  color:#000;
  text-decoration:none;
  font-weight:800;
  display:inline-flex;
  justify-content:center;
  transition:.2s ease;
}

.yellowbutton:hover{
  background:#d0ac7c;
}

.no-results{
  margin:20px 0 60px;
  color:rgba(255,255,255,.7);
}

/* ===== RESPONSIVE ===== */
@media (max-width:1100px){
  .filters-row{ grid-template-columns: repeat(3, 1fr); }
  .carbox{ grid-template-columns: repeat(3, 1fr); }
}

@media (max-width:850px){
  .filters-row{ grid-template-columns: repeat(2, 1fr); }
  .carbox{ grid-template-columns: repeat(2, 1fr); }
}

@media (max-width:520px){
  .container{ padding:0 16px; }
  .filters{ padding:0 16px; }

  .filters-row{ grid-template-columns:1fr; }

  .f-actions{
    flex-direction:column;
  }

  .btn-filter, .btn-reset{
    width:100%;
  }

  .carbox{
    grid-template-columns:1fr;
  }

  .autocim{
    font-size:28px;
    margin-top:80px;
  }

  .carsbox{
    height:160px;
  }
}
</style>

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