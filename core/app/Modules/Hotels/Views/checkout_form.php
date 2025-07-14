<style>
  body {
    background-color: #f5f5f5;
  }

  .booking-header {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    margin: 30px 0px 0px 0px;

  }

  .booking-form-section {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1),
      0 10px 15px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    padding: 25px;
    margin-top: 20px;
  }

  .form-label {
    font-weight: 500;
  }

  .booking-summary {
    background-color: #fff;
    border-left: 4px solid #28a745;
    padding: 15px;
    border-radius: 6px;
    margin-top: 20px;
  }

  .next-btn {
    margin-top: 30px;
  }

  .country-code-select {
    width: 80px;
  }

  /* Animation */
  @keyframes fadeUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .fade-up {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.6s ease-out forwards;
  }

  .fade-delay-1 {
    animation-delay: 0.2s;
  }

  .fade-delay-2 {
    animation-delay: 0.4s;
  }

  .fade-delay-3 {
    animation-delay: 0.6s;
  }

  .fade-delay-4 {
    animation-delay: 0.8s;
  }

  .fade-delay-5 {
    animation-delay: 1s;
  }

  .fade-delay-6 {
    animation-delay: 1.2s;
  }


  .blue-round {
    padding: 2px 15px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    width: 130px;
    background-color: #001c34;
    color: #a0d1ca;
    margin-bottom: 10px;
  }

  .invalid-card {
    border: 2px solid red;
  }

  .text-left {
    text-align: left !important
  }

  .form-select:focus,
  .form-control:focus {
    box-shadow: none !important
  }

  .select2-container--default .select2-selection--single {
    display: flex !important;
    height: 100% !important;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    align-items: center;
    justify-content: center;
  }

  .select2-container--default .select2-selection--single {
    padding: 0px !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    font-size: 15px !important;
  }

  .select2-results__option[aria-selected] {
    font-size: 14px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 50% !important;
    transform: translateY(-50%);
  }

  .form-control.is-valid,
  .was-validated .form-control:valid {
    border-color: inherit !important;
    padding-right: inherit !important;
    background-image: none !important;
    background-repeat: initial !important;
    background-position: initial !important;
    background-size: initial !important;
    box-shadow: none !important;
  }
</style>




