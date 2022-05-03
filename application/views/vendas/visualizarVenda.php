<?php $totalProdutos = 0;?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Lançamento <?php echo $result->id_fin?></h5>
                <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/vendas/editar/'.$result->id_fin.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
                    <a target="_blank" title="Imprimir" class="btn btn-mini btn-inverse" href="<?php echo site_url()?>/vendas/imprimir/<?php echo $result->id_fin; ?>"><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content" id="printOs">
                <div class="invoice-content">
                    <div class="invoice-head">
                        
                          <!--  
                            <tbody>

                                <?php if($emitente == null) {?>
                                            
                                <tr>
                                    <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/mapos/emitente">Configurar</a></td>
                                </tr>
                                <?php } else {?>

                                <tr>
                                    <td style="width: 25%"><img src=" <?php echo $emitente[0]->url_logo; ?> "></td>
                                    <td> <span style="font-size: 20px; "> <?php echo $emitente[0]->nome; ?></span> </br><span><?php echo $emitente[0]->cnpj; ?> </br> <?php echo $emitente[0]->rua.', nº:'.$emitente[0]->numero.', '.$emitente[0]->bairro.' - '.$emitente[0]->cidade.' - '.$emitente[0]->uf; ?> </span> </br> <span> E-mail: <?php echo $emitente[0]->email.' - Fone: '.$emitente[0]->telefone; ?></span></td>
                                    <td style="width: 18%; text-align: center">#Venda: <span ><?php echo $result->idVendas?></span></br> </br> <span>Emissão: <?php echo date('d/m/Y');?></span>
	                                    <?php if($result->faturado): ?>
                                            <br>
                                            Vencimento: <?php echo date('d/m/Y', strtotime($result->data_vencimento)); ?>
	                                    <?php endif; ?>
                                    </td>
                                </tr>

                                <?php } ?>
                            </tbody>
                        </table>
   -->
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0">
                                        <?php 
                                          
                                                    $descri_Comp = "Indefinido";                                                 
                                                    $area_Comp = "Indefinido";
                                             if(NULL !== $result->cod_compassion){
                                             foreach ($result_codComp as $rcodComp)
                                             {if ($result->cod_compassion == $rcodComp->cod_Comp) 
                                                    $descri_Comp = $rcodComp->descricao;                                                 
                                                    $area_Comp = $rcodComp->area_Cod;                                        
                                             }}                                       
                                       
                                        $descri_Asso = "Indefinido"; 
                                         if(NULL !== $result->cod_assoc){
                                         foreach ($result_codIead as $rcodIead)
                                         {if ($result->cod_assoc == $rcodIead->cod_Ass) 
                                                $descri_Asso = $rcodIead->descricao_Ass;
                                         }}?>
                                        <ul>
                                            <li>
                                                    
                                                <span>Conta:</span>
                                                 <label for="nome_caixa"><h5><?php echo $result->nome_caixa .' - '.$result->tipo_Conta ?></h5></label>
                                                    
                                                <span>  Código Compassion:</span><br/>
                                                 <label for="cod_compassion"><h5><?php echo $result->cod_compassion." | ".$descri_Comp." | ".$area_Comp ?></h5></label>
                                                    
                                                <span>Código Associação: </span><br/>
                                                 <label for="cod_assoc"><h5><?php echo $result->cod_assoc." | ".$descri_Asso ?></h5></label>
                                                
                                                <span>Número do Documento Bancário: </span><br/>
                                                <label for="num_Doc_Banco"><h5><?php echo $result->num_Doc_Banco?> </h5></label>
                                                    
                                                <span>Número do Documento Fiscal:</span><br/>                  
                                                 <label for="num_Doc_Fiscal"><h5><?php echo $result->num_Doc_Fiscal?></h5></label>               
                                                
                                                <span>Razão social:</span> <br/>
                                                <label for="historico"><h5><?php echo $result->historico?></h5></label>
                                                
                                                <span>Descricao:</span><br/>
                                                <label for="descricao"><h5> <?php echo $result->descricao?></h5></label>
                                                
                                                    
                                            </li>
                                        </ul>
                                    </td>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span>Data do evento:</span>
                                                <label for="dataFin"><h5> <?php echo date('d/m/Y', strtotime($result->dataFin)) ?></h5></label>
                                                
                                                <span>Forma de saida:</span><br/>
                                                <label for="numeroDocFiscal"><h5><?php echo $result->tipo_Pag; ?></h5></label>
                                                
                                                <span>Valor do evento:</span>
                                                <label for="valorFin"><h5> <?php echo  number_format($result->valorFin, 2, ',', '.') ?></h5></label>
                                                <?php if($result->ent_Sai == '1') $e_S = 'Entrada'; else $e_S = 'Saída'; ?>
                                                
                                                <label for="ent_Sai"><h5>Lançamento de <?php echo  $e_S ?></h5></label>
                                                <?php 
             if(($result->conta_Destino) == null) $cDestinoNome = "A mesma";
                                                    else{
                    switch ($result->conta_Destino) 
					{						    
						case 1:	$cDestinoNome = "IEADALPE - 1444-3";	break;    
						case 2:	$cDestinoNome = "22360-3";	break;  
						case 3:	$cDestinoNome = "ILPI";	break;  
						case 4:	$cDestinoNome = "BR214";	break;  
						case 5:	$cDestinoNome = "BR518";	break;  
						case 6:	$cDestinoNome = "BR542";	break;  
						case 7:	$cDestinoNome = "BR549";	break;  
						case 8:	$cDestinoNome = "BR579";	break;  
						case 9:	$cDestinoNome = "BB 28965-5";	break;  
						case 10:$cDestinoNome = "CEF 1948-4";	break; 				
					}   
                                                    }
                                   ?>
                                                <span>Conta beneficiaria:</span><br/>
                                                <label for="numeroDocFiscal"><h5><?php echo $cDestinoNome; ?></h5></label>
                                                
                                                
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
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
      
                    </div>
