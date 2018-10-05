<?php

/*
 * Funcao que monta a consulta SQL a ser realizada no banco de dados da aplicacao.callable
 *
 * @conn conexao com o banco de dados
 * @table tabela a ser utilizada na consulta
 * @order opcional. caso queira ordenar a consulta
 * @where opcional. caso queira filtrar a consulta
 * @campos opcional. caso queira selecionar campos, diferente do * (todos)
 * @limit opcional. caso queira limitar a consulta
 *
 */
function sql_select($conn, $table, $order = null, $where = null, $campos = null, $limit = null, $groupby = null, $having = null, $banco = "MYSQL" ) {

    //se nao quiser SELECT * FROM, passa como parametro
    if ($campos != null) {
        $campos = $campos;
    }
    else{
        $campos = " * ";
    }

    //ORDER
    if ($order != null) {
        $order = "ORDER BY " . $order;
    }
    else{
        $order = "";
    }

    //HAVING
    if ($having != null) {
        $having = "HAVING " . $having;
    }
    else{
        $having = "";
    }

    //WHERE
    if ($where != null) {
        $where = "WHERE " . $where;
    }
    else{
        $where = "";
    }

    //GROUPBY
    if ($groupby != null) {
        $groupby = "GROUP BY " . $groupby;
    }
    else
        $groupby = "";


    //LIMIT
    if ($limit != null) {
        $limit = "LIMIT " . $limit;
    }
    else
        $limit = "";



    $query = "
        SELECT
            " . $campos . "
        FROM
            " . $table . "
            " . $where . "
            " . $groupby . "
            " . $having . "
            " . $order . "
            " . $limit . "";

    //exit($query);
    // echo '<br /><pre>
    // '.$query.'
    // </pre>';

    /*   if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
      }
     */

    if (_DEBUG == true) {
        echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    if ($banco == "MYSQL") {

        $result = @mysqli_query($conn, $query) or die(@mysqli_error($conn).' >> '.$query);
    } 

    return $result;
}



/**
 * Monta a query para insercao no banco de dados da aplicacao.
 *
 * @conn conexao com o banco de dados
 * @table tabela a ser utilizada na insercao
 * @campos campos da tabela
 * @values valores dos campos da tabela
 *
 */
function sql_insert($conn, $table, $fields, $values) {

    $query = "
        INSERT INTO
            " . $table ."
            (".$fields.")
        VALUES
            (".$values.") ;";


    if(_DEBUG==true){
        echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn).": ".$query);
    //echo " >>> ".$query."<br /><br />";

    if(_LOG==true && TABELA_LOG!=NULL ){
        criar_log($conn, $query, TABELA_LOG);
    }

    return $result;

}



/**
 * Monta a query para insercao no banco de dados da aplicacao, através de um select
 *
 * @conn conexao com o banco de dados
 * @table tabela a ser utilizada na insercao
 * @campos campos da tabela
 * @values valores dos campos da tabela
 *
 */
