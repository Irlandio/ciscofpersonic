<?php

$i = 1;
$var='resultFin'.$i; 
$i = 1;
        ?>
<div class="span6">
        <?php
             foreach ($result as $r) {
        ?>
    <div class="accordion" id="collapse-group">
        <div class="accordion-group widget-box">
            <div class="accordion-heading">
                <div class="widget-title">
                    <a data-parent="#collapse-group" href="#collapse<?php echo $i ?>" data-toggle="collapse">
                        <span class="icon"><i class="icon-list"></i></span><h5>Lançamento <?php echo $i ?> do Presente</h5>
                    </a>
                </div>
            </div>
            <div class="collapse in accordion-body" id="collapse<?php echo $i ?>">
                <div class="widget-content">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="text-align: right; width: 30%"><strong>Descrição</strong></td>
                                <td><?php echo $r->nome_beneficiario ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>n_beneficiario</strong></td>
                                <td><?php echo $r->n_beneficiario ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>valor_entrada</strong></td>
                                <td>R$ <?php echo $r->valor_entrada; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>valor_saida</strong></td>
                                <td>R$ <?php echo $r->valor_saida; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>Pendente</strong></td>
                                <td>R$ <?php echo $r->valor_pendente; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>n_protocolo</strong></td>
                                <td><?php echo $r->n_protocolo; ?></td>
                            </tr>                  
                        </tbody>
                    </table>
                        <div class="buttons">
                           <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto') && 0 == $r->id_saida){
                            echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/produtos/editar/'.$r->id_presente.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                        } ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
        <?php
        $i++;
             }
        ?>
</div>

<div class="span6">
        <?php

$i = 1;
if($resultFin1)
for($i = 1;$i <= 2;$i++)
    {
    $var='resultFin'.$i;
    if(isset($$var))
    {
    ?>
    <div class="accordion" id="collapse-group">
        <div class="accordion-group widget-box">
            <div class="accordion-heading">
                <div class="widget-title">
                    <a data-parent="#collapse-group" href="#collapse2<?php echo $i ?>" data-toggle="collapse">
                        <span class="icon"><i class="icon-list"></i></span><h5>Lançamento <?php echo $i ?> de Saída</h5>
                    </a>
                </div>
            </div>
            <div class="collapse in accordion-body"  id="collapse2<?php echo $i ?>">
                <div class="widget-content">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="text-align: right; width: 30%"><strong>Descrição</strong></td>
                                <td><?php echo $$var->historico ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>Descrição</strong></td>
                                <td>R$ <?php echo $$var->descricao; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>BR do Beneficiario</strong></td>
                                <td><?php echo $$var->dataFin ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>Valor</strong></td>
                                <td>R$ <?php echo $$var->valorFin; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>Conta</strong></td>
                                <td>R$ <?php echo $$var->conta." ".$$var->tipo_Conta; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right"><strong>cadastrante</strong></td>
                                <td><?php echo $$var->cadastrante; ?></td>
                            </tr>                  
                        </tbody>
                    </table>
                        <div class="buttons">
                           <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                            echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/vendas/editar/'.$$var->id_fin.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                        } ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
        <?php
     //   $i++;
    }
    }
    else  { ?>
    <H4>Sem lançamentos de Saída até o momento.</H4>
    <?php }   ?>
        
</div>
