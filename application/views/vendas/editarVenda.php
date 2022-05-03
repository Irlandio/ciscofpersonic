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
                      //  if($usuario->conta_Usuario == 99) 
                        {
                                
                    ?>
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divEditarVenda">
                                
                                <form action="<?php echo current_url(); ?>" method="post" id="formVendas">
                                    <?php echo form_hidden('id_fin',$result->id_fin) ?>
                                    <input id="id_fin" name="id_fin"  type="hidden" value="<?php echo $result->id_fin ?>"/>
                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                       <!--
                                        <div class="span5" >
                                            <label for="cliente">Cliente<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value="<?php echo $result->historico ?>"  />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="<?php echo $result->clientes_id ?>"  />

                                            <input id="valorTotal" type="hidden" name="valorTotal" value=""  />

                                        </div> -->
                                        <div class="span6">
                                            <label for="tecnico">Lançado por <?php echo $result->nome." em ".date('d/m/Y', strtotime($result->dataFin)) ?><span class="required">*</span></label>
                                            
                                        </div>
                                        
                                    </div>
                                                                          
                                    <div class="span6">         
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
                                    </div>
                                    
                                    <div class="span6"> 
                                                              
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
                                         <?php               
                                          if($usuario->conta_Usuario == 99)
                                              {?>                                               
                                            <option value = '0'> Saida</option>                
                                            <option value = '1'> Entrada</option>
                                                    <?php
                                            }    
                                            ?>														
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
                                            <option value = "Corrente">Corrente</option>          
                                            <option value = "Investimento">Investimento</option>          
                                            <option value = "Poupança">Poupança</option>
                                          <?php
                                            } else {?>
                                            <option value = "Suporte">Suporte</option>          
                                            <option value = "Corrente">Corrente</option>  
                                              <?php 
                                            } ?>														
                                        </select>
                                     <font color=red><span class="style1"> * </span></font>	
                                    </p> 
                            
                                    <?php 
    
                                    {
    
                                        $conta = $result->conta;
                                        $tipCont = $result->tipo_Conta;
    
    
                                         if( $conta <  4 || $conta >  8 )
                                        { ?>
                                           <input name ="cod_Comp"  type=hidden value="III-III" />
                                             <?php 
                                          
                                        }else{
                                        ?>
                                    <p class="cod_Comp">
                                        <label for="compassion">Código Compassion *</label>
                                        <?php 
                                          
                                                    $descri_Comp = "Indefinido";                                                 
                                                    $area_Comp = "Indefinido";
                                             if(NULL !== $result->cod_compassion){
                                             foreach ($result_codComp as $rcodComp)
                                             {if ($result->cod_compassion == $rcodComp->cod_Comp) 
                                                    $descri_Comp = $rcodComp->descricao;                                                 
                                                    $area_Comp = $rcodComp->area_Cod;                                        
                                             }}?>
                                          <select id="cod_Comp" name="cod_Comp" >
                                            <option value = 
                                            "<?php echo $result->cod_compassion ?>"><?php echo $result->cod_compassion." | ".$descri_Comp." | ".$area_Comp ?></option>

                                            <?php 
                                          //  while($cod_Comp = mysqli_fetch_array($query)) 
                                             foreach ($result_codComp as $rcodComp)
                                             {
                                              if( $rcodComp->codigoNovo == 1 ){?>
                                            <!--  -->
                                                <option value = "<?php echo $rcodComp->cod_Comp ?>">
                                                <?php echo ' '.$rcodComp->cod_Comp." |
                                                ".$rcodComp->descricao." | ".$rcodComp->area_Cod.' '?></option>
                                            <?php }} ?>
                                              </select>
                                    <?php }    ?>
                                </p>
                                <p class="cod_ass">						
                                    <label for="cod_ass">Código Associação *</label>
                                    <?php 

                                        $descri_Asso = "Indefinido"; 
                                         if(NULL !== $result->cod_assoc){
                                         foreach ($result_codIead as $rcodIead)
                                         {if ($result->cod_assoc == $rcodIead->cod_Ass) 
                                                $descri_Asso = $rcodIead->descricao_Ass;
                                         }}?>
                                     <select id="cod_Ass" name="cod_Ass">
                                        <option value = "<?php echo $result->cod_assoc ?>"><?php echo $result->cod_assoc." | ".$descri_Asso ?> </option>
                                        <?php //while($cod_Ass = mysqli_fetch_array($queryA)) 
                                        foreach ($result_codIead as $rcodIead)
                                        {?>
                                        <option value = "<?php echo $rcodIead->cod_Ass ?>">
                                        <?php echo $rcodIead->cod_Ass." | ".$rcodIead->descricao_Ass ?></option>
                                        <?php } //$con->disconnect();
                                        ?>														
                                          </select>
                                </p>
                          <?php  }?>
                                <p class="numeroDocBancario">
                                    <?php                                  					
                                            if($conta <> 3)
                                            {?>
                                        <label for="numeroDocBanco">Número do Documento Bancário</label>
                                        <input id="numeroDoc" name="numeroDoc" value="<?php echo $result->num_Doc_Banco ?>" />
                                    <?php }	
                                        ?>
                                    <span class="style1">*</span>
                                </p> 
                                <p class="docFiscal">
                                        <label for="numeroDocFiscal">Número do Documento Fiscal</label>
                                      <td>
                                        <input id="numDocFiscal" name="numDocFiscal" value="<?php echo $result->num_Doc_Fiscal ?>" />
                                    <font color=red> *</font></td>
                                </p>
                                <div class="span6">
                                                <label for="dataInicial">Data do evento financeiro<span class="required">*</span></label>
                                                <input id="dataVenda" class="span12 datepicker" type="Text" name="dataVenda" value="<?php echo date('d/m/Y', strtotime($result->dataFin)); ?>"  />
                                </div> 
                                <div class="span6">
                                    <?php
