<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  <title>Autó részletek</title>

  @vite([
    'resources/css/auto.css',
    'resources/css/style3.css',
    'resources/css/navbar.css',
  ])
</head>

<body>
  <x-navbar />

  <main class="wrap">

    <!-- TOP -->
    <div class="top-grid">
      <!-- HERO IMAGE -->
      <div class="hero" id="heroBox">
        <div style="padding:18px;">Betöltés...</div>
      </div>

      <!-- SIDE -->
      <aside class="side">
        <div class="side-inner">

          <img class="mini-img" id="miniImg" src="" alt="" style="display:none;">

          <p class="side-title">Infó / ajánlatkérés</p>
          <p class="price" id="priceEl">—</p>

          <div class="side-actions">
            <a class="btn" href="tel:+36202813595">06 20 281 35 95</a>
            <a href="#" class="btn btn-gold" id="offerBtn">Kérj árajánlatot</a>
          </div>

          <div class="badge">
            <span>Raktáron:</span>
            <b id="stockEl">—</b>
          </div>

        </div>
      </aside>
    </div>

    <!-- TITLE -->
    <div class="title">
      <div>
        <h1 id="titleEl">Betöltés...</h1>
        <p class="subtitle" id="subtitleEl">—</p>
      </div>
    </div>

    <!-- QUICK -->
    <section class="quick" aria-label="Fő adatok">
      <div class="chip">
        <div class="k">Évjárat</div>
        <div class="v" id="yearQuick">—</div>
      </div>
      <div class="chip">
        <div class="k">Hengerűrtartalom</div>
        <div class="v" id="ccmQuick">—</div>
      </div>
      <div class="chip">
        <div class="k">Teljesítmény</div>
        <div class="v gold" id="powerQuick">—</div>
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
            <tr><td>Modell</td><td id="specModell">—</td></tr>
            <tr><td>Évjárat</td><td id="specEvjarat">—</td></tr>
            <tr><td>Kilométeróra</td><td id="specKm">—</td></tr>
            <tr><td>Ajtók száma</td><td id="specAjtok">—</td></tr>
            <tr><td>Üzemanyag</td><td id="specUzemanyag">—</td></tr>
            <tr><td>Teljesítmény</td><td id="specTeljesitmeny">—</td></tr>
          </table>
        </div>

        <div class="spec-card">
          <div class="spec-head">
            <span class="spec-tag">Műszaki</span>
            <span class="spec-muted">Részletek</span>
          </div>
          <table class="spec-table">
            <tr><td>Márka</td><td id="specMarka">—</td></tr>
            <tr><td>Kivitel</td><td id="specKivitel">—</td></tr>
            <tr><td>Állapot</td><td id="specAllapot">—</td></tr>
            <tr><td>Személyek száma</td><td id="specSzemelyek">—</td></tr>
            <tr><td>Szín</td><td id="specSzin">—</td></tr>
            <tr><td>Sebességváltó</td><td id="specValto">—</td></tr>
            <tr><td>Hengerűrtartalom</td><td id="specCcm">—</td></tr>
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

  <x-footer />

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const apiBase = "/api";

      // ID a URL-ből: /autok/16 -> 16
      const getAutoIdFromUrl = () => {
        const parts = window.location.pathname.split("/").filter(Boolean);
        const last = parts[parts.length - 1];
        const id = Number(last);
        return Number.isFinite(id) ? id : null;
      };

      const autoId = getAutoIdFromUrl();
      if (!autoId) {
        console.error("Nem találok autó ID-t az URL-ben.");
        return;
      }

      // elemek
      const heroBox = document.getElementById("heroBox");
      const miniImg = document.getElementById("miniImg");
      const priceEl = document.getElementById("priceEl");
      const stockEl = document.getElementById("stockEl");
      const offerBtn = document.getElementById("offerBtn");

      const titleEl = document.getElementById("titleEl");
      const subtitleEl = document.getElementById("subtitleEl");

      const yearQuick = document.getElementById("yearQuick");
      const ccmQuick = document.getElementById("ccmQuick");
      const powerQuick = document.getElementById("powerQuick");

      const specModell = document.getElementById("specModell");
      const specEvjarat = document.getElementById("specEvjarat");
      const specKm = document.getElementById("specKm");
      const specAjtok = document.getElementById("specAjtok");
      const specUzemanyag = document.getElementById("specUzemanyag");
      const specTeljesitmeny = document.getElementById("specTeljesitmeny");

      const specMarka = document.getElementById("specMarka");
      const specKivitel = document.getElementById("specKivitel");
      const specAllapot = document.getElementById("specAllapot");
      const specSzemelyek = document.getElementById("specSzemelyek");
      const specSzin = document.getElementById("specSzin");
      const specValto = document.getElementById("specValto");
      const specCcm = document.getElementById("specCcm");

      // komment elemek
      const listEl = document.getElementById("reviews-list");
      const contentEl = document.getElementById("comment-content");
      const msgEl = document.getElementById("comment-message");
      const formEl = document.getElementById("commentForm");
      const sendBtn = document.getElementById("sendBtn");

      const formatFt = (n) => {
        const num = Number(n || 0);
        return num.toLocaleString("hu-HU") + " Ft";
      };

      const formatKm = (n) => {
        const num = Number(n || 0);
        return num.toLocaleString("hu-HU") + " km";
      };

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

      async function loadCar(){
        try{
          const res = await fetch(`${apiBase}/autok/${autoId}`, {
            headers: { "Accept": "application/json" }
          });

          if(!res.ok){
            heroBox.innerHTML = `<div style="padding:18px;">Nem sikerült betölteni az autót.</div>`;
            return;
          }

          const a = await res.json();

          // title
          const fullTitle = `${a.marka || ""} ${a.modell || ""}`.trim() || "Autó részletek";
          document.title = fullTitle;
          titleEl.textContent = fullTitle;

          subtitleEl.textContent = `${a.evjarat ?? "—"} · ${a.uzemanyag ?? "—"} · ${a.szin ?? "—"}`;

          // hero kép
          const heroImg = a.kep || "/images/no-image.png";
          heroBox.innerHTML = `<img src="${heroImg}" alt="${escapeHtml(fullTitle)}" onerror="this.onerror=null;this.src='/images/no-image.png';">`;

          // mini kép
          if(a.kep2){
            miniImg.src = a.kep2;
            miniImg.alt = fullTitle;
            miniImg.style.display = "block";
            miniImg.onerror = () => { miniImg.style.display = "none"; };
          } else {
            miniImg.style.display = "none";
          }

          // ár + raktár
          priceEl.textContent = formatFt(a.ar);
          const stock = Number(a.raktaron ?? 0);
          stockEl.textContent = stock > 0 ? `${stock} db` : "Nincs raktáron";

          // ajánlat gomb URL (állítsd a route-odra, ha más)
          offerBtn.href = `/offer/${autoId}`;

          // quick
          yearQuick.textContent = a.evjarat ?? "—";
          ccmQuick.textContent = (a.hengerurtartalom ?? "—") + " ccm";
          powerQuick.textContent = (a.teljesitmeny ?? "—") + " LE";

          // spec
          specMarka.textContent = a.marka ?? "—";
          specModell.textContent = a.modell ?? "—";
          specEvjarat.textContent = a.evjarat ?? "—";
          specKm.textContent = formatKm(a.kilometerora);
          specAjtok.textContent = a.ajtok_szama ?? "—";
          specUzemanyag.textContent = a.uzemanyag ?? "—";
          specTeljesitmeny.textContent = (a.teljesitmeny ?? "—") + " LE";

          specKivitel.textContent = a.kivitel ?? "—";
          specAllapot.textContent = a.allapot ?? "—";
          specSzemelyek.textContent = a.szemelyek_szama ?? "—";
          specSzin.textContent = a.szin ?? "—";
          specValto.textContent = a.sebessegvalto ?? "—";
          specCcm.textContent = (a.hengerurtartalom ?? "—") + " ccm";

        } catch(err){
          console.error("Car fetch error:", err);
          heroBox.innerHTML = `<div style="padding:18px;">Hálózati hiba az autó betöltésénél.</div>`;
        }
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

          const arr = Array.isArray(data) ? data : (Array.isArray(data.data) ? data.data : []);

          if(arr.length === 0){
            listEl.innerHTML = "<p>Még nincs vélemény.</p>";
            return;
          }

          listEl.innerHTML = arr.map(c => {
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

      // indulás
      loadCar();
      loadComments();
    });
  </script>

</body>
</html>