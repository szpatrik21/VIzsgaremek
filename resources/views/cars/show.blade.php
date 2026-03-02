<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ $auto->marka }} - {{ $auto->modell }}</title>

    @vite([
        'resources/css/auto.css',
        'resources/css/style3.css',
        'resources/css/navbar.css',
        'resources/js/autok.js'
    ])
</head>

<style>
:root{
  --font-body: "Space Grotesk", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  --font-display: "Playfair Display", Georgia, serif;

  --bg:#070707;
  --text: rgba(255,255,255,.94);
  --muted: rgba(255,255,255,.76);

  --gold:#d4af37;
  --gold2:#f2d06a;

  --line: rgba(255,255,255,.14);
  --shadow: 0 16px 45px rgba(0,0,0,.60);
  --radius: 16px;

  --gold-glow: 0 0 0 1px rgba(212,175,55,.28), 0 10px 30px rgba(212,175,55,.12);
}

body{
  font-family: var(--font-body);
  color: var(--text);
  background:
    radial-gradient(900px 520px at 15% 10%, rgba(212,175,55,.10), transparent 60%),
    radial-gradient(900px 520px at 85% 12%, rgba(255,255,255,.06), transparent 60%),
    linear-gradient(180deg, #0a0a0a, #000 55%, #070707);
}

/* CÍMEK */
.ar1,
.jellemzok-cim,
.reviews-section h2{
  font-family: var(--font-display);
  font-weight: 800;
  letter-spacing: .3px;
}

.ar2 p{
  font-family: var(--font-body);
  font-weight: 800;
  letter-spacing: .2px;
}

/* ---------- LAYOUT ---------- */
.egesz{
  max-width: 1320px;
  margin: 0 auto;
  padding: 28px 18px 10px;
}

.kepauto{
  display: grid;
  grid-template-columns: 1.75fr .95fr;
  gap: 22px;
  align-items: start;
}

/* ---------- HERO IMAGE + THUMBS ---------- */
.auto1{
  background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
  border: 1px solid var(--line);
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: var(--shadow);
}

.auto1 img{
  width: 100%;
  height: 430px;
  object-fit: cover;
  display:block;
}

.auto1{
  position: relative; /* fontos az overlay miatt */
  overflow: hidden;
}

/* kis képek ráülnek a nagy képre */
.gallery-thumbs{
  position: absolute;
  bottom: 18px;
  left: 18px;

  display: flex;
  gap: 10px;

  padding: 10px;
  border-radius: 14px;

  background: rgba(0,0,0,.55);
  backdrop-filter: blur(8px);

  border: 1px solid rgba(255,255,255,.15);
  box-shadow: 0 10px 30px rgba(0,0,0,.6);
}

.gallery-thumbs::-webkit-scrollbar{ height: 8px; }
.gallery-thumbs::-webkit-scrollbar-thumb{ background: rgba(255,255,255,.14); border-radius: 20px; }

.thumb{
  width: 85px;
  height: 55px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,.16);
  overflow:hidden;
  cursor:pointer;
  flex: 0 0 auto;
  position:relative;
  transition: .15s ease;
}
.thumb img{
  width:100%;
  height:100%;
  object-fit: cover;
  display:block;
  transform: scale(1.02);
}
.thumb:hover{
  border-color: rgba(212,175,55,.55);
}
.thumb.active{
  border-color: rgba(212,175,55,.8);
  box-shadow: 0 0 0 2px rgba(212,175,55,.15);
}

/* ---------- SIDE CARD (NO IMAGE) ---------- */
.auto3{
  top: 16px;
  background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
  border: 1px solid var(--line);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: var(--shadow);
}

.side-title{
  font-family: var(--font-display);
  font-weight: 800;
  font-size: 18px;
  margin: 0 0 12px;
  letter-spacing: .2px;
}

.badges{
  display:flex;
  flex-direction: column;
  gap: 10px;
}

.badge{
  display:flex;
  align-items:center;
  gap:10px;
  padding: 10px 12px;
  border-radius: 12px;
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.14);
  color: rgba(255,255,255,.78);
  font-weight: 800;
  font-size: 14px;
}

.badge b{
  color: #fff;
  font-weight: 900;
  text-shadow: 0 0 18px rgba(255,255,255,.12);
}

.phone-btn{
  display:block;
  width: 100%;
  margin-top: 14px;
  padding: 12px 12px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,.16);
  background: rgba(255,255,255,.08);
  color: var(--text);
  text-decoration:none;
  text-align:center;
  font-weight: 900;
}

