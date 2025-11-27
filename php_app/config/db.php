<?php
if (PHP_SESSION_ACTIVE !== session_status()) {
    session_start();
}

$host = 'localhost';
$db   = 'kopi_iot';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}