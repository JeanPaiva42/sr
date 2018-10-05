<?php

date_default_timezone_set('America/Sao_Paulo');


switch( $_SERVER['SERVER_NAME'] ){

 //editado pra funcionar no meu pc
    case 'localhost': case 'localhost:8888':{

        //constantes do Banco de Dados
        define('BD_HOST', 'localhost'); // USE O NOME DO TEU BANCO DE DADOS embrapa
        define('BD_USER', 'root'); // USE O TEU USUARIO DE BANCO DE DADOS
        define('BD_PASS', ''); // USE A TUA SENHA DO BANCO DE DADOS ufjf2018
        define('BD_NAME', 'recosonline'); // USE O NOME DO TEU BANCO DE DADOS

        define('URL_PADRAO', 'http://localhost/r.ecos-master/');

    }break;


    case 'recos.online': {

        define('BD_HOST', 'recosonline.mysql.dbaas.com.br'); // USE O NOME DO TEU BANCO DE DADOS
        define('BD_USER', 'recosonline'); // USE O TEU USUARIO DE BANCO DE DADOS
        define('BD_PASS', 'ufjf0978'); // USE A TUA SENHA DO BANCO DE DADOS
        define('BD_NAME', 'recosonline'); // USE O NOME DO TEU BANCO DE DADOS

        define('URL_PADRAO', 'http://recos.online/prototipo/');

    }break;


}







//contantes utilizadas na aplicacao
if(isset($_GET['debug']) && $_GET['debug']=='true'){
    define('_DEBUG', true); // Se for TRUE ativa o DEBUG no sistema
} else {
    define('_DEBUG', false); // Se for TRUE ativa o DEBUG no sistema
}

define('_LOG', false); // Se for TRUE ativa o LOG no sistema


define('_HASH', 'R3C0S-UFJF');// usado na criação da HASH


define('_TABLE_STATS', 'recos_tb_stats');





function conectar(){

    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Erro de conexao: %s\n", mysqli_connect_error());
        //exit();
    }


    $conn = mysqli_connect(BD_HOST, BD_USER, BD_PASS);
    mysqli_select_db($conn,BD_NAME);

    return $conn;
}





?>
