<?php

namespace VanDragt\Carbon;

class Security
{

    function login_redirect()
    {
        if (!$this->is_loggedin()) {
            $url = new Url();
            header('Location: ' . $url->index('/admin')->abs()->url);
        };
    }

    function is_loggedin()
    {
        return !is_null(Http::session('admin'));
    }

    function login()
    {
        Log::info(sprintf("Login attempt from %s", $_SERVER['REMOTE_ADDR']));

        $output = "";

        if (is_null(\Configuration::ADMIN_PASSWORD)) {
            $output .= "Please set an admin password under Configuration::ADMIN_PASSWORD.<br>";
        } else {
            $password = HTTP::post('password');
            if (is_null($password)) {
                $output .= "<form method='post'><input type='password' name='password'><input type='submit'></form>";
            } elseif ($password == \Configuration::ADMIN_PASSWORD) {
                Http::set_session(array(
                    'admin' => TRUE,
                ));
                $output .= "logged in.<br>";
                Log::info("Login attempt successful");
                $url = new Url();
                header('Location: ' . $url->index('/admin')->abs()->url);
            } else {
                Log::warn("Login attempt unsuccessful.");
            }
        }

        return $output;
    }

    function logout()
    {
        session_destroy();

        return "logged out.<br>";
    }
}