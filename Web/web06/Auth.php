<?php
require_once "DBController.php";
require_once "ManageCookie.php";

class Auth {
    protected $getMemberByUsernameQuery;
    protected $getTokenByUsernameQuery;
    protected $markAsExpiredQuery;
    protected $insertTokenQuery;
    protected $db_handle;

    function __construct() {
        $this->getMemberByUsernameQuery = "SELECT * FROM members WHERE member_name = ?";
        $this->getTokenByUsernameQuery = "SELECT * FROM tbl_token_auth WHERE username = ? AND is_expired = ?";
        $this->markAsExpiredQuery = "UPDATE tbl_token_auth SET is_expired = ? WHERE id = ?";
        $this->insertTokenQuery = "INSERT INTO tbl_token_auth (username, password_hash, selector_hash, expiry_date) values (?, ?, ?, ?)";
        $this->db_handle = new DBController();
    }

    function getMemberByUsername($username) {
        $result = $this->db_handle->runQuery($this->getMemberByUsernameQuery, 's', array($username));
        return $result;
    }

    function getTokenByUsername($username, $expired) {
        $result = $this->db_handle->runQuery($this->getTokenByUsernameQuery, 'si', array($username, $expired));
            return $result;
    }

    function markAsExpired($tokenId) {
        $expired = 1;
        $result = $this->db_handle->update($this->markAsExpiredQuery, 'ii', array($expired, $tokenId));
        return $result;
    }

    function insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date) {
        $result = $this->db_handle->insert($this->insertTokenQuery, 'ssss', array($username, $random_password_hash, $random_selector_hash, $expiry_date));
        return $result;
    }
}