function sql_insert_select($conn, $table, $fields, $select) {

    $query = "
        INSERT INTO
            " . $table ."
            (".$fields.")

            ".$select." ";


    if(_DEBUG==true){
        echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    //echo " >>> ".$query;

    if(_LOG==true && TABELA_LOG!=NULL ){
        criar_log($conn, $query, TABELA_LOG);
    }

    return $result;

}



/**
 * Monta a query para atualizadao de registros no banco de dados da aplicacao.
 *
 * @conn conexao com o banco de dados
 * @table tabela a ser utilizada na insercao
 * @values valores dos campos da tabela
 *
 */
function sql_update($conn, $table, $values, $where) {

    $query = "
        UPDATE
            " . $table ."
        SET
            ".$values."
        WHERE
            ".$where." ";

    if(_DEBUG==true){
        echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if(_LOG==true && TABELA_LOG!=NULL ){
        criar_log($conn, $query, TABELA_LOG);
    }

    return $result;

}



/**
 * Monta a query para exclusao de um registro no banco de dados da aplicacao.
 *
 * @conn conexao com o banco de dados
 * @table tabela a ser utilizada na insercao
 * @values valores dos campos da tabela
 *
 */
function sql_delete($conn, $table, $where) {

    $query = "
        DELETE FROM
            " . $table ."
        WHERE
            ".$where." ";

            //exit($query);

    if(_DEBUG==true){
        echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if(_LOG==true && TABELA_LOG!=NULL ){
        criar_log($conn, $query, TABELA_LOG);
    }

    return $result;

}



/**
 * Retorna array de registros, de acordo com o RESULT passado
 *
 *
 * @conn conexao com o banco de dados
 * @table tabela a ser utilizada na insercao
 * @values valores dos campos da tabela
 *
 */
function sql_fetch_array($result,$conn=NULL) {


    if(_DEBUG==true){
    //    echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    $result = mysqli_fetch_array($result);

    if(_LOG==true){
        //criar_log($conn, $query);
    }

    return $result;

}

function sql_fetch_assoc($result,$conn=NULL) {


    if(_DEBUG==true){
    //    echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    $result = mysqli_fetch_assoc($result);

    if(_LOG==true){
        //criar_log($conn, $query);
    }

    return $result;

}



/**
 * Retorna array de registros, de acordo com o RESULT passado
 * INCOMPLETA AINDA!
 *
 * @conn conexao com o banco de dados
 * @table tabela a ser utilizada na insercao
 * @values valores dos campos da tabela
 *
 */
function sql_num_rows($result,$conn=NULL) {


    if(_DEBUG==true){
        //echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $query . '</div>';
    }

    //$result = mysqli_num_rows($result) or die(mysqli_error($conn));
    $result = mysqli_num_rows($result);

    if(_LOG==true){
        //criar_log($conn, $query);
    }

    return $result;

}




/*
 * Verifica se usuario esta logado no sistema.
 * Caso nao esteja, redireciona ele para a pagina inicial.
 *
 */
function verifica_logado() {

    if (@$_SESSION['usuario_logado'] == false) {

        print '<script>window.location = "index.php";</script>';
    }
}





/**
 * Verifica se o usuário pode logar no sistema
 *
 */
function verifica_login($conn, $usuario, $senha){


        //$acao = $_POST['acao'];

        //if ($acao == "logar") {

            //$usuario = $_POST["usuario"];
            //$senha = $_POST["senha"];

            $query = "
                SELECT * FROM "._TABELA_USUARIOS_."
                WHERE txt_usuario_usu = '" . $usuario . "'
                AND txt_senha_usu = '" . $senha . "' LIMIT 1
                    ";

            $result = mysqli_query($conn,$query) or die(mysqli_error($conn));

            $quantidade = mysqli_num_rows($result);

                //INFORMAÇÕES PARA O LOG
                $fields = "
                            txt_usuario_log,
                            txt_query_log
                            ";

                $values = "
                            '".$usuario."',";

            if ($quantidade > 0) {

                //logou corretamente
                $aux_log = sql_insert($conn,_TABELA_LOG_,$fields,$values."'USUARIO LOGOU'");

                $registros = mysqli_fetch_array($result);

                $_SESSION["usuario_logado"] = true;
                $_SESSION["tipo_usuario"] = $registros['int_tipo_usu'];
                $_SESSION["cod_usuario"] = $registros['pk_cod_usuario'];
                $_SESSION["nome_usuario"] = $registros['txt_nome_usu'];
                $_SESSION["email_usuario"] = $registros['txt_email_usu'];
                $_SESSION["usuario_usuario"] = $registros['txt_usuario_usu'];

                redireciona("index.php");



            } else {

                //NÃO logou
                $aux_log = sql_insert($conn,_TABELA_LOG_, $fields,$values."'USUARIO NAO LOGOU'");


                //MENSAGEM DE USUARIO INVALIDO
                return '
  <div class="alert alert-danger">
    <strong>ERRO!</strong><br />
    Nome de usu&aacute;rio ou senha inv&aacute;lidos
  </div>
                ';
            }//else

        //}//acao=logar

}




/*
 * Verifica se usuario eh administrador.
 * Caso nao seja, redireciona ele para o painel inicial.
 *
 */
function verifica_admin() {

    if ( @$_SESSION['tipo_usuario'] == 3 ) {


        print utf8_encode("<script> alert('NAO PERMITIDO'); window.location = 'index.php';</script>");
    }
}




/*
 * Verifica se usuario esta logado no sistema.
 * Caso nao esteja, redireciona ele para a pagina inicial.
 *
 */
function redireciona($url,$mensagem=null) {

        if($mensagem!=null){
            //$url = $url."msg/".$mensagem."/";
            $url = $url."&msg=".$mensagem."";
        }


        print '<script>window.location = "'.$url.'";</script>';


}




/**
 * Armazena todas opera��es realizadas no sistema.
 * @sql query que foi realizada
 *
 */
function criar_log($conn,$sql,$table="tb_log"){

    //data da operacao
    $hoje = date("Y-m-d H:i:s");

    // if(isset($_SESSION['cod_usuario'])){
        // $cod_usuario = $_SESSION['cod_usuario'];
    // } else $cod_usuario = 0;

    $q = "
        INSERT INTO
            ".$table."
            (
            dat_operacao_log,
            txt_query_log,
            txt_usuario_log
            )
        VALUES
            (
            '".$hoje."',
            '".addslashes(trim($sql))."',
            '".$_SESSION['usuario_usuario']."'
            ) ";


    if(_DEBUG==true){
        echo '<div style="z-index:100; color:red; background:#F4F4F4; border:solid 1px #E1E1E1; position:fixed; float:right; padding:10px; bottom:0; right:10px;">' . $q . '</div>';
    }

    $result = mysqli_query($conn, $q) or die(mysqli_error($conn));

    //EXIT($q);
    //return $result;


}





/*
 * FUNCAO PARA ENVIO DE EMAIL PELO SISTEMA, UTILIZANDO PHPMAILER
 *
 */

/*require 'assets/PHPMailer-master/PHPMailerAutoload.php';
function envia_email_phpmailer($para,$msg,$assunto,$noreply=false){


	$mail = new PHPMailer();

    $mail->isSMTP();                                      // Set mailer to use SMTP
    //$mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup server
	$mail->Mailer = "smtp";
	$mail->Host = MAIL_HOST;
	$mail->Port = MAIL_PORT;//465 // 25
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = MAIL_CONTA;                            // SMTP username
    $mail->Password = MAIL_SENHA;                           // SMTP password
    //$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted

    $mail->From = MAIL_CONTA;
    $mail->FromName = MAIL_NOME;
    $mail->addAddress($para,$para);  // Add a recipient


    $mail->WordWrap = 50;                                 // Set word wrap to 50 character
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $assunto;
    $mail->Body    = $msg;
    $mail->AltBody = $msg;


    if(!$mail->send()) {
        //echo "Message could not be sent. <p>";
        //echo "Mailer Error: " . $mail->ErrorInfo;
        //echo MAIL_HOST.'::'.MAIL_CONTA;
        return false;
    }

    return true;



}
*/



function formata_data($data, $formato='br', $mostra_hora=false) {

    if($data=="" || $data==NULL){

        return null;

    }

    if($mostra_hora==true){
        $complemento_hora = " - ".substr($data, 11, 5);
    } else $complemento_hora = " ";

    switch ($formato) {

        case 'br': {

                return substr($data, 8, 2) . '/' . substr($data, 5, 2) . '/' . substr($data, 0, 4).$complemento_hora;
            }break;

        case 'en': {

                return substr($data, 6, 4) . '-' . substr($data, 3, 2) . '-' . substr($data, 0, 2).$complemento_hora;
            }break;
    }
}








function remove_acentuacao($value){

        $value = strtolower($value);

        $from = "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ";
        $to = "aaaaeeiooouucAAAAEEIOOOUUC-";

        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        $value = strtr($value, $mapping);

        $value = strtolower($value);

        return $value;

}




/*
function google_analytics(){

    print "

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-43060010-1', 'auto');
      ga('send', 'pageview');

    </script>

        ";
}

google_analytics();
*/









function mes_extenso($mes){

    switch($mes){


        case 1: {
            return 'Janeiro';
        } break;
        case 2: {
            return 'Fevereiro';
        } break;
        case 3: {
            return 'Março';
        } break;
        case 4: {
            return 'Abril';
        } break;
        case 5: {
            return 'Maio';
        } break;
        case 6: {
            return 'Junho';
        } break;
        case 7: {
            return 'Julho';
        } break;
        case 8: {
            return 'Agosto';
        } break;
        case 9: {
            return 'Setembro';
        } break;
        case 10: {
            return 'Outubro';
        } break;
        case 11: {
            return 'Novembro';
        } break;
        case 12: {
            return 'Dezembro';
        } break;


    }

}

function dia_da_semana($data, $abreviacao = false){

    if($abreviacao){
        // Array com os dias da semana
        $diasemana = array('DOM', 'SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SÁB');
    } else {
        // Array com os dias da semana
        $diasemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
    }

    // Aqui podemos usar a data atual ou qualquer outra data no formato Ano-mês-dia (2014-02-28)
    //$data = date('Y-m-d');

    // Varivel que recebe o dia da semana (0 = Domingo, 1 = Segunda ...)
    $diasemana_numero = date('w', strtotime($data));

    // Exibe o dia da semana com o Array
    return $diasemana[$diasemana_numero];
}




function cria_select($tabela, $descricao, $pk, $label, $value=NULL, $name=NULL){

    $conn = conectar();

    if($tabela=="cidade"){
        $aux_filtro = sql_select($conn,$tabela.' c INNER JOIN estado e ON (c.estado=e.id)','uf ASC, c.nome ASC',NULL,'*, c.id AS cidade_id, e.uf AS sigla, c.nome AS cidade_nome');
    } else {
        $aux_filtro = sql_select($conn,$tabela,$descricao,NULL,'*');
    }

    if($name==NULL){
        $id_name = $tabela;
    } else {
        $id_name = $name;
    }



    $retorno .= '
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label filtro_agrupa" >
        <select  id="'.$id_name.'" class="mdl-textfield__input filtro_input" name="'.$id_name.'" >
            <option value="#"></option>';

        while($filtro = sql_fetch_array($aux_filtro)){

            if($tabela=="cidade"){
                $desc = ($filtro['sigla']).'/'.utf8_encode($filtro['cidade_nome']);
            } else {
                $desc = $filtro[$descricao];
            }

            $retorno .= '<option ';
            if( ($value!=NULL) && ($value==$filtro[$pk]) ){
                $retorno .= ' selected ';
            }
            $retorno .= ' value="'.$filtro[$pk].'">'.$desc.'</option>';
        }

    $retorno .= '
        </select>
        <label class="mdl-textfield__label filtro_label" for="" >
            '.$label.'
        </label>
    </div>
    ';

    return $retorno;

}





/**
 * Fonte: https://github.com/asimlqt/Euclidean-Distance-Score/blob/master/recommendation.php
 * @param type $prefs 
 * @param type $person1 
 * @param type $person2 
 * @return type
 */
// function euclidean_distance_score($prefs, $person1, $person2) {
function euclidean_distance_score($prefs, $person1, $person2) {

    /*$reviews = array(
        'Tania Diede' => array(
            'The Mozart Conspiracy' => 3.0,
            'The Cross (Vampire Federation 2)' => 3.5,
            'The Doomsday Prophecy' => 3.0,
            'The Lost Symbol' => 4.5,
            'The Da Vinci Code' => 5.0
        ),
        'Allan Rhein' => array(
            'The Mozart Conspiracy' => 1.5,
            'The Cross (Vampire Federation 2)' => 4.0,
            'The Doomsday Prophecy' => 1.0,
            'The Lost Symbol' => 4.5,
            'The Da Vinci Code' => 4.0
        ),
        'Lorrie Schisler' => array(
            'The Mozart Conspiracy' => 1.0,
            'The Cross (Vampire Federation 2)' => 2.5,
            'The Doomsday Prophecy' => 3.0,
            'The Lost Symbol' => 3.5,
            'The Da Vinci Code' => 3.0
        ),
        'Dollie Massengill' => array(
            'The Mozart Conspiracy' => 2.0,
            'The Doomsday Prophecy' => 3.0,
            'The Lost Symbol' => 3.5,
            'The Da Vinci Code' => 3.0
        )
    );

    echo '<pre>';
    print_r($reviews);
    echo '</pre>';
    */

    //ajustando o array $prefs
    $prefs = array( $prefs[0][$person1] , $prefs[1][$person2] );

    /*
    echo '<pre>';
    echo '<hr /> Array Prefs: ';
    print_r( $prefs);
    // echo '<hr /> Array User 1: ';
    // print_r( $prefs[0][$person1]);
    // echo '<hr /> Array User 2: ';
    // print_r( $prefs[1][$person2]);
    echo '<hr />';
    echo '</pre>';
    */


    // if(!array_key_exists($person1, $prefs) || !array_key_exists($person2, $prefs))
    if(!array_key_exists(0, $prefs) || !array_key_exists(1, $prefs))
        return 0;
    
    // if(count(array_intersect_key($prefs[$person1], $prefs[$person2])) === 0) 
    if(count(array_intersect_key($prefs[0], $prefs[1])) === 0) 
        return 0;
    
    $sumOfSquares = 0;

    // foreach($prefs[$person1] as $item => $value) {
    foreach($prefs[0] as $item => $value) {

        // echo '>> '.$value.' <<';
        // if(array_key_exists($item, $prefs[$person2])) {
        if(array_key_exists($item, $prefs[1])) {
            // $sumOfSquares += pow($value - $prefs[$person2][$item], 2);
            $sumOfSquares += pow($value - $prefs[1][$item], 2);

            // echo $sumOfSquares.' -- ';
        }//if

    }//foreach

    //original
    // return 1/(1+$sumOfSquares);

    if( $sumOfSquares == 0 ){
        return 1;
    } else {
        return 1/sqrt($sumOfSquares);
    }
    // return 1/sqrt($sumOfSquares);

}
/*
// Example
$reviews = array(
    'Tania Diede' => array(
        'The Mozart Conspiracy' => 3.0,
        'The Cross (Vampire Federation 2)' => 3.5,
        'The Doomsday Prophecy' => 3.0,
        'The Lost Symbol' => 4.5,
        'The Da Vinci Code' => 5.0
    ),
    'Allan Rhein' => array(
        'The Mozart Conspiracy' => 1.5,
        'The Cross (Vampire Federation 2)' => 4.0,
        'The Doomsday Prophecy' => 1.0,
        'The Lost Symbol' => 4.5,
        'The Da Vinci Code' => 4.0
    ),
    'Lorrie Schisler' => array(
        'The Mozart Conspiracy' => 1.0,
        'The Cross (Vampire Federation 2)' => 2.5,
        'The Doomsday Prophecy' => 3.0,
        'The Lost Symbol' => 3.5,
        'The Da Vinci Code' => 3.0
    ),
    'Dollie Massengill' => array(
        'The Mozart Conspiracy' => 2.0,
        'The Doomsday Prophecy' => 3.0,
        'The Lost Symbol' => 3.5,
        'The Da Vinci Code' => 3.0
    )
);
echo euclidean_distance_score($reviews, 'Tania Diede', 'Allan Rhein');
 */


function record_sort($records, $field, $reverse=false){

    $hash = array();
    
    foreach($records as $key => $record){
        $hash[$record[$field].$key] = $record;
    }
    
    ($reverse)? krsort($hash) : ksort($hash);
    
    $records = array();
    
    foreach($hash as $record){
        $records []= $record;
    }
    
    return $records;
}





/**
* Função remove stopwords de uma string e retorna a string sem as stopwords 
*/
function clear($string){
  //lista de stopwords
    $stopwords = array("nesta", " nesta "," de "," a "," o "," que "," e "," do "," da "," em "," um "," para "," é "," com "," não "," uma "," os "," no "," se "," na "," por "," mais "," as "," dos "," como",
    " mas "," foi "," ao "," ele "," das "," tem "," à "," seu "," sua "," ou "," ser "," quando "," muito "," há "," nos "," já "," está "," eu "," também "," só "," pelo "," pela "," até "," isso "," ela",
    " entre "," era "," depois "," sem "," mesmo "," aos "," ter "," seus "," quem "," nas "," me "," esse "," eles "," estão "," você "," tinha "," foram "," essa "," num "," nem "," suas "," meu "," às",
    " minha "," têm "," numa "," pelos "," elas "," havia "," seja "," qual "," será "," nós "," tenho "," lhe "," deles "," essas "," esses "," pelas "," este "," fosse "," dele "," tu "," te "," vocês",
    " vos "," lhes "," meus "," minhas "," teu "," tua "," teus "," tuas "," nosso "," nossa "," nossos "," nossas "," dela "," delas "," esta "," estes "," estas "," aquele "," aquela "," aqueles",
    " aquelas "," isto "," aquilo "," estou "," está "," estamos "," estão "," estive "," esteve "," estivemos "," estiveram "," estava "," estávamos "," estavam "," estivera",
    " estivéramos "," esteja "," estejamos "," estejam "," estivesse "," estivéssemos "," estivessem "," estiver "," estivermos "," estiverem "," hei "," há "," havemos "," hão "," houve",
    " houvemos "," houveram "," houvera "," houvéramos "," haja "," hajamos "," hajam "," houvesse "," houvéssemos "," houvessem "," houver "," houvermos "," houverem", "grande", "extra", "pretas",
    " houverei "," houverá "," houveremos "," houverão "," houveria "," houveríamos "," houveriam "," sou "," somos "," são "," era "," éramos "," eram "," fui "," foi", "polpa", "porç", "preta",
    " fomos "," foram "," fora "," fôramos "," seja "," sejamos "," sejam "," fosse "," fôssemos "," fossem "," for "," formos "," forem "," serei "," será "," seremos", "ralad", "madur", "sement",
    " serão "," seria "," seríamos "," seriam "," tenho "," tem "," temos "," tém "," tinha "," tínhamos "," tinham "," tive "," teve "," tivemos "," tiveram "," tivera", "sopa", "suco", "moida", "moída",
    " tivéramos "," tenha "," tenhamos "," tenham "," tivesse "," tivéssemos "," tivessem "," tiver "," tivermos "," tiverem "," terei "," terá "," teremos "," terão "," teria "," teríamos ", "virgem", "junt",
    " teriam");

  //substitui todas as stopwords por espaço simples
    $r = str_ireplace($stopwords, " ", $string);
  //remover todos os espaços repetidos e retorna a string
  return preg_replace('/\s+/', ' ',$r);
}

?>
