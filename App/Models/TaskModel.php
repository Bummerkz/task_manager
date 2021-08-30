<?php

namespace app\App\Models;

use app\App\core\Database;
use app\App\core\Model;
use Throwable;

class TaskModel extends Model
{
    public int $ID;
    public string $username;
    public string $email;
    public string $text;
    public bool $status;
    public bool $admin_revised;

    public Database $database;

    public string $tableName = 'tasks';

    private array $sortingColumns = ['username', 'email', 'status'];

    public function __construct()
    {
        $this->database = new Database();
    }

    public function add(): bool
    {
        $this->database->connect_db();

        try {
            $stmt = $this->database->prepare("INSERT INTO $this->tableName(username, email, text) VALUES (?,?,?)");
            $stmt->execute([$this->username, $this->email, $this->text]);
            return true;
        } catch (Throwable $th) {
            echo $th;
            return false;
        }
    }

    public function updateTask(): bool
    {
        $this->database->connect_db();

        try {
            $stmt = $this->database->pdo->query("UPDATE $this->tableName SET text='$this->text', admin_revised=$this->admin_revised WHERE ID=$this->ID");
            $stmt->execute();
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    public function checkDone(int $ID): bool
    {
        $this->database->connect_db();
        try {
            $stmt = $this->database->pdo->query("UPDATE $this->tableName SET status=1 WHERE ID=$ID");
            $stmt->execute();
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    public function getTaskByID(int $ID)
    {
        $this->database->connect_db();
        try {
            $stmt = $this->database->pdo->query("SELECT * FROM $this->tableName WHERE ID=$ID");
            $stmt->execute();
            return $stmt->fetchObject();
        } catch (Throwable $th) {
            return false;
        }
    }

    public function getTotalAmountOfTasks()
    {
        $this->database->connect_db();

        try {
            $stmt = $this->database->pdo->query("SELECT COUNT(ID) AS count FROM $this->tableName");
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['count'];
        } catch (Throwable $th) {
            return false;
        }
    }

    public function getTasksPerPage(int $page = 1, string $sortColumn = 'ID', string $sortOrder = 'ASC', int $limit = 3): bool|array
    {
        $sortColumn = in_array($sortColumn, $this->sortingColumns) ? $sortColumn : $this->sortingColumns[0];
        $sortOrder = strtolower($sortOrder) == 'desc' ? 'DESC' : 'ASC';

        $start_from = ($page - 1) * $limit;

        $sortedTaskList = [];

        $this->database->connect_db();
        try {
            $stmt = $this->database->pdo->query("SELECT * FROM $this->tableName ORDER BY $sortColumn $sortOrder LIMIT $start_from, $limit");

            while ($data = $stmt->fetch()) {
                $task = new TaskModel();
                $task->ID = $data['ID'];
                $task->username = $data['username'];
                $task->email = $data['email'];
                $task->text = $data['text'];
                $task->status = !(($data['status'] == 0));
                $task->admin_revised = !(($data['admin_revised'] == 0));

                $sortedTaskList[] = $task;
            }

            return $sortedTaskList;
        } catch (Throwable $th) {
            return false;
        }
    }
}