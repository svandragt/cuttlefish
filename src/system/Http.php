<?php

namespace Cuttlefish;

use Configuration;

class Http
{


    public static function post(string $key): ?string
    {

        return ( isset($_POST[ $key ]) ) ? htmlspecialchars($_POST[ $key ]) : null;
    }

    public static function session(string $key): ?string
    {

        return ( isset($_SESSION[ $key ]) ) ? htmlspecialchars($_SESSION[ $key ]) : null;
    }

    /**
     * @param true[] $values
     *
     * @return void
     */
    public static function setSession(array $values): void
    {
        foreach ($values as $key => $value) {
            $_SESSION[ $key ] = $value;
        }
    }
}
