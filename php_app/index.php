<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Landing Page</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- Style -->
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/landing.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include __DIR__ . '/includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <main>
        <section class="hero">
            <h1>Welcome to KOPI IoT</h1>
            <hr>
            <p>Komposter Pintar Untuk Rumah dan Warung Kopi</p>
            <div class="btn-group">
                <a href="/dashboard/penjual/" class="btn-primary">Kumpulkan Ampas</a>
                <a href="/dashboard/pembeli/" class="btn-primary">Beli Kompos</a>
            </div>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <!-- FOOTER END -->

    <script src="/assets/js/script.js"></script>
</body>

</html>