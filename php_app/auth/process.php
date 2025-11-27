<?php
require_once '../config/db.php';
require_once '../functions/users.php';
require_once '../functions/toko.php';
require_once '../functions/sensor.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // $query = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    // $data = $query->fetch_assoc();

    if ($data = loginUser($username, $password)) {
        // User found, set session
        $_SESSION['data'] = $data;

        if ($data['role'] == 'driver') {
            echo "
            <script>
                alert('Login Berhasil! Selamat datang di KOPI IoT.');
                window.location.href = '../dashboard/driver/';
            </script>
            ";
        } elseif ($data['role'] == 'penjual') {
            echo "
            <script>
                alert('Login Berhasil! Selamat datang di KOPI IoT.');
                window.location.href = '../dashboard/penjual/';
            </script>
            ";
        } elseif ($data['role'] == 'pembeli') {
            echo "
            <script>
                alert('Login Berhasil! Selamat datang di KOPI IoT.');
                window.location.href = '../dashboard/pembeli/';
            </script>
            ";
        } else {
            // Admin role
            echo "
            <script>
                alert('Login Berhasil! Selamat datang di KOPI IoT.');
                window.location.href = '../dashboard/admin/';
            </script>
            ";
        }
    } else {
        // Authentication failed
        header('Location: ./index.php?error=invalid_credentials');
        exit();
    }
}

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (insertUser($nama, $username, $password, $role)) {
        // langsung login
        $_SESSION['data'] = [
            'id_user' => $conn->insert_id,
            'nama' => $nama,
            'username' => $username,
            'role' => $role
        ];

        if ($role == 'penjual') {
            echo "
            <script>
                alert('Registrasi Berhasil! Silahkan daftarkan toko Anda.');
                window.location.href = '../auth/register/toko.php';
            </script>
            ";
            exit();
        }

        echo "
        <script>
            alert('Registrasi Berhasil! Selamat datang di KOPI IoT.');
            window.location.href = '../dashboard/" . $role . "/';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Registrasi Gagal! Silahkan coba lagi.');
            window.location.href = './';
        </script>
        ";
    }
}

if (isset($_POST['buat_toko'])) {
    $id_penjual = $_SESSION['data']['id_user'];
    $nama_toko = $_POST['nama_toko'];
    $deskripsi_toko = $_POST['deskripsi_toko'];
    $gambar_toko = $_FILES['gambar_toko']['name'];
    $alamat = $_POST['alamat'];
    $latitude = $_POST['lat'];
    $longitude = $_POST['lng'];

    // Upload gambar toko
    $target_dir = "../assets/img/toko/";
    $gambar_toko = time() . '_' . basename($gambar_toko);
    $target_file = $target_dir . $gambar_toko;
    if (!move_uploaded_file($_FILES['gambar_toko']['tmp_name'], $target_file)) {
        // Gagal mengupload gambar
        $gambar_toko = '';
    }

    if (insertToko($nama_toko, $deskripsi_toko, $alamat, $gambar_toko, $latitude, $longitude, $id_penjual)) {
        $id_toko = $conn->insert_id; // Ambil ID toko yang baru dibuat
        echo "
        <script>
            alert('Toko berhasil dibuat!');
            window.location.href = '../dashboard/penjual/';
        </script>
        ";

        if (insertSensor($id_toko, null, null, null, 0, $latitude, $longitude, null)) {
            // Sensor berhasil ditambahkan
            echo "
            <script>
                alert('Data Toko dan Sensor berhasil dibuat. Selamat datang di KOPI IoT!');
                window.location.href = '../dashboard/penjual/';
            </script>
            ";
        } else {
            // Gagal menambahkan sensor
            echo "
            <script>
                alert('Toko berhasil dibuat, tetapi gagal menambahkan sensor. Silahkan coba lagi.');
                window.location.href = '../dashboard/penjual/';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Pembuatan toko gagal! Silahkan coba lagi.');
            window.location.href = './toko.php';
        </script>
        ";
    }
}
