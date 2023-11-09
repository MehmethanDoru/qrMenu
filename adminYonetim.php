<?php
session_start();
require "db.php";
$sql = "SELECT * FROM `kategori` ";
$result = mysqli_query($conn, $sql);

$categories = array();
if (mysqli_num_rows($result) > 0) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Redirect to admin-giris.php if not logged in
if (!isset($_SESSION["admin_username"])) {
    header("Location: admin-giris.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukkan adi</title>
    <link rel="stylesheet" href="css/adminYonetim.css">
</head>

<body>

    <div class="navbar">
        <a href="#" class="logo">
            <img src="logo.svg" alt="Dükkan Logo">
        </a>
        <div class="center-text">Yönetim Paneli</div>
        <a href="logout.php" class="right-button">Çıkış Yap</a>
    </div>
    <div class="grid-container">
        <a href="yonetim/yonetim_stoksuz.php " id="stoksuz">
            <div class="grid-item-stoksuz">
                Stokta Olmayanlar
            </div>
        </a>

        <?php foreach ($categories as $category) {
            // reverse turkish to english
            $englishCategory = str_replace(
                array('ç', 'ğ', 'ı', 'i', 'ö', 'ş', 'ü', ' ', 'Ç', 'Ğ', 'I', 'İ', 'Ö', 'Ş', 'Ü'),
                array('c', 'g', 'i', 'i', 'o', 's', 'u', '', 'c', 'g', 'i', 'i', 'o', 's', 'u'),
                strtolower($category['kategori'])
            ); ?>

            <a href="yonetim/yonetim_<?php echo $englishCategory ?>.php " id="<?php echo $category['kategori'] ?>">
                <div class="grid-item">
                    <?php echo $category['kategori'] ?>
                </div>
            </a>
        <?php } ?>
    </div>
    <?php ?>
</body>

</html>