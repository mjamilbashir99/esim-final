<style>
  .custom-input {
    background-color: #E8F0FE;
    border: 1px solid #ced4da;
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  .custom-input:focus {
    background-color: #ffffff;
    border-color: #001c34;
    box-shadow: 0 0 0 0.2rem rgba(0, 28, 52, 0.25);
  }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow-lg my-4" style="width: 100%; max-width: 500px;">
    <h3 class="text-center mb-4">Register</h3>

    <?php if (session()->has('errors')): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form class="needs-validation" action="<?= site_url('register/submit') ?>" method="post" id="registerForm" novalidate>
      <div class="mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input
          type="text"
          class="form-control custom-input"
          id="fullname"
          name="name"
          value="<?= old('name') ?>"
          required
        />
        <div class="invalid-feedback">Please enter your full name.</div>
      </div>

      <div class="mb-3">
        <label for="number" class="form-label">Mobile Number</label>
        <input
          type="tel"
          class="form-control custom-input"
          id="number"
          name="phone"
          value="<?= old('phone') ?>"
          pattern="\d{10}"
          required
        />
        <div class="invalid-feedback">
          Please enter a valid 10-digit phone number.
        </div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input
          type="email"
          class="form-control custom-input"
          id="email"
          name="email"
          value="<?= old('email') ?>"
          required
        />
        <div class="invalid-feedback">Please enter a valid email.</div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control custom-input"
          id="password"
          name="password"
          minlength="6"
          required
        />
        <div class="invalid-feedback">
          Password must be at least 6 characters long.
        </div>
      </div>

      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input
          type="password"
          class="form-control custom-input"
          id="confirmPassword"
          name="confirm_password"
          required
        />
        <div class="invalid-feedback" id="confirmFeedback">
          Please confirm your password.
        </div>
      </div>

      <button
        type="submit"
        class="btn btn-success w-100"
        style="background-color: #001c34;"
      >
        Register
      </button>
    </form>

    <div class="text-center mt-3">
      <p>
        Already have an account?
        <a href="<?= site_url('login') ?>">Login here</a>
      </p>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Validation Script -->
<script>
  (() => {
    "use strict";

    const form = document.getElementById("registerForm");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const confirmFeedback = document.getElementById("confirmFeedback");

    form.addEventListener(
      "submit",
      function (event) {
        if (
          !form.checkValidity() ||
          password.value !== confirmPassword.value
        ) {
          event.preventDefault();
          event.stopPropagation();

          if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add("is-invalid");
            confirmFeedback.textContent = "Passwords do not match.";
          } else {
            confirmPassword.classList.remove("is-invalid");
          }
        } else {
          confirmPassword.classList.remove("is-invalid");
        }

        form.classList.add("was-validated");
      },
      false
    );
  })();
</script>
