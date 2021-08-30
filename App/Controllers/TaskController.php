<?php

namespace app\App\Controllers;

use app\App\core\Controller;
use app\App\core\Request;
use app\App\core\Response;
use app\App\Models\TaskModel;

class TaskController extends Controller
{
    // Переход на страницу создания задачи
    public function add(): string
    {
        return $this->render('add', [
        ]);
    }

    // Помечаем задачу как выполнена
    public function done(Request $request, Response $response)
    {
        $params = $request->getBody();
        $ID = null;
        $taskModel = new TaskModel();

        if (array_key_exists('ID', $params)) {
            $ID = intval($params['ID']);
            $taskModel->checkDone($ID);
        }

        $response->redirect('/?message=Задача отмечена выполненой!&messageType=success');
    }

    // Контроллер редактирования задачи
    public function edit(Request $request, Response $response)
    {
        if (LoginController::isAdmin()) { // Проверям вход админа
            $params = $request->getBody();
            $ID = null;
            $taskModel = new TaskModel();

            if (array_key_exists('ID', $params)) {
                $ID = intval($params['ID']);
            } else {
                $response->redirect('/');
            }

            $task = $taskModel->getTaskByID($ID);  // Получаем задачу по ее ID

            return $this->render('edit', [
                'task' => $task,
            ]);
        } else {
            $response->redirect('/?message=Для редактирования задач, необходимо войти!&messageType=danger');
        }
    }

    public function saveTask(Request $request, Response $response) {
        $task = new TaskModel();
        $task->loadData($request->getBody());
        $task->status = 0;
        $task->admin_revised = 0;
        if ($task->add()) {
            $response->redirect('/?message=Задача успешно добавлена!&messageType=success');
        }
    }

    public function saveEditedTask(Request $request, Response $response) {
        if (LoginController::isAdmin()) {
            $task = new TaskModel();
            $body = $request->getBody();

            if ($body['oldtext'] === $body['text']) {
                $response->redirect('/?message=Задача не изменена!&messageType=warning');
                return;
            }

            $task->loadData($body);
            $task->admin_revised = 1;
            if ($task->updateTask()) {
                $response->redirect('/?message=Задача успешно сохранена!&messageType=success');
            }
        } else {
            $response->redirect('/?message=Для редактирования задач, необходимо войти!&messageType=danger');
        }
    }
}