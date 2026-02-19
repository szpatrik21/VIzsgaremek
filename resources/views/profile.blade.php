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

    <!-- PROFILKÉP RÉSZ -->
    <div class="profile-image-section">
        <img id="profile_image" src="/default-avatar.png" alt="Profilkép">
        <input type="file" id="imageInput" accept="image/*">
        <button id="uploadBtn" type="button">Feltöltés</button>
        <div id="uploadMsg" class="upload-msg"></div>
    </div>

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

    const uploadBtn = document.getElementById("uploadBtn");
    const imageInput = document.getElementById("imageInput");
    const uploadMsg = document.getElementById("uploadMsg");
    const profileImg = document.getElementById("profile_image");

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

        if (user.profile_image) {
            profileImg.src = "/storage/" + user.profile_image;
        }

    } catch (error) {
        console.error(error);
        window.location.href = "/login";
        return;
    }

    uploadBtn.addEventListener("click", async () => {

        const file = imageInput.files[0];

        if (!file) {
            uploadMsg.textContent = "Válassz ki egy képet!";
            return;
        }

        uploadMsg.textContent = "Feltöltés...";

        const formData = new FormData();
        formData.append("image", file);

        try {
            const res = await fetch("/api/upload-profile-image", {
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token
                },
                body: formData
            });

            const data = await res.json();

            if (!res.ok) {
                uploadMsg.textContent = data.message ?? "Hiba történt";
                return;
            }

            profileImg.src = "/storage/" + data.path;
            uploadMsg.textContent = "✅ Profilkép frissítve!";
        } catch (err) {
            console.error(err);
            uploadMsg.textContent = "Hálózati hiba!";
        }
    });

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

.profile-image-section {
    text-align: center;
    margin: 10px 0 20px;
}

.profile-image-section img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #d4af37;
    margin-bottom: 10px;
}

.profile-image-section input {
    display: block;
    margin: 0 auto 10px;
    color: #f5f5f5;
}

.profile-image-section button {
    background: #d4af37;
    border: none;
    padding: 10px 18px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
}

.upload-msg {
    margin-top: 10px;
    font-size: 14px;
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
