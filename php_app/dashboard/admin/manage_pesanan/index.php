<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
include "../../../config/db.php";
require_once '../../../functions/pesanan.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

if (isset($_GET['delete'])) {
    $pesanan_id = $_GET['delete'];
    if (deletePesanan($pesanan_id)) {
        $_SESSION['message'] = "Pesanan berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus pesanan.";
    }
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    // ubah status pesanan menjadi selesai
    if (changeToSelesai($_GET['id'])) {
        $_SESSION['message'] = "Status pesanan berhasil diganti menjadi selesai.";
    } else {
        $_SESSION['error'] = "Gagal mengubah status pesanan menjadi selesai.";
    }
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
    <link rel="stylesheet" href="/assets/style/admin.css">

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
        <?php include '../../../includes/admin_aside.php'; ?>
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

                <h1>Daftar Pesanan Masuk</h1>
                <hr class="line-break">
                <table>
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pembeli</th>
                            <th>Produk</th>
                            <th>Gambar</th>
                            <th>Waktu Pesanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pesanan = getAllPesanan();
                        foreach ($pesanan as $pesanan_item) :
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($pesanan_item['id_pesanan']) ?></td>
                                <td><?= htmlspecialchars($pesanan_item['nama']) ?></td>
                                <td><?= htmlspecialchars($pesanan_item['nama_produk']) ?></td>
                                <td>
                                    <img src="/assets/img/produk/<?= htmlspecialchars($pesanan_item['gambar']) ?>" alt="<?= htmlspecialchars($pesanan_item['nama_produk']) ?>" class="img-small">
                                </td>
                                <td><?= htmlspecialchars($pesanan_item['waktu_pesanan']) ?></td>
                                <td class="status-<?= $pesanan_item['status'] == 'selesai' ? 'active' : 'pending' ?>" style="text-align: center;"><?= ucfirst(htmlspecialchars($pesanan_item['status'])) ?></td>
                                <td>
                                    <a href="kelola.php?id=<?= urlencode($pesanan_item['id_pesanan']) ?>" class="edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                        </svg>
                                    </a>
                                    <a href="index.php?id=<?= urlencode($pesanan_item['id_pesanan']) ?>" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan pesanan ini')">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                                            <path d="m424-318 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm280-590q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z" />
                                        </svg>
                                    </a>
                                </td>
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

    <!-- FOOTER -->
    <?php //include '../../../includes/footer.php'; 
    ?>
    <!-- FOOTER END -->

    <!-- <script src="../../../assets/js/script.js"></script> -->
</body>

</html>