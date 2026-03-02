<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  <title>Regisztráció</title>

  @vite([
    'resources/css/navbar.css'
  ])

  <style>
    :root{
      --bg:#0f0f0f;
      --panel:#141414;
      --panel2:#1a1a1a;
      --text:#f5f5f5;
      --muted:rgba(255,255,255,.70);
      --border:rgba(255,255,255,.10);
      --gold:#d4af37;
      --gold2:#e6c35c;
    }

    *{ box-sizing:border-box; }

    body{
      margin:0;
      background: var(--bg);
      color: var(--text);
      font-family: "Space Grotesk", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    /* ✅ csak ezen az oldalon finom override a navbarhoz */
    body.register-page{
      padding-top: 64px;
    }
    body.register-page .navbar{
      height: 64px;
      padding: 0 40px;
    }

    /* ===== LAYOUT ===== */
    .register-wrapper{
      min-height: calc(100vh - 64px);
      display:grid;
      grid-template-columns: 1.1fr .9fr;
    }

    /* BAL OLDAL (KÉP + OVERLAY) */
    .register-left{
      position:relative;
      background:
        linear-gradient(120deg, rgba(0,0,0,.65), rgba(0,0,0,.30)),
        url('{{ asset("images/porsche-4795517.jpg") }}') center/cover no-repeat;
      display:flex;
      align-items:flex-end;
      padding: 48px;
      border-right: 1px solid rgba(255,255,255,.06);
    }

    .brand-box{
      max-width: 520px;
      background: rgba(0,0,0,.35);
      border: 1px solid rgba(255,255,255,.10);
      backdrop-filter: blur(10px);
      border-radius: 18px;
      padding: 26px 24px;
      box-shadow: 0 24px 80px rgba(0,0,0,.55);
    }

    .brand-box h1{
      margin:0 0 10px;
      font-family:"Playfair Display", serif;
      font-weight:800;
      letter-spacing:.2px;
      font-size: 34px;
      line-height: 1.15;
    }

    .brand-box p{
      margin:0;
      color: rgba(255,255,255,.78);
      font-size: 15px;
      line-height: 1.6;
    }

    .brand-pills{
      margin-top: 16px;
      display:flex;
      gap:10px;
      flex-wrap:wrap;
    }

    .pill{
      font-size: 12px;
      color: rgba(255,255,255,.78);
      border: 1px solid rgba(255,255,255,.12);
      background: rgba(255,255,255,.04);
      padding: 8px 10px;
      border-radius: 999px;
      letter-spacing: .2px;
    }

    /* JOBB OLDAL (FORM) */
    .register-right{
      display:flex;
      align-items:center;
      justify-content:center;
      padding: 48px 20px;
      background:
        radial-gradient(800px 400px at 20% 10%, rgba(212,175,55,.10), transparent 55%),
        radial-gradient(700px 380px at 90% 70%, rgba(255,210,48,.06), transparent 60%),
        var(--bg);
    }

    .form-shell{
      width: 440px;
      max-width: 100%;
    }

    .form-shell h2{
      margin:0 0 10px;
      font-family:"Playfair Display", serif;
      font-size: 32px;
      letter-spacing:.2px;
    }

    .form-shell .sub{
      margin:0 0 18px;
      color: rgba(255,255,255,.70);
      font-size: 14px;
      line-height: 1.5;
    }

    form{
      width: 100%;
      background: rgba(255,255,255,.03);
      border: 1px solid rgba(255,255,255,.10);
      backdrop-filter: blur(10px);
      padding: 22px;
      border-radius: 16px;
      box-shadow: 0 18px 70px rgba(0,0,0,.55);
    }

    .grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .field{
      display:flex;
      flex-direction:column;
      gap:6px;
      margin-bottom: 12px;
    }

    .field.full{ grid-column: 1 / -1; }

    label{
      font-weight:700;
      font-size:13px;
      color: rgba(255,255,255,.86);
      letter-spacing:.2px;
    }

    input{
      width:100%;
      height:44px;
      padding: 10px 12px;
      border-radius: 10px;
      font-size: 14px;
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.14);
      color:#fff;
      transition: .18s ease;
      outline:none;
    }

    input:focus{
      border-color: rgba(212,175,55,.65);
      box-shadow: 0 0 0 3px rgba(212,175,55,.15);
      background: rgba(255,255,255,.07);
    }

    button{
      width:100%;
      height:46px;
      margin-top: 6px;
      background: var(--gold);
      color:#000;
      border:none;
      border-radius: 12px;
      cursor:pointer;
      font-size: 15px;
      font-weight: 900;
      letter-spacing:.2px;
      transition:.18s ease;
    }

    button:hover{ background: var(--gold2); transform: translateY(-1px); }

    #msg{
      margin-top: 12px;
      text-align:center;
      font-weight:800;
      font-size: 14px;
    }
    #msg.error{ color:#ff5c5c; }
    #msg.success{ color:#66ff99; }

    /* MOBIL */
    @media (max-width: 980px){
      body.register-page .navbar{ padding: 0 20px; }
      .register-wrapper{
        grid-template-columns: 1fr;
      }
      .register-left{
        min-height: 240px;
        padding: 24px;
        border-right: none;
        border-bottom: 1px solid rgba(255,255,255,.06);
        align-items:flex-end;
      }
      .brand-box h1{ font-size: 26px; }
      .register-right{ padding: 30px 16px; }
      .grid{ grid-template-columns: 1fr; }
    }
  </style>
