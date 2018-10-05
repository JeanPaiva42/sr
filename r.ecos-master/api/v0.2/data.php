<?php

header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Credentials: true');  

header('Access-Control-Allow-Origin: http://www.gestaoescolarsimplificada.com.br');  

//mostra os erros
// ini_set('display_errors', 1);
// ini_set('display_startup_erros', 1);
// error_reporting(E_ALL);


include('../../config/inc.config.php');
include('../../config/inc.functions.php');


$conn = conectar();


$project_key = @$_GET['key'];



// $dat_inicio_solicitacao_log = mktime( date('H'),date('i'),date('s'),date('m'),date('d'),date('Y') );
$dat_inicio_solicitacao_log = date('Y-m-d H:i:s');





// echo '<pre>';

if( isset($_GET['action']) ){
	
	$action = $_GET['action'];

	switch( $action ){

		default:{

			echo '[{"error": invalid action}]';

		} break;

		








		case 'resourceRedirect':{

			$resource_id = $_GET['id'];
			$url_origem = @$_GET['url_origem'];
			
			//pega dados do recurso
			$resource = sql_fetch_array(sql_select($conn,'recos_tb_service_repository',NULL,'pk_cod_repository = '.$resource_id, '*'));

			//salva na tabela de STATS
			$fields_stats = ' fk_cod_repository_sta, txt_descricao_sta, txt_url_origem_sta';
			$values_stats = " ".$resource_id.", 'RECURSO CLICADO' , '".$url_origem."' ";

			sql_insert($conn,'recos_tb_stats',$fields_stats,$values_stats);

			//redireciona ao recurso, ou abre ele com um modal, por exemplo
			redireciona( $resource['txt_url_rep'] );

		} break;



		case 'resourceReject':{

			$resource_id = $_GET['id'];
			$url_origem = @$_GET['url_origem'];
			
			//pega dados do recurso
			$resource = sql_fetch_array(sql_select($conn,'recos_tb_service_repository',NULL,'pk_cod_repository = '.$resource_id, '*'));

			//salva na tabela de STATS
			$fields_stats = ' fk_cod_repository_sta, txt_descricao_sta, txt_url_origem_sta';
			$values_stats = " ".$resource_id.", 'RECURSO REJEITADO' , '".$url_origem."' ";

			sql_insert($conn,'recos_tb_stats',$fields_stats,$values_stats);

			echo 'ok';

		} break;



		case 'getResources':{

			// echo '<pre>';
			// var_dump($_GET);
			// echo '</pre>';

			//parâmetro necessário é o IDENTIFICADOR do usuário.
			if( isset($_GET['userid']) && $_GET['userid']!='' ){

				//Usuário que está solicitando os recursos.
				//É passado por parâmetro
				$userid = $_GET['userid'];


				//KEY DO PROJETO - $project_key; 
				$project = sql_fetch_array(sql_select($conn,'recos_tb_projects',NULL,"txt_hash_pro = '".$project_key."' "));

				// var_dump($project);

				if( @$_GET['test']=='true' ){
					$pretty = '&pretty=true';
				}
				





/**
 * 1ª PARTE - PERFIL DOS USUÁRIOS
 * 
 */
// echo '<h1>PROFILE - PERFIL DOS USUÁRIOS</h1>';
	
				// $profiling_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_profiling_pro']." "));
				// $profiling_url = URL_PADRAO.'services/'.$profiling_service['txt_url_ser'].'/?key='.$project_key.'&userid='.$userid;
				// $profiling_result = file_get_contents($profiling_url);
				
/**
 * 2ª PARTE - CÁLCULO DE SIMILARIDADES ENTRE ELES, PARA ENCONTRAR OS MAIS PRÓXIMOS
 * EUCLIDEAN METHOD SERVICE
 */
// echo '<h1>METHOD - DISTÂNCIA EUCLIDIANA</h1>';

				// $method_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_method_pro']." "));
				// $method_url = URL_PADRAO.'services/'.$method_service['txt_url_ser'].'/?key='.$project_key.'&userid='.$userid.'&profiling='.urlencode($profiling_result);
				// $method_result = file_get_contents($method_url);

/** 
 * FILTRAGEM
 * 3ª PARTE - COLLABORATIVE FILTERING SERVICE - características deste usuário
 * e iremos através da API da EMBRAPA verificar quais mídias eles mais acessam, e quais eles mais favoritam. 
 * Importante dar um peso maior para os favoritos. 
 */

// echo '<h1>FILTERING - FILTRAGEM COLABORATIVA</h1>';

				// $filtering_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_filtering_pro']." "));
				// $filtering_url = URL_PADRAO.'services/'.$filtering_service['txt_url_ser'].'/?key='.$project_key.'&userid='.$userid.'&method='.urlencode($method_result);
				// $filtering_result = file_get_contents($filtering_url);
				
/**
 * 4ª PARTE - REPOSITÓRIO
 * 
 */
// echo '<h1>REPOSITORY</h1>';

				$repository_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_repository_pro']." "));
				// $repository_url = URL_PADRAO.'services/'.$repository_service['txt_url_ser'].'/?key='.$project_key.'&userid='.$userid.'&filtering='.urlencode($filtering_result);
				$repository_url = URL_PADRAO.'services/'.$repository_service['txt_url_ser'].'/?key='.$project_key.'&userid='.$userid;
				$repository_result = file_get_contents($repository_url);
			
/**
 * PARTE FINAL - AGORA RETORNA O RESULTADO PARA SER CONSUMIDO PELO APLICATIVO 
 * 
 */

				if( @$_GET['pretty']=='true' ){
					echo '<pre>';
					// echo json_encode( $repository_result, JSON_PRETTY_PRINT );
					echo $repository_result;
					echo '</pre>';
				} else {
					echo $repository_result;
				}
			



			} else{
				echo '[{"error": no user id}]';
			}


		}break;



	}


}//if

