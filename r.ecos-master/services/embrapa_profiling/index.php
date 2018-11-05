<?php

//mostra os erros
 ini_set('display_errors', 1);
 ini_set('display_startup_erros', 1);
 error_reporting(E_ALL);


include("../../classes/RecosService.php");

class EmbrapaProfiling extends RecosService{
  function __construct(){

		if( isset($_GET['key']) ){
			$token = $_GET['key'];
		} else {
			//token inválido
			echo '[{"error": "token invalid"}]';
			exit;
		}

		/* PEGA INFORMAÇÕES SOBRE ESTE PROJETO */
		$this->conn = conectar();
		$aux = sql_select($this->conn,'recos_tb_projects',NULL,'txt_hash_pro = \''.$token.'\' ');
		$project = sql_fetch_array($aux);
		$id_project = $project['pk_cod_project'];

		$this->__token = $token;


		if( !$this->checkToken() ){

			//token inválido
			echo '[{"error": "token invalid profiling"}]';

		} else {

			if( isset($_GET['userid']) ){
				$userid = $_GET['userid'];
			} else {
				//user inválido
				echo '[{"error": "user invalid"}]';
				exit;
			}


			//simulando dados usuário solicitante dos recursos
			//o CORRETO é pegar pela API DA EMBRAPA =>> /pesquisaCadastroUsuario

			$infoUsuarioSolicitante = json_decode(file_get_contents("http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/pesquisaCadastroUsuario?idUsuario=".$userid));
      $user                      = array();
      $usu1                      = (array) $infoUsuarioSolicitante;
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

			$result = json_encode($user);

			echo $result;



			//aqui chama o próximo service - neste caso, METHOD, passando como parâmetro o $result
			//ou não?





		}//else
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

}//class

$service = new EmbrapaProfiling();



?>
