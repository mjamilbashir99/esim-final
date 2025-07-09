<h2 class="text-center my-5 text-dark-green">Country plans</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
<?php endif; ?>

<div class="container ">
    <div class="row gap-2 flex-md-column flex-lg-row" style="margin-bottom: 30px;">
        <?php foreach ($destinations as $country => $bundles): ?>
            <?php $firstBundle = $bundles[0] ?? null; ?>
            <?php if ($firstBundle): ?>
                <div class="col-lg-3 p-2 mt-3 bg-light-green border-radius border-color-dark container-fluid d-flex justify-content-between align-items-center arrow-hover-180">
                    <div class="d-flex gap-3 align-items-center">
                        <img src="<?= esc($firstBundle['imageUrl']) ?>" alt="Bundle Image" style="
                            width: 50px;
                            height: 50px;
                            object-fit: cover;
                            border-radius: 50%;
                        " />
                        <div class="text-dark-green">
                            <p class="h6 fw-bold m-0"><?= esc($country) ?></p>
                            <p class="h6 fw-normal m-0"><?= esc($firstBundle['description']) ?></p>
                            <p><strong><?= count($bundles) ?> Plans Available</strong></p>
                            <a href="<?= site_url('destinations/' . urlencode($country)) ?>">View Plans</a>
                        </div>
                    </div>
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>