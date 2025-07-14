
<!-- <h2>Hotel Details</h2> -->
<!-- <h2>Hotel Name: <?= esc($hotelDetails['hotel']['name']['content'] ?? 'N/A') ?></h2>
<h2>Hotel Name: <?= esc($hotelDetails['hotel']['description']['content'] ?? 'N/A') ?></h2> -->

<!-- <pre><?php print_r($hotelDetails); ?></pre> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .image-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
    }
    .image-control{
        width:80%;
        max-height:450px;
    }
    .swal2-popup.no-padding-popup {
        padding: 0;
        background: transparent;
        box-shadow: none;
    }

    .swal-large-image {
        /* max-width: 90vw;
        max-height: 90vh; */
        width: 700px;
        height: auto;
        border-radius: 8px;
    }
    
</style>
<!-- Image galery -->
 <style>
      .gallery-thumbnail {
        cursor: pointer;
        opacity: 0.6;
        transition: 0.3s;
        flex: 0 0 auto;
        max-width: 150px;
        margin-right: 10px;
      }

      .gallery-thumbnail.active,
      .gallery-thumbnail:hover {
        opacity: 1;
        border: 2px solid #0d6efd;
      }

      .main-image {
        width: 100%;
        max-height: 350px;
        object-fit: cover;
      }

      .image-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        font-size: 2rem;
        padding: 0.5rem 1rem;
        cursor: pointer;
        z-index: 10;
      }

      .nav-arrow.left {
        left: 10px;
      }

      .nav-arrow.right {
        right: 10px;
      }

      .counter {
        position: absolute;
        top: 15px;
        right: 20px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 1rem;
        z-index: 11;
      }

      .thumbnails-scroll {
        display: flex;
        overflow-x: auto;
        padding-bottom: 10px;
        scroll-behavior: smooth;
      }

      .thumbnails-scroll::-webkit-scrollbar {
        display: none;
      }
      tr{
        font-size: 16px !important;
      }
    </style>
