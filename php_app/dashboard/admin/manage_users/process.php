<?php
require_once '../../../config/db.php';
require_once '../../../functions/users.php';
if (isset($_POST['aksi'])) {
    // CREATE DATA
    if ($_POST['aksi'] === 'add') {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
    
        if (insertUser($nama, $username, $password, $role)) {
            $_SESSION['message'] = 'Data user berhasil ditambahkan.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error adding user: ' . $stmt->error;
            header('Location: ./kelola.php');
        }
    
        $stmt->close();
        $conn->close();
    }

    // UPDATE DATA
    if ($_POST['aksi'] === 'edit') {
        $old_password = getPasswordById($_POST['id_user']);
        $id = $_POST['id_user'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'] == '' ? $old_password : $_POST['password'];
        $role = $_POST['role'];
    
        if (updateUser($id, $nama, $username, $password, $role)) {
            $_SESSION['message'] = 'Data user berhasil diperbarui.';
            header('Location: ./index.php');
        } else {
            $_SESSION['error'] = 'Error updating user: ' . $stmt->error;
            header('Location: ./kelola.php');
        }
    
        $stmt->close();
        $conn->close();
    }
}