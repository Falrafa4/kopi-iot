<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getAllUsers() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM users");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getUserById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getPasswordById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT password FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ? $result['password'] : null;
}

function loginUser($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertUser($nama, $username, $password, $role) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $username, $password, $role);
    return $stmt->execute();
}

function updateUser($id, $nama, $username, $password, $role) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET nama = ?, username = ?, password = ?, role = ? WHERE id_user = ?");
    $stmt->bind_param("ssssi", $nama, $username, $password, $role, $id);
    return $stmt->execute();
}

function deleteUser($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}