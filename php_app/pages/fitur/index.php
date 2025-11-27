<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Landing Page</title>
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/landing.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <main>
        <section class="feature">
            <div class="feature-heading">
                <h2>Fitur Utama<br>KOPI IoT</h2>
                <hr>
            </div>
            <div class="features-container">
                <div class="feature-item">
                    <h3>Monitoring</h3>
                    <p>Pantau tingkat ampas kopi Anda melalui dashboard interaktif kami.</p>
                </div>
                <div class="feature-item">
                    <h3>Notifikasi Otomatis</h3>
                    <p>Dapatkan notifikasi otomatis saat tempat sampah ampas kopi Anda hampir penuh.</p>
                </div>
                <div class="feature-item">
                    <h3>Jemput Ampas</h3>
                    <p>Jemput ampas kopi Anda dengan mudah melalui layanan pengumpulan kami yang efisien.</p>
                </div>
            </div>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
    <!-- FOOTER END -->
</body>

</html>