exit;
?>









				/**
				 * EUCLIDEAN METHOD SERVICE - Como calcula a similaridade entre usuários
				 * */
				if($project['fk_cod_method_pro']!=0 && $project['fk_cod_method_pro'] != NULL ){

					$topics = urlencode(trim(@$_GET['topics']));
					

					$method_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_method_pro']." "));

					//assim eu USARIA o retorno do serviço anterior
					// $method_url = URL_PADRAO.'services/'.$method_service['txt_url_ser'].'/?key='.$project_key.'&pretty=true&qtd=3&profile='.json_decode($retorno_service_profiling).'&userid1='.$user_id;

					//deste jeito, passo direto o ID do user, logo não uso o retorno do serviço anterior.
					$method_url = URL_PADRAO.'services/'.$method_service['txt_url_ser'].'/?key='.$project_key.'&qtd=3&userid1='.$user_id.'&courseid='.$course_id.'&topics='.$topics;

					/*$method_url = URL_PADRAO.'services/'.$method_service['txt_url_ser'].'/';


						$getdata = http_build_query(
						array(
						    'key' => $project_key,
						    'qtd' => 3,
						    'userid1' => $user_id,
						    'courseid' => $course_id,
						    'topics' => $topics
						 )
						);

						$opts = array('http' =>
						 array(
						    'method'  => 'GET',
						    'content' => $getdata,
						    'header' => "Content-Type: application/x-www-form-urlencoded"
						)
						);

						$context  = stream_context_create($opts);

						$retorno_service_method = file_get_contents($method_url, false, $context);
						// $retorno_service_method_test = file_get_contents($method_url.@$pretty, false, $context);
						$retorno_service_method_test = file_get_contents($method_url, false, $context);

					// }//if
					// else{

						*/

					$retorno_service_method = file_get_contents($method_url);
					// $retorno_service_method_test = file_get_contents($method_url.@$pretty);

					// }


					if( @$_GET['test']=='true' ){
						echo '<h5>'.$method_service['txt_title_ser'].'</h5>';
						echo $method_url.'<br />';
						// echo $method_service['txt_description_ser'].'<br />';
						echo $retorno_service_method;
						echo '<hr />';
					}
					// exit;
				}//if

				/**
				 * COLLABORATIVE FILTERING SERVICE - características deste usuário
				 * */
					//este pode procurar por avaliações feitas por este usuário. Caso não tenha, dai é partida frio.
					//caso tenha usa a filtragem deste projeto

					//DÁ PRA USAR DO ULTIMO SERVIÇO: LISTA COM 3 USUÁRIOS MAIS SIMILARES. 
					//DESTA FORMA PODE PROCURAR POR PREFERÊNCIAS DESTES 3 USUÁRIOS MAIS SIMILARES
				if($project['fk_cod_filtering_pro']!=0 && $project['fk_cod_filtering_pro'] != NULL ){
					$filtering_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_filtering_pro']." "));
					
					$retorno_service_method = json_decode($retorno_service_method);
					$user_id2 = $retorno_service_method[0]->userid2;
					$user_id3 = $retorno_service_method[1]->userid2;
					$user_id4 = $retorno_service_method[2]->userid2;

					$filtering_url = URL_PADRAO.'services/'.$filtering_service['txt_url_ser'].'/?key='.$project_key.'&userid1='.$user_id.'&userid2='.$user_id2.'&userid3='.$user_id3.'&userid4='.$user_id4;
					
					$retorno_service_filtering = file_get_contents($filtering_url);
					$retorno_service_filtering_test = file_get_contents($filtering_url.@$pretty);

					if( @$_GET['test']=='true' ){
						echo '<h5>'.$filtering_service['txt_title_ser'].'</h5>';
						echo $filtering_service['txt_description_ser'].'<br />';
						echo $retorno_service_filtering_test;
						echo '<hr />';
					}
					//exit;
				}//if



				/**
				 * REPOSITORY SERVICE - recursos aderentes às caracterísicas e preferências de usuários similares a este
				 * */
				if($project['fk_cod_repository_pro']!=0 && $project['fk_cod_repository_pro'] != NULL ){
					$repository_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_repository_pro']." "));

					//reetorno do service anterior
					$resources = json_decode($retorno_service_filtering);

					$repository_url = URL_PADRAO.'services/'.$repository_service['txt_url_ser'].'/?key='.$project_key;


					//retorna 10 vídeos do YOUTUBE
					//pensar em passar por parametro, nível do aluno
					$retorno_service_repository = file_get_contents($repository_url);
					$retorno_service_repository_test = file_get_contents($repository_url.@$pretty);
						

					if( @$_GET['test']=='true' ){
						echo '<h5>'.$repository_service['txt_title_ser'].'</h5>';
						echo $repository_service['txt_description_ser'].'<br />';
						echo $retorno_service_repository_test;
						// echo '<hr />';
					}

					/*
					if( @$_GET['pretty']=='true' ){
						echo '<pre>';
						echo json_encode( $retorno_service_repository, JSON_PRETTY_PRINT );
						echo '</pre>';
					} else {
						echo json_encode( $retorno_service_repository );
					}*/
				}//if

					

					
					/*if( @$_GET['test']=='true' ){
						echo '<h2><a href="#">REPOSITORY SERVICE</a> - retorna informações sobre os recursos selecionados no serviço anterior</h2>';
						echo $retorno_service_repository;
						echo '<hr />';
					}*/
					// exit;


					//RETORNO FINAL, que será utilizado na INTERFACE pro USUARIO
					// echo '{'.$retorno_service_repository.'}';




			} else{
				echo '[{"error": no user id}]';
			}


		}break;
		
		
		
		
		

		case 'getResourcesWordpress_20171021':{


			//este comando será chamado diretamente pelo MOODLE, por exemplo, para pegar recursos de acordo com o ID do usuário

			//ID ORIGINAL DO USUÁRIO
			

			//if( isset($_GET['userid']) && $_GET['userid']!='' ){

				//$user_id = $_GET['userid'];

				//$course_id = @$_GET['courseid'];

				//KEY DO PROJETO - $project_key;
				$project = sql_fetch_array(sql_select($conn,'recos_tb_projects',NULL,"txt_hash_pro = '".$project_key."' "));

				if( @$_GET['test']=='true' ){
					$pretty = '&pretty=true';
				}


				
				
				/**
				 * EUCLIDEAN METHOD SERVICE - Como calcula a similaridade entre usuários
				 * */
				if($project['fk_cod_method_pro']!=0 && $project['fk_cod_method_pro'] != NULL ){

					// echo 'entrou';

					$topics = urlencode(trim(@$_GET['topics']));
						
					$url_origem = @$_GET['url_origem'];
					$qtd = @$_GET['qtd'];

					$method_service = sql_fetch_array(sql_select($conn,'recos_tb_services',NULL,"pk_cod_service = ".$project['fk_cod_method_pro']." "));

					//assim eu USARIA o retorno do serviço anterior
					// $method_url = URL_PADRAO.'services/'.$method_service['txt_url_ser'].'/?key='.$project_key.'&pretty=true&qtd=3&profile='.json_decode($retorno_service_profiling).'&userid1='.$user_id;

					//deste jeito, passo direto o ID do user, logo não uso o retorno do serviço anterior.
					$method_url = URL_PADRAO.'services/'.$method_service['txt_url_ser'].'/?key='.$project_key.'&qtd='.$qtd.'&topics='.$topics.'&url_origem='.$url_origem;

					// exit($method_url);


					$retorno_service_method = file_get_contents($method_url);
					// $retorno_service_method_test = file_get_contents($method_url.@$pretty);

					// }

					//LOG
					// $dat_final_solicitacao_log = mktime( date('H'),date('i'),date('s'),date('m'),date('d'),date('Y') );
					$dat_final_solicitacao_log = date('Y-m-d H:i:s');
					sql_insert($conn,'recos_tb_log',' fk_cod_project_log, txt_descricao_log, dat_inicio_solicitacao_log, dat_final_solicitacao_log '," ".$project['pk_cod_project']." , 'REQUISICAO GETRESOURCESWORDPRESS_20171021' , '".$dat_inicio_solicitacao_log."' , '".$dat_final_solicitacao_log."' ");


					echo $retorno_service_method;


				}//if
				else {
					echo '[{"error": no method service selected}]';

				}



		}break;

		
		case 'resourceRedirect_20171021':{

			if( isset($_GET['resource_id']) ){

				$resource_id = $_GET['resource_id'];
				$url_origem = @$_GET['url_origem'];
				
				$conn = conectar();

				//pega dados do recurso
				$resource = sql_fetch_array(sql_select($conn,'recos_tb_service_repository',NULL,'pk_cod_repository = '.$resource_id, '*'));


				// echo '<pre>';
				// var_dump($resource);
				// echo '</pre>';

				//salva na tabela de STATS
				$fields_stats = ' fk_cod_repository_sta, txt_descricao_sta, txt_url_origem_sta';
				$values_stats = " ".$resource_id.", 'RECURSO CLICADO' , '".$url_origem."' ";

				sql_insert($conn,_TABLE_STATS,$fields_stats,$values_stats);

				//redireciona ao recurso, ou abre ele com um modal, por exemplo
				redireciona( $resource['txt_url_rep'] );


				/*

				if( tipo == video && embed == true){
					//dai faz EMBED do vídeo. Mas assim é mais dificil verificar se clicou ou não

				}

				*/


			} else {
				echo '[{"error": no resource id}]';
			}

		}break;

		
		case 'resourceReject_20171021':{

			if( isset($_GET['resource_id']) ){

				$resource_id = $_GET['resource_id'];
				$url_origem = @$_GET['url_origem'];
				
				$conn = conectar();

				//pega dados do recurso
				$resource = sql_fetch_array(sql_select($conn,'recos_tb_service_repository',NULL,'pk_cod_repository = '.$resource_id, '*'));


				// echo '<pre>';
				// var_dump($resource);
				// echo '</pre>';

				//salva na tabela de STATS
				$fields_stats = ' fk_cod_repository_sta, txt_descricao_sta, txt_url_origem_sta';
				$values_stats = " ".$resource_id.", 'RECURSO REJEITADO' , '".$url_origem."' ";

				sql_insert($conn,_TABLE_STATS,$fields_stats,$values_stats);

				//redireciona ao recurso, ou abre ele com um modal, por exemplo
				// redireciona( $resource['txt_url_rep'] );


				//agora tem que fazer alguma coisa
				echo 'ok';


			} else {
				echo '[{"error": no resource id}]';
			}

		}break;



	}


}//if


?>