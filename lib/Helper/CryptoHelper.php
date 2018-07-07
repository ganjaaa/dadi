<?php

namespace DND\Helper;

class CryptoHelper {

    public static function Crypt($password, $iteration=50, $salt='abcdefghijklmnopqrstuvwxyz'){
        for($i=0;$i<=$iteration;$i++){
            $password = hash('sha512', $password.$salt);
        }
        return $password;
    }

}
