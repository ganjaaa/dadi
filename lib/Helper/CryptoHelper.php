<?php

namespace DND\Helper;

class CryptoHelper {

    public static function Crypt($password, $iteration = 50, $salt = 'abcdefghijklmnopqrstuvwxyz') {
        for ($i = 0; $i <= $iteration; $i++) {
            $password = hash('sha512', $password . $salt);
        }
        return $password;
    }

    public static function getRandomString($length, $keyspace = '23456789abcdefghjkmnpqrstuvwxyz') {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    public static function getSecureString($lenght) {
        $bytes = openssl_random_pseudo_bytes($lenght, $cstrong);
        return bin2hex($bytes);
    }

}
