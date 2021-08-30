<?php

/** @var $task */
?>
<div class="container-fluid">
    <h3>Редактировать задание</h3>
    <form class="col s12" action="/edit" method="POST">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Ваше имя" aria-label="Username" name="ID"
                   aria-describedby="basic-addon1" value="<?php echo $task->ID; ?>" required hidden>
            <input type="text" class="form-control" placeholder="Ваше имя" aria-label="Username" name="username"
                   aria-describedby="basic-addon1" value="<?php echo htmlspecialchars($task->username); ?>" required disabled>
            <span class="input-group-text">@</span>
            <input type="email" class="form-control" placeholder="Email" aria-label="Username" name="email"
                   aria-describedby="basic-addon1" value="<?php echo htmlspecialchars($task->email); ?>" required disabled>
        </div>
        <div class="input-group">
            <textarea class="form-control mb-3" placeholder="Текст задачи" name="oldtext" aria-label="With textarea"
                      hidden><?php echo htmlspecialchars($task->text); ?></textarea>
            <textarea class="form-control mb-3" placeholder="Текст задачи" name="text" aria-label="With textarea"
                      required maxlength="255"><?php echo htmlspecialchars($task->text); ?></textarea>
        </div>

        <div class="d-grid gap-2 d-md-block">
            <button class="btn btn-primary" type="submit">Сохранить</button>
            <a href='/' class="btn btn-danger" role="button">Отмена</a>
        </div>
        <br/>
    </form>
</div>