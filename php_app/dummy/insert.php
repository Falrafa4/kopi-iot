<?php
require "../config/db.php";

$suhu = $_POST['suhu'];
$kelembapan = $_POST['kelembapan'];
$volume = $_POST['volume'];
$prediksi_selesai = $_POST['prediksi_selesai'];
$status = $_POST['status'];
$id_sensor = $_POST['id_sensor'];

$sql = "UPDATE sensor SET 
        suhu = '$suhu',
        kelembapan = '$kelembapan',
        volume = '$volume',
        prediksi_selesai = '$prediksi_selesai'
        WHERE id_sensor = '$id_sensor'";
$conn->query($sql);

if ($conn->affected_rows > 0) {
    echo "OK";
} else {
    echo "Error: " . $conn->error;
}