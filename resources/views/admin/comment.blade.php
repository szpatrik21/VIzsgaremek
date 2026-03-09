<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin – Kommentek</title>

  <style>
    :root {
      --black: #000;
      --white: #fff;
      --gold: #d4af37;
      --gray: #e6e6e6;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background: #f7f7f7;
      font-family: Arial, sans-serif;
      color: #111;
    }

    header {
      background: var(--black);
      color: var(--white);
      padding: 18px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 22px;
      font-weight: bold;
    }

    .logo span {
      color: var(--gold);
    }

    .content {
      padding: 40px;
      max-width: 1000px;
      margin: 0 auto;
    }

    h2 {
      font-size: 26px;
      margin-bottom: 25px;
      border-left: 5px solid var(--gold);
      padding-left: 12px;
    }

    .status {
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 8px;
      display: none;
    }

    .status.success {
      background: #e9ffe9;
      color: #145214;
      display: block;
    }

    .status.error {
      background: #ffe9e9;
      color: #8a1f1f;
      display: block;
    }

    .comment-row {
      background: var(--white);
      border: 1px solid var(--gray);
      border-radius: 10px;
      padding: 16px;
      margin-bottom: 14px;
      display: flex;
      justify-content: space-between;
      gap: 18px;
    }

    .comment-main {
      flex: 1;
    }

    .comment-meta {
      font-size: 13px;
      color: #444;
      margin-bottom: 8px;
      line-height: 1.4;
    }

    .comment-meta strong {
      color: var(--gold);
    }

    .comment-text {
      font-size: 15px;
      line-height: 1.45;
      white-space: pre-wrap;
    }

    .danger-btn {
      background: #b00020;
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      height: fit-content;
    }

    .danger-btn:hover {
      filter: brightness(1.1);
    }

    .back-btn {
      background: #000;
      color: #d4af37;
      text-decoration: none;
      border: 1px solid #d4af37;
      padding: 10px 16px;
      border-radius: 6px;
      font-weight: bold;
      display: inline-block;
    }

    .page-link {
      display: inline-block;
      padding: 6px 10px;
      margin: 0 4px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      border: 1px solid #d4af37;
      cursor: pointer;
    }

    .pagination {
      margin-top: 20px;
      text-align: center;
    }

    .empty-state {
      background: #fff;
      border: 1px solid var(--gray);
      border-radius: 10px;
      padding: 16px;
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">Lux<span>Car</span> Admin</div>
    <a href="/admin/dashboard" class="back-btn">Vissza</a>
  </header>

  <div class="content">
    <h2>Kommentek</h2>

    <div id="statusBox" class="status"></div>

    <div id="commentsRoot">
      <div class="empty-state">Betöltés...</div>
    </div>

    <div id="paginationRoot" class="pagination"></div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const commentsRoot = document.getElementById("commentsRoot");
      const paginationRoot = document.getElementById("paginationRoot");
      const statusBox = document.getElementById("statusBox");

const apiBase = "/api/admin-comments"

      const esc = (s) => String(s ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");

      const getToken = () =>
        localStorage.getItem("jwt_token") ||
        localStorage.getItem("token") ||
        "";

      const getPage = () => {
        const params = new URLSearchParams(window.location.search);
        return Number(params.get("page") || 1);
      };

      const setPage = (page) => {
        const params = new URLSearchParams(window.location.search);
        params.set("page", page);
        const qs = params.toString();
        const newUrl = qs ? `${window.location.pathname}?${qs}` : window.location.pathname;
        window.history.pushState({}, "", newUrl);
      };

      const showStatus = (text, ok = true) => {
        statusBox.textContent = text;
        statusBox.className = "status " + (ok ? "success" : "error");
      };

      const clearStatus = () => {
        statusBox.textContent = "";
        statusBox.className = "status";
      };

      const formatDate = (value) => {
        if (!value) return "-";
        const d = new Date(value);
        if (Number.isNaN(d.getTime())) return value;
        return d.toLocaleString("hu-HU", {
          year: "numeric",
          month: "2-digit",
          day: "2-digit",
          hour: "2-digit",
          minute: "2-digit"
        });
      };

      const getAutoName = (comment) => {
        const a = comment.auto || {};
        if (a.brand || a.model) return `${a.brand || ""} ${a.model || ""}`.trim();
        if (a.marka || a.modell) return `${a.marka || ""} ${a.modell || ""}`.trim();
        if (a.marka || a.tipus) return `${a.marka || ""} ${a.tipus || ""}`.trim();
        if (a.name) return a.name;
        return "";
      };

      async function safeJson(res) {
        const ct = res.headers.get("content-type") || "";
        if (ct.includes("application/json")) return await res.json();
        return null;
      }

      async function loadComments() {
        clearStatus();
        commentsRoot.innerHTML = `<div class="empty-state">Betöltés...</div>`;
        paginationRoot.innerHTML = "";

        const page = getPage();

        try {
          const res = await fetch(`${apiBase}?page=${page}`, {
            headers: {
              "Accept": "application/json"
            }
          });

          const json = await safeJson(res);

          if (!res.ok) {
            commentsRoot.innerHTML = `<div class="empty-state">Nem sikerült betölteni a kommenteket.</div>`;
            return;
          }

          const comments = Array.isArray(json)
            ? json
            : (Array.isArray(json?.data) ? json.data : []);

          if (!comments.length) {
            commentsRoot.innerHTML = `<div class="empty-state">Nincs komment.</div>`;
          } else {
            commentsRoot.innerHTML = comments.map(comment => {
              const user = comment.user || {};
              const auto = comment.auto || {};
              const author = user.username || user.email || "Ismeretlen";
              const autoName = getAutoName(comment);
              const autoText = auto.id
                ? (autoName ? `${autoName} (ID: ${auto.id})` : `Ismeretlen név (ID: ${auto.id})`)
                : "Nincs hozzárendelve";

              return `
                <div class="comment-row">
                  <div class="comment-main">
                    <div class="comment-meta">
                      <strong>Írta:</strong> ${esc(author)}<br>
                      <strong>Autó:</strong> ${esc(autoText)}<br>
                      <strong>Dátum:</strong> ${esc(formatDate(comment.created_at))}
                    </div>

                    <div class="comment-text">
                      ${esc(comment.content)}
                    </div>
                  </div>

                  <button class="danger-btn" data-id="${comment.id}">
                    Törlés
                  </button>
                </div>
              `;
            }).join("");
          }

          renderPagination(json);
          bindDeleteButtons();

        } catch (err) {
          console.error("Comments load error:", err);
          commentsRoot.innerHTML = `<div class="empty-state">Hálózati hiba történt.</div>`;
        }
      }

      function renderPagination(json) {
        if (!json || typeof json !== "object") return;

        const currentPage = Number(json.current_page || 1);
        const lastPage = Number(json.last_page || 1);

        if (lastPage <= 1) {
          paginationRoot.innerHTML = "";
          return;
        }

        let html = "";

        for (let i = 1; i <= lastPage; i++) {
          const active = i === currentPage;

          html += `
            <a
              href="#"
              class="page-link"
              data-page="${i}"
              style="
                color: ${active ? "#000" : "#d4af37"};
                background: ${active ? "#d4af37" : "#000"};
              "
            >
              ${i}
            </a>
          `;
        }

        paginationRoot.innerHTML = html;

        paginationRoot.querySelectorAll(".page-link").forEach(link => {
          link.addEventListener("click", (e) => {
            e.preventDefault();
            const page = Number(link.dataset.page || 1);
            setPage(page);
            loadComments();
          });
        });
      }

      function bindDeleteButtons() {
        commentsRoot.querySelectorAll(".danger-btn").forEach(btn => {
          btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            if (!id) return;

            const ok = confirm("Biztosan törlöd ezt a kommentet?");
            if (!ok) return;

            const token = getToken();

            try {
              const res = await fetch(`${apiBase}/${id}`, {
                method: "DELETE",
                headers: {
                  "Accept": "application/json",
                  ...(token ? { "Authorization": "Bearer " + token } : {})
                }
              });

              const json = await safeJson(res);

              if (!res.ok) {
                const msg = json?.message || "Nem sikerült törölni a kommentet.";
                showStatus(msg, false);
                return;
              }

              showStatus(json?.message || "Komment törölve.");
              loadComments();

            } catch (err) {
              console.error("Delete error:", err);
              showStatus("Hálózati hiba történt.", false);
            }
          });
        });
      }

      window.addEventListener("popstate", loadComments);

      loadComments();
    });
  </script>

</body>
</html>