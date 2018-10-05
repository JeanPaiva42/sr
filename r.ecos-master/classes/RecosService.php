<?php
//relative path nao ta funcionando na minha maquina
require_once(realpath(dirname(__FILE__) . '/..') . '/config/inc.config.php');

require_once(realpath(dirname(__FILE__) . '/..') . '/config/inc.functions.php');

class RecosService{

	//token de segurança para acessar este serviço
	public $__token;
	//id deste projeto no banco de dados
	public $__idProject;
	//conexão com o banco de dados
	public $__conn;
	//decide se o retorno será em json_pretty ou não
	public $__pretty;
	//dados de entrada para este serviço
	public $__dataInput;
	//dados de saída para este serviço
	public $__dataOutput;


	function __construct(){

		//cria conexão com o banco de dados
		$this->__conn = conectar();

		//define o retorno em JSON. Caso seja TRUE, mostra ela mais bonito.
		$this->__pretty = false;

	}





	function checkToken(){

		// echo 'Verificando TOKEN deste serviço. <br />';

		//information about this project
		// var_dump($this->__conn);

		if( $this->__conn != NULL ){
			$aux = sql_select($this->__conn,'recos_tb_projects',NULL,'txt_hash_pro = \''.$this->__token.'\' ');
		} else {
			// echo '<br />--ERRO DE CONEXAO: '.'txt_hash_pro = \''.$this->__token.'\' ';
			$conn = conectar();
			$aux = sql_select($conn,'recos_tb_projects',NULL,'txt_hash_pro = \''.$this->__token.'\' ');
			// var_dump($aux);
			// return false;
		}

		 //echo $aux;
		// echo '123';

		if( sql_num_rows($aux) == 0 ){

			// echo 'retorno false';

			// echo '[{"error": token invalid}]';
			return false;

		} else {

			// echo 'retorno true';

			$project = sql_fetch_array($aux);
			$this->__idProject = $project['pk_cod_project'];

			// echo '[{"status": token ok}]';
			return true;

		}//else


	}//function








}//class


?>
