<?php use app\App\Controllers\LoginController;

header("X-XSS-Protection: 1"); ?>

<!DOCTYPE html>

<html lang="ru">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <title>Задачник</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="container col-s4">
    <nav class="navbar navbar-light bg-light">
        <a href="/" class="navbar-brand"><h3><i class="fas fa-tasks"></i> Задачник</h3></a>

        <?php
        if (LoginController::isBadAuth()) { ?>
            <div class="alert alert-danger" role="alert">
                Проверьте данные учетной записи...
            </div>
        <?php }

        if (LoginController::isAdmin()) { ?>
        <form class="form-inline" action="/logout" method="POST">
            <button class="btn btn-outline-danger my-2 my-sm-0" id="logout">Выйти</button>
            <?php
            } else { ?>
            <form class="d-flex" action="/login" method="POST">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                           aria-describedby="basic-addon1" name="login" required>
                    <input type="password" class="form-control" placeholder="Password" aria-label="Password"
                           aria-describedby="basic-addon1" name="password" required>
                </div>
                <button class="btn btn-outline-success my-2 my-sm-0" id="login">Войти</button>
                <?php } ?>
            </form>
    </nav>
</div>

<div class="container col-s4">
    {{content}}
</div>

</body>

</html>