</head>

<body class="register-page">
  <x-navbar />

  <div class="register-wrapper">

    <!-- BAL OLDAL -->
    <div class="register-left">
      <div class="brand-box">
        <h1>Csatlakozz a LuxCar világához</h1>
        <p>Hozz létre fiókot, és kérj ajánlatot prémium modellekre gyorsan, egyszerűen. </p>

        <div class="brand-pills">
          <span class="pill">Prémium modellek</span>
          <span class="pill">Gyors ajánlatkérés</span>
          <span class="pill">Egyszerű kezelés</span>
        </div>
      </div>
    </div>

    <!-- JOBB OLDAL -->
    <div class="register-right">
      <div class="form-shell">
        <h2>Regisztráció</h2>
        <p class="sub">Add meg az adataidat, és már mehetsz is válogatni a kiemelt autók között. </p>

        <form id="registerForm" novalidate>
          <div class="grid">
            <div class="field full">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" required />
            </div>

            <div class="field full">
              <label for="username">Felhasználónév</label>
              <input type="text" id="username" name="username" required />
            </div>

            <div class="field">
              <label for="last_name">Vezetéknév</label>
              <input type="text" id="last_name" name="last_name" required />
            </div>

            <div class="field">
              <label for="first_name">Keresztnév</label>
              <input type="text" id="first_name" name="first_name" required />
            </div>

            <div class="field full">
              <label for="password">Jelszó</label>
              <input type="password" id="password" name="password" required />
            </div>

            <div class="field">
              <label for="phone">Telefonszám</label>
              <input type="tel" id="phone" name="phone" required />
            </div>

            <div class="field">
              <label for="birthdate">Születési dátum</label>
              <input type="date" id="birthdate" name="birthdate" required />
            </div>

            <div class="field full">
              <label for="address">Lakóhely</label>
              <input type="text" id="address" name="address" required />
            </div>
          </div>

          <button type="submit">Regisztráció</button>

          <p id="msg"></p>
        </form>
      </div>
    </div>

  </div>

  <script>
    document.getElementById("registerForm").addEventListener("submit", async (e) => {
      e.preventDefault();

      const msg = document.getElementById("msg");
      msg.textContent = "";
      msg.className = "";

      const payload = {
        email: document.getElementById("email").value.trim(),
        username: document.getElementById("username").value.trim(),
        last_name: document.getElementById("last_name").value.trim(),
        first_name: document.getElementById("first_name").value.trim(),
        password: document.getElementById("password").value,
        phone: document.getElementById("phone").value.trim(),
        birthdate: document.getElementById("birthdate").value,
        address: document.getElementById("address").value.trim(),
      };

      try {
        const res = await fetch("/api/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
          },
          body: JSON.stringify(payload),
        });

        const contentType = res.headers.get("content-type") || "";
        let data = {};

        if (contentType.includes("application/json")) {
          data = await res.json();
        } else {
          const text = await res.text();
          console.log("Nem JSON válasz:", text);
          msg.textContent = "Szerver hiba történt.";
          msg.className = "error";
          return;
        }

        if (!res.ok) {
          if (data.errors) {
            const firstKey = Object.keys(data.errors)[0];
            msg.textContent = data.errors[firstKey][0];
          } else {
            msg.textContent = data.message || "Hiba történt a regisztrációnál!";
          }
          msg.className = "error";
          return;
        }

        msg.textContent = data.message || "Sikeres regisztráció! ✅";
        msg.className = "success";

        document.getElementById("registerForm").reset();

        setTimeout(() => {
          window.location.href = "/login";
        }, 1200);

      } catch (err) {
        console.error(err);
        msg.textContent = "Hálózati hiba történt.";
        msg.className = "error";
      }
    });
  </script>
</body>
</html>