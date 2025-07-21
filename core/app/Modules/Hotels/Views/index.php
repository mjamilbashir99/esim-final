<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Bootstrap Icons CDN (Include in your <head> or before closing </body>) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<main class="px-0">
    <section class="d-flex justify-content-center align-items-center animated-bg" style="min-height: 100vh; padding: 2rem;">
        <div class="p-5 rounded-5 shadow-lg text-white glass-bg" style="max-width: 800px; width: 100%;">

            <h1 class="text-center fw-bold mb-4" style="font-size: 2.2rem; letter-spacing: 1px; color: #ffe4e1;">Find the Best Places Today</h1>

            <form id="searchForm" onsubmit="handleSubmit(event)">
                <!-- Destination -->
                <div class="mb-4 position-relative">
                    <label for="searchInput" class="form-label fw-bold">Destination</label>
                    <input type="text" id="searchInput" name="destination"
                        class="form-control form-control-lg bg-transparent border-0 text-white"
                        placeholder="Search by name or location" style="border-bottom: 2px solid #ffffff55;" />

                    <!-- Loader Spinner -->
                    <div id="searchLoader" class="position-absolute" style="display: none; right: 20px; top: 60%; transform: translateY(-50%);">
                        <svg width="22" height="22" viewBox="0 0 50 50">
                            <circle cx="25" cy="25" r="20" stroke="#ffffffcc" stroke-width="4" fill="none"
                                stroke-linecap="round" />
                        </svg>
                    </div>

                    <!-- Suggestions -->
                    <div id="suggestions" class="list-group mt-2 fs-6 shadow-sm" style="cursor:pointer;"></div>
                    <div id="searchError" class="text-danger fw-bold mt-2" style="
                            display: none;
                            font-size: 14px;
                            margin-left: 2px;">&#9888; No results found
                    </div>
                </div>

                <!-- Dates & Nights -->
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label for="dateRange" class="form-label fw-bold">Dates</label>
                        <input type="text" id="dateRange" name="dateRange" class="form-control form-control-lg bg-transparent border-0 text-white" placeholder="Check-in & check-out" style="border-bottom: 2px solid #ffffff55;" />
                    </div>
                    <div class="col-md-4">
                        <label for="nights" class="form-label fw-bold">Nights</label>
                        <select id="nights"
                            class="form-select form-select-lg bg-transparent border-0 text-white"
                            style="
                                border-bottom: 2px solid #ffffff;
                                appearance: none;
                                -webkit-appearance: none;
                                -moz-appearance: none;
                                background-image: url('data:image/svg+xml;utf8,<svg fill=\'white\' height=\'20\' viewBox=\'0 0 24 24\' width=\'20\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>');
                                background-repeat: no-repeat;
                                background-position: right 0.75rem center;
                                background-size: 20px 20px;
                                padding-right: 2.5rem;
                            ">
                            <option class="dropdown-item text-black bg-white" value="" disabled selected hidden>Select Nights</option>
                            <script>
                                for (let i = 1; i <= 30; i++) {
                                    document.write(`<option class="text-black bg-white" value="${i}">${i}</option>`);
                                }
                            </script>
                        </select>


                    </div>
                </div>

                <input type="hidden" id="checkin" name="checkin">
                <input type="hidden" id="checkout" name="checkout">

                <!-- Travellers -->
                <div class="mb-4 position-relative" style="z-index: 10;">
                    <label for="passengerInput" class="form-label fw-bold">Travellers</label>
                    <input type="text" id="passengerInput" name="passenger" readonly
                        class="form-control form-control-lg bg-transparent border-0 text-white"
                        value="2 Adults, 1 Room"
                        style="cursor: pointer; border-bottom: 2px solid #ffffff55;" />

                    <div id="passengerDropdown"
                        class="passenger-dropdown-container"
                        style="display: none;">

                        <!-- Adults -->
                        <div class="passenger-row">
                            <span>Adults</span>
                            <div class="passenger-control">
                                <button type="button" onclick="updatePassenger('adults', -1)">−</button>
                                <span id="adultsCount">2</span>
                                <button type="button" onclick="updatePassenger('adults', 1)">+</button>
                            </div>
                        </div>

                        <!-- Children -->
                        <div class="passenger-row">
                            <span>Children</span>
                            <div class="passenger-control">
                                <button type="button" onclick="updatePassenger('children', -1)">−</button>
                                <span id="childrenCount">0</span>
                                <button type="button" onclick="updatePassenger('children', 1)">+</button>
                            </div>
                        </div>

                        <!-- Child Ages -->
                        <div id="childAges" class="passenger-ages"></div>

                        <!-- Rooms -->
                        <div class="passenger-row mt-3">
                            <span>Rooms</span>
                            <div class="passenger-control">
                                <button type="button" onclick="updatePassenger('rooms', -1)">−</button>
                                <span id="roomsCount">1</span>
                                <button type="button" onclick="updatePassenger('rooms', 1)">+</button>
                            </div>
                        </div>
                    </div>


                    <!-- Hidden Inputs -->
                    <input type="hidden" id="adultsInput" name="adults" value="2" />
                    <input type="hidden" id="childrenInput" name="children" value="0" />
                    <input type="hidden" id="roomsInput" name="rooms" value="1" />
                </div>


                <!-- Search Button -->
                <button type="submit" class="btn w-100 mt-3 text-white fw-bold btn-lg" style="background: linear-gradient(90deg, rgba(255, 35, 109, 0.6), rgba(255, 75, 43, 0.8));
 border-radius: 14px;">Search</button>

            </form>

        </div>
    </section>
    <style>
        .glass-bg {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .form-control,
        .form-select {
            border: 1px solid #ddd !important;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-control::placeholder {
            color: #ccc !important;
            opacity: 1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ff4b2b !important;
            box-shadow: 0 0 0 0.1rem rgba(255, 75, 43, 0.25) !important;
        }

        .animated-bg {
            position: relative;
            overflow: hidden;
        }

        .animated-bg::before {
            content: "";
            position: absolute;
            top: -10%;
            left: -10%;
            width: 120%;
            height: 120%;
            background-image: url('<?= base_url("assets/img/bg-hotel.jpeg") ?>');
            background-size: cover;
            background-position: center;
            filter: brightness(0.7);
            transform: scale(1);
            animation: zoomPan 25s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes zoomPan {
            0% {
                transform: scale(1) translate(0, 0);
            }

            50% {
                transform: scale(1.1) translate(5px, 5px);
            }

            100% {
                transform: scale(1) translate(0, 0);
            }
        }

        .animated-bg>* {
            position: relative;
            z-index: 1;
        }

        .fancy-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .fancy-spinner .ring {
            width: 30px;
            height: 30px;
            margin: 4px;
            border: 3px solid #f75d34;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            border-color: #f75d34 transparent transparent transparent;
        }

        .fancy-spinner .dot {
            width: 12px;
            height: 12px;
            background: #f75d34;
            border-radius: 50%;
            margin-left: 10px;
            animation: pulse 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.4);
                opacity: 0.6;
            }
        }

        #searchLoader {
            display: none;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        #searchLoader svg circle {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: 0;
            animation: search-spinner 1.4s linear infinite;
        }

        @keyframes search-spinner {
            0% {
                stroke-dashoffset: 0;
                transform: rotate(0deg);
                transform-origin: 50% 50%;
            }

            100% {
                stroke-dashoffset: -360;
                transform: rotate(360deg);
                transform-origin: 50% 50%;
            }
        }

        #searchError {
            display: none;
            color: red;
            font-weight: bold;
            padding: 8px 0 0 2px;
        }

        .passenger-dropdown-container {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            padding: 1.5rem;
            margin-top: 8px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            z-index: 999;
            color: #fff;
        }

        .passenger-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 16px;
        }

        .passenger-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .passenger-control button {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 18px;
            transition: all 0.2s ease;
        }

        .passenger-control button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .passenger-control span {
            width: 24px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        /* Age Select Fields */
        .passenger-ages {
            display: flex;
            overflow-x: auto;
            gap: 12px;
            margin-top: 1rem;
            padding-bottom: 8px;
            scrollbar-width: thin;
        }

        .passenger-ages::-webkit-scrollbar {
            height: 6px;
        }

        .passenger-ages::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }


        .passenger-ages select {
            width: 100px;
            padding: 6px 10px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            border-radius: 10px;
            outline: none;
            appearance: none;
            backdrop-filter: blur(8px);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .passenger-ages select:focus {
            border-color: #ffbdbd;
            background: rgba(255, 255, 255, 0.2);
        }
    </style>

    <div id="searchLoader">
        <svg width="22" height="22" viewBox="0 0 50 50">
            <circle cx="25" cy="25" r="20" stroke="#ffffffcc" stroke-width="4" fill="none" stroke-linecap="round" />
        </svg>
    </div>
    <div id="searchError">Please enter a valid destination.</div>


    <div id="loader" style="
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
">
        <div style="
        background: linear-gradient(135deg, #d3ffe8, #e9efff, #ffd6e8);
        border-radius: 20px;
        padding: 45px 35px;
        width: 100%;
        max-width: 400px;
        box-shadow:
            0 20px 30px rgba(0, 0, 0, 0.12),
            0 10px 15px rgba(0, 0, 0, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.3);
        position: relative;
        text-align: center;
        overflow: hidden;
        animation: floatIn 0.6s ease-in-out;
    ">
            <div class="fancy-spinner" style="margin: 0 auto 25px;"></div>

            <p style="
            font-size: 18px;
            font-weight: 700;
            color: #202124;
            margin-bottom: 14px;
        ">
                Searching for hotels...
            </p>

            <div id="search-summary" style="
            font-size: 15px;
            color: #333;
            line-height: 1.5;
        "></div>
        </div>
    </div>

    <style>
        .fancy-spinner {
            width: 56px;
            height: 56px;
            border: 5px solid transparent;
            border-top: 5px solid #00f0ff;
            border-right: 5px solid #ff00cc;
            border-radius: 50%;
            animation: spin 0.85s linear infinite;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
            box-shadow:
                0 0 10px #00f0ff,
                0 0 10px #ff00cc inset;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes floatIn {
            0% {
                transform: scale(0.9) translateY(20px);
                opacity: 0;
            }

            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }
    </style>




</main>

</div>

<style>
    .hotel-img {
        height: 260px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.4s ease;
    }

    .hover-scale:hover .hotel-img {
        transform: scale(1.05);
    }

    .discount-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background-color: #dc3545;
        color: #fff;
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 1.1rem;
        color: #343a40;
        margin-top: 10px;
    }

    .alinks {
        text-decoration: none;
        color: inherit;
    }

    .section-heading {
        border-bottom: 3px solid #ff4b2b;
        display: inline-block;
        padding-bottom: 8px;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .hotel-img {
            height: 200px;
        }
    }
</style>

<section class="py-5 bg-light position-relative">
    <div class="container text-center">
        <!-- Section Heading -->
        <h2 class="fw-bold display-6 text-dark section-heading">
            Hidden hotel deals revealed <br />
            <span class="text-primary">Save up to 60% today</span>
        </h2>
        <!-- Sub Text -->
        <p class="mt-3 fs-5 text-muted col-md-8 mx-auto">
            We search across trusted platforms to find the best hotel deals and pass the savings directly to you.
        </p>
    </div>

    <div class="container mt-5">
        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <?php
            $today = date('d+F+Y');
            $threeDaysLater = date('d+F+Y', strtotime('+3 days'));
            ?>

            <div class="col-md-4">
                <a href="<?= base_url("search-result?destination=Ohtels+Villa+Dorada&checkin=$today&checkout=$threeDaysLater&adults=2&children=0&rooms=1&passenger_summary=2+Adults,+1+Room&children_ages=") ?>"
                    class="alinks">
                    <div class="card border-0 shadow-sm h-100 hover-scale rounded-3 overflow-hidden">
                        <div class="position-relative">
                            <img src="<?= base_url('/assets/img/hotel1.jpg') ?>" class="card-img-top hotel-img" alt="North Beach Hotel">
                            <span class="discount-badge">-34%</span>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">Ohtels Villa Dorada</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <a href="<?= base_url("search-result?destination=Ohtels+Villa+Dorada&checkin=$today&checkout=$threeDaysLater&adults=2&children=0&rooms=1&passenger_summary=2+Adults,+1+Room&children_ages=") ?>"
                    class="alinks">
                    <div class="card border-0 shadow-sm h-100 hover-scale rounded-3 overflow-hidden">
                        <div class="position-relative">
                            <img src="<?= base_url('/assets/img/hotel2.jpg') ?>" class="card-img-top hotel-img" alt="Westgate Palace Resort">
                            <span class="discount-badge">-12%</span>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">Westgate Palace Resort</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <a href="<?= base_url("search-result?destination=Ohtels+Villa+Dorada&checkin=$today&checkout=$threeDaysLater&adults=2&children=0&rooms=1&passenger_summary=2+Adults,+1+Room&children_ages=") ?>"
                    class="alinks">
                    <div class="card border-0 shadow-sm h-100 hover-scale rounded-3 overflow-hidden">
                        <div class="position-relative">
                            <img src="<?= base_url('/assets/img/hotel3.jpg') ?>" class="card-img-top hotel-img" alt="New Otani Tokyo Garden">
                            <span class="discount-badge">-38%</span>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">New Otani Tokyo Garden</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section style="background: #fff; color: #212529; padding: 80px 0; position: relative; overflow: hidden;">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-7" style="margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; font-weight: 700; line-height: 1.4; margin-bottom: 1.5rem;">
                    Booking a Room on Hotel Room Discount is<br />
                    <span style="color: #0d6efd;">Fast, Easy, and Reliable</span>
                </h2>

                <div style="margin-bottom: 1.5rem;">
                    <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 6px;">
                        <span style="background-color: #e9ecef; color: #0d6efd; padding: 6px 12px; border-radius: 8px; margin-right: 10px; font-weight: 700; display: inline-block; min-width: 32px; text-align: center;">1</span>
                        Price Alerts
                    </p>
                    <p style="font-size: 0.95rem; line-height: 1.7; font-family: 'Lato', sans-serif;">
                        Hotel prices change frequently. Subscribe to our price alerts to stay updated whenever the price changes for your selected hotel. This helps you book at the perfect time.
                    </p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 6px;">
                        <span style="background-color: #e9ecef; color: #0d6efd; padding: 6px 12px; border-radius: 8px; margin-right: 10px; font-weight: 700; display: inline-block; min-width: 32px; text-align: center;">2</span>
                        Verified Reviews Only
                    </p>
                    <p style="font-size: 0.95rem; line-height: 1.7; font-family: 'Lato', sans-serif;">
                        We collect genuine guest reviews from trusted platforms like Agoda, Hotels.com, and more using TrustYou, an advanced semantic analysis system. This ensures accurate and trustworthy ratings from real guests.
                    </p>
                </div>

                <div>
                    <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 6px;">
                        <span style="background-color: #e9ecef; color: #0d6efd; padding: 6px 12px; border-radius: 8px; margin-right: 10px; font-weight: 700; display: inline-block; min-width: 32px; text-align: center;">3</span>
                        Transparent Final Prices
                    </p>
                    <p style="font-size: 0.95rem; line-height: 1.7; font-family: 'Lato', sans-serif;">
                        Hotel Room Discount displays the actual final price. There are no hidden charges or extra taxes. What you see is exactly what you pay.
                    </p>
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <img src="<?= base_url('/assets/img/business-woman.jpg') ?>" alt="Business Woman"
                    style="max-width: 100%; height: auto; border-radius: 0.75rem; box-shadow: 0 8px 24px rgba(0,0,0,0.15); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>

        </div>
    </div>
</section>



<section style="padding: 100px 0; background: linear-gradient(to right, #f8fafc, #e0f2fe);">
    <div class="container text-center">

        <!-- Headline -->
        <h2 style="font-size: 2.25rem; font-weight: 700; font-family: 'Montserrat', sans-serif; color: #0f172a; max-width: 800px; margin: 0 auto;">
            Get access to a wider selection of hotels using
            <span style="color: #0ea5e9;">Hotel Room Discount</span>
        </h2>

        <!-- Subheading -->
        <p style="font-size: 1.05rem; font-weight: 400; color: #475569; font-family: 'Lato', sans-serif; margin-top: 20px; max-width: 720px; margin-left: auto; margin-right: auto;">
            We compare room prices from 70+ hotel booking services, letting you pick the most affordable offers — even those not listed elsewhere.
        </p>

        <!-- Feature Cards -->
        <div class="row mt-5">
            <!-- Feature Box -->
            <div class="col-md-4 mb-4">
                <div style="background: rgba(255, 255, 255, 0.85); border-radius: 16px; padding: 30px; backdrop-filter: blur(8px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="bi bi-box" style="font-size: 1.8rem;"></i>
                    </div>
                    <p style="color: #334155; font-size: 0.95rem; font-family: 'Lato', sans-serif;">
                        We search both major platforms and small local systems. Discover unique family-run hotels often hidden from mainstream listings.
                    </p>
                </div>
            </div>

            <!-- Feature Box -->
            <div class="col-md-4 mb-4">
                <div style="background: rgba(255, 255, 255, 0.85); border-radius: 16px; padding: 30px; backdrop-filter: blur(8px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #14b8a6, #2dd4bf); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="bi bi-search" style="font-size: 1.8rem;"></i>
                    </div>
                    <p style="color: #334155; font-size: 0.95rem; font-family: 'Lato', sans-serif;">
                        Guest reviews are pulled from multiple booking platforms, offering you more well-rounded, reliable hotel ratings.
                    </p>
                </div>
            </div>

            <!-- Feature Box -->
            <div class="col-md-4 mb-4">
                <div style="background: rgba(255, 255, 255, 0.85); border-radius: 16px; padding: 30px; backdrop-filter: blur(8px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #6366f1, #818cf8); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="bi bi-chat-dots" style="font-size: 1.8rem;"></i>
                    </div>
                    <p style="color: #334155; font-size: 0.95rem; font-family: 'Lato', sans-serif;">
                        Ratings combine cross-platform data to help you make better, more informed booking decisions without second-guessing.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    const today = new Date();
    const threeDaysLater = new Date();
    threeDaysLater.setDate(today.getDate() + 3);

    const fpInstance = flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d M Y",
        minDate: "today",
        defaultDate: [today, threeDaysLater],
        closeOnSelect: false,
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const checkIn = selectedDates[0];
                const checkOut = selectedDates[1];

                // Difference in days
                const nights = Math.round((checkOut - checkIn) / (1000 * 60 * 60 * 24));

                // Check if check-in and check-out are same
                if (checkIn.toDateString() === checkOut.toDateString()) {
                    alert("Check-in and Check-out dates cannot be the same.");
                    instance.clear();
                    document.getElementById("checkin").value = "";
                    document.getElementById("checkout").value = "";
                    return;
                }

                // Check if range is more than 30 days
                if (nights > 30) {
                    alert("You cannot select more than 30 days.");
                    instance.clear();
                    document.getElementById("checkin").value = "";
                    document.getElementById("checkout").value = "";
                    document.getElementById("nights").value = "";
                    return;
                }

                document.getElementById("checkin").value = flatpickr.formatDate(checkIn, "d F Y");
                document.getElementById("checkout").value = flatpickr.formatDate(checkOut, "d F Y");
                document.getElementById("nights").value = nights;

                document.getElementById("checkin").classList.remove("is-invalid");
                document.getElementById("checkout").classList.remove("is-invalid");

                instance.close();
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkin").value = flatpickr.formatDate(today, "d F Y");
        document.getElementById("checkout").value = flatpickr.formatDate(threeDaysLater, "d F Y");
        const nights = Math.round((threeDaysLater - today) / (1000 * 60 * 60 * 24));
        document.getElementById("nights").value = nights;
    });

    // Auto-update dateRange based on nights dropdown
    document.getElementById("nights").addEventListener("change", function() {
        const nights = parseInt(this.value);
        if (!isNaN(nights) && nights > 0) {
            const newCheckIn = new Date();
            const newCheckOut = new Date();
            newCheckOut.setDate(newCheckIn.getDate() + nights);

            // Set date range programmatically
            fpInstance.setDate([newCheckIn, newCheckOut]);

            document.getElementById("checkin").value = flatpickr.formatDate(newCheckIn, "d F Y");
            document.getElementById("checkout").value = flatpickr.formatDate(newCheckOut, "d F Y");
        }
    });
    let passengers = {
        adults: 2,
        children: 0,
        rooms: 1,
    };

    // updatePassenger("rooms", 0);
    function updatePassenger(type, delta) {
        if (type === "adults") {
            passengers.adults = Math.max(1, Math.min(passengers.adults + delta, 8));
        } else if (type === "children") {
            passengers.children = Math.max(0, Math.min(passengers.children + delta, 4));
            updateChildAgeInputs();
        } else if (type === "rooms") {
            passengers.rooms = Math.max(1, Math.min(passengers.rooms + delta, 10));
        }

        document.getElementById("adultsCount").textContent = passengers.adults;
        document.getElementById("childrenCount").textContent = passengers.children;
        document.getElementById("roomsCount").textContent = passengers.rooms;
        document.getElementById("adultsInput").value = passengers.adults;
        document.getElementById("childrenInput").value = passengers.children;
        document.getElementById("roomsInput").value = passengers.rooms;

        let summary = `${passengers.adults} Adult${passengers.adults > 1 ? "s" : ""}`;
        if (passengers.children > 0) summary += `, ${passengers.children} Child${passengers.children > 1 ? "ren" : ""}`;
        summary += `, ${passengers.rooms} Room${passengers.rooms > 1 ? "s" : ""}`;
        document.getElementById("passengerInput").value = summary;
    }

    function updateChildAgeInputs() {
        const count = passengers.children;
        const container = document.getElementById("childAges");

        const previousValues = {};
        const existingSelects = container.querySelectorAll("select");
        existingSelects.forEach((select, index) => {
            previousValues[`childAge${index}`] = select.value;
        });

        container.innerHTML = "";
        if (count > 0) {
            const label = document.createElement("label");
            label.textContent = "Children Ages";
            label.className = "form-label fw-bold mb-1 w-100";
            container.appendChild(label);
        }

        // Step 3: Create new selects and restore old values if available
        for (let i = 0; i < count; i++) {
            const select = document.createElement("select");
            select.name = "children_ages[]";
            select.id = `childAge${i}`;
            // select.className = "form-control mt-2 fs-16px lato fw-normal";
            select.className = "form-select bg-white text-dark";
            select.style.width = "100px";
            select.style.borderRadius = "8px";
            select.style.border = "1px solid #ccc";

            select.required = true;

            const defaultOption = document.createElement("option");
            defaultOption.disabled = true;
            defaultOption.textContent = `0`;
            defaultOption.value = "0";
            select.appendChild(defaultOption);

            for (let age = 1; age <= 17; age++) {
                const option = document.createElement("option");
                option.value = age;
                option.textContent = age;
                select.appendChild(option);
            }

            if (previousValues[`childAge${i}`]) {
                select.value = previousValues[`childAge${i}`];
            } else {
                select.selectedIndex = 0;
            }

            container.appendChild(select);
        }

    }

    document
        .getElementById("passengerInput")
        .addEventListener("click", function() {
            const dropdown = document.getElementById("passengerDropdown");
            dropdown.style.display =
                dropdown.style.display === "none" ? "block" : "none";
        });

    document.addEventListener("click", function(e) {
        const dropdown = document.getElementById("passengerDropdown");
        const input = document.getElementById("passengerInput");
        if (!dropdown.contains(e.target) && e.target !== input) {
            dropdown.style.display = "none";
        }
    });

    const cityOptions = document.querySelectorAll(".dropdown-item-custom");

    cityOptions.forEach((option) => {
        option.addEventListener("click", function() {
            const cityName = this.querySelector(".title").textContent;
            document.getElementById("searchInput").value = cityName;

            document.getElementById("suggestions").classList.add("d-none");
        });
    });

    function showDropdown() {
        document.getElementById("suggestions").classList.remove("d-none");
    }

    document.addEventListener("click", function(e) {
        if (!e.target.closest(".search-dropdown")) {
            document.getElementById("suggestions").classList.add("d-none");
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('loader').style.display = 'none';
    });

    const searchInput = document.getElementById('searchInput');
    let originalValue = '';

    searchInput.addEventListener('focus', function() {
        originalValue = this.value;
        this.value = '';
        document.getElementById('suggestions').innerHTML = '';
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target)) {
            if (searchInput.value.trim() === '') {
                searchInput.value = originalValue;
            }
        }
    });

    function handleSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const destination = form.destination;
        const dateRange = form.dateRange;
        const checkin = form.checkin;
        const checkout = form.checkout;
        const passengerInput = document.getElementById('passengerInput');
        const adults = document.getElementById('adultsInput').value;
        const children = document.getElementById('childrenInput').value;
        const rooms = document.getElementById('roomsInput').value;
        const childrenAgesInputs = document.querySelectorAll("select[name='children_ages[]']");
        const childrenAges = Array.from(childrenAgesInputs).map(select => {
            return select.value === "" ? "0" : select.value;
        });
        let hasError = false;

        if (!destination.value.trim()) {
            destination.classList.add('is-invalid');
            hasError = true;
        }

        if (!checkin.value.trim() || !checkout.value.trim()) {
            dateRange.classList.add('is-invalid');
            hasError = true;
        }

        if (!passengerInput.value.trim()) {
            passengerInput.classList.add('is-invalid');
            hasError = true;
        }

        if (hasError) return;
        const checkinDate = new Date(checkin.value);
        const checkoutDate = new Date(checkout.value);
        const nights = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24));

        // Generate summary HTML
        const summaryHTML = `
            <div style="font-size: 17px; font-weight: 700; margin-bottom: 6px;">${destination.value}</div>
            <div>from <strong>${checkin.value}</strong> to <strong>${checkout.value}</strong></div>
            <div style="margin-top: 6px;">
                ${nights} night${nights != 1 ? 's' : ''},
                ${adults} adult${adults > 1 ? 's' : ''}${children > 0 ? ', ' : ''}
                ${children > 0 ? `${children} ${children == 1 ? 'child' : 'children'}` : ''}
                ${children > 0 ? ' ' : ''}and
                ${rooms} room${rooms > 1 ? 's' : ''}
            </div>
        `;


        document.getElementById('search-summary').innerHTML = summaryHTML;
        document.getElementById('loader').style.display = 'flex';

        const params = new URLSearchParams({
            destination: destination.value,
            checkin: checkin.value,
            checkout: checkout.value,
            adults: adults,
            children: children,
            rooms: rooms,
            passenger_summary: passengerInput.value,
            children_ages: childrenAges.join(","),
        });

        fetch("<?= base_url('search-hotels') ?>?" + params.toString())
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `<?= base_url('search-result') ?>?${params.toString()}`;
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": 5000,
                        "extendedTimeOut": 5000,
                        "positionClass": "toast-top-right"
                    };
                    toastr.error(data.error || 'Unknown error occurred while searching hotels.');

                    document.getElementById('loader').style.display = 'none';
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const fields = ['searchInput', 'dateRange', 'passenger'];

        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);

            field.addEventListener('input', () => {
                if (field.classList.contains('is-invalid')) {
                    field.classList.remove('is-invalid');
                }
            });

            field.addEventListener('blur', () => {
                const isSearchInput = field.id === 'searchInput';

                if (isSearchInput) {
                    if (!field.value.trim() && !originalValue.trim()) {
                        field.classList.add('is-invalid');
                    }
                } else {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                    }
                }
            });

        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const cityTriggers = document.querySelectorAll('.city-search-trigger');

        cityTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const destination = this.dataset.destination;

                const today = new Date();
                const checkinDate = today;
                const checkoutDate = new Date();
                checkoutDate.setDate(today.getDate() + 7);

                const options = {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                };
                const checkinFormatted = checkinDate.toISOString().split('T')[0];
                const checkoutFormatted = checkoutDate.toISOString().split('T')[0];

                const adults = 2;
                const rooms = 1;
                const children = 0;
                const passenger = `${adults}+Adults,+${rooms}+Room`;

                const params = new URLSearchParams({
                    destination: destination,
                    checkin: checkinFormatted,
                    checkout: checkoutFormatted,
                    passenger: passenger,
                    rooms: rooms,
                    adults: adults,
                    children: children,
                });

                // Show loader if you have one
                const loader = document.getElementById('loader');
                if (loader) loader.style.display = 'flex';

                // Call the backend to store session and redirect
                fetch("<?= base_url('search-hotels') ?>?" + params.toString())
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = `<?= base_url('search-result') ?>?${params.toString()}`;
                        } else {
                            alert('Error searching hotels: ' + (data.error || 'Unknown error'));
                            if (loader) loader.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (loader) loader.style.display = 'none';
                    });
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const loader = document.getElementById('searchLoader');
        const error = document.getElementById('searchError');
        const suggestionsBox = document.getElementById('suggestions');

        if (!searchInput || !loader || !error || !suggestionsBox) return;

        let controller = null;
        let hideLoaderTimeout = null;

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (hideLoaderTimeout) clearTimeout(hideLoaderTimeout);
            error.style.display = 'none';
            error.textContent = '';
            suggestionsBox.innerHTML = '';
            suggestionsBox.classList.add('d-none');

            if (query.length >= 3) {
                loader.style.display = 'block';

                if (controller) controller.abort();
                controller = new AbortController();
                const signal = controller.signal;

                fetch("<?= base_url('get-city-suggestions?term=') ?>" + encodeURIComponent(query), {
                        signal
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            suggestionsBox.classList.remove('d-none');

                            data.forEach(city => {
                                const item = document.createElement('a');
                                item.classList.add('list-group-item', 'list-group-item-action');
                                const parts = [city.city_name, city.state_name, city.country_name].filter(Boolean);
                                item.textContent = parts.join(', ');

                                item.addEventListener('click', () => {
                                    searchInput.value = city.city_name;
                                    suggestionsBox.innerHTML = '';
                                    suggestionsBox.classList.add('d-none');
                                    loader.style.display = 'none';
                                });

                                suggestionsBox.appendChild(item);
                            });

                            hideLoaderTimeout = setTimeout(() => {
                                loader.style.display = 'none';
                            }, 2000);
                        } else {
                            error.style.display = 'block';
                            error.textContent = 'No results found.';
                            loader.style.display = 'none';
                        }
                    })
                    .catch(err => {
                        if (err.name !== 'AbortError') {
                            console.error('Fetch error:', err);
                            error.style.display = 'block';
                            error.textContent = 'Error fetching results.';
                            loader.style.display = 'none';
                        }
                    });
            } else {
                loader.style.display = 'none';
                error.style.display = 'none';
                suggestionsBox.classList.add('d-none');
                suggestionsBox.innerHTML = '';
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#suggestions') && e.target !== searchInput) {
                loader.style.display = 'none';
            }
        });
    });
</script>