<div class="col-md-10 mx-auto my-5" style="margin-top: 150px !important;">
  <!-- Header Section -->
  <div class="text-success my-4 text-center" id="countdownTimer" style="font-size:20px;"></div>
  <div class="booking-header row fade-up fade-delay-1">

    <div class="col-lg-3">
      <!-- <img
            src="https://via.placeholder.com/200x130"
            class="img-fluid rounded"
            alt="Hotel"
          /> -->
      <?php if (!empty($imageUrl)): ?>
        <?php
        $baseUrl = "https://photos.hotelbeds.com/giata/";
        $fullImageUrl = $baseUrl . $imageUrl;
        ?>
        <img src="<?= htmlspecialchars($fullImageUrl) ?>" alt="<?= htmlspecialchars($hotelName) ?>" class=" col-12 h-100">
      <?php endif; ?>

    </div>

    <div class="col-lg-9 mt-4 mt-lg-0">
      <h4 class="fs-20px fw-medium montserrat"><?= esc($hotelName) ?></h4>
      <?php
      // $address = isset($hotel['hotel']['address']['content']) ? $hotel['hotel']['address']['content'] : 'Address not available';
      ?>

      <p class="text-left fs-16px fw-normal lato">
        Checkin: <?= esc($checkin) ?> <?= !empty($checkInHour) ? 'at ' . esc($checkInHour) : '' ?><br>
        Checkout: <?= esc($checkout) ?> <?= !empty($checkOutHour) ? 'by ' . esc($checkOutHour) : '' ?>
        <!-- <br>Total Stay:  <b>(3 Nights)</b> -->
      </p>
      <!-- <p class="text-left">1 x <span style="color: #001c34" class="fw-semibold">Standard Room</span>, BED AND BREAKFAST (BB)</p> -->
      <p class="text-left fs-16px fw-normal lato"><?= htmlspecialchars($address) ?></p>
      <!-- <div class="blue-round">
            <p class="p-0 m-0"> 2 Adults</p>
            </div> -->
      <?php
      $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'INR' => '₹',
        'JPY' => '¥'
      ];

      $currencySymbol = isset($currencySymbols[$currency]) ? $currencySymbols[$currency] : $currency;
      ?>
      <span class="badge  btn-search fs-20px lato fw-medium">
        Price <?= esc($currencySymbol) ?> <?= esc($price) ?>
      </span>
    </div>
  </div>

  <!-- Form Section -->
  <div class="booking-form-section mt-4" style="background-color: white;">
    <p class="text-end text-success fw-semibold fade-up fade-delay-1 fs-16px fw-normal lato">
      Almost done! Just fill in the * required info
    </p>

    <form action="/book-room" method="POST" class=" row flex-column flex-lg-row">
      <input type="hidden" value="<?= $price ?>" name="hotel_price">

      <!-- Name Fields -->
      <div class="col-lg-6">
        <div class="col-md-12">
          <h5 class="mb-3 fs-16px fw-normal ">Personal Details</h5>
        </div>
        <div class="row g-3 fade-up fade-delay-3 ">
          <div class="col-md-2">
            <label for="title" class="form-label fs-14px fw-normal lato">Title</label>
            <select class="form-select fs-16px fw-normal lato" id="title">
              <option class="fs-16px fw-normal lato">Mr</option>
              <option class="fs-16px fw-normal lato">Ms</option>
              <option class="fs-16px fw-normal lato">Mrs</option>
            </select>
          </div>

          <input type="hidden" name="rateKey" value="<?= esc($rateKey) ?>">

          <?php
          $session = session();
          $fullName = $session->get('user_name');
          $nameParts = explode(' ', trim($fullName));
          $firstName = $nameParts[0] ?? '';
          $lastName = isset($nameParts[1])
            ? implode(' ', array_slice($nameParts, 1))
            : '';
          ?>
          <?php $session = session(); ?>
          <div class="col-md-5">
            <label for="fname" class="form-label fs-14px fw-normal lato">First Name *</label>
            <input
              type="text"
              class="form-control fs-16px fw-normal lato"
              name="name"
              placeholder="First name"
              value="<?= esc($firstName) ?>"
              required />
          </div>
          <div class="col-md-5">
            <label for="lname" class="form-label fs-14px fw-normal lato">Last Name *</label>
            <input type="text" class="form-control fs-16px fw-normal lato" name="surname"
              placeholder="Last name"
              value="<?= esc($lastName) ?>" required />
          </div>
        </div>
        <!-- <div class="row mt-3 align-items-end fade-up fade-delay-5">
            <div class="col-md-12">
              <label for="phone" class="form-label fw-20px montserrat fw-medium"
                >Telephone (mobile preferred) *</label
              >
              <input type="tel" class="form-control fw-16px fw-normal lato"style="font-size:16px !important" id="phone"  value="<?= esc($session->get('user_phone')) ?>"  required /> -->
        <?php
        $session = session();
        $countryCode = $session->get('user_country_code');
        // var_dump($countryCode);die();
        $userPhone = $session->get('user_phone');
        ?>
        <div class="fade-up fade-delay-5 mt-2">
          <label for="phone" class="form-label fs-14px lato fw-normal">Telephone (mobile preferred) *</label>
          <div class="form-group d-flex gap-2 ">

            
            <select
                id="country-code"
                name="country_code"
                class="form-select text-center"
                required
                style="max-width: 100px;">
                <?php foreach ($country_codes as $code): ?>
                    <option 
                        value="<?= esc($code) ?>" 
                        <?= (session()->get('user_country_code') == $code) ? 'selected' : '' ?>
                    >+<?= esc($code) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input
              type="tel"
              class="form-control fw-14px fw-normal lato"
              id="phone"
              name="phone"
              placeholder="Phone Number"
              style="font-size:14px !important"
              value="<?= esc($userPhone) ?>"
              required />
          </div>
        </div>
      </div>

      <!-- Card Details Section -->
      <div class=" mt-4 mt-lg-0 fade-up fade-delay-6 col-lg-6 ">
        <div class="col-md-12">
          <h5 class="mb-3 fs-16px fw-normal ">Card Details</h5>
        </div>

        <div class="col-md-12">
          <label for="card_number" class="form-label fs-14px fw-normal fw-normal lato">Card Number *</label>
          <!-- <input type="text" class="form-control" name="card_number" id="card_number" placeholder="•••• •••• •••• ••••" required /> -->
          <!-- <label for="card-element" class="form-label fs-14px fw-normal fw-medium montserrat">Card Details *</label> -->
          <div id="card-element" class="form-control fs-14px fw-normal lato" style="height: 38px; padding: 8px 12px;"></div>
          <div id="card-errors" class="text-danger mt-2"></div>
        </div>
      </div>
      <!-- <span id="btnLoader" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span> -->
      <!-- Button -->
      <div class="text-end next-btn fade-up fade-delay-6">
        <button type="submit" class="btn btn-search" id="submit-btn" style="border-width:2px !important">
          <span class="spinner-border spinner-border-sm d-none text-light" id="loader" role="status" aria-hidden="true"></span>
          <span id="btn-text">Book Now</span>

        </button>

        <!-- <div class="text-muted mt-1 small fs-14px fw-nowmal lato">
          Don't worry – your payment will be secure!
        </div> -->
      </div>
    </form>
  </div>
</div>

<style>
  .select2-container--default .select2-selection--single {
    height: 100% !important;
    padding: 6px 12px;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
  }

  .select2-selection__rendered {
    line-height: 28px !important;
  }

  .select2-selection {
    height: 38px !important;
  }
