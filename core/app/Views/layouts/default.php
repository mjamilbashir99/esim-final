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
  "
>
  <!-- Glow Shape -->
  <div style="
    position: absolute;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 60%);
    top: -100px;
    right: -100px;
    z-index: 1;
  "></div>

  <!-- Content -->
  <div style="z-index: 2;">
    <h1
      class="display-5 fw-bold mb-2"
      style="text-shadow: 1px 1px 4px rgba(0,0,0,0.4); font-family: 'Montserrat', sans-serif;"
    >
      Hotel Booking
    </h1>
    <p style="font-size: 1.05rem; opacity: 0.9; font-family: 'Lato', sans-serif;">
      Best prices across 70+ platforms. Real Reviews. No Hidden Fees.
    </p>
  </div>

  <!-- Bottom Wave Divider -->
  <!-- <div style="position:absolute; bottom:-1px; width:100%; overflow:hidden; line-height:0;">
    <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 60px; width: 100%;">
      <path d="M0.00,49.98 C150.00,150.00 349.33,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
        style="stroke: none; fill: #ffffff;"></path>
    </svg>
  </div> -->
</section>


    <div class="content">
      <?= $content ?>
    </div>

    <footer class="w-100 container-fluid" style="background-color: #001c34">
      <ul
        class="navbar-nav d-flex flex-row justify-content-center py-2 fontSize mobile-col"
        style="gap: 20px; list-style: none; padding-left: 0">
        <li class="nav-item">
          <p
            class="nav-link active text-white m-0 fontSize"
            aria-current="page">
            COPYRIGHT © 2025 HOTEL ROOM DISCOUNT&nbsp;
            <span class="slash">|</span>
          </p>
        </li>
        <li class="nav-item">
          <a
            class="nav-link active text-white fontSize"
            aria-current="page"
            href="#">About Us <span class="slash">|</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fontSize" href="#">Why Booking With Us <span class="slash"> |</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fontSize" href="#">Airport Transfer</a>
        </li>
      </ul>
    </footer>

    <!-- Bootstrap Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>

</body>

</html>