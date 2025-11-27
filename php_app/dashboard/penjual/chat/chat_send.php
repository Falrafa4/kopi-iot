<?php
// Mengirim pesan ke database.
include "../config/db.php";

$pengirim = $_POST["pengirim"];
$penerima = $_POST["penerima"];
$pesan = $_POST["pesan"];

$conn->query("INSERT INTO chat (id_pengirim, id_penerima, pesan) 
              VALUES ('$pengirim', '$penerima', '$pesan')");

echo "ok";
?>