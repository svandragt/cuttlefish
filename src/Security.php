<?php

namespace Cuttlefish;

class Security
{


    public function isLoggedIn(): bool
    {
        return ! is_null(Http::session('admin'));
    }
}
