<?php
	if (!isset($_COOKIE["password"]))
		setcookie("password", "biskutsedap");
	
	if (!isset($_COOKIE["cookie"]))
		setcookie("cookie", "ZXlKcFpDSTZJaklpTENKMGVYQmxJam9pZFhObGNpSjk");
?>

<style>

.wrong {
	color: #FF4242;
}

.right {
	color: #42FF42;
}
</style>

<head>
<link href="https://fonts.googleapis.com/css?family=Charm" rel="stylesheet">
</head>
<body>
  <main id="main-holder">
    <h1 id="login-header">Only admin can login v2</h1>
    
    <form id="login-form">
      <input type="text" name="username" id="username-field" class="login-form-field" placeholder="Username">
      <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password">
      <input type="submit" value="Login" id="login-form-submit">
    </form>
  
  </main>
</body>

		<!-- if (strcmp($_COOKIE["password"], $pass) == 0) {
				echo " class='right'>";
				echo "Good job! Here's your flag:<br>ihack{}";
			} else {
				echo " class='wrong'>";
				echo "You got the admin password wrong :c<br>";
			}
			echo "</h1";
		} -->
 
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
