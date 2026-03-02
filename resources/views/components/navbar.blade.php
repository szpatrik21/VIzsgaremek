
<nav class="navbar">
  <div class="navbar-left">
    <div class="yel3">
      <h1>LuxCar</h1>
    </div>

    <a href="{{ route('main') }}" 
       class="nav-link {{ request()->routeIs('main') ? 'is-active' : '' }}">
       Kezdőoldal
    </a>

    <a href="{{ route('autok.index') }}" 
       class="nav-link {{ request()->routeIs('autok.*') ? 'is-active' : '' }}">
       Autók
    </a>

    <a href="{{ route('contact') }}" 
       class="nav-link {{ request()->routeIs('contact') ? 'is-active' : '' }}">
       Kapcsolat
    </a>

    <!-- ✅ GYIK MENÜ -->
    <a href="{{ route('gyik') }}" 
       class="nav-link {{ request()->routeIs('gyik') ? 'is-active' : '' }}">
       GYIK
    </a>
  </div>

  <!-- HAMBURGER -->
  <button class="hamburger" id="hamburger"
          aria-label="Menü"
          aria-controls="mobileMenu"
          aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>

  <!-- BACKDROP -->
  <div class="menu-backdrop" id="menuBackdrop"></div>

  <!-- MOBIL MENÜ -->
  <aside class="mobile-menu" id="mobileMenu" aria-hidden="true">
    <div class="mobile-menu__head">
      <div class="mobile-brand">LuxCar</div>
      <button class="menu-close" id="menuClose" aria-label="Bezárás">✕</button>
    </div>

    <nav class="mobile-menu__links">
      <a href="{{ route('main') }}" class="nav-link {{ request()->routeIs('main') ? 'is-active' : '' }}">Kezdőoldal</a>
      <a href="{{ route('autok.index') }}" class="nav-link {{ request()->routeIs('autok.*') ? 'is-active' : '' }}">Autók</a>
      <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'is-active' : '' }}">Kapcsolat</a>

      <!-- ✅ GYIK MOBILON IS -->
      <a href="{{ route('gyik') }}" class="nav-link {{ request()->routeIs('gyik') ? 'is-active' : '' }}">GYIK</a>
    </nav>

    <div class="mobile-menu__auth">
      <div class="auth-buttons" id="guestAuthMobile" style="display:none;">
        <a href="{{ route('login') }}" class="btn-auth btn-login">Bejelentkezés</a>
        <a href="{{ route('register') }}" class="btn-auth btn-register">Regisztráció</a>
      </div>

      <div class="userbox" id="userBoxMobile" style="display:none;">
        <a href="/profile" class="profile-link" id="profileNameMobile">Profil</a>
        <a href="#" class="logout-link" id="logoutBtnMobile">Kijelentkezés</a>
      </div>
    </div>
  </aside>

  <div class="navbar-right">

    <div class="auth-buttons" id="guestAuth" style="display:none;">
      <a href="{{ route('login') }}" class="btn-auth btn-login">
        Bejelentkezés
      </a>
      <a href="{{ route('register') }}" class="btn-auth btn-register">
        Regisztráció
      </a>
    </div>

    <div class="userbox" id="userBox" style="display:none;">
      <a href="/profile" class="profile-link" id="profileName"><b>Profil</b></a>
      <a href="#" class="logout-link" id="logoutBtn">Kijelentkezés</a>
    </div>

  </div>
