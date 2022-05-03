	
    <style>
.badgebox
{    opacity: 0;}
.badgebox + .badge
{    text-indent: -999999px;	width: 27px;}
.badgebox:focus + .badge
{    box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge
{	text-indent: 0;}
</style>

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
		  	<?php

            if($usuario->conta_Usuario == 99)
                      { $contaNome = "Todas contas";
                        }else
                          { $contaNome = $usuario->nome_caixa;
                              
                  }
            $conta = $usuario->conta_Usuario;
			$nivel = $usuario->permissoes_id;	
            $tipo_conta_acesso = $usuario->celular;

            $_SESSION['t_Cont'] = "0";

              include 'apoio/funcao.php';
 ?>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">                
                <h5>Lançamentos  -   <?php
                              echo 'Usuário: '.$usuario->nome.' | Conta do usuário: '. $contaNome.' | Nivel: '. $nivel.' '.$usuario->permissao.'  | Acesso de tipo de conta: '. $tipo_conta_acesso ;
                    ?></h5>
            </div>
            <div class="widget-content nopadding">
                
                <div class="invoice-content">
                <?php 
               
                if(isset($result_A))
               { 
                    echo $_POST['idLanc'];                   
                  //  foreach ($result_A as $rA) 
                    {
                       
                       // echo  'Exclusão em processo de criação.' ;
                         ?>       
                
                    <div class="invoice-head">
                        
   
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0"><?php 
                                          
                                                    $descri_Comp = "Indefinido";                                                 
                                                    $area_Comp = "Indefinido";
                                             if(NULL !== $result_A->cod_compassion){
                                             foreach ($result_codComp as $rcodComp)
                                             {if ($result_A->cod_compassion == $rcodComp->cod_Comp) 
                                                    $descri_Comp = $rcodComp->descricao;                                                 
                                                    $area_Comp = $rcodComp->area_Cod;                                        
                                             }}                                       
                                       
                                        $descri_Asso = "Indefinido"; 
                                         if(NULL !== $result_A->cod_assoc){
                                         foreach ($result_codIead as $rcodIead)
                                         {if ($result_A->cod_assoc == $rcodIead->cod_Ass) 
                                                $descri_Asso = $rcodIead->descricao_Ass;
                                         }}?>
                                        <ul>
                                            <li>
                                                    
                                                <span>Conta:</span>
                                                 <label for="caixa"><h5><?php echo $result_A->nome_caixa .' - '.$result_A->tipo_Conta ?></h5></label>
                                                    
                                                <span>  Código Compassion:</span><br/>
                                                 <label for="codComp"><h5><?php echo $result_A->cod_compassion." | ".$descri_Comp ?></h5></label>
                                                    
                                                <span>Código Associação: </span><br/>
                                                 <label for="codAss"><h5><?php echo $result_A->cod_assoc." | ".$descri_Asso ?></h5></label>
                                                
                                                <span>Número do Documento Bancário: </span><br/>
                                                <label for="numBanc"><h5><?php echo $result_A->num_Doc_Banco?> </h5></label>
                                                    
                                                <span>Número do Documento Fiscal:</span><br/>                  
                                                 <label for="numeroDocFiscal"><h5><?php echo $result_A->num_Doc_Fiscal?></h5></label>               
                                                
                                                <span>Razão social:</span> <br/>
                                                <label for="hist"><h5><?php echo $result_A->historico?></h5></label>
                                                
                                                <span>Descricao:</span><br/>
                                                <label for="descri"><h5> <?php echo $result_A->descricao?></h5></label>
                                                
                                                    
                                            </li>
                                        </ul>
                                    </td>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span>Data do evento:</span>
                                                <label for="data"><h5> <?php echo date('d/m/Y', strtotime($result_A->dataFin)) ?></h5></label>
                                                
                                                <span>Forma de saida:</span><br/>
                                                <label for="pagam"><h5><?php echo $result_A->tipo_Pag; ?></h5></label>
                                                
                                                <span>Valor:</span>
                                                <label for="valor"><h5> <?php echo  number_format($result_A->valorFin, 2, ',', '.') ?></h5></label>
                                                
                                                <?php   if($result_A->ent_Sai == 0) $e_S = 'Saída'; else  $e_S = 'Entrada'; ?>
                                                <label for="numeroDocFiscal"><h5>Lançamento de <?php   echo $e_S; ?></h5></label>
                                                 <?php 
                                                
                                                switch ($result_A->conta_Destino) 
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
                                                        }                        ?>
                                                <span>Conta beneficiaria:</span><br/>
                                                <label for="numeroDocFiscal"><h5><?php echo $cDestinoNome; ?></h5></label>
                                                
                                                <?php if($_POST['oP_Exc'] ==  "exclui"){?>
                                                    <a href="#modal-excluir" role="button" data-toggle="modal" venda="<?php echo $result_A->id_fin ?>" class="btn btn-danger tip-top" title="Excluir lançamento"><button class="btn btn-danger">Excluir Lançamento</button></a>
                                                <?php
                                                } else 
                                                    if($_POST['oP_Exc'] ==  "anexo"){?>
                                                        <a href=" <?php echo base_url().'index.php/vendas/editar/'.$result_A->id_fin; ?>" role="button" venda="<?php echo $result_A->id_fin ?>" class="btn btn-success tip-top" title="Exclua o Anexo">  <button class="btn btn-success" id="btnContinuar"><i class="icon-lock  icon-white"></i> Exclua antes o anexo</button></a>
                                                        <?php
                                                }  else 
                                                    if($_POST['oP_Exc'] ==  "presentes"){?>
                                                        <a href="" role="button" venda="<?php echo $result_A->id_fin ?>" class="btn btn-success tip-top" title="Exclua saídas deste presente">  <button class="btn btn-success" id="btnContinuar"><i class="icon-lock  icon-white"></i> Exclua antes as saídas</button></a>
                                                        <?php
                                                } if(isset($presentesE) )
                                                    { ?>  
                                                    <br/><span>Lançamentos em presentes especiais a serem alterados com esta exclusão:</span>
                                                                                                      
                                                    <?php 
                                                    $contPre = 0;
                                                    $protocRepet = 'a';
                                                foreach ($presentesE as $presExc) 
                                                { 
                                                 // $contPre = $contPre + 1; 
                                                //  $n_id_presente =  'id_presente'.$contPre;
                                               //   $id_presente  = $presExc->id_presente;
                                        //***Se o presente for diferente do anterior    
                                                if($protocRepet !== $presExc->n_protocolo) 
                                                {
                                                
                                                ?>
                                                <label for="Lançamento"><h5> <?php echo $presExc->id_presente.' protocolo '.$presExc->n_protocolo.' Data '.$presExc->data_presente.'.' ?></h5></label>  
                                                <?php 
                                                    
                                                    
                                                }else 
                                        //***Se o presente for o mesmo do anterior                                                 
                                                if($protocRepet == $presExc->n_protocolo) 
                                                {                                                                                                
                                                if($result_A->ent_Sai == 0) 
                                                {
                                                    
                                                ?>   
                                                
                                                <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />
                                                <input type="hidden" id="idLanc" name="idLanc" value="<?php echo $idpresExc; ?>" />
                                                <label for="Lançamento"><h5> <?php echo $presExc->id_presente.' protocolo '.$presExc->n_protocolo.' Data '.$presExc->data_presente.'. ' ?></h5></label> 
                                                <?php 
                                                }else if($result_A->ent_Sai == 1)
                                                 {
                                                ?>   
                                                <form action="<?php echo current_url(); ?>" method="post" > 
                                                <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />
                                                <input type="hidden" id="idLanc" name="idLanc" value="<?php echo $idpresExc; ?>" />
                                                <label for="Lançamento"><h5> <?php echo $presExc->id_presente.' protocolo '.$presExc->n_protocolo.' Data '.$presExc->data_presente.'. ' ?>                                  
                                                 <button class="btn btn-danger">Excluir antes<i class="icon-remove icon-white" title="Excluir lançamento"></i></button></h5></label> 
                                                </form>
                                                <?php 
                                                } 
                                                }
                                                    $idpresExc = $presExc->id_saida;
                                                    $protocRepet = $presExc->n_protocolo; 
                                                }} ?>
                                                
                                 
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
      
                    </div>
                    <?php
                    
                    }
                    
                }else

                {?>
                

                <form action="<?php echo base_url(); ?>index.php/vendas/adicionar" method="post" name="form" class="form">	
               <!--<form  method="post" name="form" class="form">	 -->
                  <div class="span4" >      
                <p class="conta">
                    
                        <label for="conta"><H5>Conta</H5></label>
                          <select id="conta" name="conta">
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

                            <font color=red><span class="style1"> * </span></font>	
                    
                  <p>
                        <label for="tipCont"><H5>Movimentação</H5></label>
                      <td>	

                           <label  class="btn btn-default" submit><input  name="tipoES" checked="checked" type="radio" value="0"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Despesa</label>

                         <?php 
                         
                          if($nivel < 3)
                              {
                          ?>
                           <label  class="btn btn-default" submit><input  name="tipoES" type="radio" value="1"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Receita</label><br/>

                       <?php }                
                        unset($_SESSION['conta']);        
                        unset($_SESSION['tipoCont']);
                        unset($_SESSION['cod_Ass']);
                        unset($_SESSION['cod_Comp']) ;
						unset($_SESSION['numeroDoc']);
						unset($_SESSION['numDocFiscal']);
						unset($_SESSION['razaoSoc']);
						unset($_SESSION['descri']);	
                        unset($_SESSION['valorFin']);
                        unset($_SESSION['tipoPag']);//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
						unset($_SESSION['tipoES']) ; 
                        unset($_SESSION['conta_Destino']);        
                        unset($_SESSION['cadastrante']);
                        unset($_SESSION['qtd_presentes']);
                        unset($_SESSION['id_presentes']) ;
						unset($_SESSION['senhaAdm']);
                        	 ?>
                    </p>
                        
                    
                 </div>
                    <div class="span4" >
                    <p>
                        <label for="tipCont"><H5>Tipo de conta</H5></label>


                            <?php

                            switch ($tipo_conta_acesso) 
                            {
                                case 1:	?>	
                                   <label  class="btn btn-default" submit><input  name="tipCont" checked="checked" type="radio" value="Suporte"   class="badgebox" style="margin-top:5px;"/>
                                                            <span class="badge" >&check;</span> Suporte</label><br/>

                                     <?php
                                    break;    
                                case 2:	?>	
                                    <label  class="btn btn-default" submit><input  name="tipCont"  type="radio" value="Corrente"   class="badgebox" style="margin-top:15px;"/>
                                                            <span class="badge" >&check;</span> Corrente</label> 

                                     <?php
                                    break;  
                                case 3:		?>	
                                   <label  class="btn btn-default" submit><input  name="tipCont" checked="checked" type="radio" value="Suporte"   class="badgebox" style="margin-top:5px;"/>
                                                            <span class="badge" >&check;</span> Suporte</label><br/> 
                                    <label  class="btn btn-default" submit><input  name="tipCont"  type="radio" value="Corrente"   class="badgebox" style="margin-top:5px;"/>
                                                            <span class="badge" >&check;</span> Corrente</label> 

                                     <?php
                                    break;  
                                case 4:	?>	
                                   <label  class="btn btn-default" submit><input  name="tipCont" checked="checked" type="radio" value="Suporte"   class="badgebox" style="margin-top:5px;"/>
                                                            <span class="badge" >&check;</span> Suporte</label> <br/>
                                    <label  class="btn btn-default" submit><input  name="tipCont"  type="radio" value="Corrente"   class="badgebox" style="margin-top:5px;"/>
                                                            <span class="badge" >&check;</span> Corrente</label> <br/>
                                    <label  class="btn btn-default" submit><input  name="tipCont"  type="radio" value="Investimento"   class="badgebox" style="margin-top:5px;"/>
                                                            <span class="badge" >&check;</span> F. Investimento</label> <br/>
                                    <label  class="btn btn-default" submit><input  name="tipCont" type="radio" value="Poupança"   class="badgebox" style="margin-top:5px;"/>
                                                            <span class="badge" >&check;</span> Poupança</label> 
                                     <?php
                                    break; 				
                            }	
                            ?>

                        </p>

                    </div> 
						<script type="text/javascript">
							function id( el ){
									return document.getElementById( el );
							}
							function mostra( el ){
									id( el ).style.display = 'block';                                  
                            }
                           
							function esconde_todos( el, tagName ){
									var tags = el.getElementsByTagName( tagName );
									for( var i=0; i<tags.length; i++ )
									{	tags[i].style.display = 'none';
									}
							}
							window.onload = function()
							{
									id('true').style.display = 'none';
									id('presentes').onchange = function()
									{
											esconde_todos( id('palco'), 'div' );
											mostra( this.value );
									}
									var radios = document.getElementsByTagName('input');
									for( var i=0; i<radios.length; i++ ){
											if( radios[i].type=='radio' )
											{
													radios[i].onclick = function(){
															esconde_todos( id('palco'), 'div' );
															mostra( this.value );
													}
											}
									}
							} 
						</script>
					
                        <div class="span4" >
                                <label for="presentes"><H5>presentes</H5></label>
                                        <?php
                                            if($nivel < 5 || $conta < 4 || ($conta > 8 && $conta <> 99))
                                            {	?>	
                               <label  class="btn btn-default" submit><input  name="presentes" checked="checked" type="radio" value="out"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Outros lançamentos</label><br/>
                               <label  class="btn btn-default" submit><input  name="presentes" type="radio" value="true"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Presentes Especiais</label><br/><br/>
                                           <?php
                                            }	
                                            ?>
                                          <div id = "palco">
                                          <div id = "true">
                                            <?php
                                              if($nivel < 3){
                                            echo '<label for="pres">Se entrada de Presente Especial</label>';
                                                    echo '<select id="presentes" name="qtd_presentes">';
                                                            echo '<option value="1">Quantidade de presentes</option>';										
                                                            $contar = 1; 
                                                            while(($contar <= 40)) {										
                                                                echo '<option value = '.$contar.'>'.$contar.' Presentes</option>';
                                                                 $contar = $contar+1; }
                                                             echo ' </select>';
                                                } 
                                        ?>
                                         </div>   
                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){ ?>
                                       <!--
                                         <button class="btn btn-danger" ><i class="icon-wrench  icon-white"></i>  EM MANUTENÇÃO, (Tente mais tarde)</button>
                                              -->
                                              <button class="btn btn-success" id="btnContinuar"><i class="icon-plus  icon-white"></i>  Novo Lançamento</button>

                                        <?php } ?>
                                        </div>         


                                <input name ="tab"  type="hidden" value="<?php echo $conta ?>" />
                                <input name ="tipop" type="hidden" value="<?php echo $nivel ?>" />
                                <input name ="tipo_conta_acesso" type="hidden" value="<?php echo $tipo_conta_acesso ?>" />
                                 <input name ="tipoConsulta"  type="hidden" value="0" />
                                <input name ="cadastrado"  type="hidden" value="sim"  />
                                <input name ="termop" type="hidden" value="a" /><span class="style1"></span>		
                            </div>
                    <!--
                        <div class="span3" style="background:#f0efea;">
                            <?php
                                if($nivel < 5 || $conta < 4 || ($conta > 8 && $conta <> 99))
                                {	?>	
                                <label for="presentes"><H5>Multi Lançamentos <br/>(Não disponível no momento)</H5></label>
                                        
                               <label  class="btn btn-default" submit><input  name="multi" checked="checked" type="radio" value="0"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Lançamento Simples</label><br/>
                               <label  class="btn btn-default" submit><input  name="multi" type="radio" value="1"   class="badgebox" style="margin-top:5px;"/> <span class="badge" >&check;</span> Multi Lannçamento</label><br/><br/>
                                          <div id = "palc">                                         
                                            <?php
                                              if($nivel < 3){
                                          //  echo '<label for="pres">Se for multi lançamentos</label>';
                                                    echo '<select id="qtd_Multi" name="qtd_Multi">';
                                                            echo '<option value="1">Quantidade de lançamentos</option>';										
                                                            $contar = 1; 
                                                            while(($contar <= 30)) {										
                                                                echo '<option value = '.$contar.'>'.$contar.' lançamentos</option>';
                                                                 $contar = $contar+1; }
                                                             echo ' </select>';
                                                } 
                                        ?>                                         
                                        </div>  
                                                          
                           <?php
                            }	
                            ?>     
                            </div> -->


                    </form>
                
                    <?php
                }
                     
                    if(!$results){?>
                        <div class="widget-box">
                         <div class="widget-title">
                            <span class="icon">
                                <i class="icon-folder-open"></i>
                             </span>
                            <h5>Lançamentos   </h5>

                         </div>

                    <div class="widget-content nopadding">


                    <table class="table table-bordered ">
                        <thead>
                            <tr style="backgroud-color: #2D335B">
                                 <th>#</th>
                                <th>Data lançamento</th>
                                <th>Histórico</th>
                                <th>Valor (R$)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td colspan="6">Nenhum Lançamento Encontrado</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    </div>
                    <?php } else{?>


                    <div class="widget-box">
                         <div class="widget-title">
                        <!--    <span class="icon">
                                <i class="icon-folder-open"></i>
                             </span>
//****** FORM de Pesquisa para filtro -->
    <form method="get" action="<?php echo base_url(); ?>index.php/vendas/gerenciar">      

        <div class="span2">
            <button class="span12 btn"><i class="icon-search">  Filtrar</i> </button>
        </div>
        <div class="span6">
            <input type="text" name="pesquisa"  id="pesquisa"  placeholder="Fornecedor ou histórico" class="span5" value="" >
            <input type="text" name="cod"  id="cod"  placeholder="Código do lançamento" class="span4" value="" >
                            
                          <select  style="width:150px;" id="status" name="status">
                               <option value = "">Todas contas</option>
                         <?php
                            //  echo 'Conta '. $conta.' Nivel '. $nivel.' Acesso de conta '. $tipo_conta_acesso ;
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
        <div class="span2">
            <input type="text" name="data"  id="data"  placeholder="Data Inicial" class="span6 datepicker" value="">
            <input type="text" name="data2"  id="data2"  placeholder="Data Final" class="span6 datepicker" value="" >
        </div>
    </form>
                             
                             
        <h5>   <span class="badge" style="background-color: #8A9B0F; border-color: #8A9B0F">Com Anexo</span>   <span class="badge" style="background-color: #CDB380; border-color: #CDB380">Sem Anexo</span>
        </h5>

         </div>

         <BR>
            <div class="widget-content nopadding">


            <table class="table table-bordered ">
                <thead>
                    <tr style="backgroud-color: #2D335B">
                        
                        <th>#</th>
                        <th><H5>Data / Conta </H5></th>
                        <th><H5>Códigos</H5></th>
                        <th><H5>Tipo / Forma</H5></th>
                        <th><H5>Doc (Banc/Fiscal)</H5></th>
                        <th><H5>Histórico | Descrição detalhada </H5></th>
                        <th><H5>Valor (R$)</H5></th>
                        <th></th>
                            
                    </tr>
                </thead>
                <tbody>
                    <?php    
                    $contar = 1;
                     foreach ($results as $r) {

                         

                        $aneX = 0;
                        $cor = '#CDB380';
                        foreach ($anexos as $a) {
                           if($a->fin_id == $r->id_fin) { $cor = '#8A9B0F'; $aneX = 1;}
                        }

//************ Verifica Se o lançamento for entrada de presentes especiais e se ja houver saidas
                         // Se não houver saídas a variavel $presente valerá 1

                        $presentes = 0; 
                        foreach ($presentesEsp as $pres) {
                           if($pres->id_entrada == $r->id_fin && ($pres->id_saida !== (0 || null ))) 
                           { $presentes = 1;}

                           if($pres->id_saida == $r->id_fin ) 
                           { $protocoloPres = $pres->n_protocolo;}
                        }

                        if($usuario->conta_Usuario == 99)
                        {

                        $dataVenda = date(('d/m/Y'),strtotime($r->dataFin));
                        if($r->ent_Sai == 1){$ent_Sai = 'Sim'; $sinal = " "; $corV = "#130be0";} else
                                            { $ent_Sai = 'Não'; $sinal = "-"; $corV = "#fa0606";}  
                            {
                             $valorFin = $r->valorFin;
                                if(formatoRealPntVrg($valorFin) == true) 
                               {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                   //serve pra validar  valores acima e abaixo de 1000
                                    $valorFinExibe  =    $valorFin;   
                                   $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                               }else if(formatoRealInt($valorFin) == true)
                               {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                   //serve pra validar  valores acima e abaixo de 1000
                                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                                   $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
                               }else if(formatoRealPnt($valorFin) == true)
                               {
                                   $valorFin  =    $valorFin;
                                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                               }else if(formatoRealVrg($valorFin) == true)
                               {
                                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                                   $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                               }else
                               {
                                   echo "O valor digitado não esta nos parametros solicitados";
                               }
                            }


                        echo '<tr>';

                        echo '<td><span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->id_fin.'</span></td>';   

                      //  echo '<td>'.$r->id_fin.'</td>';<font color=red>Razão Social</font>
                            $caix = $r->conta;
                        switch ($caix) 
                                {						    
                                    case 1:	$corC = "#fa0606";	break;    
                                    case 2:	$corC = "#ac092e";	break;  
                                    case 3:	$corC = "#6608b7";	break;  
                                    case 4:	$corC = "#0d909b";	break;  
                                    case 5:	$corC = "#570cbe";	break;  
                                    case 6:	$corC = "#3c61e8";	break;  
                                    case 7:	$corC = "#0db0eb";	break;  
                                    case 8:	$corC = "#1f909a";	break;  
                                    case 9:	$corC = "#fd7908";	break;  
                                    case 10:$corC = "#935103";	break; 				
                                }                  
                            $tipoC = $r->tipo_Conta;
                        switch ($tipoC) 
                                {						    
						          case "Corrente":	   $cor = "#354789";	break; 
						          case "Suporte":	    $cor = "red";	break; 
						          case "Investimento":	$cor = "#3f950a";	break; 
						          case "Poupança":	   $cor = "#8A9B0F";	break; 
                                }
                            if ($r->cod_compassion == "III-III") $cod_compassi = '--- '; else  $cod_compassi = $r->cod_compassion; 
                        echo '<td>'.$dataVenda.'<br><font color='.$corC.'>'.$r->nome_caixa.'</font> </td>
                        <td><font color="#570cbe">'.$cod_compassi.'</font><br><font color="#10840b">'.$r->cod_assoc.'</font> </td>
                        <td ><font color='.$cor.'>'.$tipoC.'</font><br><font color='.$cor.'>'.$r->tipo_Pag.'</font></td>
                        <td><font color="#570cbe">'.$r->num_Doc_Banco.'</font><br><font color="#10840b">'.$r->num_Doc_Fiscal.'</font> </td>';
                                $limite = 100;
                            if (strlen($r->historico) > $limite) $hist = substr($r->historico,0,$limite).'(...) '; else  $hist = $r->historico.' ';
                            if (strlen($r->descricao) > $limite) $desc = substr($r->descricao,0,$limite).'(...)'; else  $desc = $r->descricao;
                             
                       // echo '<td><a href="'.base_url().'index.php/clientes/visualizar/'.$r->idClientes.'">'.$r->nomeCliente.'</a></td>';tipo_Pag
                       //echo '<td>'.$r->cod_assoc.' | '.$hist.' | '.strlen($r->descricao).'</a></td>';
                        echo '<td>'.$hist.' | '.$desc.'</a></td>';
                        echo '<td style="text-align:right;"><font color='.$corV.'>'.$sinal.'  '.$valorFin.'</font></td>';

                        echo '<td>';
                         ?>
                       <form action="<?php echo current_url(); ?>" method="post" >
                                  <?php
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$r->id_fin.'" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/imprimir/'.$r->id_fin.'" target="_blank" class="btn btn-inverse tip-top" title="Imprimir"><i class="icon-print"></i></a>'; 
                        }
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/editar/'.$r->id_fin.'" class="btn btn-info tip-top" title="Editar lançamento"><i class="icon-pencil icon-white"></i></a>'; 
                        }
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'dVenda') ){
                           ?>
                            <input type="hidden" id="ent_Sai" name="ent_Sai" value=" <?php echo $r->ent_Sai ?>" />
                            <input type="hidden" id="idLanc" name="idLanc" value="<?php echo $r->id_fin; ?>" />
                                <?php  
                            if(isset($protocoloPres))
                            {
                                  ?>
                            <input type="hidden" id="protocoloPres" name="protocoloPres" value="<?php echo $protocoloPres; ?>" />
                             <?php
                            }
                           if($presentes !== 1)
                                    {
                                    if($aneX == 0){?>
                                         <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />

                                         <button class="btn btn-danger"><i class="icon-remove icon-white" title="Excluir lançamento"></i></button>

                                  <?php
                                     //   echo '<a href="#modal-excluir" role="button" data-toggle="modal" venda="'.$r->id_fin.'" class="btn btn-danger tip-top" title="Excluir lançamento"><i class="icon-remove icon-white"></i></a>'; 
                                    }else {
                                           ?>

                                         <input type="hidden" id="oP_Exc" name="oP_Exc" value="anexo" />
                                        <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes o anexo!"></i></button>
                                  <?php 
                                        //echo '<a href="#modal-exc" role="button" data-toggle="modal"  class="btn btn-danger tip-top" title="Exclua antes o anexo!"><i class="icon-lock icon-white"></i></a>';  
                                    }}else 
                                    {
                                           ?>

                                         <input type="hidden" id="oP_Exc" name="oP_Exc" value="presentes" />
                                        <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes os lançamentos de saida destes presentes!"></i></button>
                                  <?php
                                        //echo '<a href="#modal-exc" role="button" data-toggle="modal"  class="btn btn-danger tip-top" title="Exclua antes os lançamentos de saida destes presentes!"><i class="icon-lock icon-white"></i></a>'; 
                                }
                                    ?>
                            </form>
                                <?php
                                    }

                        echo '</td>';
                        echo '</tr>';
                        }else
                        if($r->id_caixa == $usuario->conta_Usuario)
                        {

                        $dataVenda = date(('d/m/Y'),strtotime($r->dataFin));
                     //   if($r->ent_Sai == 1){$ent_Sai = 'Sim';} else{ $ent_Sai = 'Não';}
                            
                            
                        if($r->ent_Sai == 1){$ent_Sai = 'Sim'; $sinal = " "; $corV = "#130be0";} else
                                            { $ent_Sai = 'Não'; $sinal = "-"; $corV = "#fa0606";} 

                             $valorFin = $r->valorFin;
                                if(formatoRealPntVrg($valorFin) == true) 
                               {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                   //serve pra validar  valores acima e abaixo de 1000
                                    $valorFinExibe  =    $valorFin;   
                                   $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                               }else if(formatoRealInt($valorFin) == true)
                               {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                   //serve pra validar  valores acima e abaixo de 1000
                                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                                   $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
                               }else if(formatoRealPnt($valorFin) == true)
                               {
                                   $valorFin  =    $valorFin;
                                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                               }else if(formatoRealVrg($valorFin) == true)
                               {
                                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                                   $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                               }else
                               {
                                   echo "O valor digitado não esta nos parametros solicitados";
                               }


                        echo '<tr>';
                        echo '<td><span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->id_fin.'</span></td>';
                           $caix = $r->conta;
                        switch ($caix) 
                                {						    
                                    case 1:	$corC = "#fa0606";	break;    
                                    case 2:	$corC = "#ac092e";	break;  
                                    case 3:	$corC = "#6608b7";	break;  
                                    case 4:	$corC = "#0d909b";	break;  
                                    case 5:	$corC = "#570cbe";	break;  
                                    case 6:	$corC = "#3c61e8";	break;  
                                    case 7:	$corC = "#0db0eb";	break;  
                                    case 8:	$corC = "#1f909a";	break;  
                                    case 9:	$corC = "#fd7908";	break;  
                                    case 10:$corC = "#935103";	break; 				
                                }                  
                            $tipoC = $r->tipo_Conta;
                        switch ($tipoC) 
                                {						    
						          case "Corrente":	   $cor = "#354789";	break; 
						          case "Suporte":	    $cor = "red";	break; 
						          case "Investimento":	$cor = "#3f950a";	break; 
						          case "Poupança":	   $cor = "#8A9B0F";	break; 
                                }
                            if ($r->cod_compassion == "III-III") $cod_compassi = '--- '; else  $cod_compassi = $r->cod_compassion; 
                        echo '<td>'.$dataVenda.'<br><font color='.$corC.'>'.$r->nome_caixa.'</font> </td>
                        <td><font color="#570cbe">'.$cod_compassi.'</font><br><font color="#10840b">'.$r->cod_assoc.'</font> </td>
                        <td ><font color='.$cor.'>'.$tipoC.'</font><br><font color='.$cor.'>'.$r->tipo_Pag.'</font></td>
                        <td><font color="#570cbe">'.$r->num_Doc_Banco.'</font><br><font color="#10840b">'.$r->num_Doc_Fiscal.'</font> </td>';
                                $limite = 100;
                            if (strlen($r->historico) > $limite) $hist = substr($r->historico,0,$limite).'(...) '; else  $hist = $r->historico.' ';
                            if (strlen($r->descricao) > $limite) $desc = substr($r->descricao,0,$limite).'(...)'; else  $desc = $r->descricao;
                             
                       // echo '<td><a href="'.base_url().'index.php/clientes/visualizar/'.$r->idClientes.'">'.$r->nomeCliente.'</a></td>';tipo_Pag
                       //echo '<td>'.$r->cod_assoc.' | '.$hist.' | '.strlen($r->descricao).'</a></td>';
                        echo '<td>'.$hist.' | '.$desc.'</a></td>';
                        echo '<td style="text-align:right;"><font color='.$corV.'>'.$sinal.'  '.$valorFin.'</font></td>';

                        echo '<td>';
                         ?>
                              <form action="<?php echo current_url(); ?>" method="post" >
                                  <?php

                        if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$r->id_fin.'" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                           // echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/imprimir/'.$r->id_fin.'" target="_blank" class="btn btn-inverse tip-top" title="Imprimir"><i class="icon-print"></i></a>'; 
                        }
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/editar/'.$r->id_fin.'" class="btn btn-info tip-top" title="Editar lançamento"><i class="icon-pencil icon-white"></i></a>'; 
                        }
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'dVenda') ){
                             ?>
                            <input type="hidden" id="ent_Sai" name="ent_Sai" value=" <?php echo $r->ent_Sai ?>" />
                            <input type="hidden" id="idLanc" name="idLanc" value="<?php echo $r->id_fin; ?>" />
                             <?php
                           if($presentes !== 1)
                                    {
                                    if($aneX == 0){?>
                                         <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />                                 
                                         <button class="btn btn-danger"><i class="icon-remove icon-white" title="Excluir lançamento"></i></button>                                         
                                  <?php
                                    }else {
                                           ?>                                                
                                         <input type="hidden" id="oP_Exc" name="oP_Exc" value="anexo" />
                                        <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes o anexo!"></i></button>
                                  <?php 
                                    }}else 
                                    {
                                           ?>                                                
                                         <input type="hidden" id="oP_Exc" name="oP_Exc" value="presentes" />
                                        <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes os lançamentos de saida destes presentes!"></i></button>
                                  <?php
                                }
                                    ?>
                            </form>
                                <?php
                                    }

                        echo '</td>';
                        echo '</tr>';
                        }

                          $contar = $contar+1;
                        } ?>
                    <tr>

                    </tr>
                </tbody>
            </table>
            </div>
            </div>

                    <?php echo $this->pagination->create_links();}?>

        </div>
        </div>

    </div>
