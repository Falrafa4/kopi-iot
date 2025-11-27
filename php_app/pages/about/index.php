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
        <section class="about">
            <h2>About Kopi IoT</h2>
            <hr>
            <p>Kopi IoT adalah platform inovatif yang memanfaatkan teknologi Internet of Things untuk mengelola ampas kopi secara efisien. Sistem kami membantu penjual kopi memantau tingkat ampas mereka dan memberi notifikasi kepada pengemudi saat waktunya pengumpulan, memastikan lingkungan yang lebih bersih dan mendorong praktik berkelanjutan.</p>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
    <!-- FOOTER END -->
</body>

</html>