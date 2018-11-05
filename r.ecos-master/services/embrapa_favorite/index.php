<?php

//mostra os erros
 ini_set('display_errors', 1);
 ini_set('display_startup_erros', 1);
 error_reporting(E_ALL);


include("../../classes/RecosService.php");

class EmbrapaProfiling extends RecosService{
  function __construct(){
    if (isset($_GET['key'])) {
        $token = $_GET['key'];
    } else {
        //token inválido
        echo '[{"error": "token invalid"}]';
        exit;
    }

    if (isset($_GET['userid'])) {
        $userid = $_GET['userid'];
    } else {
        //user inválido
        echo '[{"error": "user invalid"}]';
        exit;

    }
    if (isset($_GET['midias'])) {
        $midias = $_GET['midias'];
    } else {
        //user inválido
        $midias = json_decode(file_get_contents("http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/todasMidias"));


    }
    if(is_string($midias))
        $midias = json_decode($midias);
    $infoConteudoFavoritado = json_decode(file_get_contents("http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/pesquisaFavoritosUsuario?idUsuario=" . $userid));
    $midias = reset($midias);
    $favs = ($this->getFavorites($infoConteudoFavoritado, $midias));
    array_unshift($favs, $infoConteudoFavoritado);
    echo (json_encode($favs));
}

function getFavorites($favs, $todasM){
 $cartilhaUsuario = array();
 foreach ($favs as $f){
     foreach($todasM as $cart){
     $ca = (array)$cart;
     if($ca['codAinfo'] == $f){
     $cartilhaUsuario[] = $ca;
     }
   }
 }
 return $cartilhaUsuario;
}

}//class


$service = new EmbrapaProfiling();



?>
