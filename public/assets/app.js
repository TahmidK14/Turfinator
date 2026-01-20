console.log("app.js loaded ✅");

/* =========================
   THEME TOGGLE (GLOBAL)
   ========================= */
(function () {
  const apply = () => {
    const dark = document.body.classList.contains("dark");
    const btn = document.getElementById("themeToggle");
    if (btn) btn.textContent = dark ? "Light" : "Dark";
  };

  // apply saved theme immediately
  if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
  }
  apply();

  document.addEventListener("click", function (e) {
    const btn = document.getElementById("themeToggle");
    if (!btn) return;
  
    // if the click happened on the toggle button (or inside it)
    if (!btn.contains(e.target)) return;
  
    e.preventDefault();
    e.stopPropagation();
  
    document.body.classList.toggle("dark");
    localStorage.setItem(
      "theme",
      document.body.classList.contains("dark") ? "dark" : "light"
    );
    apply();
  
    console.log("Theme toggled ->", document.body.classList.contains("dark") ? "dark" : "light");
  });
  
})();


document.addEventListener("DOMContentLoaded", () => {


  /* -------------------------
     Turf Form Validation
  -------------------------- */
  const turfForm = document.getElementById("turfForm");
  if (turfForm) {
    turfForm.addEventListener("submit", (e) => {
      const priceEl = turfForm.querySelector('input[name="price_per_hour"]');
      const price = (priceEl?.value ?? "").trim();

      if (price === "" || isNaN(price) || Number(price) <= 0) {
        alert("Price must be a positive number");
        e.preventDefault();
        return;
      }

      // Optional: require image on create page if field exists + required attribute is missing
      const imageEl = turfForm.querySelector('input[name="image"]');
      if (imageEl && imageEl.hasAttribute("required") && imageEl.files.length === 0) {
        alert("Turf image is required");
        e.preventDefault();
      }
    });
  }

  /* -------------------------
     Register Form Validation
  -------------------------- */
  const reg = document.getElementById("registerForm");
  if (reg) {
    reg.addEventListener("submit", (e) => {
      const pass = reg.querySelector('input[name="password"]')?.value ?? "";
      const cpass = reg.querySelector('input[name="confirm_password"]')?.value ?? "";

      if (pass.length < 6) {
        alert("Password must be at least 6 characters");
        e.preventDefault();
      } else if (pass !== cpass) {
        alert("Passwords do not match");
        e.preventDefault();
      }
    });
  }

  /* -------------------------
     Booking Form Validation
  -------------------------- */
  const bookingForm = document.getElementById("bookingForm");
  if (bookingForm) {
    bookingForm.addEventListener("submit", (e) => {
      const s = bookingForm.querySelector('input[name="start_time"]')?.value ?? "";
      const en = bookingForm.querySelector('input[name="end_time"]')?.value ?? "";

      if (s && en && en <= s) {
        alert("End time must be after start time");
        e.preventDefault();
      }
    });
  }

  /* -------------------------
     Change Password Validation
  -------------------------- */
  const passwordForm = document.getElementById("passwordForm");
  if (passwordForm) {
    passwordForm.addEventListener("submit", (e) => {
      const newPass = passwordForm.querySelector('input[name="new_password"]')?.value ?? "";
      const confirm = passwordForm.querySelector('input[name="confirm_password"]')?.value ?? "";

      if (newPass.length < 6) {
        alert("New password must be at least 6 characters");
        e.preventDefault();
      } else if (newPass !== confirm) {
        alert("New passwords do not match");
        e.preventDefault();
      }
    });
  }

  /* -------------------------
     AJAX Live Turf Search
  -------------------------- */
  const searchBox = document.getElementById("searchBox");
  const turfBody = document.getElementById("turfBody");

  if (searchBox && turfBody) {
    const renderRows = (data) => {
      turfBody.innerHTML = "";

      if (!Array.isArray(data) || data.length === 0) {
        turfBody.innerHTML = "<tr><td colspan='4'>No turfs found</td></tr>";
        return;
      }

      data.forEach((t) => {
        const price = parseFloat(t.price_per_hour);
        turfBody.innerHTML += `
          <tr>
            <td>${escapeHtml(t.name)}</td>
            <td>${escapeHtml(t.location)}</td>
            <td>${Number.isFinite(price) ? price.toFixed(2) : ""}</td>
            <td><a href="index.php?page=turf-details&id=${t.id}">View</a></td>
          </tr>
        `;
      });
    };

    // tiny debounce so it feels smoother and avoids spamming requests
    let timer = null;
    searchBox.addEventListener("input", () => {
      clearTimeout(timer);
      timer = setTimeout(() => {
        const q = searchBox.value;

        fetch(`./index.php?page=api-turfs&q=${encodeURIComponent(q)}`)
          .then((res) => res.json())
          .then(renderRows)
          .catch((err) => console.error("Fetch error:", err));
      }, 150);
    });
  }

  function escapeHtml(str) {
    return String(str ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }
});
