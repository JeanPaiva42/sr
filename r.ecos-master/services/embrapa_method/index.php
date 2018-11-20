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
        $aux        = sql_select($this->conn, 'recos_tb_projects', NULL, 'txt_hash_pro = \'' . $token . '\' ');
        $project    = sql_fetch_array($aux);
        $id_project = $project['pk_cod_project'];


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

            $profiling_service = sql_fetch_array(sql_select($this->conn, 'recos_tb_services', NULL, "pk_cod_service = " . $project['fk_cod_profiling_pro'] . " "));
            $profiling_url     = URL_PADRAO . 'services/' . $profiling_service['txt_url_ser'] . '/?key=' . $token . '&userid=' . $userid;
            $profiling_result  = file_get_contents($profiling_url);
            $profiling         = json_decode($profiling_result);
            //simulando dados usuário solicitante dos recursos
            //o CORRETO é pegar pela API DA EMBRAPA =>> /pesquisaCadastroUsuario
            if (isset($_GET['userid'])) {
                $userid = $_GET['userid'];
            }

            $infoUsuarioSolicitante = json_decode(file_get_contents("http://".$_SERVER['SERVER_NAME']."/r.ecos-master/services/embrapa_profiling/index.php?key=d046fefdec9f4139ab36f11b49f6c56f&userid=".$userid), true);
            $todasMidias = json_decode(file_get_contents("http://".$_SERVER['SERVER_NAME']."/r.ecos-master/services/embrapa_repository/index.php?key=d046fefdec9f4139ab36f11b49f6c56f&userid=".$userid), true);


            $favoritasDoUsuario = json_decode(file_get_contents("http://".$_SERVER['SERVER_NAME']."/r.ecos-master/services/embrapa_favorite/index.php?key=d046fefdec9f4139ab36f11b49f6c56f&userid=".$userid), true);
            $infoConteudoFavoritado = array_shift($favoritasDoUsuario);
                $arr_distancias = array();
            $dists = $this->distanciaEntreUsuarioCartilha($infoUsuarioSolicitante,  $todasMidias, $infoConteudoFavoritado);
            asort($dists);
            array_reverse($dists, true);

            $score = array();
            $favRec = array();
            if(!empty($infoConteudoFavoritado)){
              $favRec = $this->distanciaEntreFavoritoCartilha($favoritasDoUsuario, $todasMidias,$infoUsuarioSolicitante);

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
            $result = json_encode($score);

            $final_output = array();
            foreach ($score as $key=>$value){
                $new_arr = array();
                $new_arr["CodAinfo"] = $key;
                $new_arr["proximidade"] = $value;
                $final_output[] = $new_arr;
            }

            echo json_encode($final_output);

        } //else

    }


    function distanciaEntreUsuarioCartilha($usu1, $cartilhas, $infoConteudoFavoritado)
    {

        // echo 'entrou!';
        //CONVERSÕES caso os parâmetros cheguem aqui como OBJETOS, e não como ARRAYS
        $distancia   = 0;
        $distArray   = array();
        $user = $usu1;
         foreach ($cartilhas as $cart) {

            $cart = (array) $cart;

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
      $user = $usuario;

        foreach ($favs as $cart) {
        $distArray = array();
        foreach ($cartilhas as $midia) {
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
