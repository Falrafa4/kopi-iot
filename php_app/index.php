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
    <?php include __DIR__ . '/includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <main>
        <section class="hero">
            <h1>Welcome to KOPI IoT</h1>
            <hr>
            <p>Komposter Pintar Untuk Rumah dan Warung Kopi</p>
            <div class="btn-group">
                <a href="./dashboard/penjual/" class="btn-primary">Kumpulkan Ampas</a>
                <a href="./dashboard/pembeli/" class="btn-primary">Beli Kompos</a>
            </div>
        </section>

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

        <section class="about">
            <h2>About Kopi IoT</h2>
            <hr>
            <p>Kopi IoT adalah platform inovatif yang memanfaatkan teknologi Internet of Things untuk mengelola ampas kopi secara efisien. Sistem kami membantu penjual kopi memantau tingkat ampas mereka dan memberi notifikasi kepada pengemudi saat waktunya pengumpulan, memastikan lingkungan yang lebih bersih dan mendorong praktik berkelanjutan.</p>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <!-- FOOTER END -->
</body>
</html>