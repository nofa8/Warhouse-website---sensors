<!doctype html>
<html lang="pt">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serviço Vigilância Inteligente </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <meta http-equiv="refresh" content="10">
</head>
  <body style="background: radial-gradient(#001f3f, #008cbb)">

  <?php
    session_start(); /*Inicia a sessão*/
    if ( !isset($_SESSION['username']) ){ /*Se variável superglobal "username" não estiver definida*/
      header( "refresh:3;url=index.php" ); /*Faz um refresh da página e redireciona para a página index.php*/
      die( "Acesso restrito." ); /*Imprime uma mensagem e sai do script*/
    }
  ?>
  <?php //buscar aos ficheiros cada um dos valores
    $valor_temperatura = file_get_contents("api/files/temperatura/valor.txt");
    $hora_temperatura = file_get_contents("api/files/temperatura/hora.txt");
    $nome_temperatura = file_get_contents("api/files/temperatura/nome.txt");

    $valor_humidade = file_get_contents("api/files/humidade/valor.txt");
    $hora_humidade = file_get_contents("api/files/humidade/hora.txt");
    $nome_humidade = file_get_contents("api/files/humidade/nome.txt");

    $valor_mov = file_get_contents("api/files/movsensor/valor.txt");
    $hora_mov = file_get_contents("api/files/movsensor/hora.txt");
    $nome_mov = file_get_contents("api/files/movsensor/nome.txt");
  ?>

     <nav class="navbar navbar-expand-lg bg-body-tertiary"> <!-- Navbar, SVI == Home, Histórico só aparece ao admin - liga ao history.php -->
        <div class="container-fluid">
          <a class="navbar-brand" href="dashboard.php">S.V.I.</a> <!-- Com dropdown dependendo do tamanho da página em questão -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
              </li>
              <li class="nav-item">
                <?php  if($_SESSION['username'] == 'admin')
                {
                  echo '<a class="nav-link" href="history.php">Histórico</a>'; 
                }?>
              </li>
            </ul>
             <form class="d-flex" role="search" action="logout.php">
                <button class="btn btn-outline-secondary" type="submit">Logout</button>   <!--Button que liga ao logout.php -->
             </form>
          </div>
       </div>
     </nav>

    <br>
    <br>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
              <img src="imagens/index.png" class="float-end" style="width: 150px;" alt="">
              <h1>Serviço de Vigilância Inteligente</h1>
              <h4>Bem vindo <b><?php echo ucwords($_SESSION['username']);?></b></h4>  <!--Parte "Introdutória", nome com first letter uppercase -->
              <p>Tecnologias de Internet</p>
            </div>
       </div>
    </div>

    <br>

    <div class="container">
        <div class="row text-center"> <!--Demonstração dos sensores e atuadores e dos seus mais recentes valores e significado tendo em conta a imagem e valor no ficheiro valor.txt -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header sensor">
                    <b>Temperatura: <?php echo("$valor_temperatura"."ºC");?></b>
                    </div>
                    <div class="card-body">
                        <?php
                        if($valor_temperatura >=30){
                          echo '<img src="imagens/temperature-high.png" alt="temperature">';
                        }
                        else{
                          echo '<img src="imagens/temperature-low.png" alt="temperature">';

                        }
                        
                        ?>
                    </div>
                    <div class="card-footer">
                        <b>Atualização:</b> <?php echo("$hora_temperatura");
                        if($_SESSION['username']=='admin'){
                          echo '<br>
                                <a  href="history.php?nome=temperatura" class="historyLk"> Histórico</a>';}?>
                                <!--Se for admin aparece histórico se não não aparece nada -->
                    </div> 
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header sensor">
                    <b>Humidade: <?php echo("$valor_humidade"."%");?></b>
                    </div>
                    <div class="card-body">
                      <?php
                          if($valor_humidade >=60){
                            echo '<img src="imagens/humidity-high.png" alt="temperature">';
                          }
                          else{
                            echo '<img src="imagens/humidity-low.png" alt="temperature">';

                          }
                          
                          ?>
                    </div>
                    <div class="card-footer">
                        <b>Atualização:</b> <?php echo("$hora_humidade"); 
                        if($_SESSION['username']=='admin'){
                          echo '<br>
                                <a class="historyLk" href="history.php?nome=humidade"> Histórico</a>';}?> 
                                <!--Se for admin aparece histórico se não não aparece nada -->
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header atuador">
                        <b>Sensor de Movimento: <?php echo("$valor_mov"."m")?></b>
                    </div>
                    <div class="card-body">
                      <?php
                          if($valor_mov == 0){
                            echo '<img src="imagens/light-off.png" alt="movsensor">';
                          }
                          else{
                            echo '<img src="imagens/light-on.png" alt="movsensor">';

                          }
                          
                          ?>
                    </div>
                    <div class="card-footer">
                        <b>Atualização:</b> <?php echo("$hora_mov");
                        if($_SESSION['username']=='admin'){
                          echo '<br>
                                <a class="historyLk" href="history.php?nome=movsensor"> Histórico</a>';};?>
                                <!--Se for admin aparece histórico se não não aparece nada -->
                    </div>
                </div>
            </div>
        </div>     
    </div>

    <br> 

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4><b>Tabela de sensores</b></h4><!--Tabela dos sensores -->
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Tipo de dispositivo IoT</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data de atualização</th>
                            <th scope="col">Estado Alertas</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo("$nome_temperatura") ?></td> <!--Sensor de Temperatura -->
                            <td><?php echo("$valor_temperatura"."º") ?></td>
                            <td> <?php echo("$hora_temperatura") ?></td>
                            <td>
                              <?php
                                if($valor_temperatura >= 30){
                                  echo '<span class="badge text-bg-danger">High</span></td>';
                                }
                                else{
                                  echo '<span class="badge text-bg-info">Low</span></td>';
                                }
                              ?>
                        </tr>
                        <tr>
                            <td><?php echo("$nome_humidade") ?></td> <!--Sensor Humidade -->
                            <td><?php echo("$valor_humidade"."%") ?></td>
                            <td> <?php echo("$hora_humidade") ?></td>
                            <td>
                              <?php
                                if($valor_humidade >= 60){
                                  echo '<span class="badge text-bg-primary">High</span></td>';
                                }
                                else{
                                  echo '<span class="badge text-bg-success">Low</span></td>';
                                }
                              ?>
                        </tr>
                        <tr>
                            <td><?php echo("$nome_mov") ?></td> <!--Sensor de Movimento -->
                            <td><?php echo("$valor_mov"." m") ?></td>
                            <td> <?php echo("$hora_mov") ?></td>
                            <td>
                              <?php
                              if($valor_mov == 0){
                                echo '<span class="badge text-bg-success">Ativo</span></td>';
                              }
                              else{
                                echo '<span class="badge text-bg-warning">Acionado</span></td>';
                              }
                              ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>