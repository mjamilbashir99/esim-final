<div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 600px; margin: 40px auto; background-color: #f9f9f9;">
    <div class="card-body text-center">
        <h2 class="mb-4 text-success">🎉 Thank You! Your eSIM is Ready</h2>

        <div class="text-start">
            <p><strong>📄 ICCID:</strong> <span class="text-dark"><?= esc($iccid) ?></span></p>
            <p><strong>🔐 Matching ID:</strong> <span class="text-dark"><?= esc($matchingId) ?></span></p>
            <p><strong>🌐 SMDP+ Address:</strong> <span class="text-dark"><?= esc($smdpAddress) ?></span></p>
            <p><strong>🧾 Order ID:</strong> <span class="text-dark"><?= esc($orderId) ?></span></p>
        </div>

        <hr>

        <p class="mt-3 mb-0 text-muted">📲 Use this information to manually add the eSIM to your device.</p>
    </div>
</div>
