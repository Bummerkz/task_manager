<?php

namespace app\App\Controllers;

use app\App\core\Application;
use app\App\core\Controller;
use app\App\core\Request;
use app\App\core\Response;

class LoginController extends Controller
{
    // Проверка на наличие текущей сессии админа
    public static function isAdmin(): bool
    {
        return Application::$app->session->get('isAdmin');
    }

    // Авторизация не прошла? Показываем ошибку.
    public static function isBadAuth(): bool
    {
        $badAuth = Application::$app->session->get('badAuth');
        Application::$app->session->remove('badAuth');
        return $badAuth;
    }

    // Функция авторизации
    public function login(Request $request, Response $response)
    {
        $authData = $request->getBody(); // Получаем логин и пароль
        $login = null;
        $password = null;

        // Проверяем есть ли в body логин и пароль
        if (array_key_exists('login', $authData)) {
            $login = $authData['login'];
        }
        if (array_key_exists('password', $authData)) {
            $password = $authData['password'];
        }

        if ($login === 'admin' && $password === '123') {
            Application::$app->session->set('isAdmin', 'true'); // Пока в сессии висит ключ isAdmin - мы в админке
            $response->redirect('/?message=Вы вошли!&messageType=success');
        } else {
            $response->redirect('/?message=Проверьте данные для входа!&messageType=danger');
        }
    }

    // Функция выхода из админки
    public function logout(Request $request, Response $response)
    {
        Application::$app->session->remove('isAdmin');
        $response->redirect('/?message=Вы вышли!&messageType=warning');
    }
}