<div class="container "  style="margin-top:150px">
      <div class="card  content-section overflow-hidden">
        <div
          class="card-body d-flex flex-sm-column flex-md-column flex-lg-row flex-wrap"
        >
          <div class="col-md-12 col-12 mb-3">
            <div class="d-flex justify-content-between mbl-flex-col">
              <div class="">
                <div class="mb-3">
                  <h1 class="card-title h3"><?= esc($hotelDetails['hotel']['name']['content'] ?? 'N/A') ?></h1>
                  <!-- <div class="lato"><?= esc($hotelDetails['hotel']['address']['content'] ?? 'N/A') ?></div> -->
                 
                </div>

                <!-- <div class="d-flex align-items-center gap-3">
                  <div class="rating-circle"><?= esc($hotelDetails['hotel']['category']['description']['content'] ?? 'N/A') ?></div>
                  <div> -->
                  <?php
                    function getStarRatingHtml($ratingString) {
                    $ratingStars = '';

                    if (!empty($ratingString)) {
                        preg_match('/(\d+(\.\d+)?)/', $ratingString, $matches);

                        if (!empty($matches)) {
                            $numericRating = floatval($matches[0]);
                            $fullStars = floor($numericRating);
                            $halfStar = ($numericRating - $fullStars) >= 0.5;
                            $ratingStars .= str_repeat('<i class="fas fa-star text-warning"></i>', $fullStars);
                            if ($halfStar) {
                                $ratingStars .= '<i class="fas fa-star-half-alt text-warning"></i>';
                            }
                            $totalStars = $fullStars + ($halfStar ? 1 : 0);
                            $ratingStars .= str_repeat('<i class="far fa-star text-warning"></i>', 5 - $totalStars);
                        }
                    }

                    return $ratingStars;
                }
                ?>

                <div class="lato d-flex align-items-center gap-2 flex-wrap">
                    <span><?= esc($hotelDetails['hotel']['address']['content'] ?? 'N/A') ?></span>
                    <span class="rating-stars"><?= getStarRatingHtml($hotelDetails['hotel']['category']['description']['content'] ?? '') ?></span>
                </div>

              </div>
              <div
                class="d-flex flex-column pt-4 py-sm-0 justify-content-md-between justify-content-sm-start mt-auto"
              >
                <div
                  class="d-flex gap-2 align-items-center justify-content-xs-start justify-content-md-between mobile-flex-sart"
                >
                  <b class="lato">Ranking: <?= esc($hotelDetails['hotel']['ranking'] ?? 'N/A') ?></b>
                </div>
                <div class="form-check w-100 pl-0">
                  <label
                    class="form-check-label d-flex justify-content-md-between justify-content-start gap-2"
                    for="rating5"
                  >
                    
                  </label>
                </div>
              </div>
            </div>
            <div class="my-3">
              <div
                class="d-flex gap-3 justify-content-evenly">
                <a
                  href="#photos"
                  class="section-link selected text-decoration-none text-secondary py-2 fw-semibold  text-center"
                  >Photos</a
                >
                <a
                  href="#details"
                  class="section-link text-decoration-none text-secondary py-2 fw-semibold  text-center"
                  >Details</a
                >
                <a
                  href="#rooms"
                  class="section-link text-decoration-none text-secondary py-2 fw-semibold text-center"
                  >Rooms</a
                >
                <a
                  href="#amenities"
                  class="section-link text-decoration-none text-secondary py-2 fw-semibold text-center"
                  >Amenities</a
                >
              </div>
            </div>
            
            <?php

                helper('generic_helper');
              
                $imageBaseUrl = 'https://photos.hotelbeds.com/giata/';
                $images = $hotelDetails['hotel']['images'] ?? [];
                $totalImages = count($images);
            ?>

                <div id="photos" class="flex-column flex-lg-row d-lg-flex gap-2">
                <?php if (!empty($images)): ?>
                    <img
                        src="<?= getAvailableImageUrl($images[0]['path']) ?>"
                        alt="Hotel Image"
                        class="property-image w-100 rounded mb-3"
                        data-bs-toggle="modal" data-bs-target="#galleryModal"
                    />
                    <div class="d-flex flex-wrap gap-2 flex-lg-column mbl-flex-row">
                        <?php foreach (array_slice($images, 1, 4) as $img): ?>
                            <img
                                src="<?= getAvailableImageUrl($img['path']) ?>"
                                class="image-thumbnail rounded"
                                alt="<?= $img['type']['description']['content'] ?? 'Hotel Image' ?>"
                                data-bs-toggle="modal" data-bs-target="#galleryModal"
                            />
                        <?php endforeach; ?>

                        <?php if ($totalImages > 5): ?>
                            <div class="position-relative" data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer;">
                                <img
                                    src="<?= getAvailableImageUrl($images[5]['path']) ?>"
                                    class="image-thumbnail rounded"
                                    alt="More Photos"
                                    style="filter: brightness(50%);"
                                />
                                <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-6">
                                    +<?= $totalImages - 5 ?> photos
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content" style="padding:20px;">
                            <div class="modal-header">
                                <h5 class="modal-title">Photo Gallery</h5>
                                <button type="button " class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="image-wrapper mb-3">
                                <div class="counter" id="imageCounter">1 / 1</div>
                                <button class="nav-arrow left" onclick="prevImage()">‹</button>
                                <img id="mainImage" src="" class="img-fluid main-image" alt="Gallery Image" />
                                <button class="nav-arrow right" onclick="nextImage()">›</button>
                            </div>

                            <div class="thumbnails-scroll px-2" id="thumbnailsContainer">
                                <!-- Thumbnails will be injected here -->
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Image Slider Modal -->
                <div class="modal fade" id="sliderModal" tabindex="-1" aria-labelledby="sliderModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content" style="background:#ebebeb">
                            <div class="modal-header border-0">
                                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div id="sliderCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner" id="carouselInner"></div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#sliderCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" style="color:black"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#sliderCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
      </div>
    </div>

    <?php
        $facilityIcons = [
            'room' => 'fa-door-closed',
            'hotel' => 'fa-hotel',
            'wheelchair' => 'fa-wheelchair',
            'car park' => 'fa-parking',
            'valet' => 'fa-parking',
            '24-hour reception' => 'fa-clock',
            'wi-fi' => 'fa-wifi',
            'car hire' => 'fa-car',
            'airport shuttle' => 'fa-shuttle-van',
            'room service' => 'fa-bell',
            'laundry' => 'fa-soap',
            'security' => 'fa-user-shield',
            'bellboy' => 'fa-bell-concierge',
            'safe' => 'fa-lock',
            'currency exchange' => 'fa-money-bill-wave',
            'lift' => 'fa-elevator',
            'concierge' => 'fa-concierge-bell',
            'newspapers' => 'fa-newspaper',
            'luggage' => 'fa-suitcase-rolling',
            'clothes dryer' => 'fa-tshirt',
            'towels' => 'fa-bath',
            'bed linen' => 'fa-bed',
            'café' => 'fa-coffee',
            'bar' => 'fa-glass-martini-alt',
            'restaurant' => 'fa-utensils',
            'smoking area' => 'fa-smoking',
            'banquet' => 'fa-chair',
            'meeting room' => 'fa-handshake',
            'business centre' => 'fa-briefcase',
            'indoor pool' => 'fa-swimming-pool',
            'hairdressing' => 'fa-cut',
            'breakfast' => 'fa-bread-slice',
            'non-smoking' => 'fa-ban-smoking',
            'fitness' => 'fa-dumbbell',
        ];
    ?>




