document.getElementById("loginForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const msg = document.getElementById("msg");
    msg.textContent = "";
    msg.className = "";

    try {
        const res = await fetch("/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                username: document.getElementById("username").value,
                password: document.getElementById("password").value,
            })
        });

        const data = await res.json();

        // ✅ 200–299 → siker
        if (res.ok) {
            localStorage.setItem("jwt_token", data.token);

            msg.textContent = "Sikeres bejelentkezés!";
            msg.className = "success";

            setTimeout(() => {
                window.location.href = "/main";
            }, 1000);
        //Státuszkód
        // ❌ 401 → rossz adatok
        } else if (res.status === 401) {
            msg.textContent = "Hibás felhasználónév vagy jelszó!";
            msg.className = "error";

        // ❌ 422 → validációs hiba
        } else if (res.status === 422) {
            msg.textContent = "Hiányzó vagy hibás adatok!";
            msg.className = "error";

        // 💀 minden más
        } else {
            msg.textContent = "Szerverhiba (" + res.status + ")";
            msg.className = "error";
        }

    } catch (err) {
        msg.textContent = "Nem érhető el a szerver.";
        msg.className = "error";
    }
});