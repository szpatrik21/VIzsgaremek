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
    <!-- marad a form kinézet/struktúra, csak JS kezeli -->
    <form class="filters" id="filtersForm">
      <div class="filters-row">

        <div class="f">
          <label>Márka</label>
          <select name="marka" id="markaSelect">
            <option value="">Összes</option>
          </select>
        </div>

        <div class="f">
          <label>Állapot</label>
          <select name="allapot" id="allapotSelect">
            <option value="">Összes</option>
          </select>
        </div>

        <div class="f">
          <label>Kivitel</label>
          <select name="kivitel" id="kivitelSelect">
            <option value="">Összes</option>
          </select>
        </div>

        <div class="f">
          <label>Szín</label>
          <select name="szin" id="szinSelect">
            <option value="">Összes</option>
          </select>
        </div>

        <div class="f f-actions">
          <button type="submit" class="btn-filter">Szűrés</button>
          <a class="btn-reset" href="/autok" id="resetBtn">Törlés</a>
        </div>

      </div>
    </form>
  </div>

  <div class="container">
    <div class="carbox" id="carsRoot">
      <p class="no-results">Betöltés...</p>
    </div>
  </div>

</div>

<x-footer />

<script>
document.addEventListener("DOMContentLoaded", () => {
  const apiBase = "/api";

  const form = document.getElementById("filtersForm");
  const carsRoot = document.getElementById("carsRoot");

  const markaSelect = document.getElementById("markaSelect");
  const allapotSelect = document.getElementById("allapotSelect");
  const kivitelSelect = document.getElementById("kivitelSelect");
  const szinSelect = document.getElementById("szinSelect");

  const formatFt = (n) => {
    const num = Number(n || 0);
    return num.toLocaleString("hu-HU") + " Ft";
  };

  const esc = (s) => String(s ?? "")
    .replaceAll("&","&amp;")
    .replaceAll("<","&lt;")
    .replaceAll(">","&gt;")
    .replaceAll('"',"&quot;")
    .replaceAll("'","&#039;");

  const getQuery = () => new URLSearchParams(window.location.search);

  const setSelectOptions = (selectEl, values, selectedValue) => {
    const first = selectEl.querySelector("option[value='']");
    selectEl.innerHTML = "";
    selectEl.appendChild(first);

    (values || []).forEach(v => {
      const opt = document.createElement("option");
      opt.value = v;
      opt.textContent = v;
      if (v === selectedValue) opt.selected = true;
      selectEl.appendChild(opt);
    });
  };

  const applyQueryToSelects = () => {
    const q = getQuery();
    markaSelect.value = q.get("marka") || "";
    allapotSelect.value = q.get("allapot") || "";
    kivitelSelect.value = q.get("kivitel") || "";
    szinSelect.value = q.get("szin") || "";
  };

  const updateUrlFromSelects = () => {
    const q = new URLSearchParams();
    if (markaSelect.value) q.set("marka", markaSelect.value);
    if (allapotSelect.value) q.set("allapot", allapotSelect.value);
    if (kivitelSelect.value) q.set("kivitel", kivitelSelect.value);
    if (szinSelect.value) q.set("szin", szinSelect.value);

    const qs = q.toString();
    const newUrl = qs ? `/autok?${qs}` : `/autok`;
    window.history.pushState({}, "", newUrl);
  };

  async function fetchCarsAndFilters() {
    carsRoot.innerHTML = `<p class="no-results">Betöltés...</p>`;

    const q = getQuery();
    const url = `${apiBase}/autok?${q.toString()}`;

    try {
      const res = await fetch(url, { headers: { "Accept": "application/json" } });
      if (!res.ok) {
        carsRoot.innerHTML = `<p class="no-results">Nem sikerült betölteni az autókat.</p>`;
        return;
      }

      const json = await res.json();

      // autók: lehet {data:[...]} vagy sima [...]
      const autok = Array.isArray(json) ? json : (Array.isArray(json.data) ? json.data : []);

      // szűrők: json.filters.* vagy külön mezők
      const filters = json.filters || {};
      const markak = filters.markak || json.markak || [];
      const allapotok = filters.allapotok || json.allapotok || [];
      const kivitelek = filters.kivitelek || json.kivitelek || [];
      const szinek = filters.szinek || json.szinek || [];

      // selectek frissítése (és az aktuális query kiválasztása)
      const selectedMarka = q.get("marka") || "";
      const selectedAllapot = q.get("allapot") || "";
      const selectedKivitel = q.get("kivitel") || "";
      const selectedSzin = q.get("szin") || "";

      setSelectOptions(markaSelect, markak, selectedMarka);
      setSelectOptions(allapotSelect, allapotok, selectedAllapot);
      setSelectOptions(kivitelSelect, kivitelek, selectedKivitel);
      setSelectOptions(szinSelect, szinek, selectedSzin);

      // autók kirender
      if (!autok.length) {
        carsRoot.innerHTML = `<p class="no-results">Nincs találat a szűrésre.</p>`;
        return;
      }

      carsRoot.innerHTML = autok.map(auto => {
        const kep = auto.kep || "/images/no-image.png";
        const marka = auto.marka || "";
        const modell = auto.modell || "";
        const teljesitmeny = auto.teljesitmeny ?? 0;
        const uzemanyag = auto.uzemanyag || "";
        const ar = formatFt(auto.ar);
        const url = auto.url || (auto.id ? `/autok/${auto.id}` : "#");

        return `
          <div class="carbox1">
            <img src="${esc(kep)}" class="carsbox" alt="${esc(marka)} ${esc(modell)}"
                 onerror="this.onerror=null;this.src='/images/no-image.png';">

            <div class="card-content">
              <p><strong>${esc(marka)} ${esc(modell)}</strong></p>
              <p>${esc(String(teljesitmeny))} LE • ${esc(uzemanyag)}</p>
              <p><b>${esc(ar)}</b></p>

              <a class="yellowbutton" href="${esc(url)}">Érdekel</a>
            </div>
          </div>
        `;
      }).join("");

    } catch (err) {
      console.error(err);
      carsRoot.innerHTML = `<p class="no-results">Hálózati hiba történt.</p>`;
    }
  }

  // form submit -> query frissítés -> API reload
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    updateUrlFromSelects();
    fetchCarsAndFilters();
  });

  // back/forward gomb kezelés
  window.addEventListener("popstate", () => {
    applyQueryToSelects();
    fetchCarsAndFilters();
  });

  // start: query -> select -> fetch
  applyQueryToSelects();
  fetchCarsAndFilters();
});
</script>

</body>
</html>