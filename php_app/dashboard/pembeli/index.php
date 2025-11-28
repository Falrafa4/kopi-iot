<!-- INI HALAMAN DASHBOARD USER -->
<?php
include "../../config/db.php";

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'pembeli') {
    header('Location: ../../auth/login/');
    exit();
}

// user sementara (prototype)
$id_user = $_SESSION['data']['id_user'];

$query = $conn->query("SELECT * FROM toko");
$toko_all = $query->fetch_all(MYSQLI_ASSOC);

$query_notif = $conn->query("SELECT toko.nama_toko, sensor.status FROM sensor
JOIN toko ON sensor.id_toko = toko.id_toko
WHERE sensor.status = 'Ready'");
$notifikasi = $query_notif->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Dashboard Pembeli</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- Style -->
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/pembeli.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <main>
        <section>
            <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['data']['nama']) ?>!</h1>
            <hr class="line-break">
        </section>

        <section>
            <h2 class="mb-1">Daftar Toko Penyedia Ampas Kopi</h2>
            <div class="container" id="containerToko">
                <?php foreach ($toko_all as $toko) : ?>
                    <div href="detail.php?id=<?= htmlspecialchars($toko['id_toko']) ?>" class="card-toko" data-id="<?= htmlspecialchars($toko['id_toko']) ?>">
                        <div class="image-container">
                            <img src="../../assets/img/<?= htmlspecialchars($toko['gambar_toko']) ?>" alt="Kafe 1">
                        </div>
                        <div class="desc">
                            <h3><?= strtoupper($toko['nama_toko']) ?></h3>
                            <p><?= htmlspecialchars($toko['alamat']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include '../../includes/footer.php'; ?>
    <!-- FOOTER END -->

    <!-- <script src="../../assets/js/script.js"></script> -->
</body>

</html>