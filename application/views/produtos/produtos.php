 

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>

<div class="span3">
   <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aProduto')){ ?>
    <a href="<?php echo base_url();?>index.php/produtos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Abastecimento</a>
<?php } 
$contaUser = $this->session->userdata('contaUser'); ?>
</div>
<div class="buttons">
            <!--//****** FORM de Pesquisa para filtro -->
    <form method="get" action="<?php echo base_url(); ?>index.php/produtos/gerenciar">
        <div class="span1">
            <button class="span12 btn"><i class="icon-search">Filtrar</i> </button>
            
            <input type="hidden" name="pesquisa"  id="pesquisa"  value="true" >
        </div>
        <div class="span1">
            <select  style="width:120px;" id="contas" name="contas">
                   <option value = "">Todas contas</option>
             <?php
                    foreach ($contas as $rcx) {
                        if($contaUser == 99 && $rcx->id_caixa > 3 && $rcx->id_caixa < 9)
                        {?>
                        <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                <?php
                            }else
                            if($contaUser == $rcx->id_caixa){
                                ?>
                        <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                <?php
                            }
                   }
             ?>
             </select>
        </div>
        <div class="span2">
            <select id="benef" name="benef">
                <option value = "">Beneficiário</option>
             <?php
                foreach ($beneficiarios as $rbn) { ?>
                    <option value = "<?php echo $rbn->documento ?>"><?php echo $rbn->documento." | ".$rbn->nomeCliente ?></option>
                <?php
               }  ?>														
            </select>
        </div>
        <div class="span2">   
            <input type="text" name="data"  id="data"  placeholder="Data Inicial" class="span6 datepicker" value="">
            <input type="hidden" name="data2"  id="data2"  placeholder="Data Final" class="span6 datepicker" value="" >
        </div>
    </form>
</div>

