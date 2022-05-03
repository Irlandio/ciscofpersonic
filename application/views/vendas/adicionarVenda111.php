
    <style>
.badgebox
{
    opacity: 0;
}
.badgebox + .badge
{
    text-indent: -999999px;
	width: 27px;
}
.badgebox:focus + .badge
{
    
    box-shadow: inset 0px 0px 5px;
}
.badgebox:checked + .badge
{
	text-indent: 0;
}
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
                    
                    if( isset($_SESSION['conta']))
                    {
                         
                        $conta = ($_SESSION['conta']);        
                        if(null !== ( $_SESSION['tipoCont']))    $tipCont        = ($_SESSION['tipoCont']);
                        if(null !== ( $_SESSION['cod_Ass']))     $cod_assoc      = ($_SESSION['cod_Ass']);
                        if(null !== ( $_SESSION['cod_Comp']))    $cod_compassion = ($_SESSION['cod_Comp']) ;
						if(null !== ( $_SESSION['numeroDoc']))   $num_Doc        = ($_SESSION['numeroDoc']);
						if(null !== ( $_SESSION['numDocFiscal']))$numDocFiscal   = ($_SESSION['numDocFiscal']);
						if(null !== ( $_SESSION['razaoSoc']))    $razaoSoc       = ($_SESSION['razaoSoc']);
						if(null !== ( $_SESSION['descri']))      $descri         = ($_SESSION['descri']);	
                        if(null !== ( $_SESSION['valorFin']))    $valorFin       = ($_SESSION['valorFin']);
                        if(null !== ( $_SESSION['tipoPag']))     $tipo_Pag       = ($_SESSION['tipoPag']);
						if(null !== ( $_SESSION['tipoES']))      $tipoES         = ($_SESSION['tipoES']) ; 
                        if(null !== ( $_SESSION['cadastrante'])) $cadastrante    = ($_SESSION['cadastrante']);
                        if(null !== ( $_SESSION['presentes'])) {  $presentes      = ($_SESSION['presentes']);
                         if(isset( $_SESSION['qtd_presentes'])) if(null !== ( $_SESSION['qtd_presentes']))$qtd_presentes= ($_SESSION['qtd_presentes']);}
                        if(isset( $_SESSION['id_presentes'])) $id_presentes  = ($_SESSION['id_presentes']) ;
						if(isset( $_SESSION['senhaAdm']))     $senhaAdm      = ($_SESSION['senhaAdm']);
                        if(null !== ( $_SESSION['dataVenda']))     $dataVenda    = $_SESSION['dataVenda'];
                           
                         /*  
                          if( ($qtd_presentes) > 0)
                          {
                            $contar = 1;
                                    while (($contar <= $qtd_presentes) ) 
                                        {
                                            $nome = 'nome'.$contar;
                                            $Codigo = 'Codigo'.$contar;
                                            $Protocolo = 'Protocolo'.$contar;
                                            $valorPre = 'valorPre'.$contar;
                                                $_POST[$nome] = $_SESSION[$nome]
                                                $_POST[$Codigo] =  $_SESSION[$Codigo];	
                                                $_POST[$Protocolo] = $_SESSION[$Protocolo];
                                                $_POST[$valorPre] = $_SESSION[$valorPre];	

                                            $contar = $contar+1;							

                                        }
                          }*/
                        
                    }else {//Se a pagina foi chamada pela página cadatrarLançamento ou seja tentar denovo
                                      
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
                        	 
                     
					$contaA =  $_POST["tab"];
                    $nivel =  $_POST["tipop"];
          
					$conta = $_POST["conta"];
					$tipCont = $_POST["tipCont"];
					$tipoES = $_POST["tipoES"];
					$presentes = $_POST["presentes"];
					$multiLance = '0';
                        
						if(($tipCont == "Suporte" && $presentes == "true" ))
						{	echo "<center><font color = red >O tipo de conta selecionado foi Suporte (pequeno caixa).</font>";
							echo "<font color = red >Verifique se a opção esta correta. </font></br></center>";
						//echo "<center><font color = red >Para presentes especiais você deve retornar e </font>";
						//	echo "<font color = red >selecionar tipo de conta Corrente!</font></center>";
						//	$presentes = "false";
                        // exit;
						} 
					//$conta = $_SESSION['Cont'];
					//$tipCont = $_SESSION['t_Cont'];		
					}

                        if($tipoES == 0) $tipoEnt_Sai = "Despesa";
                        else if($tipoES == 1) $tipoEnt_Sai = "Receita";

					switch ($conta)
					{
						case 0:	$contaNome = "Retorne a pagina anterior o selecione uma conta para lançamento";	break;    
						case 1:	$contaNome = "IEADALPE - 1444-3";	break;    
						case 2:	$contaNome = "22360-3";	break;  
						case 3:	$contaNome = "ILPI";	break;  
						case 4:	$contaNome = "BR214";	break;  
						case 5:	$contaNome = "BR518";	break;  
						case 6:	$contaNome = "BR542";	break;  
						case 7:	$contaNome = "BR549";	break;  
						case 8:	$contaNome = "BR579";	break;  
						case 9:	$contaNome = "BB 28965-5";	break;  
						case 10:$contaNome = "CEF 1948-4";	break; 				
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
                          <input name ="presentes"  type="hidden" value="<?php echo $presentes ?>" />                            

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
                    
                    <div class="span6"> 			
                            
                       <?php 
                        if( $presentes == "true" )
                        {
                        if( $tipoES == 0 )
                        {     ?>
                        <p class="cod_Comp">
                            <label for="compassion">Código Compassion *</label>
                                  <select id="cod_Comp" name="cod_Comp" class="span12" >

                                        <option value = "D06-010">
                                        D06-010 | COMPASSION PRESENTES ESPECIAIS | FUNDOS ESPECIAIS COMPASSION</option>

                                      </select>
                        </p>
                        <p class="cod_ass">
                            <label for="cod_ass">Código IEADALPE *</label>
                                 <select id="cod_Ass" name="cod_Ass" class="span12">
                                    <option value = "D06-010">
                                        D06-010 | PRESENTES ESPECIAIS (Compassion)</option>										
                                      </select> 
                            </p>
                        <?php 
                        } else if( $tipoES == 1 )
                            {  ?>
                            <p class="cod_Comp">
                                <label for="compassion">Código Compassion *</label>
                                  <select id="cod_Comp" name="cod_Comp" class="span12" >
                                    <option value = "R01-020">
                                    R01-020 | PRESENTES ESPECIAIS | FUNDOS ESPECIAIS COMPASSION</option>
                                    </select>
                            </p>
                            <p class="cod_ass">
                                <label for="cod_ass">Código IEADALPE *</label>
                                     <select id="cod_Ass" name="cod_Ass" class="span12">
                                        <option value = "R01">
                                            R01 | DOAÇÕES COMPASSION </option>										
                                          </select> 
                                </p>
                        <?php 

                            }
                        } else
                        {								
                         if( $conta <  4 || $conta >  8 )
                            {
                               echo '<input id="cod_Comp" name="cod_Comp"  type=hidden value=III-III />';
                            }else
                             {
                                      //  $query = mysqli_query($conex, "SELECT * FROM cod_compassion WHere  ent_Sai = 0 ");
                                        ?>
                                <p class="cod_Comp">
                                    <label for="compassion">Código Compassion *</label>
                                      <select id="cod_Comp" name="cod_Comp" >                                              
                                        <option value = NULL >Opção financeira Compassion</option>
                                        <?php 
                                          if( $tipoES == 0 )
                                          {                                                                                                 
                                             foreach ($result_codComp as $rcodComp)
                                             {
                                                  if( $rcodComp->ent_SaiComp == 0 )
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
                                                  if( $rcodComp->ent_SaiComp == 1 )
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
                             <?php 
                                
                               foreach ($result_codIead as $rcodIead)
                                {  
                                      if($rcodIead->cod_Ass == $cod_assoc) 
                                      {$cod_A =   $rcodIead->cod_Ass;
                                      $descricao_A = $rcodIead->descricao_Ass;
                                      }     
                                            }?> 
                            
                            <label for="cod_ass">Código IEADALPE *</label>
                             <select id="cod_Ass" name="cod_Ass">
                                <option value = NULL >Oopção Financeira IEADALPE</option>
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
                        <p class="numeroDocBancario">
                            <?php                                  					
                                    if($conta <> 3)
                                    {?>
                                <label for="numeroDocBanco">Número do Documento Bancário</label>
                                <input id="numeroDoc" name="numeroDoc" value= "<?php echo $num_Doc ?>"  />
                            <?php }
                                ?>
                            <span class="style1">*</span>
                        </p> 
                        <p class="docFiscal">
                                <label for="numeroDocFiscal">Número do Documento Fiscal</label>
                              <td>
                                <input id="numDocFiscal" name="numDocFiscal" value= "<?php echo $numDocFiscal ?>" />
                            <font color=red> *</font></td>
                        </p>
                        <div class="span6">
                                        <label for="dataInicial">Data do evento financeiro<span class="required">*</span></label>
                                        <input id="dataVenda" class="span4 datepicker" type="Text" name="dataVenda" value="<?php echo $dataVenda; ?>"  />
                        </div>                        
                        <div class="span6">                                                           
                        <p class="conta">
                            <label for="conta">à beneficio da conta</label>
                            <select id="conta_Destino" name="conta_Destino">                                              
                            <option value = "<?php echo $conta ?>"><?php echo $conta.' | '.$contaNome ; ?></option>
                             <?php
                                foreach ($result_caixas as $rcx) 
                                {                   
                              if($usuario->conta_Usuario == 99)
                                   if(($conta < 4) || ($conta > 8))
                                  {?>                                               
                                <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa ?></option>
                                        <?php
                                }    
                               }
                              ?>														
                            </select>
                         <font color=red><span class="style1"> * </span></font>	
                        </p>
                        </div>
                        
                  
                    </div>
                                
                    <div class="span5"> 
                                <?php 
                            if($tipCont == "Corrente") 
                                            { ?>
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
                                            id('cheq').style.display = 'none';
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



                                                    <label for="tiposaida">Forma de saida</label>
                                                    <input  name="tipoPag" type="radio" value="trans" CHECKED>Transferência
                                                    <input  name="tipoPag"  id = "rd-time" type="radio" value="cheq" style="margin-top:15px;" >Cheque

                                                  <div id = "palco">
                                                 <div id = "cheq">

                                                    <label for="tiposaida"><input  name="chequeCompen" type="checkbox" value= "0">Cheque já compensado</label>

                                                 </div>
                                                 </div>
                                                <?php 
                                            }	
                                            ?>

                                <div id="blAux6">
                                    <p class="VALOR">
                                    <label for="valor">Valor do lançamento</label>
                                    <span class="style1">* R$ </span><input text-align="right" name="valorFin" class="money"  value= "<?php echo $valorFin ?>"  ><font color=red> **</font>
                                    </p>
                                    <p class="Historico">
                                        <label for="razao"><font color=red>Histórico</font></label>
                                        <input class="span12" name ="razaoSoc" type="text"  value= "<?php echo $razaoSoc ?>" maxlength=45 ><font color=red> *</font>

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
                    <div class="span12">
                        <div id = "outro">								
                                    <?php 
                           if( $presentes == "true" )   
                            {
    //****** ENTRADA DE presentes especiais
                           if($tipoES == ( 1))
                            {
                             //  $qtd_presentes = $_POST["qtd_presentes"];
                                ?>
                             <input name ="qtd_presentes"  type="hidden" value="<?php echo $qtd_presentes ?>" />


                                <input type = "radio" name = "v_Valores" id = "v_Valores" value="1"  checked="checked"/> <font color = #458B74>- Verificar</font>
                                  <input type = "radio" name = "v_Valores" id = "v_Valores" value ="0"  /> <font color = #458B74>- verificar e Cadastrar</font>
                                </div>


                                    <table>
                                    <th font color="#458B74" >Beneficiário</th>	
                                    <th font color=red >Código BR/Protocólo</th>
                                    <!--<th font color=red >Protocólo</th>-->
                                    <th font color=red >Valor R$</th>					

                                    <?php
                                    if($_SESSION['nome1'] == null)
                                    {
                                    
                                        $contar = 1;
                                        while (($contar <= $qtd_presentes) || $contar == 30) 
                                        {
                                        ?>
                                        <tr>
                                        <td>
                                        <?php  $nome = 'nome'.$contar ?>										
                                        <input name="<?php echo $nome ?>" placeholder= "<?php echo $nome ?>" />										
                                        </td>
                                        <td >
                                        <?php  $Codigo = 'Codigo'.$contar ?>
                                        <input  iid="Codigo" name="<?php echo $Codigo ?>" placeholder= "<?php echo $Codigo ?>" />						
                                        <?php  $Protocolo = 'Protocolo'.$contar ?>
                                        <input   iid="Protocolo" name="<?php echo $Protocolo ?>" placeholder= "<?php echo $Protocolo ?>"  />
                                        </td>
                                        <td>
                                        <?php  $valorPre = 'valorPre'.$contar ?>
                                        <input   name="<?php echo $valorPre ?>" class="money"   placeholder= "<?php echo $valorPre ?>"    />
                                        </td>
                                        </tr>
                                    <?php
                                    $contar = $contar+1;
                                    if($contar == 31) exit;
                                    }
                                    } else
                                    {                                
										$contar = 1;
										while (($contar <= $qtd_presentes) || $contar == 30) 
										{
										?>
										<tr>
										<td>
										<?php  $nome = 'nome'.$contar ?>										
										<input id="name" name="<?php echo $nome ?>" value= "<?php echo $_SESSION[$nome] ?>" />										
										</td>
										<td>
										<?php  $Codigo = 'Codigo'.$contar ?>
										<input id="Codigo" name="<?php echo $Codigo ?>" value= "<?php echo $_SESSION[$Codigo] ?>" />			
										<?php  $Protocolo = 'Protocolo'.$contar ?>
										<input id="Protocolo" name="<?php echo $Protocolo ?>" value= "<?php echo $_SESSION[$Protocolo] ?>" />
										</td>
										<td>
										<?php  $valorPre = 'valorPre'.$contar ?>
										* R$ <input name="<?php echo $valorPre ?>"  class="money"  value= "<?php echo $_SESSION[$valorPre] ?>" />
										</td>
										</tr>
										
										
										<?php
										$contar = $contar+1;
										if($contar == 31) exit;
										}
                                    }
									?>       
                                        
                                <tr> <td></td>  <td>VALOR TOTAL</td> <td>
                                <span class="style1">* R$ </span>
                        <input name="valtotal" readonly><br>
                        </td> 
                                </tr>
                        </table>
                            <?php 
                            }else 
    //****** sAÍDA DE presentes especiais
                               if($tipoES == ( 0))
                                    {
                                    if($nivel < 4)
                                    {
                                    require_once 'conexao.class.php';		
                                    $con = new Conexao();		 
                                    $con->connect(); $conex = $_SESSION['conex']; 
                                    //id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
                                        $presentes_abertos = mysqli_query($conex, 'SELECT * FROM presentes_especiais, aenpfin
                                                    WHERE id_fin = id_entrada and  id_saida like 0 and  conta like '.$conta.' ORDER BY dataFin');

                                    if (mysqli_num_rows($presentes_abertos) == 0 ) 
                                        {	echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";
                                        }
                                        
                                            echo '<table border=1 bgcolor="LightGray" width="70%">';
                                            echo '<thead bgcolor="#BDBDBD"><tr><th colspan="8" bgcolor="white" align="center" >Presentes especiais em aberto conta '.$contaNome.' </th>  </tr>';

                                           // echo '<th> </th>';	
                                            echo '<th>Nº</th>';	
                                            echo '<th>Conta</th>';	
                                            echo '<th>BR</th>';	
                                            echo '<th>Nome Beneficiário</th>';	
                                            echo '<th>Protocolo</th>';	
                                            echo '<th>Data</th>';
                                            echo '<th>Total R$</th>';	
                                            echo '<th>Valor pendente R$</th>';	
                                            echo '</tr></thead>';
                                            echo '<tbody style="font-size:80%">';
                                            $total = 0;	$inicio = 1;
                                //	while ($rows_presentes = mysqli_fetch_assoc($presentes_abertos)) 
                                        $contaY = "a";
                                 foreach ($pre as $rpres)    
                                    {	switch ($rpres->conta) 
                                        {
                                            case 1:	$contaN = "IEADALPE - 1444-3"; break;    
                                            case 2:	$contaN = "22360-3"; break;  
                                            case 3:	$contaN = "ILPI"; break;  
                                            case 4:	$contaN = "BR214"; break;  
                                            case 5:	$contaN = "BR518"; break;  
                                            case 6:	$contaN = "BR542"; break;  
                                            case 7:	$contaN = "BR549"; break;  
                                            case 8:	$contaN = "BR579"; break;  
                                            case 9:	$contaN = "BB 28965-5"; break;  
                                            case 10:$contaN = "CEF 1948-4"; break;
                                            case 99:$contaN = "Todas contas"; break;  				
                                        }		
                                            $data_Ch= implode('/',array_reverse(explode('-',$rpres->dataFin)));
                                            $val_Ch= number_format($rpres->valor_entrada, 2, ',', '.');
                                            $valor_pendente= number_format($rpres->valor_pendente, 2, ',', '.');

                                            if ($contaY == $contaN)
                                            {//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
                                                if ($val_Ch <> $valor_pendente)
                                                {	echo '<tr bgcolor="Yellow">'; $presente_pendente = "true";
                                                }	else 	echo '<tr bgcolor="#CEF6D8">';

                                                echo '<td><label  class="btn btn-default" submit>'.$rpres->id_presente.'<input  name="id_presentes" type="radio" value= "'.$rpres->id_presente.'"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                echo '<td>'.$contaN.'</td>';
                                                echo '<td>'.$rpres->n_beneficiario.'</td> <td>'.$rpres->nome_beneficiario.'</td>';
                                                echo '<td>'.$rpres->n_protocolo.'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
                                                echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
                                                $total = $total + $rpres->valor_pendente;
                                            }else
                                            {
                                                if ($inicio == 0)
                                                {$val_ChT= number_format($total, 2, ',', '.');
                                                    echo '<tr  bgcolor="#CEF6D8">';

                                                    echo '<td></td> <td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
                                                    echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_ChT.'</h4></td></tr>';

                                                    if ($val_Ch <> $valor_pendente)
                                                {	echo '<tr bgcolor="Yellow">'; $presente_pendente = "true";
                                                }	else 	echo '<tr bgcolor="#CEF6D8">';

                                                    
                                                echo '<td><label  class="btn btn-default" submit>'.$rpres->id_presente.'<input  name="id_presentes" type="radio" value= "'.$rpres->id_presente.'"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                echo '<td>'.$contaN.'</td>';
                                                echo '<td>'.$rpres->n_beneficiario.'</td> <td>'.$rpres->nome_beneficiario.'</td>';
                                                echo '<td>'.$rpres->n_protocolo.'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                    echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
                                                echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
                                                    $total = $total + $rpres->valor_pendente;
                                                }else
                                                {	 echo '<tr  bgcolor="#CEF6D8">';
                                                   
                                                echo '<td><label  class="btn btn-default" submit>'.$rpres->id_presente.'<input  name="id_presentes" type="radio" value= "'.$rpres->id_presente.'"  class="badgebox" style="margin-top:15px;" ><span class="badge" >&check;</span></label></td> ';

                                                echo '<td>'.$contaN.'</td>';
                                                echo '<td>'.$rpres->n_beneficiario.'</td> <td>'.$rpres->nome_beneficiario.'</td>';
                                                echo '<td>'.$rpres->n_protocolo.'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                    echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
                                                echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
                                                    $total = $total + $rpres->valor_pendente;
                                                    $inicio = 0;
                                                }
                                            }	
                                            $inicio = 0;
                                            $contaY = $contaN;
                                    } 	
                                        $val_Ch= number_format($total, 2, ',', '.');
                                        echo '<td></td> <td></td> <td></td>  <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
                                        echo '<td bgcolor="Yellow"  ><h4 align="right" valign=bottom >',$val_Ch.'</h4></td></tr>';
                                        echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                                    }	
                                    }	
                            }

                                    if( isset($presente_pendente)) 
                                        if( $presente_pendente == "true") 
                                        echo '* As linhas em amarelo são referentes a presentes com parte do valor ja lançado!';							
                                            ?>	
                                </div>
                          <?php          
//********* Insere "70_porcento" ou "30_porcento" para identificar de onde é o valor
                                        if($conta == 3)
                                        {		
                                            echo '<label><input  checked="checked"  name="numeroDoc" type="radio" value= "70_porcento" />
                            Pertence aos 70% </label>';                                            
                                            echo '<label><input name="numeroDoc" type="radio" value= "30_porcento" />Pertence aos 30%</label></br></br>';	
                                        }?>	




                <?php
                }else
  
    //******* Se o lançamento esta iniciando                  
                {
                     if( $multiLance =='1')
                     {
                         
					$qtd_Mult = $_POST['qtd_Multi'];
                              ?>
                    <div class="widget-content nopadding">


                    <table class="table table-bordered ">
                        <thead>
                            <tr style="backgroud-color: #2D335B">
                                <th>Códigos</th>
                                <th>Documentos</th>
                                <th>Data/Valor</th>
                                <th>Descrições</th>
                                <th>Forma</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php    
                            for($cont = 0; $cont <= $qtd_Mult; $cont++) 
                            {?>               
                            <tr>
                                <td><select id="cod_Comp" name="cod_Comp" >                                              
                                        <option value = "">Opção financeira Compassion</option>
                                        <?php 
                                          if( $tipoES == 0 )
                                          {                                                                                                 
                                             foreach ($result_codComp as $rcodComp)
                                             {
                                                  if( $rcodComp->ent_SaiComp == 0 )
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
                                                  if( $rcodComp->ent_SaiComp == 1 )
                                                  {
                                                  ?>                                        
                                                    <option value = "<?php echo $rcodComp->cod_Comp ?>">
                                                    <?php echo ' '.$rcodComp->cod_Comp." |
                                                    ".$rcodComp->descricao." | ".$rcodComp->area_Cod.' '?></option>
                                                   <?php } else { }
                                               }
                                         } ?>
                                          </select>
                                <select id="cod_Ass" name="cod_Ass">
                                <option value = "">Oopção financeira IEADALPE</option>
                                <?php 

                             if( $tipoES == 0 )
                                { 
                                 foreach ($result_codIead as $rcodIead)
                                { 
                                    if( $rcodIead->ent_SaiAss == 0 )
                                      { ?>                                           
                                    <option value = "<?php echo $rcodIead->cod_Ass ?>">
                                    <?php echo $rcodIead->cod_Ass."