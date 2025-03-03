	
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
        
        <?php           

        ?>
        
        
        
        <div class="widget-box">
            <div class="widget-title">                
                <h5>Lançamentos  -   <?php
                              echo 'Usuário: '.$usuario->nome.' | Conta do usuário: '. $contaNome.' | Nivel: '. $nivel.' '.$usuario->permissao.'  | Acesso de tipo de conta: '. $tipo_conta_acesso ;
                    ?></h5>
            </div>
            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                <div class="span12" id="divGerir" style=" margin-left: 0">
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
                                                    $descri_Comp = $rcodComp->descricaoCod;
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

                                                <span>Conta beneficiaria:</span><br/>
                                                <label for="numeroDocFiscal"><h5><?php echo $result_A->conta_Destino; ?></h5></label>

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
                                                }  ?>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 

                    </div>
                    <div class="invoice-head">
                            <?php
                            }
                        }else
                        {?>
                        <form action="<?php echo base_url(); ?>index.php/vendas/adicionar" method="post" name="form" class="form">	
                          <input  name="conta" type="hidden" value="4"/>
                         <div class="span6" >
                         <div>
                                <label for="tipCont"><H5>Movimentação</H5></label>
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
                                unset($_SESSION['centro']);      
                                unset($_SESSION['status']);                        	 
                             ?>
                         </div><br>
                                <input  name="tipCont" type="hidden" value="Suporte"/>
                                <div>
                                       <input name="presentes"  type="hidden" value="out"/>
                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){ ?>
                                       <button class="btn btn-success" id="btnContinuar"><i class="icon-plus  icon-white"></i>  Novo Lançamento</button>
                                       <?php } ?>
                                </div><br>
                                </div>
                                    <input name ="tab"  type="hidden" value="<?php echo $conta ?>" />
                                    <input name ="tipop" type="hidden" value="<?php echo $nivel ?>" />
                                    <input name ="tipo_conta_acesso" type="hidden" value="<?php echo $tipo_conta_acesso ?>" />
                                     <input name ="tipoConsulta"  type="hidden" value="0" />
                                    <input name ="cadastrado"  type="hidden" value="sim"  />
                                    <input name ="termop" type="hidden" value="a" /><span class="style1"></span>                        
                            </form>                
                            <?php
                            }
                        if(!$centro) $centro = ''; 
                  //  if(isset($centro))
                  //  var_dump($PGN ); 
                       if(isset($centro)) $_SESSION['centro'] = $centro; 
                        if(isset($status)) $_SESSION['status'] = $status;
                        ?>
                  </div>
                <div class="widget-box">
                    <!--  FORM de Pesquisa para filtro -->
                    <form method="get" action="<?php echo base_url(); ?>index.php/vendas/gerenciar">      

                        <div class="span2">
                            <button class="span12 btn"><i class="icon-search">  Filtrar</i> </button>
                        </div>
                        <div class="span5">
                            <input class="span3" type="text" name="pesquisa"  id="pesquisa"  placeholder="Fornecedor ou histórico" class="span5" value="<?php if($pesquisa) echo $pesquisa; ?>" >
                            <input class="span2" type="text" name="cod"  id="cod"  placeholder="Código do lançamento" class="span4" value="" >

                            <select  style="width:150px;" id="centro" name="centro">
                                <option value = "" <?php if($centro == '') echo 'selected'; ?> >Todas contas</option>
                                 <?php
                                    //  echo 'Conta '. $conta.' Nivel '. $nivel.' Acesso de conta '. $tipo_conta_acesso ; 
                                  foreach ($result_codIead as $rFundo)
                                  {?>
                                <option value = "<?php echo $rFundo->cod_Ass ?>" <?php if($centro == $rFundo->cod_Ass) echo 'selected' ?> ><?php echo $rFundo->cod_Ass." | ".$rFundo->descricao_Ass ?></option>
                                    <?php
                                    }
                                  ?>														
                            </select>
                            <select  style="width:150px;" id="status" name="status">
                                <option value = "0" <?php if($status == '0') echo 'selected'; ?>>Status</option>
                                <option value = "1" <?php if($status == '1') echo 'selected'; ?>>Abertos</option>
                                <option value = "2" <?php if($status == '2') echo 'selected'; ?>>Fechados</option>
                                    													
                            </select>
                        </div>
                        <div class="span2">
                            <input type="text" name="data"  id="data"  placeholder="Data Inicial" class="span6 datepicker" value="<?php if(isset($_SESSION['data'])) echo $_SESSION['data']; ?>">
                            <input type="text" name="data2"  id="data2"  placeholder="Data Final" class="span6 datepicker" value="<?php if(isset($_SESSION['data2'])) echo $_SESSION['data2']; ?>" >
                        </div>
                    </form>


                        </div>
                </div>
                <ul class="nav nav-tabs">
                    <li id="tabDetalhes"><a href="#tab1" data-toggle="tab">Lançamentos do mês</a></li>
                    <li class="active" id="tabAnexos"><a href="#tab2" data-toggle="tab">TODOS Lançamento</a></li>
                    <li id="tabAnexos"><a href="#tab3" data-toggle="tab">Saldos</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab1">

                    <div class="invoice-content">
                                 <?php               
                                if(!$resultsMes){?>
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
                                   
                   
                    <h5>   <span class="badge" style="background-color: #8A9B0F; border-color: #8A9B0F">Com Anexo</span>   <span class="badge" style="background-color: #CDB380; border-color: #CDB380">Sem Anexo</span>
                    </h5>

                     </div>

                     <BR>
                        <div class="widget-content nopadding">


                        <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">

                                    <th>#</th>
                                    <th><H5>Evento / Fatura </H5></th>
                                    <th><H5>Códigos</H5></th>
                                    <th><H5>Forma</H5></th>
                                    <th><H5>Parcela</H5></th>
                                    <th><H5>Histórico | Descrição detalhada </H5></th>
                                    <th><H5>Valor (R$)</H5></th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php    
                                $contar = 1;
                                 foreach ($resultsMes as $r){
                                     {
                                    $aneX = 0;
                                    $cor = '#CDB380';
                                    foreach ($anexos as $a) {
                                       if($a->fin_id == $r->id_fin) { $cor = '#8A9B0F'; $aneX = 1;}
                                    }

                    //************ Verifica Se o lançamento for entrada de presentes especiais e se ja houver saidas
                                     // Se não houver saídas a variavel $presente valerá 1

                                    $presentes = 0; 
                                    if($usuario->conta_Usuario == 99)
                                    {

                                    $dataEvento = date(('d/m/Y'),strtotime($r->dataEvento));
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
                                        $status = $r->num_Doc_Fiscal;
                                    switch ($status) 
                                            {			    
                                              case "Efetuado":	   $cor = "#354789";	break; 
                                              case "Suporte":	    $cor = "red";	break; 
                                              case "Previsto":	$cor = "#3f950a";	break; 
                                              case "Poupança":	   $cor = "#8A9B0F";	break; 
                                            }
                                        $cod_compassi = $r->cod_compassion; 
                                    echo '<tr>';

                                    echo '<td><span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->id_fin.'<br>'.$status.'</span></td>';
                                    echo '<td>'.$dataEvento.'<br>'.$dataVenda.' </td>
                                    <td><font color="#570cbe">'.$cod_compassi.' ('.$r->descricao.')</font><br><font color="#10840b">'.$r->cod_assoc.' ('.$r->descricao_Ass.')</font> </td>
                                    <td ><font color='.$cor.'>'.$r->tipo_Pag.'</font></td>
                                    <td><font color="#570cbe">'.$r->num_Doc_Banco.'</font><br><font color="#10840b"></font> </td>';
                                            $limite = 100;
                                        if (strlen($r->historico) > $limite) $hist = substr($r->historico,0,$limite).'(...) '; else  $hist = $r->historico.' ';
                                        if (strlen($r->descricao) > $limite) $desc = substr($r->descricao,0,$limite).'(...)'; else
                                            $desc = $r->descricao;

                                    echo '<td>'.$hist.' | '.$desc.'</a></td>';
                                    echo '<td style="text-align:right;"><font color='.$corV.'>'.$sinal.'  '.$valorFin.'</font></td>';

                                    echo '<td>';
                                     ?>
                                   <form action="<?php echo current_url(); ?>" method="post" >
                                              <?php
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$r->id_fin.'" target="_blank"  class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/imprimir/'.$r->id_fin.'" target="_blank" class="btn btn-inverse tip-top" title="Imprimir"><i class="icon-print"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/editar/'.$r->id_fin.'" target="_blank" class="btn btn-info tip-top" title="Editar lançamento"><i class="icon-pencil icon-white"></i></a>'; 
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
                                                if($aneX == 0){?>
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />
                                                     <button class="btn btn-danger"><i  target="_blank" class="icon-remove icon-white" title="Excluir lançamento"></i></button>
                                              <?php
                                                }else {
                                                       ?>
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="anexo" />
                                                    <button target="_blank" class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes o anexo!"></i></button>
                                              <?php 
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
                                            $limite = 50;
                                        if (strlen($r->historico) > $limite) $hist = substr($r->historico,0,$limite).'(...) '; else  $hist = $r->historico.' ';
                                       // if (strlen($r->descricao) > $limite) $desc = substr($r->descricao,0,$limite).'(...)'; else
                                        $desc = $r->descricao;

                                   // echo '<td><a href="'.base_url().'index.php/clientes/visualizar/'.$r->idClientes.'">'.$r->nomeCliente.'</a></td>';tipo_Pag
                                   //echo '<td>'.$r->cod_assoc.' | '.$hist.' | '.strlen($r->descricao).'</a></td>';
                                    echo '<td>'.$hist.' | '.$desc.'</a></td>';
                                    echo '<td style="text-align:right;"><font color='.$corV.'>'.$sinal.'  '.$valorFin.'</font></td>';

                                    echo '<td>';
                                     ?>
                                          <form action="<?php echo current_url(); ?>" method="post" >
                                              <?php

                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$r->id_fin.'" target="_blank" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                                       // echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/imprimir/'.$r->id_fin.'" target="_blank" class="btn btn-inverse tip-top" title="Imprimir"><i class="icon-print"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/editar/'.$r->id_fin.'" target="_blank" class="btn btn-info tip-top" title="Editar lançamento"><i class="icon-pencil icon-white"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'dVenda') ){
                                         ?>
                                        <input type="hidden" id="ent_Sai" name="ent_Sai" value=" <?php echo $r->ent_Sai ?>" />
                                        <input type="hidden" id="idLanc" name="idLanc" value="<?php echo $r->id_fin; ?>" />
                                         <?php
                                                if($aneX == 0){?>
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />                                 
                                                     <button class="btn btn-danger"><i class="icon-remove icon-white" title="Excluir lançamento"></i></button>                                         
                                              <?php
                                                }else {
                                                       ?>                                                
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="anexo" />
                                                    <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes o anexo!"></i></button>
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
                                    } }?>
                                <tr>

                                </tr>
                            </tbody>
                        </table>
                        </div>
                        </div>

                                <?php echo $this->pagination->create_links();}?>

                    </div>
                    </div>
                    <div class="tab-pane active" id="tab2">
<?php //var_dump($resultsAux1); ?>
                    <div class="invoice-content">
                                 <?php               
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
                                    <th><H5>Forma</H5></th>
                                    <th><H5>Parcela</H5></th>
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

//                                    $presentes = 0; 
//                                    foreach ($presentesEsp as $pres) {
//                                       if($pres->id_entrada == $r->id_fin && ($pres->id_saida !== (0 || null ))) 
//                                       { $presentes = 1;}
//
//                                       if($pres->id_saida == $r->id_fin ) 
//                                       { $protocoloPres = $pres->n_protocolo;}
//                                    }

                                    if($usuario->conta_Usuario == 99)
                                    {

                                    $dataEvento = date(('d/m/Y'),strtotime($r->dataEvento));
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
                                        $status = $r->num_Doc_Fiscal;
                                    switch ($status) 
                                            {			    
                                              case "Efetuado":	   $cor = "#354789";	break; 
                                              case "Suporte":	    $cor = "red";	break; 
                                              case "Previsto":	$cor = "#3f950a";	break; 
                                              case "Poupança":	   $cor = "#8A9B0F";	break; 
                                            }
                                        $cod_compassi = $r->cod_compassion; 
                                    echo '<tr>';

                                    echo '<td><span class="badge" style="background-color: '.$cor.'; border-color: '.$cor.'">'.$r->id_fin.'<br>'.$status.'</span></td>';
                                    echo '<td>'.$dataEvento.'<br>'.$dataVenda.' </td>
                                    <td><font color="#570cbe">'.$cod_compassi.' ('.$r->descricao.')</font><br><font color="#10840b">'.$r->cod_assoc.' ('.$r->descricao_Ass.')</font> </td>
                                    <td ><font color='.$cor.'>'.$r->tipo_Pag.'</font></td>
                                    <td><font color="#570cbe">'.$r->num_Doc_Banco.'</font><br><font color="#10840b"></font> </td>';
                                            $limite = 100;
                                      //  if (strlen($r->historico) > $limite) $hist = substr($r->historico,0,$limite).'(...) '; else
                                        $hist = $r->historico.' ';
                                      //  if (strlen($r->descricao) > $limite) $desc = substr($r->descricao,0,$limite).'(...)';else 
                                        $desc = $r->descricao;

                                    echo '<td>'.$hist.' </td>';
                                    echo '<td style="text-align:right;"><font color='.$corV.'>'.$sinal.'  '.$valorFin.'</font></td>';

                                    echo '<td>';
                                     ?>
                                   <form action="<?php echo current_url(); ?>" method="post" >
                                              <?php
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$r->id_fin.'" target="_blank" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/imprimir/'.$r->id_fin.'" target="_blank" class="btn btn-inverse tip-top" title="Imprimir"><i class="icon-print"></i></a>'; 
                                    }
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                                        echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/editar/'.$r->id_fin.'" target="_blank" class="btn btn-info tip-top" title="Editar lançamento"><i class="icon-pencil icon-white"></i></a>'; 
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
                                                if($aneX == 0){?>
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />
                                                     <button class="btn btn-danger"><i class="icon-remove icon-white" title="Excluir ESTE lançamento!"></i></button>
                                              <?php
                                                }else {
                                                       ?>
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="anexo" />
                                                    <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes o anexo!"></i></button>
                                              <?php 
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
                                        {
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
//                                       if($presentes !== 1)
//                                                {
                                                if($aneX == 0){?>
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" />                                 
                                                     <button class="btn btn-danger"><i class="icon-remove icon-white" title="Excluir lançamento"></i></button>                                         
                                              <?php
                                                }else {
                                                       ?>                                                
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="anexo" />
                                                    <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes o anexo!"></i></button>
                                              <?php 
                                                }
//                                            }  else 
//                                                {
                                                       ?>                                                
<!--
                                                     <input type="hidden" id="oP_Exc" name="oP_Exc" value="presentes" />
                                                    <button class="btn btn-danger"><i class="icon-lock icon-white" title="Exclua antes os lançamentos de saida destes presentes!"></i></button>
-->
                                              <?php
//                                            }
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
                                    
                                    
                                   <form action="<?php echo current_url(); ?>" method="post" >
                                      <td>  </td>
                                      <td><LABEL>EXCLUIR ESPECIFICO</LABEL>  </td>
                                      <td>
                                          <select id="conta" name="conta">                                              
                                        <option value = "0">SAÍDA</option>                                           
                                        <option value = "0">ENTRADA</option>
                                        													
                                        </select>
                                       </td>
                                      <td>       <LABEL>ID lançamento</LABEL>
                                        <input type="text" id="idLanc" name="idLanc" value="" /></td> 
                                      <td>    
                                        <input type="hidden" id="protocoloPres" name="protocoloPres" value="" /></td>   
                                      <td>     
                                        <input type="hidden" id="oP_Exc" name="oP_Exc" value="exclui" /></td>   
                                      <td>     
                                       <button class="btn btn-danger"><i class="icon-remove icon-white" title="Excluir ESTE lançamento!"></i></button></td> 
                                        </form>

                                </tr>
                            </tbody>
                        </table>
                        </div>
                        </div>

                                <?php echo $this->pagination->create_links();}?>

                    </div>
                    </div>
                    <div class="tab-pane" id="tab3">

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