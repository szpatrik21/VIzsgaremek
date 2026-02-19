<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCar - Profil</title>

    @vite([
        'resources/css/profile.css',
        'resources/css/navbar.css',
    ])
</head>

<body>
<x-navbar />

<div class="profile-container">
    <h2 id="username">Profil</h2>

    <div class="profile-card">
        <p><strong>Teljes név:</strong> <span id="full_name"></span></p>
        <p><strong>Email cím:</strong> <span id="email"></span></p>
        <p><strong>Telefonszám:</strong> <span id="phone"></span></p>
        <p><strong>Születési dátum:</strong> <span id="birthdate"></span></p>
        <p><strong>Lakóhely:</strong> <span id="address"></span></p>
        <p><strong>Regisztráció dátuma:</strong> <span id="created_at"></span></p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", async () => {

    const token = localStorage.getItem("jwt_token");

    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const res = await fetch("/api/user", {
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        if (!res.ok) {
            localStorage.removeItem("jwt_token");
            window.location.href = "/login";
            return;
        }

        const user = await res.json();

        document.getElementById("username").textContent = user.username;
        document.getElementById("full_name").textContent = user.first_name + " " + user.last_name;
        document.getElementById("email").textContent = user.email;
        document.getElementById("phone").textContent = user.phone;
        document.getElementById("birthdate").textContent = user.birthdate;
        document.getElementById("address").textContent = user.address;
        document.getElementById("created_at").textContent =
            new Date(user.created_at).toLocaleDateString("hu-HU");

    } catch (error) {
        console.error(error);
        window.location.href = "/login";
    }
});
</script>

<style>
body {
    background: #0f0f0f;
    margin: 0;
    padding-top: 120px;
    font-family: Arial, sans-serif;
    color: #f5f5f5;
}

.profile-container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
}

.profile-card {
    background: #1a1a1a;
    padding: 25px;
    border-radius: 12px;
    margin-top: 20px;
}

.profile-card p {
    margin: 12px 0;
    font-size: 15px;
}

h2 {
    text-align: center;
}
</style>

</body>
</html>
