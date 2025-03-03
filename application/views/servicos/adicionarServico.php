

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Cadastro de Idoso</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="codigo" class="control-label">Código<span class="required">*</span></label>
                        <div class="controls">
                            <input id="codigo" type="text" name="codigo" value="<?php echo set_value('nomeCliente'); ?>"  maxlength="2" />
                        </div>
                    </div>
                    
                                    
                                
                    <div class="control-group">
                        <label for="area_Cod" class="control-label">Grupo<span class="required">*</span></label>
                        <div class="controls">
                             <select id="area_Cod" name="area_Cod">
                                <option value = ""> Selecione o Grupo</option>
                             <?php { 
                                foreach ($grupos as $rg)
                                    { 
                                        $codG = explode("-", $rg->cod_Comp);
                                        $codGrup = $codG[0];
                                 ?>                                           
                                        <option value = "<?php echo $rg->area_Cod.','.$codGrup.','.$rg->ent_SaiComp ?>" <?php if($rg->area_Cod.','.$codGrup.','.$rg->ent_SaiComp == set_value('documento')){ echo 'selected';} ?>>
                                        <?php echo $codGrup.' - '.$rg->area_Cod.' - '; ?> <?php if($rg->ent_SaiComp == 1){ echo 'Entrada';}else { echo 'Saída';}?></option>
                                       <?php                                                       
                                     }
                                 } 
                                ?>	
                                <option value = "new,D,0" > Novo Grupo SAÍDA</option>	
                                <option value = "new,C,1" > Novo Grupo ENTRADA</option>													
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricaoCod" class="control-label">Descrição do Código<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricaoCod" type="text" name="descricaoCod" value="<?php echo set_value('descricao'); ?>"  />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/servicos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="new" class="control-label">Só se Novo Grupo<span class="required"></span></label>
                        <div class="controls">
                            <input id="new" type="text" name="new" value="<?php echo set_value('new'); ?>"  />
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
           $('#formCliente').validate({
            rules :{
                  codigo:{ required: true},
                  descricaoCod:{ required: true},
                  area_Cod:{ required: true},
                
                 
            },
            messages:{
                  codigo :{ required: 'Campo Requerido.'},
                  descricaoCod :{ required: 'Campo Requerido.'},
                  area_Cod:{ required: 'Campo Requerido.'},
                  
                  

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
          
    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
      });
</script>




