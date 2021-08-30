<?php

namespace app\App\Controllers;

use app\App\core\Controller;
use app\App\core\Request;
use app\App\Models\TaskModel;

class HomeController extends Controller
{
    public array $taskList;

    public string $sortColumn;
    public string $sortOrder;

    public string $upOrDown;
    public string $ascOrDesc;

    public string $message;
    public bool $gotMessage;
    public string $messageType;

    // Контроллер главной страницы
    public function home(Request $request): string
    {
        $taskModel = new TaskModel(); // модель задачи
        $params = $request->getBody(); // параметры сортировки и номера страницы
        $page = 1;
        $this->message = '';
        $this->messageType = '';
        $this->gotMessage = false;

        // Проверяем на наличие ключей
        if (array_key_exists('p', $params)) {
            $page = intval($params['p']);
        }
        if (array_key_exists('sortColumn', $params)) {
            $this->sortColumn = $params['sortColumn'];
        } else {
            $this->sortColumn = 'username';
        }
        if (array_key_exists('sortOrder', $params)) {
            $this->sortOrder = $params['sortOrder'];
        } else {
            $this->sortOrder = 'ASC';
        }
        if (array_key_exists('message', $params)) {
            $this->message = $params['message'];
            $this->gotMessage = true;
            if (array_key_exists('messageType', $params)) {
                $this->messageType = $params['messageType'];
            } else {
                $this->messageType = 'danger';
            }
        }

        // Переменные для создания заголовков таблицы
        $this->upOrDown = str_replace(array('ASC','DESC'), array('up','down'), $this->sortOrder);
        $this->ascOrDesc = $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
        $addClass = ' class="highlight"';

        $total = $taskModel->getTotalAmountOfTasks(); // Получаем общее количество задач

        // Получаем необходимый список задач, с учетом сортировки и пагинации
        $this->taskList = $taskModel->getTasksPerPage($page, $this->sortColumn, $this->sortOrder);

        // Отрисовываем страница и передаем переменные
        return $this->render('home', [
            'taskList' => $this->taskList,
            'sortOrder' => $this->sortOrder,
            'sortColumn' => $this->sortColumn,
            'pagination' => $this->createPaginationBlock($total, $page),
            'upOrDown' => $this->upOrDown,
            'ascOrDesc' => $this->ascOrDesc,
            'addClass' => $addClass,
            'message' => $this->message,
            'gotMessage' => $this->gotMessage,
            'messageType' => $this->messageType,
            'currentPage' => $page,
        ]);
    }

    public function createPaginationBlock(int $total, int $currentPage = 1): string
    {
        $paginationHTML = '<ul class="pagination">';

        $max = 5;
        $amount = ceil($total / 3);

        $left = $currentPage - ceil($max / 2);
        $start = $left > 0 ? $left : 1;

        if ($start + $max <= $amount) {
            $end = $start > 1 ? $start + $max : $max;
        } else {
            $end = $amount;
            $start = $amount - $max > 0 ? $amount - $max : 1;
        }

        $limits = array($start, $end);
        $links = '';

        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $currentPage) {
                $links .= '<li class="page-item active"><a class="page-link" href="#">' . $page . '</a></li>';
            } else {

                $links .= $this->generatePageHTML($page);
            }
        }

        if (!is_null($links)) {
            if ($currentPage > 1)
                $links = $this->generatePageHTML(1, '&lt;') . $links;
            if ($currentPage < $amount)
                $links .= $this->generatePageHTML($amount, '&gt;');
        }
        $paginationHTML .= $links . '</ul>';

        return $paginationHTML;
    }

    public function generatePageHTML(int $page, string $text = null): string
    {
        if (!$text) {
            $text = $page;
        }

        return '<li class="page-item"><a class="page-link" href="?p=' . $page . '&sortColumn='.$this->sortColumn.'&sortOrder='.$this->sortOrder.'">' . $text . '</a></li>';
    }
}