<div class="content-section mt-4 px-3 py-2" style="background-color:white;" id="details">
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold fs-20px mb-0"  >
      <a  style="color:rgb(33, 37, 41) !important" class="text-decoration-none  fw-semibold" data-bs-toggle="collapse" href="#detailsContent" role="button" aria-expanded="false" aria-controls="detailsContent">
        Details
      </a>
    </h2>
    <i id="detailsIcon" class="bi bi-chevron-down fs-6" data-bs-toggle="collapse" data-bs-target="#detailsContent" role="button" aria-expanded="false"></i>
  </div>

  <div id="detailsContent" class="collapse mt-2">
    <p class="fs-14px  fw-normal">
      <?= esc($hotelDetails['hotel']['description']['content'] ?? 'N/A') ?>
      <?= esc($hotelDetails['hotel']['description']['content'] ?? 'N/A') ?>
    </p>
  </div>
</div>


    <!-- Aminities Sections -->
    <!-- <div class="container my-4 p-0 sahdow" style="background-color: white;">
        
        <?php if (isset($hotelDetails['hotel']['facilities']) && is_array($hotelDetails['hotel']['facilities'])): ?>
            <h2 style="padding-left: 10px; " class=" fs-20px fw-semibold" id="amenities">Amenities</h2>
            <div class="d-flex overflow-auto gap-3 px-2">
                
                <?php foreach ($hotelDetails['hotel']['facilities'] as $facility): ?>
                    <?php
                        $description = strtolower($facility['description']['content'] ?? '');
                        $iconClass = 'fa-concierge-bell'; // default icon

                        foreach ($facilityIcons as $keyword => $icon) {
                            if (strpos($description, $keyword) !== false) {
                                $iconClass = $icon;
                                break;
                            }
                        }
                    ?>
                    <div class="flex-shrink-0 border rounded p-3 text-center" style="min-width: 150px;">
                        <i class="fas <?= $iconClass ?> fa-2x mb-2"></i>
                        <div class="lato"><?= $facility['description']['content'] ?? 'Facility Info' ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div> -->


   



     


      

      <div id="rooms" class="content-section content-section-overflow px-2">
        <div class="table-responsive">
            <table class="table">
              <thead>
                  <tr>
                      <th>Room Name</th>
                      <th>Room Description</th>
                      <th>Characteristics</th>
                      <th>Guests</th>
                      <th>Board</th>
                      <!-- <th>Rate Key</th> -->
                      <th>Select</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                    $searchAdults = $getSearchedAdults;
                    $roomShown = false;
                    $adultsInSession = session()->get('adults_store_in_session') ?? 0;
                    // var_dump($searchAdults);
                ?>
              
                  <?php if (!empty($rateData['rooms'])): ?>
                    <?php foreach ($rateData['rooms'] as $index => $room): ?>
                        <?php 
                            $detailsRoom = $hotelDetails['hotel']['rooms'][$index] ?? null;
                            $maxAdults = $detailsRoom['maxAdults'] ?? 0;
                            // var_dump($maxAdults);die();
                            if ($maxAdults !== $searchAdults) {
                                continue; // skip this room if it can't fit all adults
                            }

                            $roomShown = true; 
                        ?>
                        
                        <?php foreach ($room['rates'] as $rate): ?>
                            <tr>
                                <td class="text-lowercase"><?= htmlspecialchars($room['name']) ?></td>
                                <td class="text-lowercase"><?= htmlspecialchars($detailsRoom['description'] ?? 'N/A') ?></td>
                                <td class="text-lowercase"><?= htmlspecialchars($detailsRoom['characteristic']['description']['content'] ?? 'N/A') ?></td>
                                <td class="text-lowercase">
                                    <?php 
                                        $adultsInSession = session()->get('adults') ?? 0; 
                                        $maxAdults = $detailsRoom['maxAdults'] ?? 0;
                                        $maxChildren = $detailsRoom['maxChildren'] ?? 0;
                                    ?>
                                    <?php for ($i = 0; $i < $maxAdults; $i++): ?>
                                        <i class="fas fa-user" title="Adult"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = 0; $i < $maxChildren; $i++): ?>
                                        <i class="fas fa-child" title="Child"></i>
                                    <?php endfor; ?>
                                </td>
                                <td class="text-lowercase"><?= htmlspecialchars($rate['boardName']) ?></td>
                                <!-- <td><small><?= htmlspecialchars($rate['rateKey']) ?></small></td> -->
                                <td>
                                    <form onsubmit="return checkRate(this);">
                                        <input type="hidden" name="rateKey" value="<?= htmlspecialchars($rate['rateKey']) ?>">
                                        <button type="submit" class="btn btn-primary btn-sm btn-search"style="font-size:16px !important;width: 110px;padding: 5px;">Select Room</button>
                                    </form>
                                    <tr class="rate-info-row" style="display:none;">
                                        <td colspan="7" class="rate-info-cell"></td>
                                    </tr>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <?php if (!$roomShown): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No room information available. Please try another hotel or search again.
                            </td>
                        </tr>
                    <?php endif; ?>

                  <?php else: ?>
                      <tr>
                          <td colspan="7" class="text-center text-muted">No room information available. Please try another hotel or search again.</td>
                      </tr>
                  <?php endif; ?>

              </tbody>
            </table>

        </div>
    </div>



    <div class="container my-4 py-4 content-section" style="background-color: white;">
    <?php if (isset($hotelDetails['hotel']['facilities']) && is_array($hotelDetails['hotel']['facilities'])): ?>
        <h2 style="padding-left: 10px;" class="fs-20px fw-semibold mb-4" id="amenities">Amenities</h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 px-3 py-0">
            <?php foreach ($hotelDetails['hotel']['facilities'] as $facility): ?>
                <div class="col" style="margin: 0 !important;">
                    <div class="d-flex align-items-center gap-2" style="height: 30px !important;">
                        <i class="bi bi-check text-success mt-1 fs-5"></i>
                        <span class="lato fs-16px">
                            <?= $facility['description']['content'] ?? 'Facility Info' ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
    </div>
