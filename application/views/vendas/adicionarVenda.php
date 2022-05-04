
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
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
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
        $lancamento = array();
        if( isset($_SESSION['lancamento']))
        {
            $lancamento = $_SESSION['lancamento'];
        
var_dump($lancamento);
       
            $conta          = $lancamento['conta'];        
            $tipCont        = $lancamento['tipo_Conta'];
            $cod_assoc      = $lancamento['cod_assoc'];
            $cod_compassion = $lancamento['cod_compassion'] ;
            $num_Doc        = $lancamento['num_Doc_Banco'];
            $numDocFiscal   = $lancamento['num_Doc_Fiscal'];
            $razaoSoc       = $lancamento['historico'];
            $descri         = $lancamento['descricao'];	
            $valorFin       = $lancamento['valorFin'];
            $tipo_Pag       = $lancamento['tipo_Pag'];
            $tipoES         = $lancamento['ent_Sai'] ; 
            $cadastrante    = $lancamento['cadastrante'];
        }else
        {//Se a pagina foi chamada pela página cadatrarLançamento ou seja tentar denovo 
            unset($_SESSION['lancamento']);        
            
            $contaA =  $_POST["tab"];
            $nivel =  $_POST["tipop"];

            $conta = $_POST["conta"];
            $tipCont = $_POST["tipCont"];
            $tipoES = $_POST["tipoES"];
            $presentes = $_POST["presentes"];
            $multiLance = '0';
        }
            if($tipoES == 0) $tipoEnt_Sai = "Despesa";
            else if($tipoES == 1) $tipoEnt_Sai = "Receita";        
        
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
     $id_fin = 0; 
    $saldo_Atual = 0.00; 	
    $dataUlt_saldo = 0.00;
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
                                    <?php //if($custom_error == true)
                                        { ?>
                                    <!--
                                    <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">Dados incompletos, verifique os campos com asterisco ou se selecionou corretamente cliente e responsável.</div>
                                    -->
                                    <?php } ?>
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
                <?php  
    //******* Se a solicitação de lançamento deu erro e voltou, os campos são Realimentados
                if( isset($_SESSION['conta']))
                {?>                    
                   <div class="span3">                            
                       <?php                         
                        {			
                         {
                           //  $query = mysqli_query($conex, "SELECT * FROM cod_compassion WHere  ent_Sai = 0 ");
                            ?>
                        <p class="cod_Comp">
                            <label for="compassion">Centro de Custo *</label>
                              <select id="cod_Comp" name="cod_Comp" >                                              
                                <option value = NULL >Centro de Custo</option>
                                <?php 
                                  if( $tipoES == 0 )
                                  {                                                                                                 
                                     foreach ($result_codComp as $rcodComp)
                                     {
                                          if( $rcodComp->ent_SaiComp == 0 && $rcodComp->codigoNovo == 1 )
                                          { ?>                                           
                                        <option value = "<?php echo $rcodComp->cod_Comp ?>">
                                        <?php echo ' '.$rcodComp->cod_Comp." |
                                        ".$rcodComp->descricao." | ".$rcodComp->area_Cod.' '?></option>
                                       <?php } else { } 
                                     }
                                   } else 
                                  if( $tipoES == 1 ) 
                                  {                                                                                                 
                                     foreach ($result_codComp as $rcodComp)
                                     {
                                          if( $rcodComp->ent_SaiComp == 1 && $rcodComp->codigoNovo == 1 )
                                          {
                                          ?>                                        
                                            <option value = "<?php echo $rcodComp->cod_Comp ?>">
                                            <?php echo ' '.$rcodComp->cod_Comp." |
                                            ".$rcodComp->descricao." | ".$rcodComp->area_Cod.' '?></option>
                                           <?php } else { }
                                       }
                                 } ?>
                              </select>
                        </p>
                            <?php }?>
                        <p class="cod_ass">
                             <?php                                
                               foreach ($result_codIead as $rcodIead)
                                {
                                  if($rcodIead->cod_Ass == $cod_assoc) 
                                  {$cod_A =   $rcodIead->cod_Ass;
                                  $descricao_A = $rcodIead->descricao_Ass;
                                  }     
                                }?>                            
                            <label for="cod_ass">Fundo Financeiro *</label>
                             <select id="cod_Ass" name="cod_Ass">
                                <option value = NULL >Meio Financeiro</option>
                                <option value = "<?php echo $cod_A ?>">
                                    <?php echo $cod_A." | ".$descricao_A ?></option>
                             <?php 
                                if( $tipoES == 0 )
                                { 
                                 foreach ($result_codIead as $rcodIead)
                                { 
                                    if( $rcodIead->ent_SaiAss == 0 )
                                      { ?>                                           
                                    <option value = "<?php echo $rcodIead->cod_Ass ?>">
                                    <?php echo $rcodIead->cod_Ass." | ".$rcodIead->descricao_Ass ?></option>
                                   <?php } else { }                                                      
                                 }

                                 } else 
                                  if( $tipoES == 1 ) 
                                  {
                                  foreach ($result_codIead as $rcodIead)
                                    { 
                                      if( $rcodIead->ent_SaiAss == 1 )
                                      {
                                      ?>                                        
                                        <option value = "<?php echo $rcodIead->cod_Ass ?>">
                                        <?php echo '  '.$rcodIead->cod_Ass." |
                                        ".$rcodIead->descricao_Ass ?></option>
                                       <?php } else { }
                                    } 
                                }
                                ?>														
                                  </select>
                        </p>
                        <?php }
                        ?>
                         <p class="docFiscal">
                                        <label for="dataInicial">Data do evento financeiro<span class="required">*</span></label>
                                        <input id="dataVenda" class="span6 datepicker" type="Text" name="dataVenda" value="<?php echo $dataVenda; ?>"  />
                       </p>
                        <input id="numDocFiscal" name="numDocFiscal" type="hidden" value="<?php echo $numDocFiscal ?>" />
                        <input id="conta_Destino" name="conta_Destino" type="hidden" value = "<?php echo $conta ?>" /> 
                    </div>
                    <div class="span3"> 
                        <label for="tiposaida">Forma de saida</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio" checked  value="Eventual" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Eventual</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Periodico" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Periodico</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Fixo" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Eventual</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Parcelado" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Parcelado</label>
                        
                        <div id = "palco">
                         <div id = "Periodico">
                            <label for="conta_Destino">Repetir</label>
                            <td>
                                <input  name="conta_Destino"  id = "conta_Destino" type="number" value="1" max=24 >
                                <font color=red> *</font>
                            </td>
                         </div>
                        </div>

                        <div id="blAux6">
                            <p class="VALOR">
                            <label for="valor">Valor do lançamento</label>
                            <span class="style1">* R$ </span><input text-align="right" name="valorFin" class="money"  value= "<?php echo $valorFin ?>"  ><font color=red> **</font>
                            </p>
                            <p class="Historico">
                                <label for="razao"><font color=red>Histórico</font></label>
                                <textarea name ="razaoSoc" type="text" maxlength=100 ></textarea><font color=red> *</font>

                            </p>
                            <p class="descri">
                                <label for="descri">Descrição</label>
                                <textarea name ="descri" type="text" maxlength=100 ><?php echo $descri ?></textarea><font color=red> *</font>
                            </p>   
                        </div> 
                            <p class="Senha">
                                <label for="senhaAdm"><font color=red>Senha Admnistrador</font></label>
                                <input  name ="senhaAdm" type="text"  value= ""  ><font color=red> *</font>

                            </p>
                    </div>
                <?php
                }else  
    //******* Se o lançamento esta iniciando                  
                {                     
                 {?>
                   <div class="span3">	
                       <?php                         
                        {
                         {
                            ?>
                            <p class="cod_Comp">
                                <label for="compassion">Centro de Custo *</label>
                                  <select id="cod_Comp" name="cod_Comp" >                                              
                                    <option value = "">Centro de Custo</option>
                                    <?php 
                                      if( $tipoES == 0 )
                                      { 
                                       foreach ($result_codComp as $rcodComp)
                                         {
                                              if( $rcodComp->ent_SaiComp == 0 && $rcodComp->codigoNovo == 1 )
                                              { ?>                                           
                                            <option value = "<?php echo $rcodComp->cod_Comp ?>">
                                            <?php echo ' '.$rcodComp->cod_Comp." |
                                            ".$rcodComp->descricao." | ".$rcodComp->area_Cod.' '?></option>
                                           <?php } else { } 
                                         }
                                       } else 
                                      if( $tipoES == 1 ) 
                                      {                                                                                                 
                                         foreach ($result_codComp as $rcodComp)
                                         {
                                              if( $rcodComp->ent_SaiComp == 1 && $rcodComp->codigoNovo == 1 )
                                              {
                                              ?>                                        
                                                <option value = "<?php echo $rcodComp->cod_Comp ?>">
                                                <?php echo ' '.$rcodComp->cod_Comp." |
                                                ".$rcodComp->descricao." | ".$rcodComp->area_Cod.' '?></option>
                                               <?php } else { }
                                           }
                                     } ?>
                                      </select>
                        </p>
                        <?php }    ?>
                    <p class="cod_ass">

                        <label for="cod_ass">Fundo Financeiro *</label>
                         <select id="cod_Ass" name="cod_Ass">
                            <option value = "">Meio Financeiro</option>
                            <?php 

                         if( $tipoES == 0 )
                            { 
                             foreach ($result_codIead as $rcodIead)
                            { 
                                if( $rcodIead->ent_SaiAss == 0 )
                                  { ?>                                           
                                <option value = "<?php echo $rcodIead->cod_Ass ?>">
                                <?php echo $rcodIead->cod_Ass." | ".$rcodIead->descricao_Ass ?></option>
                               <?php } else { }                                                      
                             }

                             } else 
                              if( $tipoES == 1 ) 
                              {
                              foreach ($result_codIead as $rcodIead)
                                { 
                                  if( $rcodIead->ent_SaiAss == 1 )
                                  {
                                  ?>                                        
                                    <option value = "<?php echo $rcodIead->cod_Ass ?>">
                                    <?php echo '  '.$rcodIead->cod_Ass." |
                                    ".$rcodIead->descricao_Ass ?></option>
                                   <?php } else { }
                                } 
                            }
                            ?>														
                        </select>
                    </p>
                    <?php }
                    ?>
                    <p class="docFiscal">
                    </p>                                
                    <p class="conta" class="span6">
                                    <label for="dataInicial">Data do evento financeiro<span class="required">*</span></label>
                                    <input id="dataVenda" class="span6 datepicker" type="Text" name="dataVenda" value="<?php echo date('d/m/Y'); ?>"  />
                     </p>
</div>
                   <div class="span3">
                        <label for="tiposaida">Forma de saida</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio" checked  value="Eventual" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Eventual</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Periodico" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Periodico</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Fixo" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Eventual</label>
                        <label class="btn btn-default" submit><input name="tipoPag" id="rd-time" type="radio"   value="Parcelado" class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Parcelado</label>
                        
                        <div id = "palco">
                         <div id = "Periodico">
                            <label for="conta_Destino">Repetir</label>
                            <td>
                                <input  name="conta_Destino"  id = "conta_Destino" type="number" value="1" max=24 >
                                <font color=red> *</font>
                            </td>
                         </div>
                        </div>

                           <div id="blAux6">
                                <p class="VALOR">
                                <label for="valor">Valor do lançamento</label>
                                <span class="style1">* R$ </span><input text-align="right" name="valorFin"  class="money"  ><font color=red> **</font>
                                </p>
                                <p class="Historico">
                                    <label for="raz"><font color=red>Histórico</font></label>
                                     <textarea name ="razaoSoc" type="text" maxlength=100  placeholder="Descrição."></textarea><font color=red> *</font>

                                </p>
                                <p class="descri">
                                    <label for="descri">Descrição</label>
                                    <textarea name ="descri" type="text" placeholder="- Observação." maxlength=100></textarea><font color=red> *</font>
                                </p>   
                            </div>

                        <p class="senhaAdm">
                             <input  style ="background: transparent; border: none;" name ="raz" type="hidden"  >
                            <label for="senhaAd"><font color=red>senha Administrador</font></label>
                            <input  name ="senhaAdm" type="text"  value=""  maxlength=50><font color=red> *</font>
                        </p>
                    </div>
                 <?php }?>
                    <div class="span12">
                    <div id = "outro">								
                                	
</div>                          	
                   <?php
                    }
                    ?>
                <div class="span4" style="padding: 1%; margin-left: 0">
                    <div class="span6 offset3" style="text-align: center">
                        <button class="btn btn-success" id="btnContinuar"><i class="icon-share-alt icon-white"></i> Continuar</button>
                        <a href="<?php echo base_url() ?>index.php/vendas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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
      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteCliente",
            minLength: 1,
            select: function( event, ui ) {
                 $("#clientes_id").val(ui.item.id);    
            }
      });
      $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteUsuario",
            minLength: 1,
            select: function( event, ui ) {
                 $("#usuarios_id").val(ui.item.id);
            }
      });
      $("#formVendas").validate({
          rules:{
          },
          messages:{
             cliente: {required: 'Campo Requerido.'},
             tecnico: {required: 'Campo Requerido.'},
             dataVenda: {required: 'Campo Requerido.'}
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