</style>



<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  window.addEventListener("DOMContentLoaded", function() {
    const countdownEl = document.getElementById("countdownTimer");
    const bookingForm = document.querySelector("form");

    const url = new URL(window.location.href);
    let expiry = url.searchParams.get("expires");

    if (!expiry) {
      const now = new Date().getTime();
      const expireAt = now + 15 * 60 * 1000;
      expiry = expireAt;

      url.searchParams.set("expires", expireAt);
      history.replaceState(null, '', url.href);
    } else {
      expiry = parseInt(expiry);
    }

    const interval = setInterval(() => {
      const now = new Date().getTime();
      const timeLeft = expiry - now;

      if (timeLeft <= 0) {
        clearInterval(interval);
        countdownEl.innerHTML = "Booking expired";
        disableForm();
        Swal.fire({
          title: "Booking Expired",
          text: "Please try searching again.",
          icon: "warning",
          confirmButtonText: "Search Again",
          allowOutsideClick: false,
          allowEscapeKey: false
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "<?= base_url('home') ?>";
          }
        });
        return;
      }

      const totalSeconds = Math.floor(timeLeft / 1000);
      const minutes = Math.floor(totalSeconds / 60);
      const seconds = totalSeconds % 60;

      const displayTime =
        minutes > 0 ?
        `${minutes} minute${minutes > 1 ? 's' : ''} ${seconds} second${seconds !== 1 ? 's' : ''}` :
        `${seconds} second${seconds !== 1 ? 's' : ''}`;

      countdownEl.innerHTML = `This booking will expire in <span style="color:red;">${displayTime}</span>`;
    }, 1000);

    function disableForm() {
      const elements = bookingForm.elements;
      for (let i = 0; i < elements.length; i++) {
        elements[i].disabled = true;
      }
    }
  });
</script>



<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
  const stripe = Stripe("<?= getenv('STRIPE_PUBLIC_KEY') ?>"); // set this in .env
  const elements = stripe.elements();
  const cardElement = elements.create('card');
  cardElement.mount('#card-element');

  const form = document.querySelector("form");
  const submitBtn = document.getElementById("submit-btn");
  const loader = document.getElementById("loader");
  const btnText = document.getElementById("btn-text");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Disable button and show loader
    submitBtn.disabled = true;
    loader.classList.remove('d-none');
    btnText.textContent = 'Processing...';

    const {
      paymentMethod,
      error
    } = await stripe.createPaymentMethod({
      type: 'card',
      card: cardElement,
    });

    const cardElementContainer = document.getElementById("card-element");
    if (error) {
      cardElementContainer.classList.add('invalid-card');
      // Re-enable button and hide loader
      submitBtn.disabled = false;
      loader.classList.add('d-none');
      btnText.textContent = 'Next';
      return;
    }
    cardElementContainer.classList.remove('invalid-card');

    const formData = new FormData(form);
    formData.append("payment_method_id", paymentMethod.id);

    const response = await fetch("<?= base_url('book-room') ?>", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();
    if (result.html) {
      document.body.innerHTML = result.html;
    }

    if (result.error) {
      alert(result.error);
      // Re-enable button and hide loader
      submitBtn.disabled = false;
      loader.classList.add('d-none');
      btnText.textContent = 'Next';
    } else if (result.redirect) {
      window.location.href = result.redirect;
    }
  });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- <script>
  $(document).ready(function() {
    const selectedCode = $('#country-code').data('selected'); // e.g., "91"
    console.log("Selected code from session:", selectedCode);

    fetch('https://restcountries.com/v3.1/all')
      .then(res => res.json())
      .then(data => {
        const countries = data.map(country => {
          const flag = country.flags?.png || '';
          const root = country.idd?.root || '';
          const suffixes = country.idd?.suffixes || [];
          if (!root || suffixes.length === 0) return null;

          return suffixes.map(suffix => {
            const dialCode = (root + suffix).replace('+', '');
            return {
              id: dialCode,
              text: `+${dialCode}`,
              flag: flag
            };
          });
        }).flat().filter(Boolean); // flatten array & remove nulls

        $('#country-code').select2({
          data: countries,
          templateResult: formatCountry,
          templateSelection: formatCountry,
          escapeMarkup: function(m) {
            return m;
          },
          placeholder: 'Select country code'
        });

        // Delay setting value until Select2 is initialized fully
        setTimeout(() => {
          if (selectedCode) {
            $('#country-code').val(selectedCode).trigger('change');
          }
        }, 300);

        function formatCountry(country) {
          if (!country.id) return country.text;
          return `<img src="${country.flag}" style="width:20px; margin-right:5px;" /> ${country.text}`;
        }
      })
      .catch(error => {
        console.error("Failed to fetch countries:", error);
      });
  });
</script> -->