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

    <!-- 🔥 ÚJ NÉV MEZŐK -->

    <label>Vezetéknév:</label><br>
    <input type="text" id="last_name" required><br><br>

    <label>Keresztnév:</label><br>
    <input type="text" id="first_name" required><br><br>

    <label>Jelszó:</label><br>
    <input type="password" id="password" required><br><br>

    <label>Telefonszám:</label><br>
    <input type="tel" id="phone" required><br><br>

    <label>Születési dátum:</label><br>
    <input type="date" id="birthdate" required><br><br>

    <label>Lakóhely:</label><br>
    <input type="text" id="address" required><br><br>

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
        last_name: document.getElementById("last_name").value,
        first_name: document.getElementById("first_name").value,
        password: document.getElementById("password").value,
        phone: document.getElementById("phone").value,
        birthdate: document.getElementById("birthdate").value,
        address: document.getElementById("address").value,
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