.offer-btn{
  display:block;
  width:100%;
  padding: 12px 14px;
  margin-top: 10px;
  background: var(--gold2);
  color: #000;
  font-weight: 950;
  text-align:center;
  text-decoration:none;
  border-radius: 12px;
  transition: .18s ease;
  box-shadow: var(--gold-glow);
}
.offer-btn:hover{ background: #ffe08a; transform: translateY(-1px); }

/* ---------- TITLE + PRICE ---------- */
.ar{
  display:flex;
  align-items: baseline;
  justify-content: flex-start;
  gap: 40px;
}

.ar1{
  font-size: 44px;
  margin: 0;
}

.ar2 p{
  margin: 0;
  font-size: 34px;
  color: var(--gold2);
  text-shadow:
    0 0 22px rgba(212,175,55,.25),
    0 0 55px rgba(212,175,55,.10);
  position: relative;
  top: 1px;
}

.subline{
  margin-top: 10px;
  color: var(--muted);
  font-weight: 800;
  line-height: 1.4;
}

/* ---------- QUICK SPECS CARDS ---------- */
.quick-specs{
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, max-content));
  gap: 12px;
  justify-content: start;
  margin-left:60px;
}

.qs{
  background: linear-gradient(180deg, rgba(255,255,255,.11), rgba(255,255,255,.03));
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 14px;
  padding: 16px 14px;
  box-shadow: 0 10px 25px rgba(0,0,0,.48);
  min-height: 84px;
  display:flex;
  flex-direction: column;
  justify-content: center;
  transition: .16s ease;
}
.qs:hover{
  border-color: rgba(212,175,55,.35);
  box-shadow: 0 0 0 3px rgba(212,175,55,.10), 0 14px 35px rgba(0,0,0,.60);
  transform: translateY(-1px);
}

.qs .k{
  color: rgba(255,255,255,.80);
  font-size: 13px;
  font-weight: 900;
  letter-spacing: .2px;
  line-height: 1.2;
}
.qs .v{
  margin-top: 8px;
  font-size: 18px;
  font-weight: 950;
  line-height: 1.2;
  color: rgba(255,255,255,.95);
}
.qs .v.gold{ color: var(--gold2); }

/* ---------- SPEC TABLES -> CARD PANELS ---------- */
.jellemzok-cim{
  margin: 36px 0 14px;
  font-size: 30px;
}

.jellemzok-container{
  display:grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-bottom:10px;
}

.spec-card{
  background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
  border: 1px solid var(--line);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: var(--shadow);
  width:85%;
}
.reviews-list,
.reviews-form{
  background: linear-gradient(
    180deg,
    rgba(255,255,255,.09),
    rgba(255,255,255,.03)
  );
}
.spec-head{
  display:flex;
  justify-content: space-between;
  align-items:center;
  margin-bottom: 10px;
}
.spec-head h4{
  margin:0;
  font-family: var(--font-display);
  letter-spacing: .2px;
  font-size: 20px;
  line-height: 1.2;
}
.spec-head span{
  color: rgba(255,255,255,.70);
  font-weight: 900;
  font-size: 13px;
  line-height: 1.2;
}

.jellemzok{
  width:100%;
  border-collapse: collapse;
}
.jellemzok td{
  padding: 10px 0;
  border-bottom: 1px solid rgba(255,255,255,.10);
  font-size: 14px;
}
.jellemzok tr:nth-child(even) td{
  background: rgba(255,255,255,.03);
}
.jellemzok td:first-child{
  color: rgba(255,255,255,.78);
  font-weight: 900;
  width: 45%;
}
.jellemzok tr:last-child td{ border-bottom: 0; }

/* ---------- LIGHTBOX ---------- */
.lightbox{
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.85);
  display:none;
  align-items:center;
  justify-content:center;
  z-index: 9999;
  padding: 22px;
}
.lightbox.open{ display:flex; }
.lightbox img{
  max-width: 1100px;
  width: 100%;
  max-height: 80vh;
  object-fit: contain;
  border-radius: 16px;
  border: 1px solid rgba(255,255,255,.16);
  box-shadow: 0 30px 70px rgba(0,0,0,.7);
}
.lightbox .close{
  position:absolute;
  top: 18px;
  right: 18px;
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: rgba(255,255,255,.10);
  border: 1px solid rgba(255,255,255,.18);
  color: #fff;
  font-weight: 900;
  cursor:pointer;
}

