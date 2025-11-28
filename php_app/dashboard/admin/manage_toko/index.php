<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
include "../../../config/db.php";
require_once '../../../functions/toko.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

// Fetch semua toko
$query = $conn->query("SELECT * FROM toko JOIN users ON toko.id_penjual = users.id_user");
$toko_all = $query->fetch_all(MYSQLI_ASSOC);

// if (isset($_GET['delete'])) {
//     $user_id = $_GET['delete'];
//     if (deleteToko($user_id)) {
//         $_SESSION['message'] = "User berhasil dihapus.";
//     } else {
//         $_SESSION['error'] = "Gagal menghapus user.";
//     }
//     header('Location: index.php');
//     exit();
// }
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
        .pemilik {
            display: flex !important;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #555;
            margin-top: 1rem;
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

                <h1>Daftar Toko</h1>
                <hr class="line-break">
                <!-- <a href="/dashboard/admin/manage_toko/kelola.php" class="btn-kelola mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                    Tambah Toko
                </a> -->


                <div class="container" id="containerToko">
                    <?php foreach ($toko_all as $toko) : ?>
                        <div href="detail.php?id=<?= htmlspecialchars($toko['id_toko']) ?>" class="card-toko" data-id="<?= htmlspecialchars($toko['id_toko']) ?>">
                            <div class="image-container">
                                <img src="../../../assets/img/toko/<?= htmlspecialchars($toko['gambar_toko']) ?>" alt="Kafe 1">
                            </div>
                            <div class="desc">
                                <h3><?= strtoupper($toko['nama_toko']) ?></h3>
                                <p><?= htmlspecialchars($toko['alamat']) ?></p>
                                <p class="pemilik">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#684503">
                                        <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q14-36 44-58t68-22q38 0 68 22t44 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm280-670q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-246q54-53 125.5-83.5T480-360q83 0 154.5 30.5T760-246v-514H200v514Zm280-194q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41ZM280-200h400v-10q-42-35-93-52.5T480-280q-56 0-107 17.5T280-210v10Zm200-320q-25 0-42.5-17.5T420-580q0-25 17.5-42.5T480-640q25 0 42.5 17.5T540-580q0 25-17.5 42.5T480-520Zm0 17Z" />
                                    </svg>
                                    <?= htmlspecialchars($toko['nama']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="keteranganToko">
                </div>
            </section>
        </main>
    </div>
    <!-- KONTEN END -->

    <script src="../../../assets/js/script.js"></script>
    <script>
        function attachCardClick() {
            document.querySelectorAll('.card-toko').forEach(card => {
                card.addEventListener('click', () => {
                    const tokoId = card.getAttribute('data-id');

                    fetch(`../../../api/get_detail_toko.php?id=${tokoId}`)
                        .then(response => response.json())
                        // ... kode sebelumnya ...
                        .then(data => {
                            const output = document.getElementById('keteranganToko');

                            // Hapus style inline manual, gunakan class CSS
                            output.removeAttribute('style');

                            const className = data.status_toko === 'Aktif' ? 'status-active' : 'status-not-active';

                            // Isi konten
                            output.innerHTML = `
                                <h1 class='mb-2'>Detail Toko</h1>
                                <div class="container-detail-toko">
                                    <iframe
                                        id="mapFrame"
                                        style="border:0; width: 50%;"
                                        loading="lazy"
                                        allowfullscreen
                                        src="https://www.google.com/maps?q=${data.lat},${data.lng}&z=15&output=embed">
                                    </iframe>
                                    <div class="desc-toko">
                                        <img src="../../../assets/img/toko/${data.gambar_toko}" alt="${data.nama_toko}">
                                        <h2>${data.nama_toko}</h2>
                                        <p>${data.deskripsi_toko}</p>
                                        <p class="badge-status ${className}">Toko ${data.status_toko}</p>
                                    </div>
                                </div>
                            `;

                            // Tambahkan class active untuk memicu animasi CSS
                            // Kita pakai timeout sedikit agar transisi terbaca browser
                            setTimeout(() => {
                                output.classList.add('active');
                            }, 100);

                            output.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        });
                    // ... kode setelahnya ...

                });
            });
        }

        attachCardClick();
    </script>
</body>

</html>