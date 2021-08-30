<?php

namespace app\App\core;

class Session
{
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key): bool
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
}