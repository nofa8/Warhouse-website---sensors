<?php

    header('Content-Type: text/html; charset=utf-8');
//  If Post
    if($_SERVER['REQUEST_METHOD']== 'POST'){

        //'I get a POST';
        print_r($_POST);
        if( isset($_POST['nome']) && isset($_POST['valor']) && isset($_POST['hora']) ){
            if (!file_exists("files/". $_POST['nome']. "/valor.txt")||!file_exists("files/". $_POST['nome']. "/hora.txt")||!file_exists("files/".$_POST['nome']."/log.txt")){
                http_response_code(400);
                echo("Sensor não existente");
            }
            else{
                file_put_contents("files/". $_POST['nome']. "/valor.txt", $_POST['valor']);
                file_put_contents("files/". $_POST['nome']. "/hora.txt", $_POST['hora']);
                file_put_contents("files/".$_POST['nome']."/log.txt",$_POST['hora']."; ".$_POST['valor'] .PHP_EOL ,FILE_APPEND);
            }
        }
        else{
            http_response_code(400);
        }
        
    }   //If Get
    else if($_SERVER['REQUEST_METHOD']== 'GET') {
       //'I get a GET';
        if( isset($_GET['nome'])){  // Se for recebido nome
            if (!file_exists("files/".$_GET['nome']."/valor.txt")){ //Se não existir o ficheiro valor.txt
                http_response_code(400);  //Não existe!
                echo("Sensor não existente");
            }
            else{ // Senão, buscar valor ao ficheiro valor.txt do folder do nome
                echo("".file_get_contents("files/".$_GET['nome']."/valor.txt"));
            }
        }
        else{   //Parâmetro errado
            echo("Missing GET parameters");
            http_response_code(400);
        }

    }
    else{ 
        echo 'Request Method Inválido';
        http_response_code(403);
    }
    
?>