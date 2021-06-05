<?php

namespace Cuttlefish;

class Security
{
    public function maybeLoginRedirect(): void
    {
        if (! $this->isLoggedIn()) {
            $Url = new Url('/admin');
            header('Location: ' . $Url->url_absolute);
        };
    }

    public function isLoggedIn(): bool
    {
        return ! is_null(Http::session('admin'));
    }

    public function login(): string
    {
        Log::info(sprintf("Login attempt from %s", $_SERVER['REMOTE_ADDR']));

        $output = "";
        if (isset($_ENV['CUTTLEFISH_ADMIN_PASSWORD'])) {
            $admin_password = $_ENV['CUTTLEFISH_ADMIN_PASSWORD'];
            $password = Http::post('password');
            if ($password === $admin_password) {
                Http::setSession(array(
                    'admin' => true,
                ));
                $output .= "logged in.<br>";
                Log::info("Login attempt successful");
                $Url = new Url('/admin');
                header('Location: ' . $Url->url_absolute);
            } else {
                if (false === empty($password)) {
                    Log::warn("Login attempt unsuccessful.");
                    $output .= "Nope.<br>";
                }
                $output .= "<form method='post'><input type='password' name='password'><input type='submit'></form>";
            }
        } else {
            $output .= <<< MSG
            <p>To login, create an environment variable called
            <code>CUTTLEFISH_ADMIN_PASSWORD</code> with a password as the value in a file named <code>.env</code>
             in the root of the project.
             
             <ul>
                <li><a href="https://github.com/vlucas/phpdotenv#usage">More usage information</a></li>
             </ul>
MSG;
        }

        return $output;
    }

    public function logout(): string
    {
        session_destroy();

        return "logged out.<br>";
    }
}