<script>


function calculateProfitPrice(netPrice) {
    // const profitMultiplier = 1.15; 
    const profitMultiplier = <?= $convertedProfitAmount ?>; 
    // alert(profitMultiplier);
    return Math.round(netPrice * profitMultiplier * 100) / 100;
}


// function checkRate(form) {
//     event.preventDefault();

//     const rateKey = form.querySelector('input[name="rateKey"]').value;
//     const row = form.closest('tr');
//     const infoRow = row.nextElementSibling;

//     fetch('<?= base_url('check-rate') ?>', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded',
//             'X-Requested-With': 'XMLHttpRequest'
//         },
//         body: new URLSearchParams({ rateKey })
//     })
//     .then(async res => {
//         let data;
//         try {
//             data = await res.json();
//         } catch (e) {
//             throw new Error('Invalid JSON response');
//         }

//         let message = '';

//         if (!res.ok) {
//             console.log('HTTP error:', res.status, data?.error);
//             if (res.status === 403 || (data?.error && data.error.toLowerCase().includes('quota'))) {
//                 message = '<div class="text-warning">There is a technical issue. Please try again later.</div>';
//             } else {
//                 message = '<div class="text-danger">Allotments not available. Please try another room.</div>';
//             }
//         } else if (data.error) {
//             console.log('API error:', data.error);
//             if (data.error.toLowerCase().includes('quota')) {
//                 message = '<div class="text-danger">There is a technical issue. Please try again later.</div>';
//             } else {
//                 message = '<div class="text-danger">Allotments not available. Please try another room.</div>';
//             }
//         } else if (!data.hotel || !data.hotel.rooms || !data.hotel.rooms[0] || !data.hotel.rooms[0].rates) {
//             message = '<div class="text-danger">Allotments not available. Please try another room.</div>';
//         } else {
//             const hotelName = data.hotel.name; // get hotel name
//             // const price = data.hotel.rooms[0].rates[0].net;

