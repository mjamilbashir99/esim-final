<style>
    body {
        background-color: #f7fdf9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .containerOppo {
        max-width: 900px;
        margin: 50px auto;
        padding: 0 20px;
    }

    h2.text-dark-green {
        color: #1b5e20;
        font-size: 2rem;
        margin-bottom: 10px;
        border-bottom: 2px solid #a5d6a7;
        padding-bottom: 8px;
    }

    .text-muted {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 20px;
    }

    .important-note,
    .exception-note {
        background-color: #fff8e1;
        border-left: 5px solid #ffc107;
        padding: 15px 20px;
        border-radius: 6px;
        font-size: 0.95rem;
        margin-bottom: 25px;
    }

    .list-group {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        padding: 20px;
        list-style: none;
        margin-bottom: 30px;
    }

    .list-group-item {
        background-color: #f9fff9;
        padding: 12px 16px;
        border: 1px solid #e0f2f1;
        color: #1b5e20;
        font-weight: 600;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background-color 0.2s ease-in-out;
    }

    .list-group-item:hover {
        background-color: #c8e6c9;
    }

    h5 {
        color: #2e7d32;
        font-weight: 600;
        margin-top: 35px;
        margin-bottom: 15px;
    }

    .screenshot {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        margin: 20px 0 30px;
    }
</style>

<div class="containerOppo">
    <h2 class="text-dark-green fw-bold">Oppo eSIM Compatibility</h2>
    <p class="text-muted">Last updated: 5 months ago</p>

    <!-- Oppo Device Image -->
    <img src="https://www.oppo.com/content/dam/oppo/common/mkt/v2-2/reno-12-en/listpage/427-600-silver.png" alt="Oppo eSIM Compatible Devices" class="screenshot" />

    <div class="important-note">
        <strong>Important:</strong> Your device must be <strong>carrier-unlocked</strong> to use an eSIM.
    </div>

    <h5>Compatible Oppo Devices</h5>
    <ul class="list-group">
        <?php
        $compatibleDevices = [
            'Oppo Find N2 Flip',
            'Oppo Find X3 Pro',
            'Oppo Reno 5A',
            'Oppo Reno 6 Pro 5G',
            'Oppo A55s 5G',
            'Oppo Find X5',
            'Oppo Find X5 Pro'
        ];

        foreach ($compatibleDevices as $device): ?>
            <li class="list-group-item"><?= esc($device) ?></li>
        <?php endforeach; ?>
    </ul>

    <h5>Not Compatible</h5>
    <ul class="list-group">
        <li class="list-group-item text-muted">Oppo Find X5 Lite</li>
    </ul>

    <div class="exception-note">
        <p><strong>Note:</strong> eSIM support may vary by region or carrier.</p>
        <p>Before purchasing, confirm eSIM functionality with <strong>Oppo support</strong> or your <strong>carrier</strong>.</p>
    </div>

    <?= view('partials/recent_views') ?>

</div>