</nav>
<script>
document.addEventListener("DOMContentLoaded", async () => {
  // ===== DESKTOP AUTH ELEMEK (MEGLÉVŐK) =====
  const guestAuth = document.getElementById("guestAuth");
  const userBox = document.getElementById("userBox");
  const profileName = document.getElementById("profileName");
  const logoutBtn = document.getElementById("logoutBtn");

  // ===== MOBILE AUTH ELEMEK (ÚJAK) =====
  const guestAuthMobile = document.getElementById("guestAuthMobile");
  const userBoxMobile = document.getElementById("userBoxMobile");
  const profileNameMobile = document.getElementById("profileNameMobile");
  const logoutBtnMobile = document.getElementById("logoutBtnMobile");

  // ===== HAMBURGER ELEMEK =====
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobileMenu");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const menuClose = document.getElementById("menuClose");

  const openMenu = () => {
    hamburger?.classList.add("is-open");
    mobileMenu?.classList.add("is-open");
    menuBackdrop?.classList.add("is-open");
    hamburger?.setAttribute("aria-expanded", "true");
    mobileMenu?.setAttribute("aria-hidden", "false");
  };

  const closeMenu = () => {
    hamburger?.classList.remove("is-open");
    mobileMenu?.classList.remove("is-open");
    menuBackdrop?.classList.remove("is-open");
    hamburger?.setAttribute("aria-expanded", "false");
    mobileMenu?.setAttribute("aria-hidden", "true");
  };

  hamburger?.addEventListener("click", () => {
    mobileMenu.classList.contains("is-open") ? closeMenu() : openMenu();
  });

  menuBackdrop?.addEventListener("click", closeMenu);
  menuClose?.addEventListener("click", closeMenu);

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMenu();
  });

  mobileMenu?.querySelectorAll("a").forEach(a => {
    a.addEventListener("click", closeMenu);
  });

  // ===== AUTH LOGIKA =====
  const token = localStorage.getItem("jwt_token");

  const showGuest = () => {
    guestAuth.style.display = "flex";
    userBox.style.display = "none";

    guestAuthMobile.style.display = "flex";
    userBoxMobile.style.display = "none";
  };

  const showUser = (fullName) => {
    guestAuth.style.display = "none";
    userBox.style.display = "flex";
    profileName.textContent = fullName;

    guestAuthMobile.style.display = "none";
    userBoxMobile.style.display = "flex";
    profileNameMobile.textContent = fullName;
  };

  // első render: ne villanjon
  guestAuth.style.display = "none";
  userBox.style.display = "none";
  guestAuthMobile.style.display = "none";
  userBoxMobile.style.display = "none";

  if (!token) {
    showGuest();
  } else {
    try {
      const res = await fetch("/api/user", {
        headers: {
          "Authorization": "Bearer " + token,
          "Accept": "application/json"
        }
      });

      if (!res.ok) {
        localStorage.removeItem("jwt_token");
        showGuest();
      } else {
        const user = await res.json();
        showUser(`${user.first_name} ${user.last_name}`);
      }
    } catch (err) {
      console.error("User fetch error:", err);
      showGuest();
    }
  }

  const doLogout = (e) => {
    e.preventDefault();
    localStorage.removeItem("jwt_token");
    window.location.href = "/login";
  };

  logoutBtn?.addEventListener("click", doLogout);
  logoutBtnMobile?.addEventListener("click", doLogout);
});
</script>

<style>

  .hamburger{
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
}
@media (max-width:700px){
  .hamburger{
    margin-right: 30px; /* állítsd 8-16px között ízlésre */
  }
}

/* ===== NAVBAR FONTS ===== */

.navbar{
  font-family: "Space Grotesk", system-ui, sans-serif;
}

.yel3 h1{
  font-family: "Playfair Display", serif;
  font-weight: 700;
  letter-spacing: .5px;
}
:root{
  --gold:#d4af37;
  --gold-light:#ffd230;
  --border:rgba(255,255,255,.15);
}

/* NAV + gombok legyenek modern, “precíz” */
.navbar,
.nav-link,
.btn-auth,
.yellowbutton,
.profile-link,
.logout-link{
  font-family: var(--font-body);
  letter-spacing: .2px;
}

/* NAVBAR */
.navbar{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 70px;
  padding: 0 40px;
  background: #000;
  border-bottom: 1px solid var(--border);
  z-index: 1000;

  display: flex;
  align-items: center;
  justify-content: flex-start;   /* ✅ ne space-between */
}

