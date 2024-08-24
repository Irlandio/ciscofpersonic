<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/dist/excanvas.min.js"></script><![endif]-->

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>

<!--Action boxes-->
<div class="container-fluid">
    <h5> CiScoFiP (Cadastro de Informação e Suporte de controle Financeiro Pessoal)</h5>
    <div class="quick-actions_homepage">
        <ul class="quick-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) { ?>
                <!-- <li class="bg_db"> <a href="<?php echo base_url() ?>index.php/vendas"><i class="icon-folder-open"></i> Lançamentos</a></li> -->
            <?php } ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                <!-- <li class="bg_ls"> <a href="<?php echo base_url() ?>index.php/clientes"> <i class="icon-group"></i> Beneficiários</a> </li> -->
            <?php } ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {  ?>
                <li class="bg_ls"> <a href="<?php echo base_url() ?>index.php/produtos"> <i class="icon-group"></i> Abastecimentos</a></li>
            <?php  } ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) { ?>
                <!-- <li class="bg_db"> <a href="<?php echo base_url() ?>index.php/servicos"> <i class="icon-group"></i> Códigos</a> </li> -->
            <?php } ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) { ?>
                <li class="bg_ls"> <a href="<?php echo base_url() ?>index.php/financeiro/lancamentos?periodo=todos&situacao=todos"> <i class="icon-tags"></i> R. Bancária</a> </li>
            <?php } ?>


        </ul>
    </div>
</div>
<!--End-Action boxes-->



