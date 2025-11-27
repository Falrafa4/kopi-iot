<?php
// cek session start
if (PHP_SESSION_ACTIVE !== session_status()) {
    session_start();
}

if (isset($_SESSION['data']) && ($_SESSION['data']['role'] != 'penjual')) {
    header('Location: ../../dashboard/' . $_SESSION['data']['role'] . '/');
    exit();
}

if (!isset($_SESSION['data'])) {
    header('Location: ../../auth/login/');
    exit();
}

require_once '../../functions/toko.php';
if (isset($_SESSION['data']) && hasTokoByIdUser($_SESSION['data']['id_user'])) {
    header('Location: ../../dashboard/' . $_SESSION['data']['role'] . '/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Buat Toko</title>
    <link rel="stylesheet" href="../../assets/style/global.css">
    <link rel="stylesheet" href="../../assets/style/login.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Leaflet stable -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Leaflet GeoSearch stable (2.9.0) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.8.0/dist/geosearch.css" />
    <script src="https://unpkg.com/leaflet-geosearch@3.8.0/dist/geosearch.umd.js"></script>

    <style>
        /* Pastikan container search bar tidak terpengaruh style global */
        .leaflet-control-geosearch *,
        .leaflet-control-geosearch *:before,
        .leaflet-control-geosearch *:after {
            box-sizing: border-box;
        }

        .leaflet-geosearch-bar {
            z-index: 1000;
        }

        /* Perbaikan Input Field */
        .leaflet-control-geosearch form input.glass {
            color: black !important;
            background: none !important;
            padding: 0 8px !important;
            height: auto !important;
            border: none !important;
            margin: 0 !important;
            width: 100% !important;
        }

        /* Memastikan form search bar memiliki background putih yang rapi */
        .leaflet-control-geosearch.bar form {
            background-color: white !important;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            padding: 0 5px;
            display: flex;
            align-items: center;
        }

        /* Memperbaiki posisi tombol reset (X) */
        .leaflet-control-geosearch button.reset {
            background-color: transparent !important;
            color: black !important;
            border: none !important;
            padding: 0 5px !important;
            cursor: pointer;
            font-size: 16px;
            line-height: normal;
            width: fit-content;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <main class="login-page">
        <section class="login-form">
            <form action="../process.php" method="POST" enctype="multipart/form-data">
                <h1>Daftarkan Toko di KOPI IoT</h1>
                <hr class="line-break">

                <p>Silahkan daftarkan toko Anda.</p>

                <label for="nama_toko">Nama Toko</label>
                <input type="text" id="nama_toko" name="nama_toko" required>

                <label for="deskripsi_toko">Deskripsi Toko</label>
                <input type="text" id="deskripsi_toko" name="deskripsi_toko" required>

                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" required>

                <label for="gambar_toko">Gambar Toko</label>
                <input type="file" id="gambar_toko" name="gambar_toko" accept="image/*" required>

                <h2>Maps Toko</h2>
                <div id="map"></div>

                <label for="lat">Latitude</label>
                <input type="text" id="lat" name="lat" readonly required>

                <label for="lng">Longitude</label>
                <input type="text" id="lng" name="lng" readonly required>

                <!-- <p>Sudah punya akun? <a href="../login/">Masuk di sini</a></p> -->

                <button type="submit" name="buat_toko">Buat Toko</button>
            </form>
        </section>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include  '../../includes/footer.php'; ?>
    <!-- FOOTER END -->

    <script>
        // Inisialisasi Map
        var map = L.map('map').setView([-7.446, 112.718], 13);

        // Tile OSM gratis
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        // --- BAGIAN GEOSEARCH DIPERBARUI ---
        const provider = new GeoSearch.OpenStreetMapProvider();

        const searchControl = new GeoSearch.SearchControl({
            provider: provider,
            style: 'bar',
            searchLabel: 'Cari alamat...',
        });

        map.addControl(searchControl);
        // -----------------------------------
        // Hapus class 'glass' yang konflik dengan CSS global Anda
        const searchInput = document.querySelector('.leaflet-control-geosearch form input');
        if (searchInput) {
            searchInput.classList.remove('glass');
        }

        // Event saat hasil search dipilih
        map.on('geosearch/showlocation', (e) => {
            // e.location.y = lat, e.location.x = lng
            setMarker(e.location.y, e.location.x);
        });

        // Klik map -> ambil koordinat manual
        map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });

        // Fungsi menempatkan marker + isi input
        function setMarker(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        }
    </script>
</body>

</html>