<?php
if(!$results){?>
	<div class="widget-box">
        <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
            </span>
        <h5>Abastecimentos</h5>
        </div>    

        <div class="widget-content nopadding">
            <table class="table table-bordered ">
                <thead>
                        <th>#id_comb </th>
                        <th>Data</th>
                        <th>quilometragem</th>
                        <th>litros</th>
                        <th>valor</th>
                        <th>posto</th>
                        <th>veiculo</th>
                        <th></th>
                        <th></th>        
                </thead>
                <tbody>
                    <tr>
                    <?php if(isset($_SESSION['benef'])){ ?>    
                        <td colspan="5">Nenhum Abastecimentos Cadastrado</td>
                        <?php } else { ?>    
                        <td colspan="5">Nenhum Registro de abastecimento Cadastrado</td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php } else{
        $stt = 'ultimos';
        $aba1 = ""; $aba2 = ""; $aba3 = ""; $aba11 = "";
        switch ($stt)
            {
              case 'ultimos':	    $sttN = 'ultimos';	$aba1 = "active"; break;    
              case 'semanal':	$sttN = 'semanal';	$aba2 = "active";	break;  
              case 'mensal':	$sttN = 'mensal';	$aba3 = "active";	break;
                default: 	        $sttN = 'ultimos'; $aba1 = "active";
          }   
        ?>

        <div class="widget-box">
             <div class="widget-title"  style= "background:blue" >                         
                <ul class="nav nav-tabs">
                    <li class="<?php echo  $aba1; ?>" id="divPrev"><a href="#tab1" data-toggle="tab"> ULTIMOS</a></li>
                    <li  class="<?php echo  $aba2; ?>" id="divPrev"><a href="#tab2" data-toggle="tab"> <font  color = Red >SEMANAL</font></a></li>
                    <li class="<?php echo  $aba3; ?>" id="divPrev"><a href="#tab3" data-toggle="tab"> MENSAL</a></li>
                    <li  id="divDoados"> - </li>
                    <li  id="divDoados" ><DIV>  <font  color = '#ffffff' ><h4><?php echo "<< DOAÇÕES >>" ?> </h4></font> </DIV></li>

                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane <?php echo  $aba1; ?>" id="tab1">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-barcode"></i>
                        </span>
                        <h5>Abastecimentos</h5>
                    </div>

                    <div class="widget-content nopadding">
                        <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th>#id_comb </th>
                                    <th>Data</th>
                                    <th>quilometragem</th>
                                    <th>litros</th>
                                    <th>valor</th>
                                    <th>posto</th>
                                    <th>veiculo</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nProtocoloAnt =  $id_entradaAnterior = '';
                                $vEntrada = $vSaida = $vPendente = $vEntradaTotal = $vSaidaTotal = $vPendenteTotal = 0.0;
                                foreach ($results as $r) {
                                {   
                                    
                                    // if($id_entradaAnterior != '' && $id_entradaAnterior != $r->id_entrada)
                                    // {                    
                                    //     $vEntradaTotal   = $vEntrada;
                                    //     $vSaidaTotal     = $vSaida;
                                    //     $vPendenteTotal  = $vPendente;
                                    //     $vEntrada = $vSaida = $vPendente = 0.0;
                                    ?>
                                    <!-- <tr><td colspan=6><H4>TOTAL POR LOTE</H4></td>
                                    <td><H4><?php //echo number_format($vEntradaTotal,2,',','.') ?></H4></td>
                                    <td><H4><?php //echo number_format($vSaidaTotal,2,',','.') ?></H4></td>
                                    <td><H4><?php //echo number_format($vPendenteTotal,2,',','.') ?></H4></td>
                                    <td></td></tr> -->
                                    <?php  
                                    // }
                                    // if($r->n_protocolo != $nProtocoloAnt)
                                    //     {
                                    //         $cor2 = '<font>';
                                    //         $vEntrada   += $r->valor_entrada;                     
                                    //     }else {
                                    //         $cor2 = '<font color = blue >';
                                    //         $vPendente  -= $vpend;
                                    //     }
                                    // $vSaida     += $r->valor_saida;
                                    // $vPendente  += $r->valor_pendente;
                                    
                                    // $vpend = $r->valor_pendente;
                                    // $cor1 = ($vpend >= 0.2) ? '<font color = red >' : ($vpend < -2) ? '<font color = #893306 >' : '<font color = blue >';
                                    echo '<tr>';
                                    echo '<td>'.$r->id_comb.'</td>';
                                    echo '<td>'.date('d/m/Y', strtotime($r->data_abast)).'</td>';
                                    echo '<td>'.$r->quilometragem.'</td>';
                                    echo '<td>'.$r->litros.'</td>';
                                    echo '<td>R$ '.number_format($r->valor,2,',','.').'</td>';
                                    echo '<td> '.$r->posto.'</td>';
                                    echo '<td>'.$r->veiculo.'</font></td>';            
                                    echo '<td>';
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/visualizar/'.$r->id_comb.'" class="btn tip-top" title="Visualizar Presente"><i class="icon-eye-open"></i></a>  '; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/editar/'.$r->id_comb.'" class="btn btn-info tip-top" title="Editar Presente"><i class="icon-pencil icon-white"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao' && 1==2),'dProduto')){
                                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" produto="'.$r->id_comb.'" class="btn btn-danger tip-top" title="Excluir Presente"><i class="icon-remove icon-white"></i></a>'; 
                                    }                     
                                    echo '</td>';
                                    echo '</tr>';                
                                        // $nProtocoloAnt = $r->n_protocolo;
                                        // $id_entradaAnterior = $r->id_entrada;
                                    }
                                }?>
                                <tr>                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <?php echo $this->pagination->create_links();}
                    unset ($_SESSION['benef']);
                ?>
            </div>
            
            <div class="tab-pane <?php echo  $aba2; ?>" id="tab2">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-barcode"></i>
                        </span>
                        <h5>SEMANAIS</h5>
                    </div>

                    <div class="widget-content nopadding">
                        <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th>#</th>
                                    <th>Período</th>
                                    <th>Quilometragem</th>
                                    <th>Litros</th>
                                    <th>Valor</th>
                                    <th>Consumo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nProtocoloAnt =  $id_entradaAnterior = '';
                                $vEntrada = $vSaida = $vPendente = $vEntradaTotal = $vSaidaTotal = $vPendenteTotal = 0.0;
                                // var_dump($semanal);
                                foreach ($semanal as $s) {
                                {
                                    
                                    // var_dump($s['quilometragemI']);
                                    
                                    echo '<tr>';
                                    echo '<td></td>';
                                    echo '<td>'.date('d/m/Y', strtotime($s['dataI'])).' a '.date('d/m/Y', strtotime($s['dataF'])).'</td>';
                                    echo '<td>'.$s['quilometragemI'].' a '.$s['quilometragemF'].'</td>';
                                    echo '<td>'.$s['litros'].'</td>';
                                    echo '<td>R$ '.number_format($s['valor'],2,',','.').'</td>';
                                    echo '<td> '.$s['consumo'].'km/l</td>';  
                                    echo '</tr>';
                                    }
                                }?>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane <?php echo  $aba3; ?>" id="tab3">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-barcode"></i>
                        </span>
                        <h5>MENSAIS</h5>
                    </div>

                    <div class="widget-content nopadding">
                        <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th>#id_comb </th>
                                    <th>Data</th>
                                    <th>quilometragem</th>
                                    <th>litros</th>
                                    <th>valor</th>
                                    <th>posto</th>
                                    <th>veiculo</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nProtocoloAnt =  $id_entradaAnterior = '';
                                $vEntrada = $vSaida = $vPendente = $vEntradaTotal = $vSaidaTotal = $vPendenteTotal = 0.0;
                                foreach ($results as $r) {
                                {   
                                    
                                    echo '<tr>';
                                    echo '<td>'.$r->id_comb.'</td>';
                                    echo '<td>'.date('d/m/Y', strtotime($r->data_abast)).'</td>';
                                    echo '<td>'.$r->quilometragem.'</td>';
                                    echo '<td>'.$r->litros.'</td>';
                                    echo '<td>R$ '.number_format($r->valor,2,',','.').'</td>';
                                    echo '<td> '.$r->posto.'</td>';
                                    echo '<td>'.$r->veiculo.'</font></td>';            
                                    echo '<td>';
                                    echo '</td>';
                                    echo '</tr>';
                                    }
                                }?>
                                <tr>                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal -->
    <div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/produtos/excluir" method="post" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Excluir Produto</h5>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idProduto" name="id" value="" />
        <h5 style="text-align: center">Deseja realmente excluir este produto?</h5>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-danger">Excluir</button>
    </div>
    </form>
    </div>



<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var produto = $(this).attr('produto');
        $('#idProduto').val(produto);

    });

    $(".datepicker6").datepicker({
            beforeShowDay: noWeekendsOrHolidays,  dateFormat: 'dd/mm/yy',
            maxDate: 180, 
            minDate: 1,disabledDates: ['2021-04-02','2021-04-23','2021-09-10','2021-09-14' ],
            dayNames: ["Domingo", "Segunda", "Terca", "Quarta", "Quinta", "Sexta", "S&aacute;bado"],
            dayNamesMin: ["Dom", "S", "T", "Q","Q", "S", "Sab"],
            dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            monthNames: ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthNamesShort: ["Jan","Fev", "Mar","Abr", "Mai","Jun", "Jul","Ago", "Set","Out", "Nov","Dez"] })
});
</script>