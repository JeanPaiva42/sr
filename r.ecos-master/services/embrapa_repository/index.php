<?php

//mostra os erros
 ini_set('display_errors', 1);
 ini_set('display_startup_erros', 1);
 error_reporting(E_ALL);


include("../../classes/RecosService.php");






class EmbrapaRepository extends RecosService{

	function __construct(){

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
			echo '[{"error": "token invalid"}]';

		} else {

/*			$filtering_service = sql_fetch_array(sql_select($this->conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_filtering_pro']." "));
			$filtering_url = URL_PADRAO.'services/'.$filtering_service['txt_url_ser'].'/?key='.$token.'&userid='.$userid;
			$filtering_result = file_get_contents($filtering_url);
			$filtering = json_decode($filtering_result);
*/

			/*
			USA INFORMAÇÕES DA API EMBRAPA
			*/
			$url_repositorio = "http://hereford.cnpgl.embrapa.br/AppLeiteWebService/recomendaappleite/todasMidias";

      //COMENTADO TRECHO ABAIXO POR MOTIVOS DE NAO SABER PRA QUE SERVE POR ENAQUANTO
/*
      $curl = curl_init($url_repositorio);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$curl_response = curl_exec($curl);
			curl_close($curl);
*/
			/*
			FIM - USA INFORMAÇÕES DA API EMBRAPA
			*/

			$repo = json_decode(file_get_contents($url_repositorio));
      $repo = reset($repo);
			//$retorno_repositorio = json_decode($curl_response);
			//$retorno_repositorio = $retorno_repositorio->midias;
			//print_r ($retorno_repositorio);
		/*	foreach( $repo as $midia ){

				//verificar se esta mídia está no ARRAY retorno do serviço FILTERING
        echo ($filtering);
				if( array_key_exists($midia->codAinfo , $filtering) ){
					echo 'entrei';
					//salva no BD, para saber quais recursos estão sendo recomendados
					$verifica = sql_select($this->conn,'recos_tb_service_repository',NULL," txt_url_rep = '".$midia->url."' AND fk_cod_project_rep = ".$id_project);
					if(sql_num_rows($verifica) == 0){

						//insere um novo repositorio
						$fields = ' fk_cod_project_rep, fk_cod_type_rep, txt_url_rep, txt_description_rep ';
						$values = " ".$id_project.", 1, '".$midia->url."', '".$midia->titulo."' ";

						if(sql_insert($this->conn,'recos_tb_service_repository',$fields,$values)){
							// echo '<br /> ->>salvou repositorio';
						}

					}


					//pega o ID do banco de dados destes vídeos
					$get_resource_id = sql_fetch_array(sql_select($this->conn,'recos_tb_service_repository',NULL,"txt_url_rep = '".$midia->url."' AND fk_cod_project_rep = ".$id_project));
					$resource_id = $get_resource_id['pk_cod_repository'];


					//salva na tabela de STATS
					$url_origem = $_SERVER['SERVER_NAME'];
					$fields_stats = ' fk_cod_repository_sta, txt_descricao_sta, txt_url_origem_sta, txt_topicos_sta';
					$values_stats = " ".$resource_id.", 'RECURSO APRESENTADO' , '".$url_origem."' , '' ";

					if( sql_insert($this->conn,'recos_tb_stats',$fields_stats,$values_stats) ){
						// echo '<br /> ->>salvou stats';
					}


					$infoTodosUsuarios[] = array(
						array('id' => $midia->codAinfo,
						'titulo' => $midia->titulo,
						'descricao' => $midia->descricao,
						'url_acesso' => URL_PADRAO.'api/v0.2/data.php?action=resourceRedirect&id='.$resource_id,
						'url_rejeitar' => URL_PADRAO.'api/v0.2/data.php?action=resourceReject&id='.$resource_id )
					);//$midia->url

				}//if

			}//foreach
*/
	//		$result = json_encode($infoTodosUsuarios, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

			echo (json_encode($repo));

		}//else

	}









}//class


$service = new EmbrapaRepository();



?>
