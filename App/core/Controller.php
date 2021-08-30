<?php

namespace app\App\core;

class Controller
{
    public function render($view, $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }
}