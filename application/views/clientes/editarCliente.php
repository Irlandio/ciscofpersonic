<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
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
                <h5>Editar Beneficiário</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } 
                $br = substr($result->documento, -4);
                ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('idClientes',$result->idClientes) ?>
                        <label for="nomeCliente" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nomeCliente" type="text" name="nomeCliente" value="<?php echo $result->nomeCliente; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="documento" class="control-label">BR (Beneficiário)<span class="required">*</span></label>
                        <div class="controls">
                            <input id="documento" type="text" name="documento" value="<?php echo $br; ?>" readonly maxlength="4" size="4"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="telefone" class="control-label">BR (Projeto)<span class="required">*</span></label>
                        <div class="controls">
                              <?php
                            
                            switch ($result->telefone) 
                                    {					
                                        case 4:	$br_Proj = "BR-214 Planalto";	break;  
                                        case 5:	$br_Proj = "BR-518 Janga";	break;  
                                        case 6:	$br_Proj = "BR-542 Bezerros";	break;  
                                        case 7:	$br_Proj = "BR-549 Catende";	break;  
                                        case 8:	$br_Proj = "BR-579 Jurema";	break;  				
                                    }    
                            switch ($result->sexo) 
                                    {					
                                        case "M":	$sexN = "Masculino";	break;  
                                        case "F":	$sexN = "Feminino";	break;  				
                                    }              
                            switch ($result->pessoa_fisica) 
                                    {					
                                        case "1":	$sttN = "Ativo";	break;  
                                        case "0":	$sttN = "Inativo";	break;  				
                                    }   
                             
                            $dataNasc     = explode('-', $result->dataCadastro);
                            $dataN    = $dataNasc[2].'/'.$dataNasc[1].'/'.$dataNasc[0];

                            
                            ?>
                          <select  style="width:150px;" id="brProjeto" name="brProjeto" readonly>
                               <option value = "<?php echo $result->telefone; ?>"><?php echo $br_Proj; ?></option>  
                              											
                              </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">Estatus<span class="required">*</span></label>
                        <div class="controls">
                            
                          <select  style="width:150px;" id="statu" name="statu">
                               <option value = "<?php echo $result->pessoa_fisica; ?>"><?php echo $sttN; ?></option> 
                               <option value = "1">Ativo</option>             
                               <option value = "0">Inativo</option>              
                              											
                              </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">Sexo<span class="required">*</span></label>
                        <div class="controls">
                            
                          <select  style="width:150px;" id="sexo" name="sexo">
                               <option value = "<?php echo $result->sexo; ?>"><?php echo $sexN; ?></option> 
                               <option value = "M">Masculino</option>             
                               <option value = "F">Feminino</option>              
                              											
                              </select>
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">Data Nasc<span class="required">*</span></label>
                        <div class="controls">
                            <input type='text' class="form_date" id='datetimepicker1'   name="dataNasc" value="<?php echo $dataN; ?>"  maxlength="10" />
                        </div>
                    </div>




                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/clientes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
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

<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
           $('#formCliente').validate({
            rules :{
                  nomeCliente:{ required: true},
                  documento:{ required: true},
                  dataNasc:{ required: true},
                  sexo:{ required: true}
            },
            messages:{
                  nomeCliente :{ required: 'Campo Requerido.'},
                  documento :{ required: 'Campo Requerido.'},
                  dataNasc:{ required: 'Campo Requerido.'},
                  sexo:{ required: 'Campo Requerido.'}

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
      });
</script>

