<?php
session_start();
if (isset($_SESSION['data'])) {
    header('Location: ../../dashboard/' . $_SESSION['data']['role'] . '/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Register</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- Style -->
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/login.css">

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
    <main class="login-page">
        <section class="login-form">
            <form action="../process.php" method="POST">
                <h1>Register KOPI IoT</h1>
                <hr class="line-break">

                <p>Silahkan buat akun Anda.</p>

                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" required>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="role">Daftar Sebagai</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Pilih role Anda</option>
                    <option value="penjual">Pemilik Toko</option>
                    <option value="pembeli">Pembeli</option>
                </select>

                <p>Sudah punya akun? <a href="../login/">Masuk di sini</a></p>

                <button type="submit" name="register">Register</button>
            </form>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include  '../../includes/footer.php'; ?>
    <!-- FOOTER END -->
</body>

</html>