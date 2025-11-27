<?php

include '../config/db.php';

$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : '';

$query = "SELECT * FROM toko WHERE nama_toko LIKE '%$keyword%' OR alamat LIKE '%$keyword%'";
$result = $conn->query($query);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);