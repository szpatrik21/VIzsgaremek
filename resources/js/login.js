document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const res = await fetch("/api/login", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            username: document.getElementById("username").value,
            password: document.getElementById("password").value,
        })
    });

    const msg = document.getElementById("msg");
    const data = await res.json();

    if (data.token) {
        localStorage.setItem("jwt_token", data.token);

        msg.textContent = "Sikeres bejelentkezés! Üdv, " + document.getElementById("username").value + "!";
        msg.className = "success";

        // Ha szeretnéd átirányítani:
        // setTimeout(() => window.location.href = "/dashboard", 1500);

    } else {
        msg.textContent = data.error || "Hibás adatok!";
        msg.className = "error";
    }
});