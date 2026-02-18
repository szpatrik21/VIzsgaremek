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

        <button type="submit">Bejelentkezés</button>
    </form>

<p id="msg"></p>

<style>
/* Teljes oldal */
body {
    font-family: Arial, sans-serif;
    background: #0f0f0f;        /* teljesen sötét háttér */
    margin: 0;
    padding-top: 120px;         /* navbar miatt */
    text-align: center;
    color: #f5f5f5;
}

/* Cím */
h2 {
    margin-bottom: 20px;
    font-size: 26px;
    color: #ffffff;
}

/* Form kerete */
form {
    width: 350px;
    margin: auto;
    background: #1a1a1a;        /* sötétszürke doboz */
    padding: 25px;
    border-radius: 10px;
    text-align: left;
}

/* Label */
label {
    font-weight: bold;
    font-size: 14px;
    color: #e0e0e0;
}

/* Input mezők */
input {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border-radius: 6px;
    font-size: 15px;
    background: #2b2b2b;        /* sötét input */
    border: 1px solid #444;
    color: #fff;
    transition: 0.2s;
}

input:focus {
    border-color: #888;
    outline: none;
    background: #333;
}

/* Gomb */
button {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background: #d4af37;      /* arany gomb */
    color: #000;
    border: none;
    border-radius: 6px;
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
    margin-top: 15px;
    color: #ff5c5c;
}

</style>
</body>
</html>
