<?php

$config = array();
require_once __DIR__ . '/vendor/autoload.php';

// a unique key that identifies this application - DO NOT LEAVE THIS EMPTY!
$config['app_key'] = '53c43a2798a7ee7e7c6730abc7fa30c4';
// a secret key to be used during encryption
$config['encryption_key'] = md5($config['app_key'] . $_SERVER['REMOTE_ADDR']);

function convertHTMLToPDF($rawdata) {
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($rawdata);
    $b64 = base64_encode($mpdf->OutputBinaryData());

    return $b64;
}

function add_http($url){
    // not a good way to filter http/s but as long as its work
	if(!preg_match('/\b(?:(?:https?|file):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $url)){
		$url = 'http://' . $url;
	}

	return $url;
}

function curl_url($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0");
    curl_setopt($curl, CURLOPT_URL, $url);

    $rawdata = curl_exec($curl);
    return $rawdata;
}

function app_url() {
    return (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}

function base64_url_encode($input){
    // = at the end is just padding to make the length of the str divisible by 4
    return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
}

function base64_url_decode($input){
	return base64_decode(str_pad(strtr($input, '-_', '+/'), strlen($input) % 4, '=', STR_PAD_RIGHT));
}

function rot_pass_str($str, $key, $decypt = false) {
    // if key short from actual data
    $key_length = strlen($key);
    $result = str_repeat(' ', strlen($str));

    for($i = 0; $i < strlen($str); $i++) {
        if($decypt) {
            $url_asc = ord($str[$i]) - ord($key[$i % $key_length]);
        }else {
            $url_asc = ord($str[$i]) + ord($key[$i % $key_length]);
        }

        $result[$i] = chr($url_asc);
    }

    return $result;
}

function url_encrypt($url) {
    // encrypt url
    global $config;
    $url = rot_pass_str($url, $config["encryption_key"]);

    return base64_url_encode($url);
}

function url_decrypt($url) {
    global $config;

    $url = base64_url_decode($url);
    $url = rot_pass_str($url, $config["encryption_key"], true);

    return $url;
}

function secure_url($url) {
    $url = htmlspecialchars_decode($url);
    return app_url() . '?q=' . url_encrypt($url);
    // var_dump($a);die();
}

if(isset($_POST['url'])) {
    $url = $_POST['url'];
    $url = add_http($url);

    header("HTTP/1.1 302 Found");
    header('Location: ' . secure_url($url));
    exit;
}elseif(isset($_GET['q'])) {
    $url = url_decrypt($_GET['q']);
    $rawdata = curl_url($url);
    $pdfCoverted = convertHTMLToPDF($rawdata);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        * {
        outline: none;
        }

        html,
        body {
        height: 100%;
        min-height: 100%;
        }

        body {
        margin: 0;
        background-color: #ffd8d8;
        font-family: Montserrat;
        color: #404040;
        }

        .tb {
        display: table;
        width: 100%;
        }

        .td {
        display: table-cell;
        vertical-align: middle;
        }

        input,
        button {
        color: #fff;
        padding: 0;
        margin: 0;
        border: 0;
        background-color: transparent;
        }

        #cover {
        position: absolute;
        top: 20%;
        left: 0;
        right: 0;
        width: 1000px;
        padding: 35px;
        margin: -83px auto 0 auto;
        background-color: #ff7575;
        border-radius: 20px;
        box-shadow: 0 10px 40px #ff7c7c, 0 0 0 20px #ffffffeb;
        transform: scale(0.6);
        }

        #cover-2 {
        position: absolute;
        top: 40%;
        /* margin-top: 100%; */
        left: 0;
        right: 0;
        width: 1000px;
        height: 60%;
        padding: 35px;
        margin: -83px auto 0 auto;
        background-color: #ff7575;
        border-radius: 20px;
        box-shadow: 0 10px 40px #ff7c7c, 0 0 0 20px #ffffffeb;
        /* transform: scale(0.6); */
        }

        form {
        height: 96px;
        }

        input[type="text"] {
        width: 100%;
        height: 96px;
        font-size: 60px;
        line-height: 1;
        }

        input[type="text"]::placeholder {
        color: #e16868;
        }

        #s-cover {
        width: 1px;
        padding-left: 35px;
        }

        button {
        position: relative;
        display: block;
        width: 84px;
        height: 96px;
        cursor: pointer;
        }

        #s-circle {
        position: relative;
        top: -8px;
        left: 0;
        width: 43px;
        height: 43px;
        margin-top: 0;
        border-width: 15px;
        border: 15px solid #fff;
        background-color: transparent;
        border-radius: 50%;
        transition: 0.5s ease all;
        }

        button span {
        position: absolute;
        top: 68px;
        left: 43px;
        display: block;
        width: 45px;
        height: 15px;
        background-color: transparent;
        border-radius: 10px;
        transform: rotateZ(52deg);
        transition: 0.5s ease all;
        }

        button span:before,
        button span:after {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 45px;
        height: 15px;
        background-color: #fff;
        border-radius: 10px;
        transform: rotateZ(0);
        transition: 0.5s ease all;
        }

        #s-cover:hover #s-circle {
        top: -1px;
        width: 67px;
        height: 15px;
        border-width: 0;
        background-color: #fff;
        border-radius: 20px;
        }

        #s-cover:hover span {
        top: 50%;
        left: 56px;
        width: 25px;
        margin-top: -9px;
        transform: rotateZ(0);
        }

        #s-cover:hover button span:before {
        bottom: 11px;
        transform: rotateZ(52deg);
        }

        #s-cover:hover button span:after {
        bottom: -11px;
        transform: rotateZ(-52deg);
        }
        #s-cover:hover button span:before,
        #s-cover:hover button span:after {
        right: -6px;
        width: 40px;
        background-color: #fff;
        }

        .my_title {
            text-align: center;
            margin-bottom: 0px;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
        h1 {
            font-size: 50px;
        }

        .container {
        text-align: center;
        /* padding-left: 30px;
        padding-right: 30px; */
        margin-right: 50px;
        }

        #cover-2 pre {
        display: inline-block;
        width: 30%;
        text-align: left;
        }
    </style>
</head>
<body>
    <div class="my_title">
        <h1>Convert HTML to PDF</h1>
    </div>
    <div id="cover">
        <form method="post" action="">
            <div class="tb">
            <div class="td"><input type="text" placeholder="http://" name="url" required></div>
            <div class="td" id="s-cover">
                <button type="submit">
                <div id="s-circle"></div>
                <span></span>
                </button>
            </div>
            </div>
        </form>
    </div>
    <div id="<?= isset($_GET['q']) ? "cover-2" : "" ?>">
        <pre>
        </pre>
        <?php
        if(!empty($rawdata)) {
            ?>
            <object data="data:application/pdf;base64,<?= $pdfCoverted; ?>" type="application/pdf" width="100%" height="90%">
                <iframe src="data:application/pdf;base64,<?= $pdfCoverted; ?>" width="100%" height="90%" style="border: none;">
                This browser does not support PDFs. Please download the PDF to view it:
                <a href="data:application/pdf;base64,<?= $pdfCoverted; ?>">Download PDF</a>
                </iframe>
            </object>
            <?php
        }elseif(isset($_GET['q'])) {
            ?>
            <div style="text-align: center;">
            <h2>No Result</h2>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
