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
  ])

  <style>
    :root{
  --font-body: "Space Grotesk", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  --font-display: "Playfair Display", Georgia, serif;

  --bg:#000;

  /* Élénkebb, “glow”-os rendszer */
  --text: rgba(255,255,255,.94);
  --muted: rgba(255,255,255,.72);

  --gold:#d4af37;
  --gold2:#f2d06a;

  /* panelek világosabbak */
  --panel: rgba(255,255,255,.06);
  --panel2: rgba(255,255,255,.045);

  /* keretek élénkebbek */
  --line: rgba(255,255,255,.18);

  /* prémium árnyék + arany peremfény */
  --shadow: 0 22px 70px rgba(0,0,0,.72);


  --radius: 18px;
  --container: 1280px;
  --pad: 18px;
}

    *{ box-sizing: border-box; }
    body{
      margin:0;
      font-family: var(--font-body);
      background: var(--bg);
      color: var(--text);
    }

    /* ====== LAYOUT WRAPPER ====== */
    .wrap{
      max-width: var(--container);
      margin: 0 auto;
      padding: 26px var(--pad) 80px;
    }

    /* ====== TOP GRID ====== */
    .top-grid{
      display:grid;
      grid-template-columns: 1.6fr .95fr;
      gap: 18px;
      align-items: start;
    }

    /* ====== HERO IMAGE ====== */
    .hero{
      border: 1px solid var(--line);
      border-radius: var(--radius);
      overflow:hidden;
      background: #000;
      box-shadow: var(--shadow);
    }
    .hero img{
      width:100%;
      height: 520px;
      object-fit: cover;
      display:block;
      filter: saturate(1.05) contrast(1.05);
    }

    /* ====== SIDE CARD ====== */
    .side{
      border: 1px solid var(--line);
      border-radius: var(--radius);
      background: var(--panel);
      box-shadow: var(--shadow);
      overflow:hidden;
    }
    .side-inner{ padding: 16px; }

    .mini-img{
      width:100%;
      height: 160px;
      object-fit: cover;
      border-radius: 14px;
      border: 1px solid rgba(255,255,255,.10);
      display:block;
      margin-bottom: 12px;
    }

    .side-title{
      margin: 0 0 8px;
      font-family: var(--font-display);
      font-weight: 800;
      letter-spacing: .2px;
      font-size: 20px;
    }

    .price{
      margin: 0 0 12px;
      font-size: 30px;
      font-weight: 950;
      color: var(--gold2);
      text-shadow: 0 0 22px rgba(212,175,55,.18);
    }

    .side-actions{
      display:grid;
      gap: 10px;
      margin: 10px 0 12px;
    }

    .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      text-decoration:none;
      font-weight: 900;
      border-radius: 14px;
      padding: 12px 14px;
      transition: .15s ease;
      cursor:pointer;
      border: 1px solid rgba(255,255,255,.16);
      background: rgba(0,0,0,.35);
      color: var(--text);
    }
    .btn:hover{
      transform: translateY(-1px);
      border-color: rgba(242,208,106,.35);
    }

