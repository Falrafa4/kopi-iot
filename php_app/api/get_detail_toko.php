<?php

include '../config/db.php';

$id_toko = isset($_GET['id']) ? $_GET['id'] : null;

$query = $conn->prepare("SELECT * FROM toko WHERE id_toko = ?");
$query->bind_param("i", $id_toko);
$query->execute();
$result = $query->get_result();
$toko_detail = $result->fetch_assoc();

if (!$toko_detail) {
    echo json_encode(["error" => "Data tidak ditemukan"]);
    exit;
}
echo json_encode($toko_detail);