

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
                        <label for="nomeCliente" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nomeCliente" type="text" name="nomeCliente" value="<?php echo set_value('nomeCliente'); ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="documento" class="control-label">CPF<span class="required">*</span></label>
                        <div class="controls">
                            <input id="documento" type="text" name="documento" value="<?php echo set_value('documento'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label">Data de Nascimento</label>
                        <div class="controls">
                            <input id="data_Nasc" class="span3 datepicker" type="Text" name="data_Nasc" value="<?php echo date('d/m/Y'); ?>"  />
                            <!--<input id="data_Nasc" type="text" name="data_Nasc" value="<?php echo set_value('data_Nasc'); ?>"  />-->
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">RG<span class="required">*</span></label>
                        <div class="controls">
                            <input id="rg" type="text" name="rg" value="<?php echo set_value('rg'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">sexo<span class="required">*</span></label>
                        <div class="controls">
                            <select id="sexo" name="sexo">   
                                        <option value = "">Selecione </option> 
                                        <option value = "m">Masculino</option>  
                                        <option value = "f">Feminino</option>
                                        </select>
                        
                           <!-- <input id="sexo" type="text" name="sexo" value="<?php echo set_value('sexo'); ?>"  />-->
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label">Data de Admissao</label>
                        <div class="controls">
                            <input id="data_Admc" class="span3 datepicker" type="Text" name="data_Admc" value="<?php echo date('d/m/Y'); ?>"  />
                            <!--<input id="data_Nasc" type="text" name="data_Nasc" value="<?php echo set_value('data_Admc'); ?>"  />-->
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="numero" class="control-label">status<span class="required">*</span></label>
                        <div class="controls">
                            <select id="status" name="status">   
                                        <option value = "">Selecione </option> 
                                        <option value = "ativo">Ativo</option>  
                                        <option value = "inativo">Inativo</option>
                                        </select>
                            <!--<input id="status" type="text" name="status" value="<?php echo set_value('status'); ?>"  />-->
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
                  nomeCliente:{ required: true},
                  documento:{ required: true},
                  rg:{ required: true},
                
                 
            },
            messages:{
                  nomeCliente :{ required: 'Campo Requerido.'},
                  documento :{ required: 'Campo Requerido.'},
                  rg:{ required: 'Campo Requerido.'},
                  
                  

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




