<?php

class Util {
    // create random integer
    public function cryptoRandSecure($min, $max) {
        $range = $max - $min;
        if ($range < 1) {
            return $min; // not so random...
        }
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function getToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet) - 1;

        for($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
        }

        return $token;
    }

    public function redirect($url) {
        // to prevent from Execution After Redirect vulnerability 
            // header("Location: " . $url);
        echo "<script> location.replace('".$url."'); </script>";
        exit;
    }

    public function clearAuthCookie() {
        if (isset($_COOKIE["remember_user"])) {
            unset($_COOKIE['remember_user']);
            setcookie("remember_user", "", time()-3600); // empty value and old timestamp
        }
    }
}
?>