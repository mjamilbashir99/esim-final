<style>
      body {
        background-color: #f5f5f5;
      }

      .booking-header {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-top: 30px;
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
    </style>
<!-- <h2>Enter your details</h2>
<h2><?= esc($hotelName) ?></h2>
<p><strong>Price:</strong> <?= esc($price) ?> <?= esc($currency) ?></p>
<form action="/book-room" method="POST">
    <input type="hidden" name="rateKey" value="<?= esc($rateKey) ?>">
    
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Surname:</label>
    <input type="text" name="surname" required>


    <button type="submit">Confirm Booking</button>
</form> -->




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Animated Booking Form</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    
  </head>
  <body>
    <div class="col-md-6 mx-auto">
      <!-- Header Section -->
      <div class="booking-header row fade-up fade-delay-1">
        <div class="col-md-3">
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
                <img src="<?= htmlspecialchars($fullImageUrl) ?>" alt="<?= htmlspecialchars($hotelName) ?>" class="img-fluid" style="max-height:300px;">
          <?php endif; ?>
          
        </div>
        <div class="col-md-9">
          <h4><?= esc($hotelName) ?></h4>
          <?php
            // $address = isset($hotel['hotel']['address']['content']) ? $hotel['hotel']['address']['content'] : 'Address not available';
            ?>

            <p><?= htmlspecialchars($address) ?></p>
          <span class="badge bg-success">Price <?= esc($price) ?> <?= esc($currency) ?></span>
        </div>
      </div>

      <!-- Form Section -->
      <div class="booking-form-section mt-4">
        <p class="text-end text-success fw-semibold fade-up fade-delay-1">
          Almost done! Just fill in the * required info
        </p>

        <form action="/book-room" method="POST">
         
          <!-- Name Fields -->
          <div class="row g-3 fade-up fade-delay-3">
            <div class="col-md-2">
              <label for="title" class="form-label">Title</label>
              <select class="form-select" id="title">
                <option>Mr</option>
                <option>Ms</option>
                <option>Mrs</option>
              </select>
            </div>


             <input type="hidden" name="rateKey" value="<?= esc($rateKey) ?>">
    
   
            <div class="col-md-5">
              <label for="fname" class="form-label">Full Name *</label>
              <input type="text" class="form-control" name="name" required />
            </div>
            <div class="col-md-5">
              <label for="lname" class="form-label">Sur Name *</label>
              <input type="text" class="form-control" name="surname"  required />
            </div>
          </div>
          <div class="row mt-3 align-items-end fade-up fade-delay-5">
            <div class="col-md-12">
              <label for="phone" class="form-label"
                >Telephone (mobile preferred) *</label
              >
              <input type="tel" class="form-control" id="phone" required />
            </div>
          </div>


          <!-- Card Details Section -->
        <div class="row mt-4 fade-up fade-delay-6">
        <div class="col-md-12">
            <h5 class="mb-3">Card Details</h5>
        </div>

        <div class="col-md-6">
            <label for="card_number" class="form-label">Card Number *</label>
            <input type="text" class="form-control" name="card_number" id="card_number" placeholder="•••• •••• •••• ••••" required />
        </div>

        <div class="col-md-3">
            <label for="card_expiry" class="form-label">Expiry Date *</label>
            <input type="text" class="form-control" name="card_expiry" id="card_expiry" placeholder="MM/YY" required />
        </div>

        <div class="col-md-3">
            <label for="card_cvc" class="form-label">CVC *</label>
            <input type="text" class="form-control" name="card_cvc" id="card_cvc" placeholder="123" required />
        </div>

        <div class="col-md-4 mt-3">
            <label for="card_zip" class="form-label">ZIP / Postal Code *</label>
            <input type="text" class="form-control" name="card_zip" id="card_zip" required />
        </div>
        </div>
          
          <!-- Button -->
          <div class="text-end next-btn fade-up fade-delay-6">
            <button type="submit" class="btn btn-success btn-lg">
              Next: Final details
            </button>
            <div class="text-muted mt-1 small">
              Don't worry – you won't be charged yet!
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>

