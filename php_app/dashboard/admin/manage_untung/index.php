<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
include "../../../config/db.php";
require_once '../../../functions/keuntungan.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

if (isset($_GET['delete'])) {
    $keuntungan_id = $_GET['delete'];
    if (deleteKeuntungan($keuntungan_id)) {
        $_SESSION['message'] = "Keuntungan berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus keuntungan.";
    }
    header('Location: index.php');
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
    <link rel="stylesheet" href="/assets/style/admin.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
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

                <h1>Daftar Keuntungan</h1>
                <hr class="line-break">
                <a href="/dashboard/admin/manage_untung/kelola.php" class="btn-kelola mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                        <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                    </svg>
                    Tambah Keuntungan
                </a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Satuan</th>
                            <th>Waktu Update</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $conn->query("SELECT * FROM keuntungan");
                        while ($keuntungan = $query->fetch_assoc()) :

                            // --- LOGIKA FORMAT ANGKA (Mulai) ---
                            $nilai = $keuntungan['keuntungan_value'];
                            $tampilan_nilai = "";

                            // Cek apakah nilainya angka bulat (contoh: 1500.0000)
                            if (floor($nilai) == $nilai) {
                                // Format angka bulat: 0 desimal, pemisah ribuan titik
                                $tampilan_nilai = number_format($nilai, 0, ',', '.');
                            } else {
                                // Format angka desimal: max 4 desimal, pemisah desimal koma
                                $tampilan_nilai = number_format($nilai, 4, ',', '.');
                                // Hapus nol berlebih di belakang (contoh: 0,3000 jadi 0,3)
                                $tampilan_nilai = rtrim($tampilan_nilai, '0');
                                // Hapus koma jika ternyata setelah nol dihapus jadi kosong (jaga-jaga)
                                $tampilan_nilai = rtrim($tampilan_nilai, ',');
                            }
                            // --- LOGIKA FORMAT ANGKA (Selesai) ---
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($keuntungan['id_keuntungan']) ?></td>
                                <td><?= htmlspecialchars($keuntungan['keuntungan_key']) ?></td>
                                <td>Rp<?= $tampilan_nilai ?></td>
                                <td><?= htmlspecialchars($keuntungan['satuan']) ?></td>
                                <td><?= htmlspecialchars($keuntungan['waktu_update']) ?></td>
                                <td><?= empty($keuntungan['keterangan']) ? '-' : htmlspecialchars($keuntungan['keterangan']) ?></td>
                                <td>
                                    <a href="kelola.php?id=<?= urlencode($keuntungan['id_keuntungan']) ?>" class="edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                        </svg>
                                    </a>
                                    <a href="./index.php?delete=<?= urlencode($keuntungan['id_keuntungan']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus keuntungan ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                                            <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        endwhile;
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