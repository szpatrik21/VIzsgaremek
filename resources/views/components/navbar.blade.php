<nav class="navbar">
  <div class="navbar-left">
    <div class="yel3">
      <h1 class="yel2">Lux</h1><h1 class="yel">Car</h1>
    </div>
    <a href="{{ route('main') }}">Kezdőoldal</a>
    <a href="{{ route('cars') }}">Autók</a>
    <a href="{{ route('comments') }}">Vélemények</a>
  </div>

  <div class="navbar-right">
    <a href="{{ route('cart') }}">
      <img src="{{ asset('images/bag-shopping-solid-full.svg') }}" alt="Kosár">
    </a>

    <a href="{{ route('login') }}">
      <img src="{{ asset('images/user-solid-full.svg') }}" alt="Profil">
    </a>
  </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("jwt_token");

    // Ha nincs token → nem vagy bejelentkezve
    if (!token) return;

    try {
        const res = await fetch("/api/user", {
            headers: {
                "Authorization": "Bearer " + token
            }
        });

        if (!res.ok) return;

        const user = await res.json();

        // Username kiírása a navbar-ba
        const navbarRight = document.querySelector(".navbar-right");

        navbarRight.innerHTML = `
            <span class="logged-in-user">Bejelentkezve: <strong>${user.username}</strong></span>
            <a id="logoutBtn" href="#">Kijelentkezés</a>
        `;
        
        // Kijelentkezés
        document.getElementById("logoutBtn").addEventListener("click", function() {
            localStorage.removeItem("jwt_token");
            location.reload();
        });

    } catch (error) {
        console.error("User fetch error:", error);
    }
});
</script>


<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

<style>
    .yel3{
  display:flex;
}
.yel{
  color:#ffd230;
}

.navbar {
  background-color: #000;
  color:#fff;         
  height: 56px;  
  position: fixed;
  top: 0; left: 0;
  width: 100%; 
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  font-size: 20px;
  border-bottom: 1px solid #5b5b5b;
  z-index: 1000;
}

.navbar-left {
  display: flex;
  align-items: center;
  gap: 60px;
}

.navbar-right {
  display: flex;
  align-items: center;
  gap: 20px;
  padding: 0 40px;
}

.navbar-right img {
  cursor: pointer;
  margin-right: 20px;
  filter: brightness(0) invert(1);
  transition: .3s;
  width:28px;
}

.navbar-right img:hover {
  filter: brightness(0) invert(63%) sepia(85%) saturate(450%) hue-rotate(10deg);
}

.navbar a {
  color: white;
  text-decoration: none !important;
}

.navbar a:hover {
  color:#c89c0a;
  text-decoration: underline;
}

</style>