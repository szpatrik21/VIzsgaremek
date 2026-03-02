<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  <title>Bejelentkezés</title>

  @vite([
    'resources/css/navbar.css',
    'resources/css/loggin.css',
    'resources/js/login.js'
  ])

  <style>
    :root{
      --bg:#0f0f0f;
      --panel:#1a1a1a;
      --border:rgba(255,255,255,.10);
      --gold:#d4af37;
      --gold2:#e6c35c;
      --text:#f5f5f5;
    }

    *{ box-sizing:border-box; }

    body{
      margin:0;
      background:var(--bg);
      color:var(--text);
      font-family:"Space Grotesk", system-ui, sans-serif;
      padding-top:64px; /* navbar height */
      display:flex;
      justify-content:center;
      align-items:center;
      min-height:100vh;
    }

    .login-wrapper{
      width:420px;
      max-width:calc(100% - 32px);
    }

    h2{
      font-family:"Playfair Display", serif;
      font-size:32px;
      margin:0 0 18px;
      text-align:center;
    }

    form{
      background:rgba(255,255,255,.03);
      border:1px solid var(--border);
      backdrop-filter:blur(10px);
      padding:28px;
      border-radius:16px;
      box-shadow:0 20px 60px rgba(0,0,0,.55);
    }

    .field{
      display:flex;
      flex-direction:column;
      gap:6px;
      margin-bottom:14px;
    }

    label{
      font-weight:700;
      font-size:13px;
      color:rgba(255,255,255,.85);
      letter-spacing:.2px;
    }

    input{
      width:100%;
      height:44px;
      padding:10px 12px;
      border-radius:10px;
      font-size:14px;
      background:rgba(255,255,255,.05);
      border:1px solid rgba(255,255,255,.15);
      color:#fff;
      transition:.2s ease;
      outline:none;
    }

    input:focus{
      border-color:var(--gold);
      box-shadow:0 0 0 3px rgba(212,175,55,.15);
      background:rgba(255,255,255,.07);
    }

    .register-wrapper{
      text-align:right;
      margin-top:4px;
      margin-bottom:6px;
    }

    .reg-link{
      color:rgba(255,255,255,.75);
      text-decoration:none;
      font-size:14px;
      transition:.2s;
    }

    .reg-link:hover{
      color:var(--gold);
      text-decoration:underline;
    }

    button{
      width:100%;
      height:46px;
      margin-top:10px;
      background:var(--gold);
      color:#000;
      border:none;
      border-radius:12px;
      cursor:pointer;
      font-size:15px;
      font-weight:800;
      transition:.2s ease;
    }

    button:hover{
      background:var(--gold2);
      transform:translateY(-1px);
    }

    #msg{
      margin-top:14px;
      text-align:center;
      font-weight:700;
      font-size:14px;
    }

    #msg.error{ color:#ff5c5c; }
    #msg.success{ color:#66ff99; }
  </style>
</head>

<body>
  <x-navbar />

  <div class="login-wrapper">
    <h2>Bejelentkezés</h2>

    <form id="loginForm">
      <div class="field">
        <label for="username">Felhasználónév</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div class="field">
        <label for="password">Jelszó</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="register-wrapper">
        <a class="reg-link" href="{{ route('register') }}">Új fiók létrehozása</a>
      </div>

      <button type="submit">Bejelentkezés</button>

      <p id="msg"></p>
    </form>
  </div>

</body>
</html>