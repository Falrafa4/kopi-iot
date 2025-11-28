<?php
require_once '../../../config/db.php';
require_once '../../../functions/keuntungan.php';
if (isset($_POST['aksi'])) {
    // CREATE DATA
    if ($_POST['aksi'] === 'add') {
        $keuntungan_key = $_POST['keuntungan_key'];
        $keuntungan_value = $_POST['keuntungan_value'];
        $unit = $_POST['unit'];
        $keterangan = $_POST['keterangan'];
    
        if (insertKeuntungan($keuntungan_key, $keuntungan_value, $unit, $keterangan)) {
            $_SESSION['message'] = 'Data keuntungan berhasil ditambahkan.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error adding keuntungan: ' . $stmt->error;
            header('Location: ./kelola.php');
        }
    
        $stmt->close();
        $conn->close();
    }

    // UPDATE DATA
    if ($_POST['aksi'] === 'edit') {
        $id = $_POST['id_keuntungan'];
        $keuntungan_key = $_POST['keuntungan_key'];
        $keuntungan_value = $_POST['keuntungan_value'];
        $unit = $_POST['unit'];
        $keterangan = $_POST['keterangan'];
    
        if (updateKeuntungan($id, $keuntungan_key, $keuntungan_value, $unit, $keterangan)) {
            $_SESSION['message'] = 'Data keuntungan berhasil diperbarui.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error updating keuntungan: ' . $stmt->error;
            header('Location: ./kelola.php');
        }
    
        $stmt->close();
        $conn->close();
    }
}