<?php if ($os != null) { ?>
    <div class="row-fluid" style="margin-top: 0">

        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
                    <h5>Quantidades de Lançamentos no mês atual</h5>
                    <?php
                    $caixaNome[1] = "IEADALPE - 1444-3";
                    $total[1] = 0;
                    $caixaNome[2] = "22360-3";
                    $total[2] = 0;
                    $caixaNome[3] = "ILPI";
                    $total[3] = 0;
                    $caixaNome[4] = "BR214";
                    $total[4] = 0;
                    $caixaNome[5] = "BR518";
                    $total[5] = 0;
                    $caixaNome[6] = "BR542";
                    $total[6] = 0;
                    $caixaNome[7] = "BR549";
                    $total[7] = 0;
                    $caixaNome[8] = "BR579";
                    $total[8] = 0;
                    $caixaNome[9] = "BB 28965-5";
                    $total[9] = 0;
                    $caixaNome[10] = "CEF 1948-4";
                    $total[10] = 0;
                    $cor[1] = "#0085cc";
                    $cor[2] = "#0085cc";
                    $cor[3] = "#0085cc";
                    $cor[4] = "#4b5de4";
                    $cor[5] = "#4b5de4";
                    $cor[6] = "#4b5de4";
                    $cor[7] = "#4b5de4";
                    $cor[8] = "#4b5de4";
                    $cor[9] = "#0085cc";
                    $cor[10] = "#0085cc";
                    foreach ($os as $o) {
                        switch ($o->conta) {
                            case 1:
                                ++$total[1];
                                $cor[1] = "#0085cc";
                                break;
                            case 2:
                                ++$total[2];
                                $cor[2] = "#0085cc";
                                break;
                            case 3:
                                ++$total[3];
                                $cor[3] = "#0085cc";
                                break;
                            case 4:
                                ++$total[4];
                                $cor[4] = "#4b5de4";
                                break;
                            case 5:
                                ++$total[5];
                                $cor[5] = "#4b5de4";
                                break;
                            case 6:
                                ++$total[6];
                                $cor[6] = "#4b5de4";
                                break;
                            case 7:
                                ++$total[7];
                                $cor[7] = "#4b5de4";
                                break;
                            case 8:
                                ++$total[8];
                                $cor[8] = "#4b5de4";
                                break;
                            case 9:
                                ++$total[9];
                                $cor[9] = "#0085cc";
                                break;
                            case 10:
                                ++$total[10];
                                $cor[10] = "#0085cc";
                                break;
                        }
                        // echo "['".$caixaNome."', ".$o->total."],";
                    }
                    ?>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span8">

                            <div id="chart-os" style=""></div>
                        </div>

                        <div class="span4">
                            <table class="table table-bordered ">
                                <tbody>
                                    <?php
                                    for ($i = 4; $i <= 8; $i++) {
                                        if ($i < 7) $ii = $i - 3;
                                        else  if ($i > 6) $ii = $i + 2;
                                        echo '<tr> <td><span class="badge" style="background-color: ' . $cor[$i] . '; border-color: ' . $cor[$i] . '">' . $total[$i] . ' - ' . $caixaNome[$i] . '</span></td> <td><span class="badge" style="background-color: ' . $cor[$ii] . '; border-color: ' . $cor[$ii] . '">' . $total[$ii] . ' - ' . $caixaNome[$ii] . '</span></td> </tr> ';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<div class="row-fluid" style="margin-top: 0">

    <div class="span12">

        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
                <h5>Ultimos lançamentos</h5>
            </div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Conta</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Usuário</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($lancamentos != null) {
                            foreach ($lancamentos as $rl) {
                                if ($rl->ent_Sai == 1) {
                                    $sinal = " ";
                                    $corV = "#130be0";
                                } else {
                                    $sinal = "-";
                                    $corV = "#fa0606";
                                }
                                $valorFinExibe  =    number_format(str_replace(",", ".", $rl->valorFin), 2, ',', '.');
                                $dataVenda = explode('-', $rl->dataFin);
                                $dataF = $dataVenda[2] . '/' . $dataVenda[1] . '/' . $dataVenda[0];
                                echo '<tr>';
                                echo '<td>' . $rl->nome_caixa . '</td>';
                                echo '<td>' . $rl->historico . '</td>';
                                echo '<td>' . $dataF . '</td>';
                                echo '<td  style="text-align:right;">R$ <font color=' . $corV . '>' . $sinal . '  ' . $valorFinExibe . '</font></td>';
                                echo '<td>' . $rl->nome . '</td>';
                                echo '<td>';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eUsuario')) {
                                    echo '<a href="' . base_url() . 'index.php/produtos/editar/' . $rl->id_fin . '" class="btn btn-info"> <i class="icon-pencil" ></i> </a>  ';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3">Nenhum produto com estoque baixo.</td></tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="span12" style="margin-left: 0">

        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
                <h5>Presentes em aberto</h5>
            </div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Data Inicial</th>
                            <th>Conta</th>
                            <th>BR Beneficiário</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($ordens != null) {
                            foreach ($ordens as $o) {

                                echo '<tr>';
                                echo '<td>' . $o->idOs . '</td>';
                                echo '<td>' . date('d/m/Y', strtotime($o->dataInicial)) . '</td>';
                                echo '<td>' . date('d/m/Y', strtotime($o->dataFinal)) . '</td>';
                                echo '<td>' . $o->nomeCliente . '</td>';
                                echo '<td>';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                    echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $o->idOs . '" class="btn"> <i class="icon-eye-open" ></i> </a> ';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3">Nenhum presente em aberto.</td></tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<?php if ($estatisticas_financeiro != null) {
    if ($estatisticas_financeiro->total_receita1C != null || $estatisticas_financeiro->total_despesa1C != null || $estatisticas_financeiro->total_despesa1S != null || $estatisticas_financeiro->total_despesa1S != null) {  ?>
        <div class="row-fluid" style="margin-top: 0">

            <div class="span4">

                <div class="widget-box">
                    <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
                        <h5>Estatísticas financeiras - Realizado</h5>
                    </div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span12">
                                <div id="chart-financeiro" style=""></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="span4">

                <div class="widget-box">
                    <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
                        <h5>Estatísticas financeiras - Pendente</h5>
                    </div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span12">
                                <div id="chart-financeiro2" style=""></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="span4">

                <div class="widget-box">
                    <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
                        <h5>Total em caixa / Previsto</h5>
                    </div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span12">
                                <div id="chart-financeiro-caixa" style=""></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
<?php }
} ?>

<div class="row-fluid" style="margin-top: 0">

    <div class="span12">

        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
                <h5>Estatísticas do Sistema</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                        <ul class="site-stats">
                            <li class="bg_lh"><i class="icon-tags"></i> <strong><?php echo $this->db->count_all('caixas'); ?></strong> <small>Contas</small></li>
                            <li class="bg_lh"><i class="icon-barcode"></i> <strong><?php echo $this->db->count_all('usuarios'); ?></strong> <small>Usuários </small></li>
                            <li class="bg_lh"><i class="icon-group"></i> <strong><?php echo $this->db->count_all('clientes'); ?></strong> <small>Beneficiários</small></li>
                            <li class="bg_lh"><i class="icon-wrench"></i> <strong><?php echo $this->db->count_all('aenpfin'); ?></strong> <small>Lançamentos</small></li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>


<?php if ($os != null) { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var data = [
                <?php
                if ($usuario->conta_Usuario > 3 && $usuario->conta_Usuario < 9) {
                    for ($i = 4; $i <= 8; $i++) {
                        echo "['" . $caixaNome[$i] . "', " . $total[$i] . "],";
                    }
                } else {
                    for ($i = 1; $i <= 10; $i++) {
                        echo "['" . $caixaNome[$i] . "', " . $total[$i] . "],";
                    }
                }
                ?>

            ];
            var plot1 = jQuery.jqplot('chart-os', [data], {
                seriesDefaults: {
                    // Make this a pie chart.
                    renderer: jQuery.jqplot.PieRenderer,
                    rendererOptions: {
                        // Put data labels on the pie slices.
                        // By default, labels show the percentage of the slice.
                        showDataLabels: true
                    }
                },
                legend: {
                    show: true,
                    location: 'e'
                }
            });

        });
    </script>

<?php } ?>


<?php if (isset($estatisticas_financeiro) && $estatisticas_financeiro != null) {
    if ($estatisticas_financeiro->total_receita1C != null || $estatisticas_financeiro->total_despesa1C != null || $estatisticas_financeiro->total_despesa1C != null || $estatisticas_financeiro->total_despesa1S != null) {
?>
        <script type="text/javascript">
            $(document).ready(function() {

                var data2 = [
                    ['Total Receitas', <?php echo ($estatisticas_financeiro->total_receita1C != null) ?  $estatisticas_financeiro->total_receita1C : '0.00'; ?>],
                    ['Total Despesas', <?php echo ($estatisticas_financeiro->total_despesa1C != null) ?  $estatisticas_financeiro->total_despesa1C : '0.00'; ?>]
                ];
                var plot2 = jQuery.jqplot('chart-financeiro', [data2], {

                    seriesColors: ["#9ACD32", "#FF8C00", "#EAA228", "#579575", "#839557", "#958c12", "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],
                    seriesDefaults: {
                        // Make this a pie chart.
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {
                            // Put data labels on the pie slices.
                            // By default, labels show the percentage of the slice.
                            dataLabels: 'value',
                            showDataLabels: true
                        }
                    },
                    legend: {
                        show: true,
                        location: 'e'
                    }
                });


                var data3 = [
                    ['Total Receitas', <?php echo ($estatisticas_financeiro->total_receita1S != null) ?  $estatisticas_financeiro->total_receita1S : '0.00'; ?>],
                    ['Total Despesas', <?php echo ($estatisticas_financeiro->total_despesa1S != null) ?  $estatisticas_financeiro->total_despesa1S : '0.00'; ?>]
                ];
                var plot3 = jQuery.jqplot('chart-financeiro2', [data3], {

                        seriesColors: ["#90EE90", "#FF0000", "#EAA228", "#579575", "#839557", "#958c12", "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],
                        seriesDefaults: {
                            // Make this a pie chart.
                            renderer: jQuery.jqplot.PieRenderer,
                            rendererOptions: {
                                // Put data labels on the pie slices.
                                // By default, labels show the percentage of the slice.
                                dataLabels: 'value',
                                showDataLabels: true
                            }
                        },
                        legend: {
                            show: true,
                            location: 'e'
                        }
                    }

                );


                var data4 = [
                    ['Total em Caixa', <?php echo ($estatisticas_financeiro->total_receita - $estatisticas_financeiro->total_despesa); ?>],
                    ['Total a Entrar', <?php echo ($estatisticas_financeiro->total_receita_pendente - $estatisticas_financeiro->total_despesa_pendente); ?>]
                ];
                var plot4 = jQuery.jqplot('chart-financeiro-caixa', [data4], {

                        seriesColors: ["#839557", "#d8b83f", "#d8b83f", "#ff5800", "#0085cc"],
                        seriesDefaults: {
                            // Make this a pie chart.
                            renderer: jQuery.jqplot.PieRenderer,
                            rendererOptions: {
                                // Put data labels on the pie slices.
                                // By default, labels show the percentage of the slice.
                                dataLabels: 'value',
                                showDataLabels: true
                            }
                        },
                        legend: {
                            show: true,
                            location: 'e'
                        }
                    }

                );


            });
        </script>

<?php }
} ?>