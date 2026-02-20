<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <x-navbar />
        @vite([
    'resources/css/main_page.css',
    'resources/css/navbar.css',
    'resources/js/login.js'
])
</head>
<body>

<h2>Bejelentkezés</h2>

    <form id="loginForm">
        <label>Felhasználónév:</label><br>
        <input type="text" id="username" required><br><br>

        <label>Jelszó:</label><br>
        <input type="password" id="password" required><br><br>

<div class="register-wrapper">
    <a class="reg-link" href="{{ route('register') }}">
        Új fiók létrehozása
    </a>
</div>
<style>
.register-wrapper {
    text-align: right;
    margin-top: 10px;
}

.reg-link {
    color: #ffffff;
    text-decoration: none;
    transition: 0.3s;
    font-size:15px;
}

.reg-link:hover {
    text-decoration: underline;
       color: #d4af37;
}
</style>
        <button type="submit">Bejelentkezés</button>
    </form>

<p id="msg"></p>

<style>
/* Teljes oldal */
* {
    box-sizing: border-box; /* 🔥 ettől lesz tényleg ugyanakkora a szélesség */
}

body {
    font-family: Arial, sans-serif;
    background: #0f0f0f;
    margin: 0;
    padding-top: 120px;
    text-align: center;
    color: #f5f5f5;
}

/* Cím */
h2 {

    font-size: 30px;
    color: #ffffff;
}

/* Form keret */
form {
    width: 420px;                /* kicsit szélesebb, kényelmesebb */
    max-width: calc(100% - 32px);
    margin: 0 auto;
    background: #1a1a1a;
    padding: 28px;
    border-radius: 14px;
    text-align: left;
    box-shadow: 0 10px 30px rgba(0,0,0,0.35);
}

/* Label */
label {
    display: block;
    font-weight: bold;
    font-size: 14px;
    color: #e0e0e0;
    margin: 12px 0 6px;          /* szép ritmus */
}

/* Input mezők */
input {
    width: 100%;
    height: 44px;                /* egységes magasság */
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 15px;
    background: #2b2b2b;
    border: 1px solid #444;
    color: #fff;
    transition: 0.2s;
}

input:focus {
    border-color: #888;
    outline: none;
    background: #333;
}

/* Gomb – ugyanakkora széles és magas, mint az inputok */
button {
    width: 100%;
    height: 46px;
    margin-top: 18px;
    background: #d4af37;
    color: #000;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: 0.2s;
}

button:hover {
    background: #e6c35c;
}

/* Üzenetek */
#msg {
    width: 420px;
    max-width: calc(100% - 32px);
    margin: 14px auto 0;
    text-align: center;
    font-weight: 600;
}

#msg.error { color: #ff5c5c; }
#msg.success { color: #66ff99; }

</style>

</body>
</html>
