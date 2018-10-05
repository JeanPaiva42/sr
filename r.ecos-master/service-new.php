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
                
                echo 'Not allowed yet :)';

                /*

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
                fk_cod_repository_pro
                ';
                $values = "
                1,
                '".$_POST['title']."',
                '".$hash."',
                ".$_POST['filtering'].",
                ".$_POST['method'].",
                ".$_POST['profiling'].",
                ".$_POST['repository']."
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
                */

            }
            ?>



            
            <div class="mdl-grid">
                <!-- <div class="mdl-cell mdl-cell--8-col"></div> -->
                <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--12-col-tablet" style="text-align:Center; background:white;">

                    <h3>New service</h3>
                    <p>Fill the form bellow to add a new service</p>
                    
                    


                    <form action="?action=new" method="POST">

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="title" name="title">
                            <label class="mdl-textfield__label" for="title">Title</label>
                        </div>

                        <br />

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="description" name="description">
                            <label class="mdl-textfield__label" for="description">Description</label>
                        </div>

                        <br />

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select class="mdl-textfield__input" id="filtering" name="filtering">
                                <option value="0">- none -</option>
                                <option value="1">Filtering</option>
                                <option value="2">Method</option>
                                <option value="3">Profiling</option>
                                <option value="4">Repository</option>
                            </select>
                            <label class="mdl-textfield__label" for="filtering">Service category</label>
                        </div>

                        <br />
<!-- 
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="file" id="file" name="file">
                            <label class="mdl-textfield__label" for="file">Select service file (.zip or .7z)</label>
                        </div> -->

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--file">
                            <input class="mdl-textfield__input" placeholder="Select file (.zip or .7z)" type="text" id="uploadFile" readonly />
                            <div class="mdl-button mdl-button--primary mdl-button--icon mdl-button--file">
                                <i class="material-icons">attach_file</i><input type="file" id="uploadBtn">
                            </div>
                        </div>


                        <style>
                        .mdl-button--file {
                          input {
                            cursor: pointer;
                            height: 100%;
                            right: 0;
                            opacity: 0;
                            position: absolute;
                            top: 0;
                            width: 300px;
                            z-index: 4;
                          }
                        }

                        .mdl-textfield--file {
                          .mdl-textfield__input {
                            box-sizing: border-box;
                            width: calc(100% - 32px);
                          }
                          .mdl-button--file {
                            right: 0;
                          }
                        }
                        </style>

                        <script>
                        document.getElementById("uploadBtn").onchange = function () {
                            document.getElementById("uploadFile").value = this.files[0].name;
                        };
                        </script>

                        <br />


                        <br /><br />

                        <!-- Accent-colored raised button with ripple -->
                        <input type="submit" value="Confirm" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" />

                        <br /><Br />

                    </form>

                </div>
                <!-- <div class="mdl-cell mdl-cell--4-col"></div> -->
            </div>








<?
require_once('inc.footer.php');
?>
