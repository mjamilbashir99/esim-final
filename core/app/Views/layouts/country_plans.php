<h2 class="text-center my-5 text-dark-green">Plans for <?= esc($country) ?></h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?= esc($error) ?></div>
<?php endif; ?>

<?php if (empty($bundles)): ?>
    <p class="text-center text-muted">No plans available for <?= esc($country) ?>.</p>
<?php else: ?>
    <div class="container">
        <div class="row">
            <?php foreach ($bundles as $bundle): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm bg-light-green border-color-dark border-radius h-100">
                        <img src="<?= esc($bundle['imageUrl']) ?>" class="card-img-top border-bottom" alt="<?= esc($bundle['name']) ?>" style="object-fit: cover; height: 200px;">
                        <div class="card-body text-dark-green">
                            <h5 class="card-title fw-bold"><?= esc($bundle['name']) ?></h5>
                            <p class="card-text"><?= esc($bundle['description']) ?></p>
                            <p><strong>Price:</strong> <?= convertCurrency($bundle['selling_price'] ?? $bundle['price']) ?></p>
                            <a href="<?= site_url('bundle/' . $bundle['name']) ?>">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
