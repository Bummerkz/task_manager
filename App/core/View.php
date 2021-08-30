<?php

namespace app\App\core;

class View
{
    public function renderView($view, array $params): array|bool|string
    {
        $viewContent = $this->renderViewOnly($view, $params);
        ob_start();
        include_once Application::$ROOT_DIR."/App/Views/layouts/main.php";
        $layoutContent = ob_get_clean();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderViewOnly($view, array $params): bool|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/App/Views/$view.php";
        return ob_get_clean();
    }
}