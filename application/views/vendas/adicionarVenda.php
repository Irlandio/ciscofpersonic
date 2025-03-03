
<style>
.badgebox
{opacity: 0;}
.badgebox + .badge
{text-indent: -999999px;width: 27px;}
.badgebox:focus + .badge
{box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge
{text-indent: 0;}
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="atext/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<div class="row-fluid" style="margin-top:0">
    
        <div id="blCabeca" title="sitename">  
            <?php
                //include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
                //protegePagina(); // Chama a função que protege a página

            $conta = $usuario->conta_Usuario;
            $nivel = $usuario->permissoes_id;	
            $contaA = $usuario->celular;

            //$contaA = $_SESSION['conta_acesso'];
            //$nivel = $_SESSION['nivel_acesso'];			
            if (session_status() !== PHP_SESSION_ACTIVE) {//Verificar se a sessão não já está aberta.
            session_start();
            }
            foreach ($result_caixas as $rcx) {                   
            if($usuario->conta_Usuario == 99)
            { $contaNome = "Todas contas";
            }else
            { $contaNome = $rcx->nome_caixa;
            }
            }
            ?>
    </div>
</div>
        <?php
//var_dump($_SESSION['lancamento']);
        $lancamento = array();
        if( isset($_SESSION['lancamento']))
        {
            $lancamento     = $_SESSION['lancamento'];
            $conta          = $lancamento['conta'];        
            $tipCont        = $lancamento['tipo_Conta'];
            $fundoF         = $lancamento['fundoF'];
            $cCustos        = $lancamento['cCustos'] ;
            $num_Doc        = $lancamento['num_Doc_Banco'];
            $numDocFiscal   = $lancamento['num_Doc_Fiscal'];
            $razaoSoc       = $lancamento['historico'];
            $dataFin       = $lancamento['dataFin'];
            $descri         = $lancamento['descricao'];	
            $valorFin       = $lancamento['valorFin'];
            $tipo_Pag       = $lancamento['tipo_Pag'];
            $tipoES         = $lancamento['ent_Sai'] ; 
            $cadastrante    = $lancamento['cadastrante'];
        }else if( isset($_POST["tab"]))
        {//Se a pagina foi chamada pela página cadatrarLançamento ou seja tentar denovo 
            $contaA =  $_POST["tab"];
            $nivel =  $_POST["tipop"];
            $conta = $_POST["conta"];
            $tipCont = $_POST["tipCont"];
            $tipoES = $_POST["tipoES"];
            $multiLance = '0';
        }else 
        {//Se a pagina foi chamada pela página cadatrarLançamento ou seja tentar denovo 
            $contaA =  4;
            $nivel =  1;
            $conta = 4;
            $tipCont = "Suporte";
            $tipoES = 0;
            $multiLance = '0';
        }
        unset($_SESSION['lancamento']);
//            if($tipoES == 0) $tipoEnt_Sai = "Despesa";
//            else if($tipoES == 1) $tipoEnt_Sai = "Receita";        
        $tipoEnt_Sai = $tipoES == 0 ? "Despesa Saída" : "Receita";

            foreach ($result_caixas as $rcx) 
                {                   
                  if($conta == $rcx->id_caixa)
                       $contaNome = $rcx->nome_caixa;
               }
        $ano = date("Y");			
        $mes = date("m");
        $ano0 = $ano;
        $ano2 = $ano;
        switch ($mes) 
            {
                case "01":	$mes0 = "12"; $mes = "01"; $mes2 = "02"; $ano0 = $ano - 1 ; break;  	
                case "02":	$mes0 = "01"; $mes = "02"; $mes2 = "03"; break;  
                case "03":	$mes0 = "02"; $mes = "03"; $mes2 = "04"; break;  	
                case "04":	$mes0 = "03"; $mes = "04"; $mes2 = "05"; break;  
                case "05":	$mes0 = "04"; $mes = "05"; $mes2 = "06"; break;  	
                case "06":	$mes0 = "05"; $mes = "06"; $mes2 = "07"; break;  
                case "07":	$mes0 = "06"; $mes = "07"; $mes2 = "08"; break;  	
                case "08":	$mes0 = "07"; $mes = "08"; $mes2 = "09"; break;  
                case "09":	$mes0 = "08"; $mes = "09"; $mes2 = "10"; break;  	
                case "10":	$mes0 = "09"; $mes = "10"; $mes2 = "11"; break;
                case "11":	$mes0 = "10"; $mes = "11"; $mes2 = "12"; break;	
                case "12":	$mes0 = "11"; $mes = "12"; $mes2 = "01"; $ano2 = $ano + 1 ; break;  				
            }
        $data1= date($ano.'-'.$mes.'-01');//Cria a variavel data inicial com o mês e o ano atual sendo dia 01
        $data2= date($ano2.'-'.$mes2.'-01');//Cria a variavel data final com o mês seguinte sendo dia 01
        $data_mes_Anterior= date($ano0.'-'.$mes0.'-01');//Cria a variavel data do dia 01 de 1 mes atráz
					
if (!$resultUltimo || $resultUltimo == null )
{
    $id_fin         = 0; 
    $saldo_Atual    = 0.00; 	
    $dataUlt_saldo  = 0.00;
    $dataUlt_saldoExib= implode('/',array_reverse(explode('-',$dataUlt_saldo)));
    $saldo_AtualExib = number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.');
}else{
           foreach ($resultUltimo as $rU) 
                {
                        $id_fin = $resultUltimo->id_fin; 
						$saldo_Atual = $resultUltimo->saldo; 	
						$dataUlt_saldo = $resultUltimo->dataFin;
						$dataUlt_saldoExib= implode('/',array_reverse(explode('-',$dataUlt_saldo)));
						$saldo_AtualExib = number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.');                    
                }

}           //echo '  - mês atual '.$mes.' data prox mês '.$data2.' data mês anterior'.$data_mes_Anterior;
						//echo '</br>  Saldo em '.$dataUlt_saldo.' R$ '. $saldo_Atual.'</br>';
					echo  "<strong>CISCOF - Lançamento para conta - ".$contaNome." | ". $usuario->idUsuarios." ".$usuario->nome." - Nivel de acesso ".$nivel." </strong> ";
//var_dump($lancamento);
					?>	
<div class="span12">
<div class="widget-box">
    <div class="widget-title">
       <h5> <span class="icon">
            <i class="icon-folder-open"></i>
        </span>Lançamento
        <?php echo " da conta -  ".$conta.' - '.$contaNome ." | C.". $tipCont." Saldo atual R$ "; if(isset($saldo_AtualExib)) echo $saldo_AtualExib;
       if(isset($dataUlt_saldoExib)) echo " | em ".$dataUlt_saldoExib; ?></h5> <H4 ><?php echo $tipoEnt_Sai; ?></H4> 
    </div>            
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-folder-open"></i>
            </span>
            <ul class="nav nav-tabs">
                <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes do lançamento</a></li>
            </ul>
        </div>
        <div class="widget-content nopadding">
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <div class="span12" id="divCadastrarOs">
                            
                        <?php if ($custom_error != '') {
                            echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                        } ?>
                        <form action="<?php echo current_url(); ?>" method="post" id="formVendas">
                            <input name ="cadastrante"  type="hidden" value="<?php echo $usuario->idUsuarios ?>" />
                            <input name ="tab"  type="hidden" value="<?php echo $contaA ?>" />
                            <input name ="tipop"  type="hidden" value="<?php echo $nivel ?>" />
                            <input name ="conta"  type="hidden" value="<?php echo $conta ?>" />
                            <input name ="tipCont"  type="hidden" value="<?php echo $tipCont ?>" />
                            <input name =" tipoES"  type="hidden" value="<?php echo  $tipoES ?>" />
                            <input name ="presentes"  type="hidden" value="" />                            

                            <input name ="tab"  type="hidden" value="aenpFin" />
                            <input name ="caixa"  type="hidden" value="<?php echo $conta ?>" />
                            <input name ="tipoCont"  type="hidden" value="<?php echo $tipCont ?>" />
                            <input name ="tipContNome"  type="hidden" value="<?php echo $tipCont ?>" />
                            <input name ="saldo_Atual"  type="hidden" value="<?php echo $saldo_Atual ?>" />
                            <input name ="id_fin"  type="hidden" value="<?php echo $id_fin ?>" />
                            <input name ="diaUm_mêsAtual"  type="hidden" value="<?php echo $data1 ?>" />
                            <input name ="dataUlt_saldo"  type="hidden" value="<?php echo $dataUlt_saldo ?>" />
                            <input name ="op"  type="hidden" value="opCad" />
                            <input name ="tipoConsulta"  type="hidden" value=3 />
                          
                          
                       <div class="span12">                 
                           <div class="span3">
                                <div class="control-group">
                                    <label for="cCustos" class="control-label">Centro de Custo<span class="required">*</span></label>
                                    <div class="controls">
                                      <select id="cCustos" name="cCustos" >                                              
                                        <option value = "" >Centro de Custo</option>
                                        <?php 
                                          if( $tipoES == 0 )
                                          {      
                                             foreach ($result_codComp as $rcodComp)
                                             {
                                                  if( $rcodComp->ent_SaiComp == 0 && substr($rcodComp->cod_Comp,-2,2) !== '00')
                                                  { ?>                                           
                                                    <option value = "<?php echo $rcodComp->cod_Comp ?>" <?php if( !empty($lancamento))if($rcodComp->cod_Comp == $cCustos){ echo 'selected';} ?>>
                                                    <?php echo ' '.$rcodComp->cod_Comp." |
                                                    ".$rcodComp->descricaoCod." | ".$rcodComp->area_Cod.' '?></option>
                                               <?php } else { } 
                                             }
                                           } else 
                                          if( $tipoES == 1 ) 
                                          {     
                                             foreach ($result_codComp as $rcodComp)
                                             {
                                                  if( $rcodComp->ent_SaiComp == 1)
                                                  {
                                                  ?>                                        
                                                    <option value = "<?php echo $rcodComp->cod_Comp ?>" <?php if( !empty($lancamento))if($rcodComp->cod_Comp == $cCustos){ echo 'selected';} ?>>
                                                    <?php echo ' '.$rcodComp->cod_Comp." |
                                                    ".$rcodComp->descricaoCod." | ".$rcodComp->area_Cod.' '?></option>
                                                   <?php } else { }
                                               }
                                         } ?>
                                      </select>
                                    </div>
                                </div>
                                    
                                <div class="control-group">
                                    <label for="fundoF" class="control-label">Fundo Financeiro<span class="required">*</span></label>
                                    <div class="controls">
                                     <select id="fundoF" name="fundoF">
                                        <option value = "" >Fundo Financeiro</option>
                                     <?php                                        
                                        { 
                                        foreach ($result_codIead as $rcodIead)
                                            {   $codigoFundo = $rcodIead->cod_Ass;
                                                $dataVenc   = $rcodIead->cont_Contabil;
                                                $dataMelhor = $rcodIead->ent_SaiAss;
                                                $cred_deb = $rcodIead->area;
                                         
                                         ?>                                           
                                                <option value = "<?php echo $codigoFundo ?>" <?php if( !empty($lancamento))if($rcodIead->cod_Ass == $fundoF){ echo 'selected';} ?>>
                                                <?php echo $rcodIead->cod_Ass." | ".$rcodIead->descricao_Ass ?></option>
                                               <?php                                                       
                                             }
                                         } 
                                        ?>														
                                          </select>
                                    </div>
                                </div>
                                <?php echo $dataFin = !empty($lancamento) ? $dataFin : date('d/m/Y');?>
                                    <label for="dataInicial">Data do evento financeiro<span class="required">*</span></label>
                                    <input id="dataVenda" class="span6 datepicker" type="Text" name="dataVenda" value="<?php echo $dataFin;?>"  />
                               
                                <input  name ="numeroDoc" type="hidden"  value= "1"  >
                               
                              
                            <p class="confirma"> 
                                <?php  $numDocFiscal = !empty($lancamento) ? $numDocFiscal : "Previsto";
                                       $chekFisc0 = $numDocFiscal == "Previsto" ? "checked" : "";
                                       if( !empty($lancamento)) $chekFisc1 = $numDocFiscal == "Efetuado" ? "checked" : ""; ?>
                                <label for="tiposaida">Situação</label>
                                <label class="btn btn-default" submit>
                                    <input name="numDocFiscal" type="radio" value="Previsto" <?php echo $chekFisc0 ?> class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Previsto</label> 
                                <label class="btn btn-default" submit>
                                    <input name="numDocFiscal" type="radio"  value="Efetuado" <?php if( !empty($lancamento))echo $chekFisc1 ?> class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Efetuado</label>                                
                            </p>
                            </div>
                           <div class="span3"> 
                                <label for="tiposaida">Tipo de Lançamento</label>
                                <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio" checked  value="Eventual" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Eventual</label>
                                <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Periodico" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Periodico</label>
                                <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Fixo" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Fixo</label>
                                <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Parcelado" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Parcelado</label>

                                <div id = "palco">
                                 <div id = "Periodico">
                                    <label for="conta_Destino">Repetir</label>
                                    <td>
                                        <input  name="conta_Destino"  id = "conta_Destino" type="number" value="1" max=48 >
                                        <font color=red> *</font>
                                    </td>
                                 </div>
                                </div>

                                <div id="blAux6">
                                    
                                <div class="control-group">
                                    <label for="valorFin" class="control-label">Valor do lançamento<span class="required">*</span></label>
                                    <div class="controls">
                                        <input text-align="right" name="valorFin" class="money"  value= "<?php if( !empty($lancamento))echo $valorFin ?>"  >
                                    </div>
                                </div>
                                    
                                <div class="control-group">
                                            <label for="razaoSoc" class="control-label">Histórico<span class="required">*</span></label>
                                    <div class="controls">
                                        <input  name ="razaoSoc" type="text"  value= "<?php if( !empty($lancamento))echo $razaoSoc ?>" maxlength=100 placeholder="- Rzão Social."><font color=red> *</font> 
                                    </div>

                                    </div>
                                    
                                <div class="control-group">
                                        <label for="descricao" class="control-label">Descrição<span class="required">*</span></label>
                                    <div class="controls">
                                        <input  name ="descricao" type="text"  value= "<?php if( !empty($lancamento))echo $descri ?>" maxlength=100 placeholder="- Descrição."><font color=red> *</font> 
                                    </div>
                                </div>
                                </div> 
                            </div>
                       </div>   
                       <div class="span12">
                            <div class="span4" style="padding: 1%; margin-left: 0">
                                <div class="span6 offset3" style="text-align: center">
                                    <button class="btn btn-success" id="btnContinuar"><i class="icon-share-alt icon-white"></i> Continuar</button>
                                    <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                </div>
                           </div>
                        </div>
                       <div class="span12">
                                     <div class="span4">
                                    <p class="Senha">
                                        <label for="senhaAdm"><font color=red>Senha Admnistrador</font></label>
                                        <input  name ="senhaAdm" type="text"  value= ""  ><font color=red> *</font>

                                    </p>
                                    </div>
                                 <div class="span3">

                                   <label class="btn btn-default" submit><input name="pular" id="pular" type="checkbox"  value="Eventual" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Pular fatura</label>

                                </div>
                       </div>
                    </form>	
                    </div>
                </div>
            </div>
            <div class="span12">		
                <div id="blRodape">  	
                                    <h5 text-align=center>Controle Pessoal</h5>		

                </div> 
                 <font color=red>( ** )</font><font color = red>Obs: </font><font color = #458B74 size=2>Padrão para preenchimento de valores
                                    99.999,99 ou 99999,99 ou 99999.99 ou 99999
                </font><br/>
                <font color=red>( * )</font><font color = red>Obs: </font><font color = #458B74 size=2>- No campo <b>DOCUMENTO FISCAL </b> inserir NF ou CF antes do número e separando com traço. <br/>- No campo <b>Historico </b>prencher <b>apenas</b> com o a razão social do estabelecimento. <br/>- E no campo <b>DESCRIÇÃO</b> fica livre para descrever os detalhes que julgar nescessário.</font>
            </div>
        </div> 
    </div>
</div>
</div>

<script type="text/javascript">
        function id( el ){
                return document.getElementById( el );
        }
        function mostra( el ){
            if( el == "Periodico" || el == "Parcelado" )
                id( "Periodico" ).style.display = 'block';
        }
        function esconde_todos( el, tagName ){
                var tags = el.getElementsByTagName( tagName );
                for( var i=0; i<tags.length; i++ )
                {	tags[i].style.display = 'none';
                }
        }
        window.onload = function()
        {
                id('Periodico').style.display = 'none';
                id('rd-time').onchange = function()
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
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 $(".money").maskMoney();
      $("#formVendas").validate({
          rules:{
             descricao: {required:true},
             razaoSoc: {required:true},
             dataVenda: {required:true},
             valorFin: {required:true},
             cCustos: {required:true},
             fundoF: {required:true}
          },
          messages:{
             descricao: {required: 'Campo Requerido.'},
             razaoSoc: {required: 'Campo Requerido.'},
             dataVenda: {required: 'Campo Requerido.'},
             valorFin: {required: 'Campo Requerido.'},
             cCustos: {required: 'Campo Requerido.'},
             fundoF: {required: 'Campo Requerido.'}
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