//             const netPrice = data.hotel.rooms[0].rates[0].net;
//             const price = calculateProfitPrice(netPrice);
//             // alert(price);
//             const currency = data.hotel.currency;

//             const currencySymbols = {
//                 'USD': '$',
//                 'EUR': '€',
//                 'GBP': '£',
//                 'INR': '₹',
//                 'JPY': '¥'
//             };

//             const currencySymbol = currencySymbols[currency] || currency;
//             // const price = data.hotel.rooms[0].rates[0].net;
//             // const currency = data.hotel.currency;
//             const cancellation = data.hotel.rooms[0].rates[0].cancellationPolicies?.map(p =>
//                 `Cancel before <strong>${p.from}</strong>`).join('<br>') || 'No policy found.';

//           message = `
//             <div class="bg-light p-3 rounded border">
//                 <strong>Net Price:</strong> ${currencySymbol} ${price}<br>
//                 <strong>Cancellation Policy: </strong>${cancellation}
//                 <div class="mt-2">
//                     <form action="<?= base_url('checkout') ?>" method="GET">
//                         <input type="hidden" name="rateKey" value="${encodeURIComponent(rateKey)}">
//                         <input type="hidden" name="hotelName" value="${encodeURIComponent(hotelName)}">
//                         <input type="hidden" name="price" value="${encodeURIComponent(price)}">
//                         <input type="hidden" name="currency" value="${encodeURIComponent(currency)}">
//                         <button type="submit" class="btn btn-success btn-sm btn-search">Book Now</button>
//                     </form>
//                 </div>
//             </div>`;

//         }

//         infoRow.querySelector('.rate-info-cell').innerHTML = message;
//         infoRow.style.display = 'table-row';
//     })
//     .catch(err => {
//         console.error('Fetch error:', err);
//         infoRow.querySelector('.rate-info-cell').innerHTML = '<div class="text-danger">No availability for this room at the moment.</div>';
//         infoRow.style.display = 'table-row';
//     });

//     return false;
// }

