<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body class="bg-auth">
    <main>
        <div class="flex align-items-center" style="height: 100vh;">
            <div class="flex-row justify-content-center">
                <div class="fb-50">
                    <div class="card">
                        <form action="" method="post" id="loginForm">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-custom" value="<?= (isset($_POST['username'])) ? $_POST['username'] : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-custom" value="<?= (isset($_POST['password'])) ? $_POST['password'] : ''; ?>">
                            </div>
                            <img src="captcha.php" alt="CAPTCHA IMAGE">
                            <div class="form-group" style="margin-top: 5px;">
                                <label for="captcha">Masukan Kode</label>
                                <input type="captcha" name="captcha" id="captcha" class="form-custom" value="<?= (isset($_POST['captcha'])) ? $_POST['captcha'] : ''; ?>">
                            </div>
                            <input type="submit" name="submit" value="Login" class="btn btn-success w-100">
                        </form>
                        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="assets/js/main.js"></script>
</body>

</html>