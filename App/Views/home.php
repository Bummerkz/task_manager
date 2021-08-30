<?php

use app\App\Controllers\LoginController;
use app\App\Controllers\HomeController;

/** @var $sortColumn
 * @var $ascOrDesc
 * @var $upOrDown
 * @var $taskList
 * @var $pagination
 * @var $gotMessage
 * @var $message
 * @var $messageType
 * @var $currentPage
 */
?>

<?php
if ($gotMessage) { ?>
<div class="alert alert-<?php echo htmlspecialchars($messageType); ?>" role="alert">
    <?php echo htmlspecialchars($message); ?>
</div>
<?php } else { ?>
<div class="alert alert-secondary" role="alert">
    Добро пожаловать в Задачник!
</div>
<?php } ?>

<div class="container">
    <p><a href='/add' class="btn btn-primary" role="button">Добавить задачу</a></p>
    <p><?php echo $pagination; ?></p>
</div>
<table class="table table-hover table-sm">
    <thead class="thead-dark thead_center">
    <tr class="table-secondary">
        <th class="th_revised"></th>
        <th><a class="table-primary" href="/?p=<?php echo $currentPage; ?>&sortColumn=username&sortOrder=<?php echo $ascOrDesc; ?>">Имя пользователя
                <i class="fas fa-sort<?php echo $sortColumn == 'username' ? '-' . $upOrDown : ''; ?>"></i></a></th>
        <th><a class="table-primary" href="/?p=<?php echo $currentPage; ?>&sortColumn=email&sortOrder=<?php echo $ascOrDesc; ?>">E-mail
                <i class="fas fa-sort<?php echo $sortColumn == 'email' ? '-' . $upOrDown : ''; ?>"></i></a></th>
        <th class="th_text">Текст задачи</th>
        <th class="th_status"><a class="table-primary" href="/?p=<?php echo $currentPage; ?>&sortColumn=status&sortOrder=<?php echo $ascOrDesc; ?>">Статус
                <i class="fas fa-sort<?php echo $sortColumn == 'status' ? '-' . $upOrDown : ''; ?>"></i></a></th>
        <?php if (LoginController::isAdmin()) { ?>
            <th class="th_action">Действие</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($taskList as $taskItem) : ?>
        <tr class="<?php if ($taskItem->status) echo 'table-success'; ?>">
            <?php if ($taskItem->admin_revised) { ?>
                <td><img width="60" src="img/revised.jpg"> </td>
            <?php } else {
                echo '<td></td>';
            }
            ?>
            <td><?php echo htmlspecialchars($taskItem->username) ?></td>
            <td><?php echo htmlspecialchars($taskItem->email) ?></td>
            <td><?php echo htmlspecialchars($taskItem->text) ?></td>
            <td>
                <?php
                if ($taskItem->status) {
                    echo "Выполнено";
                }
                else {
                    if (LoginController::isAdmin()) {
                        echo '<a href="/done?ID=' . $taskItem->ID . '" class="btn btn-outline-success" role="button">Выполнить</a>';
                    } else {
                        echo '-';
                    }
                }
                ?>
            </td>
            <?php if (LoginController::isAdmin()) { ?>
                <td>
                    <a href="/edit?ID=<?php echo $taskItem->ID ?>" class="btn btn-warning"
                       role="button">Редактировать</a>
                </td>
            <?php } ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>