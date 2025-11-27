<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
include "../../../config/db.php";
require_once '../../../functions/toko.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

// Fetch semua toko
$query = $conn->query("SELECT * FROM toko");
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
    <link rel="stylesheet" href="../../../assets/style/global.css">
    <link rel="stylesheet" href="../../../assets/style/admin.css">

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