body{
  padding-top: 70px;
}

/* LEFT */
.navbar-left{
  display: flex;
  align-items: center;
  gap: 40px;
}

.yel3 h1{
  margin: 0;
  font-size: 24px;
  font-weight: 800;
  letter-spacing: .5px;
  color: #fff;
}

/* LINKS */
.nav-link{
  position: relative;
  font-size: 16px;
  font-weight: 600;
  color: #fff;
  text-decoration: none !important;
  padding: 8px 0;
  transition: color .2s ease;
  white-space: nowrap;
}

.nav-link:hover{
  color: var(--gold);
}

.nav-link::after{
  content:"";
  position:absolute;
  left:0;
  bottom:-6px;
  width:100%;
  height:2px;
  background: var(--gold);
  transform: scaleX(0);
  transition: transform .2s ease;
}
/* KIJELENTKEZÉS = rendes gomb */
.logout-link{
  display: inline-flex;
  align-items: center;
  justify-content: center;

  height: 44px;
  padding: 0 16px;
  border-radius: 12px;

  border: 1px solid rgba(255,255,255,.22);
  background: rgba(255,255,255,.03);

  font-size: 14px;
  font-weight: 700;
  letter-spacing: .2px;

  color: rgba(255,255,255,.88);
  text-decoration: none !important;

  transition: .2s ease;
}

.logout-link:hover{
  border-color: var(--gold);
  background: rgba(212,175,55,.08);
  color: #fff;

}
.nav-link:hover::after{
  transform: scaleX(1);
}

.nav-link.is-active{
  color: var(--gold-light);
}

.nav-link.is-active::after{
  transform: scaleX(1);
}

/* RIGHT */
.navbar-right{
  margin-left: auto;            /* ✅ EZ tolja teljesen jobbra */
  display: flex;
  align-items: center;
  gap: 14px;
}

/* AUTH BUTTONS */
.auth-buttons{
  display:flex;
  gap:12px;
}

/* Base */
.btn-auth{
  padding: 10px 18px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none !important;
  transition: .2s ease;
  white-space: nowrap;
}

/* Login */
.btn-login{
  border: 1px solid rgba(255,255,255,.3);
  color: #fff;
  background: transparent;
}

.btn-login:hover{
  border-color: var(--gold);
  color: var(--gold);
}

/* Register */
.btn-register{
  background: var(--gold);
  color: #000;
  border: 1px solid var(--gold);
}

.btn-register:hover{
  background: var(--gold-light);
  border-color: var(--gold-light);
}

/* USER */
.userbox{
  display:flex;
  align-items:center;
  gap:14px;
  padding-left:14px;
  border-left:1px solid rgba(255,255,255,.2);
}

.profile-link{
  color:#fff;
  font-weight:700;
  text-decoration:none !important;
  white-space: nowrap;
}

.logout-link{
  color:#ccc;
  font-size:16px;
  text-decoration:none !important;
  white-space: nowrap;
}

.logout-link:hover{
  color: var(--gold);
}

/* MOBILE */
@media (max-width:700px){
  .navbar{
    height: 64px;
    padding: 0 20px;
  }

  body{
    padding-top: 64px;
  }

  .auth-buttons{
    flex-direction: column;
    align-items: stretch;
  }

  .btn-auth{
    width: 100%;
    text-align: center;
  }
}



/* ===== USER (bejelentkezve) ===== */

.userbox{
  display:flex;
  align-items:center;
  gap:18px;
  padding-left:24px;
  border-left:none;                 /* ❌ kiszedjük a csíkot */
}

/* NÉV – prémium arany */
.profile-link{
  color: var(--gold);
  font-weight: 700;
  font-size: 15px;
  letter-spacing: .3px;
  text-decoration: none !important;
  transition: .2s ease;
}

.profile-link:hover{
  color: var(--gold-light);
}

