<?php
session_start();

require_once "Auth.php";
require_once "Util.php";
require_once "AuthCookieSessionValidate.php";

$auth = new Auth();
$util = new Util();
// session_destroy();
if ($isLoggedIn) {
    $util->redirect("flag.php");
}

if(!empty($_POST["login"])) {
    $isAuthenticated = false;

    // get username and password from users's data
    $username = $_POST["member_name"];
    $password = $_POST["member_password"];

    // check if username is exists in database
    $user = $auth->getMemberByUsername($username);

    // if password from database is match with provided password, set $isAuthenticated
    if(password_verify($password, $user[0]["member_password"])) {
        $isAuthenticated = true;
    }

    if($isAuthenticated) {
        // create session
        $_SESSION["member_id"] = $user[0]["member_id"];

        if(!empty($_POST["remember"])) {
            $random_password = $util->getToken(16);
            $random_selector = $util->getToken(32);
            
            $set_user_cookie = new ManageCookie($username, $random_password, $random_selector);
            $set_user_cookie = urlencode(base64_encode(serialize($set_user_cookie)));
            
            // set cookie
            setcookie("remember_user", $set_user_cookie, $cookie_expiration_time);

            $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
            $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);

            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
            $userToken = $auth->getTokenByUsername($username, 0);

            // mark existing token as expired if exists to create new one            
            if (! empty($userToken[0]["id"])) {
                $auth->markAsExpired($userToken[0]["id"]);
            }

            // Insert new token
            $auth->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
            
        }else {
            $util->clearAuthCookie();
        }
        
        $util->redirect("flag.php");
    }else {
        $message = "Invalid Login";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>E-Flag</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">E-Flag🇲🇾</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<main class="login-form">
    <div class="container">
    <?php 
    if(isset($message)) { 
        ?>
        <div class="alert alert-danger" role="alert">
            <?= $message ?>
        </div>
        <?php
    } 
    ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Member ID</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="member_name" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="member_password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" name="login" value="Login">
                                    Login
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>

</body>
</html>