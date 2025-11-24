<?php
session_start();

// Pastikan Anda telah mengatur konfigurasi SMTP untuk mengirim email
require 'vendor/autoload.php'; // Jika menggunakan Composer untuk library email

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Cek apakah email terdaftar (ini contoh, Anda perlu menyesuaikan dengan database Anda)
    // Misalkan Anda memiliki array pengguna
    $users = [
        'user@example.com' => 'password123', // Contoh data pengguna
    ];

    if (array_key_exists($email, $users)) {
        // Buat token reset
        $token = bin2hex(random_bytes(50)); // Token acak
        $_SESSION['reset_token'] = $token;
        $_SESSION['reset_email'] = $email;

        // Kirim email dengan tautan reset
        $reset_link = "http://localhost/your-web-project/reset_password.php?token=" . $token;

        // Menggunakan PHPMailer atau library email lain untuk mengirim email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->setFrom('noreply@example.com', 'Your Website');
        $mail->addAddress($email);
        $mail->Subject = 'Reset Sandi Anda';
        $mail->Body    = "Klik tautan ini untuk mereset sandi Anda: $reset_link";

        if ($mail->send()) {
            echo "Tautan reset telah dikirim ke email Anda.";
        } else {
            echo "Email gagal dikirim.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
}
?>
<?php
session_start();

if (!isset($_GET['token']) || !isset($_SESSION['reset_token']) || $_GET['token'] !== $_SESSION['reset_token']) {
    echo "Token tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Sandi</title>
</head>
<body>
    <h2>Reset Sandi</h2>
    <form action="update_password.php" method="POST">
        <label for="new_password">Sandi Baru:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Perbarui Sandi</button>
    </form>
</body>
</html>
