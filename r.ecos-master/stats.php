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

                    <h3>Project Statistics</h3>

                    <?

                    //lista projetos deste usuario
                    $conn = conectar();

                    $hash = $_GET['h'];

                    $table = 'recos_tb_stats
                    INNER JOIN recos_tb_service_repository ON ( fk_cod_repository_sta = pk_cod_repository )
                    INNER JOIN recos_tb_projects ON ( fk_cod_project_rep = pk_cod_project)
                    ';
                    $order = 'substr(dat_registro_sta,1,10), txt_descricao_sta';
                    $where = 'fk_cod_user_pro = '.$_SESSION['user_cod'].' AND txt_hash_pro = \''.$hash.'\' '; //1 é o codigo do usuario de testes
                    $fields = 'pk_cod_project, txt_descricao_sta, substr(dat_registro_sta,1,10) as data , count(*) as total';
                    $groupby = 'pk_cod_project, txt_descricao_sta';


                    $projeto = sql_fetch_array(sql_select($conn,'recos_tb_projects',NULL,'txt_hash_pro = \''.$hash.'\''));

                    ?>


                    <p><?=$projeto['txt_title_pro'];?> - <?=$projeto['txt_hash_pro'];?></p>


                    <?


                    $hoje = date('Y-m-d');
                    // $hoje = '2017-10-08';
                    $data_ontem = date( 'Y-m-d' , strtotime($hoje . "-1 days") );
                    $data_7dias = date( 'Y-m-d' , strtotime($hoje . "-7 days") );
                    $data_30dias = date( 'Y-m-d' , strtotime($hoje . "-1 month") );
                    $data_60dias = date( 'Y-m-d' , strtotime($hoje . "-59 days") );

                    //REQUISICAO HOJE
                    $complemento_req_hoje = ' 
                    AND substr(dat_registro_sta,1,10) = \''.$hoje.'\' 
                    AND txt_descricao_sta = \'RECURSO APRESENTADO\' ';
                    $requisicoes_hoje = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_req_hoje,$fields,NULL,$groupby));

                    //REQUISICAO ONTEM
                    $complemento_req_ontem = ' 
                    AND substr(dat_registro_sta,1,10) = \''.$data_ontem.'\' 
                    AND txt_descricao_sta = \'RECURSO APRESENTADO\' ';
                    $requisicoes_ontem = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_req_ontem,$fields,NULL,$groupby));

                    //REQUISICAO 7 DIAS
                    $complemento_req_7dias = ' 
                    AND dat_registro_sta BETWEEN \''.$data_7dias.' 00:00:00\' AND \''.$hoje.' 23:59:59\' 
                    AND txt_descricao_sta = \'RECURSO APRESENTADO\' ';
                    $requisicoes_7dias = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_req_7dias,$fields,NULL,$groupby));

                    //REQUISICAO 30 DIAS
                    $complemento_req_30dias = ' 
                    AND dat_registro_sta BETWEEN \''.$data_30dias.' 00:00:00\' AND \''.$hoje.' 23:59:59\' 
                    AND txt_descricao_sta = \'RECURSO APRESENTADO\' ';
                    $requisicoes_30dias = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_req_30dias,$fields,NULL,$groupby));



                    //CLIQUES HOJE
                    $complemento_clique_hoje = ' 
                    AND substr(dat_registro_sta,1,10) = \''.$hoje.'\' 
                    AND txt_descricao_sta = \'RECURSO CLICADO\' ';
                    $cliques_hoje = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_clique_hoje,$fields,NULL,$groupby));

                    //CLIQUES ONTEM
                    $complemento_clique_ontem = ' 
                    AND substr(dat_registro_sta,1,10) = \''.$data_ontem.'\' 
                    AND txt_descricao_sta = \'RECURSO CLICADO\' ';
                    $cliques_ontem = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_clique_ontem,$fields,NULL,$groupby));

                    //CLIQUES 7 DIAS
                    $complemento_clique_7dias = ' 
                    AND dat_registro_sta BETWEEN \''.$data_7dias.' 00:00:00\' AND \''.$hoje.' 23:59:59\' 
                    AND txt_descricao_sta = \'RECURSO CLICADO\' ';
                    $cliques_7dias = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_clique_7dias,$fields,NULL,$groupby));

                    //CLIQUES 30 DIAS
                    $complemento_clique_30dias = ' 
                    AND dat_registro_sta BETWEEN \''.$data_30dias.' 00:00:00\' AND \''.$hoje.' 23:59:59\' 
                    AND txt_descricao_sta = \'RECURSO CLICADO\' ';
                    $cliques_30dias = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_clique_30dias,$fields,NULL,$groupby));



                    //REJEITADOS HOJE
                    $complemento_rejeitado_hoje = ' 
                    AND substr(dat_registro_sta,1,10) = \''.$hoje.'\' 
                    AND txt_descricao_sta = \'RECURSO REJEITADO\' ';
                    $rejeitados_hoje = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_rejeitado_hoje,$fields,NULL,$groupby));

                    //REJEITADOS ONTEM
                    $complemento_rejeitado_ontem = ' 
                    AND substr(dat_registro_sta,1,10) = \''.$data_ontem.'\' 
                    AND txt_descricao_sta = \'RECURSO REJEITADO\' ';
                    $rejeitados_ontem = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_rejeitado_ontem,$fields,NULL,$groupby));

                    //REJEITADOS 7 DIAS
                    $complemento_rejeitado_7dias = ' 
                    AND dat_registro_sta BETWEEN \''.$data_7dias.' 00:00:00\' AND \''.$hoje.' 23:59:59\' 
                    AND txt_descricao_sta = \'RECURSO REJEITADO\' ';
                    $rejeitados_7dias = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_rejeitado_7dias,$fields,NULL,$groupby));

                    //REJEITADOS 30 DIAS
                    $complemento_rejeitado_30dias = ' 
                    AND dat_registro_sta BETWEEN \''.$data_30dias.' 00:00:00\' AND \''.$hoje.' 23:59:59\' 
                    AND txt_descricao_sta = \'RECURSO REJEITADO\' ';
                    $rejeitados_30dias = sql_fetch_array(sql_select($conn,$table,$order,$where.$complemento_rejeitado_30dias,$fields,NULL,$groupby));



                    // echo '<pre>';
                    // var_dump($projetos);
                    // echo '</pre>';
                    

                    ?>




                </div>

                <div class="mdl-cell mdl-cell--4-col" style="text-align:center; background:white; padding:30px;">

                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">RECURSOS APRESENTADOS</div>
                    <div style="font-weight:800; font-size:50px; color:#CC0000; margin-top:20px;margin-bottom:15px;">
                        <?=($requisicoes_hoje['total']?$requisicoes_hoje['total']:0);?>
                    </div>
                    <div style="font-weight:300; font-size:18px; color:#999999; ">HOJE</div>
                    
                    <div style="height:1px; background:#cccccc; margin: 20px 10%; "></div>

                    <div style="float:left; width:33%; border-right: solid 1px #E1E1E1; ">
                        <div style="font-weight:800; font-size:30px; color:#AA0000; margin-top:10px; margin-bottom:10px;"><?=($requisicoes_ontem['total']?$requisicoes_ontem['total']:0);?></div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">ontem</div>
                    </div>

                    <div style="float:left; width:33%; border-right: solid 1px #E1E1E1; ">
                        <div style="font-weight:800; font-size:30px; color:#AA0000; margin-top:10px; margin-bottom:10px;"><?=($requisicoes_7dias['total']?$requisicoes_7dias['total']:0);?></div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">7 dias</div>
                    </div>
                    
                    <div style="float:left; width:33%;">
                        <div style="font-weight:800; font-size:30px; color:#AA0000; margin-top:10px; margin-bottom:10px;"><?=($requisicoes_30dias['total']?$requisicoes_30dias['total']:0);?></div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">1 mês</div>
                    </div>

                </div>

                <div class="mdl-cell mdl-cell--4-col" style="text-align:center; background:white; padding:30px;">

                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">CLIQUES EM RECURSOS</div>
                    <div style="font-weight:800; font-size:50px; color:#0000CC; margin-top:20px;margin-bottom:15px;">
                        <?=($cliques_hoje['total']?$cliques_hoje['total']:0);?>
                    </div>
                    <div style="font-weight:300; font-size:18px; color:#999999; ">HOJE - <?=number_format( ($cliques_hoje['total']/( $requisicoes_hoje['total'] ? $requisicoes_hoje['total'] : 1 ))*100, 2,',','' );?> %</div>
                    
                    <div style="height:1px; background:#cccccc; margin: 20px 10%; "></div>

                    <div style="float:left; width:33%; border-right: solid 1px #E1E1E1; ">
                        <div style="font-weight:800; font-size:30px; color:#0000AA; margin-top:10px; margin-bottom:10px;"><?=($cliques_ontem['total']?$cliques_ontem['total']:0);?></div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">ontem</div>
                    </div>

                    <div style="float:left; width:33%; border-right: solid 1px #E1E1E1; ">
                        <div style="font-weight:800; font-size:30px; color:#0000AA; margin-top:10px; margin-bottom:10px;"><?=($cliques_7dias['total']?$cliques_7dias['total']:0);?></div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">7 dias</div>
                    </div>
                    
                    <div style="float:left; width:33%;">
                        <div style="font-weight:800; font-size:30px; color:#0000AA; margin-top:10px; margin-bottom:10px;"><?=($cliques_30dias['total']?$cliques_30dias['total']:0);?></div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">1 mês</div>
                    </div>

                </div>

                <div class="mdl-cell mdl-cell--4-col" style="text-align:center; background:white; padding:30px;">

                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">RECURSOS REJEITADOS</div>
                    <div style="font-weight:800; font-size:50px; color:#00CC00; margin-top:20px;margin-bottom:15px;">
                        <?=($rejeitados_hoje['total'] ? $rejeitados_hoje['total'] : 0);?>
                    </div>
                    <div style="font-weight:300; font-size:18px; color:#999999; ">HOJE - <?=number_format( ($rejeitados_hoje['total']/ ($requisicoes_hoje['total'] ? $requisicoes_hoje['total'] : 1 ) )*100, 2,',','' );?> %</div>
                    
                    <div style="height:1px; background:#cccccc; margin: 20px 10%; "></div>

                    <div style="float:left; width:33%; border-right: solid 1px #E1E1E1; ">
                        <div style="font-weight:800; font-size:30px; color:#00AA00; margin-top:10px; margin-bottom:10px;">
                            <?=($rejeitados_ontem['total'] ? $rejeitados_ontem['total'] : 0);?>
                        </div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">ontem</div>
                    </div>

                    <div style="float:left; width:33%; border-right: solid 1px #E1E1E1; ">
                        <div style="font-weight:800; font-size:30px; color:#00AA00; margin-top:10px; margin-bottom:10px;">
                            <?=($rejeitados_7dias['total'] ? $rejeitados_7dias['total'] : 0);?>
                        </div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">7 dias</div>
                    </div>
                    
                    <div style="float:left; width:33%;">
                        <div style="font-weight:800; font-size:30px; color:#00AA00; margin-top:10px; margin-bottom:10px;">
                            <?=($rejeitados_30dias['total'] ? $rejeitados_30dias['total'] : 0);?>
                        </div>
                        <div style="font-weight:300; font-size:14px; color:#999999; ">1 mês</div>
                    </div>

                </div>





                <div class="mdl-cell mdl-cell--12-col" style="text-align:center; background:white; padding:30px;">

                    <?

                    // define('DIAS_GRAFICO',60);



                    $groupby = 'pk_cod_project, txt_descricao_sta, substr(dat_registro_sta,1,10)';

                    $chart_labels = '';

                    $data_atual = $hoje;
                    // $data_atual = date('Y-m-d');
                    $data_inicio = $data_30dias;
                    // $data_inicio = date('Y-m-d',strtotime( $data_atual.' -29 days' ));

                    //zera todos os dias
                    for( $aux_arr = $data_inicio ; $aux_arr <=$data_atual ; $aux_arr=date('Y-m-d',strtotime( $aux_arr.' +1 days' ))  ){
                        
                        $ARR_requisicoes[$aux_arr] = 0;
                        $ARR_cliques[$aux_arr] = 0;
                        $ARR_rejeicoes[$aux_arr] = 0;

                        if( $chart_labels != ''){
                            $chart_labels .= ' , ';
                        }
                        $chart_labels .= " '".substr( formata_data($aux_arr) , 0,5)."' ";
                    }


                    
                    //REQUISICAO 60 DIAS
                    // $complemento_req_60dias = ' 
                    // AND dat_registro_sta > \''.$data_60dias.'\'
                    // AND txt_descricao_sta = \'RECURSO APRESENTADO\' ';
                    // $aux_60dias = sql_select($conn,$table,$order,$where.$complemento_req_60dias,$fields,NULL,$groupby);

                    // //atualiza totais das datas encontradas
                    // while( $requisicoes_60dias = sql_fetch_array($aux_60dias) ){
                    //     $ARR_requisicoes[$requisicoes_60dias['data']] = $requisicoes_60dias['total'];
                    // }

                    //REQUISICAO 30 DIAS
                    $complemento_req_30dias = ' 
                    AND dat_registro_sta > \''.$data_30dias.'\'
                    AND txt_descricao_sta = \'RECURSO APRESENTADO\' ';
                    $aux_30dias = sql_select($conn,$table,$order,$where.$complemento_req_30dias,$fields,NULL,$groupby);

                    //atualiza totais das datas encontradas
                    while( $requisicoes_30dias = sql_fetch_array($aux_30dias) ){
                        $ARR_requisicoes[$requisicoes_30dias['data']] = $requisicoes_30dias['total'];
                    }

                    $dataset_requisicoes = '';

                    foreach( $ARR_requisicoes as $DS_requisicoes ){
                            if( $dataset_requisicoes != ''){
                                $dataset_requisicoes .= ' , ';
                            }
                            $dataset_requisicoes .= ' '.$DS_requisicoes.' ';
                    } 

                    
                    //CLIQUES 60 DIAS
                    // $complemento_cliques_60dias = ' 
                    // AND dat_registro_sta > \''.$data_60dias.'\'
                    // AND txt_descricao_sta = \'RECURSO CLICADO\' ';
                    // $aux_60dias = sql_select($conn,$table,$order,$where.$complemento_cliques_60dias,$fields,NULL,$groupby);

                    // //atualiza totais das datas encontradas
                    // while( $cliques_60dias = sql_fetch_array($aux_60dias) ){
                    //     $ARR_cliques[$cliques_60dias['data']] = $cliques_60dias['total'];
                    // }

                    //CLIQUES 30 DIAS
                    $complemento_cliques_30dias = ' 
                    AND dat_registro_sta > \''.$data_30dias.'\'
                    AND txt_descricao_sta = \'RECURSO CLICADO\' ';
                    $aux_30dias = sql_select($conn,$table,$order,$where.$complemento_cliques_30dias,$fields,NULL,$groupby);

                    //atualiza totais das datas encontradas
                    while( $cliques_30dias = sql_fetch_array($aux_30dias) ){
                        $ARR_cliques[$cliques_30dias['data']] = $cliques_30dias['total'];
                    }

                    $dataset_cliques = '';

                    foreach( $ARR_cliques as $DS_cliques ){
                            if( $dataset_cliques != ''){
                                $dataset_cliques .= ' , ';
                            }
                            $dataset_cliques .= ' '.$DS_cliques.' ';
                    } 

                    
                    //REJEITADOS 60 DIAS
                    // $complemento_rejeitados_60dias = ' 
                    // AND dat_registro_sta > \''.$data_60dias.'\'
                    // AND txt_descricao_sta = \'RECURSO REJEITADO\' ';
                    // $aux_60dias = sql_select($conn,$table,$order,$where.$complemento_rejeitados_60dias,$fields,NULL,$groupby);

                    // //atualiza totais das datas encontradas
                    // while( $rejeitados_60dias = sql_fetch_array($aux_60dias) ){
                    //     $ARR_rejeicoes[$rejeitados_60dias['data']] = $rejeitados_60dias['total'];
                    // }

                    //REJEITADOS 30 DIAS
                    $complemento_rejeitados_30dias = ' 
                    AND dat_registro_sta > \''.$data_30dias.'\'
                    AND txt_descricao_sta = \'RECURSO REJEITADO\' ';
                    $aux_30dias = sql_select($conn,$table,$order,$where.$complemento_rejeitados_30dias,$fields,NULL,$groupby);

                    //atualiza totais das datas encontradas
                    while( $rejeitados_30dias = sql_fetch_array($aux_30dias) ){
                        $ARR_rejeicoes[$rejeitados_30dias['data']] = $rejeitados_30dias['total'];
                    }

                    $dataset_rejeitados = '';

                    foreach( $ARR_rejeicoes as $DS_rejeitados ){
                            if( $dataset_rejeitados != ''){
                                $dataset_rejeitados .= ' , ';
                            }
                            $dataset_rejeitados .= ' '.$DS_rejeitados.' ';
                    } 




                    //RELAÇÕES
                    //PORCENTAGEM DE CLIQUES POR APRESENTACOES
                    // foreach(array_combine($ARR_cliques, $ARR_requisicoes) AS $valor1 => $valor2) {
                    foreach( $ARR_cliques as $key => $value) {
                        
                        if( @$dataset_cliques_relacao != ''){
                            @$dataset_cliques_relacao .= ' , ';
                        }
                        // if( $value <= $valor2 && $valor2>0 ){
                            @$dataset_cliques_relacao .= ' '.number_format( ($value/$ARR_requisicoes[$key])*100 , 0 , "" , "" ).' ';
                        // } else {
                            // @$dataset_cliques_relacao .= ' 0 ';
                        // }

                        // echo '<br /> ('.$value/$ARR_requisicoes[$key].') = '.number_format( ($value/$ARR_requisicoes[$key])*100 , 0 , "" , "" ).'%';

                    }
                    //PORCENTAGEM DE REJEICOES POR APRESENTACOES
                    // echo '<pre>';
                    // var_dump($ARR_rejeicoes);
                    // echo '</pre>';
                    // foreach(array_combine($ARR_rejeicoes, $ARR_requisicoes) AS $valor1 => $valor2) {
                    foreach( $ARR_rejeicoes as $key => $value) {
                        
                        if( @$dataset_rejeitados_relacao != ''){
                            @$dataset_rejeitados_relacao .= ' , ';
                        }
                        // if( $valor1 <= $valor2 && $valor2>0 ){
                            @$dataset_rejeitados_relacao .= ' '.number_format( ($value/$ARR_requisicoes[$key])*100 , 0 , "" , "" ).' ';
                        // } else {
                            // @$dataset_rejeitados_relacao .= ' 0 ';
                        // }

                        // echo '<br /> ('.$value/$ARR_requisicoes[$key].') = '.number_format( ($value/$ARR_requisicoes[$key])*100 , 0 , "" , "" ).'%';
                    }

                    ?>


                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">EVOLUÇÃO ÚLTIMOS 30 DIAS</div>

                    <DIV style="max-width:1100px; width:100%; margin-left:auto; margin-right:auto; overflow:hidden; ">

                        <canvas id="myChart_1" width="1100" height="250"></canvas>

                        <script>
                            var ctx = document.getElementById("myChart_1");
                            

                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                labels: [<?=$chart_labels;?>],
                                datasets: [
                                    
                                    {
                                        label: "Apresentados",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(255,0,0,0.4)",
                                        borderColor: "rgba(255,0,0,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(255,0,0,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(255,0,0,1)",
                                        pointHoverBorderColor: "rgba(255,0,0,1)",
                                        pointHoverBorderWidth: 1,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [<?=$dataset_requisicoes;?>],
                                        spanGaps: false,
                                    },

                                    {
                                        label: "Clicados",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(0,0,200,0.4)",
                                        borderColor: "rgba(0,0,200,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(0,0,200,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0,0,200,1)",
                                        pointHoverBorderColor: "rgba(0,0,200,1)",
                                        pointHoverBorderWidth: 1,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [<?=$dataset_cliques;?>],
                                        spanGaps: false,
                                    },

                                    {
                                        label: "Rejeitados",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(0,200,0,0.4)",
                                        borderColor: "rgba(0,200,0,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(0,200,0,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0,200,0,1)",
                                        pointHoverBorderColor: "rgba(0,200,0,1)",
                                        pointHoverBorderWidth: 1,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [<?=$dataset_rejeitados;?>],
                                        spanGaps: false,
                                    }
                                ]
                            },
                                options: {
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

                    </DIV>


                    <Br /><br />



                    <div style="font-weight:300; font-size:14px; color:#CCCCCC; ">EVOLUÇÃO ÚLTIMOS 30 DIAS</div>

                    <DIV style="max-width:1100px; width:100%; margin-left:auto; margin-right:auto; overflow:hidden;">

                        <canvas id="myChart_2" width="1100" height="250"></canvas>

                        <script>
                            var ctx = document.getElementById("myChart_2");
                            

                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                labels: [<?=$chart_labels;?>],
                                datasets: [

                                    {
                                        label: "% Clicados",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(0,0,200,0.4)",
                                        borderColor: "rgba(0,0,200,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(0,0,200,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0,0,200,1)",
                                        pointHoverBorderColor: "rgba(0,0,200,1)",
                                        pointHoverBorderWidth: 1,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [<?=$dataset_cliques_relacao;?>],
                                        spanGaps: false,
                                    },

                                    {
                                        label: "% Rejeitados",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(0,200,0,0.4)",
                                        borderColor: "rgba(0,200,0,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(0,200,0,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0,200,0,1)",
                                        pointHoverBorderColor: "rgba(0,200,0,1)",
                                        pointHoverBorderWidth: 1,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [<?=$dataset_rejeitados_relacao;?>],
                                        spanGaps: false,
                                    }
                                ]
                            },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                // beginAtZero:true,
                                                min:0,
                                                max:100,
                                                callback: function(value){
                                                    return value + "%"
                                                }
                                            },
                                           scaleLabel: {
                                               display: true,
                                               labelString: "Porcentagem"
                                           }
                                        }]
                                    }
                                }
                            });
                            </script>

                    </DIV>

                </div><!-- mdl-cell-12 -->




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
