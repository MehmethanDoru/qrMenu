<?php 
session_start(); // Oturumu başlatın (her sayfanın başlangıcında yapılmalıdır)
session_destroy(); // Oturumu sonlandırın

// Kullanıcıyı giriş sayfasına yönlendirin
header("Location: ../admin-giris.php");
exit;

?>