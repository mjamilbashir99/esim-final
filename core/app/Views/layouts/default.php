<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'My Website' ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css" />

    <link
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
      rel="stylesheet" />


    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
      rel="stylesheet" />
    <!-- <link href="./style.css" rel="stylesheet" /> -->
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet" />
  </head>

  <body>
    <section
      class="w-100 position-relative d-flex align-items-center justify-content-center text-white text-center"
      style="
    height: 350px;
    background: linear-gradient(rgba(30, 41, 59, 0.6), rgba(30, 41, 59, 0.6)),
      url('<?= base_url('assets/img/bg-head.jpg'); ?>') center/cover no-repeat;
    overflow: hidden;
  ">
      <div style="
    position: absolute;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 60%);
    top: -100px;
    right: -100px;
    z-index: 1;
  "></div>

      <div style="z-index: 2;">
        <h1
          class="display-5 fw-bold mb-2"
          style="text-shadow: 1px 1px 4px rgba(0,0,0,0.4); font-family: 'Montserrat', sans-serif;">
          Hotel Booking
        </h1>
        <p style="font-size: 1.05rem; opacity: 0.9; font-family: 'Lato', sans-serif;">
          Best prices across 70+ platforms. Real Reviews. No Hidden Fees.
        </p>
      </div>

      <div style="position:absolute; bottom:-1px; width:100%; overflow:hidden; line-height:0;">
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 60px; width: 100%;">
          <path d="M0.00,49.98 C150.00,150.00 349.33,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
            style="stroke: none; fill: #ffffff;"></path>
        </svg>
      </div>
    </section>


    <div class="content">
      <?= $content ?>
    </div>

    <footer class="container-fluid d-flex flex-column align-items-center justify-content-center"
      style="
    position: relative;
    background: radial-gradient(circle at bottom center, #0d1b2a, #000814);
    color: #fff;
    padding: 60px 20px 40px;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
    z-index: 1;
    border-top-left-radius: 40px;
    border-top-right-radius: 40px;
  ">

      <div style="position: absolute; bottom: -50px; left: 10%; width: 200px; height: 200px; background: #00f7ff; opacity: 0.2; filter: blur(80px); z-index: 0;"></div>
      <div style="position: absolute; bottom: -60px; right: 10%; width: 150px; height: 150px; background: #ff4ecd; opacity: 0.15; filter: blur(70px); z-index: 0;"></div>

      <div class="rounded-4 shadow-lg"
        style="
      backdrop-filter: blur(20px);
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      padding: 30px 40px;
      width: 100%;
      max-width: 900px;
      text-align: center;
      z-index: 2;
    ">

        <h2 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 20px; letter-spacing: 1px; color: #ffffffee;">
          Hotel Room Discount
        </h2>

        <div class="d-flex flex-wrap justify-content-center" style="gap: 30px; font-size: 1rem;">
          <a href="#" style="color: #d3f8ff; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#00f7ff'" onmouseout="this.style.color='#d3f8ff'">About Us</a>
          <a href="#" style="color: #d3f8ff; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#00f7ff'" onmouseout="this.style.color='#d3f8ff'">Why Book With Us</a>
          <a href="#" style="color: #d3f8ff; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#00f7ff'" onmouseout="this.style.color='#d3f8ff'">Airport Transfer</a>
          <a href="#" style="color: #d3f8ff; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#00f7ff'" onmouseout="this.style.color='#d3f8ff'">Contact</a>
        </div>
        <div style="margin: 30px auto 25px; width: 60px; height: 3px; background: linear-gradient(90deg, #00ffe5, #ff00e0); border-radius: 10px;"></div>

        <div style="margin-top: 30px; font-size: 0.9rem; color: #ffffff99;">
          © 2025 <span style="color: #00f7ff">Hotel Room Discount</span> – All rights reserved.
        </div>
      </div>
    </footer>



    <!-- Bootstrap Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>

</body>

</html>