function checkRate(form) {
    event.preventDefault();

    const rateKey = form.querySelector('input[name="rateKey"]').value;
    const row = form.closest('tr');
    const infoRow = row.nextElementSibling;

    fetch('<?= base_url('check-rate') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({ rateKey })
    })
    .then(async res => {
        let data;
        try {
            data = await res.json();
        } catch (e) {
            throw new Error('Invalid JSON response');
        }

        let message = '';

        if (!res.ok) {
            console.log('HTTP error:', res.status, data?.error);
            if (res.status === 403 || (data?.error && data.error.toLowerCase().includes('quota'))) {
                message = '<div class="text-warning">There is a technical issue. Please try again later.</div>';
            } else {
                message = '<div class="text-danger">Allotments not available. Please try another room.</div>';
            }
        } else if (data.error) {
            console.log('API error:', data.error);
            if (data.error.toLowerCase().includes('quota')) {
                message = '<div class="text-danger">There is a technical issue. Please try again later.</div>';
            } else {
                message = '<div class="text-danger">Allotments not available. Please try another room.</div>';
            }
        } else if (!data.hotel || !data.hotel.rooms || !data.hotel.rooms[0] || !data.hotel.rooms[0].rates) {
            message = '<div class="text-danger">Allotments not available. Please try another room.</div>';
        } else {
            const hotelName = data.hotel.name; // get hotel name
            // const price = data.hotel.rooms[0].rates[0].net;

            const netPrice = data.hotel.rooms[0].rates[0].net;
            const price = calculateProfitPrice(netPrice);
            // alert(price);
            const currency = data.hotel.currency;

            const currencySymbols = {
                'USD': '$',
                'EUR': '€',
                'GBP': '£',
                'INR': '₹',
                'JPY': '¥'
            };

const currencySymbol = currencySymbols[currency] || currency;
// const price = data.hotel.rooms[0].rates[0].net;
// const currency = data.hotel.currency;

let cancellation;

const policies = data.hotel.rooms[0].rates[0].cancellationPolicies;

if (policies && policies.length > 0) {
    const p = policies[0]; // Only using the first policy, same as PHP

    const fromDate = new Date(p.from);
    const month = fromDate.toLocaleString('default', { month: 'long' });
    const day = fromDate.getDate();
    const year = fromDate.getFullYear();
    const hours = fromDate.getHours() % 12 || 12;
    const minutes = fromDate.getMinutes().toString().padStart(2, '0');
    const ampm = fromDate.getHours() >= 12 ? 'PM' : 'AM';
    const formattedDate = `${month} ${day}, ${year} at ${hours}:${minutes} ${ampm}`;

    const amount = parseFloat(p.amount).toFixed(2);
    cancellation = `<p class="text-danger" style="font-size: 16px;">
        <strong style="color: black">Cancellation Policy: </strong> Cancellation fee of ${currencySymbol}${amount} applies from ${formattedDate}.
    </p>`;
} else {
    cancellation = `<p class="text-success" style="font-size: 12px;">No cancellation policy!</p>`;
}

message = `
    <div class="bg-light p-3 rounded border">
        <strong>Net Price:</strong> ${currencySymbol} ${price}<br>
        <div class="mt-2">
        ${cancellation}
            <form action="<?= base_url('checkout') ?>" method="GET">
                <input type="hidden" name="rateKey" value="${encodeURIComponent(rateKey)}">
                <input type="hidden" name="hotelName" value="${encodeURIComponent(hotelName)}">
                <input type="hidden" name="price" value="${encodeURIComponent(price)}">
                <input type="hidden" name="currency" value="${encodeURIComponent(currency)}">
                <button type="submit" class="btn btn-success btn-sm btn-search">Book Now</button>
            </form>
        </div>
    </div>`;
        }
infoRow.querySelector('.rate-info-cell').innerHTML = message;
infoRow.style.display = 'table-row';

    })
    .catch(err => {
        console.error('Fetch error:', err);
        infoRow.querySelector('.rate-info-cell').innerHTML = '<div class="text-danger">No availability for this room at the moment.</div>';
        infoRow.style.display = 'table-row';
    });

    return false;
}


</script>

