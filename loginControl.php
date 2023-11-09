<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @media screen (max-width: 380px) {
            .warning {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

</body>

</html>
<?php
require "db.php";
$login_successful = false;

session_start();

$sql = "SELECT * FROM `admin` ";
$result = mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $admins = array();
    if (mysqli_num_rows($result) > 0) {
        $admins = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($admins as $admin) {
            if ($username == $admin["username"]) {
                if ($password == $admin['password']) {
                    $login_successful = true;
                    $_SESSION["admin_username"] = $username; // Kullanıcı adını oturumda sakla
                    break; // Eğer giriş başarılıysa, döngüyü sonlandır 
                } else {
                    $redirectUrl = "admin-giris.php";
                    $waitTime = 3;
                    echo "<!DOCTYPE html>
              <html>
              <head>
                  <meta http-equiv='refresh' content='$waitTime;url=$redirectUrl'>
              </head>
              <body>
              <div class='warning' style='font-size: 20px; margin-top: 18px'>Şifre yanlış. Lütfen tekrar deneyin.</div>
                  <br> <div style='font-size: 16px; margin-top: 8px'>Yönlendiriliyorsunuz, lütfen bekleyin...</div>
              </body>
              </html>";
                    return;
                }
            }
        }
        if ($login_successful == true) {
            header("Location: adminYonetim.php");
            exit;

        } else {
            $redirectUrl = "admin-giris.php";
            $waitTime = 3;
            echo "<!DOCTYPE html>
          <html>
          <head>
              <meta http-equiv='refresh' content='$waitTime;url=$redirectUrl'>
          </head>
          <body>
          <div class='warning' style='font-size: 20px; margin-top: 18px'>Kullanıcı adı veya şifre yanlış. Lütfen tekrar deneyin.</div>
              <br> <div style='font-size: 16px; margin-top: 8px'>Yönlendiriliyorsunuz, lütfen bekleyin...</div>
          </body>
          </html>";
        }
    }
}
?>