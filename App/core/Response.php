<?php

namespace app\App\core;

class Response
{
    public function redirect($url)
    {
        header("Location: $url");
    }
}