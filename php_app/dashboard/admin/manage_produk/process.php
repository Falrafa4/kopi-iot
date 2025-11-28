<?php
require_once '../../../config/db.php';
require_once '../../../functions/produk.php';
if (isset($_POST['aksi'])) {
    // CREATE DATA
    if ($_POST['aksi'] === 'add') {
        $nama_produk = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $gambar_produk = $_FILES['gambar']['name'];

        // Upload gambar
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/produk/";
        $gambar_produk = time() . '_' . basename($gambar_produk);
        $target_file = $target_dir . $gambar_produk;
        // var_dump($target_file);
        // var_dump($_FILES['gambar']['tmp_name']);
        // die();
        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Gagal mengupload gambar
            $gambar_produk = '';
        }

        if (insertProduk($nama_produk, $harga, $stok, $gambar_produk)) {
            $_SESSION['message'] = 'Data produk berhasil ditambahkan.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error adding produk: ' . $stmt->error;
            header('Location: ./kelola.php');
        }

        $stmt->close();
        $conn->close();
    }

    // UPDATE DATA
    if ($_POST['aksi'] === 'edit') {
        $id = $_POST['id_produk'];
        $nama_produk = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $gambar_produk = $_FILES['gambar']['name'];

        if (empty($gambar_produk) || is_null($gambar_produk)) {
            // Jika tidak ada gambar baru yang diunggah, gunakan gambar lama
            $old_produk = getProdukById($id);
            $gambar_produk = $old_produk['gambar'];
        } else {
            // Upload gambar baru
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/produk/";
            $gambar_produk = time() . '_' . basename($gambar_produk);
            $target_file = $target_dir . $gambar_produk;
            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                // Gagal mengupload gambar
                $gambar_produk = '';
            }
        }

        if (updateProduk($id, $nama_produk, $harga, $stok, $gambar_produk)) {
            $_SESSION['message'] = 'Data produk berhasil diperbarui.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error updating produk: ' . $stmt->error;
            header('Location: ./kelola.php');
        }

        $stmt->close();
        $conn->close();
    }
}
