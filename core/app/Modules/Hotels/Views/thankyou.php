
    <style>
      .confirmation-container {
        max-width: 700px;
        margin: 50px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        animation: fadeSlideUp 1s ease forwards;
      }

      h2 {
        font-weight: bold;
        color: #28a745;
      }

      .fade-item {
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

      @keyframes fadeSlideUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes fadeUp {
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .info-label {
        font-weight: 600;
        color: #333;
      }

      .info-value {
        color: #555;
      }

      .thank-you-msg {
        background-color: #e9fce9;
        padding: 20px;
        border-left: 5px solid #28a745;
        border-radius: 8px;
      }
    </style>
    <div class="confirmation-container" style="margin-top: 150px !important;">
        <div class="text-center mb-4">
            <h2 class="fw-semibold">Booking Confirmed!</h2>
            <p class="text-muted fs-16px">Thank you for booking with Hotel Room Discount</p>
        </div>

        <hr>

        <div>
            <p>
                <span class="info-label fs-16px"> Hotel Name:</span>
                <span class="info-value fs-16px"><?= esc($booking['hotel']['name']) ?></span>
            </p>
            <p>
                <span class="info-label fs-16px"> Address:</span>
                <span class="info-value fs-16px"><?= esc($booking['hotel']['zoneName']) ?>, <?= esc($booking['hotel']['destinationName']) ?></span>
            </p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <p>
                    <span class="info-label fs-16px"> Check-in Date:</span>
                    <span class="info-value fs-16px"><?= esc($booking['hotel']['checkIn']) ?></span>
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    <span class="info-label fs-16px"> Check-out Date:</span>
                    <span class="info-value fs-16px"><?= esc($booking['hotel']['checkOut']) ?></span>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <p>
                    <span class="info-label fs-16px"> Buyer Name:</span>
                    <span class="info-value fs-16px"><?= esc($booking['holder']['name']) ?></span>
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    <span class="info-label fs-16px"> Surname:</span>
                    <span class="info-value fs-16px"><?= esc($booking['holder']['surname']) ?></span>
                </p>
            </div>
        </div>

        <div>
              <?php 
                  $currencySymbols = [
                      'USD' => '$',
                      'EUR' => '€',
                      'GBP' => '£',
                      'INR' => '₹',
                      'JPY' => '¥',
                  ];

                  $currencySymbol = isset($currencySymbols[$booking['currency']]) ? $currencySymbols[$booking['currency']] : $booking['currency'];

                  helper('generic_helper');
                  
                  $sellingPrice = $booking['totalNet'] !== '' ? calculateProfitPrice($booking['totalNet']) : ''; 
                  $pendingAmount = $booking['pendingAmount'] !== '' ? calculateProfitPrice($booking['pendingAmount']) : ''; 
              ?>
            <p>
                <span class="info-label"> Room Type:</span>
                <span class="info-value"><?= esc($booking['hotel']['rooms'][0]['name']) ?></span>
            </p>
            
            <p>
                <span class="info-label"> Total:</span>
                <span class="info-value"><?= esc($currencySymbol) ?> <?= esc($price) ?></span>
            </p>
            <p>
              
                <span class="info-label">Pending:</span>
                <span class="info-value"><?= esc($currencySymbol) ?> <?= esc($pendingAmount) ?></span>
            </p>
        </div>

        <div class="thank-you-msg mt-4 text-center">
            <h5 class="text-success fs-20px">We're thrilled to have you!</h5>
            <p class="fs-16px lato">Your booking is confirmed. If you need to make changes, contact us any time. Safe travels and see you soon!</p>
        </div>
    </div>
</body>
</html>
