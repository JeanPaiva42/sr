<?php

//mostra os erros
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);


include("../../classes/RecosService.php");


class EmbrapaFiltering extends RecosService{

	function __construct(){
	echo $_GET['key'];
	if( isset($_GET['key']) ){
			$token = $_GET['key'];
		} else {
			//token inválido
			echo '[{"error": "token invalid"}]';
			exit;
	}

		if( isset($_GET['userid']) ){
			$userid = $_GET['userid'];
		} else {
			//user inválido
			echo '[{"error": "user invalid"}]';
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
			echo '[{"error": "token invalid filtering"}]';

		} else {

		$method_service = sql_fetch_array(sql_select($this->conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_method_pro']." "));
		$method_url = URL_PADRAO.'services/'.$method_service['txt_url_ser'].'/?key='.$token.'&userid='.$userid;
		$method_result = file_get_contents($method_url);
		$method = json_decode($method_result);


			$arr_total_acessos = null;

			foreach($method as $key => $value){

				//identificação do usuário que iremos pegar na API da EMBRAPA as quantidades de acessos e favoritos
				// echo '<h2> -> LOOP DO USUÁRIO '.$key.'</h2>';


				//número de acessos por este usuário
				$tokenApp = 'ASHAJSHJ';
				$user_id = "1";
				$url_acesso_midia_usuario = "http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/pesquisaAcessosUsuario?idUsuario=".$user_id;
				$retorno_acessos_midia = file_get_contents($url_acesso_midia_usuario);


				//esse é o retorno atual da chamada do webservice de acessos às mídias.
				//como fica dando pau toda hora, simulei
				/*$retorno_acessos_midia = '[
					{"id":1,"tokenApp":"ASHAJSHJ","codAInfo":"A00001","numAcessos":'.rand(1,30).'},
					{"id":2,"tokenApp":"ASHAJSHJ","codAInfo":"A00002","numAcessos":'.rand(1,30).'},
					{"id":3,"tokenApp":"ASHAJSHJ","codAInfo":"A00003","numAcessos":'.rand(1,30).'},
					{"id":4,"tokenApp":"ASHAJSHJ","codAInfo":"A00004","numAcessos":'.rand(1,30).'},
					{"id":5,"tokenApp":"ASHAJSHJ","codAInfo":"A00006","numAcessos":'.rand(1,30).'},
					{"id":6,"tokenApp":"ASHAJSHJ","codAInfo":"A00007","numAcessos":'.rand(1,30).'},
					{"id":7,"tokenApp":"ASHAJSHJ","codAInfo":"A00008","numAcessos":'.rand(1,30).'},
					{"id":8,"tokenApp":"ASHAJSHJ","codAInfo":"A00009","numAcessos":'.rand(1,30).'},
					{"id":9,"tokenApp":"ASHAJSHJ","codAInfo":"A00010","numAcessos":'.rand(1,30).'}
					]';*/

				$retorno_acessos_midia = json_decode($retorno_acessos_midia);

				// echo '<pre>';
				// var_dump($retorno_acessos_midia);
				// echo '</pre>';

				foreach($retorno_acessos_midia as $acessos){

					@$arr_total_acessos[$acessos->codAInfo] += $acessos->numAcessos;

				}

				// echo '<hr>ARRAY COM TOTAL DE ACESSOS POR MÍDIA:';
				// echo '<pre>';
				// var_dump($arr_total_acessos);
				// echo '</pre>';



				//esse é o retorno atual da chamada do webservice de favoritos.
				//como não tem retorno funcionando, simulei
				// echo '<pre>';
				$retorno_favoritos_midia = json_decode(file_get_contents("http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/pesquisaFavoritosUsuario?idUsuario=".$user_id));
				/*'[
					{"id":1,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00001","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":2,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00002","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":3,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00003","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":4,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00004","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":5,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00006","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":6,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00007","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":7,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00008","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":8,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00009","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'},
					{"id":9,"tokenApp":"ASHAJSHJ","codAInfoMidia":"A00010","favorito":'.( rand(0,1) ? '"true"' : '"false"' ).'}
					]';*/
				// echo '</pre>';
				// exit;

				//$retorno_favoritos_midia = json_decode($retorno_favoritos_midia);


				// echo '<pre>';
				// var_dump($retorno_favoritos_midia);
				// echo '</pre>';

				// exit;

				foreach($retorno_favoritos_midia as $favoritos){

						//adicionando com peso maior, por ser favorito. neste caso, valor 10
						@$arr_total_acessos[$favoritos] += 10;
				}

				// echo '<hr>ARRAY COM TOTAL DE ACESSOS POR MÍDIA:';
				// echo '<pre>';
				// var_dump($arr_total_acessos);
				// echo '</pre>';

				// exit;


			}//foreach


			arsort($arr_total_acessos);


			// echo '<hr>ARRAY COM TOTAL DE ACESSOS POR MÍDIA:';
			// echo '<pre>';
			// var_dump($arr_total_acessos);
			// echo '</pre>';

			//mantém somente os 5 usuários mais similares. pode mudar este valor a vontade
			$arr_ranking_midias = array_slice($arr_total_acessos,0,3);

			// exit;

 			$result = json_encode($arr_ranking_midias);

			echo $result;

			// exit;




		//}//else

	}






}}//class


$service = new EmbrapaFiltering();



?>
