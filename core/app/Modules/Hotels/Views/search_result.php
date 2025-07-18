<!-- Toastr CSS -->
<style>
    .current {
        background: #001c34;
    }

    .fa-regular,
    .far {
        font-family: "Font Awesome 6 Free";
        font-weight: 400;
        font-size: 15px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<section style="margin-top:150px">
    <div class="mt-5 px-0 px-md-2 px-lg-5">
        <form id="searchForm" onsubmit="handleSubmit(event)">
            <div class="search-box p-md-2 p-lg-4">
                <!-- <h3 class="py-2 h5">Search Hotels</h3> -->
                <div class="row g-2 align-items-center">
                    <!-- Destination -->
                    <div class="col-lg-4">
                        <label for="searchInput" class="form-label fw-normal mb-1 fs-16px lato">Destination, Zone or Hotel Name</label>
                        <div class="search-dropdown mx-auto col-md-12">
                            <input type="text" id="searchInput" name="destination"
                                class="form-control form-control-lg col-md-12 fs-16px lato" placeholder="Destination"
                                style="font-size: 1rem" value="<?= $_GET['destination'] ?>" />
                            <div id="searchLoader" class="loader-spinner"
                                style="display:none; position:absolute; right:15px; top:50%; transform:translateY(-50%);">
                                <svg width="20" height="20" viewBox="0 0 50 50">
                                    <circle cx="25" cy="25" r="20" stroke="#999" stroke-width="5" fill="none" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div id="suggestions" class="list-group mt-2 fs-16px lato" style="cursor:pointer !important;"></div>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-md-10" style="padding-right: 0px !important;">
                                <label for="dateRange" class="form-label fw-normal fs-16px mb-1 lato">Dates</label>
                                <input type="text" id="daterange" class="form-control fs-16px lato "
                                    value="<?= date('d M Y', strtotime($_GET['checkin'])) . ' - ' . date('d M Y', strtotime($_GET['checkout'])) ?>" />
                                <input type="hidden" id="checkin" name="checkin"
                                    value="<?= date('d F Y', strtotime($_GET['checkin'])) ?>">
                                <input type="hidden" id="checkout" name="checkout"
                                    value="<?= date('d F Y', strtotime($_GET['checkout'])) ?>">
                            </div>
                            <div class="col-md-2">
                                <!-- <div class="col-md-1"> -->
                                <label for="nights" class="form-label fw-normal mb-1 fs-16px lato">Nights</label>
                                <select id="nights" class="form-control fs-16px lato fw-normal">

                                    <script>
                                        for (let i = 1; i <= 30; i++) {
                                            document.write(`<option class="fs-16px lato" value="${i}">${i}</option>`);
                                        }
                                    </script>
                                </select>
                                <!-- </div>  -->
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 col-lg-2 position-relative mt-0 mt-sm-2">
                        <label for="passengerInput" class="form-label fw-normal fs-16px mb-1 lato">Travellers</label>
                        <input type="text" id="passengerInput" name="passenger" readonly
                            class="form-control fs-16px lato fw-normal"
                            style="cursor: pointer;"
                            value="<?= isset($_GET['passenger_summary']) ? htmlspecialchars($_GET['passenger_summary']) : '2 Adults, 1 Room' ?>"
                            placeholder="1 Passenger" />

                        <div id="passengerDropdown"
                            class="p-3 mt-1 bg-white position-absolute w-100 shadow"
                            style="display: none; z-index: 999">

                            <!-- Adults -->
                            <div class="d-flex justify-content-between align-items-center mb-2 fs-16px lato fw-normal ">
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

                    <!-- Search Button -->
                    <div class="col-lg-2 mt-3 mt-sm-2">
                        <button type="submit" class="btn btn-search montserrat" style="margin-top: 28px;">Search</button>
                    </div>


                    <!-- Hidden Inputs for Backend Submission -->
                    <input type="hidden" id="adultsInput" name="adults" value="<?= $_GET['adults'] ?? 2 ?>" />
                    <input type="hidden" id="childrenInput" name="children" value="<?= count($_SESSION['children_ages'] ?? []) ?>" />
                    <input type="hidden" id="roomsInput" name="rooms" value="<?= $_GET['rooms'] ?? 1 ?>" />


                </div>
                <div id="searchError" style="display:none; color: red; font-weight: bold;">
                    &#9888; No results found
                </div>
            </div>
        </form>
    </div>

    <div class="mt-5 px-0 px-md-2 px-lg-5">
        <div class="search-btn mb-2 d-lg-none d-flex align-items-center justify-content-between gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z" />
            </svg>
            <p class="fs-20px fw-normal montserrat m-0">Filters</p>
        </div>
        <div class="row m-0 ">
            <div class="col-md-3 search-slider">
                <div class="filter-section">
                    <div class="header-search-listing">
                        <div class="container">
                            <h5 class="text-center" id="zoneNameText">
                                <?= !empty($_GET['destination']) ? htmlspecialchars($_GET['destination']) : '' ?>
                            </h5>
                            <!-- <p class="mb-0 text-center" style="font-size: 14px">
                                    <span id="filteredCount" style="display: none;"></span>
                                    <span id="separator" style="display: none;"> / </span>
                                    <span
                                        id="totalCount"><?= isset($hotels['hotels']) ? count($hotels['hotels']) : 0 ?></span>
                                    hotels found
                                </p> -->
                            <p class="mb-0 text-center" style="font-size: 14px">
                                <span id="filteredCount" style="display: none;"></span>
                                <span id="separator" style="display: none;"> / </span>
                                <span id="totalCount"><?= isset($hotels['hotels']) ? count($hotels['hotels']) : 0 ?></span>
                                hotels found
                            </p>

                        </div>
                    </div>
                    <h5 class="card-title mb-2  fs-14px fw-medium">Sort By</h5>
                    <select class="form-select sort-dropdown lato  fs-12px fw-normal mb-3 " id="sortHotels">
                        <option selected value="" class="lato  fs-12px fw-normal">Suggested</option>
                        <option value="name-asc" class="lato  fs-12px fw-normal">Hotel Name (A-Z)</option>
                        <option value="price-low" class="lato  fs-12px fw-normal">Price: Low to High</option>
                        <option value="price-high" class="lato  fs-12px fw-normal">Price: High to Low</option>
                    </select>

                    <label for="hotelSearch fs-16px fw-normal" style="font-size: 14px !important;">Hotel Name</label>
                    <div class="input-group mb-3" style="position: relative;">
                        <input list="hotelNames" id="hotelSearch" class="form-control fs-12px lato" placeholder="Search by name" autocomplete="off">
                        <datalist id="hotelNames"></datalist>
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>

                        <!-- Suggestion box container -->
                        <div id="suggestHotels" class="list-group" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000;"></div>
                    </div>

                    <div class="price-filter mb-4">
                        <div class="d-flex justify-content-between mb-2 fs-14px fw-medium">
                            <p>Price (EUR)</p>
                        </div>

                        <div class="d-flex align-items-end gap-2 mb-2">
                            <div>
                                <label class="form-label fs-14px lato">Min.</label>
                                <input type="number" id="minPrice" class="form-control fs-12px lato" value="0" disabled>
                            </div>
                            <span class="mb-1">—</span>
                            <div>
                                <label class="form-label fs-14px lato">Max.</label>
                                <input type="number" id="maxPrice" class="form-control no-spinner fs-12px lato" value="100000" min="1">
                            </div>

                        </div>

                        <!-- <input type="range" id="priceRange" class="form-range" min="0" max="100000" value="0"> -->
                        <div class="mb-3">
                            <label for="priceRange" class="form-label fs-14px montserrat">Max Price (Slider)</label>
                            <input type="range" id="priceRange" class="form-range">
                            <span id="rangeValue" style="display:none;"></span>
                        </div>
                    </div>

                    <div class="mt-4 card-title mb-2 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fs-14px fw-medium">Category</h5>
                    </div>

                    <div id="categoryFilters" class="d-flex gap-2 flex-wrap mt-2">
                        <?php
                        $categoryStars = [];
                        $hasOthers = false;

                        if (!empty($hotels['hotels'])) {
                            foreach ($hotels['hotels'] as $hotel) {
                                if (!empty($hotel['categoryName'])) {
                                    preg_match('/\d+/', $hotel['categoryName'], $matches);
                                    $starCount = isset($matches[0]) ? (int)$matches[0] : 0;

                                    if ($starCount >= 1 && $starCount <= 5) {
                                        $categoryStars[] = $starCount;
                                    } else {
                                        $hasOthers = true;
                                    }
                                } else {
                                    $hasOthers = true;
                                }
                            }
                        }

                        $categoryStars = array_unique($categoryStars);
                        sort($categoryStars);

                        function renderStars($stars)
                        {
                            if ($stars < 1 || $stars > 5) return '';

                            ob_start();
                            echo "<div class='category-box'><div class='star'>";
                            $rows = match ($stars) {
                                1, 2 => [str_repeat("★", $stars)],
                                3 => ["★", "★ ★"],
                                4 => ["★ ★", "★ ★"],
                                5 => ["★ ★", "★", "★ ★"],
                                default => [],
                            };

                            foreach ($rows as $row) {
                                echo "<div class='stars-height'>{$row}</div>";
                            }

                            echo "</div></div>";
                            return ob_get_clean();
                        }

                        foreach ($categoryStars as $index => $stars): ?>
                            <div class="form-check p-0" style="cursor: pointer;">
                                <input class="form-check-input category-filter d-none lato"
                                    type="checkbox" id="category<?= $index ?>" value="<?= esc($stars) ?>" />
                                <label class="form-check-label lato fs-12px fw-normal" for="category<?= $index ?>">
                                    <?= renderStars($stars) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($hasOthers): ?>
                            <div class="form-check p-0" style="cursor: pointer;">
                                <input class="form-check-input category-filter d-none lato"
                                    type="checkbox" id="categoryOthers" value="others" />
                                <label class="form-check-label lato fs-12px fw-normal" for="categoryOthers">
                                    <div class="category-box px-2 py-1 text-muted rounded border" style="font-size:12px;">Others</div>
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>

                    <script>
                        const categoryCheckboxes = document.querySelectorAll('.category-filter');

                        categoryCheckboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', () => {
                                const label = document.querySelector(`label[for="${checkbox.id}"]`);
                                const box = label.querySelector('.category-box');

                                if (checkbox.checked) {
                                    box.classList.add('selected');
                                } else {
                                    box.classList.remove('selected');
                                }
                            });
                        });
                    </script>

                    <h5 class="mt-4 card-title mb-2 fs-14px">Neighborhood</h5>
                    <div id="zoneFilters">
                        <?php
                        $zoneCounts = [];

                        if (!empty($hotels['hotels'])) {
                            foreach ($hotels['hotels'] as $hotel) {
                                $zone = !empty($hotel['zoneName']) ? $hotel['zoneName'] : 'Others';
                                if (!isset($zoneCounts[$zone])) {
                                    $zoneCounts[$zone] = 0;
                                }
                                $zoneCounts[$zone]++;
                            }
                        }

                        $index = 0;
                        foreach ($zoneCounts as $zone => $count):
                            $zoneId = 'zone' . md5($zone);
                            $isHidden = $index >= 10 ? 'd-none extra-zone' : '';
                        ?>
                            <div class="form-check <?= $isHidden ?>">
                                <input class="form-check-input zone-filter  mt-0" type="checkbox" id="<?= $zoneId ?>"
                                    value="<?= esc($zone) ?>" />
                                <label class="form-check-label d-flex justify-content-between" for="<?= $zoneId ?>">
                                    <p class="m-0 fs-12px fw-normal"><?= esc($zone) ?></p>
                                    <p class="m-0 fs-12px fw-normal">(<?= $count ?>)</p>
                                </label>
                            </div>
                        <?php
                            $index++;
                        endforeach;
                        ?>

                        <?php if (count($zoneCounts) > 10): ?>
                            <button type="button" id="toggleZoneFilters" class="btn btn-link p-0 mt-1 fs-12px">Show more</button>
                        <?php endif; ?>
                    </div>
                    <script>
                        document.getElementById('toggleZoneFilters')?.addEventListener('click', function() {
                            const hiddenZones = document.querySelectorAll('.extra-zone');
                            const isExpanded = hiddenZones[0]?.classList.contains('d-none') === false;

                            hiddenZones.forEach(el => el.classList.toggle('d-none'));
                            this.textContent = isExpanded ? 'Show more' : 'Show less';
                        });
                    </script>

                    <?php
                    $boardCounts = [];

                    if (!empty($hotels['hotels'])) {
                        foreach ($hotels['hotels'] as $hotel) {
                            $board = !empty($hotel['rooms'][0]['rates'][0]['boardName']) ? $hotel['rooms'][0]['rates'][0]['boardName'] : 'Others';
                            if (!isset($boardCounts[$board])) {
                                $boardCounts[$board] = 0;
                            }
                            $boardCounts[$board]++;
                        }
                    }
                    ?>

                    <?php if (!empty($boardCounts)): ?>
                        <div class="container mt-4 p-0">
                            <div class="card" style="border: none !important">
                                <div class="card-body" style="padding: 0px !important">
                                    <h5 class="card-title fs-14px fw-medium montserrat">Board</h5>
                                    <?php foreach ($boardCounts as $board => $count): ?>
                                        <div class="form-check">
                                            <input class="form-check-input board-filter mt-0" type="checkbox"
                                                id="board<?= md5($board) ?>" value="<?= esc($board) ?>" />
                                            <label class="form-check-label d-flex justify-content-between"
                                                for="board<?= md5($board) ?>">

                                                <p class="m-0 fs-12px lato fw-normal text-lowercase first-letter-upcase"><?= esc($board) ?></p>
                                                <p class="m-0 fs-12px lato fw-normal text-lowercase">(<?= $count ?>)</p>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $accommodationCounts = [];
                    $accommodationTypeMapping = [
                        'H' => 'Hotel',
                        'A' => 'Apartment',
                        'V' => 'Villa',
                        'P' => 'Hostel',
                        'B' => 'Bed & Breakfast',
                        'C' => 'Camping',
                        'G' => 'Guest House',
                        'M' => 'Motel',
                        'R' => 'Resort',
                        'T' => 'Tourist Flat',
                    ];

                    if (!empty($hotels['hotels'])) {
                        foreach ($hotels['hotels'] as $hotel) {
                            $code = $hotel['hotels_local_accumodation']['accommodation_type_code'] ?? null;
                            $key = (!empty($code) && isset($accommodationTypeMapping[$code])) ? $code : 'Others';
                            if (!isset($accommodationCounts[$key])) {
                                $accommodationCounts[$key] = 0;
                            }
                            $accommodationCounts[$key]++;
                        }
                    }
                    ?>

                    <?php if (!empty($accommodationCounts)): ?>
                        <div class="container mt-4 p-0">
                            <div class="card" style="border: none !important">
                                <div class="card-body" style="padding: 0px !important">
                                    <h5 class="card-title fs-14px fw-medium">Accommodation Type</h5>
                                    <?php foreach ($accommodationCounts as $code => $count): ?>
                                        <div class="form-check">
                                            <input class="form-check-input accommodation-filter  mt-0" type="checkbox"
                                                id="acc<?= md5($code) ?>" value="<?= esc($code) ?>" />
                                            <label class="form-check-label d-flex justify-content-between"
                                                for="acc<?= md5($code) ?>">
                                                <p class="m-0 fs-12px fw-normal lato">
                                                    <?= esc($accommodationTypeMapping[$code] ?? 'Others') ?>
                                                </p>
                                                <p class="m-0 fs-12px fw-normal lato">(<?= $count ?>)</p>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $amenityCounts = [];

                    if (!empty($hotels['hotels'])) {
                        foreach ($hotels['hotels'] as $hotel) {
                            // dd($hotel['hotels_local_accumodation']['thumbnail_url']);

                            $amenities = $hotel['hotels_local_accumodation']['amenities'] ?? [];

                            if (!is_array($amenities)) {
                                $decoded = json_decode($amenities, true);
                                $amenities = is_array($decoded) ? $decoded : explode(',', $amenities);
                            }

                            $validAmenities = [];

                            foreach ($amenities as $amenity) {
                                $amenity = trim($amenity, "[]\" ");

                                if ($amenity && !preg_match('/covid/i', $amenity) && strcasecmp($amenity, 'Ironing Set') !== 0) {
                                    $validAmenities[] = $amenity;
                                    if (!isset($amenityCounts[$amenity])) {
                                        $amenityCounts[$amenity] = 0;
                                    }
                                    $amenityCounts[$amenity]++;
                                }
                            }

                            if (empty($validAmenities)) {
                                $amenityCounts['Others'] = ($amenityCounts['Others'] ?? 0) + 1;
                            }
                        }
                    }

                    arsort($amenityCounts); // Sort by count descending
                    ?>

                    <?php if (!empty($amenityCounts)) { ?>
                        <div class="amenity-filters mt-4 p-0">
                            <h5 class="card-title mb-2 fs-14px fw-medium">Amenities</h5>

                            <?php
                            $count = 0;
                            $total = count($amenityCounts);
                            ?>

                            <?php foreach ($amenityCounts as $amenity => $value): ?>
                                <?php
                                $isHidden = $count >= 10;
                                $count++;
                                ?>
                                <div class="amenity-item <?= $isHidden ? 'extra-amenity d-none' : '' ?>">
                                    <label class="form-check-label d-flex justify-content-between mb-2">
                                        <span class="d-flex align-items-center gap-2">
                                            <input type="checkbox" class="form-check-input amenity-filter mt-0" value="<?= esc($amenity) ?>">
                                            <span class="fs-12px"><?= esc(ucwords(str_replace('_', ' ', strtolower($amenity)))) ?></span>
                                        </span>
                                        <span class="m-0 fs-12px fw-normal lato">(<?= $value ?>)</span>
                                    </label>
                                </div>
                            <?php endforeach; ?>

                            <?php if ($total > 10): ?>
                                <p id="toggleAmenities" class="mt-2 fs-12px text-primary" style="cursor:pointer;">
                                    Show more
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php } ?>

                    <!-- <?php
                            $chainCounts = [];
                            $otherChainCount = 0;

                            if (!empty($hotels['hotels'])) {
                                foreach ($hotels['hotels'] as $hotel) {
                                    $chainCode = $hotel['hotels_local_accumodation']['chain_code'] ?? null;
                                    if ($chainCode && trim($chainCode) !== '') {
                                        if (!isset($chainCounts[$chainCode])) {
                                            $chainCounts[$chainCode] = 0;
                                        }
                                        $chainCounts[$chainCode]++;
                                    } else {
                                        $otherChainCount++;
                                    }
                                }
                            }

                            ksort($chainCounts); // Sort alphabetically
                            ?>

                        <?php if (!empty($chainCounts) || $otherChainCount > 0) { ?>
                        <div class="chain-filters mt-4 p-0">
                            <h5 class="card-title mb-2 fs-14px fw-medium">Hotel Chains</h5>

                            <?php foreach ($chainCounts as $chain => $count): ?>
                            <div>
                                <label class="form-check-label d-flex justify-content-between mb-2">
                                <span class="d-flex align-items-center gap-2">
                                        <input type="checkbox" class="form-check-input chain-filter mt-0" value="<?= esc($chain) ?>">
                                        <span class="fs-12px"><?= esc(ucwords(str_replace('_', ' ', strtolower($chain)))) ?></span>
                                    </span>
                                    <span class="m-0 fs-12px fw-normal lato">(<?= $count ?>)</span>
                                </label>
                            </div>
                            <?php endforeach; ?>

                            <?php if ($otherChainCount > 0): ?>
                            <div>
                                <label class="form-check-label d-flex justify-content-between mb-2">
                                <span class="d-flex align-items-center gap-2">  
                                        <input type="checkbox" class="form-check-input chain-filter" value="others">
                                        <span class="fs-12px">Others</span>
                                    </span>
                                    <span class="m-0 fs-12px fw-normal lato">(<?= $otherChainCount ?>)</span>
                                </label>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php } ?> -->

                    <?php
                    $chainCounts = [];
                    $otherChainCount = 0;

                    if (!empty($hotels['hotels'])) {
                        foreach ($hotels['hotels'] as $hotel) {
                            $chainCode = $hotel['hotels_local_accumodation']['chain_code'] ?? null;
                            if ($chainCode && trim($chainCode) !== '') {
                                if (!isset($chainCounts[$chainCode])) {
                                    $chainCounts[$chainCode] = 0;
                                }
                                $chainCounts[$chainCode]++;
                            } else {
                                $otherChainCount++;
                            }
                        }
                    }

                    ksort($chainCounts); // Sort alphabetically
                    ?>

                    <?php if (!empty($chainCounts) || $otherChainCount > 0) { ?>
                        <div class="chain-filters mt-4 p-0">
                            <h5 class="card-title mb-2 fs-14px fw-medium">Hotel Chains</h5>

                            <?php
                            $index = 0;
                            $totalChains = count($chainCounts);
                            ?>

                            <?php foreach ($chainCounts as $chain => $count): ?>
                                <?php $isHidden = $index >= 10; ?>
                                <div class="chain-item <?= $isHidden ? 'extra-chain d-none' : '' ?>">
                                    <label class="form-check-label d-flex justify-content-between mb-2">
                                        <span class="d-flex align-items-center gap-2">
                                            <input type="checkbox" class="form-check-input chain-filter mt-0" value="<?= esc($chain) ?>">
                                            <span class="fs-12px"><?= esc(ucwords(str_replace('_', ' ', strtolower($chain)))) ?></span>
                                        </span>
                                        <span class="m-0 fs-12px fw-normal lato">(<?= $count ?>)</span>
                                    </label>
                                </div>
                                <?php $index++; ?>
                            <?php endforeach; ?>

                            <?php if ($otherChainCount > 0): ?>
                                <div class="chain-item <?= $index >= 10 ? 'extra-chain d-none' : '' ?>">
                                    <label class="form-check-label d-flex justify-content-between mb-2">
                                        <span class="d-flex align-items-center gap-2">
                                            <input type="checkbox" class="form-check-input chain-filter" value="others">
                                            <span class="fs-12px">Others</span>
                                        </span>
                                        <span class="m-0 fs-12px fw-normal lato">(<?= $otherChainCount ?>)</span>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <?php if ($totalChains + ($otherChainCount > 0 ? 1 : 0) > 10): ?>
                                <p id="toggleChains" class="mt-2 fs-12px text-primary" style="cursor:pointer;">
                                    Show more
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <?php
            if (!empty($hotels['hotels'])) {
                usort($hotels['hotels'], function ($a, $b) use ($destination) {
                    $aMatch = isset($a['name']) && strtolower($a['name']) === strtolower($destination);
                    $bMatch = isset($b['name']) && strtolower($b['name']) === strtolower($destination);

                    if ($aMatch && !$bMatch) {
                        return -1;
                    } elseif (!$aMatch && $bMatch) {
                        return 1;
                    } else {
                        return 0;
                    }
                });
            ?>
                <div class="col-lg-9" id="hotelList">
                    <?php if (!empty($hotels['hotels'])): ?>

                        <?php foreach ($hotels['hotels'] as $hotel): $imagePath = $hotel['hotels_local_accumodation']['thumbnail_url'] ?? null;

                            $imageUrl = $imagePath
                                ? 'https://photos.hotelbeds.com/giata/' . $imagePath
                                : base_url('assets/img/placeholder_hotels.svg');
                        ?>


                            <?php
                            $packaging = $hotel['rooms'][0]['rates'][0]['packaging'] ?? false;
                            ?>

                            <div>

                                <?php
                                $amenities = $hotel['hotels_local_accumodation']['amenities'] ?? [];
                                $amenityList = [];

                                if (!is_array($amenities)) {
                                    $decoded = json_decode($amenities, true);
                                    $amenities = is_array($decoded) ? $decoded : explode(',', $amenities);
                                }

                                foreach ($amenities as $amenity) {
                                    $amenityList[] = trim($amenity, "[]\" ");
                                }
                                ?>
                                <?php
                                $originalPrice = $hotel['minRate'] ?? 0;
                                $markupPercent = $markupPercent ?? 0;
                                $finalPrice = ceil($originalPrice + ($originalPrice * $markupPercent / 100));
                                ?>
                                <?php
                                $categoryStars = 0;
                                if (!empty($hotel['categoryName'])) {
                                    preg_match('/\d+/', $hotel['categoryName'], $matches);
                                    $categoryStars = isset($matches[0]) ? (int)$matches[0] : 0;
                                }
                                ?>
                                <?php
                                $accCode = $hotel['hotels_local_accumodation']['accommodation_type_code'] ?? null;
                                $dataAccommodation = (!empty($accCode) && isset($accommodationTypeMapping[$accCode])) ? $accCode : 'Others';
                                ?>
                                <?php
                                $amenities = $hotel['hotels_local_accumodation']['amenities'] ?? [];
                                if (!is_array($amenities)) {
                                    $decoded = json_decode($amenities, true);
                                    $amenities = is_array($decoded) ? $decoded : explode(',', $amenities);
                                }

                                // $cleanAmenities = array_filter(array_map(function ($a) {
                                //     $a = strtolower(trim($a, "[]\" \n\r\t")); 
                                //     return (!preg_match('/covid/i', $a) && $a !== '') ? $a : null;
                                // }, $amenities));

                                $cleanAmenities = array_filter(array_map(function ($a) {
                                    $a = strtolower(trim($a, "[]\" \n\r\t"));
                                    return (!preg_match('/covid/i', $a) && $a !== '' && stripos($a, 'ironing set') === false) ? $a : null;
                                }, $amenities));


                                $dataAmenities = !empty($cleanAmenities) ? implode(',', $cleanAmenities) : 'others';
                                ?>
                                <div class="hotel-card"
                                    data-name="<?= esc($hotel['name'] ?? '') ?>"
                                    data-price="<?= number_format($finalPrice, 2, '.', '') ?>"
                                    data-category="<?= esc($categoryStars) ?>"
                                    data-zone="<?= esc($hotel['zoneName'] ?? 'Others') ?>"
                                    data-board="<?= esc($hotel['rooms'][0]['rates'][0]['boardName'] ?? 'Others') ?>"
                                    data-accommodation="<?= $dataAccommodation ?>"
                                    data-amenities="<?= esc($dataAmenities) ?>"
                                    data-chain="<?= esc($hotel['hotels_local_accumodation']['chain_code'] ?? 'Others') ?>">
                                    <div class="row g-0 hotel-info-wrapper" id="hotels-wrapper">
                                        <div class="col-md-4 col-md-tab">


                                            <div class="hotel-image"
                                                style="background-image:url('<?= $imageUrl ?>')">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-md-tab">
                                            <div class="hotel-info">
                                                <div class="d-flex justify-content-between hotel-info-container">
                                                    <div
                                                        class="w-50 d-flex justify-content-between flex-column hotel-info-child-1">
                                                        <div>
                                                            <h4 class="fs-16px">
                                                                <?= !empty($hotel['name']) ? esc($hotel['name']) : 'Unnamed Hotel' ?>
                                                            </h4>


                                                            <!-- Show rating stars -->
                                                            <?php
                                                            $ratingStars = '';
                                                            $numericRating = 0;

                                                            if (!empty($hotel['categoryName'])) {
                                                                preg_match('/(\d+(\.\d+)?)/', $hotel['categoryName'], $matches);

                                                                if (!empty($matches)) {
                                                                    $numericRating = floatval($matches[0]);
                                                                    $fullStars = floor($numericRating);
                                                                    $halfStar = ($numericRating - $fullStars) >= 0.5 ? true : false;

                                                                    for ($i = 0; $i < $fullStars; $i++) {
                                                                        $ratingStars .= '<i class="fas fa-star text-warning"></i>';
                                                                    }

                                                                    if ($halfStar) {
                                                                        $ratingStars .= '<i class="fas fa-star-half-alt text-warning"></i>';
                                                                    }

                                                                    $totalStars = $fullStars + ($halfStar ? 1 : 0);
                                                                    for ($i = $totalStars; $i < 5; $i++) {
                                                                        $ratingStars .= '<i class="far fa-star text-warning"></i>';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <div class="rating-stars"><?= $ratingStars ?></div>

                                                        </div>

                                                        <?php
                                                        $accommodationTypeMapping = [
                                                            'H' => 'Hotel',
                                                            'A' => 'Apartment',
                                                            'V' => 'Villa',
                                                            'P' => 'Hostel',
                                                            'B' => 'Bed & Breakfast',
                                                            'C' => 'Camping',
                                                            'G' => 'Guest House',
                                                            'M' => 'Motel',
                                                            'R' => 'Resort',
                                                            'T' => 'Tourist Flat',
                                                        ];

                                                        $code = $hotel['hotels_local_accumodation']['accommodation_type_code'] ?? null;
                                                        // Facilities
                                                        $amenities = $hotel['hotels_local_accumodation']['amenities'] ?? null;
                                                        // var_dump($amenities);die();

                                                        if (!empty($code)) {
                                                            $typeText = $accommodationTypeMapping[$code] ?? ucfirst(strtolower($code));
                                                        ?>
                                                            <p class="text-sm text-gray-600 montserrat fs-16px">
                                                                Accommodation Type: <?= esc($typeText) ?>
                                                            </p>
                                                        <?php } ?>

                                                        <div class="d-flex gap-2" style="height: 30px">
                                                            <p class="district mb-2 text-lowercase">
                                                                <?= !empty($hotel['destinationCode']) ? esc($hotel['destinationCode']) : '' ?>,
                                                                <?= !empty($hotel['zoneName']) ? esc($hotel['zoneName']) : '' ?>
                                                            </p>
                                                        </div>

                                                        <?php

                                                        $boardName = '';
                                                        if (!empty($hotel['rooms'][0]['rates'][0]['boardName'])) {
                                                            $boardName = $hotel['rooms'][0]['rates'][0]['boardName'];
                                                        }
                                                        ?>

                                                        <?php if (!empty($boardName)): ?>
                                                            <div class="d-flex gap-2" style="height: 30px">
                                                                <p class="district mb-2 text-lowercase">Board:
                                                                    <?= esc($boardName) ?></p>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php
                                                        $famousAmenities = ['Internet', 'Car Park', 'Secure Parking', 'Lift Access', 'Luggage Room', 'Air Conditioning', 'Multilingual Staff', 'TV', 'Wake-up Service', 'Gym', 'Fitness Centre', 'Gym / Fitness Centre', 'Spa Centre', 'Massage', 'Sauna', 'Spa Centre / Massage / Sauna', 'Swimming Pool', 'Restaurant', 'Bar', 'Café', 'Breakfast', 'Parking', 'Valet Parking', 'Secure Parking', 'Lift Access', 'Casino', 'Massage', 'Cable TV', 'Satellite TV', 'Airport'];
                                                        // 'Wifi', 'Parking', 'Pool', 'Bathroom', 'Airport', 'Gym', 'Spa', 'Restaurant', 'Bar', 'Laundry'
                                                        $matchedAmenities = [];

                                                        // First filter out covid-related amenities
                                                        // $filteredAmenities = array_filter($amenityList, function ($amenity) {
                                                        //     return !preg_match('/covid/i', $amenity);
                                                        // });

                                                        $filteredAmenities = array_filter($amenityList, function ($amenity) {
                                                            return !preg_match('/covid/i', $amenity) &&
                                                                stripos($amenity, 'ironing set') === false;
                                                        });

                                                        // First collect up to 4 famous amenities
                                                        foreach ($famousAmenities as $famous) {
                                                            if (in_array($famous, $filteredAmenities)) {
                                                                $matchedAmenities[] = $famous;
                                                                if (count($matchedAmenities) == 4) {
                                                                    break;
                                                                }
                                                            }
                                                        }

                                                        // If less than 4 matched, fill the remaining from filtered list (excluding already added)
                                                        if (count($matchedAmenities) < 4) {
                                                            foreach ($filteredAmenities as $amenity) {
                                                                if (!in_array($amenity, $matchedAmenities)) {
                                                                    $matchedAmenities[] = $amenity;
                                                                    if (count($matchedAmenities) == 4) {
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                        <?php if (!empty($matchedAmenities)): ?>
                                                            <div class="hotel-amenities mt-2">
                                                                <ul class="list-inline mb-0" style="font-size: 0.875rem;">
                                                                    <?php foreach ($matchedAmenities as $amenity): ?>
                                                                        <li class="list-inline-item badge bg-secondary text-light p-1 m-1 first-letter-upcase">
                                                                            <?= esc(ucwords(str_replace('_', ' ', $amenity))) ?>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </div>
                                                        <?php endif; ?>

                                                    </div>

                                                    <div class="card w-50 hotel-info-child-2"
                                                        style="border: none;justify-content:space-between">
                                                        <?php
                                                        $nights = 0;
                                                        if (!empty($checkin) && !empty($checkout)) {
                                                            $checkinDate = new DateTime($checkin);
                                                            $checkoutDate = new DateTime($checkout);
                                                            $interval = $checkinDate->diff($checkoutDate);
                                                            $nights = $interval->days;
                                                        }
                                                        ?>
                                                        <span class="fs-16px lato"><?= $rooms ?> Room<?= $rooms > 1 ? 's' : '' ?> - <?= $adults ?>
                                                            Adult<?= $adults > 1 ? 's' : '' ?>- <?= $nights ?>
                                                            Night<?= $nights != 1 ? 's' : '' ?>
                                                            <?php if ($children > 0): ?> -
                                                                <?= $children ?> Child<?= $children != 1 ? 'ren' : '' ?>
                                                            <?php endif; ?> </span>


                                                        <?php
                                                        if (!empty($hotel['rooms'][0]['rates'][0]['cancellationPolicies'])) {
                                                            $policy = $hotel['rooms'][0]['rates'][0]['cancellationPolicies'][0];
                                                            $amount = number_format((float)$policy['amount'], 2);
                                                            $fromDate = date('F j, Y \a\t g:i A', strtotime($policy['from']));

                                                            echo '<p class="text-danger" style="font-size: 12px;">Cancellation fee of €' . $amount . ' applies from ' . $fromDate . '.</p>';
                                                        } else {
                                                            echo '<p class="text-success" style="font-size: 12px;">No cancellation policy!</p>';
                                                        }
                                                        ?>
                                                        <?php helper('generic_helper'); ?>
                                                        <div class="d-flex justify-content-between mt-1">
                                                            <span class="price-label fs-16px">Starting From</span>
                                                            <?php
                                                            $originalPrice = $hotel['minRate'] ?? 0;
                                                            $markupPercent = $markupPercent ?? 0;
                                                            $finalPrice = ceil($originalPrice + ($originalPrice * $markupPercent / 100));

                                                            $currency = $hotel['currency'] ?? 'USD';

                                                            $currencySymbols = [
                                                                'USD' => '$',
                                                                'EUR' => '€',
                                                                'GBP' => '£',
                                                                'INR' => '₹',
                                                                'JPY' => '¥',
                                                            ];
                                                            $currencySymbol = $currencySymbols[$currency] ?? $currency;
                                                            ?>

                                                            <span class="price-value fs-16px"><?= esc($currencySymbol) ?>
                                                                <?= esc(number_format($finalPrice)) ?></span>
                                                        </div>
                                                        <hr />
                                                        <button class="select-room-btn btn-search" target="_blank"
                                                            onclick="viewHotelDetails(<?= esc($hotel['code']) ?>)">SELECT
                                                            ROOM</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <p style="margin-top:20px;">No hotels found.</p>
                        <?php endif; ?>


                            </div>

                </div>
            <?php } ?>
        </div>
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
        </div> -->
<div id="pagination" class="text-center mt-4" style="padding:30px;"></div>
<!-- Gradient Loader Modal -->

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // To force user not to input less then 1 in pricing filter
    document.getElementById('maxPrice').addEventListener('input', function() {
        if (parseInt(this.value) <= 0 || this.value === '') {
            this.value = 1;
        }
    });
</script>
<script>
    function viewHotelDetails(code) {
        window.open("<?= site_url('hotels/hotel-details') ?>/" + code, "_blank");
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- no -->
<script>
    const today = new Date();
    const threeDaysLater = new Date();
    threeDaysLater.setDate(today.getDate() + 3);

    let fpInstance;

    // Get URL Params like $_GET
    const urlParams = new URLSearchParams(window.location.search);
    const childrenAgesParam = urlParams.get('children_ages'); // e.g. "1,6"

    const childrenAgesFromSession = childrenAgesParam ?
        childrenAgesParam.split(',').map(age => parseInt(age.trim(), 10)) :
        <?= json_encode($_SESSION['children_ages'] ?? []) ?>;

    const passengers = {
        adults: <?= isset($_GET['adults']) ? (int)$_GET['adults'] : 2 ?>,
        children: <?= (isset($_GET['children']) && is_numeric($_GET['children']) && (int)$_GET['children'] > 0)
                        ? (int)$_GET['children']
                        : count($_SESSION['children_ages'] ?? []) ?>,
        rooms: <?= isset($_GET['rooms']) ? (int)$_GET['rooms'] : 1 ?>
    };

    document.addEventListener("DOMContentLoaded", function() {
        fpInstance = flatpickr("#daterange", {
            mode: "range",
            dateFormat: "d M Y",
            minDate: "today",
            allowInput: true,
            clickOpens: true,
            closeOnSelect: false,
            defaultDate: [
                "<?= date('Y-m-d', strtotime($checkin)) ?>",
                "<?= date('Y-m-d', strtotime($checkout)) ?>"
            ],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const checkIn = selectedDates[0];
                    const checkOut = selectedDates[1];

                    // Check for same day selection
                    if (checkIn.toDateString() === checkOut.toDateString()) {
                        alert("Check-in and Check-out date cannot be the same.");
                        instance.clear();
                        document.getElementById("checkin").value = "";
                        document.getElementById("checkout").value = "";
                        return;
                    }

                    // Calculate difference in days
                    const nights = Math.round((checkOut - checkIn) / (1000 * 60 * 60 * 24));

                    // Check for range more than 30 days
                    if (nights > 30) {
                        alert("You cannot select more than 30 days.");
                        instance.clear();
                        document.getElementById("checkin").value = "";
                        document.getElementById("checkout").value = "";
                        document.getElementById("nights").value = "";
                        return;
                    }

                    // Set values if valid
                    document.getElementById("checkin").value = flatpickr.formatDate(checkIn, "d F Y");
                    document.getElementById("checkout").value = flatpickr.formatDate(checkOut, "d F Y");
                    document.getElementById("nights").value = nights;

                    instance.close();
                }
            }
        });

        const phpCheckin = new Date("<?= date('Y-m-d', strtotime($_GET['checkin'])) ?>");
        const phpCheckout = new Date("<?= date('Y-m-d', strtotime($_GET['checkout'])) ?>");

        const defaultNights = Math.round((phpCheckout - phpCheckin) / (1000 * 60 * 60 * 24));
        document.getElementById("nights").value = defaultNights;
        syncPassengerUI();
        updateChildAgeInputs();
    });

    document.getElementById("nights").addEventListener("change", function() {
        const nights = parseInt(this.value);
        if (!isNaN(nights) && nights > 0) {
            const newCheckIn = new Date();
            const newCheckOut = new Date();
            newCheckOut.setDate(newCheckIn.getDate() + nights);

            fpInstance.setDate([newCheckIn, newCheckOut]);

            document.getElementById("checkin").value = flatpickr.formatDate(newCheckIn, "d F Y");
            document.getElementById("checkout").value = flatpickr.formatDate(newCheckOut, "d F Y");
        }
    });

    function syncPassengerUI() {
        document.getElementById("adultsCount").textContent = passengers.adults;
        document.getElementById("childrenCount").textContent = passengers.children;
        document.getElementById("roomsCount").textContent = passengers.rooms;

        if (document.getElementById("adultsInput")) document.getElementById("adultsInput").value = passengers.adults;
        if (document.getElementById("childrenInput")) document.getElementById("childrenInput").value = passengers.children;
        if (document.getElementById("roomsInput")) document.getElementById("roomsInput").value = passengers.rooms;

        let summary = `${passengers.adults} Adult${passengers.adults > 1 ? "s" : ""}`;
        if (passengers.children > 0) summary += `, ${passengers.children} Child${passengers.children > 1 ? "ren" : ""}`;
        summary += `, ${passengers.rooms} Room${passengers.rooms > 1 ? "s" : ""}`;
        document.getElementById("passengerInput").value = summary;
    }

    function updatePassenger(type, delta) {
        if (type === "adults") {
            passengers.adults = Math.max(1, Math.min(passengers.adults + delta, 8));
        } else if (type === "children") {
            passengers.children = Math.max(0, Math.min(passengers.children + delta, 4));
            updateChildAgeInputs();
        } else if (type === "rooms") {
            passengers.rooms = Math.max(1, Math.min(passengers.rooms + delta, 10));
        }

        syncPassengerUI();
    }

    function updateChildAgeInputs() {
        const count = passengers.children;
        const container = document.getElementById("childAges");
        container.innerHTML = "";

        if (count > 0) {
            const label = document.createElement("label");
            label.textContent = "Children Ages";
            label.className = "form-label fw-bold mb-1 w-100";
            container.appendChild(label);
        }

        for (let i = 0; i < count; i++) {
            const select = document.createElement("select");
            select.name = "children_ages[]";
            select.id = `childAge${i}`;
            select.className = "form-control mt-2 fs-16px lato fw-normal";
            select.required = false; // <-- No longer required

            const selectedAgeRaw = childrenAgesFromSession[i];
            const selectedAge = (typeof selectedAgeRaw === 'string' || typeof selectedAgeRaw === 'number') ?
                parseInt(selectedAgeRaw, 10) : 0;

            // Option for "0" as default (not selected)
            const defaultOption = document.createElement("option");
            defaultOption.value = "0";
            defaultOption.textContent = `0`;
            defaultOption.selected = selectedAge === 0;
            select.appendChild(defaultOption);

            for (let age = 1; age <= 17; age++) {
                const option = document.createElement("option");
                option.value = age;
                option.textContent = age;
                if (selectedAge === age) {
                    option.selected = true;
                }
                select.appendChild(option);
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
</script>


<!-- no -->
<script>
    // Display none the popup by default
    document.addEventListener('DOMContentLoaded', () => {
        loader = document.getElementById('loader');
        document.getElementById('loader').style.display = 'none';
    });

    function toTitleCase(str) {
        return str.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }


    // document.getElementById('searchInput').addEventListener('input', function() {
    //     let query = this.value;

    //     if (query.length >= 3) {
    //         // fetch(`/get-city-suggestions?term=${query}`)
    //         fetch("<?= base_url('get-city-suggestions?term=') ?>" + query)
    //             .then(response => response.json())
    //             .then(data => {
    //                 const suggestionsBox = document.getElementById('suggestions');
    //                 suggestionsBox.innerHTML = '';

    //                 if (data.length > 0) {

    //                     suggestionsBox.classList.remove('d-none');

    //                     data.forEach(city => {
    //                         let item = document.createElement('a');
    //                         item.classList.add('list-group-item', 'list-group-item-action');

    //                         const parts = [city.city_name, city.state_name, city.country_name].filter(part => part && part.trim()).map(toTitleCase);
    //                         item.textContent = parts.join(', ');

    //                         item.addEventListener('click', () => {
    //                             document.getElementById('searchInput').value = city.city_name;
    //                             suggestionsBox.innerHTML = '';
    //                             suggestionsBox.classList.add('d-none');
    //                         });

    //                         suggestionsBox.appendChild(item);
    //                     });
    //                 } else {
    //                     suggestionsBox.classList.add('d-none');
    //                 }
    //             });
    //     } else {
    //         document.getElementById('suggestions').innerHTML = '';
    //         document.getElementById('suggestions').classList.add('d-none');
    //     }
    // });

    // document.addEventListener("click", function(e) {
    //     const suggestionsBox = document.getElementById('suggestions');
    //     const input = document.getElementById('searchInput');

    //     if (!suggestionsBox.contains(e.target) && e.target !== input) {
    //         suggestionsBox.classList.add('d-none');
    //     }
    // });
    // let controller = null;

    // document.getElementById('searchInput').addEventListener('input', function () {
    //     let query = this.value;

    //     if (query.length >= 3) {
    //         if (controller) {
    //             controller.abort();
    //         }

    //         controller = new AbortController();
    //         const signal = controller.signal;

    //         fetch("<?= base_url('get-city-suggestions?term=') ?>" + query, { signal })
    //             .then(response => response.json())
    //             .then(data => {
    //                 const suggestionsBox = document.getElementById('suggestions');
    //                 suggestionsBox.innerHTML = '';

    //                 if (data.length > 0) {
    //                     suggestionsBox.classList.remove('d-none');

    //                     data.forEach(city => {
    //                         let item = document.createElement('a');
    //                         item.classList.add('list-group-item', 'list-group-item-action');
    //                         const parts = [city.city_name, city.state_name, city.country_name].filter(part => part && part.trim());
    //                         item.textContent = parts.join(', ');

    //                         item.addEventListener('click', () => {
    //                             document.getElementById('searchInput').value = city.city_name;
    //                             suggestionsBox.innerHTML = '';
    //                             suggestionsBox.classList.add('d-none');
    //                         });

    //                         suggestionsBox.appendChild(item);
    //                     });
    //                 } else {
    //                     suggestionsBox.classList.add('d-none');
    //                 }
    //             })
    //             .catch(error => {
    //                 if (error.name !== 'AbortError') {
    //                     console.error('Fetch error:', error);
    //                 }
    //             });
    //     } else {
    //         document.getElementById('suggestions').innerHTML = '';
    //         document.getElementById('suggestions').classList.add('d-none');
    //     }
    // });

    document.addEventListener("click", function(e) {
        const suggestionsBox = document.getElementById('suggestions');
        const input = document.getElementById('searchInput');

        if (!suggestionsBox.contains(e.target) && e.target !== input) {
            suggestionsBox.classList.add('d-none');
        }
    });


    function handleSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const destination = form.destination;
        const checkin = form.checkin;
        const checkout = form.checkout;
        const passenger = form.passenger;
        const adults = document.getElementById('adultsCount').textContent;
        // const children = 0;
        const children = document.getElementById('childrenCount').textContent;
        // alert(children);
        const rooms = document.getElementById('roomsCount').textContent;

        let hasError = false;

        // Basic validation
        if (!destination.value.trim()) {
            destination.classList.add('is-invalid');
            hasError = true;
        }

        if (!checkin.value.trim() || !checkout.value.trim()) {
            dateRange.classList.add('is-invalid');
            hasError = true;
        }

        if (!passenger.value.trim()) {
            passenger.classList.add('is-invalid');
            hasError = true;
        }

        if (hasError) return;

        // Collect children ages from selects
        const childAgeSelects = document.querySelectorAll('#childAges select[name="children_ages[]"]');
        let childrenAges = [];
        let allAgesSelected = true;

        childAgeSelects.forEach(select => {
            const ageValue = parseInt(select.value, 10);
            // If it's not a number, consider it 0 (safety fallback)
            childrenAges.push(isNaN(ageValue) ? 0 : ageValue);
        });

        // if (!allAgesSelected && childAgeSelects.length > 0) {
        //     alert("Please select age for all children.");
        //     return;
        // }

        // document.getElementById('loader').style.display = 'flex';
        // Calculate nights
        const checkinDate = new Date(checkin.value);
        const checkoutDate = new Date(checkout.value);
        const nights = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24));

        // Generate summary HTML
        const summaryHTML = `
                <div style="font-size: 17px; font-weight: 700; margin-bottom: 6px; color: #2c3e50;">
                    ${destination.value}
                </div>
                <div style="font-size: 15px; color: #555;">
                    from <strong>${checkin.value}</strong> to <strong>${checkout.value}</strong>
                </div>
                <div style="margin-top: 6px; font-size: 15px; color: #555;">
                    ${nights} night${nights != 1 ? 's' : ''},
                    ${adults} adult${adults > 1 ? 's' : ''}${children > 0 ? ', ' : ''}
                    ${children > 0 ? `${children} ${children == 1 ? 'child' : 'children'}` : ''}
                    ${children > 0 ? ' ' : ''}and
                    ${rooms} room${rooms > 1 ? 's' : ''}
                </div>
                `;




        document.getElementById('search-summary').innerHTML = summaryHTML;
        document.getElementById('loader').style.display = 'flex';

        // Construct URL with query parameters
        const params = new URLSearchParams({
            destination: destination.value,
            checkin: checkin.value,
            checkout: checkout.value,
            passenger: passenger.value,
            rooms: rooms,
            adults: adults,
            children: children,
        });
        if (childrenAges.length > 0) {
            // Send children ages as comma separated string
            params.append('children_ages', childrenAges.join(','));
        }

        fetch("<?= base_url('search-hotels') ?>?" + params.toString())
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `<?= base_url('search-result') ?>?${params.toString()}`;
                }
                // else {
                //     alert('Error searching hotels: ' + (data.error || 'Unknown error'));
                // }
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


    // Clear red border on input/change
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
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('hotelList');
        const dropdownFilter = document.getElementById('sortHotels');
        const pagination = document.getElementById('pagination');
        const searchBtn = document.getElementById('searchBtn');
        const searchInputFilter = document.getElementById('hotelSearch');
        const suggestionsBox = document.getElementById('suggestHotels');
        const minPriceInput = document.getElementById('minPrice');
        const maxPriceInput = document.getElementById('maxPrice');
        const priceRange = document.getElementById('priceRange');
        const rangeValue = document.getElementById('rangeValue');
        const categoryCheckboxes = document.querySelectorAll('.category-filter');
        const zoneCheckboxes = document.querySelectorAll('.zone-filter');
        const boardCheckboxes = document.querySelectorAll('.board-filter');
        const accommodationCheckboxes = document.querySelectorAll('.accommodation-filter');
        const amenityCheckboxes = document.querySelectorAll('.amenity-filter');
        const chainCheckboxes = document.querySelectorAll('.chain-filter');



        let minPrice = 0;
        let maxPrice = 100000;

        let allCards = Array.from(wrapper.querySelectorAll('.hotel-card'));
        let filteredCards = [...allCards];
        const perPage = 20;
        let currentPage = 1;

        priceRange.addEventListener('input', () => {
            maxPriceInput.value = priceRange.value;
            rangeValue.textContent = priceRange.value;
            filterCards();
        });

        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const label = document.querySelector(`label[for="${checkbox.id}"]`);
                const box = label.querySelector('.category-box');
                checkbox.checked ? box.classList.add('selected') : box.classList.remove('selected');
                filterCards();
            });
        });

        zoneCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterCards);
        });

        boardCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterCards);
        });

        accommodationCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterCards);
        });

        amenityCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterCards);
        });

        chainCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterCards);
        });

        function setupAutocomplete() {
            searchInputFilter.addEventListener('input', () => {
                const term = searchInputFilter.value.trim().toLowerCase();
                suggestionsBox.innerHTML = '';
                if (!term) return;

                const matches = allCards
                    .map(card => card.dataset.name.trim())
                    .filter((name, index, self) => name.toLowerCase().includes(term) && self.indexOf(name) === index)
                    .slice(0, 10);

                matches.forEach(name => {
                    const item = document.createElement('div');
                    item.textContent = name;
                    item.className = 'list-group-item list-group-item-action';
                    item.addEventListener('click', () => {
                        searchInputFilter.value = name;
                        filterCards();
                        suggestionsBox.innerHTML = '';
                    });
                    suggestionsBox.appendChild(item);
                });
            });

            document.addEventListener('click', (e) => {
                if (!searchInputFilter.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.innerHTML = '';
                }
            });
        }

        function sortHotels(sortBy) {
            switch (sortBy) {
                case 'name-asc':
                    filteredCards.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
                    break;
                case 'price-low':
                    filteredCards.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
                    break;
                case 'price-high':
                    filteredCards.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
                    break;
            }
        }

        function calculatePriceRange() {
            const prices = allCards.map(card => parseFloat(card.dataset.price) || 0);
            const actualMin = Math.min(...prices);
            const actualMax = Math.max(...prices);

            minPriceInput.value = actualMin;
            maxPriceInput.value = actualMax;

            priceRange.min = actualMin;
            priceRange.max = actualMax;
            priceRange.value = actualMax;

            rangeValue.textContent = actualMax;
        }

        function filterCards() {
            const nameTerm = searchInputFilter.value.trim().toLowerCase();
            minPrice = parseFloat(minPriceInput.value) || 0;
            maxPrice = parseFloat(maxPriceInput.value) || 100000;

            const selectedCategories = Array.from(categoryCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const selectedZones = Array.from(zoneCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());

            const selectedBoards = Array.from(boardCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());

            const selectedAccommodation = Array.from(accommodationCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());

            const selectedAmenities = Array.from(amenityCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());

            const selectedChains = Array.from(chainCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());

            filteredCards = allCards.filter(card => {
                const name = card.dataset.name.toLowerCase();
                const price = parseFloat(card.dataset.price) || 0;
                const cardCategory = card.dataset.category || "";
                // const cardZone = (card.dataset.zone || "").toLowerCase();
                let cardZone = card.dataset.zone?.trim().toLowerCase() || "others";
                // const cardBoard = (card.dataset.board || "").toLowerCase();
                let cardBoard = card.dataset.board?.trim().toLowerCase() || "others";
                // const cardAccommodation = (card.dataset.accommodation || "").toLowerCase();
                let cardAccommodation = card.dataset.accommodation?.trim().toLowerCase() || "others";
                let cardAmenities = card.dataset.amenities?.trim().toLowerCase() || "others";
                let cardChain = card.dataset.chain?.trim().toLowerCase() || "others";

                const nameMatch = name.includes(nameTerm);
                const priceMatch = price >= minPrice && price <= maxPrice;
                // const categoryMatch = selectedCategories.length === 0 || selectedCategories.includes(cardCategory);
                const categoryMatch = selectedCategories.length === 0 ||
                    selectedCategories.includes(cardCategory) ||
                    (selectedCategories.includes('others') && (cardCategory === '' || !['1', '2', '3', '4', '5'].includes(cardCategory)));
                const zoneMatch = selectedZones.length === 0 || selectedZones.includes(cardZone);
                const boardMatch = selectedBoards.length === 0 || selectedBoards.includes(cardBoard);
                const accommodationMatch = selectedAccommodation.length === 0 || selectedAccommodation.includes(cardAccommodation);
                // const amenitiesMatch = selectedAmenities.length === 0 || selectedAmenities.includes(cardAmenities);
                const amenitiesArray = cardAmenities.split(',').map(a => a.trim());
                const amenitiesMatch = selectedAmenities.length === 0 || selectedAmenities.some(selected => amenitiesArray.includes(selected));

                const chainMatch = selectedChains.length === 0 || selectedChains.includes(cardChain);

                return nameMatch && priceMatch && categoryMatch && zoneMatch && boardMatch && accommodationMatch && amenitiesMatch && chainMatch;
            });

            document.getElementById('filteredCount').textContent = filteredCards.length;
            document.getElementById('filteredCount').style.display = filteredCards.length !== allCards.length ? 'inline' : 'none';
            document.getElementById('separator').style.display = filteredCards.length !== allCards.length ? 'inline' : 'none';

            sortHotels(dropdownFilter.value);
            renderPage(1);
        }


        function renderPage(page) {
            const totalPages = Math.ceil(filteredCards.length / perPage);
            currentPage = Math.max(1, Math.min(page, totalPages));
            wrapper.innerHTML = '';

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const pageCards = filteredCards.slice(start, end);
            pageCards.forEach(card => wrapper.appendChild(card));

            renderPagination(totalPages);
        }

        function renderPagination(totalPages) {
            pagination.innerHTML = '';
            if (totalPages <= 1) return;

            const prevBtn = document.createElement('button');
            prevBtn.textContent = 'Previous';
            prevBtn.className = 'btn btn-sm btn-outline-secondary mx-1';
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => renderPage(currentPage - 1));
            pagination.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = 'btn btn-sm mx-1 ' + (i === currentPage ? 'btn-primary current' : 'btn-outline-secondary');
                btn.addEventListener('click', () => renderPage(i));
                pagination.appendChild(btn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.textContent = 'Next';
            nextBtn.className = 'btn btn-sm btn-outline-secondary mx-1';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', () => renderPage(currentPage + 1));
            pagination.appendChild(nextBtn);
        }

        // Event Listeners
        dropdownFilter.addEventListener('change', () => {
            sortHotels(dropdownFilter.value);
            renderPage(1);
        });

        searchBtn.addEventListener('click', filterCards);

        searchInputFilter.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                filterCards();
            }
        });

        minPriceInput.addEventListener('input', filterCards);
        maxPriceInput.addEventListener('input', filterCards);

        setupAutocomplete();
        calculatePriceRange();
        sortHotels(dropdownFilter.value);
        renderPage(1);
    });
