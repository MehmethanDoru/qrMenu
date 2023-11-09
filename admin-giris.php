<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Girişi</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Panel Girişi</h2>
        <form action="loginControl.php" method="POST">
            <div class="input-group">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Şifre:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Giriş Yap</button> <br>
            <div style="margin-top:10px"><a href="sifreunuttum.php">Şifremi Unuttum</a></div>
        </form>
    </div>
</body>
</html>
