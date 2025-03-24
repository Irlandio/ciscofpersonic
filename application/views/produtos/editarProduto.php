<style>
    .badgebox {
        opacity: 0;
    }
    .badgebox+.badge {
        text-indent: -999999px;
        width: 27px;
    }
    .badgebox:focus+.badge {

        box-shadow: inset 0px 0px 5px;
    }
    .badgebox:checked+.badge {
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
                <h5>ABASTECER</h5>
            </div>

            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formProduto" method="post" class="form-horizontal">

                    <div class="control-group">
                        <?php echo form_hidden('id_comb', $result->id_comb) ?>
                    </div>

                    <div class="control-group">

                        <label for="descricao" class="control-label">Abastecimento <span class="required">*</span></label>
                        <div class="controls">
                            <h4><?php echo $result->id_comb; ?><input id="id_comb" type="hidden" name="id_comb" value="<?php echo $result->id_comb; ?>" /></h4>
                        </div>
                    </div>

                    <!-- Campo Data do Evento Financeiro -->
                    <div class="control-group">
                        <label for="dataCompra" class="control-label">Data do evento financeiro<span class="required">*</span></label>
                        <div class="controls">
                            <input id="dataCompra" class="datepicker" type="text" name="dataCompra"
                                value="<?php echo set_value('dataCompra', date('d/m/Y H:i', strtotime($result->data_abast))); ?>" />
                        </div>
                    </div>

                    <!-- Campo Posto -->
                    <div class="control-group">
                        <label for="posto" class="control-label">Posto<span class="required">*</span></label>
                        <div class="controls">
                            <select id="posto" name="posto">
                                <?php foreach ($postos as $p) { ?>
                                    <option value="<?php echo $p->id_posto; ?>"
                                        <?php echo set_select('posto', $p->id_posto, ($p->id_posto == $result->posto)); ?>>
                                        <?php echo $p->nome . " | " . $p->cidade_nome ; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Campo Veículo -->
                    <div class="control-group">
                        <label for="veiculo" class="control-label">Veículo<span class="required">*</span></label>
                        <div class="controls">
                            <select id="veiculo" name="veiculo">
                                <option value="1" <?php echo set_select('veiculo', '1', ($result->veiculo == '1')); ?>>HONDA FIT</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campo Quilometragem -->
                    <div class="control-group">
                        <label for="quilometragem" class="control-label">Quilometragem<span class="required">*</span></label>
                        <div class="controls">
                            <input id="quilometragem" type="number" name="quilometragem" min="297000"
                                value="<?php echo set_value('quilometragem', $result->quilometragem); ?>" />
                        </div>
                    </div>
                    
                    <!-- Campo Tipo de Combustível -->
                    <div class="control-group">
                        <label class="control-label">Tipo de combustível</label>
                        <div class="controls">
                            <label class="btn btn-default" submit>
                                <input name="tipo" type="radio" class="badgebox" value="1"
                                    <?php echo set_radio('tipo', '1', ($result->tipo_combustivel == '1' || $result->tipo_combustivel == 'gasolina')); ?> />
                                <span class="badge" >&check;</span> 
                                Gasolina
                            </label>

                            <label class="btn btn-default">
                                <input name="tipo" type="radio" class="badgebox" value="2"
                                    <?php echo set_radio('tipo', '2', ($result->tipo_combustivel == '2' || $result->tipo_combustivel == 'etanol')); ?> />
                                <span class="badge" >&check;</span> 
                                Etanol
                            </label>
                        </div>
                    </div>

                    <!-- Campo Valor -->
                    <div class="control-group">
                        <label for="precoCompra" class="control-label">Valor<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoCompra" class="money" type="number" name="precoCompra"
                                value="<?php echo set_value('precoCompra', $result->valor); ?>" />
                        </div>
                    </div>

                    <!-- Campo Litros -->
                    <div class="control-group">
                        <label for="litros" class="control-label">Litros<span class="required">*</span></label>
                        <div class="controls">
                            <input id="litros" class="money" type="number" name="litros"
                                value="<?php echo set_value('litros', $result->litros); ?>" />
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


<!-- 'quilometragem'  'data_abast' 'litros' 'valor' 'posto'  'veiculo' => set_value('veiculo') -->
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".money").maskMoney();

        $('#formProduto').validate({
            rules: {
                descricao: {
                    required: true
                },
                precoCompra: {
                    required: true
                }
            },
            messages: {
                descricao: {
                    required: 'Campo Requerido.'
                },
                precoCompra: {
                    required: 'Campo Requerido.'
                }
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });
</script>