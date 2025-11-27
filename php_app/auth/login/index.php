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
    <title>Kopi IoT - Login</title>
    <link rel="stylesheet" href="../../assets/style/global.css">
    <link rel="stylesheet" href="../../assets/style/login.css">

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
                <h1>Login KOPI IoT</h1>
                <hr class="line-break">

                <p>Silahkan masuk ke akun Anda.</p>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <p>Belum ada akun? <a href="../register/">Daftar di sini</a></p>

                <button type="submit" name="login">Login</button>
            </form>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include  '../../includes/footer.php'; ?>
    <!-- FOOTER END -->
</body>
</html>