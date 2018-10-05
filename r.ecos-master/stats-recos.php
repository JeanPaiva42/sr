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

                    <h3>R.ECOS Statistics</h3>

                    <?

                    //lista projetos deste usuario
                    $conn = conectar();

                    $hoje = date('Y-m-d');
                    // $data_ontem = date( 'Y-m-d' , strtotime($hoje . "-1 days") );
                    $data_7dias = date( 'Y-m-d' , strtotime($hoje . "-6 days") );
                    // $data_30dias = date( 'Y-m-d' , strtotime($hoje . "-1 months") );
                    // $data_60dias = date( 'Y-m-d' , strtotime($hoje . "-59 days") );



                    //USUÁRIOS
                    $table = 'recos_tb_users';
                    $order = NULL;
                    $where = NULL;
                    $fields = 'count(*) AS total';
                    $limit = NULL;
                    $groupby = NULL;
                    $usuarios = sql_fetch_array(sql_select($conn,$table,$order,$where,$fields,$limit,$groupby));

                    $labels_usuarios = " 'ATIVOS' , 'INATIVOS' ";
                    $dataset_usuarios = " ".$usuarios['total']." , 1 ";



                    //PROJETOS
                    $table = 'recos_tb_projects';
                    $projetos = sql_fetch_array(sql_select($conn,$table,$order,$where,$fields,$limit,$groupby));

                    $labels_projetos = " 'ATIVOS' , 'INATIVOS' ";
                    $dataset_projetos = " ".$projetos['total']." , 2 ";



                    //REQUISIÇÕES
                    $table = 'recos_tb_log';
                    // $where = 'txt_descricao_log = \'REQUISICAO GETRESOURCESWORDPRESS\' ';
                    $where = 'txt_descricao_log = \'REQUISICAO GETRESOURCESWORDPRESS_20171021\' ';
                    $groupby = NULL;
                    $requisicoes = sql_fetch_array(sql_select($conn,$table,$order,$where,$fields,$limit,$groupby));



                    $labels_requisicoes = '';

                    $data_atual = date('Y-m-d');
                    $data_inicio = date('Y-m-d',strtotime( $data_atual.' -6 days' ));

                        //zera todos os dias
                        for( $aux_arr = $data_inicio ; $aux_arr <=$data_atual ; $aux_arr=date('Y-m-d',strtotime( $aux_arr.' +1 days' ))  ){
                            
                            $ARR_requisicoes[$aux_arr] = 0;
                            
                            if( $labels_requisicoes != ''){
                                $labels_requisicoes .= ' , ';
                            }
                            $labels_requisicoes .= " '".substr( formata_data($aux_arr) , 0,5)."' ";
                        }

                        $fields = 'substr(dat_registro_log,1,10) AS data, count(*) AS total';
                        $groupby = 'substr(dat_registro_log,1,10)';
                        $complemento_req_7dias = ' AND dat_registro_log > \''.$data_7dias.'\' ';
                        $aux_7dias = sql_select($conn,$table,$order,$where.$complemento_req_7dias,$fields,$limit,$groupby);

                        //atualiza totais das datas encontradas
                        while( $requisicoes_7dias = sql_fetch_array($aux_7dias) ){
                            $ARR_requisicoes[$requisicoes_7dias['data']] = $requisicoes_7dias['total'];
                        }

                        $dataset_requisicoes = '';

                        // var_dump($ARR_requisicoes);

                        foreach( $ARR_requisicoes as $DS_requisicoes ){
                                if( $dataset_requisicoes != ''){
                                    $dataset_requisicoes .= ' , ';
                                }
                                $dataset_requisicoes .= ' '.$DS_requisicoes.' ';
                        } 

                    ?>




                </div>

                <div class="mdl-cell mdl-cell--4-col" style="text-align:center; background:white; padding:30px;">

                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">USUÁRIOS</div>
                    <div style="font-weight:800; font-size:50px; color:#1565C0; margin-top:20px;margin-bottom:15px;">
                        <i class="material-icons" style="font-size:36px; vertical-align:middle;">hot_tub</i>
                        <?=$usuarios['total'];?>
                    </div>
                    


                    <div style="height:1px; background:#cccccc; margin: 20px 10%; "></div>



                    <DIV style="max-width:200px; width:100%; margin-left:auto; margin-right:auto; overflow:hidden;"> 
                    <canvas id="myChart_1" width="100" height="100"></canvas>

                        <script>
                            var ctx = document.getElementById("myChart_1");
                            

                            var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    datasets: [
                                    {
                                        data: [<?=$dataset_usuarios;?>],
                                        backgroundColor: [ '#42A5F5' , '#BBDEFB' ],
                                        label:  'Usuários'
                                    }],
                                    labels: [<?=$labels_usuarios;?>],
                                },
                                options: {
                                    legend: {
                                        position:'bottom',
                                    }
                                }
                            });
                            </script>
                    </div>
                    

                </div>

                <div class="mdl-cell mdl-cell--4-col" style="text-align:center; background:white; padding:30px;">

                    

                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">PROJETOS</div>
                    <div style="font-weight:800; font-size:50px; color:#EF6C00; margin-top:20px;margin-bottom:15px;">
                        <i class="material-icons" style="font-size:36px; vertical-align:middle;">fitness_center</i>
                        <?=$projetos['total'];?>
                    </div>
                    
                    

                    <div style="height:1px; background:#cccccc; margin: 20px 10%; "></div>



                    <DIV style="max-width:200px; width:100%; margin-left:auto; margin-right:auto; overflow:hidden;"> 
                    <canvas id="myChart_2" width="100" height="100"></canvas>

                        <script>
                            var ctx = document.getElementById("myChart_2");
                            

                            var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    datasets: [
                                    {
                                        data: [<?=$dataset_projetos;?>],
                                        backgroundColor: [ '#FFA726' , '#FFE0B2' ],
                                        label:  'Projetos'
                                    }],
                                    labels: [<?=$labels_projetos;?>],
                                },
                                options: {
                                    legend: {
                                        position:'bottom',
                                    }
                                }
                            });
                            </script>
                    </div>
                    

                </div>

                <div class="mdl-cell mdl-cell--4-col" style="text-align:center; background:white; padding:30px;">

                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">REQUISIÇÕES</div>
                    <div style="font-weight:800; font-size:50px; color:#7E57C2; margin-top:20px;margin-bottom:15px;">
                        <i class="material-icons" style="font-size:36px; vertical-align:middle;">golf_course</i>
                        <?=$requisicoes['total'];?>
                    </div>
                    
                    

                    <div style="height:1px; background:#cccccc; margin: 20px 10%; "></div>



                    <DIV style="max-width:200px; width:100%; margin-left:auto; margin-right:auto; overflow:hidden;"> 
                    <canvas id="myChart_3" width="100" height="100"></canvas>

                        <script>
                            var ctx = document.getElementById("myChart_3");
                            
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: [<?=$labels_requisicoes;?>],
                                    datasets: [
                                        
                                        {
                                            label: '',
                                            fill: false,
                                            lineTension: 0.1,
                                            backgroundColor: "rgba(69,39,160,0.4)",
                                            borderColor: "rgba(69,39,160,1)",
                                            borderCapStyle: 'butt',
                                            borderDash: [],
                                            borderDashOffset: 0.0,
                                            borderJoinStyle: 'miter',
                                            pointBorderColor: "rgba(69,39,160,1)",
                                            pointBackgroundColor: "#fff",
                                            pointBorderWidth: 1,
                                            pointHoverRadius: 5,
                                            pointHoverBackgroundColor: "rgba(69,39,160,1)",
                                            pointHoverBorderColor: "rgba(69,39,160,1)",
                                            pointHoverBorderWidth: 1,
                                            pointRadius: 1,
                                            pointHitRadius: 10,
                                            data: [<?=$dataset_requisicoes;?>],
                                            spanGaps: false,
                                        }
                                    ]
                                },
                                options: {
                                    legend: {
                                        display:false,
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    }
                                }
                                });
                            </script>
                    </div>
                    

                </div>





                

                    <!-- 
                    <DIV style="max-width:1100px; width:100%; margin-left:auto; margin-right:auto; overflow:hidden;"> -->

                        

                    <!-- </DIV> -->





            </div><!-- mdl-grid -->


            


    <?
    require_once('inc.menu_footer.php');
    ?>



    <?
    
}//logado

?>



<?
require_once('inc.footer.php');
?>