<script>
    // function handleBooking(form) {
    //     event.preventDefault();

    //     fetch('/is-logged-in', {
    //         method: 'GET',
    //         headers: {
    //             'X-Requested-With': 'XMLHttpRequest'
    //         }
    //     })
    //     .then(res => res.json())
    //     .then(data => {
    //         if (data.logged_in) {
    //             alert('You can now proceed with booking.');
    //             // Optionally, open a modal or proceed with booking logic
    //         } else {
    //             // Save current URL and redirect
    //             const currentUrl = window.location.href;
    //             fetch('/set-redirect-url', {
    //                 method: 'POST',
    //                 headers: {
    //                     'Content-Type': 'application/x-www-form-urlencoded',
    //                     'X-Requested-With': 'XMLHttpRequest'
    //                 },
    //                 body: new URLSearchParams({ url: currentUrl })
    //             }).then(() => {
    //                 window.location.href = '/login';
    //             });
    //         }
    //     });

    //     return false;
    // }

// function handleBooking(form) {
//     event.preventDefault();

//     const rateKey = form.querySelector('input[name="rateKey"]').value;

//     fetch('/book-room', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded',
//             'X-Requested-With': 'XMLHttpRequest'
//         },
//         body: new URLSearchParams({ rateKey })
//     })
//     .then(res => res.json())
//     .then(data => {
//         if (data.success) {
//             alert('Booking successful! Booking reference: ' + data.booking.booking.reference);
//             // Optionally redirect to a booking summary page
//             // window.location.href = '/booking-confirmation/' + data.booking.booking.reference;
//         } else {
//             alert('Booking failed: ' + (typeof data.error === 'object' ? JSON.stringify(data.error) : data.error || 'Unknown error'));

//         }
//     })
//     .catch(err => {
//         console.error('Booking error:', err);
//         alert('Technical error occurred during booking.');
//     });

//     return false;
// }



function handleBooking(form) {
    event.preventDefault();

    const rateKey = form.querySelector('input[name="rateKey"]').value;

    fetch('<?= base_url('book-room') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({ rateKey })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Booking successful! Booking reference: ' + data.booking.booking.reference);
            // Optionally redirect to a booking summary page
            // window.location.href = '/booking-confirmation/' + data.booking.booking.reference;
        } else {
            alert('Booking failed: ' + (typeof data.error === 'object' ? JSON.stringify(data.error) : data.error || 'Unknown error'));

        }
    })
    .catch(err => {
        console.error('Booking error:', err);
        alert('Technical error occurred during booking.');
    });

    return false;
}


function redirectToCheckout(form) {
    event.preventDefault();

    const rateKey = form.querySelector('input[name="rateKey"]').value;

    // Redirect to a new page where user can fill out their details
    window.location.href = '<?= base_url('checkout') ?>?rateKey=' + encodeURIComponent(rateKey);
    return false;
}

</script>

<!-- For galery images -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const images = <?= json_encode($images) ?>;
        const baseUrl = '<?= $imageBaseUrl ?>';

        document.querySelectorAll('.gallery-image').forEach(img => {
            img.addEventListener('click', function () {
                const startIndex = parseInt(this.dataset.index);

                Swal.fire({
                    imageUrl: baseUrl + images[startIndex].path,
                    imageAlt: 'Hotel Image',
                    showConfirmButton: false,
                    background: 'transparent',
                    backdrop: true,
                    customClass: {
                        popup: 'no-padding-popup',
                        image: 'swal-large-image'
                    }
                });
            });
        });
    });
</script>


<!-- Galery images js -->
 <!-- <script>
    const images = <?= json_encode(array_map(function ($img) use ($imageBaseUrl) {
        return $imageBaseUrl . $img['path'];
    }, $images)) ?>;

    let currentIndex = 0;
    const mainImage = document.getElementById("mainImage");
    const thumbnailsContainer = document.getElementById("thumbnailsContainer");
    const counter = document.getElementById("imageCounter");

    function loadThumbnails() {
        thumbnailsContainer.innerHTML = "";
        images.forEach((src, index) => {
            const img = document.createElement("img");
            img.src = src;
            img.className = "img-fluid gallery-thumbnail";
            img.onclick = () => {
                currentIndex = index;
                updateMainImage();
            };
            if (index === currentIndex) img.classList.add("active");
            thumbnailsContainer.appendChild(img);
        });
    }

    function updateMainImage() {
        mainImage.src = images[currentIndex];
        counter.textContent = `${currentIndex + 1} / ${images.length}`;

        const thumbnails = thumbnailsContainer.querySelectorAll(".gallery-thumbnail");
        thumbnails.forEach((el, i) => {
            el.classList.toggle("active", i === currentIndex);
        });

        if (thumbnails[currentIndex]) {
            thumbnails[currentIndex].scrollIntoView({
                behavior: "smooth",
                inline: "center",
                block: "nearest",
            });
        }
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        updateMainImage();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateMainImage();
    }

    window.onload = function () {
        if (images.length > 0) {
            loadThumbnails();
            updateMainImage();
        }
    };