/* KIJELETKEZÉS – diszkrét */
.logout-link{
  color: rgba(255,255,255,.65);
  font-size: 14px;
  font-weight: 500;
  text-decoration: none !important;
  transition: .2s ease;
}

.logout-link:hover{
  color: #fff;
}
</style>

<style>
  /* ===== HAMBURGER + MOBILE DRAWER (DESKTOPOT NEM BÁNTJA) ===== */
.hamburger,
.menu-backdrop,
.mobile-menu{
  display: none; /* desktopon nincs */
}

/* mobilon jelenik meg */
@media (max-width:700px){
  /* Desktop elemek elrejtése mobilon */
  .navbar-left .nav-link,
  .navbar-right{
    display: none !important;
  }

  /* Hamburger jobbra */
  .hamburger{
    display: inline-flex;
    margin-left: auto;
    width: 46px;
    height: 46px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,.18);
    background: rgba(255,255,255,.03);
    cursor: pointer;

    flex-direction: column;
    justify-content: center;
    gap: 5px;
  }

  .hamburger span{
    display:block;
    width: 20px;
    height: 2px;
    background:#fff;
    border-radius: 999px;
    transition: transform .2s ease, opacity .2s ease;
  }

  .hamburger.is-open span:nth-child(1){ transform: translateY(7px) rotate(45deg); }
  .hamburger.is-open span:nth-child(2){ opacity: 0; }
  .hamburger.is-open span:nth-child(3){ transform: translateY(-7px) rotate(-45deg); }

  /* Backdrop */
  .menu-backdrop{
    display:block;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.6);
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s ease;
    z-index: 999;
  }
  .menu-backdrop.is-open{
    opacity: 1;
    pointer-events: auto;
  }

  /* Drawer */
  .mobile-menu{
    display:flex;
    position: fixed;
    top: 0;
    right: 0;
    height: 100vh;
    width: min(86vw, 360px);
    background: rgba(10,10,10,.95);
    border-left: 1px solid rgba(212,175,55,.18);
    backdrop-filter: blur(10px);
    box-shadow: -30px 0 70px rgba(0,0,0,.6);

    transform: translateX(110%);
    transition: transform .22s ease;
    z-index: 1000;

    flex-direction: column;
  }
  .mobile-menu.is-open{
    transform: translateX(0);
  }

  .mobile-menu__head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding: 18px 18px 14px;
    border-bottom: 1px solid rgba(255,255,255,.08);
  }

  .mobile-brand{
    font-family: "Playfair Display", serif;
    font-weight: 800;
    font-size: 20px;
    color: #fff;
    letter-spacing: .4px;
  }

  .menu-close{
    width: 40px;
    height: 40px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,.14);
    background: rgba(255,255,255,.03);
    color: #fff;
    cursor: pointer;
  }

  .mobile-menu__links{
    padding: 14px;
    display:flex;
    flex-direction: column;
    gap: 10px;
  }

  .mobile-menu__links .nav-link{
    padding: 12px 12px;
    border-radius: 12px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.08);
  }
  .mobile-menu__links .nav-link::after{ display:none; }

  .mobile-menu__links .nav-link.is-active{
    border-color: rgba(212,175,55,.30);
    color: var(--gold-light);
    background: rgba(212,175,55,.08);
  }

  .mobile-menu__auth{
    margin-top: auto;
    padding: 14px;
    border-top: 1px solid rgba(255,255,255,.08);
  }

  #guestAuthMobile,
  #userBoxMobile{
    display:flex;
    flex-direction: column;
    gap: 10px;
  }

  #guestAuthMobile .btn-auth{
    width: 100%;
    text-align: center;
  }

  #userBoxMobile .profile-link,
  #userBoxMobile .logout-link{
    display:flex;
    justify-content:center;
    padding: 12px 12px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,.10);
    background: rgba(255,255,255,.03);
  }

  #userBoxMobile .profile-link{ color: var(--gold); font-weight: 700; }
  #userBoxMobile .logout-link{ color: rgba(255,255,255,.8); }
}
</style>