<style>
.badgebox
{
    opacity: 0;
}
.badgebox + .badge
{    text-indent: -999999px;
	width: 27px;
}
.badgebox:focus + .badge
{
    box-shadow: inset 0px 0px 5px;
}
.badgebox:checked + .badge
{
	text-indent: 0;
}
</style>
<style  type="text/css"> /* INPUT {text-transform: uppercase;}   </style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-folder-open"></i>
                </span>
                <h5>Editar Lançamento</h5>
                <h4>#Lançamento: <?php echo $result->id_fin ?></h4>
            </div>
            <div class="widget-content nopadding">
                
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes do Lançamento</a></li>
                        <li id="tabAnexos"><a href="#tab2" data-toggle="tab">Documento anexo</a></li>

                    </ul>
                    <div class="tab-content">
                    <?php
                            $lancamento = array();
                            if( isset($_SESSION['lancamento']))
                            {
                    //var_dump($_SESSION['lancamento']);
                                $lancamento     = $_SESSION['lancamento'];
                                $conta          = $lancamento['conta'];        
                                $tipCont        = $lancamento['tipo_Conta'];
                                $fundoF         = $lancamento['fundoF'];
                                $cCustos        = $lancamento['cCustos'] ;
                                $num_Doc        = $lancamento['num_Doc_Banco'];
                                $numDocFiscal   = $lancamento['num_Doc_Fiscal'];
                                $razaoSoc       = $lancamento['historico'];
                                $dataFin        = $lancamento['dataFin'];
                                $descri         = $lancamento['descricao'];	
                                $valorFin       = $lancamento['valorFin'];
                                $conta_Destino  = $lancamento['conta_Destino'];
                                $tipo_Pag       = $lancamento['tipo_Pag'];
                                $tipoES         = $lancamento['ent_Sai'] ; 
                                $cadastrante    = $lancamento['cadastrante'];
                                $adm            = $lancamento['adm'];
                            }else $adm   = '';
                            unset($_SESSION['lancamento']);
                        {
                                
                    ?>
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divEditarVenda">
                                
                    <form action="<?php echo current_url(); ?>" method="post" id="formVendas">
                                    
                        <?php if ($custom_error != '') {
                            echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                        } ?>
                                    <?php // echo form_hidden('id_fin',$result->id_fin) ?>
                                    <input id="id_fin" name="id_fin"  type="hidden" value="<?php echo $result->id_fin ?>">
                                    <input id="saldo" name="saldo"  type="hidden" value="<?php echo $result->saldo ?>"/>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                       
                                        <div class="span12">
                                            <label for="tecnico">Lançado por <?php echo $result->nome." em ".date('d/m/Y', strtotime($result->dataFin)) ?><span class="required">*</span></label>
                                            
                                        </div>
                                        
                                    </div>
                                                                          
                            <div class="span4">         
                                        <?php $conta = $result->id_caixa ?>
                                    <p class="conta">
                                        <label for="conta">Conta de lançamento</label>
                                        <select id="conta" name="conta">                                              
                                        <option value = "<?php echo $conta ?>"><?php echo $conta.' | '.$result->nome_caixa ; ?></option>
                                         <?php
                                            foreach ($result_caixas as $rcx) 
                                            {                   
                                          if($usuario->conta_Usuario == 99)
                                              {?>                                               
                                            <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                                    <?php
                                            }    
                                           }
                                          ?>														
                                        </select>
                                     <font color=red><span class="style1"> * </span></font>	
                                    </p>   
                                                              
                                        <?php 
                                       
                                        if($result->ent_Sai == 0) {
                                             $ent_Sai = "Saída";}
                                        else if($result->ent_Sai == 1) {
                                            $ent_Sai = "Entrada";}
                                         else  $ent_Sai = "Indefinido";
                                        
                                        ?>
                                    <p class="ent_Sai">
                                        <label for="ent_Sai">Tipo de movimentação</label>
                                        <select id="ent_Sai" name="ent_Sai">                                              
                                        <option value = "<?php echo $result->ent_Sai ?>"><?php echo $ent_Sai; ?></option>                                         													
                                        </select>
                                     <font color=red><span class="style1"> * </span></font>	
                                    </p>
                                     
                                    <p class="conta">
                                        <label for="tipo_Conta">Tipo da conta</label>
                                        <select id="tipo_Conta" name="tipo_Conta">                                              
                                        <option value = "<?php echo $result->tipo_Conta ?>"><?php echo $result->tipo_Conta ; ?></option>
                                         <?php                                                            
                                          if($usuario->conta_Usuario == 99)
                                              {?>                                               
                                            <option value = "Suporte">Suporte</option>    
                                          <?php
                                            } else {?>
                                            <option value = "Suporte">Suporte</option> 
                                              <?php 
                                            } ?>														
                                        </select>
                                     <font color=red><span class="style1"> * </span></font>	
                                    </p> 
                                    <?php 
    
                                    {
                                        $conta = $result->conta;
                                        $tipCont = $result->tipo_Conta;
                                        {
                                        ?>
                                <div class="control-group">
                                    <label for="cCustos" class="control-label">Centro de Custo<span class="required">*</span></label>
                                    <div class="controls">
                                        <?php 
                                          
                                            $descri_Comp = "Indefinido";                                                 
                                            $area_Comp = "Indefinido";
                                            ?>
                                          <select id="cCustos" name="cCustos" >
                                            <?php 
                                             foreach ($result_codComp as $rcodComp)
                                             {
                                              ?>
                                                <option value = "<?php echo $rcodComp->cod_Comp ?>"
                                                     <?php if($result->cod_compassion == $rcodComp->cod_Comp){ echo 'selected';} ?>>
                                                <?php echo ' '.$rcodComp->cod_Comp." |
                                                ".$rcodComp->descricaoCod." | ".$rcodComp->area_Cod.' '?></option>
                                            <?php } ?>
                                              </select>
                                    <?php }    ?>
                                    </div>
                                </div>
                                    
                                <div class="control-group">
                                    <label for="fundoF" class="control-label">Fundo Financeiro<span class="required">*</span></label>
                                    <div class="controls">                                  
                                     <select id="fundoF" name="fundoF">                                       
                                        <?php
                                        foreach ($result_codIead as $rcodIead)
                                        { 
                                            $codigoFundo = $rcodIead->cod_Ass;
                                            $dataVenc   = $rcodIead->cont_Contabil;
                                            $dataMelhor = $rcodIead->ent_SaiAss;
                                            
                                         ?>
                                            <option value ="<?=$codigoFundo?>"
                                            <?php if($result->cod_assoc == $rcodIead->cod_Ass){ echo 'selected'; $cred_deb = $rcodIead->area;} ?>>
                                            <?php echo $rcodIead->cod_Ass." | ".$rcodIead->descricao_Ass ?></option>
                                        <?php }
                                        ?>														
                                    </select>
                                    </div>
                                </div>
                          <?php  }?>
                                <p class="docFiscal">
                                    <?php  $numDocFiscal = $result->num_Doc_Fiscal;
                                           $chekFisc0 = $numDocFiscal == "Previsto" ? "checked" : "";
                                           $chekFisc1 = $numDocFiscal == "Efetuado" ? "checked" : ""; 
                                        $exibeP = $exibeE = "true";
                                    ?>
                                    <label for="tiposaida">Situação <?=$adm?></label>
                                    <?php if($result->num_Doc_Banco != "0/0" && $cred_deb == 'CRÉDITO' && $result->cod_assoc != 'C-EMP' && $adm != 'admin')
                                          { $exibeP = $numDocFiscal == "Previsto" ? "true" : "false";
                                           $exibeE = $numDocFiscal == "Efetuado" ? "true" : "false";}
                                    if($exibeP == "true"){
                                  ?>
                                    <label class="btn btn-default" submit>
                                        <input name="numDocFiscal" type="radio" value="Previsto" <?php echo $chekFisc0 ?> class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Previsto</label> 
                                    <?php } 
                                    if($exibeE == "true"){?>
                                    <label class="btn btn-default" submit>
                                        <input name="numDocFiscal" type="radio"  value="Efetuado" <?php echo $chekFisc1 ?> class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Efetuado</label>  
                                    <?php } ?>
                                </p>
                                
                                <div class="control-group">
                                    <label for="dataInicial" class="control-label">Data do evento financeiro<span class="required">*</span></label>
                                    <div class="controls">
                                                <input id="dataEvento" class="span3 datepicker" type="Text" name="dataEvento" value="<?php echo date('d/m/Y', strtotime($result->dataEvento)); ?>" <?php if($result->num_Doc_Banco == '0/0') echo 'readonly';  ?> /> / 
                                        <input id="dataVenda" class="span3 datepicker" type="Text" name="dataVenda" value="<?php echo date('d/m/Y', strtotime($result->dataFin)); ?>" <?php if($result->num_Doc_Banco == '0/0') echo 'readonly';  ?> />
                                </div> 
                                </div>                               
                        
                        </div>
                                   
                         <div class="span4" > 
                                <p>
                                <?php
                                    if($result->num_Doc_Banco == '0/0')
                                    {
                                           $chekFat0 = $result->par_ES == $result->id_fin  ? "" : "checked";
                                           $chekFat1 = $result->par_ES == $result->id_fin ? "checked" : ""; 
                                          ?>
                                            <label class="btn btn-default" submit>
                                                <input name="fatura" type="radio" value="0" <?php echo $chekFat0 ?> class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Fatura Aberta</label> 
                                            <label class="btn btn-default" submit>
                                                <input name="fatura" type="radio"  value="1" <?php echo $chekFat1 ?> class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Fatura Fechada</label>  
                                <?php }else{ ?> 
                                    <label for="valorFin" class="control-label">Vinculado ao Lançamento <?=$result->par_ES ?></label>                                    
                                <?php } $ver_Par_ES =  $adm == 'admin' ? 'text' : 'hidden'; ?>
                                    <input name="faturapar_ES" type="<?=$ver_Par_ES?>" value="<?php echo $result->par_ES ?>"  />
                                    
                                </p>
                                <div class="control-group">
                                    <label for="valorFin" class="control-label">Valor do lançamento<span class="required">*</span></label>
                                    <div class="controls">
                                            <span class="style1">* R$ </span><input text-align="right" name="valorFin"  class="money"   value="<?php echo number_format($result->valorFin, 2, ',', '.') ?>" ><font color=red> **</font>
                                    </div>                                 
                                </div>
                                    
                                <div class="control-group">
                                            <label for="razaoSoc" class="control-label">Histórico<span class="required">*</span></label>
                                                <input class="span11"  name ="razaoSoc" type="text"  value="<?php echo $result->historico ?>"  maxlength=60><font color=red> *</font>

                                </div>                                        
                                    
                                <div class="control-group">
                                        <label for="descricao" class="control-label">Descrição<span class="required">*</span></label>
                                    <div class="controls">
                                    <textarea name ="descricao" type="text"  maxlength=100><?php echo $result->finDescricao ?></textarea><font color=red> *</font>
                                </div>
                                </div>
                                               
                                     <input  name ="cadastrante" type="hidden"  value="<?php echo $usuario->idUsuarios ?>" >
                                    <p class="tipo_Pag">
                                        <label for="tiposaida">Tipo de Lançamento</label>
                                        
                                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio" checked  value="<?=$result->tipo_Pag ?>" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> <?=$result->tipo_Pag ?></label>

                                    </p>

                                <div id = "palco">
                                 <div id = "Periodico">
                                    <label for="conta_Destino">Parcelas</label>
                                    <td>
                                        <input  name="numeroDoc"  id="numeroDoc" type="text" readonly value="<?php echo $result->num_Doc_Banco ?>"  >
                                        <font color=red> *</font>
                                    <input id="conta_Destino" name="conta_Destino" type="hidden" value = "<?php echo $conta_Desti = !empty($lancamento) ? $conta_Destino : $result->conta_Destino ?>" />
                                    </td>
                                 </div>
                                </div>
                              
                            <p class="senhaAdm">
                                <label for="senhaAdm"><font color=red>senha Administrador</font></label>
                                <input  name ="senhaAdm" type="password"  value=""  maxlength=50><font color=red> *</font>

                            </p>
                                               
                        </div>
                                <input name ="fundoFAnterior" type="hidden"  value="<?php echo $result->cod_assoc ?>">
                                <input name ="numDocFiscalAnterior" type="hidden"  value="<?php echo $result->num_Doc_Fiscal ?>"> 
                                <input name ="dataVendaAnterior" type="hidden"  value="<?php echo $result->dataFin ?>"> 
                                <input name ="valorFinAnterior" type="hidden"  value="<?php echo $result->valorFin ?>">                                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
           
                                        <div class="span8 offset2" style="text-align: center">
                                        <!--       
                                            <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> Faturar</a>
                                            --> 
                                            <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>
                                            
                                            <a href="<?php echo base_url() ?>index.php/vendas/visualizar/<?php echo $result->id_fin; ?>" class="btn btn-inverse"><i class="icon-eye-open"></i> Visualizar Lançamento</a>
                                            
                                            <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>

                                    </div>

                                </form>
                                
                                    
                            </div>

                        </div>
                        <?php }
                    ?>
       <!--Anexos-->
                     <div class="tab-pane" id="tab2">
                        <div class="span12" style="padding: 1%; margin-left: 0">
                     <div class="span12 well" style="padding: 1%; margin-left: 0" id="form-anexos">
                         <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" accept-charset="utf-8"s method="post">
                             
                         <div class="span10">
                           
                            <input type="hidden" id="fin_id" name="fin_id" value="<?php echo $result->id_fin ?>" />
                            <label for="">Anexo</label>
                            <input type="file" class="span12" name="userfile[]" multiple="multiple" size="20" />
                         </div>
                         <div class="span2">
                            <label for="">.</label>
                             
                            <button class="btn btn-success span12"><i class="icon-white icon-plus"></i> Anexar</button>
                            
                                                          
                        </div>
                          
                             
                        </form>
                        </div>
                        
                        <div class="span12" id="divAnexos" style="margin-left: 0">
                            <?php 
                            $cont = 1;
                            $flag = 5;
                            foreach ($anexos as $a) {

                                if($a->thumb == null){
                                    $thumb = base_url().'assets/img/icon-file.png';
                                    $link = base_url().'assets/img/icon-file.png';
                                }
                                else{
                                    $thumb = base_url().'assets/anexos/thumbs/'.$a->thumb;
                                    $link = $a->url.$a->anexo;
                                }

                                if($cont == $flag){
                                   echo '<div style="margin-left: 0" class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                   $flag += 4;
                                }
                                else{
                                   echo '<div class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                }
                                $cont ++;
                            } ?>
                        </div>
                    </div>
                    </div> 

                    </div>

                </div>


.

        </div>

    </div>
</div>
   <?php 
    ?>
</div>


<!-- Modal Faturar-->
<div id="modal-faturar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="formFaturar" action="<?php echo current_url() ?>" method="post">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Faturar Venda</h3>
</div>
<div class="modal-body">
    
    <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
    <div class="span12" style="margin-left: 0"> 
      <label for="descricao">Descrição</label>
      <input class="span12" id="descricao" type="text" name="descricao" value="<?php echo $result->descricao; ?> "  />
      
    </div>  
    <div class="span12" style="margin-left: 0"> 
      <div class="span12" style="margin-left: 0"> 
        <label for="cliente">Cliente*</label>
        <input class="span12" id="cliente" type="text" name="cliente" value="<?php echo $result->id_fin ?>" />
        <input type="hidden" name="clientes_id" id="clientes_id" value="<?php echo $result->id_fin ?>">
        <input type="hidden" name="vendas_id" id="vendas_id" value="<?php echo $result->id_fin; ?>">
      </div>
      
      
    </div>
    <div class="span12" style="margin-left: 0"> 
      <div class="span4" style="margin-left: 0">  
        <label for="valor">Valor*</label>
        <input type="hidden" id="tipo" name="tipo" value="receita" /> 
        <input class="span12 money" id="valor" type="text" name="valor" value="<?php echo number_format($total,2); ?> "  />
      </div>
      <div class="span4" >
        <label for="vencimento">Data Vencimento*</label>
        <input class="span12 datepicker" id="vencimento" type="text" name="vencimento"  />
      </div>
      
    </div>
    
    <div class="span12" style="margin-left: 0"> 
      <div class="span4" style="margin-left: 0">
        <label for="recebido">Recebido?</label>
        &nbsp &nbsp &nbsp &nbsp<input  id="recebido" type="checkbox" name="recebido" value="1" /> 
      </div>
      <div id="divRecebimento" class="span8" style=" display: none">
        <div class="span6">
          <label for="recebimento">Data Recebimento</label>
          <input class="span12 datepicker" id="recebimento" type="text" name="recebimento" /> 
        </div>
        <div class="span6">
          <label for="formaPgto">Forma Pgto</label>
          <select name="formaPgto" id="formaPgto" class="span12">
            <option value="Dinheiro">Dinheiro</option>
            <option value="Cartão de Crédito">Cartão de Crédito</option>
            <option value="Cheque">Cheque</option>
            <option value="Boleto">Boleto</option>
            <option value="Depósito">Depósito</option>
            <option value="Débito">Débito</option>        
          </select>
        </div>
      </div>
      
    </div>
    
    
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true" id="btn-cancelar-faturar">Cancelar</button>
  <button class="btn btn-primary">Faturar</button>
</div>
</div>
</form>
</div>
 
<!-- Modal visualizar anexo -->
<div id="modal-anexo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Visualizar Anexo</h3>
  </div>
  <div class="modal-body">
    <div class="span12" id="div-visualizar-anexo" style="text-align: center">
        <div class='progress progress-info progress-striped active'>
            <div class='bar' style='width: 100%'>
            </div></div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
    <a href="" id-imagem="" class="btn btn-inverse" id="download">Download</a>
    <?php if($usuario->conta_Usuario == 99){ ?> 
     <a href="" link="" class="btn btn-danger" id="excluir-anexo">Excluir Anexo</a>
    <?php } ?>
  </div>
</div> 



<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){

     $(".money").maskMoney(); 

     $('#recebido').click(function(event) {
        var flag = $(this).is(':checked');
        if(flag == true){
          $('#divRecebimento').show();
        }
        else{
          $('#divRecebimento').hide();
        }
     });

     $(document).on('click', '#btn-faturar', function(event) {
       event.preventDefault();
         valor = $('#total-venda').val();
         valor = valor.replace(',', '' );
         $('#valor').val(valor);
     });
     
     $("#formFaturar").validate({
          rules:{
             descricao: {required:true},
             numeroDoc: {required:true},
             valorFin: {required:true},
             razaoSoc: {required:true}
      
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             numeroDoc: {required: 'Campo Requerido.'},
             valorFin: {required: 'Campo Requerido.'},
             razaoSoc: {required: 'Campo Requerido.'}
          },
          submitHandler: function( form ){       
            var dados = $( form ).serialize();
            $('#btn-cancelar-faturar').trigger('click');
            $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>index.php/vendas/faturar",
              data: dados,
              dataType: 'json',
              success: function(data)
              {
                if(data.result == true){
                    
                    window.location.reload(true);
                }
                else{
                    alert('Ocorreu um erro ao tentar faturar venda.');
                    $('#progress-fatura').hide();
                }
              }
              });

              return false;
          }
     });

     $("#produto").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteProdutoSaida",
            minLength: 2,
            select: function( event, ui ) {

                 $("#idProduto").val(ui.item.id);
                 $("#estoque").val(ui.item.estoque);
                 $("#preco").val(ui.item.preco);
                 $("#quantidade").focus();
                 

            }
      });

      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 2,
            select: function( event, ui ) {

                 $("#clientes_id").val(ui.item.id);


            }
      });

      $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
            minLength: 2,
            select: function( event, ui ) {

                 $("#usuarios_id").val(ui.item.id);


            }
      });

      $("#formVendas").validate({
          rules:{
             descricao: {required:true},
             razaoSoc: {required:true},
             dataVenda: {required:true},
             valorFin: {required:true},
             cCustos: {required:true},
             fundoF: {required:true}
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             razaoSoc: {required: 'Campo Requerido.'},
             dataVenda: {required: 'Campo Requerido.'},
             valorFin: {required: 'Campo Requerido.'},
             cCustos: {required: 'Campo Requerido.'},
             fundoF: {required: 'Campo Requerido.'}
          },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
       });

      $("#formProdutos").validate({
          rules:{
             quantidade: {required:true}
          },
          messages:{
             quantidade: {required: 'Insira a quantidade'}
          },
          submitHandler: function( form ){
             var quantidade = parseInt($("#quantidade").val());
             var estoque = parseInt($("#estoque").val());
             if(estoque < quantidade){
                alert('Você não possui estoque suficiente.');
             }
             else{
                 var dados = $( form ).serialize();
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/adicionarProduto",
                  data: dados,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        $("#quantidade").val('');
                        $("#produto").val('').focus();
                    }
                    else{
                        alert('Ocorreu um erro ao tentar adicionar produto.');
                    }
                  }
                  });

                  return false;
                }

             }
             
       });

        $("#formAnexos").validate({
         
          submitHandler: function( form ){       
                //var dados = $( form ).serialize();
                var dados = new FormData(form); 
                $("#form-anexos").hide('1000');
                $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/anexar",
                  data: dados,
                  mimeType:"multipart/form-data",
                  contentType: false,
                  cache: false,
                  processData:false,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divAnexos" ).load("<?php echo current_url();?> #divAnexos" );
                        $("#userfile").val('');

                    }
                    else{
                        $("#divAnexos").html('<div class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> '+data.mensagem+'</div>');      
                    }
                  },
                  error : function() {
                      $("#divAnexos").html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> Ocorreu um erro. Verifique se você anexou o(s) arquivo(s).</div>');      
                  }
                  });
                  $("#form-anexos").show('1000');
                  return false;
                }
        });      

       $(document).on('click', 'a', function(event) {
            var idProduto = $(this).attr('idAcao');
            var quantidade = $(this).attr('quantAcao');
            var produto = $(this).attr('prodAcao');
            if((idProduto % 1) == 0){
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>index.php/vendas/excluirProduto",
                  data: "idProduto="+idProduto+"&quantidade="+quantidade+"&produto="+produto,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $( "#divProdutos" ).load("<?php echo current_url();?> #divProdutos" );
                        
                    }
                    else{
                        alert('Ocorreu um erro ao tentar excluir produto.');
                    }
                  }
                  });
                  return false;
            }
            
       });
        
       $(document).on('click', '.anexo', function(event) {
           event.preventDefault();
           var link = $(this).attr('link');
           var id = $(this).attr('imagem');
           var url = '<?php echo base_url(); ?>vendas/excluirAnexo/';
           $("#div-visualizar-anexo").html('<img src="'+link+'" alt="">');
           $("#excluir-anexo").attr('href', "<?php echo base_url(); ?>index.php/vendas/excluirAnexo/"+id);

           $("#download").attr('href', "<?php echo base_url(); ?>index.php/vendas/downloadanexo/"+id);

       });
/*
       $(document).on('click', '#excluir-anexo', function(event) {
           event.preventDefault();

           var link = $(this).attr('link'); 
           $('#modal-anexo').modal('hide');
           $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");

           $.ajax({
                  type: "POST",
                  url: link,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divAnexos" ).load("<?php echo current_url();?> #divAnexos" );
                    }
                    else{
                        alert(data.mensagem);
                    }
                  }
            });
       });
*/

       $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});

</script>