/* ---------- REVIEWS ---------- */
hr.sep{
  margin: 70px 0;
  border:0;
  height:1px;
  background: rgba(255,255,255,.10);
}

.reviews-section{
  max-width: 1180px;
  margin: 0 auto 70px;
  padding: 18px;
  border-radius: 18px;
  border: 1px solid rgba(212,175,55,.35);
  box-shadow: 0 0 0 3px rgba(212,175,55,.08);
}

.reviews-section h2{
  font-size: 34px;
  margin: 0 0 18px 0;
  position: relative;
  padding-bottom: 10px;
}
.reviews-section h2::after{
  content:"";
  position:absolute;
  left:0;
  bottom:0;
  width: 80px;
  height: 2px;
  background: var(--gold2);
  opacity: .75;
}

.reviews-grid{
  display:flex;
  gap: 18px;
}

.reviews-list{
  flex: 1;
  background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
  border: 1px solid rgba(255,255,255,.14);
  padding: 18px;
  border-radius: var(--radius);
  max-height: 420px;
  overflow-y: auto;
  box-shadow: var(--shadow);
}

.review-item{
  border-bottom: 1px solid rgba(255,255,255,.10);
  padding: 12px 0;
}
.review-item:last-child{ border-bottom: 0; }

.review-item strong{
  font-family: var(--font-display);
  font-weight: 900;
  color: var(--gold2);
  text-shadow: 0 0 18px rgba(212,175,55,.18);
}
.review-item p{
  margin: 6px 0 0;
  color: rgba(255,255,255,.78);
  line-height: 1.5;
}

.reviews-form{
  flex: 1;
  display:flex;
  flex-direction:column;
  gap: 10px;
  background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
  border: 1px solid rgba(255,255,255,.14);
  padding: 18px;
  border-radius: var(--radius);
  box-shadow: var(--shadow);
}

.reviews-form textarea{
  height: 140px;
  padding: 12px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,.16);
  background: rgba(0,0,0,.30);
  color:#fff;
  resize:none;
  outline: none;
}
.reviews-form textarea::placeholder{
  color: rgba(255,255,255,.40);
}

