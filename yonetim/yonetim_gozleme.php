<?php
session_start();
require "../db.php";

// Redirect to admin-giris.php if not logged in
if (!isset($_SESSION["admin_username"])) {
    header("Location: ../admin-giris.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="yonetim.css">
    <title>Gözleme Yönetim Paneli</title>
</head>

<body>
    <input type="checkbox" id="menu-toggle">

    <div class="container">
        <div class="header">
            <label class="hamburger-menu" for="menu-toggle">
                <span></span>
            </label>
            <a href="../adminYonetim.php" class="logo">
                LOGO
            </a>
            <label for="menu-toggle" class="backdrop"></label>
            <a href="logout.php" class="right-button">Çıkış Yap</a>
        </div>
    </div>
    <?php
    $sql = "SELECT * FROM `kategori` ";
    $result = mysqli_query($conn, $sql);

    $categories = array();
    if (mysqli_num_rows($result) > 0) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    ?>

    <nav class="menu">
        <ul>
            <li>
                <a href="../adminYonetim.php">Anasayfa</a>
            </li>
            <li>
                <a href="yonetim_stoksuz.php">Stokta Olmayanlar</a>
            </li>
            <?php foreach ($categories as $category) {
                // reverse turkish to english
                $englishCategory = str_replace(
                    array('ç', 'ğ', 'ı', 'i', 'ö', 'ş', 'ü', ' ', 'Ç', 'Ğ', 'I', 'İ', 'Ö', 'Ş', 'Ü'),
                    array('c', 'g', 'i', 'i', 'o', 's', 'u', '', 'c', 'g', 'i', 'i', 'o', 's', 'u'),
                    strtolower($category['kategori'])
                ); ?>
                <li>
                    <a href="yonetim_<?php echo $englishCategory ?>.php"><?php echo $category['kategori'] ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <table style='margin-top: 17px'>
        <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Ürün Açıklaması</th>
                <th>Fiyatı</th>
                <th>Stok Durumu</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `ürünler` WHERE kategori = 4";
            $result = mysqli_query($conn, $sql);

            $products = array();
            if (mysqli_num_rows($result) > 0) {
                $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
            foreach ($products as $dough) { ?>
                <script>
                    function duzenle_<?php echo $dough['urun_id']; ?>() {
                        document.getElementById('urunAdi<?php echo $dough['urun_id']; ?>').disabled = false;
                        document.getElementById('urunAciklamasi<?php echo $dough['urun_id']; ?>').disabled = false;
                        document.getElementById('fiyati<?php echo $dough['urun_id']; ?>').disabled = false;
                        document.getElementById('stokDurumu<?php echo $dough['urun_id']; ?>').disabled = false;
                        document.getElementById('onayla-button<?php echo $dough['urun_id']; ?>').disabled = false;
                    }


                    function onayla_<?php echo $dough['urun_id']; ?>() {
                        var urunId = <?php echo $dough['urun_id']; ?>;
                        var urunAdi = document.getElementById('urunAdi<?php echo $dough['urun_id']; ?>').value;
                        var urunAciklamasi = document.getElementById('urunAciklamasi<?php echo $dough['urun_id']; ?>').value;
                        var fiyati = document.getElementById('fiyati<?php echo $dough['urun_id']; ?>').value;
                        var stokDurumu = document.getElementById('stokDurumu<?php echo $dough['urun_id']; ?>').value;

                        console.log(urunAdi, urunAciklamasi, fiyati, stokDurumu);
                        document.getElementById('onayla-button<?php echo $dough['urun_id']; ?>').disabled = true;
                        document.getElementById('urunAdi<?php echo $dough['urun_id']; ?>').disabled = true;
                        document.getElementById('urunAciklamasi<?php echo $dough['urun_id']; ?>').disabled = true;
                        document.getElementById('fiyati<?php echo $dough['urun_id']; ?>').disabled = true;
                        document.getElementById('stokDurumu<?php echo $dough['urun_id']; ?>').disabled = true;
                        document.getElementById('onayla-button<?php echo $dough['urun_id']; ?>').disabled = true;

                        // AJAX isteği ile PHP'ye gönder
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "update_product.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    console.log("Veri başarıyla güncellendi.");
                                } else {
                                    console.error("Hata oluştu: " + xhr.status);
                                }
                            }
                        };

                        var data = "urunId=" + encodeURIComponent(urunId) +
                            "&urunAdi=" + encodeURIComponent(urunAdi) +
                            "&urunAciklamasi=" + encodeURIComponent(urunAciklamasi) +
                            "&fiyati=" + encodeURIComponent(fiyati) +
                            "&stokDurumu=" + encodeURIComponent(stokDurumu);

                        xhr.send(data);
                    }
                </script>

            <?php }
            foreach ($products as $dough) { ?>
                <tr>
                    <td><input type="text" id="urunAdi<?php echo $dough['urun_id']; ?>" name="urunAdi"
                            value="<?php echo $dough['urun_adi']; ?>" disabled></td>
                    <td><input type="text" id="urunAciklamasi<?php echo $dough['urun_id']; ?>" name="urunAciklamasi"
                            value="<?php echo $dough['urun_aciklamasi']; ?>" disabled>
                    </td>
                    <td><input type="text" id="fiyati<?php echo $dough['urun_id']; ?>" name="fiyati"
                            value="<?php echo $dough['urun_fiyat']; ?>₺" disabled></td>
                    <td>
                        <select id="stokDurumu<?php echo $dough['urun_id']; ?>" name="stokDurumu" disabled>
                            <option name='stokVar' value="Stokta Var" <?php if ($dough['stok'] == 1)
                                echo 'selected'; ?>>Stokta Var</option>
                            <option name='stokYok' value="Stokta Yok" <?php if ($dough['stok'] == 0)
                                echo 'selected'; ?>>Stokta Yok</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="duzenle_<?php echo $dough['urun_id']; ?>()" class="duzenle-button">Düzenle</button>
                        <button onclick="onayla_<?php echo $dough['urun_id']; ?>()"
                            id="onayla-button<?php echo $dough['urun_id']; ?>" disabled>Onayla</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <script src="yonetim.js"></script>
</body>

</html>