<?
require_once('inc.header.php');
?>



<?

// if( isset($_SESSION['user_loged']) && $_SESSION['user_loged'] == true ){

    // var_dump($_SESSION);

    ?>



    <?
    require_once('inc.menu.php');
    ?>






            
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">

                    <h3>Discussions Forum</h3>

                    <!-- <p>Check your tickets bellow</p> -->


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
                                    <th class="mdl-data-table__cell--non-numeric">Topic</th>
                                    <th class="mdl-data-table__cell--non-numeric">Last post</th>
                                    <th class="mdl-data-table__cell--non-numeric">Discussions</th>
                                    <th class="mdl-data-table__cell--non-numeric">Posts</th>
                                    
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
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">Ideias and sugestions</a></td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">Re: news service ideia</a></td>
                                    <td class="mdl-data-table__cell--non-numeric">52</td>
                                    <td class="mdl-data-table__cell--non-numeric">16</td>

                                </tr>
                                <tr>

                                    <td class="mdl-data-table__cell--non-numeric">4</td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">Services licenses</a></td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">Re: how can i get my license</a></td>
                                    <td class="mdl-data-table__cell--non-numeric">70</td>
                                    <td class="mdl-data-table__cell--non-numeric">30</td>

                                </tr>
                                <tr>

                                    <td class="mdl-data-table__cell--non-numeric">2</td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">News</a></td>
                                    <td class="mdl-data-table__cell--non-numeric"><a href="#">New characteristics in rour R.ECOS</a></td>
                                    <td class="mdl-data-table__cell--non-numeric">89</td>
                                    <td class="mdl-data-table__cell--non-numeric">32</td>

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
    
// }//logado
// else {


// }
?>



<?
require_once('inc.footer.php');
?>
