
    document.addEventListener("DOMContentLoaded", () => {
      const reveals = document.querySelectorAll(".reveal");

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("active");
          }
        });
      }, { threshold: 0.15 });

      reveals.forEach(el => observer.observe(el));
    });

    document.addEventListener("DOMContentLoaded", () => {
      const slides = document.querySelectorAll(".slider img");

      if (slides.length) {
        let current = 0;

        const showSlide = (i) => {
          slides.forEach(s => s.classList.remove("active"));
          slides[i].classList.add("active");
        };

        showSlide(0);

        setInterval(() => {
          current = (current + 1) % slides.length;
          showSlide(current);
        }, 5000);
      }

      const counters = document.querySelectorAll(".countup");
      if (!counters.length) return;

      const runOnce = new WeakSet();

      const animateCount = (el) => {
        const target = Number(el.dataset.target || 0);
        const suffix = el.dataset.suffix || "";
        const duration = 900;
        const startTime = performance.now();

        const step = (now) => {
          const progress = Math.min((now - startTime) / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          const value = Math.round(target * eased);

          el.textContent = value.toLocaleString("hu-HU") + suffix;

          if (progress < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          const el = entry.target;
          if (runOnce.has(el)) return;

          runOnce.add(el);
          animateCount(el);
        });
      }, { threshold: 0.35 });

      counters.forEach(c => observer.observe(c));
    });

    document.addEventListener("DOMContentLoaded", async () => {
      const root = document.getElementById("featuredCars");
      if (!root) return;

      const formatFt = (n) => {
        const num = Number(n || 0);
        return num.toLocaleString("hu-HU") + " Ft";
      };

      try {
        const res = await fetch("/api/featured-cars", {
          method: "GET",
          headers: {
            "Accept": "application/json"
          }
        });

        if (!res.ok) {
          throw new Error("HTTP hiba: " + res.status);
        }

        const autok = await res.json();

        if (!Array.isArray(autok) || autok.length === 0) {
          root.innerHTML = `<div class="api-msg">Jelenleg nincs kiemelt autó.</div>`;
          return;
        }

        root.innerHTML = autok.map((auto) => {
          const kep = auto.kep || "/images/no-image.png";
          const marka = auto.marka || "";
          const modell = auto.modell || "";
          const teljesitmeny = auto.teljesitmeny ?? 0;
          const uzemanyag = auto.uzemanyag || "";
          const ar = formatFt(auto.ar);
          const url = auto.url || `/autok/${auto.id}`;

          return `
            <div class="carbox1 reveal">
              <img
                src="${kep}"
                class="carsbox"
                alt="${marka} ${modell}"
                onerror="this.onerror=null;this.src='/images/no-image.png';"
              >

              <div class="card-content">
                <p class="card-title">${marka} ${modell}</p>
                <p class="card-spec">${teljesitmeny} LE • ${uzemanyag}</p>
                <p class="card-price">${ar}</p>

                <a class="yellowbutton" href="${url}">
                  Érdekel
                </a>
              </div>
            </div>
          `;
        }).join("");

        const reveals = document.querySelectorAll(".reveal");
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add("active");
            }
          });
        }, { threshold: 0.15 });

        reveals.forEach(el => observer.observe(el));
      } catch (error) {
        console.error("Nem sikerült betölteni a kiemelt autókat:", error);
        root.innerHTML = `<div class="api-msg">Nem sikerült betölteni a kiemelt autókat.</div>`;
      }
    });
