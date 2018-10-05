<?
require_once('inc.header.php');
?>



    <?
    require_once('inc.menu.php');
    ?>


    <!-- FORM LOGIN -->

    <div class="mdl-grid miolo " >

                <div class="mdl-cell mdl-cell--12-col" style="text-align:center;">



                        <h4><b>Welcome to our Marketplace!</b></h4>

                        Using our Recommender Ecossystem (R.ECOS), you can develope applications with Recommender Systems techniques.

                        <hr/>



                </div>


                <!-- list available services -->
                <?
                $conn = conectar();

                $sql_query = sql_select($conn,'recos_tb_services INNER JOIN recos_tb_categories ON (fk_cod_category_ser = pk_cod_category)', 'txt_title_ser', 'int_status_ser = 1');

                while( $service = sql_fetch_array($sql_query) ){

                    echo'
                    <div class="mdl-cell mdl-cell--4-col box">
                        <h5>
                            '.$service['txt_title_ser'].'
                        </h5>

                        <b style="color: '.$service['txt_color_cat'].'">'.$service['txt_title_cat'].'</b>

                        <br /><br />

                        '.$service['txt_description_ser'].'

                        <br /><br />

                        '.( $service['txt_url_ser']!='' ? '<a href="'.$service['txt_url_ser'].'/?key=0ee669f3cfd7f33aa68bb034afa13686&pretty=true">Example</a>' : '' ).'

                    </div>';

                }//while
                ?>

    </div>



    <?
    require_once('inc.menu_footer.php');
    ?>


<?
require_once('inc.footer.php');
?>
