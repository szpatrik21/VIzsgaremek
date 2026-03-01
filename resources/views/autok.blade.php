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
  'resources/css/style4.css'
])
</head>
<body>

<x-navbar />
<style>
    :root{
  --font-body: "Space Grotesk", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  --font-display: "Playfair Display", Georgia, serif;
}

/* ===== ALAP ===== */
body{
  font-family: var(--font-body);
}

/* ===== CÍMEK (luxus serif) ===== */
.autocim{
  font-family: var(--font-display);
  font-weight: 700;
  letter-spacing: .3px;
}

/* ===== SZŰRŐ FELIRATOK ===== */
.f label{
  font-family: var(--font-body);
  font-weight: 500;
  letter-spacing: .2px;
}

/* ===== SELECT ===== */
.f select{
  font-family: var(--font-body);
  font-weight: 500;
}

/* ===== KÁRTYA CÍM ===== */
.card-content strong{
  font-family: var(--font-display);
  font-weight: 600;
  letter-spacing: .2px;
}

/* ===== KÁRTYA SZÖVEG ===== */
.card-content p{
  font-family: var(--font-body);
}

/* ===== GOMBOK ===== */
.btn-filter,
.btn-reset,
.yellowbutton{
  font-family: var(--font-body);
  font-weight: 600;
  letter-spacing: .3px;
}
</style>
<div class="autok">
<h2 class="autocim">Autók:</h2>

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

<div class="carbox">
    @forelse($autok as $auto)
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
                <p><strong>{{ $auto->marka }} {{ $auto->modell }}</strong></p>
                <p>{{ $auto->teljesitmeny }} LE • {{ $auto->uzemanyag }}</p>
                <p><b>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</b></p>

                {{-- ✅ MODEL BINDING: nem id --}}
                <a class="yellowbutton" href="{{ route('autok.show', $auto) }}">
                    Érdekel
                </a>
            </div>

        </div>
    @empty
        <p style="margin-left:175px;">Nincs találat a szűrésre.</p>
    @endforelse
</div>

<style>
.autocim{
    margin-top:60px;
    margin-bottom:40px;
    font-size:32px;
    margin-left:150px;
}
</style>

<style>
.filters{
  max-width: 1200px;
  margin: 0 auto 24px auto;
  padding: 0 24px;
}

.filters-row{
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
  align-items: end;
}

.f{
  display: flex;
  flex-direction: column;
  gap: 6px;
  min-width: 220px;
}

.f label{
  color: #ddd;
  font-size: 14px;
}

.f select{
  padding: 10px 12px;
  border-radius: 10px;
  border: 1px solid #333;
  background: #111;
  color: #fff;
}

.f-actions{
  flex-direction: row;
  gap: 10px;
  min-width: auto;
}

.btn-filter, .btn-reset{
  padding: 10px 14px;
  border-radius: 10px;
  border: 0;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-filter{
  background: #caa36a;
  color: #111;
  font-weight: 700;
}

.btn-reset{
  background: transparent;
  color: #ddd;
  border: 1px solid #333;
}

.autok{
    margin-bottom:80px;
}
</style>
</div>




















<footer class="footer">
  <div class="footer-inner">

    <div class="footer-col">
      <h3 class="footer-logo">LuxCar</h3>
      <p>
        Prémium és exkluzív luxusautók egy helyen.
        Teljesítmény. Elegancia. Presztízs.
      </p>
    </div>

    <div class="footer-col">
      <h4>Gyors linkek</h4>
      <a href="{{ route('home') }}">Kezdőoldal</a>
      <a href="{{ route('autok.index') }}">Autók</a>
      <a href="#gyik">GYIK</a>
      <a href="#">Kapcsolat</a>
    </div>

    <div class="footer-col">
      <h4>Kapcsolat</h4>
      <p>Email: info@luxcar.hu</p>
      <p>Telefon: +36 30 123 4567</p>
      <p>Budapest, Magyarország</p>
    </div>

    <div class="footer-col">
      <h4>Kövess minket</h4>
      <div class="socials">
        <a href="#">Instagram</a>
        <a href="#">Facebook</a>
        <a href="#">YouTube</a>
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    © {{ date('Y') }} LuxCar. Minden jog fenntartva.
  </div>
</footer>

<style>
  /* ===== FOOTER ===== */

.footer{
  background: #0a0a0a;
  border-top: 1px solid rgba(212,175,55,.15);
  margin-top: 80px;
  padding-top: 60px;
}

.footer-inner{
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 40px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 40px;
}

.footer-col h3,
.footer-col h4{
  color: #fff;
  margin-bottom: 16px;
  font-family: var(--font-display);
}

.footer-col p,
.footer-col a{
  color: rgba(255,255,255,.65);
  font-size: 14px;
  line-height: 1.7;
  text-decoration: none;
  display: block;
  margin-bottom: 8px;
  transition: .2s ease;
}

.footer-col a:hover{
  color: #d4af37;
}

.footer-logo{
  font-size: 24px;
  letter-spacing: 1px;
}

.footer-bottom{
  border-top: 1px solid rgba(255,255,255,.06);
  margin-top: 50px;
  padding: 20px;
  text-align: center;
  font-size: 13px;
  color: rgba(255,255,255,.5);
}

/* mobil */
@media (max-width: 900px){
  .footer-inner{
    grid-template-columns: 1fr;
    gap: 30px;
  }
}
</style>
</body>
</html>