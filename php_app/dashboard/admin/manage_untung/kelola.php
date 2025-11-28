<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
require_once "../../../config/db.php";
require_once '../../../functions/keuntungan.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

$keuntungan_key = '';
$keuntungan_value = '';
$unit = '';
$keterangan = '';

if (isset($_GET['id'])) {
    $id_keuntungan = $_GET['id'];
    $keuntungan = getKeuntunganById($id_keuntungan);

    if (!$keuntungan) {
        $_SESSION['error'] = "User tidak ditemukan.";
    } else {
        $keuntungan_key = $keuntungan['keuntungan_key'];
        $keuntungan_value = $keuntungan['keuntungan_value'];
        $unit = $keuntungan['satuan'];
        $keterangan = $keuntungan['keterangan'];
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
                <h1><?= isset($_GET['id']) ? 'Edit' : 'Tambah' ?> Keuntungan</h1>
                <hr class="line-break">
                <form action="/dashboard/admin/manage_untung/process.php" method="POST" class="form-kelola">
                    <?php if (isset($_GET['id'])): ?>
                        <input type="hidden" name="id_keuntungan" value="<?= htmlspecialchars($_GET['id']) ?>">
                    <?php endif; ?>
                    <label for="keuntungan_key">Nama Keuntungan:</label>
                    <input type="text" id="keuntungan_key" name="keuntungan_key" value="<?= $keuntungan_key ?>" required>

                    <label for="keuntungan_value">Nilai Keuntungan:</label>
                    <input type="text" id="keuntungan_value" name="keuntungan_value" value="<?= $keuntungan_value ?>" placeholder="Contoh (dengan koma): 7.5, 9.0" required>

                    <label for="unit">Satuan:</label>
                    <input type="text" id="unit" name="unit" value="<?= $unit ?>" placeholder="Contoh: mL, kg" required>

                    <label for="keterangan">Keterangan:</label>
                    <input type="text" id="keterangan" name="keterangan" value="<?= $keterangan ?>" placeholder="Opsional">

                    <div class="btn-group">
                        <a href="./">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                                <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z" />
                            </svg>
                            Kembali
                        </a>
                        <?php
                        if (isset($_GET['id'])) { ?>
                            <button type="submit" name="aksi" value="edit" class="btn-kelola">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan Perubahan
                            </button>
                        <?php } else { ?>
                            <button type="submit" name="aksi" value="add" class="btn-kelola">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Tambahkan
                            </button>
                        <?php } ?>
                    </div>
                </form>
            </section>
        </main>
    </div>
    <!-- KONTEN END -->

    <script src="../../../assets/js/script.js"></script>
</body>

</html>