<?
require_once('inc.header.php');
?>



<?

if( isset($_SESSION['user_loged']) && $_SESSION['user_loged'] == true ){

    // var_dump($_SESSION);

    ?>



    <?
    require_once('inc.menu.php');
    ?>






            
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">

                    <h3>My Projects</h3>
                    <?

                    //lista projetos deste usuario
                    $conn = conectar();

                    $table = 'recos_tb_projects
                    LEFT JOIN recos_tb_services s1 ON (fk_cod_filtering_pro = s1.pk_cod_service)
                    LEFT JOIN recos_tb_services s2 ON (fk_cod_method_pro = s2.pk_cod_service)
                    LEFT JOIN recos_tb_services s3 ON (fk_cod_profiling_pro = s3.pk_cod_service)
                    LEFT JOIN recos_tb_services s4 ON (fk_cod_repository_pro = s4.pk_cod_service)
                    ';
                    $order = 'txt_title_pro';
                    $where = 'fk_cod_user_pro = '.$_SESSION['user_cod']; //1 é o codigo do usuario de testes
                    $fields = '*
                    , s1.txt_title_ser AS s1_title
                    , s2.txt_title_ser AS s2_title
                    , s3.txt_title_ser AS s3_title
                    , s4.txt_title_ser AS s4_title
                    , s1.txt_url_ser AS s1_url
                    , s2.txt_url_ser AS s2_url
                    , s3.txt_url_ser AS s3_url
                    , s4.txt_url_ser AS s4_url
                    ';

                    $aux_projetos = sql_select($conn,$table,$order,$where,$fields);

                    if( sql_num_rows($aux_projetos)>0 ){

                        echo '
                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">Project Title</th>

                                    <th class="mdl-data-table__cell--non-numeric">Services</th>
                                    
                                    <!--<th class="mdl-data-table__cell--non-numeric">Profiling</th>
                                    <th class="mdl-data-table__cell--non-numeric">Filtering</th>
                                    <th class="mdl-data-table__cell--non-numeric">Method</th>
                                    <th class="mdl-data-table__cell--non-numeric">Repository</th>-->

                                    <th>stats</th>
                                    <th>edit</th>
                                    <!--<th>delete</th>-->
                                    
                                </tr>
                            </thead>
                            <tbody>
                        ';


                        while($projetos = sql_fetch_array($aux_projetos)){

                            echo '
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <b>'.$projetos['txt_title_pro'].'</b><br />
                                        <small>key: '.@$projetos['txt_hash_pro'].'</small><br />
                                        <br />
                                        <!--<a href="'.URL_PADRAO.'api/v0.2/data.php?action=getResources&userid=1&key='.@$projetos['txt_hash_pro'].'">getResources</a>-->
                                        Link para retornar os recursos: <Br />
                                        <b>'.URL_PADRAO.'api/v0.2/data.php?action=getResources&key='.@$projetos['txt_hash_pro'].'&userid=99999</b> <br />
                                        <small>lembrando que deve ser passado o identificador do usuário que está solicitando os recursos</small>

                                    </td>
                                    

                            <!-- USER ID 10 é do Moodle no localhost -->

                                    <td class="mdl-data-table__cell--non-numeric">

                                        
                                            '.@$projetos['s2_title'].'
                                        
                                        <br />

                                            '.@$projetos['s3_title'].'
                                        <br />

                                            '.@$projetos['s1_title'].'
                                        <br />

                                            '.@$projetos['s4_title'].'

                                    </td>

                                    <!--
                                    <td class="mdl-data-table__cell--non-numeric">
                                        '.@$projetos['s3_title'].'
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        '.@$projetos['s1_title'].'
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        '.@$projetos['s2_title'].'
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        '.@$projetos['s4_title'].'
                                    </td>
                                    -->

                                    <td>
                                        <a href="stats.php?h='.@$projetos['txt_hash_pro'].'">
                                            <i class="material-icons">timeline</i>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="#">
                                            <i class="material-icons">mode_edit</i>
                                        </a>
                                    </td>

                                    <!--<td>
                                        <a href="#">
                                            <i class="material-icons">delete</i>
                                        </a>
                                    </td>-->
                                </tr>


                                <tr style="display:none;">
                                    <td colspan="4" style="text-align:left; ">
                                        <h4>Tests</h4>

                                        ';

                                        echo URL_PADRAO.'services/'.@$projetos['s2_url'].'/?userid1=10&key='.@$projetos['txt_hash_pro'].'&pretty=true'.'<br />';
                                        echo file_get_contents(URL_PADRAO.'services/'.@$projetos['s2_url'].'/?userid1=10&key='.@$projetos['txt_hash_pro'].'&pretty=true');
                                        echo '<hr /><br /><Br />';

                                        echo URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=10&key='.@$projetos['txt_hash_pro'].'&pretty=true'.'<br />';
                                        echo file_get_contents(URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=10&key='.@$projetos['txt_hash_pro'].'&pretty=true');
                                        echo '<br />';
                                        echo URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=9&key='.@$projetos['txt_hash_pro'].'&pretty=true'.'<br />';
                                        echo file_get_contents(URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=9&key='.@$projetos['txt_hash_pro'].'&pretty=true');
                                        echo '<br />';
                                        echo URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=8&key='.@$projetos['txt_hash_pro'].'&pretty=true'.'<br />';
                                        echo file_get_contents(URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=8&key='.@$projetos['txt_hash_pro'].'&pretty=true');
                                        echo '<br />';
                                        echo URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=7&key='.@$projetos['txt_hash_pro'].'&pretty=true'.'<br />';
                                        echo file_get_contents(URL_PADRAO.'services/'.@$projetos['s3_url'].'/?userid=7&key='.@$projetos['txt_hash_pro'].'&pretty=true');
                                        echo '<hr /><br /><Br />';

                                        echo URL_PADRAO.'services/'.@$projetos['s1_url'].'/?userid1=10&userid2=9&userid3=8&userid4=7&key='.@$projetos['txt_hash_pro'].'&pretty=true'.'<br />';
                                        echo file_get_contents(URL_PADRAO.'services/'.@$projetos['s1_url'].'/?userid1=10&userid2=9&userid3=8&userid4=7&key='.@$projetos['txt_hash_pro'].'&pretty=true');
                                        echo '<hr /><br /><Br />';

                                        echo URL_PADRAO.'services/'.@$projetos['s4_url'].'/?key='.@$projetos['txt_hash_pro'].'&pretty=true'.'<br />';
                                        echo file_get_contents(URL_PADRAO.'services/'.@$projetos['s4_url'].'/?key='.@$projetos['txt_hash_pro'].'&pretty=true');
                                        echo '<hr /><br /><Br />';

                            echo '

                                        <h4>getResources</h4>

                                        ';

                                        echo URL_PADRAO.'api/v0.1/data.php?action=getResources&userid=10&key='.@$projetos['txt_hash_pro'].'<br />';
                                        echo file_get_contents(URL_PADRAO.'api/v0.1/data.php?action=getResources&userid=10&key='.@$projetos['txt_hash_pro'].'&test=true&pretty=true');
                                        echo '<hr /><br /><Br />';


                            echo '

                                    </td>
                                </tr>
                            ';

                            ?>




                            <!--

                            //loop inside project
                            
                            /* USERS */
                            $table_users = 'recos_tb_client_users';
                            $order_users = '';
                            $where_users = 'fk_cod_project_cli = '.$projetos['pk_cod_project'];
                            $fields_users = '*';
                            $aux_users = sql_select($conn,$table_users,$order_users,$where_users,$fields_users);

                            if( sql_num_rows($aux_users)>0 ){



                                echo '

                        <tr>
                            <td class="mdl-data-table__cell--non-numeric" colspan="7">

                                <h5>
                                    <a href="#" onclick="$(\'#clients_'.$projetos['pk_cod_project'].'\').toggle();">GET /users</a>
                                </h5>

                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id="clients_'.$projetos['pk_cod_project'].'" style="display:none; width:100%;">
                                    <thead style="display:none;">
                                        <tr >
                                            <th class="mdl-data-table__cell--non-numeric">Original ID</th>

                                            <th class="mdl-data-table__cell--non-numeric">Name</th>
                                            <th class="mdl-data-table__cell--non-numeric">Email</th>
                                            <th>edit</th>
                                            <th>delete</th>
                                            
                                        </tr>
                                    </thead>

                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric" colspan="5">
                                            <small>
                                            (api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getUsersList) 
                                            <pre>
                                            '.file_get_contents(URL_PADRAO.'api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getUsersList').'
                                            </pre>
                                            </small>
                                        </th>
                                        
                                    </tr>

                                    <tbody>
                                ';

                                while($users = sql_fetch_array($aux_users) ){

                                    echo '
                                    <tr style="display:none;">
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$users['int_original_id_cli'].'
                                        </td>
                                        
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$users['txt_name_cli'].'
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$users['txt_email_cli'].'
                                        </td>
                                        
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">mode_edit</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    ';

                                }//while users

                                echo '
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                                ';

                            }//if







                            /* ACTIVITIES */
                            $table_activities = 'recos_tb_service_vle_activities';
                            $order_activities = '';
                            $where_activities = 'fk_cod_project_act = '.$projetos['pk_cod_project'];
                            $fields_activities = '*';
                            $aux_activities = sql_select($conn,$table_activities,$order_activities,$where_activities,$fields_activities);

                            if( sql_num_rows($aux_activities)>0 ){



                                echo '

                        <tr>
                            <td class="mdl-data-table__cell--non-numeric" colspan="7">

                                <h5>
                                    <a href="#" onclick="$(\'#activities_'.$projetos['pk_cod_project'].'\').toggle();">GET /activities</a>
                                </h5>

                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id="activities_'.$projetos['pk_cod_project'].'" style="display:none; width:100%;">
                                    <thead style="display:none;">
                                        <tr >
                                            <th class="mdl-data-table__cell--non-numeric">Original ID</th>

                                            <th class="mdl-data-table__cell--non-numeric">Name</th>
                                            <th>edit</th>
                                            <th>delete</th>
                                            
                                        </tr>
                                    </thead>

                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric" colspan="5">
                                            <small>
                                            (api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getActivitiesList) 
                                            <pre>
                                            '.file_get_contents(URL_PADRAO.'api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getActivitiesList').'
                                            </pre>
                                            </small>
                                        </th>
                                        
                                    </tr>

                                    <tbody>
                                ';

                                while($activities = sql_fetch_array($aux_activities) ){

                                    echo '
                                    <tr style="display:none;">
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$users['int_original_id_cli'].'
                                        </td>
                                        
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$users['txt_name_cli'].'
                                        </td>
                                        
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">mode_edit</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    ';

                                }//while activities

                                echo '
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                                ';

                            }//if







                            /* GRADES */
                            $table_grades = 'recos_tb_service_vle_grades
                            INNER JOIN recos_tb_service_vle_activities ON (fk_cod_activity_gra = pk_cod_activity)
                            INNER JOIN recos_tb_client_users ON (fk_cod_client_user_gra = pk_cod_client_user)
                            ';
                            $order_grades = '';
                            $where_grades = 'fk_cod_project_cli = '.$projetos['pk_cod_project'];
                            $fields_grades = '*';
                            $aux_grades = sql_select($conn,$table_grades,$order_grades,$where_grades,$fields_grades);

                            if( sql_num_rows($aux_grades)>0 ){



                                echo '

                        <tr>
                            <td class="mdl-data-table__cell--non-numeric" colspan="7">

                                <h5>
                                    <a href="#" onclick="$(\'#grades_'.$projetos['pk_cod_project'].'\').toggle();">GET /grades</a>
                                </h5>

                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id="grades_'.$projetos['pk_cod_project'].'" style="display:none; width:100%;">
                                    

                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric" colspan="5">
                                            <small>
                                            (api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getGradesList) 
                                            <pre>
                                            '.file_get_contents(URL_PADRAO.'api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getGradesList').'
                                            </pre>
                                            </small>
                                        </th>
                                        
                                    </tr>

                                    <tbody>
                                ';

                                while($grades = sql_fetch_array($aux_grades) ){

                                    /*echo '
                                    <tr style="display:none;">
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$grades['int_original_id_cli'].'
                                        </td>
                                        
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$grades['txt_name_cli'].'
                                        </td>
                                        
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">mode_edit</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    ';*/

                                }//while grades

                                echo '
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                                ';

                            }//if







                            /* REPOSITORIES */
                            $table_repositories = 'recos_tb_service_repository';
                            $order_repositories = '';
                            $where_repositories = 'fk_cod_project_rep = '.$projetos['pk_cod_project'];
                            $fields_repositories = '*';
                            $aux_repositories = sql_select($conn,$table_repositories,$order_repositories,$where_repositories,$fields_repositories);

                            if( sql_num_rows($aux_repositories)>0 ){



                                echo '

                        <tr>
                            <td class="mdl-data-table__cell--non-numeric" colspan="7">

                                <h5><a href="#" onclick="$(\'#repositories_'.$projetos['pk_cod_project'].'\').toggle();">GET /repositories</a></h5>

                                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id="repositories_'.$projetos['pk_cod_project'].'" style="display:none; width:100%;">
                                    <thead style="display:none;">
                                        <tr>

                                            <th class="mdl-data-table__cell--non-numeric">Description</th>
                                            <th class="mdl-data-table__cell--non-numeric">URL</th>
                                            <th>edit</th>
                                            <th>delete</th>
                                            
                                        </tr>
                                    </thead>

                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric" colspan="5">
                                            <small>
                                            (api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getRepositoriesList) 
                                            <pre>
                                            '.file_get_contents(URL_PADRAO.'api/v0.1/data.php?key='.$projetos['txt_hash_pro'].'&action=getRepositoriesList').'
                                            </pre>
                                            </small>
                                        </th>
                                        
                                    </tr>
                                    
                                    <tbody>
                                ';

                                while($repositories = sql_fetch_array($aux_repositories) ){

                                    echo '
                                    <tr style="display:none;">    
                                        
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$repositories['txt_description_rep'].'
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            '.$repositories['txt_url_rep'].'
                                        </td>
                                        
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">mode_edit</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    ';

                                }//while repositories

                                echo '
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                                ';

                            }//if
                        -->

                        <?
                        

                        }//while

                        echo '
                            </tbody>
                        </table>
                        ';

                    } else {
                        echo 'No projects found';
                    }

                    ?>
                </div>

                <!--
                <div class="mdl-cell mdl-cell--12-col">

                    <h3>API Tests</h3>

                    <div id="test_status"></div>

                </div>
                -->

            </div>


            <script>

            $(document).ready(function(){

                $("#form-button-enviar").click(function(){

                    // var dataString = '';
                    var dataString="email="+$("#form_email").val()+"&mensagem="+$("#form_mensagem").val();


                    if( $("#form_email").val() == "" || $("#form_mensagem").val() == "" ){

                        $('#form-status').html('Favor preencher todos os campos');

                    } else {

                        $('#form-status').html('ENVIANDO... Aguarde');

                        //delay(200)
                        $("#form-button-enviar").queue(function(n) {
                            $.ajax({
                                type: "POST",
                                url:"https://www.inovarpublico.com.br/envia_email.php",
                                data: dataString,
                                crossDomain: true,
                                cache: false,
                                beforeSend: function(){
                                    // $("#container-conteudo").html('<div style="text-align:center; margin-top: 100px;"><img src="img/preloader-circular.gif"  /></div>');
                                },
                                success: function(data){
                                    // $("#container-conteudo").html(data);
                                    if(data == 'ok'){
                                        $('#form-status').html('Mensagem enviada com sucesso! Em breve entraremos em contato');
                                    } else {
                                        $('#form-status').html('ERRO ao enviar mensagem. Por favor tente novamente');
                                    }
                                },
                                error: function(data) { // if error occured
                                    $('#form-status').html('ERRO ao enviar mensagem. Por favor tente novamente');
                                    // $("#container-conteudo").html('<div style="text-align:center; margin-top: 100px;"><i class="material-icons">signal_wifi_off</i><br /><br />Verifique sua conexão e tente novamente!</div>');
                                }
                            });

                            n();
                        });

                    }//else


                    // $('#container-conteudo').delay(200).animate( {opacity: 1, marginTop:"0" }, 200 );

                    return false;
                });
            });

            </script>












        <!-- Colored FAB button with ripple -->
        <a href="project-new.php" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" style="position:fixed; bottom:20px; right:20px;">
          <i class="material-icons">add</i>
        </a>


    <?
    require_once('inc.menu_footer.php');
    ?>



    <?
    
}//logado
else {

    ?>




    <?

    if( isset( $_GET['acao'] ) && $_GET['acao'] == 'logar' ){

        // var_dump($_POST);

        $conn = conectar();

        $user = sql_select($conn,'recos_tb_users', NULL, " txt_username_use = '".$_POST['input_usuario']."' AND txt_password_use = '".md5(_HASH.$_POST['input_senha'])."' ");

        // echo $_POST['input_usuario'];
        // echo md5(_HASH.$_POST['input_senha']);

        if( sql_num_rows($user) == 1 ){

            $user = sql_fetch_array($user);

            //usuário existe
            $retorno_login = 'USER LOGGED. REDIRECTING...<br /><br />';

            $_SESSION['user_loged'] = true;
            $_SESSION['user_cod'] = $user['pk_cod_user'];
            $_SESSION['user_email'] = $user['txt_email_use'];
            $_SESSION['user_type'] = $user['int_type_use'];

            redireciona('painel.php');

        } else {

            $retorno_login = 'INCORRECT DATA. TRY AGAIN<br /><br />';


        }

    }

    ?>

    <!-- FORM LOGIN -->

    <div class="mdl-grid miolo">
                <div class="mdl-cell mdl-cell--12-col">


                    <div style="width:400px; margin:0px auto 0px auto; text-align:center; background:white; padding:50px; border:solid 1px #F0F0F0; border-bottom: solid 2px #E1E1E1;">

                        <img src="img/LOGO-R.ECOS.png" style="margin-bottom:50px; width:75%;" />

                        <br />
                        <?=@$retorno_login;?>

                        <form action="?acao=logar" method="POST">

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="input_usuario" name="input_usuario">
                                <label class="mdl-textfield__label" for="input_usuario">Username</label>
                            </div>

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="password" id="input_senha" name="input_senha">
                                <label class="mdl-textfield__label" for="input_senha">Password</label>
                            </div>

                            <br /><br /><br />

                            <input type="submit" value="Login" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%;" />

                        </form>

                    </div>




                </div>
    </div>


    <?

}
?>



<?
require_once('inc.footer.php');
?>
