<?php
//mostra os erros
//ini_set('display_errors', 1);
//ini_set('display_startup_erros', 1);
//error_reporting(E_ALL);
//d046fefdec9f4139ab36f11b49f6c56f

include("../../classes/RecosService.php");

// exit('deu certo');


class EmbrapaCosineFavorite extends RecosService
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

            $infoUsuarioSolicitante = json_decode(file_get_contents("http://".$_SERVER['SERVER_NAME']."/r.ecos-master/services/embrapa_profiling/index.php?key=d046fefdec9f4139ab36f11b49f6c56f&userid=".$userid));
            $infoUsuarioSolicitante = (array)$infoUsuarioSolicitante;
            $todasMidias = json_decode(file_get_contents("http://".$_SERVER['SERVER_NAME']."/r.ecos-master/services/embrapa_repository/index.php?key=d046fefdec9f4139ab36f11b49f6c56f&userid=".$userid), true);


            $favoritasDoUsuario = json_decode(file_get_contents("http://".$_SERVER['SERVER_NAME']."/r.ecos-master/services/embrapa_favorite/index.php?key=d046fefdec9f4139ab36f11b49f6c56f&userid=".$userid), true);
            //lembrar de tirar o primeiro elemento dos favs
            array_shift($favoritasDoUsuario);
            $arr_distancias = array();
            $dists = $this->distanciaEntreUsuarioFav($infoUsuarioSolicitante, $favoritasDoUsuario);
            asort($dists);
            array_reverse($dists, true);
            $fav_prox = array_search(max($dists), $dists);
            $fav_array = array();
            $fav_array[] = $fav_prox;
            $fav_array = $this->getFavorites($fav_array,$todasMidias);
            $dists = $this->distanciaEntreFavoritoCartilha($fav_array,$todasMidias,$infoUsuarioSolicitante);

            $result = json_encode($dists);

            echo $result;

        } //else

    }

    function dotp($arr1, $arr2){
        $func =     function ($a,$b){
            return $a*$b;
        };

        return array_sum(array_map($func,$arr1,$arr2));
    }


    function distanciaCosineSimilarity($arr1,$arr2){
        $similarity = $this->dotp($arr1,$arr2)/sqrt($this->dotp($arr1,$arr1)*$this->dotp($arr2,$arr2));

        return $similarity;
    }
    function distanciaEntreUsuarioFav($usu1, $cartilhas)
    {

        $distancia   = 0;
        $distArray   = array();
        $user = $usu1;
        foreach ($cartilhas as $cart) {

            $distancia  = 0;
            //itera nas características dos usuários
                if($user['idNivelLetramento'] >= $cart['idNivelLetramento']){

                     foreach ($user as $key => $value) {
                        $distancia += ((int) $value - (int) $cart[$key]) * ((int) $value - (int) $cart[$key]);
                     }
                    // echo 'iterou! ';
                    $distArray[$cart['codAinfo']] = sqrt($distancia);
                }
            }

        return $distArray;

    } //distancia

    function distanciaEntreFavoritoCartilha($favs, $cartilhas, $usuario){
        $favsArray = array();
        $user = $usuario;
        foreach ($favs as $cart) {
            $distArray = array();
            $favArray = array();
            foreach ($cartilhas as $midia) {
                $midia = (array)$midia;
                if($cart['codAinfo'] != $midia['codAinfo']) {
                    $distancia = 0;
                    $midiaArray = array();
                    if ($user['idNivelLetramento'] >= $midia['idNivelLetramento']) {
                        foreach ($midia as $key => $value) {
                            if (($midia['codAinfo'] != $cart['codAinfo']) && ($key != "codAinfo"
                                    && $key != "descricao" && $key != "imagemMidia" && $key != "qrcode" && $key != "titulo" && $key != "categorias")) {
                                if (((int)$value != 0 || (int)$cart[$key] != 0)) {
                                    $favArray[] = (int)$value;
                                    $midiaArray[] = (int)$cart[$key];
                                }
                            }
                            // echo 'iterou! ';
                        }
                        $favsArray[$midia["codAinfo"]] = $this->distanciaCosineSimilarity($midiaArray, $favArray);

                    }
                }
            }
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
$service = new EmbrapaCosineFavorite();



?>