<!--
                    <div style="margin-top: 0; padding-top: 0">


                        <?php if($produtos != null){?>
              
                        <table class="table table-bordered table-condensed" id="tblProdutos">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 15px">Produto</th>
                                            <th style="font-size: 15px">Quantidade</th>
                                            <th style="font-size: 15px">Sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        foreach ($produtos as $p) {

                                            $totalProdutos = $totalProdutos + $p->subTotal;
                                            echo '<tr>';
                                            echo '<td>'.$p->descricao.'</td>';
                                            echo '<td>'.$p->quantidade.'</td>';
                                            
                                            echo '<td>R$ '.number_format($p->subTotal,2,',','.').'</td>';
                                            echo '</tr>';
                                        }?>

                                        <tr>
                                            <td colspan="2" style="text-align: right"><strong>Total:</strong></td>
                                            <td><strong>R$ <?php echo number_format($totalProdutos,2,',','.');?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                               <?php }?>
                        
                
                        <hr />
                    
                        <h4 style="text-align: right">Valor Total: R$ <?php echo number_format($totalProdutos,2,',','.');?></h4>

                    </div>
            -->

                    
                    
              
                </div>
            </div>
        </div>
    </div>
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
 <!--<a href="" link="" class="btn btn-danger" id="excluir-anexo">Excluir Anexo</a>-->
  </div>
</div> 


<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){

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
    
     


        
       $(document).on('click', '.anexo', function(event) {
           event.preventDefault();
           var link = $(this).attr('link');
           var id = $(this).attr('imagem');
           var url = '<?php echo base_url(); ?>os/excluirAnexo/';
           $("#div-visualizar-anexo").html('<img src="'+link+'" alt="">');
           $("#excluir-anexo").attr('link', url+id);

           $("#download").attr('href', "<?php echo base_url(); ?>index.php/os/downloadanexo/"+id);

       });

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


       });
</script>