<?php
require_once '../../../config/db.php';
require_once '../../../functions/pesanan.php';
if (isset($_POST['aksi'])) {
    // UPDATE DATA
    if ($_POST['aksi'] === 'edit') {
        $id = $_POST['id_pesanan'];
        $status = $_POST['status'];
        // var_dump($_POST);
        // die();
    
        if ($result = updateStatusPesanan($id, $status)) {
            $_SESSION['message'] = 'Data status pesanan berhasil diperbarui.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error updating status pesanan: ' . $stmt->error;
            header('Location: ./kelola.php');
        }
    
        $stmt->close();
        $conn->close();
    }
}