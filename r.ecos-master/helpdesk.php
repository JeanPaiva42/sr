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

                    <h3>Help Desk</h3>

                    <p>Check your tickets bellow</p>


                    <?
                    /*
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
                    ';

                    $aux_projetos = sql_select($conn,$table,$order,$where,$fields);

                    if( sql_num_rows($aux_projetos)>0 ){
                    
                        echo '
                        */
                        ?>

                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width:100%;">
                            <thead>
                                <tr>

                                    <th class="mdl-data-table__cell--non-numeric">ID</th>
                                    <th class="mdl-data-table__cell--non-numeric">Subject</th>
                                    <th class="mdl-data-table__cell--non-numeric">Customer Name</th>
                                    <th class="mdl-data-table__cell--non-numeric">Status</th>
                                    <th class="mdl-data-table__cell--non-numeric">Priority</th>
                                    <th class="mdl-data-table__cell--non-numeric">Date creation</th>
                                    <th class="mdl-data-table__cell--non-numeric">Action</th>
                                    
                                    <!-- <th>edit</th> -->
                                    <!-- <th>delete</th> -->
                                    
                                </tr>
                            </thead>
                            <tbody>
                        <? /*';


                        while($projetos = sql_fetch_array($aux_projetos)){

                            echo '*/
                            ?>
                                <tr>

                                    <td class="mdl-data-table__cell--non-numeric">5</td>
                                    <td class="mdl-data-table__cell--non-numeric">How can I access my evaluations?</td>
                                    <td class="mdl-data-table__cell--non-numeric">Victor Stroele</td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <span class="mdl-chip" style="background-color:#009688; ">
                                            <span class="mdl-chip__text"  style="color:white;">in progress</span>
                                        </span>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">high</td>
                                    <td class="mdl-data-table__cell--non-numeric">3 hours ago</td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">view</a></td>

                                </tr>
                                <tr>

                                    <td class="mdl-data-table__cell--non-numeric">4</td>
                                    <td class="mdl-data-table__cell--non-numeric">Questions about integration</td>
                                    <td class="mdl-data-table__cell--non-numeric">André Abdalla</td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <span class="mdl-chip" style="background-color:#c62828; ">
                                            <span class="mdl-chip__text"  style="color:white;">open</span>
                                        </span>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">medium</td>
                                    <td class="mdl-data-table__cell--non-numeric">7 hours ago</td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">view</a></td>

                                </tr>
                                <tr>

                                    <td class="mdl-data-table__cell--non-numeric">3</td>
                                    <td class="mdl-data-table__cell--non-numeric">About reproved service</td>
                                    <td class="mdl-data-table__cell--non-numeric">Fernanda Campos</td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <span class="mdl-chip" style="background-color:#333333; ">
                                            <span class="mdl-chip__text"  style="color:white;">closed</span>
                                        </span>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">low</td>
                                    <td class="mdl-data-table__cell--non-numeric">13 hours ago</td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">view</a></td>

                                </tr>




                            <? /*';*/

                        /*

                        }//while

                        echo '*/ ?>
                            </tbody>
                        </table>
                        <? /*';

                    } else {
                        echo 'No projects found';
                    }
*/
                    ?>
                </div>
            </div>




            



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

        // echo md5(_HASH.$_POST['input_senha']);

        if( sql_num_rows($user) == 1 ){

            $user = sql_fetch_array($user);

            //usuário existe
            $retorno_login = 'USER LOGGED. REDIRECTING...<br /><br />';

            $_SESSION['user_loged'] = true;
            $_SESSION['user_cod'] = $user['pk_cod_user'];
            $_SESSION['user_email'] = $user['txt_email_use'];

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
