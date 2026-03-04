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
    'resources/js/login.js',
    'resources/css/login.css'

  ])
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