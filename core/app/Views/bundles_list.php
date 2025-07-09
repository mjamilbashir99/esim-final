<style>
    .custom-section {
        padding: 60px 20px;
    }

    .custom-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .autocomplete-suggestions {
        z-index: 1000;
        background: #fff;
        max-height: 150px;
        overflow-y: auto;
        width: 100%;
    }

    .autocomplete-suggestion {
        padding: 8px;
        cursor: pointer;
    }

    .autocomplete-suggestion:hover {
        background-color: #f0f0f0;
    }

    #search-input::placeholder {
        color: white !important;
        opacity: 1;
        /* For Firefox */
    }

    .flag-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        padding: 20px;
    }

    .flag {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        transition: transform 0.3s ease;
    }

    .flag:hover {
        transform: scale(1.3);
    }

    .andorra {
        background-image: url('https://flagcdn.com/w320/ad.png');
    }

    .united-arab-emirates {
        background-image: url('https://flagcdn.com/w320/ae.png');
    }

    .australia {
        background-image: url('https://flagcdn.com/w320/au.png');
    }

    .brazil {
        background-image: url('https://flagcdn.com/w320/br.png');
    }

    .canada {
        background-image: url('https://flagcdn.com/w320/ca.png');
    }

    .chile {
        background-image: url('https://flagcdn.com/w320/cl.png');
    }

    .denmark {
        background-image: url('https://flagcdn.com/w320/dk.png');
    }

    .tab-button-style {
        background-color: #e6f9f0;
        border-radius: 10px;
        border: 1px solid #007b5e;
        color: #007b5e;
        padding: 10px 20px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .tab-button-style:hover {
        background-color: #d2f4e3;
        color: #005f46;
    }

    .nav-tabs .nav-link.active {
        background-color: #007b5e !important;
        color: #fff !important;
        border-color: #007b5e !important;
    }

    #regionSelect {
        background-color: #d7f0d8;
        color: #2a5d34;
        border: 1px solid #2a5d34;
        border-radius: 8px;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-weight: 600;
        width: auto;
        min-width: 200px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    #regionSelect:focus {
        background-color: #c0e8be;
        color: #1f4625;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(42, 93, 52, 0.5);
    }

    #regionSelect {
        background-image:
            linear-gradient(45deg, transparent 50%, #2a5d34 50%),
            linear-gradient(135deg, #2a5d34 50%, transparent 50%),
            linear-gradient(to right, #d7f0d8, #d7f0d8);
        background-position:
            calc(100% - 20px) calc(1em + 2px),
            calc(100% - 15px) calc(1em + 2px),
            100% 0;
        background-size: 5px 5px, 5px 5px, 2.5em 2.5em;
        background-repeat: no-repeat;
    }

    #regionSelect option:checked {
        background-color: #2a5d34;
        color: #d7f0d8;
    }
</style>

<main>
    <section class="container-fluid p-0 m-0 position-relative col-md-12 mobile-banner"
        style="height: auto; margin-top: -20px !important; overflow-y: hidden">
        <video class="inline-webm-video video-background d-none d-md-block" playsinline="" autoplay="" muted=""
            loop="">
            <source src="//breezesim.com/cdn/shop/t/108/assets/hero-video.mp4?v=123329851794697263961719408166"
                type="" />
        </video>
        <!-- overlay video -->
        <div class="overlay-banner">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <?php if ($session->has('user_id')) : ?>
                        <h1 class="text-light h1 py-2">Welcome <b><?= esc($session->get('user_name')) ?></b></h1>
                    <?php endif; ?>
                    <h1 class="text-light h1 fw-bolder py-2">
                        eSIM for Every Journey
                    </h1>
                    <p class="h6 fw-normal text-light text-center py-2">
                        Roam Easy: Data, Calls & Texts in One eSIM.
                    </p>
                    <div class="flag-container">
                        <a href="?country=Andorra#bundles-section">
                            <div class="flag andorra"></div>
                        </a>
                        <a href="?country=United+Arab+Emirates#bundles-section">
                            <div class="flag united-arab-emirates"></div>
                        </a>
                        <a href="?country=Australia#bundles-section">
                            <div class="flag australia"></div>
                        </a>
                        <a href="?country=Brazil#bundles-section">
                            <div class="flag brazil"></div>
                        </a>
                        <a href="?country=Canada#bundles-section">
                            <div class="flag canada"></div>
                        </a>
                        <a href="?country=Chile#bundles-section">
                            <div class="flag chile"></div>
                        </a>
                        <a href="?country=Denmark#bundles-section">
                            <div class="flag denmark"></div>
                        </a>
                    </div>
                    <div class="input-group overflow-hidden border border-light border-radius my-4">
                        <form method="get" action="<?= site_url('esim') ?>" id="search-form" class="d-flex w-100">
                            <input type="text" name="search" style="background-color: transparent !important;" class="form-control text-light border-none" id="search-input" placeholder="Search countries..." aria-label="Search countries" value="<?= esc($searchQuery ?? '') ?>" autocomplete="off" />

                            <button type="submit" class="input-group-text border-0" style="background-color: transparent !important;">
                                <i class="bi bi-search text-light"></i>
                            </button>
                            <div id="typing-spinner"
                                class="spinner-border spinner-border-sm text-light position-absolute"
                                style="right: 45px; top: 50%; transform: translateY(-50%) ; display: none;"
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </form>

                        <div id="autocomplete-suggestions" class="autocomplete-suggestions"></div>

                    </div>
                </div>
            </div>
    </section>

    <section id="bundles-section" class="container-fluid p-0 m-0 position-relative my-5">
        <h2 class="display-6 fw-bold my-5 text-dark-green text-center">
            Available Bundles
        </h2>

        <!-- Tabs -->
        <div class="d-flex justify-content-center my-4">
            <ul class="nav nav-tabs border-0 gap-3" id="bundleTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active tab-button-style" id="country-tab" data-bs-toggle="tab" href="#by-country" role="tab">
                        Browse by Country
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link tab-button-style" id="region-tab" data-bs-toggle="tab" href="#by-region" role="tab">
                        Browse by Region
                    </a>
                </li>
            </ul>
        </div>


        <div class="tab-content" id="bundleTabContent">
            <!-- Country Tab -->
            <div class="tab-pane fade show active" id="by-country" role="tabpanel">
                <div class="tab-content container">
                    <div class="tab-pane fade show active shadow border-radius container p-5" id="pills-home">
                        <div class="row gap-2 flex-md-column flex-lg-row">
                            <?php if (!empty($bundles)): ?>
                                <?php foreach ($bundles as $bundle): ?>
                                    <div class="col-lg-3 p-2 mt-3 bg-light-green border-radius border-color-dark col container-fluid d-flex justify-content-between align-items-center arrow-hover-180">
                                        <div class="d-flex gap-3 align-items-center">
                                            <img src="<?= esc($bundle['imageUrl']) ?>" alt="Bundle Image" style="
                                            width: 50px;
                                            height: 50px;
                                            object-fit: cover;
                                            border-radius: 50%;
                                        " />
                                            <div class="text-dark-green">
                                                <?php if (!empty($bundle['countries'])): ?>
                                                    <?php foreach ($bundle['countries'] as $country): ?>
                                                        <p class="h6 fw-bold m-0"><?= esc($country['name']) ?></p>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <p class="h6 fw-bold m-0">N/A</p>
                                                <?php endif; ?>
                                                <p class="h6 fw-normal m-0">
                                                    <?= esc($bundle['description']) ?>
                                                </p>
                                                <p><strong>Price:</strong> <?= convertCurrency($bundle['selling_price'] ?? $bundle['price']); ?></p>
                                                <a href="<?= site_url('bundle/' . $bundle['name']) ?>">View Details</a>
                                            </div>
                                        </div>
                                        <i class="bi bi-arrow-up-right"></i>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No bundles available.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Pagination -->
                        <div style="margin-top: 20px; text-align: center;">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?>&search=<?= esc($searchQuery ?? '') ?>#bundles-section"
                                    style="margin: 0 6px; padding: 6px 12px; background: <?= $i == $currentPage ? '#007bff' : '#eee' ?>; color: <?= $i == $currentPage ? '#fff' : '#000' ?>; text-decoration: none; border-radius: 4px;">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>

                        <!-- Country Filter -->
                        <h4 class="mt-5">Filter by Country</h4>
                        <div class="mb-4">
                            <a href="<?= site_url('esim') ?>#bundles-section"
                                style="margin-right: 10px; font-weight: <?= empty($selectedCountry) ? 'bold' : 'normal' ?>">All</a>
                            <?php foreach ($countries as $country): ?>
                                <a href="<?= site_url('esim') ?>?country=<?= urlencode($country) ?>#bundles-section"
                                    style="margin-right: 10px; font-weight: <?= $selectedCountry == $country ? 'bold' : 'normal' ?>">
                                    <?= esc($country) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Region Tab -->
            <div class="tab-pane fade <?= ($activeTab === 'region') ? 'show active' : '' ?>" id="by-region" role="tabpanel">
                <div class="tab-content container">
                    <div class="tab-pane fade show active shadow border-radius container p-5" id="pills-region">

                        <!-- Dropdown for region filter -->
                        <div class="mb-4 d-flex justify-content-center">
                            <select id="regionSelect" class="form-select w-auto">
                                <option value="all" selected>All Regions</option>
                                <?php foreach ($regions as $region): ?>
                                    <option value="<?= esc($region) ?>"><?= esc($region) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <!-- Bundles container -->
                        <div id="regionBundlesContainer">
                            <?php if (!empty($regionBundles)): ?>
                                <?php foreach ($regionBundles as $region => $bundles): ?>
                                    <div class="region-group" data-region="<?= esc($region) ?>">
                                        <div class="row">
                                            <div class="col-lg-3 offset-lg-0 ms-lg-0">
                                                <h4 class="text-dark-green mt-5" style="margin-left: 35px;"><?= esc($region) ?></h4>
                                            </div>
                                        </div>

                                        <div class="row gap-2 flex-md-column flex-lg-row">
                                            <?php foreach ($bundles as $bundle): ?>
                                                <div class="col-lg-3 p-2 mt-3 bg-light-green border-radius border-color-dark container-fluid d-flex justify-content-between align-items-center arrow-hover-180">
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <img src="<?= esc($bundle['imageUrl']) ?>" alt="Bundle Image" style="
                                    width: 50px;
                                    height: 50px;
                                    object-fit: cover;
                                    border-radius: 50%;
                                " />
                                                        <div class="text-dark-green">
                                                            <?php if (!empty($bundle['countries'])): ?>
                                                                <?php foreach ($bundle['countries'] as $country): ?>
                                                                    <p class="h6 fw-bold m-0"><?= esc($country['name']) ?></p>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <p class="h6 fw-bold m-0">N/A</p>
                                                            <?php endif; ?>
                                                            <p class="h6 fw-normal m-0"><?= esc($bundle['description']) ?></p>
                                                            <p><strong>Price:</strong> <?= convertCurrency($bundle['selling_price'] ?? $bundle['price']); ?></p>
                                                            <a href="<?= site_url('bundle/' . $bundle['name']) ?>">View Details</a>
                                                        </div>
                                                    </div>
                                                    <i class="bi bi-arrow-up-right"></i>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No region-based bundles available.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
    </section>

    <div class="mt-5">
    <div class="text-center mt-3">
        <a href="<?= site_url('destinations') ?>" class="btn btn-success btn-lg">
            View All Destinations
        </a>
    </div>
</div>



    <section class="py-5 my-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mb-3">
                        <i class="bi bi-globe2 fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-semibold">Affordable Plans</h5>
                    <p class="mb-0">
                        Enjoy Global Connectivity without<br />
                        Overspending
                    </p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mb-3">
                        <i class="bi bi-phone fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-semibold">Free Roaming</h5>
                    <p class="mb-0">Say Goodbye to Roaming Charges</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mb-3">
                        <i class="bi bi-speedometer2 fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-semibold">Reliable & Fast Internet</h5>
                    <p class="mb-0">Stream, Browse, and Connect Faster</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mb-3">
                        <i class="bi bi-sim fs-1 text-success"></i>
                    </div>
                    <h5 class="fw-bold">Easy Installation</h5>
                    <p class="mb-0">Get Connected in a few Taps</p>
                </div>
            </div>
        </div>
    </section>

    <section class="custom-section bg-dark-green">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left side: Text + Button -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="mb-3 text-light h1 fw-bold">Explore Amazing Places</h2>
                    <p class="mb-4 text-light-green display-6">
                        however the wind may drift, it means little to the air in motion
                    </p>
                    <a href="#"
                        class="btn btn-primary text-dark border-radius border-light bg-light-green display-6">Get
                        Started</a>
                </div>

                <!-- Right side: Image -->
                <div class="col-md-6">
                    <img src="https://picsum.photos/seed/picsum/536/354" alt="Travel" class="custom-image" />
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="container mt-5">
            <h2 class="mb-4 display-6 fw-bold text-dark-green text-center">
                FAQs
            </h2>
            <div class="row">
                <div class="col-md-6 mb-md-3">
                    <div class="accordion" id="accordionLeft">
                        <div class="accordion-item mb-3 border-radius border-color-dark overflow-hidden">
                            <h2 class="accordion-header" id="leftOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#leftCollapseOne" aria-expanded="false"
                                    aria-controls="leftCollapseOne">
                                    Question 1: What is an eSim?
                                </button>
                            </h2>
                            <div id="leftCollapseOne" class="accordion-collapse collapse" aria-labelledby="leftOne"
                                data-bs-parent="#accordionLeft">
                                <div class="accordion-body">
                                    eSIM stands for “embedded SIM”, because everything you need is digitally built into your smartphone or tablet. Think of it as the evolution of the SIM card - it’s just like your old SIM, but better! Now there are no tiny holes or bits of plastic to deal with, so you never have to think about swapping out SIM cards again. Wave goodbye to the old and say hello to the future of mobile connectivity!
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 border-radius border-color-dark overflow-hidden">
                            <h2 class="accordion-header" id="leftTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#leftCollapseTwo" aria-expanded="false"
                                    aria-controls="leftCollapseTwo">
                                    Question 2: Can All Phones Use eSIM?
                                </button>
                            </h2>
                            <div id="leftCollapseTwo" class="accordion-collapse collapse" aria-labelledby="leftTwo"
                                data-bs-parent="#accordionLeft">
                                <div class="accordion-body">
                                    Ensure your phone is both network unlocked and eSIM compatible before making a purchase. All iPhones made since 2018 and most new Android models are compatible.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="accordion" id="accordionRight">
                        <div class="accordion-item mb-3 border-radius border-color-dark overflow-hidden">
                            <h2 class="accordion-header" id="rightOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#rightCollapseOne" aria-expanded="true"
                                    aria-controls="rightCollapseOne">
                                    Is eSIM good for travel?
                                </button>
                            </h2>
                            <div id="rightCollapseOne" class="accordion-collapse collapse" aria-labelledby="rightOne"
                                data-bs-parent="#accordionRight">
                                <div class="accordion-body">
                                    Yes, eSIM is a great option for travelers. It allows you to switch between different carriers and plans without needing to physically swap SIM cards. This means you can easily get local data plans when traveling abroad, avoiding expensive roaming charges.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-radius border-color-dark overflow-hidden">
                            <h2 class="accordion-header" id="rightTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#rightCollapseTwo" aria-expanded="false"
                                    aria-controls="rightCollapseTwo">
                                    Question 4: What country do not support eSIM?
                                </button>
                            </h2>
                            <div id="rightCollapseTwo" class="accordion-collapse collapse" aria-labelledby="rightTwo"
                                data-bs-parent="#accordionRight">
                                <div class="accordion-body">
                                    While eSIM is widely accepted, a few places might still be catching up. Like use of eSIM in India and Russia is not common. It's best to check eSIMCard's country list before you go. But don't worry, most countries are on board with eSIM technology now!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    const input = document.getElementById('search-input');
    const spinner = document.getElementById('typing-spinner');
    const suggestionsBox = document.getElementById('autocomplete-suggestions');

    let timer;
    const delay = 300;

    input.addEventListener('input', () => {
        spinner.style.display = 'inline-block';

        clearTimeout(timer);
        timer = setTimeout(() => {
            checkForSuggestions();
        }, delay);
    });

    function checkForSuggestions() {
        let checkCount = 0;
        const maxChecks = 10;

        const waitForResult = setInterval(() => {
            const hasResults = suggestionsBox && suggestionsBox.innerHTML.trim() !== '';

            if (hasResults) {
                spinner.style.display = 'none';
                clearInterval(waitForResult);
            }

            checkCount++;

            if (checkCount >= maxChecks) {
                spinner.style.display = 'none';
                clearInterval(waitForResult);
            }
        }, 50);
    }
</script>
<script>
    document.getElementById('regionSelect').addEventListener('change', function() {
        const selectedRegion = this.value;
        const allGroups = document.querySelectorAll('.region-group');

        allGroups.forEach(group => {
            if (selectedRegion === 'all') {
                group.style.display = 'block'; // show all
            } else {
                if (group.dataset.region === selectedRegion) {
                    group.style.display = 'block'; // show selected region
                } else {
                    group.style.display = 'none'; // hide others
                }
            }
        });
    });
</script>