<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
require_once "../../../config/db.php";
require_once '../../../functions/users.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

$nama = '';
$username = '';
$password = '';
$role = '';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user = getUserById($user_id);

    if (!$user) {
        $_SESSION['error'] = "User tidak ditemukan.";
    } else {
        $nama = $user['nama'];
        $username = $user['username'];
        $password = $user['password'];
        $role = $user['role'];
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
                <h1><?= isset($_GET['id']) ? 'Edit' : 'Tambah' ?> Users</h1>
                <hr class="line-break">
                <form action="/dashboard/admin/manage_users/process.php" method="POST" class="form-kelola">
                    <?php if (isset($_GET['id'])): ?>
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($_GET['id']) ?>">
                    <?php endif; ?>
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" value="<?= $nama ?>" required>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?= $username ?>" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" <?= isset($_GET['id']) ? '' : 'required' ?>>

                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="driver" <?= $role === 'driver' ? 'selected' : '' ?>>Driver</option>
                        <option value="penjual" <?= $role === 'penjual' ? 'selected' : '' ?>>Penjual</option>
                        <option value="pembeli" <?= $role === 'pembeli' ? 'selected' : '' ?>>Pembeli</option>
                    </select>

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