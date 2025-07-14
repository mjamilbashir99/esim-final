<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Bootstrap Icons CDN (Include in your <head> or before closing </body>) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 
   <main class="px-0">
   <section class="banner position-relative d-flex flex-column justify-content-center align-items-center">
   <h1 class="Montserra text-light py-4 h4 fw-semibold montserrat mt-5 mt-lg-0 pt-5 pt-lg-0 text-center"  >Find The Best Places Today.</h1>
        <div class="container d-flex justify-content-center align-items-center px-0">
           <form id="searchForm" onsubmit="handleSubmit(event)" class="w-100">
               <div class="search-box p-2 bg-light">
               <!-- <h4 class="h5 p-2 Montserra">Search Hotels</h4> -->
                   <div class="row g-2 align-items-center px-2">
                       <!-- Destination -->
                       <div class="search-dropdown mx-auto col-md-3 position-relative">
                            <label for="searchInput" class="form-label fw-normal fs-16px mb-1">Destination, Zone or Hotel Name</label>
                            <input type="text" id="searchInput" name="destination"
                                class="form-control form-control-lg col-md-12 fs-16px lato fw-normal" placeholder="Destination" />
                            <!-- Loader spinner (hidden initially) -->
                            <div id="searchLoader" class="loader-spinner" style="display:none; position:absolute; right: 15px; top: 70%; transform: translateY(-50%);">
                                <!-- You can use a CSS spinner or an icon -->
                                <svg width="20" height="20" viewBox="0 0 50 50">
                                    <circle cx="25" cy="25" r="20" stroke="#999" stroke-width="5" fill="none" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div id="suggestions" class="list-group mt-2 fs-16px lato fw-normal shadow" style="cursor:pointer"></div>
                        </div>

                       <!-- Date Range -->
                    <div class="col-md-4">
                        <div class="row g-2 align-items-end">
                            <!-- Date Field -->
                            <div class="col-10">
                                <label for="dateRange" class="form-label fw-normal fs-16px mb-1">Dates</label>
                                <input type="text" id="dateRange" name="dateRange" class="form-control fs-16px lato fw-normal"
                                    placeholder="Select check-in & check-out dates" />
                            </div>

                            <!-- Nights Dropdown (styled like input) -->
                            <div class="col-2">
                            <label for="nights" class="form-label fw-normal mb-1 fs-16px">Nights</label>
                                <select id="nights" class="form-control fs-16px lato fw-normal">
                                    <script>
                                        for (let i = 1; i <= 30; i++) {
                                            document.write(`<option value="${i}">${i}</option>`);
                                        }
                                    </script>
                                </select>
                            </div>
                        </div>

                        <!-- Hidden inputs -->
                        <input type="hidden" id="checkin" name="checkin">
                        <input type="hidden" id="checkout" name="checkout">
                    </div>


                    
                       <div class="col-md-3 position-relative mt-3 mt-sm-2">
                       <label for="passengerInput" class="form-label fw-normal mb-1 fs-16px">Travellers</label>
                           <input type="text" id="passengerInput" name="passenger" readonly
                               class="form-control fs-16px lato fw-normal"
                               style="cursor: pointer;"
                               value="2 Adults, 1 Room"
                               placeholder="1 Passenger" />

                           <div id="passengerDropdown"
                               class="p-3 mt-1 bg-white position-absolute w-100 shadow"
                               style="display: none; z-index: 999">

                               <!-- Adults -->
                               <div class="d-flex justify-content-between align-items-center mb-2 fs-16px lato fw-normal">
                                   <span>Adults</span>
                                   <div class="d-flex align-items-center gap-2">
                                       <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updatePassenger('adults', -1)">-</button>
                                       <span id="adultsCount" class="px-2">2</span>
                                       <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updatePassenger('adults', 1)">+</button>
                                   </div>
                               </div>

                               <!-- Children -->
                               <div class="d-flex justify-content-between align-items-center mb-2 fs-16px lato fw-normal">
                                   <span>Children</span>
                                   <div class="d-flex align-items-center gap-2">
                                       <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updatePassenger('children', -1)">-</button>
                                       <span id="childrenCount" class="px-2">0</span>
                                       <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updatePassenger('children', 1)">+</button>
                                   </div>
                               </div>

                               <!-- Child Ages -->
                               <div id="childAges" class="mt-1"></div>
                               <!-- Rooms -->
                               <div class="d-flex justify-content-between align-items-center mb-2 fs-16px lato fw-normal">
                                   <span>Rooms</span>
                                   <div class="d-flex align-items-center gap-2 mt-2">
                                       <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updatePassenger('rooms', -1)">-</button>
                                       <span id="roomsCount" class="px-2">1</span>
                                       <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updatePassenger('rooms', 1)">+</button>
                                   </div>
                               </div>

                               
                           </div>
                       </div>



                       <!-- Hidden Inputs for Backend Submission -->
                       <input type="hidden" id="adultsInput" name="adults" value="2" />
                       <input type="hidden" id="childrenInput" name="children" value="0" />
                       <input type="hidden" id="roomsInput" name="rooms" value="1" />



                       <!-- Search Button -->
                       <div class="col-md-2 mt-3 mt-sm-2">
                           <button type="submit" class="btn btn-search"style="margin-top: 28px;">Search</button>
                       </div>
                   </div>
                   <div id="searchError" style="display:none; color: red; font-weight: bold;">
                        &#9888; No results found
                    </div>
               </div>
           </form>
       </div>
       </section>

    <!-- <div id="loader" style="
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    ">
       <div class="fancy-spinner">
           <div class="ring"></div>
           <div class="ring"></div>
           <div class="dot"></div>
       </div>
       <p style="margin-top: 20px; font-weight: 500; color: #444;">Searching for hotels...</p>
   </div>

   <div class="container mt-4"></div> -->

   <div id="loader" style="
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
">

        <!-- Loader Card -->
        <div style="
        background: #f4f7fb;
        border: 1px solid #dce3ed;
        border-radius: 12px;
        padding: 30px 25px;
        width: 100%;
        max-width: 360px;
        text-align: center;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);">

            <!-- Spinner -->
            <div class="fancy-spinner" style="margin: 0 auto 20px;">
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="dot"></div>
            </div>

            <!-- Message -->
            <p style="font-size: 16px; font-weight: 600; color: #444; margin-bottom: 12px;">Searching for hotels...</p>

            <!-- Summary -->
            <div id="search-summary" style="font-size: 15px; line-height: 1.6; color: #2c3e50;">
                <!-- Populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Spinner Styles -->
    <style>
        .fancy-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
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

        /* input field loader */
        .loader-spinner svg circle {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: 0;
            animation: spinner 1.5s linear infinite;
        }

        #searchError {
            display: none;
            color: red;
            font-weight: bold;
            /* margin: 10px 0 20px; */
            padding: 10px;
        }

        @keyframes spinner {
            0% {
                stroke-dashoffset: 0;
            }

            100% {
                stroke-dashoffset: -240;
            }
        }
    </style>

   </main>

   
  </div>


  <section class="py-5">
  <div class="container">
            <div >
                <p class="h4 montserrat fw-semibold text-center custom-underline position-relative">Hidden hotel deals revealed save up to 60% today</p>
            </div>
            <div class="mt-5 "><p class="col-md-6 mx-auto text-center fs-16px lato">We search across a wide range of trusted booking platforms to find the best destination deals and pass the savings on to you.</p></div>
        </div>

        <div class="container py-4">
  <div class="row g-4">

    <!-- Hotel Card 1 -->
    <div class="col-md-4">
      <div class="room-card shadow">
        <!-- <div class="hotel-info">
          <h5 class="mb-1 h6">North Beach Hotel</h5>
          <div class="stars mb-2 fs-20px">★★★★☆</div>
          <div class="discount-badge">-34%</div>
        </div> -->
        <img src="<?= base_url('/assets/img/hotel1.png')?>" class="hotel-img" alt="North Beach Hotel">
        <!-- <div class="price-section">
          <span class="price-new">$204</span>
          <span class="price-old">$308</span>
        </div> -->
      </div>
    </div>

    <!-- Hotel Card 2 -->
    <div class="col-md-4">
      <div class="room-card shadow">
        <!-- <div class="hotel-info">
          <h5 class="mb-1 h6">Hotel Westgate Palace Resort</h5>
          <div class="stars mb-2 fs-20px">★★★★☆</div>
          <div class="discount-badge">-12%</div>
        </div> -->
        <img src="<?= base_url('/assets/img/hotel2.jpg')?>" class="hotel-img" alt="Hotel Westgate Palace Resort">
        <!-- <div class="price-section">
          <span class="price-new">$392</span>
          <span class="price-old">$445</span>
        </div> -->
      </div>
    </div>

    <!-- Hotel Card 3 -->
    <div class="col-md-4">
      <div class="room-card shadow">
        <!-- <div class="hotel-info">
          <h5 class="mb-1 h6">New Otani Tokyo Garden</h5>
          <div class="stars mb-2 fs-20px">★★★★★</div>
          <div class="discount-badge">-38%</div>
        </div> -->
        <img src="<?= base_url('/assets/img/hotel3.webp')?>" class="hotel-img" alt="New Otani Tokyo Garden">
        <!-- <div class="price-section">
          <span class="price-new">$386</span>
          <span class="price-old">$621</span>
        </div> -->
      </div>
    </div>

  </div>
