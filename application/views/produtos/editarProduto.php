<style>
/* Hiding the checkbox, but allowing it to be focused */
.badgebox
{
    opacity: 0;
}

.badgebox + .badge
{
    /* Move the check mark away when unchecked */
    text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
	width: 27px;
}

.badgebox:focus + .badge
{
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */
    
    /* Adding a light border */
    box-shadow: inset 0px 0px 5px;
    /* Taking the difference out of the padding */
}

.badgebox:checked + .badge
{
    /* Move the check mark back when checked */
	text-indent: 0;
}
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Editar Presente do <?php echo $contBR; ?></h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formProduto" method="post" class="form-horizontal " >
                     <div class="control-group">
                        <?php echo form_hidden('idProdutos',$result->id_presente) ?>
                        <label for="descricao" class="control-label">Beneficiário<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" value="<?php echo $result->n_beneficiario.'- '.$result->nome_beneficiario; ?>"  style="width: 310px"  />
                            <input id="id_presente" type="hidden" name="id_presente" value="<?php echo $result->id_presente; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Alterar Beneficiario para</label>
                        <div class="controls">
                            <div class="span2">
                                <select id="benef" name="benef"  style="width: 320px" >
                                    <option value = "BR051800058"><?php echo $result->n_beneficiario.'- '.$result->nome_beneficiario; ?></option>
                                 <?php
                                    foreach ($beneficiarios as $rbn) { ?>
                                        <option value = "<?php echo $rbn->documento ?>"><?php echo $rbn->documento." | ".$rbn->nomeCliente ?></option>
                                    <?php
                                   }  ?>														
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="precoCompra" class="control-label" >Valor Entrada R$<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoCompra" class="money" type="text" name="precoCompra" value="<?php echo $result->valor_entrada; ?>" readonly />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="precoVenda" class="control-label">Valor Saída R$<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoVenda" class="money" type="text" name="precoVenda" value="<?php echo $result->valor_saida; ?>" readonly />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="precoPendente" class="control-label">Valor Pendente R$<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoPendente" class="money" type="text" name="precoPendente" value="<?php echo $result->valor_pendente; ?>" readonly />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="protocolo" class="control-label">Protocolo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="protocolo"  type="text" name="protocolo" value="<?php echo $result->n_protocolo; ?>" readonly />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
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
                  descricao: { required: true},
                  precoCompra: { required: true}
            },
            messages:{
                  descricao: { required: 'Campo Requerido.'},
                  precoCompra: { required: 'Campo Requerido.'}
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