</div>
</div>

    <!-- Modal EXCLUIR-->
    <div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <form action="<?php echo base_url() ?>index.php/vendas/excluir" method="post" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Excluir Lançamento</h5>
      </div>                           
      <div class="modal-body">
  <?php         

        if(isset($result_chekk))
        {?>
             <input type="hidden" id="id_reconc" name="id_reconc" value="<?php echo $result_chekk->id_reconc  ?>" />
             <input type="hidden" id="ent_Sai" name="ent_Sai" value=" <?php echo $result_A->ent_Sai ?>" />

         <?php                

        }
            if( isset($presentesE))
               { 
                $contPre = 0;
             foreach ($presentesE as $pres) 
             {

                $contPre = $contPre + 1;
            //   if($pres->id_saida == $r->id_fin  )
               { ?>  
                   <input type="hidden" id="id_presente"    name="id_presente<?php echo $contPre ?>" value="<?php echo  $pres->id_presente  ?>" />
                    <input type="hidden" id="id_entrada"  name="id_entrada<?php echo $contPre ?>" value="<?php echo  $pres->id_entrada  ?>" />
                   <input type="hidden" id="id_saida"       name="id_saida<?php echo $contPre ?>" value="<?php echo  $pres->id_saida  ?>" />
                   <input type="hidden" id="data_presente"  name="data_presente<?php echo $contPre ?>" value="<?php echo  $pres->data_presente  ?>" />
                   <input type="hidden" id="valor_saida"    name="valor_saida<?php echo $contPre ?>" value="<?php echo  $pres->valor_saida  ?>" />
                   <input type="hidden" id="valor_entrada"  name="valor_entrada<?php echo $contPre ?>" value="<?php echo  $pres->valor_entrada  ?>" />
                   <input type="hidden" id="valor_pendente" name="valor_pendente<?php echo $contPre ?>" value="<?php echo  $pres->valor_pendente  ?>" />
             <?php

         }//else
     //      if( $pres->id_entrada == $r->id_fin )
             }
           {             

         }
        } ?>
        <input type="hidden" id="contPre" name="contPre" value="<?php if(isset($contPre)) echo $contPre; ?>" />
        <input type="hidden" id="idVenda" name="id" value="" />
        <h5 style="text-align: center">Deseja realmente excluir este Lançamento?</h5>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-danger">Excluir</button>
      </div>
      </form>
    </div>



    <!-- Modal -->
    <div id="modal-exc" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Excluir Lançamento</h5>
      </div>                           
      <div class="modal-body">


        <h5 style="text-align: center">Esta lançamento não pode ser excluído! Verifique a exigência.</h5>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"> Sair </button>

      </div>

    </div>






<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var venda = $(this).attr('venda');
        $('#idVenda').val(venda);

    });

    $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
});

</script>