<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Histórico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style3.css">
  </head>
  <body>
    <?php
        session_start(); /*Inicia a sessão*/
        if ( !isset($_SESSION['username']) ){ /*Se variável superglobal "username" não estiver definida*/
        header( "refresh:1;url=index.php" ); /*Faz um refresh da página e redireciona para a página index.php*/
        die( "Acesso restrito." ); /*Imprime uma mensagem e sai do script*/
        }
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="dashboard.php">S.V.I.</a>
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
                <button class="btn btn-outline-secondary" type="submit">Logout</button>
             </form>
          </div>
       </div>
     </nav>

        <?php if(empty($_GET['nome'])) //Se for o histórico não ligado a nenhum sensor então 
             {                          //seleciona o que deseja ver
                echo 
                '<div>
                    <form method="post">
                        <select id="formselect" class="form-group form-control form-select form-check form-switch" name="selector" required>
                            <option value="" selected disabled>Selecione o sensor</option>
                            <option value="temperatura">Temperatura</option>
                            <option value="humidade">Humidade</option>
                            <option value="movsensor">Sensor de Movimento</option>
                        </select>
                        <br>
                        <input class="btn btn-secondary" id="selectorSubmit" type="submit" name="Submit" value="Submeter">
                    </form>
                </div>';  
            }
        ?>


        <?php 
            if(isset($_GET['nome']) || isset($_POST['selector']))
            {   //Se houver nome ou selector então buscar informação ao ficheiro e colocar numa table
                echo '
                <div class="container" id="principal">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header"><h1><b>
                                    Histórico - '; 
                                    if(isset($_GET['nome'])){   //Echo nome (nome do sensor)
                                        if($_GET["nome"] == "movsensor"){
                                            echo 'Sensor de movimento';
                                        }
                                        else{
                                            echo ucwords($_GET["nome"]);
                                        }
                                    }
                                    elseif(isset($_POST['selector'])){  //Echo nome (nome do sensor)
                                        if($_POST["selector"] == "movsensor"){
                                            echo 'Sensor de movimento';
                                        }
                                        else{
                                            echo ucwords($_POST["selector"]);
                                        }
                                    }
                                    //Table Head
                                echo'   
                                </b></h1>
                                </div>
                                <table class="table table-responsive table-hover table-bordered table-white">
                                    <thead>
                                    <tr>
                                        <th scope="col">Data</th>
                                        <th scope="col">Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody>';

                                    if(isset($_POST['selector']))   //Se houver selector ir ao ficheiro e tabela do sensor selecionado
                                    {
                                        $filezao = fopen("api/files/".$_POST['selector']."/log.txt", 'r') or die("Não consegui abrir o ficheiro!");
                                        while(!feof($filezao)){ //fopen ficheiro do log do sensor desejado
                                        //Enquanto não chega ao End Of File do ficheiro log do sensor
                                            $line = fgets($filezao);    //get line 
                                            if(empty($line)){           //se a linha estiver vazia voltar ao inicio do loop
                                                continue;
                                            }
                                            $arr = explode(";",$line);  //Explode, neste caso "corta" a linha no ';' ficando no vetor arr, arr[0] e arr[1]
                                            //echo informação do ficheiro
                                            echo '<tr>
                                                    <td>'.$arr[0].'</td>
                                                    <td>'.$arr[1].'</td>
                                                </tr>';
                                        }                                                       
                                        fclose($filezao);
                                    }
                                    else{
                                        $filezao = fopen("api/files/".$_GET['nome']."/log.txt", 'r') or die("Não consegui abrir o ficheiro!");
                                        while(!feof($filezao)){ //fopen ficheiro do log do sensor desejado
                                        //Enquanto não chega ao End Of File do ficheiro log do sensor
                                            $line = fgets($filezao);//get line
                                            if(empty($line)){       //Se linha vazia passa ao inicio do loop (passa à frente do resto do código abaixo dentro do while)
                                                continue;
                                            }
                                            $arr = explode(";",$line); //Explode, neste caso "corta" a linha no ';' ficando no vetor arr, arr[0] e arr[1]
                                            //echo informação do ficheiro
                                            echo '<tr>
                                                    <td>'.$arr[0].'</td>
                                                    <td>'.$arr[1].'</td>
                                                </tr>';
                                        }                                                       
                                        fclose($filezao);
                                    }
                                    
                                echo '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
   </body>
</html>


