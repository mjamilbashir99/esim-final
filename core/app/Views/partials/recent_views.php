<?php
$recentBrands = session()->get('recent_views') ?? [];
?>

<?php if (!empty($recentBrands)): ?>
    <div class="mt-5">
        <h5 class="text-success">🕘 Recently Viewed Articles</h5>
        <ul class="list-group small">
            <?php foreach ($recentBrands as $brand): ?>
                <li class="list-group-item">
                    <a href="<?= site_url('compatibility/' . $brand) ?>" style="display: inline-flex; align-items: center; text-decoration: none; color: inherit;">
                        <img
                            src="<?= base_url('assets/img/article_img.png') ?>"
                            alt="Article logo"
                            loading="lazy"
                            style="width: 30px; height: 30px; margin-right: 8px; vertical-align: middle;">
                        <?= ucfirst($brand) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>