</script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleAmenities');
        let isExpanded = false;

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                document.querySelectorAll('.extra-amenity').forEach(el => {
                    el.classList.toggle('d-none');
                });

                isExpanded = !isExpanded;
                toggleBtn.textContent = isExpanded ? 'Show Less' : 'Load More';
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleChainsBtn = document.getElementById('toggleChains');
        let isChainsExpanded = false;

        if (toggleChainsBtn) {
            toggleChainsBtn.addEventListener('click', function() {
                document.querySelectorAll('.extra-chain').forEach(el => {
                    el.classList.toggle('d-none');
                });

                isChainsExpanded = !isChainsExpanded;
                toggleChainsBtn.textContent = isChainsExpanded ? 'Show Less' : 'Show more';
            });
        }
    });

    const btntoggle = document.querySelector('.search-btn');
    const slider = document.querySelector('.search-slider');

    function showSlider() {
        slider.classList.add('open');
    }

    function hideSlider() {
        slider.classList.remove('open');
    }

    function toggleBehavior(enable) {
        if (enable) {
            btntoggle.addEventListener('click', showSliderHandler);
            document.addEventListener('click', hideSliderHandler);
        } else {
            btntoggle.removeEventListener('click', showSliderHandler);
            document.removeEventListener('click', hideSliderHandler);
            hideSlider();
        }
    }

    function showSliderHandler(e) {
        e.stopPropagation();
        showSlider();
    }

    function hideSliderHandler(e) {
        if (!slider.contains(e.target) && !btntoggle.contains(e.target)) {
            hideSlider();
        }
    }

    function checkWindowSize() {
        if (window.innerWidth <= 768) {
            toggleBehavior(true);
        } else {
            toggleBehavior(false);
        }
    }

    checkWindowSize();

    window.addEventListener('resize', checkWindowSize);
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const loader = document.getElementById('searchLoader');
        const error = document.getElementById('searchError');
        const suggestionsBox = document.getElementById('suggestions');
        let controller = null;

        

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

             // Reset error & suggestions on input
            error.style.display = 'none';
            suggestionsBox.innerHTML = '';
            suggestionsBox.classList.add('d-none');


            if (query.length >= 3) {
                // Show loader
                if (loader) loader.style.display = 'block';

                // Cancel previous request if running
                if (controller) controller.abort();

                controller = new AbortController();
                const signal = controller.signal;

                fetch("<?= base_url('get-city-suggestions?term=') ?>" + encodeURIComponent(query), {
                        signal
                    })
                    .then(response => response.json())
                    .then(data => {
                        suggestionsBox.innerHTML = '';

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
                                });

                                suggestionsBox.appendChild(item);
                            });
                        } else {
                            // suggestionsBox.classList.add('d-none');
                             error.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        if (error.name !== 'AbortError') {
                            console.error('Search fetch error:', error);
                        }
                    })
                    .finally(() => {
                        if (loader) loader.style.display = 'none';
                    });
            } else {
                suggestionsBox.innerHTML = '';
                suggestionsBox.classList.add('d-none');
                if (loader) loader.style.display = 'none';
            }
        });
    });
</script> -->
<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const loader = document.getElementById('searchLoader');
        const error = document.getElementById('searchError');
        const suggestionsBox = document.getElementById('suggestions');

        if (!searchInput || !loader || !error || !suggestionsBox) return;

        let controller = null;

        searchInput.addEventListener('input', function () {
            const query = this.value.trim();

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
</script> -->
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