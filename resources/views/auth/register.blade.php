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

    <!-- ÚJ MEZŐK -->

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

        // 🟢 SIKER
        msg.textContent = data.message || "Sikeres regisztráció! ✅";
        msg.className = "success";

        document.getElementById("registerForm").reset();

        // 🚀 ÁTIRÁNYÍTÁS LOGIN OLDALRA
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
body {
    font-family: Arial, sans-serif;
    background: #0f0f0f;
    margin: 0;
    padding-top: 120px;
    text-align: center;
    color: #f5f5f5;
}

h2 {
    margin-bottom: 20px;
    font-size: 26px;
    color: #ffffff;
}

form {
    width: 350px;
    margin: auto;
    background: #1a1a1a;
    padding: 25px;
    border-radius: 10px;
    text-align: left;
}

label {
    font-weight: bold;
    font-size: 14px;
    color: #e0e0e0;
}

input {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border-radius: 6px;
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

button {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background: #d4af37;
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

#msg {
    margin-top: 15px;
}

#msg.error {
    color: #ff5c5c;
}

#msg.success {
    color: #66ff99;
}
</style>

</body>
</html>
