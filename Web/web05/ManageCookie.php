<?php
require_once "Auth.php";

class ManageCookie {
    public $member_login;
    public $random_password;
    public $random_selector;
    protected $auth;

    function __construct($member_login = "", $random_password = "", $random_selector = "") {
        if(empty($this->member_login)) {
            $this->member_login = $member_login;    
        }
        if(empty($this->random_password)) {
            $this->random_password = $random_password;
        }
        if(empty($this->random_selector)) {
            $this->random_selector = $random_selector;
        }
        
        $this->auth = new Auth();
    }

    function __toString() {
        return $this->member_login . ":" . $this->random_password . $this->random_selector;
    }

    function validateCookie() {
        $isPasswordVerified = false;
        $isSelectorVerified = false;
        $isExpiryDateVerified = false;

        // Get Current date, time
        $current_time = time();
        $current_date = date("Y-m-d H:i:s", $current_time);
        
        // Get token for username and that is not expired
        $userToken = $this->auth->getTokenByUsername($this->member_login, 0);
        // Validate random password cookie with database
        if(password_verify($this->random_password, $userToken[0]["password_hash"])) {
            $isPasswordVerified = true;
        }
        
        // Validate random selector cookie with database
        if(password_verify($this->random_selector, $userToken[0]["selector_hash"])) {
            $isSelectorVerified = true;
        }
        
        // check cookie expiration by date
        if($userToken[0]["expiry_date"] >= $current_date) {
            $isExpiryDateVerified = true;
        }
        // Redirect if all cookie based validation returns true
        // Else, mark the token as expired and clear cookies
        if (!empty($userToken[0]["id"]) && $isPasswordVerified && $isSelectorVerified && $isExpiryDateVerified) {
            return true;
        }else {
            return false;
        }
    }
}