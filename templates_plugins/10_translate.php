<?php

function translate($params) {
    if (empty($params['lng']))
        $params['lng'] = 'DE';
    $lang = $params['lng'];
    $str = empty($params['str']) ? '' : $params['str'];
    $dir = __DIR__ . '/../templates_lang/';
    $found = false;
    $result = '';
    if ($str == '')
        return '';

    if (is_file($dir . $lang . '.php')) {
        include $dir . $lang . '.php';

        #var_dump($dir . $lang . '.php');
        #var_dump($lng);
        #var_dump(is_array($lng));
        #var_dump(isset($lng[md5($str)]));

        if (is_array($lng) && isset($lng[md5($str)])) {
            #var_dump($lng[md5($str)]);
            $result = $lng[md5($str)];
        } else {
            $result = $str;
            file_put_contents($dir . $lang . '.php', '$lng[\'' . md5($str) . '\'] = \'' . str_replace("'", "\\'", $str) . '\';' . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    return $result;
}