//********* Insere "70_porcento" ou "30_porcento" para identificar de onde é o valor
                                        if($conta == 3)
                                        {	?>	
                                            <label><input  checked="checked"  name="numeroDoc" type="radio" value= "70_porcento" />
                            Pertence aos 70% </label>                                           
                                            <label><input name="numeroDoc" type="radio" value= "30_porcento" />Pertence aos 30%</label><br><br>	
                                      
                                    <?php  }?>	

                              
                                </div> 
                        
                    </div>
                                
                           
                                                
                                   
                                <div class="span5" >
                                       
                                        
                                    
                                            <p class="VALOR">
                                            <label for="valor">Valor do lançamento</label>
                                            <span class="style1">* R$ </span><input text-align="right" name="valorFin"  class="money"   value="<?php echo number_format($result->valorFin, 2, ',', '.') ?>" ><font color=red> **</font>
                                            </p>
                                         
                                            <p class="Historico">
                                                <label for="razao"><font color=red>Histórico</font></label>
                                                <input class="span11"  name ="razaoSoc" type="text"  value="<?php echo $result->historico ?>"  maxlength=60><font color=red> *</font>

                                            </p>
                                         
                                            <p class="descri">
                                                <label for="descri">Descrição</label>
                                                <textarea name ="descri" type="text"  maxlength=100><?php echo $result->finDescricao ?></textarea><font color=red> *</font>
                                            </p> 
                                               
                                        <?php 
                                        $tipo_Pagamento = "Indefinido";
                                        if($result->tipo_Pag == "cheq") {
                                             $tipo_Pagamento = "Cheque";}
                                        else if($result->tipo_Pag == "trans") {
                                            $tipo_Pagamento = "Transferência";}
                                        
                                        ?>
                                     <input  name ="cadastrante" type="hidden"  value="<?php echo $usuario->idUsuarios ?>" >
                                    <p class="tipo_Pag">
                                       <input  name ="tip_PagAnt" type="hidden"  value="<?php echo $result->tipo_Pag ?>" >
                                       <label for="tipo_Pag">Tipo de movimentação</label>
                                       <select id="tipo_Pag" name="tipo_Pag">                                              
                                       <option value = "<?php echo $result->tipo_Pag ?>"><?php echo $tipo_Pagamento; ?></option>
                                       <?php               
                                          if($usuario->conta_Usuario == 99)
                                              {?>                                               
                                       <option value = "trans"> Transferência</option>                
                                       <option value = "cheq"> Cheque</option>
                                                    <?php
                                            }    
                                            ?>														
                                       </select>
                                     <font color=red><span class="style1"> * </span></font>	
                                    </p>
                                                                     
                               
                            <?php 
                                     
                           $conta_DestinoNome = "A mesma";
                                foreach ($result_caixas as $rcix) 
                                {                   
                              if($result->conta_Destino != null && $result->conta_Destino == $rcix->id_caixa)
                                  {
                                  $conta_DestinoNome = $rcix->nome_caixa;
                              }}                                    
                                    ?>                                               
                                     
                        <p class="conta">
                            <label for="conta">à beneficio da conta</label>
                            <select id="conta_Destino" name="conta_Destino">                                              
                            <option value = "<?php echo $result->conta_Destino ?>"><?php echo $result->conta_Destino.' | '.$conta_DestinoNome ; ?></option>
                             <?php
                                foreach ($result_caixas as $rcx) 
                                {                   
                             // if($usuario->conta_Usuario == 99)
                                //   if(($conta < 4) || ($conta > 8))
                                  {?>                                               
                                <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                        <?php
                                }    
                               }
                              ?>														
                            </select>
                         <font color=red><span class="style1"> * </span></font>	
                        </p>
                       
                              
                            <p class="senhaAdm">
                                <label for="senhaAdm"><font color=red>senha Administrador</font></label>
                                <input  name ="senhaAdm" type="password"  value=""  maxlength=50><font color=red> *</font>

                            </p>
                                               
                        </div>
                                          
                                   
                                    

                                   
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
      <input class="span12" id="descricao" type="text" name="descricao" value="Fatura de Venda - #<?php echo $result->id_fin; ?> "  />
      
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
             dataFin: {required:true}
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             razaoSoc: {required: 'Campo Requerido.'},
             dataFin: {required: 'Campo Requerido.'}
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

