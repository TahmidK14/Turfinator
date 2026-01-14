// Basic JS Validation (Frontend)
document.addEventListener("DOMContentLoaded", () => {
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
  