<?php

namespace app\App\core;

class Application
{
    public static Application $app;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public View $view;
    public Session $session;
    public bool $isAdmin;

    public function __construct($rootDir)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->view = new View();
        $this->isAdmin = Application::$app->session->get('isAdmin');
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}