</script> -->


<script>
    const imagePaths = <?= json_encode(array_map(function ($img) {
        return $img['path'];
    }, $images)) ?>;

    const baseUrls = [
        'https://photos.hotelbeds.com/giata/xxl/',
        'https://photos.hotelbeds.com/giata/xl/',
        'https://photos.hotelbeds.com/giata/bigger/',
        'https://photos.hotelbeds.com/giata/'
    ];

    const images = [];
    let currentIndex = 0;
    const mainImage = document.getElementById("mainImage");
    const thumbnailsContainer = document.getElementById("thumbnailsContainer");
    const counter = document.getElementById("imageCounter");

    function tryImageFallback(path, callback) {
        let index = 0;

        function tryNext() {
            if (index >= baseUrls.length) {
                callback('');
                return;
            }

            const url = baseUrls[index] + path;
            const img = new Image();
            img.onload = () => callback(url);
            img.onerror = () => {
                index++;
                tryNext();
            };
            img.src = url;
        }

        tryNext();
    }

    function loadAllImages(callback) {
        let loaded = 0;
        imagePaths.forEach((path, i) => {
            tryImageFallback(path, (finalUrl) => {
                images[i] = finalUrl;
                loaded++;
                if (loaded === imagePaths.length) callback();
            });
        });
    }

    function loadThumbnails() {
        thumbnailsContainer.innerHTML = "";
        images.forEach((src, index) => {
            const img = document.createElement("img");
            img.src = src;
            img.className = "img-fluid gallery-thumbnail";
            img.onclick = () => {
                currentIndex = index;
                updateMainImage();
            };
            if (index === currentIndex) img.classList.add("active");
            thumbnailsContainer.appendChild(img);
        });
    }

    function updateMainImage() {
        mainImage.src = images[currentIndex];
        counter.textContent = `${currentIndex + 1} / ${images.length}`;
        const thumbnails = thumbnailsContainer.querySelectorAll(".gallery-thumbnail");
        thumbnails.forEach((el, i) => {
            el.classList.toggle("active", i === currentIndex);
        });
        if (thumbnails[currentIndex]) {
            thumbnails[currentIndex].scrollIntoView({
                behavior: "smooth",
                inline: "center",
                block: "nearest",
            });
        }
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        updateMainImage();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateMainImage();
    }

    window.onload = function () {
        if (imagePaths.length > 0) {
            loadAllImages(() => {
                loadThumbnails();
                updateMainImage();
            });
        }
    };
   
    const detailsCollapse = document.getElementById('detailsContent');
  const detailsIcon = document.getElementById('detailsIcon');

  detailsCollapse.addEventListener('show.bs.collapse', function () {
    detailsIcon.classList.remove('bi-chevron-down');
    detailsIcon.classList.add('bi-chevron-up');
  });

  detailsCollapse.addEventListener('hide.bs.collapse', function () {
    detailsIcon.classList.remove('bi-chevron-up');
    detailsIcon.classList.add('bi-chevron-down');
});


//  section active tab
  const sectionLinks = document.querySelectorAll('.section-link');

// Add active class to first link by default
sectionLinks[0].classList.add('selected');

// Add click event to all links
sectionLinks.forEach(link => {
  link.addEventListener('click', function () {
    // Remove active class from all
    sectionLinks.forEach(l => l.classList.remove('selected'));
    
    // Add active class to clicked one
    this.classList.add('selected');
  });
  });

</script>
