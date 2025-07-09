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
        color: #1b5e20;
        /* consistent with your dark green */
    }

    .category-link {
        color: #2e7d32;
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

    .list-group-item.text-muted {
        color: #888;
        background-color: #f8f9fa;
    }
</style>

<div class="container my-5">
    <h2 class="text-dark-green fw-bold">Samsung eSIM Compatibility</h2>
    <img src="data:image/jpeg;base64,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" alt="Samsung eSIM Compatible Devices" class="screenshot" />
    <p class="text-muted">Last updated: 5 months ago</p>

    <p class="mb-4"><strong>Important:</strong> Your device must be <strong>carrier-unlocked</strong> to use an eSIM.</p>

    <h5 class="fw-bold text-dark-green">Compatible Samsung Devices</h5>
    <ul class="list-group mb-4">
        <?php
        $compatibleDevices = [
            'Samsung Galaxy S20',
            'Samsung Galaxy S20+',
            'Samsung Galaxy S20 Ultra',
            'Samsung Galaxy S21',
            'Samsung Galaxy S21+ 5G',
            'Samsung Galaxy S21+ Ultra 5G',
            'Samsung Galaxy S22',
            'Samsung Galaxy S22+',
            'Samsung Galaxy S22 Ultra',
            'Samsung Galaxy S23',
            'Samsung Galaxy S23+',
            'Samsung Galaxy S23 Ultra',
            'Samsung Galaxy S23 FE',
            'Samsung Galaxy S24',
            'Samsung Galaxy S24 FE',
            'Samsung Galaxy S24+',
            'Samsung Galaxy S24 Ultra',
            'Samsung Galaxy S25 Slim',
            'Samsung Galaxy S25 Ultra',
            'Samsung Galaxy Note 20',
            'Samsung Galaxy Note 20 5G',
            'Samsung Galaxy Note 20 Ultra',
            'Samsung Galaxy Note 20 Ultra 5G',
            'Samsung Galaxy Fold',
            'Samsung Galaxy Z Fold2 5G',
            'Samsung Galaxy Z Fold3',
            'Samsung Galaxy Z Fold3 5G',
            'Samsung Galaxy Z Fold4',
            'Samsung Galaxy Z Fold5',
            'Samsung Galaxy Z Fold6',
            'Samsung Galaxy Z Flip',
            'Samsung Galaxy Z Flip3 5G',
            'Samsung Galaxy Z Flip4',
            'Samsung Galaxy Z Flip5',
            'Samsung Galaxy Z Flip6'
        ];

        foreach ($compatibleDevices as $device): ?>
            <li class="list-group-item"><?= esc($device) ?></li>
        <?php endforeach; ?>
    </ul>

    <h5 class="fw-bold text-dark-green mt-4">Devices *Not* Compatible with eSIM</h5>
    <ul class="list-group mb-4">
        <?php
        $incompatibleDevices = [
            'Samsung Galaxy S20 FE 4G/5G (eSIM support varies by country)',
            'Samsung Galaxy S21 FE 4G/5G (eSIM support varies by country)',
            'Samsung S20/S21 (US versions)',
            'Galaxy Z Flip 5G (US versions)',
            'Samsung Note 20 Ultra (US and Hong Kong versions)',
            'Samsung Galaxy Z Fold 2 (US and Hong Kong versions)',
            'Samsung Galaxy S10',
            'Samsung Galaxy A Series'
        ];

        foreach ($incompatibleDevices as $device): ?>
            <li class="list-group-item text-muted"><?= esc($device) ?></li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Note:</strong> Regional support for eSIM varies. Always confirm with Samsung or your carrier.</p>

    <?= view('partials/recent_views') ?>

</div>