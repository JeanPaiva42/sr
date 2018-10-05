<?
require_once('inc.header.php');
?>




    <?
    require_once('inc.menu.php');
    ?>


    

            <?
            $conn = conectar();
            ?>


            <?
            if( isset($_GET['action']) && $_GET['action']=='new' ){
                
                $table = 'recos_tb_projects';

                //HASH
                $aux_hash = mysqli_fetch_array(mysqli_query($conn,"SHOW TABLE STATUS LIKE '".$table."'"));
                $hash = md5(_HASH.$aux_hash['Auto_increment']);

                $fields = '
                fk_cod_user_pro,
                txt_title_pro,
                txt_hash_pro,
                fk_cod_filtering_pro,
                fk_cod_method_pro,
                fk_cod_profiling_pro,
                fk_cod_repository_pro,
                fk_cod_enrichment_pro
                ';
                $values = "
                ".$_SESSION['user_cod'].",
                '".$_POST['title']."',
                '".$hash."',
                '".$_POST['filtering']."',
                '".$_POST['method']."',
                '".$_POST['profiling']."',
                '".$_POST['repository']."',
                '".$_POST['enrichment']."'
                ";

                if( sql_insert( $conn, $table, $fields, $values) ){
                    echo '
                    <p>New project successfully added</p>
                    <p>To use this project in your system, use the key bellow:</p>
                    <p><big><big>'.$hash.'</big></big></p>
                    ';
                } else {
                    echo '<p>Error! Try again</p>';
                }

            }
            ?>



            
            <div class="mdl-grid">
                <!-- <div class="mdl-cell mdl-cell--8-col"></div> -->
                <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--12-col-tablet" style="text-align:Center; background:white;">

                    <h3>New Project</h3>
                    <p>Fill the form bellow to add a new project</p>
                    
                    <?

                    $table = 'recos_tb_services';
                    $order = 'txt_title_ser';

                    ?>


                    <form action="?action=new" method="POST">

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="title" name="title">
                            <label class="mdl-textfield__label" for="title">Title</label>
                        </div>

                        <br />
                        
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select class="mdl-textfield__input" id="profiling" name="profiling">
                                <option value="0">- select -</option>
                                <?

                                $aux_service = sql_select($conn, $table, $order, 'fk_cod_category_ser = 3 AND int_status_ser = 1');
                                while($service = sql_fetch_array($aux_service)){
                                    echo '<option value="'.$service['pk_cod_service'].'">'.$service['txt_title_ser'].'</option>';
                                }//while
                                ?>
                            </select>
                            <label class="mdl-textfield__label" for="profiling">Profiling Service</label>
                        </div>

                        <br />

                        <!--<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select class="mdl-textfield__input" id="enrichment" name="enrichment">
                                <option value="0">- select -</option>
                                <?

                                $aux_service = sql_select($conn, $table, $order, 'fk_cod_category_ser = 5 AND int_status_ser = 1');
                                while($service = sql_fetch_array($aux_service)){
                                    echo '<option value="'.$service['pk_cod_service'].'">'.$service['txt_title_ser'].'</option>';
                                }//while
                                ?>
                            </select>
                            <label class="mdl-textfield__label" for="enrichment">Enrichment Service</label>
                        </div>

                        <br />-->


                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select class="mdl-textfield__input" id="filtering" name="filtering">
                                <option value="0">- select -</option>
                                <?

                                $aux_service = sql_select($conn, $table, $order, 'fk_cod_category_ser = 1 AND int_status_ser = 1');
                                while($service = sql_fetch_array($aux_service)){
                                    echo '<option value="'.$service['pk_cod_service'].'">'.$service['txt_title_ser'].'</option>';
                                }//while
                                ?>
                            </select>
                            <label class="mdl-textfield__label" for="filtering">Filtering Service</label>
                        </div>

                        <br />


                        
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select class="mdl-textfield__input" id="method" name="method">
                                <option value="0">- select -</option>
                                <?

                                $aux_service = sql_select($conn, $table, $order, 'fk_cod_category_ser = 2 AND int_status_ser = 1');
                                while($service = sql_fetch_array($aux_service)){
                                    echo '<option value="'.$service['pk_cod_service'].'">'.$service['txt_title_ser'].'</option>';
                                }//while
                                ?>
                            </select>
                            <label class="mdl-textfield__label" for="method">Model Service</label>
                        </div>

                        <br />
                        
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select class="mdl-textfield__input" id="repository" name="repository">
                                <option value="0">- select -</option>
                                <?

                                $aux_service = sql_select($conn, $table, $order, 'fk_cod_category_ser = 4 AND int_status_ser = 1');
                                while($service = sql_fetch_array($aux_service)){
                                    echo '<option value="'.$service['pk_cod_service'].'">'.$service['txt_title_ser'].'</option>';
                                }//while
                                ?>
                            </select>
                            <label class="mdl-textfield__label" for="repository">Recommendation Service</label>
                        </div>

                        <br /><br />

                        <!-- Accent-colored raised button with ripple -->
                        <input type="submit" value="Confirm" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" />

                        <br /><Br />

                    </form>

                </div>
                <!-- <div class="mdl-cell mdl-cell--8-col"></div> -->
            </div>








<?
require_once('inc.footer.php');
?>
