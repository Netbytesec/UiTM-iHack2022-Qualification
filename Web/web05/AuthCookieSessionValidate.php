<?php 
require_once "Auth.php";
require_once "Util.php";

$auth = new Auth();
$util = new Util();

// Get Current date, time
$current_time = time();
$current_date = date("Y-m-d H:i:s", $current_time);

// Set Cookie expiration for 1 month
$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month

$isLoggedIn = false;
// Check if loggedin session and redirect if session exists
if (!empty($_SESSION["member_id"])) {
    $isLoggedIn = true;
}
// Check if loggedin session exists
else if (!empty($_COOKIE["remember_user"])) {
    // unserialize user cookie
    $user_data = unserialize(base64_decode(urldecode($_COOKIE["remember_user"])));
    
    if(!empty($user_data->member_login) && !empty($user_data->random_password) && !empty($user_data->random_selector)) {
        // Initiate auth token verification diirective to false
        $isPasswordVerified = false;
        $isSelectorVerified = false;
        $isExpiryDateVerified = false;
        
        // Get token for username
        if($user_data->validateCookie()) {
            $isLoggedIn = true;
        }else {
            if(!empty($userToken[0]["id"])) {
                $auth->markAsExpired($userToken[0]["id"]);
            }
            // clear cookies
            $util->clearAuthCookie();
        }
    }
}
?>