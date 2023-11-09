<?php
// category information
// 1->Kahve, 2->Çay, 3->Atıştırmalık, 4->Gözleme, 5->Soğuk İçecek, 6->Tatlı
require "db.php";
$sql = "SELECT * FROM `kategori` ";
$result = mysqli_query($conn, $sql);

$categories = array();
if (mysqli_num_rows($result) > 0) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Menü</title>
</head>

<body>
    <div id="preloader">
        <div id="loader">
            <div id="progress-bar"></div>
        </div>
    </div>
    <input type="checkbox" id="menu-toggle">

        <div class="container navbar">
            <div class="header">
                <label class="hamburger-menu" for="menu-toggle">
                    <span></span>
                </label>
                <a href="#" class="logo">
                    LOGO
                </a>

                <label for="menu-toggle" class="backdrop" id="backdrop"></label>
            </div>
        </div>

        <nav class="menu">
            <ul>
                <?php foreach ($categories as $category) { ?>
                    <li>
                        <a onclick="scrollToCategory('<?php echo $category['kategori']; ?>')">
                            <?php echo $category['kategori']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <div id="content-wrapper" style="display: none">

        <div style='margin-top:77px'></div>

        <?php foreach ($categories as $category) { ?>
            <div class="categoryy" id="<?php echo $category['kategori'] ?>">
                <?php echo $category['kategori']; ?>
            </div>
            <?php
            $sql = "SELECT * FROM `ürünler` WHERE kategori = '" . $category['kategori_id'] . "'";
            $result = mysqli_query($conn, $sql);

            $products = array();
            if (mysqli_num_rows($result) > 0) {
                $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
            foreach ($products as $product) { ?>
                <div class="content">
                    <div class="image">
                        <div style="position: relative;">
                            <?php if ($product['stok'] == 1) { ?>
                                <img src="images/<?php echo $product['urun_gorsel'] ?>"
                                    onclick="openOverlay('<?php echo $product['urun_gorsel']; ?>', '<?php echo $product['urun_adi']; ?>', '<?php echo $product['urun_aciklamasi']; ?>')">
                            <?php } ?>
                            <?php if ($product['stok'] == 0) { ?>
                                <img src="images/<?php echo $product['urun_gorsel'] ?>" style="opacity:0.3">
                                <img src="stock.png" alt="Stock Image"
                                    style="position: absolute; top: 3px; left: 2px; width: 100%; opacity:0.7">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="title ms-2">
                            <?php echo $product['urun_adi'] ?>
                        </div>
                        <div class="details ms-2">
                            <?php echo $product['urun_aciklamasi'] ?>
                        </div>
                    </div>
                    <div class="price">
                        <?php echo $product['urun_fiyat'] ?>₺
                    </div>
                </div>

            <?php } ?>

        <?php } ?>

        <div class="overlay" id="overlay" style="display: none">
            <div class="overlay-content">
                <span class="close-btn" onclick="closeOverlay()">&times;</span>
                <div id="overlay-image"></div>
                <div id="overlay-details">
                    <div id="overlay-product-name"></div>
                    <div id="overlay-product-description"></div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
        <script src="script.js"></script>
</body>

</html>