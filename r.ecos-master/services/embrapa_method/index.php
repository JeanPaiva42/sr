<?php

//mostra os erros
//ini_set('display_errors', 1);
//ini_set('display_startup_erros', 1);
//error_reporting(E_ALL);
//d046fefdec9f4139ab36f11b49f6c56f

include("../../classes/RecosService.php");
// exit('deu certo');


class EmbrapaMethod extends RecosService
{
    function __construct()
    {

        // echo 'criou embrapaRepository <Br />';

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


        /* PEGA INFORMAÇÕES SOBRE ESTE PROJETO */

        $this->conn = conectar();
/*
        $aux        = sql_select($this->conn, 'recos_tb_projects', NULL, 'txt_hash_pro = \'' . $token . '\' ');
        $project    = sql_fetch_array($aux);
        $id_project = $project['pk_cod_project'];
*/

        $this->__token = $token;

        if (!$this->checkToken()) {

            //token inválido
            echo '[{"error": "token invalid method"}]';

        } else {

            //echo '[{"status": "token ok"}]';
            //com os dados de todos usuários, basta agora realizar o cálculo
            if (isset($_GET['profiling'])) {
                $profiling = urldecode($_GET['profiling']);
            }
/*
            $profiling_service = sql_fetch_array(sql_select($this->conn, 'recos_tb_services', NULL, "pk_cod_service = " . $project['fk_cod_profiling_pro'] . " "));
            $profiling_url     = URL_PADRAO . 'services/' . $profiling_service['txt_url_ser'] . '/?key=' . $token . '&userid=' . $userid;
            $profiling_result  = file_get_contents($profiling_url);
            $profiling         = json_decode($profiling_result);
            */
            //simulando dados usuário solicitante dos recursos
            //o CORRETO é pegar pela API DA EMBRAPA =>> /pesquisaCadastroUsuario
            if (isset($_GET['userid'])) {
                $userid = $_GET['userid'];
            }
            $infoUsuarioSolicitante = json_decode(file_get_contents("http://".$_SERVER['SERVER_NAME']."/r.ecos-master/services/embrapa_profiling/index.php?key=d046fefdec9f4139ab36f11b49f6c56f&userid=".$userid));
            $infoConteudoAcessado   = json_decode(file_get_contents("http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/pesquisaAcessosUsuario?idUsuario=" . $userid));
            $infoConteudoFavoritado = json_decode(file_get_contents("http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/pesquisaFavoritosUsuario?idUsuario=" . $userid));
            $todasMidias            = json_decode(file_get_contents("http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/todasMidias"));
            $arrayCartilha = array();
            $arrayCartilha = reset($todasMidias);

            $favoritasDoUsuario = $this->getFavorites($infoConteudoFavoritado, $arrayCartilha);


            $arrayCartilha  = array();
            $arrayCartilha  = reset($todasMidias);
            $arr_distancias = array();
            $dists          = $this->distanciaEntreUsuarioCartilha($infoUsuarioSolicitante, (array) $arrayCartilha, $infoConteudoFavoritado);
            asort($dists);
            array_reverse($dists, true);
            $score = array();
            if(!empty($infoConteudoFavoritado)){
              $favRec = $this->distanciaEntreFavoritoCartilha($favoritasDoUsuario, $arrayCartilha,$infoUsuarioSolicitante);
              asort($favRec);
              array_reverse($favRec, true);
              $score = $this->scoreFinalDistancias($dists, $favRec, $infoConteudoFavoritado);
              asort($score);
              array_reverse($score, true);
            }
            //ordena este array, por distâncias do menor para maior
            else{
              $score = $dists;
            }
            //mantém somente os 5 usuários mais similares. pode mudar este valor a vontade
            //$arr_distancias_cortado = array_slice($arr_distancias,0,5);
            $result = json_encode($score);
            //$result = json_encode($arr_distancias_cortado);
            echo $result;

        } //else

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

    function getRegiao($regiao)
    {
        switch ($regiao) {
            case 0:
                return "sudeste";
            case 1:
                return "sul";
            case 2:
                return "norte";
            case 3:
                return "centroOeste";
            case 4:
                return "nordeste";
        }
    }
    function distanciaEntreUsuarioCartilha($usu1, $cartilhas, $infoConteudoFavoritado)
    {

        // echo 'entrou!';
        //CONVERSÕES caso os parâmetros cheguem aqui como OBJETOS, e não como ARRAYS
        $user                      = array();
        $usu1                      = (array) $usu1;
        $user['idNivelLetramento'] = $usu1['idNivelLetramento'];
        $regioes                   = array(
            "sudeste",
            "sul",
            "norte",
            "centroOeste",
            "nordeste"
        );
        foreach ($regioes as $r) {
            $user[$r] = 0;
        }
        $regi        = $this->getRegiao($usu1['idRegiao']);
        $user[$regi] = 1;
        $distancia   = 0;
        $distArray   = array();
        foreach ($cartilhas as $cart) {
            $cart       = (array) $cart;
            $distancia  = 0;
            //itera nas características dos usuários
            if (!(in_array($cart['codAinfo'], $infoConteudoFavoritado))){
            if($user['idNivelLetramento'] >= $cart['idNivelLetramento']){
            foreach ($user as $key => $value) {
                $distancia += ((int) $value - (int) $cart[$key]) * ((int) $value - (int) $cart[$key]);
                $data_array[$key] = $cart[$key];
            }
            // echo 'iterou! ';
            $distArray[$cart['codAinfo']] = sqrt($distancia);
          }
        }
      }
        return $distArray;

    } //distancia

    function distanciaEntreFavoritoCartilha($favs, $cartilhas, $usuario){
      $favsArray = array();
      $user = (array)$usuario;
      foreach ($favs as $cart) {
        $distArray = array();
        foreach ($cartilhas as $midia) {
          $midia = (array)$midia;
          $distancia = 0;
         if($user['idNivelLetramento'] >= $midia['idNivelLetramento']){
          foreach ($midia as $key => $value) {
            if(($midia['codAinfo'] != $cart['codAinfo']) && ($key != "codAinfo"
            && $key != "descricao" && $key != "imagemMidia" && $key != "qrcode" && $key != "titulo" && $key != "categorias")){
              $distancia += ((int) $value - (int) $cart[$key]) * ((int) $value - (int) $cart[$key]);
          }
          // echo 'iterou! ';
        }
          $distArray[$midia['codAinfo']] = sqrt($distancia);
        }
      }
        $favsArray[$cart["codAinfo"]] = $distArray;
      }
      return $favsArray;
    }//function

function scoreFinalDistancias($userDistancias, $favDistancias,$infoConteudoFavoritado){
  $finalScore = array();
  foreach ($favDistancias as $fav) {
    foreach ($fav as $key => $value) {
      if(!in_array($key,$infoConteudoFavoritado)){
        if(!array_key_exists($key, $finalScore)){
          $finalScore[$key] = 0;
        }
        $finalScore[$key]+=$value;
    }
  }
  }
  foreach ($userDistancias as $key => $value) {
      $finalScore[$key]+=$value;
  }
  return $finalScore;
}//function

} //class
$service = new EmbrapaMethod();



?>
