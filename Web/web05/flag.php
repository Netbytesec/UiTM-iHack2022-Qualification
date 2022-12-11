<?php
session_start();
require_once "AuthCookieSessionValidate.php";
require_once "Util.php";

$util = new Util();

if(!$isLoggedIn) {
    $util->redirect("./");
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

    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="Favicon.png">

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

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">Logout <span class="sr-only">(current)</span></a>
            </li>
        </div>
    </div>
</nav>
<hr>
<div class="container">
    <div class="alert alert-success mt-5 shadow-sm" role="alert">
        <h4 class="alert-heading">Well done!</h4>
        <p>Aww yeah, you successfully read this important alert message. This means you are successfully bypass login using deserialize vulnerability.</p>
        <hr>
        <p class="mb-0">Here take this ʕっ•ᴥ•ʔっ <strong>ihack{flag}</strong>.</p>
    </div>
</div>

</body>
</html>