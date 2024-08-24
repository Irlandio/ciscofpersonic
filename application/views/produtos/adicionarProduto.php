<style>
.badgebox{ opacity: 0;}.badgebox + .badge{text-indent: -999999px;width: 27px;}
.badgebox:focus + .badge{ box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge{text-indent: 0;}
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>ABASTECER</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formProduto" method="post" class="form-horizontal" >                
                
                    <div class="control-group">
                        <label for="data">Data do evento financeiro<span class="control-label required">*</span></label>
                        <div class="controls">
                            <input id="dataCompra" class="datepicker" type="Text" name="dataCompra" value="<?php echo date('d/m/Y')?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="unidade" class="control-label">Posto<span class="required">*</span></label>
                        <div class="controls">
                            <!--<input id="unidade" type="text" name="unidade" value="<?php echo set_value('unidade'); ?>"  />-->
                            <select id="posto" name="posto">
                                <?php
                                foreach ($postos as $p) { ?>
                                    <option value = "<?php echo $p->id_posto  ?>"><?php echo $p->nome." | ".$p->cidade ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                    <label for="unidade" class="control-label">Veículo<span class="required">*</span></label>
                    <div class="controls">
                        <!--<input id="unidade" type="text" name="unidade" value="<?php echo set_value('unidade'); ?>"  />-->
                        <select id="veiculo" name="veiculo">
                            <option value="1">HONDA FIT</option>
                        </select>
                    </div>
                    </div>
<?php var_dump($resultUltimo)?>
                     <div class="control-group">
                        <label for="quilometragem" class="control-label">Quilometragem<span class="required">*</span></label>
                        <div class="controls">
                            <input id="quilometragem" type="number" name="quilometragem" MIN='297000' value="<?php echo set_value('quilometragem'); ?>"  />
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Tipo de combustivel</label>
                        <div class="controls">

                        <label  class="btn btn-default" submit><input  name="tipo" type="radio" value="1" Checked class="badgebox" style="margin-top:5px; margin-left: 0"/> <span class="badge" >&check;</span> Gasolina</label>

                        <label  class="btn btn-default" submit><input  name="tipo" type="radio" value="2" class="badgebox" style="margin-top:5px; margin-left: 0"/> <span class="badge" >&check;</span> Etanol</label>

                        </div>
                    </div>

                    <div class="control-group">
                        <label for="precoCompra" class="control-label">Valor<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoCompra" class="money" type="text" name="precoCompra" value="<?php echo set_value('precoCompra'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="precoCompra" class="control-label">Litros<span class="required">*</span></label>
                        <div class="controls">
                            <input id="litros" class="money" type="text" name="litros" value="<?php echo set_value('litros'); ?>"  />
                        </div>
                    </div>



                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/produtos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>

                    
                </form>
            </div>

         </div>
     </div>
</div>

<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".money").maskMoney();

        $('#formProduto').validate({
            rules :{
                  quilometragem: { required: true},
                  precoCompra: { required: true},
                  litros: { required: true}
            },
            messages:{
                  quilometragem: { required: 'Campo Requerido.'},
                  precoCompra: { required: 'Campo Requerido.'},
                  litros: { required: 'Campo Requerido.'}
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



