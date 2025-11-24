<?php
session_start();

// Cek apakah token valid
if (!isset($_SESSION['reset_token'])) {
    echo "Token tidak valid.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];

    // Di sini, Anda perlu memperbarui sandi di database pengguna
    // Misalkan Anda memiliki fungsi updatePassword($email, $new_password)
    $email = $_SESSION['reset_email'];
    
    // Contoh: updatePassword($email, password_hash($new_password, PASSWORD_DEFAULT));

    // Setelah memperbarui, hapus token dari session
    unset($_SESSION['reset_token']);
    unset($_SESSION['reset_email']);

    echo "Sandi Anda telah diperbarui. Silakan login.";
}
?>
