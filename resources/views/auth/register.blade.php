<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció</title>
</head>
<body>
    <x-navbar />
<h2>Regisztráció</h2>

<form id="registerForm">
    <label>Email:</label><br>
    <input type="email" id="email" required><br><br>

    <label>Felhasználónév:</label><br>
    <input type="text" id="username" required><br><br>

    <label>Jelszó:</label><br>
    <input type="password" id="password" required><br><br>

    <button type="submit">Regisztráció</button>
</form>

<p id="msg"></p>

<script>
document.getElementById("registerForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const msg = document.getElementById("msg");
    msg.textContent = "";
    msg.className = "";

    const payload = {
        email: document.getElementById("email").value,
        username: document.getElementById("username").value,
        password: document.getElementById("password").value,
    };

    try {
        const res = await fetch("/api/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify(payload)
        });

        const contentType = res.headers.get("content-type") || "";
        let data = {};

        if (contentType.includes("application/json")) {
            data = await res.json();
        } else {
            const text = await res.text();
            console.log("Nem JSON válasz:", text);
            msg.textContent = "Szerver hiba (nem JSON válasz). Nézd a konzolt 😈";
            msg.className = "error";
            return;
        }

        // 🔴 HTTP hiba (pl. 422 validation)
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

        // 🟢 Siker
        msg.textContent = data.message || "Sikeres regisztráció! ✅";
        msg.className = "success";

        // opcionális: ürítsd a formot
        // document.getElementById("registerForm").reset();

        // opcionális átirányítás
        // setTimeout(() => window.location.href = "/login", 1500);

    } catch (err) {
        console.error(err);
        msg.textContent = "Hálózati/Szerver hiba történt 😬";
        msg.className = "error";
    }
});
</script>

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
