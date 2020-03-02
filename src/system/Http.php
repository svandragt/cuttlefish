<?php

namespace Cuttlefish;

use Configuration;

class Http
{
    public static function get($key)
    {

        return ( isset($_GET[ $key ]) ) ? htmlspecialchars($_GET[ $key ]) : null;
    }

    public static function post($key)
    {

        return ( isset($_POST[ $key ]) ) ? htmlspecialchars($_POST[ $key ]) : null;
    }

    public static function session($key)
    {

        return ( isset($_SESSION[ $key ]) ) ? htmlspecialchars($_SESSION[ $key ]) : null;
    }

    protected static function attachPlaintext($contents)
    {
        $filename = sprintf("cbn_%s.%s", date("Y-m-d_H-i-s", time()), Configuration::CONTENT_EXT);
        header("Content-Type: text/plain");
        header("Content-disposition: attachment; filename=$filename");
        print $contents;
        exit();
    }

    public static function setSession($values)
    {
        foreach ($values as $key => $value) {
            $_SESSION[ $key ] = $value;
        }
    }
}