.btn-gold{
  background: linear-gradient(180deg, #e6c66b, #caa23a);
  color:#000;
  font-weight: 950;
  border: 1px solid rgba(0,0,0,.25);
  box-shadow: 0 8px 22px rgba(0,0,0,.45);
}

.btn-gold:hover{
  transform: translateY(-1px);
  filter: brightness(1.04);
}

    .badge{
      display:flex;
      justify-content: space-between;
      gap: 10px;
      padding: 12px;
      border-radius: 14px;
      border: 1px solid rgba(255,255,255,.10);
      background: var(--panel2);
      font-weight: 900;
      color: rgba(255,255,255,.78);
      margin-top: 10px;
    }
    .badge b{ color:#fff; }

    /* ====== TITLE ROW ====== */
    .title{
      margin-top: 22px;
      padding-bottom: 14px;
      border-bottom: 1px solid var(--line);
      display:flex;
      justify-content: space-between;
      align-items:flex-end;
      gap: 16px;
    }
    .title h1{
      margin:0;
      font-family: var(--font-display);
      font-size: 40px;
      font-weight: 800;
      letter-spacing:.2px;
    }
    .subtitle{
      margin: 10px 0 0;
      color: var(--muted);
      font-weight: 800;
      line-height: 1.4;
    }

    /* ====== QUICK SPECS ====== */
    .quick{
      margin-top: 18px;
      display:grid;
      grid-template-columns: repeat(3, minmax(0,1fr));
      gap: 10px;
    }
    .chip{
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 16px;
      background: rgba(255,255,255,.03);
      padding: 14px;
      transition: .15s ease;
    }
    .chip:hover{
      transform: translateY(-1px);
      border-color: rgba(242,208,106,.25);
    }
    .chip .k{
      color: rgba(255,255,255,.65);
      font-weight: 900;
      font-size: 12px;
      letter-spacing:.2px;
    }
    .chip .v{
      margin-top: 8px;
      font-weight: 950;
      font-size: 16px;
    }
    .chip .v.gold{ color: var(--gold2); }

    /* ====== SECTION TITLE (white label) ====== */
    .label{
      display:inline-block;
      background:dark;
      color:white;
      padding: 8px 14px;
      border-radius: 12px;
      font-family: var(--font-display);
      font-weight: 900;
      font-size: 28px;
      letter-spacing:.2px;
    }

    /* ====== SPECS ====== */
    .section{ margin-top: 52px; }

    .spec-grid{
      margin-top: 18px;
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .spec-card{
      border: 1px solid rgba(255,255,255,.12);
      border-radius: var(--radius);
      background: rgba(255,255,255,.03);
      overflow:hidden;
    }

    .spec-head{
      padding: 14px 16px;
      border-bottom: 1px solid rgba(255,255,255,.10);
      display:flex;
      justify-content: space-between;
      align-items:center;
    }
    .spec-tag{
      display:inline-block;
      background:#fff;
      color:#000;
      padding: 6px 12px;
      border-radius: 12px;
      font-weight: 900;
      font-family: var(--font-display);
    }
    .spec-muted{
      color: rgba(255,255,255,.62);
      font-weight: 900;
      font-size: 12px;
      letter-spacing:.2px;
    }

    .spec-table{
      width:100%;
      border-collapse: collapse;
      font-family: var(--font-body);
    }
    .spec-table td{
      padding: 12px 16px;
      border-bottom: 1px solid rgba(255,255,255,.08);
      font-size: 14px;
    }
    .spec-table td:first-child{
      width: 46%;
      color: rgba(255,255,255,.68);
      font-weight: 900;
    }
    .spec-table tr:last-child td{ border-bottom:0; }

    /* ====== REVIEWS ====== */
    .reviews{
      margin-top: 60px;
      border-top: 1px solid var(--line);
      padding-top: 34px;
    }

    .reviews-grid{
      margin-top: 18px;
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .reviews-list,
    .reviews-form{
      border: 1px solid rgba(255,255,255,.12);
      border-radius: var(--radius);
      background: rgba(255,255,255,.03);
      padding: 16px;
    }

    .reviews-list{
      max-height: 420px;
      overflow:auto;
    }

    .review-item{
      border:1px solid rgba(255,255,255,.10);
      border-radius: 14px;
      padding: 14px;
      background: rgba(0,0,0,.35);
      margin-bottom: 12px;
      transition:.15s ease;
    }
    .review-item:hover{ border-color: rgba(242,208,106,.22); transform: translateY(-1px); }

    .review-item strong{
      font-family: var(--font-display);
      font-weight: 800;
      letter-spacing:.2px;
      display:block;
      color: var(--gold2);
    }
    .review-item p{
      margin: 8px 0 0;
      color: rgba(255,255,255,.78);
      line-height: 1.5;
      font-family: var(--font-body);
    }

    .reviews-form{
      display:flex;
      flex-direction: column;
      gap: 10px;
    }
    .reviews-form textarea{
      height: 150px;
      padding: 12px;
      border-radius: 14px;
      background: rgba(0,0,0,.55);
      border: 1px solid rgba(255,255,255,.14);
      color:#fff;
      outline:none;
      resize:none;
      font-family: var(--font-body);
    }
    .reviews-form textarea::placeholder{ color: rgba(255,255,255,.40); }

    .reviews-form button{
      width:100%;
      padding: 12px;
      border-radius: 14px;
      border:0;
      font-weight: 950;
      background: var(--gold2);
      color:#000;
      cursor:pointer;
      transition:.15s ease;
      font-family: var(--font-body);
      letter-spacing:.2px;
    }
    .reviews-form button:hover{ background:#ffe08a; transform: translateY(-1px); }

    #comment-message{ font-weight:900; margin:0; }
    #comment-message.ok{ color:#66ff99; }
    #comment-message.err{ color:#ff5c5c; }

    /* ===== FOOTER ===== */
    .footer{
      background: #0a0a0a;
      border-top: 1px solid rgba(212,175,55,.15);
      margin-top: 80px;
      padding: 60px 0 0;
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
      font-family: var(--font-body);
    }

    .footer-col a:hover{ color: var(--gold); }

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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1100px){
      .top-grid{ grid-template-columns: 1fr; }
      .hero img{ height: 420px; }
      .title h1{ font-size: 34px; }
      .spec-grid{ grid-template-columns: 1fr; }
      .reviews-grid{ grid-template-columns: 1fr; }
      .footer-inner{ grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 700px){
      .hero img{ height: 320px; }
      .title{ flex-direction: column; align-items:flex-start; }
      .quick{ grid-template-columns: 1fr; }
      .footer-inner{ grid-template-columns: 1fr; padding: 0 22px; }
    }


    /* ===== GLOBAL PANEL LOOK ===== */
.hero,
.side,
.spec-card,
.reviews-list,
.reviews-form,
.chip{
  background: linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.03));
  border: 1px solid rgba(255,255,255,.18);
  box-shadow: var(--shadow);
}

.hero{
  box-shadow: var(--shadow), var(--glow);
}

.side{
  box-shadow: var(--shadow), 0 0 0 1px rgba(255,255,255,.06), 0 20px 50px rgba(0,0,0,.65);
}

/* hover: arany perem + kis lift */
.side:hover,
.spec-card:hover,
.reviews-list:hover,
.reviews-form:hover,
.chip:hover{
  border-color: rgba(242,208,106,.38);
  box-shadow: var(--shadow), 0 0 0 1px rgba(242,208,106,.18), 0 18px 50px rgba(212,175,55,.12);
  transform: translateY(-1px);
  transition: .18s ease;
}

/* ===== SPEC HEAD kicsit “fényesebb” ===== */
.spec-head{
  background: rgba(255,255,255,.04);
}

/* ===== LABEL (Jellemzők / Vélemények) – végre ne “dark” legyen lol ===== */
.label{
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(242,208,106,.28);
  box-shadow: 0 0 0 1px rgba(255,255,255,.06), 0 14px 40px rgba(212,175,55,.10);
}

/* ===== BUTTONS élénkebb ===== */
.btn{
  border: 1px solid rgba(255,255,255,.22);
  background: rgba(255,255,255,.06);
}
.btn:hover{
  border-color: rgba(242,208,106,.45);
  box-shadow: 0 0 0 1px rgba(242,208,106,.18);
}

.btn-gold{
  background: linear-gradient(180deg, #ffe08a, #d4af37);
  box-shadow: 0 0 0 1px rgba(242,208,106,.20), 0 16px 40px rgba(212,175,55,.16);
}
.btn-gold:hover{
  background: linear-gradient(180deg, #fff0b5, #e0bb45);
}

/* ===== REVIEW ITEM kerete is élénkebb ===== */
.review-item{
  border: 1px solid rgba(255,255,255,.16);
  background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(0,0,0,.35));
}

.spec-table tr:nth-child(even) td{
  background: rgba(255,255,255,.03);
}
.review-item:hover{
  border-color: rgba(242,208,106,.35);
  box-shadow: 0 0 0 1px rgba(242,208,106,.12);
}

/* ===== MINI IMG keret ===== */
.mini-img{
  border: 1px solid rgba(242,208,106,.22);
  box-shadow: 0 14px 40px rgba(0,0,0,.55);
}
  </style>
</head>

<body>
  <x-navbar />

  <main class="wrap">

    <!-- TOP -->
    <div class="top-grid">
      <!-- HERO IMAGE -->
      <div class="hero">
        @if(!empty($auto->kep))
          <img src="{{ asset($auto->kep) }}" alt="{{ $auto->marka }} {{ $auto->modell }}">
        @else
          <div style="padding:18px;">Nincs kép</div>
        @endif
      </div>

      <!-- SIDE -->
      <aside class="side">
        <div class="side-inner">

          @if(!empty($auto->kep2))
            <img class="mini-img" src="{{ asset($auto->kep2) }}" alt="{{ $auto->marka }} {{ $auto->modell }}">
          @endif

          <p class="side-title">Infó / ajánlatkérés</p>
          <p class="price">{{ number_format($auto->ar, 0, ',', ' ') }} Ft</p>

          <div class="side-actions">
            <a class="btn" href="tel:+36202813595">06 20 281 35 95</a>
            <a href="{{ route('offer.create', $auto) }}" class="btn btn-gold">Kérj árajánlatot</a>
          </div>

          <div class="badge">
            <span>Raktáron:</span>
            <b>
              @if($auto->raktaron > 0)
                {{ $auto->raktaron }} db
              @else
                Nincs raktáron
              @endif
            </b>
          </div>

        </div>
      </aside>
    </div>

    <!-- TITLE -->
    <div class="title">
      <div>
        <h1>{{ $auto->marka }} {{ $auto->modell }}</h1>
        <p class="subtitle">{{ $auto->evjarat }} · {{ $auto->uzemanyag }} · {{ $auto->szin }}</p>
      </div>
    </div>

    <!-- QUICK -->
    <section class="quick" aria-label="Fő adatok">
      <div class="chip">
        <div class="k">Évjárat</div>
        <div class="v">{{ $auto->evjarat }}</div>
      </div>
      <div class="chip">
        <div class="k">Hengerűrtartalom</div>
        <div class="v">{{ $auto->hengerurtartalom }} ccm</div>
      </div>
      <div class="chip">
        <div class="k">Teljesítmény</div>
        <div class="v gold">{{ $auto->teljesitmeny }} LE</div>
      </div>
    </section>

    <!-- SPECS -->
    <section class="section">
      <div class="label">Jellemzők</div>

      <div class="spec-grid">
        <div class="spec-card">
          <div class="spec-head">
            <span class="spec-tag">Alapadatok</span>
            <span class="spec-muted">Részletek</span>
          </div>
          <table class="spec-table">
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
            <span class="spec-tag">Műszaki</span>
            <span class="spec-muted">Részletek</span>
          </div>
          <table class="spec-table">
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
    </section>

    <!-- REVIEWS -->
    <section class="reviews">
      <div class="label">Vélemények</div>

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

  </main>

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

  <script>
    document.addEventListener("DOMContentLoaded", () => {
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
          setMsg("Kommenteléshez be kell jelentkezned! 🔒");
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
            setMsg("Lejárt / hibás token. Jelentkezz be újra! 🔒");
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

          setMsg(data?.message || "Komment elküldve ✅", true);
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