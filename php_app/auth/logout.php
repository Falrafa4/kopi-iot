<?php
session_start();
session_destroy();

// header('Location: ./login/');
// exit();
?>
<script>
    alert('Anda berhasil logout.');
    window.location.href = './login/';
</script>