.reviews-form button{
  padding: 12px;
  background: var(--gold2);
  border:0;
  font-weight: 950;
  cursor:pointer;
  border-radius: 12px;
  box-shadow: var(--gold-glow);
}
.reviews-form button:hover{ background: #ffe08a; }

#comment-message{ font-weight:900; margin:0; }
#comment-message.ok{ color:#66ff99; }
#comment-message.err{ color:#ff5c5c; }

/* ---------- RESPONSIVE ---------- */
@media(max-width: 1100px){
  .quick-specs{ grid-template-columns: repeat(3, 1fr); }
  .kepauto{ grid-template-columns: 1fr; }
  .auto3{ position: relative; top: auto; }
}
@media(max-width: 700px){
  .ar{ flex-direction: column; align-items:flex-start; }
  .ar1{ font-size: 34px; }
  .ar2 p{ font-size: 26px; }
  .quick-specs{ grid-template-columns: repeat(2, 1fr); }
  .jellemzok-container{ grid-template-columns: 1fr; }
  .reviews-grid{ flex-direction: column; }
}
</style>
<body>
<x-navbar />

<div class="egesz">

    <div class="kepauto">
        <!-- Nagy kép + thumbnails -->
        <div class="auto1">
            @if(!empty($auto->kep))
                <img id="mainCarImg" src="{{ asset($auto->kep) }}" alt="{{ $auto->marka }} {{ $auto->modell }}">
            @else
                <p style="padding:18px;">Nincs kép</p>
            @endif

            <div class="gallery-thumbs" id="thumbs">
                @php
                    $imgs = [];
                    if(!empty($auto->kep)) $imgs[] = $auto->kep;
                    if(!empty($auto->kep2 ?? null)) $imgs[] = $auto->kep2;
                    if(!empty($auto->kep3 ?? null)) $imgs[] = $auto->kep3;
                    if(!empty($auto->kep4 ?? null)) $imgs[] = $auto->kep4;
                    if(!empty($auto->kep5 ?? null)) $imgs[] = $auto->kep5;
                    if(!empty($auto->kep6 ?? null)) $imgs[] = $auto->kep6;
                @endphp

                @foreach($imgs as $i => $img)
                    <div class="thumb {{ $i === 0 ? 'active' : '' }}" data-src="{{ asset($img) }}">
                        <img src="{{ asset($img) }}" alt="thumb {{ $i+1 }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Oldalsó blokk (sticky) - NO IMAGE -->
        <div class="auto3">
            <p class="side-title">Infó / ajánlatkérés</p>

            <div class="badges">
              <div class="badge"> Állapot: <b>{{ $auto->allapot }}</b></div>
              <div class="badge"> Raktár:
                <b>
                  @if($auto->raktaron > 0)
                      {{ $auto->raktaron }} db
                  @else
                      Nincs raktáron
                  @endif
                </b>
              </div>
              <div class="badge"> Váltó: <b>{{ $auto->sebessegvalto }}</b></div>
            </div>

            <a class="phone-btn" href="tel:+36202813595">06 20 281 35 95</a>

            <a href="{{ route('offer.create', $auto) }}" class="offer-btn">Kérj árajánlatot</a>
        </div>
    </div>
<style>

  .phone-btn{
    margin-top:40px;
    width:80%;
  }
  .offer-btn{
    width:80%;
    margin-bottom:35px;
  }
</style>
    <!-- Cím + Ár -->
    <div class="ar">
        <h3 class="ar1">{{ $auto->marka }} {{ $auto->modell }}</h3>
        <div class="ar2">
            <p>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</p>
        </div>
    </div>

    <div class="subline">
         {{ $auto->evjarat }} ·  {{ $auto->szin }} ·  {{ $auto->uzemanyag }}
    </div>
    <style>
      .subline{
        margin-left:60px;
        margin-bottom:60px;
      }
    </style>

    <!-- Quick specs -->
    <div class="quick-specs">
        <div class="qs">
            <div class="k"> Teljesítmény</div>
            <div class="v gold">{{ $auto->teljesitmeny }} LE</div>
        </div>
        <div class="qs">
            <div class="k"> Futott km</div>
            <div class="v">{{ number_format($auto->kilometerora, 0, ',', ' ') }} km</div>
        </div>
        <div class="qs">
            <div class="k"> Üzemanyag</div>
            <div class="v">{{ $auto->uzemanyag }}</div>
        </div>
        <div class="qs">
            <div class="k"> Váltó</div>
            <div class="v">{{ $auto->sebessegvalto }}</div>
        </div>
        <div class="qs">
            <div class="k"> Hengerűrtartalom</div>
            <div class="v">{{ $auto->hengerurtartalom }} ccm</div>
        </div>
        <div class="qs">
            <div class="k"> Ajtók</div>
            <div class="v">{{ $auto->ajtok_szama }} db</div>
        </div>
    </div>

    <!-- Jellemzők -->
    <h3 class="jellemzok-cim">Jellemzők</h3>

    <style>
      .jellemzok-cim{
        margin-left:60px;
        margin-top:60px;
        margin-bottom:60px;
      }
    </style>

    <div class="jellemzok-container">
        <div class="spec-card">
            <div class="spec-head">
                <h4>Alapadatok</h4>
                <span>Részletek</span>
            </div>
            <table class="jellemzok">
                <tr><td>Modell</td><td>{{ $auto->modell }}</td></tr>
                <tr><td>Évjárat</td><td>{{ $auto->evjarat }}</td></tr>
                <tr><td>Kilométeróra</td><td>{{ number_format($auto->kilometerora, 0, ',', ' ') }} km</td></tr>
                <tr><td>Ajtók száma</td><td>{{ $auto->ajtok_szama }}</td></tr>
                <tr><td>Üzemanyag</td><td>{{ $auto->uzemanyag }}</td></tr>
                <tr><td>Teljesítmény</td><td>{{ $auto->teljesitmeny }} LE</td></tr>
            </table>
        </div>

        <div class="spec-card">
            <div class="spec-head">
                <h4>Műszaki</h4>
                <span>Részletek</span>
            </div>
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

</div>

<hr class="sep">

<section class="reviews-section">
    <h2>Vélemények</h2>

    <div class="reviews-grid">
        <div class="reviews-list" id="reviews-list">
            <p>Betöltés...</p>
        </div>

        <form class="reviews-form" id="commentForm">
            <textarea id="comment-content" placeholder="Írd le a véleményed..."></textarea>
            <button type="submit" id="sendBtn">Küldés</button>
            <p id="comment-message"></p>
        </form>
    </div>
</section>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox">
  <button class="close" id="lbClose">✕</button>
  <img id="lbImg" src="" alt="car">
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // --- gallery thumbs ---
  const mainImg = document.getElementById("mainCarImg");
  const thumbs = document.querySelectorAll(".thumb");
  const lightbox = document.getElementById("lightbox");
  const lbImg = document.getElementById("lbImg");
  const lbClose = document.getElementById("lbClose");

  function setActiveThumb(el){
    thumbs.forEach(t => t.classList.remove("active"));
    el.classList.add("active");
  }

  thumbs.forEach(t => {
    t.addEventListener("click", () => {
      const src = t.getAttribute("data-src");
      if(mainImg && src){
        mainImg.src = src;
        setActiveThumb(t);
      }
    });
  });

  if(mainImg){
    mainImg.style.cursor = "zoom-in";
    mainImg.addEventListener("click", () => {
      lbImg.src = mainImg.src;
      lightbox.classList.add("open");
    });
  }

  lbClose.addEventListener("click", () => lightbox.classList.remove("open"));
  lightbox.addEventListener("click", (e) => {
    if(e.target === lightbox) lightbox.classList.remove("open");
  });

  // --- comments (your original logic) ---
  const autoId = {{ $auto->id }};
  const apiBase = "/api";

  const listEl = document.getElementById("reviews-list");
  const contentEl = document.getElementById("comment-content");
  const msgEl = document.getElementById("comment-message");
  const formEl = document.getElementById("commentForm");
  const sendBtn = document.getElementById("sendBtn");

  function getToken(){
    return localStorage.getItem("jwt_token") || localStorage.getItem("token") || "";
  }

  function setMsg(text, ok=false){
    msgEl.textContent = text || "";
    msgEl.className = text ? (ok ? "ok" : "err") : "";
  }

  function escapeHtml(str){
    return String(str ?? "")
      .replaceAll("&","&amp;")
      .replaceAll("<","&lt;")
      .replaceAll(">","&gt;")
      .replaceAll('"',"&quot;")
      .replaceAll("'","&#039;");
  }

  async function safeJson(res){
    const ct = res.headers.get("content-type") || "";
    if(ct.includes("application/json")) return await res.json();
    return {};
  }

  async function loadComments(){
    listEl.innerHTML = "<p>Betöltés...</p>";

    try{
      const res = await fetch(`${apiBase}/autok/${autoId}/comments`, {
        headers: { "Accept": "application/json" }
      });

      const data = await safeJson(res);

      if(!res.ok){
        listEl.innerHTML = "<p>Nem sikerült betölteni a véleményeket.</p>";
        return;
      }

      if(!Array.isArray(data) || data.length === 0){
        listEl.innerHTML = "<p>Még nincs vélemény.</p>";
        return;
      }

      listEl.innerHTML = data.map(c => {
        const u = c.user || {};
        const name =
          (u.first_name && u.last_name) ? `${u.first_name} ${u.last_name}` :
          (u.username || "Felhasználó");

        return `
          <div class="review-item">
            <strong>${escapeHtml(name)}</strong>
            <p>${escapeHtml(c.content)}</p>
          </div>
        `;
      }).join("");

    }catch(err){
      listEl.innerHTML = "<p>Nem sikerült betölteni a véleményeket.</p>";
    }
  }

  async function sendComment(){
    setMsg("");

    const token = getToken();
    const content = (contentEl.value || "").trim();

    if(!token){
      setMsg("Kommenteléshez be kell jelentkezned! ");
      return;
    }

    if(content.length < 2){
      setMsg("Írj legalább 2 karaktert.");
      return;
    }

    sendBtn.disabled = true;

    try{
      const res = await fetch(`${apiBase}/autok/${autoId}/comments`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization": "Bearer " + token
        },
        body: JSON.stringify({ content })
      });

      const data = await safeJson(res);

      if(res.status === 401 || res.status === 403){
        localStorage.removeItem("jwt_token");
        localStorage.removeItem("token");
        setMsg("Lejárt / hibás token. Jelentkezz be újra! ");
        return;
      }

      if(!res.ok){
        const errMsg =
          (data?.errors && Object.values(data.errors)?.[0]?.[0]) ||
          data?.message ||
          data?.error ||
          "Hiba a küldésnél.";
        setMsg(errMsg);
        return;
      }

      setMsg(data?.message || "Komment elküldve ", true);
      contentEl.value = "";
      await loadComments();

    }catch(err){
      setMsg("Hálózati hiba történt.");
    }finally{
      sendBtn.disabled = false;
    }
  }

  formEl.addEventListener("submit", (e) => {
    e.preventDefault();
    sendComment();
  });

  loadComments();
});
</script>

</body>
</html>