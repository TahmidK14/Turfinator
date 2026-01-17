console.log("app.js loaded ✅");

// Basic JS Validation (Frontend)
document.addEventListener("DOMContentLoaded", () => {
    const turfForm = document.getElementById("turfForm");
if (turfForm) {
  turfForm.addEventListener("submit", (e) => {
    const price = turfForm.querySelector('input[name="price_per_hour"]').value.trim();
    if (price === "" || isNaN(price) || Number(price) <= 0) {
      alert("Price must be a positive number");
      e.preventDefault();
    }
  });
}

    const reg = document.getElementById("registerForm");
    if (reg) {
      reg.addEventListener("submit", (e) => {
        const pass = reg.querySelector('input[name="password"]').value;
        const cpass = reg.querySelector('input[name="confirm_password"]').value;
  
        if (pass.length < 6) {
          alert("Password must be at least 6 characters");
          e.preventDefault();
        } else if (pass !== cpass) {
          alert("Passwords do not match");
          e.preventDefault();
        }
      });
    }
  });
  const bookingForm = document.getElementById("bookingForm");
  if (bookingForm) {
    bookingForm.addEventListener("submit", (e) => {
      const s = bookingForm.querySelector('input[name="start_time"]').value;
      const en = bookingForm.querySelector('input[name="end_time"]').value;
      if (s && en && en <= s) {
        alert("End time must be after start time");
        e.preventDefault();
      }
    });
  }
  console.log("app.js loaded ✅");

  document.addEventListener("DOMContentLoaded", () => {
  
    const searchBox = document.getElementById("searchBox");
    const turfBody = document.getElementById("turfBody");
  
    if (!searchBox || !turfBody) {
      console.warn("Search elements not found");
      return;
    }
  
    console.log("Search box found ✅");
  
    searchBox.addEventListener("keyup", () => {
      const q = searchBox.value;
      console.log("Typing:", q);
  
      fetch(`./index.php?page=api-turfs&q=${encodeURIComponent(q)}`)
        .then(res => res.json())
        .then(data => {
          turfBody.innerHTML = "";
  
          if (data.length === 0) {
            turfBody.innerHTML = "<tr><td colspan='4'>No turfs found</td></tr>";
            return;
          }
  
          data.forEach(t => {
            turfBody.innerHTML += `
              <tr>
                <td>${t.name}</td>
                <td>${t.location}</td>
                <td>${parseFloat(t.price_per_hour).toFixed(2)}</td>
                <td>
                  <a href="index.php?page=turf-details&id=${t.id}">View</a>
                </td>
              </tr>
            `;
          });
        })
        .catch(err => console.error("Fetch error:", err));
    });
  
  });
  
  document.addEventListener("DOMContentLoaded", () => {
    const passwordForm = document.getElementById("passwordForm");
    if (passwordForm) {
      passwordForm.addEventListener("submit", (e) => {
        const newPass = passwordForm.querySelector('input[name="new_password"]').value;
        const confirm = passwordForm.querySelector('input[name="confirm_password"]').value;
  
        if (newPass.length < 6) {
          alert("New password must be at least 6 characters");
          e.preventDefault();
        } else if (newPass !== confirm) {
          alert("New passwords do not match");
          e.preventDefault();
        }
      });
    }
  });
    