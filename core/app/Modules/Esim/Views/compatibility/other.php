<style>
    body {
        background-color: #f7fdf9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .containerOther {
        max-width: 900px;
        margin: auto;
    }

    .section-title {
        color: #1b5e20;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .last-updated {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 25px;
    }

    .important-note {
        background-color: #e8f5e9;
        border-left: 4px solid #2e7d32;
        padding: 15px 20px;
        border-radius: 8px;
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .device-section {
        margin-bottom: 40px;
    }

    .device-section h5 {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .list-group {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        padding: 20px;
        max-height: 550px;
        overflow-y: auto;
    }

    .list-group-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        color: #333;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .disclaimer {
        font-size: 0.9rem;
        color: #555;
        margin-top: 30px;
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px 20px;
        border-radius: 8px;
    }
</style>

<div class="containerOther my-5">
    <h2 class="section-title">Other eSIM-Compatible Devices</h2>
    <p class="last-updated">Last updated: 5 months ago</p>

    <div class="important-note">
        <strong>Important:</strong> Your phone or device must also be <strong>carrier unlocked</strong> to use an eSIM.
    </div>

    <div class="device-section">
        <h5>Compatible Devices</h5>
        <div class="list-group">
            <?php
            $devices = [
                'Motorola Razr 2019',
                'Motorola Razr 5G',
                'Motorola Razr 2022',
                'Motorola Razr 40',
                'Motorola Razr 40 Ultra',
                'Motorola Razr+',
                'Motorola Edge 2022',
                'Motorola Edge 2023',
                'Motorola Edge+ (2023)',
                'Motorola Edge 40',
                'Motorola Edge 40 Pro',
                'Motorola Edge 40 Neo',
                'Motorola Edge 50 Pro',
                'Motorola Edge 50 Ultra',
                'Motorola Edge 50 Fusion',
                'Motorola Moto G Power 5G (2024)',
                'Motorola G52J 5G',
                'Motorola G52J 5G Ⅱ',
                'Motorola G53J 5G',
                'Moto G54 5G',
                'Motorola G84',
                'Motorola G34',
                'Motorola Moto G53',
                'Motorola Moto G54',
                'Motorola Razr+ 2024',
                'Motorola Razr 2024',
                'Motorola Moto G Stylus 5G 2024',
                'Gemini PDA',
                'Rakuten Mini',
                'Rakuten Big-S',
                'Rakuten Big',
                'Rakuten Hand',
                'Rakuten Hand 5G',
                'Sony Xperia 10 III Lite',
                'Sony Xperia 10 IV',
                'Sony Xperia 1 IV',
                'Sony Xperia 10V',
                'Sony Xperia 5 IV',
                'Sony Xperia 1 V',
                'Sony Xperia Ace III',
                'Sony Xperia 5 V',
                'Sony Xperia 1 VI',
                'Honor Magic 4 Pro',
                'Honor Magic 5 Pro',
                'Honor Magic 6 Pro',
                'Honor 90',
                'Honor X8',
                'Honor 200',
                'Honor 200 Pro',
                'Honor Magic V2',
                'Honor Magic V3',
                'Fairphone 4',
                'Fairphone 5',
                'Sharp Aquos Sense4 lite',
                'Sharp Aquos Sense6s',
                'Sharp Aquos Sense7',
                'Sharp Aquos Sense7 plus',
                'Sharp Aquos Sense8',
                'Sharp Aquos Wish',
                'Sharp Aquos zero 6',
                'Sharp Aquos R7',
                'Sharp Aquos R8',
                'Sharp Aquos R8 Pro',
                'Sharp Simple Sumaho6',
                'Vivo X80 Pro',
                'Vivo X90 Pro',
                'Vivo X100 Pro',
                'Vivo V29',
                'Vivo V29 Lite',
                'Vivo V29 Lite 5G (Europe only)',
                'Vivo V40',
                'Vivo V40 lite',
                'Vivo V40 SE',
                'Xiaomi 12T Pro',
                'Xiaomi 13',
                'Xiaomi 13 Lite',
                'Xiaomi 13 Pro',
                'Xiaomi 14 Global Version',
                'DOOGEE V30',
                'Vito Y33S',
                'Nokia G60 5G',
                'Nokia XR21',
                'Nokia X30',
                'OnePlus Open',
                'OnePlus 11',
                'OnePlus 12',
                'OnePlus 13',
                'HAMMER Blade 3',
                'HAMMER Explorer PRO',
                'HAMMER Blade 5G',
                'OUKITEL WP30 Pro',
                'OUKITEL WP33 Pro',
                'Nuu X5',
                'ZTE Nubia Flip',
                'TLC 50 5G',
                'Asus ROG Phone 9',
                'Asus ROG Phone 9 Pro'
            ];

            foreach ($devices as $device): ?>
                <div class="list-group-item"><?= esc($device) ?></div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="disclaimer">
        <strong>Note:</strong> Many of these models may have regional variations. Always check the official device specifications or contact the manufacturer to confirm eSIM support for your exact model number.
    </div>

    <?= view('partials/recent_views') ?>

</div>