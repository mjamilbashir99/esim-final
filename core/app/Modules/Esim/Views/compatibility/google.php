<style>
    body {
        background-color: #f7fdf9;
    }

    .sidebar {
        background-color: #e0f2f1;
        padding: 20px;
        border-radius: 10px;
    }

    .article-box {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .article-box h2 {
        color: #0f9d58;
        /* Google green */
    }

    .category-link {
        color: #0f9d58;
        text-decoration: none;
    }

    .category-link:hover {
        text-decoration: underline;
    }

    .screenshot {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin-bottom: 15px;
    }
</style>

<div class="container my-5">
    <h2 class="text-dark-green fw-bold">Google eSIM Compatibility</h2>
    <img src="data:image/jpeg;base64,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" alt="Google eSIM Compatible Devices" class="screenshot" />
    <p class="text-muted">Last updated: 5 months ago</p>

    <p class="mb-4"><strong>Important:</strong> Your device must be <strong>carrier-unlocked</strong> to use an eSIM.</p>

    <h5 class="fw-bold text-dark-green">Compatible Pixel Phones</h5>
    <ul class="list-group mb-4">
        <?php
        $pixelList = [
            'Pixel 3 (excluding Verizon and some Japanese models)',
            'Pixel 3 XL',
            'Pixel 3a',
            'Pixel 3a XL',
            'Pixel 4',
            'Pixel 4 XL',
            'Pixel 4a',
            'Pixel 4a (5G)',
            'Pixel 5',
            'Pixel 5a',
            'Pixel 6',
            'Pixel 6 Pro',
            'Pixel 6a',
            'Pixel 7',
            'Pixel 7 Pro',
            'Pixel 7a',
            'Pixel 8',
            'Pixel 8 Pro',
            'Pixel 8a',
            'Pixel Fold'
        ];

        foreach ($pixelList as $device): ?>
            <li class="list-group-item"><?= esc($device) ?></li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Note:</strong> Most Pixel devices from Pixel 4 onward support dual SIM (1 eSIM + 1 physical SIM).</p>
    <p><strong>Exceptions:</strong> Pixel 3 models from Japan and Verizon are not eSIM-compatible.</p>
    <p><strong>Foldable:</strong> Pixel Fold supports dual active eSIM and physical SIM.</p>

    <?= view('partials/recent_views') ?>

</div>