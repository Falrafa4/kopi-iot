<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getSensorById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM sensor WHERE id_sensor = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getSensorAll() {
    global $conn;
    $result = $conn->query("SELECT * FROM sensor");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function insertSensor($id_toko, $suhu = null, $kelembapan = null, $volume = null, $selesai = 0, $lat, $lng, $prediksi_selesai = null) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO sensor (id_toko, suhu, kelembapan, volume, selesai, lat, lng, prediksi_selesai) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("idddiddi", $id_toko, $suhu, $kelembapan, $volume, $selesai, $lat, $lng, $prediksi_selesai);
    return $stmt->execute();
}

function updateSensor($id_sensor, $suhu, $kelembapan, $volume, $selesai, $lat, $lng, $prediksi_selesai) {
    global $conn;
    $stmt = $conn->prepare("UPDATE sensor SET suhu = ?, kelembapan = ?, volume = ?, selesai = ?, lat = ?, lng = ?, prediksi_selesai = ? WHERE id_sensor = ?");
    $stmt->bind_param("dddiddii", $suhu, $kelembapan, $volume, $selesai, $lat, $lng, $prediksi_selesai, $id_sensor);
    return $stmt->execute();
}