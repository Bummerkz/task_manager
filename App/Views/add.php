<div class="container-fluid">
    <h3>Добавить задание</h3>
    <form class="col s12" action="/add" method="POST">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Ваше имя" aria-label="Username" name="username"
                   aria-describedby="basic-addon1" required maxlength="45">
            <span class="input-group-text">@</span>
            <input type="email" class="form-control" placeholder="Email" aria-label="Username" name="email"
                   aria-describedby="basic-addon1" required maxlength="45">
        </div>
        <div class="input-group">
            <textarea class="form-control" placeholder="Текст задачи" name="text" aria-label="With textarea"
                      required maxlength="255"></textarea>
        </div>
        <br/>

        <div class="input-group">
            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
        <br/>
    </form>
</div>