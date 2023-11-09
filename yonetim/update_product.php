<?php
session_start();

require "../db.php";
// Redirect to admin-giris.php if not logged in
if (!isset($_SESSION["admin_username"])) {
    header("Location: ../admin-giris.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // JavaScript'ten gelen verileri al
    $urunId = $_POST['urunId'];
    $urunAdi = $_POST["urunAdi"];
    $urunAciklamasi = $_POST["urunAciklamasi"];
    $fiyati = $_POST["fiyati"];
    $stokDurumu = ($_POST["stokDurumu"] === "Stokta Var") ? 1 : 0;


    $sql = "UPDATE ürünler SET urun_adi='$urunAdi', urun_aciklamasi='$urunAciklamasi', urun_fiyat='$fiyati', stok='$stokDurumu' WHERE urun_id = $urunId";

    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        echo "Ürün başarıyla güncellendi.";
    } else {
        echo "Ürün güncellenirken hata oluştu: " . mysqli_error($conn);
    }

    file_put_contents('sql_log.txt', date('Y-m-d H:i:s') . ' - SQL Sorgusu: ' . $sql . "\n", FILE_APPEND);

}
?>

