
<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
function formatar_mascara(src, mascara) {
 var campo = src.value.length;
 var saida = mascara.substring(0,1);
 var texto = mascara.substring(campo);
 if(texto.substring(0,1) != saida) {
 src.value += texto.substring(0,1);
 }
}
</script>
<style>
.badgebox
{opacity: 0;}
.badgebox + .badge
{ text-indent: -999999px;width: 27px;}
.badgebox:focus + .badge
{ box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge
{text-indent: 0;}
</style>

<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
    <div class="widget-box"> 
        <div class="span12">           
        <?php 
			$nivel = $usuario->permissoes_id;	
         
        if(!(isset($_SESSION['tipoPesquisa'])) || $_SESSION['tipoPesquisa'] == 0) 
        { 
            ?>
            
        <?php
        }
        if(!(isset($_SESSION['tipoPesquisa'])) || $_SESSION['tipoPesquisa'] == 0) 
        { ?>
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-list-alt"></i>
                    </span>
                    <h5>Relatórios Mensais</h5>
                </div>
                <div class="widget-content">
                    <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiro" method="post">
                    <div class="span12 well">
                    <div class="span3">
                        <?php    
                           ?>
                        <p class="conta">                    
                        <label for="conta">Conta</label>
                          <select  style="width:170px;"  id="conta" name="conta">

                         <?php
                                foreach ($result_caixas as $rcx) {  
                                 if(isset($_SESSION['contA'] ))
                                {
                                foreach ($result_caixas as $rcxx)
                                {                                        
                                    if($_SESSION['contA'] == $rcxx->id_caixa) 
                                    {?>
                                   <option value = "<?php echo $rcxx->id_caixa ?>"><?php echo $rcxx->id_caixa." | ".$rcxx->nome_caixa ?></option>
                                   <?php 
                                }}
                                    unset($_SESSION['contA']) ;
                                }
                                  if($usuario->conta_Usuario == 99)
                                  {                                     
                                  ?>
                            <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa; ?></option>
                                    <?php
                                }else
                                  if($usuario->conta_Usuario == $rcx->id_caixa){
                                      ?>
                            <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                    <?php
                                  }
                                }
                              ?>														
                              </select>
                            <font color=red><span class="style1"> * </span></font>	                    
                        </p>
                    </div>
                    <div class="span2">             
                        <label for="conta">Ano</label>
                                  <?php 
                                  $ano =date("Y");
                                  $anoIni = 2009;
                                  ?>	
                                    <select style="width:100px;" id="ano" name="ano">
                                        <option value ='<?php echo $ano?>'><?php echo $ano ?></option>
                                        <?php --$ano;
                                            while($anoIni < $ano) {?>
                                        <option value = '<?php echo $ano ?>'><?php echo $ano?></option>										
                                        <?php --$ano;} ?>														
                                    </select><span class="style1">*</span>

                        </div>
                    <div class="span2">
                                <label for="conta">Mês</label>	
                                  <?php
                                        $meses = array("", "janeiro", "fevereiro", "março", "abril",
                                        "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
                                        $data = date("m");
                                        $data <= 9 ? $data = $data[1] : $data = $data;
                                        ?>
                                        <select  style="width:100px;" id="mes" name="mes">
                                        <option value='<?php echo $data ?>'><?php echo ' '.$meses[$data] ?></option>
                                        <?php                                            
                                        for($i = 1; $i <= count($meses)-1; $i++) {
                                        $i == $data ? $valor = "selected" : $valor = "";
                                       // $i <= 9 ? $ii = "'0'.$i." : $ii = $i;
                                        ?>
                                        <option value='<?php echo $i ?>'><?php echo ' '.$meses[$i] ?></option>
                                        <?php
                                        }
                                        ?>
                                        </select>												
                                        <span class="style1">*</span>
 </div>
                    <div class="modal-footer">

                         <div class="span2" style="margin-left: 0; text-align: center">
                            <!--<input type="reset" class="btn" value="Limpar" />-->
                            <label  class="btn btn-default" submit><input  name="excel"  type="checkbox" value="Corrente"   class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Excel</label>
                        </div>
                        <div class="span3" style="margin-left: 0; text-align: center">
                            <button class="btn btn-success span12"><i class="icon-list-alt"></i> Relatório mensal</button>
                        </div>
                    </div>  
                    </div>
                    </form>
                        &nbsp
                    </div>
            </div>
        <?php
        }?>
        </div>
    </div>
    </div>            
    <?php
         //else        
          unset($_SESSION['tipoPesquisa']);    
   if((isset($lancamentos)))
     {
    ?>       
 <div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-list-alt"></i>
            </span>
            <h5>Relatórios gerado</h5>
            <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiro" method="post">
                   <input id="excel" name="excel"  type="hidden" value="1"/>
                <div class="row espaco">
                </div>
           </form> 
        </div>
      
</div>
</div>
    <?php
     }
    ?>      
</div>
<script>
 $(function () {
    $('#datetimepicker1').datetimepicker({           
       format: 'DD/MM/YYYY', 
       locale: 'PT-BR'             
});
    $('#datetimepicker2').datetimepicker({           
       format: 'DD/MM/YYYY', 
       locale: 'PT-BR'             
});
    $('#datetimepicker3').datetimepicker({           
       format: 'DD/MM/YYYY', 
       locale: 'PT-BR'             
});
    $('#datetimepicker4').datetimepicker({           
       format: 'DD/MM/YYYY', 
       locale: 'PT-BR'             
});
 });
   
</script>