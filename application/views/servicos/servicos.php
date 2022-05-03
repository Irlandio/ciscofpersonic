<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aServico') && 1==2){ ?>
    <a href="<?php echo base_url()?>index.php/servicos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Código</a>
<?php } ?>
<?php

            if($usuario->conta_Usuario == 99)
                      { $contaNome = "Todas contas";
                        }else
                          { $contaNome = $usuario->nome_caixa;
                              
                  }
            $conta = $usuario->conta_Usuario;
			$nivel = $usuario->permissoes_id;	
            $tipo_conta_acesso = $usuario->celular;

           
 
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Código</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>-descricao </th>
                        <th>area_Cod</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Código Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
	

?>
<div class="widget-box">-   <?php
                              echo 'Usuário: '.$usuario->nome.' | Conta do usuário: '. $contaNome.' | Nivel: '. $nivel.' '.$usuario->permissao.'  | Acesso de tipo de conta: '. $tipo_conta_acesso ;
                    ?>
 <div class="widget-title">
     
    <span class="icon">
        <i class="icon-user"></i>
     </span>
     
   <?php
    if(9 == 99)
    {
   ?>                        
    <form method="get" action="<?php echo base_url(); ?>index.php/servicos/gerenciar">      

        <div class="span3">
            <input type="text" name="pesquisa"  id="pesquisa"  placeholder="Nome do Beneficiário a pesquisar" class="span12" value="" >
        </div>
        <?php
    if($conta == 99)
    {
   ?>
        <div class="span2">           
                        
                          <select id="status" name="status">
                         <?php
                              echo 'Conta '. $conta.' Nivel '. $nivel.' Acesso de conta '. $tipo_conta_acesso ;
                                foreach ($result_caixas as $rcx) {                   
                              if($usuario->conta_Usuario == 99)
                              {?>
                            <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
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

        </div>

        <?php
    }else{
        ?>
        
        <div class="span3">
            <input type="text" name="pesquisaBR"  id="pesquisaBR"  placeholder="BR do Beneficiário a pesquisar" class="span12" value="" >
        </div>
        <?php
    }
        ?>
        
        <div class="span1">
            <button class="span12 btn"> <i class="icon-search"></i> </button>
        </div>
    </form>
           
        <?php }
   ?>                
                         </div>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Descrição </th>
                        <th>Aréa</th>
                        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            if($r->codigoNovo != 1) {$fonti = '<font  color = #9f9ff5 >'; $fontf = '</font> (Inativo)';}else {$fonti = ''; $fontf = '';}
            echo '<tr>'; 
            echo '<td>'.$fonti.$r->cod_Comp.$fontf.'</font></td>';
            echo '<td>'.$fonti.$r->descricao.$fontf.'</td>';
            echo '<td>'.$fonti.$r->area_Cod.$fontf.'</td>';
            echo '<td>'.$fonti.$r->ent_SaiComp.$fontf.'</td>';
            echo '<td>';
            if(1==2){
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){
                echo '<a href="'.base_url().'index.php/servicos/visualizar/'.$r->cod_Comp.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eServico')){
                echo '<a href="'.base_url().'index.php/servicos/editar/'.$r->cod_Comp.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Idoso"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dServico')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="'.$r->cod_Comp.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir cadastro de Idoso"><i class="icon-remove icon-white"></i></a>'; 
            }}              
            echo '</td>';
           
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
<?php }
echo $this->pagination->create_links();
?>

        <div class="widget-box">        
    <form method="post" action="<?php echo base_url(); ?>index.php/servicos/gerenciar"> 
        <div class="span6">
            
            <input  class="span2" type="text" name="inicio"  id="inicio"  placeholder="Registro Inicial" value="114950">
            <input  class="span2" type="text" name="altera"  id="altera"    value="1" >
                <div class="span6 offset3">
                    <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                </div>
            
        </div>  
    </form>            
</div>   
     


 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/servicos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Idoso</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idIdoso" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este cliente e os dados associados a ele (OS, Vendas, Receitas)?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>





<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var servico = $(this).attr('cliente');
        $('#idIdoso').val(servico);

    });

});

</script>