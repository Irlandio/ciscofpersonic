<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/dist/excanvas.min.js"></script><![endif]-->
<?php if("http://127.0.0.1:80/ciscofpersonic/" == base_url())
{ $urlAux = "http://127.0.0.1:80/ciscodtk/";}else
    { $urlAux = "http://imprimadesign.tk/"; }
    $urlAux = 'http://ciscof-aenpazfin.net/';
?>
<script language="javascript" type="text/javascript" src="<?php echo $urlAux;?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>

<!--Action boxes-->
  <div class="container-fluid">
      <h5> CiScoFiP (Cadastro de Informação e Suporte de controle Financeiro Pessoal)</h5>
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){ ?>
            <li class="bg_db"> <a href="<?php echo base_url()?>index.php/vendas"><i class="icon-folder-open"></i> Lançamentos</a></li>
<!--
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
            <li class="bg_ls"> <a href="<?php echo base_url()?>index.php/clientes"> <i class="icon-group"></i> Beneficiários</a> </li>
        <?php } ?>
-->
<!--
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){  ?>
            <li class="bg_ls"> <a href="<?php echo base_url()?>index.php/produtos"> <i class="icon-group"></i> Presentes Especiais <font color='#e6f805'> Novo</font></a></li>
        <?php  } ?>
-->
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){ ?>
            <li class="bg_db"> <a href="<?php echo base_url()?>index.php/servicos"> <i class="icon-group"></i> Códigos</a> </li>
        <?php } ?>
<!--
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
            <li class="bg_ls"> <a href="<?php echo base_url()?>index.php/financeiro/lancamentos?periodo=todos&situacao=todos"> <i class="icon-tags"></i> R. Bancária</a> </li>
        <?php } ?>        
-->
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
            <li class="bg_ls"> <a href="<?php echo base_url()?>index.php/relatorios/financeiro"> <i class="icon-tags"></i> Relatórios</a> </li>
        <?php } ?>    

        
      </ul>
    </div>
        <?php if( 1==12) { ?>        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>cod</th>
                        <th>Saldo</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
            <?php
                    echo '<tr><td colspan=7>'.$fatur.'<td></tr>';
                //  var_dump($lanceCredFaturas); 
                foreach ($lanceCredFaturas as $st) {
            //if($st->par_ES != null)
            {
                    echo '<tr>';
                    echo '<td>'.$st->id_fin.'</td>';
                    echo '<td>'.$st->historico.' '.$st->descricao.'</td>';
                    echo '<td>'.$st->par_ES.'</td>';
                    echo '<td>'.$st->num_Doc_Banco.'</td>';
                    echo '<td>'.$st->dataEvento.'</td>';
                    echo '<td>'.$st->valorFin.'</td>';
                    echo '<td>R$ '.number_format($st->valorFin, 2, ',', '.').'</td>';
                    echo '<td>';
                    echo '</tr>';
            }
                }

                  ?>
                </tbody>
            </table>
        <?php } ?>    
  </div>  
