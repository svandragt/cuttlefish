<?php

namespace src;

class Http
{
    public static function post(string $key): ?string
    {
        return (isset($_POST[$key])) ? htmlspecialchars($_POST[$key]) : null;
    }

    public static function session(string $key): ?string
    {
        return (isset($_SESSION[ $key ])) ? htmlspecialchars($_SESSION[ $key ]) : null;
    }

    public static function setSession(array $values): void
    {
        foreach ($values as $key => $value) {
            $_SESSION[ $key ] = $value;
        }
    }
}