</div>

    </section>
    <section class="bg-success text-white  pt-5">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Text Section -->
      <div class="col-lg-7">
        <h2 class="fw-semibold mb-4 h4">
        Booking a Room on Hotel Room Discount is Fast, Easy, and Reliable
        </h2>

        <div class="mb-4">
          <p  class="montserrat fs-20px"><span class="fw-bold me-2 fs-20px montserrat">1</span>Price Alerts</p>
          <p class="lato fs-16px">Hotel prices change frequently. Subscribe to our price alerts to stay updated whenever the price changes for your selected hotel. This helps you book at the perfect time.</p>
        </div>

        <div class="mb-4">
          <p class="montserrat fs-20px"><span class="fw-bold me-2 fs-20px">2</span >Verified Reviews Only</p>
          <p class="lato fs-16px">We collect genuine guest reviews from trusted platforms like Agoda, Hotels.com and more using TrustYou, an advanced semantic analysis system. This ensures accurate and trustworthy ratings from real guests.</p>
        </div>

        <div>
          <p  class="fs-20px montserrat"> <span class="fw-bold me-2 fs-20px montserrat">3</span>Transparent Final Prices.</p>
          <p class="lato fs-16px">Hotel Room Discount displays the actual final price. There are no hidden charges or extra taxes. What you see is exactly what you pay.</p>
        </div>
      </div>

      <!-- Image Section -->
      <div class="col-lg-5 text-center">
        <img src="<?= base_url('/assets/img/girl.png') ?>" alt="Business Woman" class="img-fluid">
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light text-center">
  <div class="container">
    <p class="fw-semibold custom-underline position-relative h3 col-md-7 mx-auto montserrat h4 text-center text-lg-left">Get access to a wider selection of hotels using Hotel Room Discount.</p>
    <p class="lead mt-5 fw-normal fs-16px lato">We compare room prices from 70 different hotel booking services, enabling you to pick the most affordable offers that are not even listed</p>

    <div class="row mt-5">
      <div class="col-md-4 mb-4">
        <div class="d-flex flex-column align-items-center">
          <div class="text-success mb-3 fs-1">
          <i class="bi bi-box"></i>
          </div>
          <p class="text-muted fs-16px lato">Hotel Room Discount searches both major booking platforms and smaller local systems. Many small, family-run hotels are not listed on the big sites, and we make sure you don’t miss out on those hidden gems.</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="d-flex flex-column align-items-center">
          <div class="text-success mb-3 fs-1">
            <i class="bi bi-search"></i>
          </div>
          <p class="text-muted fs-16px lato">We also collect guest feedback from multiple booking sources, which makes Hotel Room Discount’s ratings more complete and reliable.</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="d-flex flex-column align-items-center">
          <div class="text-success mb-3 fs-1">
            <i class="bi bi-chat-dots"></i>
          </div>
          <p class="text-muted fs-16px lato">Our ratings combine reviews from various booking sources, giving you a more balanced and reliable view of each hotel.</p>
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
                passengers.rooms = Math.max(1, Math.min(passengers.rooms +  delta, 10));
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
               select.className = "form-control mt-2 fs-16px lato fw-normal";
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
                    } 
                    else {
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
  
    document.addEventListener('DOMContentLoaded', function () {
        const cityTriggers = document.querySelectorAll('.city-search-trigger');

        cityTriggers.forEach(trigger => {
        trigger.addEventListener('click', function () {
            const destination = this.dataset.destination;

            const today = new Date();
            const checkinDate = today;
            const checkoutDate = new Date();
            checkoutDate.setDate(today.getDate() + 7);

            const options = { day: '2-digit', month: 'long', year: 'numeric' };
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

            searchInput.addEventListener('input', function () {
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

                    fetch("<?= base_url('get-city-suggestions?term=') ?>" + encodeURIComponent(query), { signal })
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

            document.addEventListener('click', function (e) {
                if (!e.target.closest('#suggestions') && e.target !== searchInput) {
                    loader.style.display = 'none';
                }
            });
        });
    </script>
