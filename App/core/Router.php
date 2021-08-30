<?php

namespace app\App\core;

use app\App\Controllers\HomeController;
use app\App\Controllers\LoginController;
use app\App\Controllers\TaskController;

class Router
{
    private Request $request;
    private Response $response;
    private array $routeMap = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->get('/', [HomeController::class, 'home']);
        $this->get('/^p([0-9]+$)', [HomeController::class, 'pages/$1']);
        $this->get('/add', [TaskController::class, 'add']);
        $this->get('/edit', [TaskController::class, 'edit']);
        $this->get('/done', [TaskController::class, 'done']);
        $this->post('/add', [TaskController::class, 'saveTask']);
        $this->post('/edit', [TaskController::class, 'saveEditedTask']);
        $this->post('/login', [LoginController::class, 'login']);
        $this->post('/logout', [LoginController::class, 'logout']);
    }

    public function get(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }

    public function post(string $url, $callback)
    {
        $this->routeMap['post'][$url] = $callback;
    }

    public function resolve()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();

        $callback = $this->routeMap[$method][$url] ?? false;
        if (!$callback) {
            return 'Page not found';
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params = []): array|bool|string
    {
        return Application::$app->view->renderView($view, $params);
    }
}