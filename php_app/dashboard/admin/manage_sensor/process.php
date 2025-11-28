<?php
require_once '../../../config/db.php';
require_once '../../../functions/sensor.php';
require_once '../../../functions/toko.php';

if (isset($_POST['aksi'])) {
    // CREATE DATA
    if ($_POST['aksi'] === 'add') {
        $nama_sensor = $_POST['nama_sensor'];
        $id_toko = $_POST['id_toko'];
        $suhu = null;
        $kelembapan = null;
        $volume = null;
        $selesai = 0;
        $prediksi_selesai = null;
        $location = getLocationTokoByIdUser($id_toko);
        $lat = $location['lat'];
        $lng = $location['lng'];
    
        if (insertSensor($id_toko, $nama_sensor, $suhu, $kelembapan, $volume, $selesai, $lat, $lng, $prediksi_selesai)) {
            $_SESSION['message'] = 'Data sensor berhasil ditambahkan.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error adding sensor: ' . $stmt->error;
            header('Location: ./kelola.php');
        }
    
        $stmt->close();
        $conn->close();
    }

    // UPDATE DATA
    if ($_POST['aksi'] === 'edit') {
        $id = $_POST['id_sensor'];
        $nama_sensor = $_POST['nama_sensor'];
        $id_toko = $_POST['id_toko'];
    
        if (updateNameSensor($id, $nama_sensor, $id_toko)) {
            $_SESSION['message'] = 'Data sensor berhasil diperbarui.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error updating sensor: ' . $stmt->error;
            header('Location: ./kelola.php');
        }
    
        $stmt->close();
        $conn->close();
    }
}