<!--End-Action boxes-->
<?php if($os != null){ ?>
<div class="accordion" id="collapse-group">
        <div class="accordion-group widget-box">
            <div class="accordion-heading">
                <div class="widget-title">
                    <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                        <span class="icon"><i class="icon-list"></i></span><h5>Quantidades de Lançamentos no mês atual</h5>
                    </a>
                </div> 
            </div>             
                <?php
                {
                    $cor[0] = "#839557";
                    $cor[1] = "#f2938f";
                    $cor[2] = "#d11109";
                    $cor[3] = "#d8b83f";
                    $cor[4] = "#0d1d98";
                    $cor[5] = "#10a527";
                   $i=0;
                foreach ($c_Custos as $c)
                      {
                        $i++;
                        $cC = $i%6;
                        $c_Custo[$c->cod_Comp] = $c->cod_Comp; 
                        $total1[$c->cod_Comp] = 0;  
                        $total0[$c->cod_Comp] = 0; 
                        $cor[$c->cod_Comp]= $cor[$cC]; 
                      }
                $total1T = $total0T = $total0Pago = $total1Recebido = 0;
                foreach ($os as $o) 
                {
                    if($o->ent_Sai == 0 && isset($total0[$o->cod_compassion]))
                     {   $total0[$o->cod_compassion] += $o->valorFin;
                        if($o->num_Doc_Fiscal == "Efetuado" ) $total0Pago += $o->valorFin;
                         $total0T += $o->valorFin;
                     //echo 'D '.$o->valorFin.', ';
                     }
                    if($o->ent_Sai == 1  && isset($total1[$o->cod_compassion]))
                     {   $total1[$o->cod_compassion] += $o->valorFin;
                        if($o->num_Doc_Fiscal == "Efetuado" ) $total1Recebido += $o->valorFin;
                         $total1T += $o->valorFin;
                     //echo 'C '.$o->valorFin.', ';
                     }
                }
                $diferenca = abs($total1T-$total0T); //Diferença dos totais receita - despesa
                $total1TRelativo = $total1T>$total0T ? $total1T-$diferenca : $total1T;
                $total0TRelativo = $total0T>$total1T ? $total0T-$diferenca : $total0T;
                $saldoTXT = $total1T>$total0T ? "Saldo Positivo" : "Saldo Negativo";
                $saldPositivoTXT = "Receita Comprometida";
                $saldnegativoTXT = "Despesa Acobertada";
    
                $diferencaReal = $total1Recebido-$total0Pago;
                $EntradasReeal = $total1Recebido;
                $SaidasReeal = $total0Pago;
    
    
                $situacao = array();
                $sit = array();
                            $situacao['descri'] =   'Previstos';
                            $situacao['entrada'] =  $total1T;
                            $situacao['saida'] =    $total0T;    
                            $situacao['saldo'] =    $diferenca;
                $sit[] = $situacao;    
                            $situacao['descri'] =   'Efetuados';
                            $situacao['entrada'] =  $total1Recebido;
                            $situacao['saida'] =    $total0Pago;
                            $situacao['saldo'] =    $total1Recebido-$total0Pago;
                $sit[] = $situacao;
                }
                ?>
            <div class="collapse accordion-body" id="collapseGOne">
                <div class="widget-content">
                    <div class="span5"><h5>Saldo Previsto <?=$diferenca?></h5>
                    <div id="chart-saldo" style=""></div>
                    </div>
                    <div class="span5"><h5>Saldo Real <?=$diferencaReal?></h5>
                    <div id="chart-saldoReal" style=""></div>
                    </div>
                    <div class="span5"><h5>Créditos <?=$total1T?></h5>
                    <div id="chart-creditos" style=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-group widget-box">
            <div class="accordion-heading">
                <div class="widget-title">
                    <a data-parent="#collapse-group" href="#collapseGOne1" data-toggle="collapse">
                        <span class="icon"><i class="icon-list"></i></span><h5>Estatiticas de Saídas</h5>
                    </a>
                </div> 
            </div> 
            <div class="collapse accordion-body" id="collapseGOne1">
                <div class="widget-content">
                    <div class="span12" ><h5>Débitos <?=$total0T?></h5>
                    <div id="chart-debitos" style='height: 600px;'></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } 
    ?>
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Situação Atual</h5>
                </a>
            </div> 
        </div>             
        <div class="collapse accordion-body" id="collapseGTwo">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Entradas</th>
                            <th>Saídas</th>
                            <th>Saldo</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($sit as $st) {

                                echo '<tr>';
                                echo '<td><H4>'.$st['descri'].'</H4></td>';
                                echo '<td><font color=blue><H4>R$ '.number_format($st['entrada'], 2, ',', '.').'</H4></FONT></td>';
                                echo '<td><font color=red><H4>R$ '.number_format($st['saida'], 2, ',', '.').'</H4></FONT></td>';
                                echo '<td><font color=green><H4>R$ '.number_format($st['saldo'], 2, ',', '.').'</H4></FONT></td>';
                                echo '<td>';
                                echo '</td>';
                                echo '</tr>';
                            }

                        ?>
                    </tbody>
                </table>
        </div>
    </div>
    
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGThre" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Estatisticas previstas CARTÕES</h5>
                </a>
            </div> 
        </div>             
        <div class="collapse accordion-body" id="collapseGThre"><?php //var_dump($somaMeses[0]->tr); ?>
             <div class="span6">
                 
                  <table class="table table-bordered">
                    <tbody>
                        <?php
                        
                        $mes = array();
                        $mesSoma = array();
                        $dif = strtotime($datamax) - strtotime(date('Y-m-d'));

                        $meses = floor($dif / (60 * 60 * 24 * 30)) + 2;
                                echo '<tr><th>DIA</th><th>CARTÃO</th>';
                                $cFundoAnterior = ''; 
                       for ($i = 0; $i <  $meses; $i++ )
                        {
                           $j = $i-2;
                           $mes[$i] = date('y-m', strtotime("+".$j." month", strtotime(date('Y-m-d'))));
                           echo '<th><H4>'.date('M/y', strtotime("+".$j." month", strtotime(date('Y-m-d')))).'</H4></th>';          $mesSoma[$i] = 0;               
                        }
                                echo '</tr>';
                    foreach($lanceCredFaturass AS $lcF)
                        {
                            if($lcF->cod_assoc != $cFundoAnterior ){
                                $j = 0;
                                echo '<tr><td><H4>'.date('d', strtotime($lcF->dataFin)).'</H4></td>';
                                echo '<td><H4>'.$lcF->cod_assoc.'</H4></td>';
//                                echo '<td><H4>'.$lcF->cod_assoc.'</H4>'.date('y-m', strtotime($lcF->dataFin)).' $meses'.$meses.' $j='.$j.'</td>';
                            
                            }
                            for($l = $j; $l < $meses; $l++ )
                              {  
//                                    echo '<td> $j='.$j.' $l='.$l.' $mes[$l]='.$mes[$l].' m/Y='.date('y-m', strtotime($lcF->dataFin)).' Linha'.__LINE__.'</td>';
                                if( date('y-m', strtotime($lcF->dataFin)) < $mes[$l])
                                  {  
//                                   echo '<td> $j='.$j.' $l='.$l.' $mes[$l]='.$mes[$l].' m/Y='.date('y-m', strtotime($lcF->dataFin)).' Linha'.__LINE__.'</td>';
                                     $l = $meses;
                                  }
                                else
                                if( date('y-m', strtotime($lcF->dataFin)) == $mes[$l])
                                {
                                    $corFat = $lcF->num_Doc_Fiscal == 'Previsto' ?  "#d65b5b" : "#3252db";
                                    echo '<td><font color='.$corFat.'><H4>'.number_format($lcF->valorFin, 2, ',', '.').'</H4></font>'
//                                    echo '<td><font color='.$corFat.'><H4>'.number_format($lcF->valorFin, 2, ',', '.').'</H4>'.date('d/m', strtotime($lcF->dataFin)).'</font>'
//                                        .$lcF->cod_assoc.' '.date('m/y', strtotime($lcF->dataFin))
                                        .'</td>';
                                    $l = $meses;
                                    $mesSoma[$j] += $lcF->valorFin;
                                }else 
                                {
                                    echo '<td></td>'; 
//                                    echo '<td> $j='.$j.' $l='.$l.' $mes[$l]='.$mes[$l].' Linha'.__LINE__.'</td>'; 
                                    $j++;
                                }
                              }
                                $cFundoAnterior = $lcF->cod_assoc;
                                $j++;
                            }
                                echo '</tr><tr><th><h4>Totais</H4>';
                        
                           for ($i = 0; $i <  $meses; $i++ )
                            {
                               echo '<th><font color="#d65b5b"><H4>'.number_format($mesSoma[$i], 2, ',', '.').'</H4></font></th>';              
                            }
                                echo '</tr>';

                        ?>
                    </tbody>
                </table>
                 <?php
