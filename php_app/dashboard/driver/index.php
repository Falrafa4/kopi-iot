<!-- INI HALAMAN DASHBOARD DRIVER -->
<?php
include "../../config/db.php";

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'driver') {
    header('Location: ../../login/');
    exit();
}

// user sementara (prototype)
$id_user = $_SESSION['data']['id_user'];

$query = $conn->query("SELECT * FROM toko");
$toko_all = $query->fetch_all(MYSQLI_ASSOC);

$query_notif = $conn->query("SELECT toko.nama_toko, sensor.status, sensor.prediksi_selesai FROM sensor
JOIN toko ON sensor.id_toko = toko.id_toko");
$notifikasi = $query_notif->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Dashboard Driver</title>
    <link rel="stylesheet" href="../../assets/style/global.css">
    <link rel="stylesheet" href="../../assets/style/dashboard.css">

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
    <main>
        <section>
            <h1>Selamat Datang, Driver!</h1>
            <hr class="line-break">
        </section>

        <section class="sampah-notif" id="mapSampah">
            <h2 class="mb-1">Lokasi Tempat Sampah Ampas Kopi</h2>
            <div class="container-sampah-notif">
                <div class="notification">
                    <h2 class="mb-1">Notifikasi Terbaru</h2>
                    <p>Siap ambil ampas kopi?</p>
                    <ul>
                        <?php
                        if (empty($notifikasi)) {
                            echo "<li>Tidak ada notifikasi baru.</li>";
                        }
                        foreach ($notifikasi as $notif) {
                            if ($notif['status'] == 'Empty'):
                                $class = 'success';
                                $message = "Ampas kopi di <strong>" . htmlspecialchars($notif['nama_toko']) . "</strong> baru diganti. Tempat sampah kosong.";
                            elseif ($notif['status'] == 'Ready'):
                                $class = 'warning';
                                $message = "Ampas kopi di <strong>" . htmlspecialchars($notif['nama_toko']) . "</strong> sudah penuh. Segera diambil.";
                            else:
                                $class = 'danger';
                                $message = "Ampas kopi di <strong>" . htmlspecialchars($notif['nama_toko']) . "</strong> belum siap diambil. Prediksi penuh dalam waktu dekat: " . htmlspecialchars($notif['prediksi_selesai']) . ".";
                            endif;
                            echo "<li class='" . $class . "'>" . $message . "</li>";
                        }
                        ?>
                    </ul>
                </div>
                <div class="map-sampah">
                    <iframe
                        width="600"
                        height="450"
                        style="border:0;"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q=-7.4461,112.7183&z=15&output=embed">
                    </iframe>
                </div>
            </div>
        </section>

        <section>
            <h2 class="mb-1">Daftar Toko Penyedia Ampas Kopi</h2>
            <div class="container" id="containerToko">
                <?php foreach ($toko_all as $toko) : ?>
                    <div href="detail.php?id=<?= htmlspecialchars($toko['id_toko']) ?>" class="card-toko" data-id="<?= htmlspecialchars($toko['id_toko']) ?>">
                        <div class="image-container">
                            <img src="../../assets/img/<?= htmlspecialchars($toko['gambar_toko']) ?>" alt="Kafe 1">
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
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include '../../includes/footer.php'; ?>
    <!-- FOOTER END -->

    <!-- <script src="../../assets/js/script.js"></script> -->
    <script>
        const searchInput = document.getElementById("search");
        const container = document.querySelector(".container");

        searchInput.addEventListener("keyup", function() {
            const containerToko = document.getElementById("containerToko");
            // get lokasi container toko
            window.scrollTo(0, containerToko.offsetTop - 200);
            let keyword = this.value;

            fetch(`../../api/search_toko.php?keyword=${keyword}`)
                .then(res => res.json())
                .then(data => {
                    container.innerHTML = ""; // reset

                    if (data.length === 0) {
                        container.innerHTML = "<p>Toko tidak ditemukan</p>";
                        return;
                    }

                    data.forEach(toko => {
                        container.innerHTML += `
                            <div class="card-toko" data-id="${toko.id_toko}">
                                <div class="image-container">
                                    <img src="../../assets/img/${toko.gambar_toko}" alt="${toko.nama_toko}">
                                </div>
                                <div class="desc">
                                    <h3>${toko.nama_toko.toUpperCase()}</h3>
                                    <p>${toko.alamat}</p>
                                </div>
                            </div>
                        `;
                    });

                    // panggil ulang event click pada card
                    attachCardClick();
                });
        });

        function attachCardClick() {
            document.querySelectorAll('.card-toko').forEach(card => {
                card.addEventListener('click', () => {
                    const tokoId = card.getAttribute('data-id');

                    fetch(`../../api/get_detail_toko.php?id=${tokoId}`)
                        .then(response => response.json())
                        // ... kode sebelumnya ...
                        .then(data => {
                            const output = document.getElementById('keteranganToko');

                            // Hapus style inline manual, gunakan class CSS
                            output.removeAttribute('style');

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
                                        <img src="../../assets/img/${data.gambar_toko}" alt="${data.nama_toko}">
                                        <h2>${data.nama_toko}</h2>
                                        <p>${data.deskripsi_toko}</p>
                                        <a href="detail.php?id=${tokoId}" class="see-more">Lihat Selengkapnya</a>
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

        // panggil sekali saat halaman pertama load
        attachCardClick();
    </script>
</body>

</html>