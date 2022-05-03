 

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>

<div class="span3">
   <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aProduto') && 1==2){ ?>
    <a href="<?php echo base_url();?>index.php/produtos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Presentes Especiais</a>
<?php } 
$contaUser = $this->session->userdata('contaUser'); ?>
</div>
<div class="buttons">
            <!--//****** FORM de Pesquisa para filtro -->
    <form method="get" action="<?php echo base_url(); ?>index.php/produtos/gerenciar">
        <div class="span1">
            <button class="span12 btn"><i class="icon-search">  Filtrar</i> </button>
            
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
        <h5>Presentes Especiais</h5>

     </div>
     

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
            <th>#</th>
            <th>Data</th>
            <th>BR</th>
            <th>Beneficiario</th>
            <th>Protocolo</th>
            <th>Entrada</th>
            <th>Saida</th>
            <th>Pendente</th>
            <th></th>
        
    </thead>
    <tbody>

        <tr>
           <?php if(isset($_SESSION['benef'])){ ?>    
            <td colspan="5">Nenhum Presentes Especiais Cadastrado para <strong><?php echo $_SESSION['benef'] ?> desde 2018.</strong></td>
    <?php } else { ?>    
            <td colspan="5">Nenhum Presentes Especiais Cadastrado</td>
    <?php } ?>
        </tr>
    </tbody>
</table>
</div>
</div>

<?php } else{?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Presentes Especiais</h5>
         

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th rowspan=2>#</th>
            <th rowspan=2>Data</th>
            <th colspan=2>Lançamentos</th>
            <th rowspan=2>Beneficiario</th>
            <th rowspan=2>Protocolo</th>
            <th colspan=3>Valores</th>
            <th rowspan=2></th>
        </tr>
        <tr style="backgroud-color: #2D335B">
            <th>Entrada</th>
            <th>Saída</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Pendente</th>
        </tr>
    </thead>
    <tbody>
        <?php
             $nProtocoloAnt =  $id_entradaAnterior = '';
             $vEntrada = $vSaida = $vPendente = $vEntradaTotal = $vSaidaTotal = $vPendenteTotal = 0.0;
             foreach ($results as $r) {
            {   
                
                if($id_entradaAnterior != '' && $id_entradaAnterior != $r->id_entrada)
                {                    
                    $vEntradaTotal   = $vEntrada;
                    $vSaidaTotal     = $vSaida;
                    $vPendenteTotal  = $vPendente;
                    $vEntrada = $vSaida = $vPendente = 0.0;
                ?>
                 <tr><td colspan=6><H4>TOTAL POR LOTE</H4></td>
                 <td><H4><?php echo number_format($vEntradaTotal,2,',','.') ?></H4></td>
                 <td><H4><?php echo number_format($vSaidaTotal,2,',','.') ?></H4></td>
                 <td><H4><?php echo number_format($vPendenteTotal,2,',','.') ?></H4></td>
                 <td></td></tr>
                  <?php  
                }
                if($r->n_protocolo != $nProtocoloAnt)
                    {
                        $cor2 = '<font>';
                        $vEntrada   += $r->valor_entrada;                     
                    }else {
                        $cor2 = '<font color = blue >';
                        $vPendente  -= $vpend;
                    }
                $vSaida     += $r->valor_saida;
                $vPendente  += $r->valor_pendente;
                
                $vpend = $r->valor_pendente;
                $cor1 = ($vpend >= 0.2) ? '<font color = red >' : ($vpend < -2) ? '<font color = #893306 >' : '<font color = blue >';
            echo '<tr>';
            echo '<td>'.$r->id_presente.'</td>';
            echo '<td>'.date('d/m/Y', strtotime($r->data_presente)).'</td>';
            echo '<td>'.$r->id_entrada.'</td>';
            echo '<td>'.$r->id_saida.'</td>';
            echo '<td>'.$r->n_beneficiario.' - '.$r->nome_beneficiario.'</td>';
            echo '<td>'.$cor2.$r->n_protocolo.'</font></td>';
            echo '<td>R$ '.number_format($r->valor_entrada,2,',','.').'</td>';
            echo '<td>R$ '.number_format($r->valor_saida,2,',','.').'</td>';
            echo '<td>R$ '.$cor1.number_format($r->valor_pendente,2,',','.').'</font></td>';            
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/visualizar/'.$r->id_presente.'" class="btn tip-top" title="Visualizar Presente"><i class="icon-eye-open"></i></a>  '; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto') && 0 == $r->id_saida){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/editar/'.$r->id_presente.'" class="btn btn-info tip-top" title="Editar Presente"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao' && 1==2),'dProduto')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" produto="'.$r->id_presente.'" class="btn btn-danger tip-top" title="Excluir Presente"><i class="icon-remove icon-white"></i></a>'; 
            }                     
            echo '</td>';
            echo '</tr>';                
                $nProtocoloAnt = $r->n_protocolo;
                $id_entradaAnterior = $r->id_entrada;
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