//                 
//                    foreach($lanceCredFaturass AS $lcF)
//                        {
//                            echo $lcF->cod_assoc.' '.$lcF->dataFin.' '.$lcF->id_fin.' '.$lcF->valorFin.'<br>';
//                    }
                 ?>
                 
            </div>
        </div>
    </div>
        
    <div class="accordion-group widget-box">
            <div class="accordion-heading">
                <div class="widget-title">
                    <a data-parent="#collapse-group" href="#collapseGfuor" data-toggle="collapse">
                        <span class="icon"><i class="icon-list"></i></span><h5>Estatisticas previstas RESUMIDAS</h5>
                    </a>
                </div> 
            </div>             
            <div class="collapse accordion-body" id="collapseGfuor"><?php //var_dump($somaMeses[0]->tr); ?>
                 <div class="span8">


                        <?php
                        $totalFaturas = $totalLimites = $qtdTot = $somaTotFundoPrevG = 0; $i= 0;
                        $saldoAtual = 0;
                    foreach ($somaMeses as $rSoma) 
                    { $i++; 

                     ?>

                     <?php 
                        if  ($i == 1) {?>                         
                        <div class="accordion-heading">
                            <div class="widget-title">
                            <a data-parent="#collapse-group1" href="#collapseGSix" data-toggle="collapse">
                                <span class="icon"></span>
                            <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="15%">MÊS</th>
                                            <th width="35%">SALDO FINAL</th>
                                            <th width="15%">ENTRADAS</th>
                                            <th width="15%">SAI (CRÉDITO)</th>
                                            <th width="12%">SAI (DÉBITO)</th>
                                            <th width="15%">#</th>
                                        </tr>
                                    </thead>
                                </table>
                                </a>
                            </div> 
                        </div> 
                       <?php 
                        }?>                        
                        <div class="accordion-heading">
                            <div class="widget-title">
                            <a data-parent="#collapse-group1" href="#collapseGSix1<?=$i?>" data-toggle="collapse">
                                <span class="icon"></span>
                            <table class="table table-bordered">
                                    <thead>
                                       <tr>                 
                                           <th width="15%"><font color=black><H4><?= date('M/Y', strtotime($rSoma->dataI))?></H4></font></th>
                                           <?php $sm = $rSoma->tr-($rSoma->tdD+$rSoma->tdC); 
                                           $crS = $sm < 0 ? "red" : "blue"; ?>
                                           <th width="40%"><font color="<?= $crS ?>" ><H4><?=number_format($sm, 2, ',', '.')?></H4></font></th> 
                                           <th width="15%"><font color="#3252db"><H4><?=number_format($rSoma->tr, 2, ',', '.')?></H4></font></th>      
                                           <th width="15%"><font color="#d65b5b"><H4><?=number_format($rSoma->tdC, 2, ',', '.')?></H4></font></th> 
                                           <th width="15%"><font color=d65b5b><H4><?=number_format($rSoma->tdD, 2, ',', '.')?></H4></font></th> 
                                           <th width="15%"><font color=black><H4>SALDO</H4></font></th> 
                                       </tr>
                                    </thead>
                                </table>
                                </a>
                            </div> 
                        </div> <BR>         
                        <div class="collapse accordion-body" id="collapseGSix1<?=$i?>">
                            <div  style="overflow:scroll;height:50;width:100%; overflow:auto">
                              <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>DtaS</th>
                                                <th>Fundo Financeiro</th>
                                                <th>Descrição</th>
                                                <th>ENTRADAS</th>
                                                <th colspan="2">SAÍDAS</th>
                                                <th>SALDO</th>
                                            </tr>
                                        </thead>
                                 <?php       
                                foreach ($lancFuturos as $rF) 
                                { 
                                    if(($rF->cod_assoc != 'D-BT' && $rF->num_Doc_Banco == '0/0' && $rF->cod_assoc != 'C-EMP') 
                                        || ($rF->cod_assoc == 'C-EMP' && $rF->num_Doc_Banco != '0/0') 
                                       || $rF->cod_assoc == 'D-BT' || $rF->cod_assoc == 'C-ALT' )
                                    {
                                       $status = $rF->num_Doc_Fiscal;
                                       $corStatus = $status == 'Previsto' ? "#d15609" : "#10a527";
                                    if( date('m/Y', strtotime($rF->dataFin)) == date('m/Y', strtotime($rSoma->dataI))){
                                        $debdNum = $credNum = $entradNum = ''; 
                                        if($rF->ent_Sai == 0)
                                        {
                                            $saldoAtual -= $rF->valorFin;
                                            if($rF->cod_assoc != 'D-BT') 
                                                {
                                                    $credNum = number_format($rF->valorFin, 2, ',', '.'); 
                                                }else{
                                                        $debdNum = number_format($rF->valorFin, 2, ',', '.');
                                                    }
                                        }else
                                            {
                                                $saldoAtual += $rF->valorFin;
                                                $entradNum = number_format($rF->valorFin, 2, ',', '.');
                                            }
                                            $status != 'Previsto' ? 
                                            ($corSaldo = $saldoAtual < 0 ? 'red' : 'blue') :  
                                            ($corSaldo = $saldoAtual < 0 ? "#f78b48" : "#3f6acb");
                                            $saldoAtualText = number_format($saldoAtual, 2, ',', '.');
                                        ?> 
                                   <tr>                 
                                       <th width="15%">
                                           <font color=blue><?=date('d/m/Y', strtotime($rF->dataFin))?></font>
                                           <font color='<?=$corStatus?>'><?=$status?></font> 
                                       </th>      
                                       <th width="20%"><font color=green><?=$rF->descricao_Ass ?></font></th> 
                                       <th width="20%"  style="background:<?=$corStatus?>"><font color=green>
                                                 <?php
                                                if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                                    echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$rF->id_fin.'" target="_blank" class="btn tip-top" title="Ver mais detalhes">'.$rF->descricao.'</a>'; }?></font></th> 
                                       <th width="15%"><font color=blue><H5><?=$entradNum?></H5></font></th>
                                       <th width="15%"><font color=red><H5><?=$credNum?></H5></font></th>
                                       <th width="15%"><font color=red><H5><?=$debdNum?></H5></font></th> 
                                       <th width="15%" style="text-align: right"><font color='<?=$corSaldo?>'><H5><?=$saldoAtualText?></H5></font></th> 
                                   </tr>

                                  <?php } }     
                                }?>
                             </table>
                            </div>
                        </div>

                        <?php 
                    }  
                     ?> 
                </div>
            </div>
        </div>

    <div class="accordion-group widget-box">
        <?php  ?>
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGFive" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Faturas cartões</h5>
                </a>
            </div> 
        </div>             
        <div class="collapse accordion-body" id="collapseGFive">
                <div class="span8" >
                   <?php 
                    $totalFaturas = $totalLimites = $qtdTot = $somaTotFundoPrevG = 0; $i= 0;
                     $mesAtual = date('Y-m-01'); 
                    foreach($cFundos AS $cF)
                        { $i++;
                            if($cF->area == 'CRÉDITO')
                            { $txt = '';
                                $tabela = '<table class="table table-bordered">
                                              <thead>
                                                 <tr>
                                                    <th>#</th>
                                                    <th>Data</th>
                                                    <th>Descrição</th>
                                                    <th>Valor</th>
                                                    <th>Parcela</th>
                                                </tr> 
                                            </thead>
                                           <tbody>';
                                $somaTotFundo = $somaTotFundoPrev = $qtdLancMes = $qtdLancFundo = 0;
                            foreach($lanceCredito AS $cLC)
                            { 
                                if($cF->cod_Ass == $cLC->cod_assoc)
                                {
                                   // $txt .= ", ".$cLC->dataFin;
                                    $qtdLancFundo++;
                                    $somaTotFundoPrev += $cLC->valorFin;                                
                                    if($cLC->dataFin == $dataprxFatura[$cF->cod_Ass])
                                       { $somaTotFundo += $cLC->valorFin;
                                        $qtdLancMes++;
                                        $tabela .= '<tr>
                                                        <td>'.$cLC->id_fin.'</td>
                                                        <td>'.date('d/m/Y', strtotime($cLC->dataEvento)).'</td>
                                                        <td>'.$cLC->historico.' '.$cLC->descricao.'</td>
                                                        <td><font color=blue><H5>'.number_format($cLC->valorFin, 2, ',', '.').'</H5></font></td>
                                                        <td>'.$cLC->num_Doc_Banco.'</td>
                                                    </tr>';}
                                    }
                            }
                                $tabela .= '</tbody></table>';
                             $qtdTot = $qtdLancFundo;
                            $somaTotFundoPrevG += $somaTotFundoPrev;
                            ?>                                
                        <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group1" href="#collapseGFive<?=$i?>" data-toggle="collapse">
                                <span class="icon"><i class="icon-list"></i></span><h5><?=$cF->cod_Ass?> (<?= date('d/m/y', strtotime($dataprxFatura[$cF->cod_Ass])) ?>) <?= number_format(($cF->limite - $somaTotFundoPrev), 2, ',', '.') ?> | <font color=blue><?=number_format($somaTotFundo, 2, ',', '.')?></font><br>  <?=$cF->descricao_Ass?> (<?= $qtdLancMes.' Lançamentos '?>)</h5>
                            </a>
                        </div> 
                    </div>  <br>           
                    <div class="collapse accordion-body" id="collapseGFive<?=$i?>">
                        <div class="span8" ><br>
                            <?=$tabela?>
                        </div>
                    </div>
                        <?php
                            $totalFaturas += $somaTotFundo;
                            $totalLimites += $cF->limite;

                        }
                    }?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Faturas atuais</th>
                                <th>Utilizado</th>
                                <th>Disponivel</th>
                                <th>Limite</th>
                            </tr>    
                        
                        </thead>
                        <tbody>
                                <tr>
                                    <td>    </td>
                                    <td><font color=red><H5>R$ <?=number_format($totalFaturas, 2, ',', '.')?></H5></font></td>
                                    <td><font color=red><H5>R$ <?=number_format($somaTotFundoPrevG, 2, ',', '.')?></H5></font></td>
                                    <td><font color=blue><H5>R$ <?=number_format(($totalLimites-$somaTotFundoPrevG), 2, ',', '.')?></H5></font></td>
                                    <td>  <?= number_format(($totalLimites), 2, ',', '.') ?>  </td>
                                </tr>
                        </tbody>                        
                    </table>
        </div>
        </div>
    </div><?php 
    //var_dump($somaMesEnt3);
    if($estatisticas_financeiro != null){ 
          if($estatisticas_financeiro->total_receita1C != null || $estatisticas_financeiro->total_despesa1C != null || $estatisticas_financeiro->total_despesa1S != null || $estatisticas_financeiro->total_despesa1S != null){  ?>
   

    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGFuor" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Estatisticass futuras</h5>
                </a>
            </div> 
        </div>             
        <div class="collapse accordion-body" id="collapseGFuor">
        <div class="span4">

            <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estatísticas financeiras - Realizado</h5></div>
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
                <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estatísticas financeiras - Pendente</h5></div>
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
                <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Total em caixa / Previsto</h5></div>
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
    </div>
    <?php } } ?>
</div>
    <div class="row-fluid" style="margin-top: 0">

        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estatísticas do Sistema</h5></div>
                <div class="widget-content">
                    <div class="row-fluid">           
                        <div class="span12">
                            <ul class="site-stats">
                                <li class="bg_lh"><i class="icon-tags"></i> <strong><?php echo $this->db->count_all('caixas');?></strong> <small>Contas</small></li>
                                <li class="bg_lh"><i class="icon-barcode"></i> <strong><?php echo $this->db->count_all('usuarios');?></strong> <small>Usuários </small></li>
                                <li class="bg_lh"><i class="icon-group"></i> <strong><?php echo $this->db->count_all('clientes');?></strong> <small>Beneficiários</small></li>
                                <li class="bg_lh"><i class="icon-wrench"></i> <strong><?php echo $this->db->count_all('aenpfin');?></strong> <small>Lançamentos</small></li>

                            </ul>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<?php //if($c_Custos != null) 
{?>
<script type="text/javascript">    
    $(document).ready(function(){
            var dataSR = [
                        <?php 
                      {
                           echo "['Entradas Efetuadas R$".$EntradasReeal."', ".$EntradasReeal."],";
                           echo "['Saidas Pagas R$".$SaidasReeal."', ".$SaidasReeal."],";
                           echo "['Saldo Real R$".$diferencaReal."', ".abs($diferencaReal)."],";
                      }
                ?>
              ];
              var plot = jQuery.jqplot ('chart-saldoReal', [dataSR], 
                {  seriesDefaults: {
                    renderer: jQuery.jqplot.PieRenderer, 
                    rendererOptions: {
                      showDataLabels: true   }  }, 
                  legend: { show:true, location: 'e' }
                }
            );
            var dataS = [
                        <?php 
                      {
                           echo "['".$saldPositivoTXT." R$".$total1TRelativo."', ".$total1TRelativo."],";
                           echo "['".$saldnegativoTXT." R$".$total0TRelativo."', ".$total0TRelativo."],";
                           echo "['".$saldoTXT." R$".$diferenca."', ".$diferenca."],";
                      }
                ?>
              ];
              var plot = jQuery.jqplot ('chart-saldo', [dataS], 
                {  seriesDefaults: {
                    renderer: jQuery.jqplot.PieRenderer, 
                    rendererOptions: {
                      showDataLabels: true   }  }, 
                  legend: { show:true, location: 'e' }
                }
            );
            var dataD = [
                        <?php     
                foreach ($c_Custos as $c)
                      {
                           if($total0[$c->cod_Comp] != 0)
                           echo "['".$c->cod_Comp." (".$c->descricaoCod.") R$".$total0[$c->cod_Comp]."', ".$total0[$c->cod_Comp]."],";
                      }
                ?>
              ];
              var plot = jQuery.jqplot ('chart-debitos', [dataD], 
                {  seriesDefaults: {
                    renderer: jQuery.jqplot.PieRenderer, 
                    rendererOptions: {
                      showDataLabels: true   }  }, 
                  legend: { show:true, location: 'e' }
                }
            );
            var dataC = [
                        <?php     
                foreach ($c_Custos as $c)
                      {
                           if($total1[$c->cod_Comp] != 0)
                           echo "['".$c->cod_Comp." (".$c->descricaoCod.") R$".$total0[$c->cod_Comp]."', ".$total1[$c->cod_Comp]."],";
                      }
                ?>
              ];
              var plot = jQuery.jqplot ('chart-creditos', [dataC], 
                {  seriesDefaults: {
                    renderer: jQuery.jqplot.PieRenderer, 
                    rendererOptions: {
                      showDataLabels: true   }  }, 
                  legend: { show:true, location: 'e' }
                }
            );
    });
 
</script>

<?php } ?>


<?php if(isset($estatisticas_financeiro) && $estatisticas_financeiro != null) { 
         if($estatisticas_financeiro->total_receita1C != null || $estatisticas_financeiro->total_despesa1C != null || $estatisticas_financeiro->total_despesa1C != null || $estatisticas_financeiro->total_despesa1S != null){
?>
<script type="text/javascript">
    
    $(document).ready(function(){

      var data2 = [['Total Receitas',<?php echo ($estatisticas_financeiro->total_receita1C != null ) ?  $estatisticas_financeiro->total_receita1C : '0.00'; ?>],['Total Despesas', <?php echo ($estatisticas_financeiro->total_despesa1C != null ) ?  $estatisticas_financeiro->total_despesa1C : '0.00'; ?>]];
      var plot2 = jQuery.jqplot ('chart-financeiro', [data2], 
        {  

          seriesColors: [ "#9ACD32", "#FF8C00", "#EAA228", "#579575", "#839557", "#958c12","#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],   
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
          legend: { show:true, location: 'e' }
        }
      );


      var data3 = [['Total Receitas',<?php echo ($estatisticas_financeiro->total_receita1S != null ) ?  $estatisticas_financeiro->total_receita1S : '0.00'; ?>],['Total Despesas', <?php echo ($estatisticas_financeiro->total_despesa1S != null ) ?  $estatisticas_financeiro->total_despesa1S : '0.00'; ?>]];
      var plot3 = jQuery.jqplot ('chart-financeiro2', [data3], 
        {  

          seriesColors: [ "#90EE90", "#FF0000", "#EAA228", "#579575", "#839557", "#958c12","#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],   
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
          legend: { show:true, location: 'e' }
        }

      );


      var data4 = [['Total em Caixa',<?php echo ($estatisticas_financeiro->total_receita - $estatisticas_financeiro->total_despesa); ?>],['Total a Entrar', <?php echo ($estatisticas_financeiro->total_receita_pendente - $estatisticas_financeiro->total_despesa_pendente); ?>]];
      var plot4 = jQuery.jqplot ('chart-financeiro-caixa', [data4], 
        {  

          seriesColors: ["#839557","#d8b83f", "#d8b83f", "#ff5800", "#0085cc"],   
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
          legend: { show:true, location: 'e' }
        }

      );


    });
 
</script>

<?php } } ?>