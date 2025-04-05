<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitcoin Checkout</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="card-title text-center mb-2">Bitcoin Checkout</h2>
            <div class="img-wrapper text-center"><img src="<?= $qrImageUrl ?>" alt="Bitcoin QR Code" class="img-fluid"></div>
            <p class="text-center mb-4">Please send <strong><?= $btcAmount ?></strong> BTC to:<br><code><?= $btcAddress ?></code></p>
            <p class="text-muted">After sending, enter your transaction hash below to verify:</p>
            <form id="txForm">
                <input type="hidden" name="action" value="checkTransaction">
                <div class="mb-3">
                    <input type="text" name="hashName" id="hashName" class="form-control" placeholder="Transaction hash id" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit Transaction</button>
            </form>
            <div id="result"></div>
        </div>
    </div>
</div>
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/js/main.js"></script>
</body>
</html>
