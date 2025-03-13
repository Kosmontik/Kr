<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center flex-column min-vh-100 ">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Панель навигации</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Переключатель навигации">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Главная</a>
        <a class="nav-link" href="#">Рекомендуемые</a>
        <a class="nav-link" href="#">Цена</a>
        <a class="nav-link" id="avtoriz" >Авторизация</a>
      </div>
    </div>
  </div>
</nav>
<div class="modal-dialog modal-dialog-centered" id="modal">
<div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Авторизация</h5>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            <label for="login">
                <input type="text" id="login" name="login">
            </label>
            <label for="password">
                <input type="password" id="password" name="password">
            </label>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
</div>

<script src="js/bootstrap.bundle.js"></script>
<script>
let avtoriz=document.getElementById('#avtoriz');
let modal=document.getElementById('#modal');
avtoriz.addEventListener('click', ()=>{
modal.showModal();
});
</script>
</body>
</html>