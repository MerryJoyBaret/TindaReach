document.addEventListener("DOMContentLoaded", function () {
  var form = document.querySelector("[data-auth-form]");
  if (!form) return;

  var passwordInput = form.querySelector('input[name="password"]');
  var confirmInput = form.querySelector('input[name="confirm_password"]');
  var strengthFill = form.querySelector("[data-strength-fill]");
  var strengthHint = form.querySelector("[data-strength-hint]");

  var fadeLinks = document.querySelectorAll("[data-fade-link]");
  fadeLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {
      var href = link.getAttribute("href");
      if (!href || href.indexOf("javascript:") === 0 || href === "#") return;
      event.preventDefault();
      document.body.classList.add("fade-out");
      window.setTimeout(function () {
        window.location.href = href;
      }, 180);
    });
  });

  form.querySelectorAll("[data-toggle-password]").forEach(function (button) {
    button.addEventListener("click", function () {
      var targetName = button.getAttribute("data-toggle-password");
      var target = form.querySelector('input[name="' + targetName + '"]');
      if (!target) return;

      var shouldShow = target.type === "password";
      target.type = shouldShow ? "text" : "password";
      button.textContent = shouldShow ? "🙈" : "👁";
      button.setAttribute("aria-label", shouldShow ? "Hide password" : "Show password");
    });
  });

  function setFieldHint(fieldName, message) {
    var hint = form.querySelector('[data-error-for="' + fieldName + '"]');
    if (hint) hint.textContent = message || "";
  }

  function calculateStrength(value) {
    var score = 0;
    if (value.length >= 8) score += 25;
    if (/[A-Z]/.test(value)) score += 20;
    if (/[a-z]/.test(value)) score += 15;
    if (/[0-9]/.test(value)) score += 20;
    if (/[^A-Za-z0-9]/.test(value)) score += 20;
    return Math.min(score, 100);
  }

  function strengthLabel(score) {
    if (score < 35) return { text: "Weak password", color: "#d92d20" };
    if (score < 70) return { text: "Medium strength", color: "#f79009" };
    return { text: "Strong password", color: "#157347" };
  }

  if (passwordInput && strengthFill && strengthHint) {
    passwordInput.addEventListener("input", function () {
      var score = calculateStrength(passwordInput.value.trim());
      var level = strengthLabel(score);
      strengthFill.style.width = score + "%";
      strengthFill.style.background = level.color;
      strengthHint.textContent = passwordInput.value ? level.text : "Use 8+ chars, letters, numbers, and symbols.";
    });
  }

  form.addEventListener("submit", function (event) {
    var valid = true;

    form.querySelectorAll("[data-error-for]").forEach(function (node) {
      node.textContent = "";
    });

    var fullName = form.querySelector('input[name="fullname"]');
    if (fullName && fullName.value.trim().length < 2) {
      setFieldHint("fullname", "Please enter your full name.");
      valid = false;
    }

    var email = form.querySelector('input[name="email"]');
    if (email) {
      var emailValue = email.value.trim();
      var looksLikeEmail = emailValue.indexOf("@") > -1;
      var emailValid = looksLikeEmail ? /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue) : emailValue.length >= 3;
      if (!emailValid) {
        setFieldHint("email", "Enter a valid email or username.");
        valid = false;
      }
    }

    if (passwordInput) {
      var passwordValue = passwordInput.value.trim();
      if (passwordValue.length < 8) {
        setFieldHint("password", "Password must be at least 8 characters.");
        valid = false;
      }
    }

    if (confirmInput && passwordInput && confirmInput.value !== passwordInput.value) {
      setFieldHint("confirm_password", "Passwords do not match.");
      valid = false;
    }

    var terms = form.querySelector('input[name="terms"]');
    if (terms && !terms.checked) {
      setFieldHint("terms", "Please accept the Terms & Conditions.");
      valid = false;
    }

    if (!valid) {
      event.preventDefault();
      return;
    }

    var loadingButton = form.querySelector("[data-loading-button]");
    if (loadingButton) {
      loadingButton.classList.add("is-loading");
      loadingButton.setAttribute("disabled", "disabled");
      loadingButton.textContent = loadingButton.getAttribute("data-loading-label") || "Please wait...";
    }
  });
});
