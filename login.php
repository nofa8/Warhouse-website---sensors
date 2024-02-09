<?php
    session_start();//Iniciar a sessão
    
    include 'data.php';//include da informação do login(pass e username)
    
    if(isset($_POST['username']) && isset($_POST['password'])){ //Se houver username e password
      if($_POST['username']  == $username && password_verify ($_POST['password'], $password_hash)||($_POST['username']  == $username1 && password_verify($_POST['password'], $password_hash1))){
        //Verificação das credenciais
        $_SESSION['username'] = $_POST['username'];//colocar o username na variavel session
        header('Location: dashboard.php');//abrir dashboard
      }else{//senao (credenciais erradas)
        $_SESSION['message'] = "Credenciais Erradas";//aparece mensagem de erro
        
      } 
    }?>
<!doctype html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style1.css">
  </head>
  <body>
    <div class="container justify-content-center" >
      <div class="row justify-content-center" >
        <form class="TIform"  method="post">
              <h1>
              <img src="imagens/index.png" style="max-width:200px;height:auto;"  id="ipimg" alt="">
              <b style="color: silver;text-align: center;">Serviço Vigilância Inteligente</b></h1>
              
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label" id="usercomname">Username: </label>
                <input type="text" name="username" class="form-control" id="exampleInputEmail1" required>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label" id="passdaword">Password:</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
              </div>

              <?php
              if(isset($_SESSION['message']) && $_SESSION['message'] != ""){
                echo "<div class='alert alert-danger' role='alert'>",$_SESSION['message'],"</div>";
                $_SESSION['message'] = "";
              }?>

              <button type="submit" class="btn btn-primary">Submeter</button>
        </form>
      </div>
    </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>
