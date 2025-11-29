<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
include "../../../config/db.php";
require_once '../../../functions/pesanan.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'pembeli') {
    header('Location: ../../../auth/login/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Dashboard Admin</title>

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

    <style>
        .img-small {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <div class="content" id="content">
        <?php include '../../../includes/pembeli_aside.php'; ?>
        <main>
            <section>
                <!-- message -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert success">
                        <?= htmlspecialchars($_SESSION['message']) ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <!-- error -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert error">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <h1>Daftar Pesanan Anda</h1>
                <hr class="line-break">

                <?php
                    $pesanan = getAllPesananById($_SESSION['data']['id_user']);
                    foreach ($pesanan as $pesanan_item) :
                ?>
                    <!-- <div class="card-pesanan" data-id="<?= htmlspecialchars($pesanan_item['id_pesanan']) ?>">
                        <div class="image-container">
                            <img src="/assets/img/produk/<?= htmlspecialchars($pesanan_item['gambar']) ?>" alt="<?= htmlspecialchars($pesanan_item['nama_produk']) ?>">
                        </div>
                        <div class="card-content">
                            <h3><?= htmlspecialchars($pesanan_item['nama_produk']) ?></h3>
                            <p>Jumlah: <?= htmlspecialchars($pesanan_item['qty']) ?></p>
                            <p>Waktu Pesanan: <?= htmlspecialchars($pesanan_item['waktu_pesanan']) ?></p>
                            <p class="status-pesanan status-<?= htmlspecialchars($pesanan_item['status']) ?>">Status: <?= strtoupper(htmlspecialchars($pesanan_item['status'])) ?></p>
                        </div>
                    </div> -->
                <?php endforeach; ?>

                <table class="list-pesanan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu Pesanan</th>
                            <th>Produk</th>
                            <th>Gambar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $pesanan = getAllPesananById($_SESSION['data']['id_user']);
                        foreach ($pesanan as $pesanan_item) :
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= htmlspecialchars($pesanan_item['waktu_pesanan']) ?></td>
                                <td><?= htmlspecialchars($pesanan_item['nama_produk']) ?></td>
                                <td>
                                    <img src="/assets/img/produk/<?= htmlspecialchars($pesanan_item['gambar']) ?>" alt="<?= htmlspecialchars($pesanan_item['nama_produk']) ?>" class="img-small">
                                </td>
                                <td class="status-<?= htmlspecialchars($pesanan_item['status']) ?>" style="text-align: center;"><?= strtoupper(htmlspecialchars($pesanan_item['status'])) ?></td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <!-- KONTEN END -->

    <script src="../../../assets/js/script.js"></script>
</body>

</html>