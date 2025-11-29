<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
require_once "../../../config/db.php";
require_once '../../../functions/pesanan.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
}

$id_pesanan = $_GET['id'];
$pesanan = getPesananById($id_pesanan);
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
            <section class="kelola user">
                <h1>Edit Status Pesanan</h1>
                <hr class="line-break">
                <form action="/dashboard/admin/manage_pesanan/process.php" method="POST" class="form-kelola">
                    <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($_GET['id']) ?>">

                    <label for="status">Pilih Status:</label>
                    <select name="status" id="status">
                        <option value="pending" <?= $pesanan['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="selesai" <?= $pesanan['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>

                    <div class="btn-group">
                        <a href="./">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                                <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z" />
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" name="aksi" value="edit" class="btn-kelola">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>
    <!-- KONTEN END -->

    <script src="../../../assets/js/script.js"></script>
</body>

</html>