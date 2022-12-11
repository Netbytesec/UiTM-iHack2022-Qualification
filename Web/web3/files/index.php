<?php
	if (!isset($_COOKIE["password"]))
		setcookie("password", "biskutsedap");
	
	if (!isset($_COOKIE["cookie"]))
		setcookie("cookie", "ZXlKcFpDSTZJaklpTENKMGVYQmxJam9pZFhObGNpSjk");
?>

<style>
h1 {
	font-family: 'Charm', cursive; margin-top: 20px; margin-left:40px; font-size: 50px
}

.wrong {
	color: #FF4242;
	text-shadow: 2px 2px #000000;
}

.right {
	color: #42FF42;
	text-shadow: 2px 2px #000000;
}
</style>

<head>
<link href="https://fonts.googleapis.com/css?family=Charm" rel="stylesheet">
</head>
<body>
<h1>The admin says he forgot his password. How are we going to retrieve the cookie?
</body>
<?php
    error_reporting(0);
	$pass = "yabedabedooo0000#@#@lesgo";
    $cookie_name = "cookie";
	
    if (isset($_COOKIE["cookie"])) {
        $val = json_decode(base64_decode(base64_decode($_COOKIE["cookie"])));
		
        if ($val->type == 'admin') {			
			echo "<h1 ";

			echo $_COOKIE["password"];
			if (strcmp($_COOKIE["password"], $pass) == 0) {
				echo " class='right'>";
				echo "Good job! Here's your flag:<br>ihack{2b8db212aed914f43859ccce1b92365a}";
			} else {
				echo " class='wrong'>";
				echo "You got the admin password wrong :c<br>";
			}
			
			echo "</h1";
		}
    }
?>
</h1>
