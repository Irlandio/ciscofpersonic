
<html>
	<head><link rel="stylesheet" href="styles.css"  />	
	<head><link rel="stylesheet" href="styleprint.css" media="print" />	
	<script>
function cont(){
   var conteudo = document.getElementById('print').innerHTML;
   tela_impressao = window.open('about:blank');
   tela_impressao.document.write(conteudo);
   tela_impressao.window.print();
   tela_impressao.window.close();
}
						
function soma() 
{
form.valtotal.value = (form.valorPre1.value*1)+(form.valorPre2.value*1)+(form.valorPre3.value*1)+(form.valorPre4.value*1)+(form.valorPre5.value*1) 			
}
</script>
		<title>SISCOF - Lançamento financeiro</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
	</head>
	<body bgcolor="#Feeeab">
		<div id="bloco">  	
			<div id="blCabeca" title="sitename">  		
				<?php
					include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
					protegePagina(); // Chama a função que protege a página
			?>				
		<div id="skipmenu">Até aqui nos ajudou o Senhor  >>>>     
			<?php 
			$caixa = $_SESSION['conta_acesso'];
			$nivel = $_SESSION['nivel_acesso'];			
			switch ($caixa) 
			{
				case 1:	$caixaNome = "IEADALPE - 1444-3"; break;    
				case 2:	$caixaNome = "22360-3"; break;  
				case 3:	$caixaNome = "ILPI"; break;  
				case 4:	$caixaNome = "BR214"; break;  
				case 5:	$caixaNome = "BR518"; break;  
				case 6:	$caixaNome = "BR542"; break;  
				case 7:	$caixaNome = "BR549"; break;  
				case 8:	$caixaNome = "BR579"; break;  
				case 9:	$caixaNome = "BB 28965-5"; break;  
				case 10:$caixaNome = "CEF 1948-4"; break;
				case 99:$caixaNome = "Todas contas"; break;  				
			}							
			echo  "<strong>".$_SESSION['usuarioNome']."</strong> | Nivel de acesso ".$nivel." | ".$caixaNome;
			?>	
		</div>  	  		
					<h1>SISCOF - Lançamento de entrada </h1>  	
			</div>  				
			<div id="blMenu">  		
				<?php
					include"menuFLateral.html";
				?>				
			</div>  
			<div id="blCorpo">
				<form action="cadastrar_Lancamento.php" method="post" onsubmit="validaForm(); return false;" class="form">				
							<input name ="cad"  type="hidden" value="aenpfin"/>						
							<input type="hidden" name="tipoConsulta" value="<?php echo $tipoConsulta['3'] ?>"/>
							<input name ="op"  type="hidden" value="opCad"/>
							<input name ="tipop"  type="hidden" value="id_Fin"/>
								<!--Recebe valor do codigo do cliente ja cadastrado, para mostrar apenas ele antes de confirmar a compra-->
						</p>
						
						<p><img class="imagefloat" src="aenpazHorizontal.png" alt="" width="200" height="45" border="0">
							<?php
                            require_once 'funcao.php';
    
                               if(isset($_SESSION['tid_caixa'] ))
                                    {
                                   
                                   
                                $data	=         $_SESSION['tdata'];
								$valorFin	=     $_SESSION['tvalorFin'];
								$tipoCont	=     $_SESSION['ttipoCont'];
								$tipContNome	= $_POST["tipContNome"];
								$diaUm_mêsAtual	= $_SESSION['tdiaUm_mêsAtual'];
								$dataUlt_saldo	= $_POST["dataUlt_saldo"];
                                   
                               
                                 echo "</b></br> Valor digitado <strong><td> R$  ".$valorFin."</td></strong></br>";
                      
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
                                 
                        echo "</b></br> Valor p/ Exibir <strong><td> R$  ".$valorFinExibe."</td></strong></br>";
                       echo "</b></br> Valor p/ Guardar <strong><td> R$  ".$valorFin."</td></strong></br>"; 
                              
                                   
                                   ECHO "<h4></b>Registro financeiro de entrada</h4>";								
								require_once 'conexao.class.php';		
								$con = new Conexao();		 
								$con->connect(); $conex = $_SESSION['conex']; 			
								require_once"consultar.php";								
								//$con->disconnect(); 
								if($dataUlt_saldo < $diaUm_mêsAtual && $data >= $diaUm_mêsAtual)
									echo "<font color = grey size = 3>Primeiro lançamento do mês para esta conta. </font><br/>";
								
								$id_caixa =     $_SESSION['tid_caixa'];
								$cod_Ass =      $_SESSION['tcod_Ass'] ;
								$cod_Comp =     $_SESSION['tcod_Comp'];
								$numeroDoc=     $_SESSION['tnumeroDoc'];
								$numDocFiscal=  $_SESSION['tnumDocFiscal'];
								$razaoSoc	=        $_SESSION['trazaoSoc'];								
								$qtd_presentes	= $_SESSION['tqtd_presentes'];
                                $tid_presentes	= $_SESSION['tid_presentes'];
                                $id_fin	=         $_SESSION['ttid_fin'];//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
								$saldo_Atual	= $_SESSION['saldo_AtualConsult'] ;
								
								
						//$valorFin =  number_format(str_replace(",",".",$valorFin ),2, ".", "");
								
								$saldo_Final	= $saldo_Atual + $valorFin;
								$ent_Sai = 1;//Código para SAÍDA  é ( 0 )
								$cadastrante= $_SESSION['usuarioID'];
							/*	 	if($tipoPag == "trans") $Pag ="transferência"; else
										if($tipoPag == "cheq") $Pag ="cheque";
								echo "Saída através de <strong><td>".$Pag."</td></strong><br/>";
								echo "Histórico  - <strong><td>".$razaoSoc."</td></strong><br/>";
								echo "Documento Bancário  - <strong><td>".$numeroDoc."</td></strong> - ";
								echo "Documento Fiscal  - <strong><td>".$numDocFiscal."</td></strong> - ";
								$dataL= implode('/',array_reverse(explode('-',$data)));
								echo "<br/>Data  - <strong><td>".$dataL."</td></strong>  - ";
								ECHO "</b> Valor <strong><td> R$  ",number_format(str_replace(",",".",$valorFin ), 2, ',', '.'),"</td></strong></br>";*/
								//ECHO "</b> formato para o bd <strong><td> ", number_format(str_replace(",",".",$valorFin ),2, ".", ""),"</td></strong></br>";
								
                      ?>
            
							<div id="blAux5">
                            <p class="numeroDocBancario">
									<label for="numeroDocBanco">Número do Documento Bancário</label>
									<input id="numeroDoc" name="numeroDoc" value="<?php echo $numeroDoc; ?>" />
								<span class="style1">*</span>
							</p> 
							<p class="docFiscal">
									<label for="numeroDocFiscal">Número do Documento Fiscal</label>
								  <td>
									<input id="numDocFiscal" name="numDocFiscal" value="<?php echo $numDocFiscal; ?>" />
								<span class="style1">*</span></td>
							</p>
							<font color = red ><label for="razaoSoc" font color = red >Data do evento financeiro</label>
							<input  type="DATE" name="data" id = "data1" value="<?php echo implode('/',array_reverse(explode('-',$data))); ?>"  step="1"></br></font>			
							</div>
						<div id="blAux6">
							<p class="VALOR">
							<label for="valor">Valor do lançamento</label>
							* R$ </span><input text-align="right" name="valorFin" value="<?php echo $valorFinExibe; ?>" >
							</p>
							<p class="Historico">
								<label for="razaoSoc">Histórico</label>
								<textarea name ="razaoSoc" type="text"  maxlength=100><?php echo $razaoSoc; ?></textarea>
							</p>
                                
                        </div>
						    
                         <?php 
                                   
								ECHO "</br></br> ======== ======== ======== </br>";
								ECHO "</b> Saldo atual <td> R$  ",number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.'),"</td></br>";
								ECHO "</b> Saldo após o lançamento <td> R$  ",number_format(str_replace(",",".",$saldo_Final), 2, ',', '.'),"</td></br>";
								//echo $id_fin;
								
								//Busca o id do ultimo registro cadastrado;
								$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
												<a href='menu1.php'>Voltar ao Menu</a></center>");
												exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max )) 
								{	$id_Maxaenp = $id_ultimo['id_fin']; }								
								$con->disconnect(); 
                                   
                                   
								echo  "<br><font color = grey size = 1> Registro com saldo atual - ".$id_fin."</font>";
								echo  "<br><font color = grey size = 1> Ultimo registro lançado - ".$id_Maxaenp."</font><br><br>";
								
                                    echo  "<label for='v_Valores'>Verificar somatório dos valores*</label>";
							
								if($cod_Comp == ( "R01-020"))
								{
									?>

                                    <input type = "radio" name = "v_Valores" id = "v_Valores" value="1"  checked="checked"/> <font color = #458B74>- Verificar</font>
						              <input type = "radio" name = "v_Valores" id = "v_Valores" value ="0"  /> <font color = #458B74>- verificar e Cadastrar</font>
									</div>
										
										<table>
										<th font color="#458B74" >Beneficiário</th>	
										<th font color=red >Código BR</th>
										<th font color=red >Protocólo</th>
										<th font color=red >Valor R$</th>					
										
										<?php
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
										</td>
										<td>
										<?php  $Protocolo = 'Protocolo'.$contar ?>
										<input id="Protocolo" name="<?php echo $Protocolo ?>" value= "<?php echo $_SESSION[$Protocolo] ?>" />
										</td>
										<td>
										<?php  $valorPre = 'valorPre'.$contar ?>
										* R$ <input name="<?php echo $valorPre ?>"  value= "<?php echo $_SESSION[$valorPre] ?>" />
										</td>
										</tr>
										
										
										<?php
										$contar = $contar+1;
										if($contar == 31) exit;
										}
								}
									?>
								<!--	<tr> <td></td> <td></td> <td>VALOR TOTAL</td> <td>
									<span class="style1">* R$ </span>
							<input name="valtotal" readonly><br>
							</td> 
									</tr>
							</table>
							<input type="button" onclick="soma()" value="Somar Valores" background-color= "#133141" color= "#FFF">
                            -->  	    	
							<p class="variaveis"><!--Campo fica em oculto apenas para guardar o indicador da tabela "congregacao"-->
								
							<input name ="qtd_presentes"  type="hidden" value="<?php echo $qtd_presentes ?>"/>
							<input name ="id_caixa"  type="hidden" value="<?php echo $id_caixa ?>"/>
							<input name ="tipoCont"  type="hidden" value="<?php echo $tipContNome?>"/>
							<input name ="cod_Comp"  type="hidden" value="<?php echo $cod_Comp ?>"/>	
							<input name ="cod_Ass"  type="hidden" value="<?php echo $cod_Ass ?>"/>
							
							<input name ="ent_Sai"  type="hidden" value="<?php echo $ent_Sai ?>"/>	
							<input name ="id_fin"  type="hidden" value="<?php echo $id_fin ?>" />
							<input name ="tipoPag"  type="hidden" value="<?php echo $tipoPag ?>" />
							<input name ="saldo_Final"  type="hidden" value="<?php echo $saldo_Final ?>" />
							<input name ="diaUm_mêsAtual"  type="hidden" value="<?php echo $diaUm_mêsAtual ?>" />
							<input name ="dataUlt_saldo"  type="hidden" value="<?php echo $dataUlt_saldo ?>" />
							<input name ="cadastrante"  type="hidden" value="<?php echo $cadastrante ?>"/>	
                                <!--
                            <input name ="numeroDoc"  type="hidden" value="<?php echo $numeroDoc ?>"/>	
							<input name ="numDocFiscal"  type="hidden" value="<?php echo $numDocFiscal ?>"/>						
							<input name="razaoSoc" type="hidden"  value="<?php echo $razaoSoc ?>"/>
							<input name ="valorFin"  type="hidden" value="<?php echo $valorFin ?>"/>
							<input name ="data"  type="hidden" value="<?php echo $data ?>"/>	
										-->				
							</p>		
                            
                            <?php
                                   
                               } 
                                   else
                                    {
                                       if(isset( $_POST["data"] )) { $data	= $_POST["data"];}
                                       
                                       if(isset( $_POST["tipoCont"])) {$tipoCont	= $_POST["tipoCont"];}
                                       if(isset( $_POST["tipContNome"])) {$tipContNome	= $_POST["tipContNome"];}
                                       if(isset(  $_POST["diaUm_mêsAtual"])) {$diaUm_mêsAtual	= $_POST["diaUm_mêsAtual"];}
                                       if(isset( $_POST["dataUlt_saldo"] )) {$dataUlt_saldo	= $_POST["dataUlt_saldo"];}
                                
                                   
                                   // Função verifica se o valor é válido para moeda, tendo o padrão 999.999.999,99
                         
                           /*        	*/
                  //   echo "</b></br> Valor digitado <strong><td> R$  ".$valorFin."</td></strong></br>";
                      if(isset( $_POST["valorFin"] )) 
                      { $valorFin	= $_POST["valorFin"];
                                       
                             if(formatoRealPntVrg($valorFin) == true) 
                           {//Verific se o numero digitado é com (.) milhar e (,) decimal
                               //serve pra validar  valores acima e abaixo de 1000
                                 //    echo "Ponto e virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                                $valorFinExibe  =    $valorFin;   
                               $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                           }else if(formatoRealInt($valorFin) == true)
                           {//Verific se o numero digitado é inteiro sem ponto nem virgula
                               //serve pra validar  valores acima e abaixo de 1000
                             //      echo "Inteiro!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                              $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                               $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
                           }else if(formatoRealPnt($valorFin) == true)
                           {
                               //     echo "Ponto!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                               $valorFin  =    $valorFin;
                                $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                           }else if(formatoRealVrg($valorFin) == true)
                           {
                               //    echo "Virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                               $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                               $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                           }else
                           {
                               echo "O valor digitado não esta nos parametros solicitados";
                           }
                      }
                //        echo "</b></br> Valor p/ Exibir <strong><td> R$  ".$valorFinExibe."</td></strong></br>";
                 //      echo "</b></br> Valor p/ Guardar <strong><td> R$  ".$valorFin."</td></strong></br>";            
                  //               //ECHO "</b> formato para o bd <strong><td> ", number_format(str_replace(",",".",$valorFin ),2, ".", ""),"</td></strong></br>";
								 
						
								
								ECHO "<h4></b>Registro financeiro de entrada</h4>";								
								require_once 'conexao.class.php';		
								$con = new Conexao();		 
								$con->connect(); $conex = $_SESSION['conex']; 			
								require_once"consultar.php";								
								//$con->disconnect(); 
								if($dataUlt_saldo < $diaUm_mêsAtual && $data >= $diaUm_mêsAtual)
									echo "<font color = grey size = 3>Primeiro lançamento do mês para esta conta. </font><br/>";
								
								$id_caixa =$_POST["caixa"];
								$cod_Ass =$_POST["cod_ass"];
								$cod_Comp = $_POST["compassion"];
								$numeroDoc= $_POST["numeroDocBanco"];
								$numDocFiscal= $_POST["numeroDocFiscal"];
								$razaoSoc	= $_POST["razaoSoc"];
							//	$tipoPag	= $_POST["tipoPag"];
								
								$qtd_presentes	= $_POST["qtd_presentes"];
								
								
							//	$valorFin =  number_format($valorFin,2,',','.');
							//	$valorFin =  number_format(str_replace(",",".",$valorFin ),2, ".", "");
								$id_fin	= $_POST["id_fin"];//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
								$saldo_Atual	= $_POST["saldo_Atual"];
								$saldo_Final	= $saldo_Atual + $valorFin;
								$ent_Sai = 1;//Código para SAÍDA  é ( 0 )
								$cadastrante= $_SESSION['usuarioID'];
							
                                   echo "Histórico  - <strong><td>".$razaoSoc."</td></strong><br/>";
								echo "Documento Bancário  - <strong><td>".$numeroDoc."</td></strong> - ";
								echo "Documento Fiscal  - <strong><td>".$numDocFiscal."</td></strong> - ";
								$dataL= implode('/',array_reverse(explode('-',$data)));
								echo "<br/>Data  - <strong><td>".$dataL."</td></strong>  - ";
								echo "</b> Valor <strong><td> R$  ".$valorFinExibe."</td></strong></br>";// number_format(str_replace(",",".",$valorFin ), 2, ',', '.'),"</td></strong></br>";
                                 
								echo " ======== ======== ======== </br>";
								echo "</b> Saldo atual <td> R$  ",number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.'),"</td></br>";
								echo "</b> Saldo após o lançamento <td> R$  ",number_format(str_replace(",",".",$saldo_Final), 2, ',', '.'),"</td></br>";
								//echo $id_fin;
								
								//Busca o id do ultimo registro cadastrado;
								$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
												<a href='menu1.php'>Voltar ao Menu</a></center>");
												exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max )) 
								{	$id_Maxaenp = $id_ultimo['id_fin']; }								
								$con->disconnect(); 
								echo  "<br><font color = grey size = 1> Registro com saldo atual - ".$id_fin."</font>";
								echo  "<br><font color = grey size = 1> Ultimo registro lançado - ".$id_Maxaenp."</font><br><br>";
								
								if($cod_Comp == ( "R01-020"))
								{
									?>
                            <label for="v_Valores">Verificar valores*</label>
									
                             <input type = "radio" name = "v_Valores" id = "v_Valores" value=1 style="margin-top:15px;" checked="checked"/> <font color = #458B74> Verificar</font>
						              <input type = "radio" name = "v_Valores" id = "v_Valores" value =0 style="margin-top:15px;" /> <font color = #458B74>verificar e Cadastrar</font>
									</div>
										
										<table>
										<th font color="#458B74" >Beneficiário</th>	
										<th font color=red >Código BR</th>
										<th font color=red >Protocólo</th>
										<th font color=red >Valor R$</th>					
										
										<?php
										$contar = 1;
										while (($contar <= $qtd_presentes) || $contar == 30) 
										{
										?>
										<tr>
										<td>
										<?php  $nome = 'nome'.$contar ?>										
										<input id="name" name="<?php echo $nome ?>" placeholder= "<?php echo $nome ?>" />										
										</td>
										<td>
										<?php  $Codigo = 'Codigo'.$contar ?>
										<input id="Codigo" name="<?php echo $Codigo ?>" placeholder= "<?php echo $Codigo ?>" />										
										</td>
										<td>
										<?php  $Protocolo = 'Protocolo'.$contar ?>
										<input id="Protocolo" name="<?php echo $Protocolo ?>" placeholder= "<?php echo $Protocolo ?>" />
										</td>
										<td>
										<?php  $valorPre = 'valorPre'.$contar ?>
										* R$ <input name="<?php echo $valorPre ?>"  />
										</td>
										</tr>
										
										
										<?php
										$contar = $contar+1;
										if($contar == 31) exit;
										}
									?>
									<tr> <td></td> <td></td> <td>VALOR TOTAL</td> <td>
									<span class="style1">* R$ </span>
							<input name="valtotal" readonly><br>
							</td> 
									</tr>
							</table>
                            


							<input type="button" onclick="soma()" value="Somar Valores" background-color= "#133141" color= "#FFF">
                            <?php
								}
							?>
    	
							<p class="variaveis"><!--Campo fica em oculto apenas para guardar o indicador da tabela "congregacao"-->
								
							<input name ="qtd_presentes"  type="hidden" value="<?php echo $qtd_presentes ?>"/>
							<input name ="id_caixa"  type="hidden" value="<?php echo $id_caixa ?>"/>
							<input name ="tipoCont"  type="hidden" value="<?php echo $tipContNome?>"/>
							<input name ="cod_Comp"  type="hidden" value="<?php echo $cod_Comp ?>"/>	
							<input name ="cod_Ass"  type="hidden" value="<?php echo $cod_Ass ?>"/>	
							<input name ="numeroDoc"  type="hidden" value="<?php echo $numeroDoc ?>"/>	
							<input name ="numDocFiscal"  type="hidden" value="<?php echo $numDocFiscal ?>"/>						
							<input name="razaoSoc" type="hidden"  value="<?php echo $razaoSoc ?>"/>
							<input name ="valorFin"  type="hidden" value="<?php echo $valorFin ?>"/>
							<input name ="data"  type="hidden" value="<?php echo $data ?>"/>	
							<input name ="ent_Sai"  type="hidden" value="<?php echo $ent_Sai ?>"/>	
							<input name ="id_fin"  type="hidden" value="<?php echo $id_fin ?>" />
							<input name ="tipoPag"  type="hidden" value="<?php echo $tipoPag ?>" />
							<input name ="saldo_Final"  type="hidden" value="<?php echo $saldo_Final ?>" />
							<input name ="diaUm_mêsAtual"  type="hidden" value="<?php echo $diaUm_mêsAtual ?>" />
							<input name ="dataUlt_saldo"  type="hidden" value="<?php echo $dataUlt_saldo ?>" />
							<input name ="cadastrante"  type="hidden" value="<?php echo $cadastrante ?>"/>	
                           
							<input name ="saldo_AtualConsult"  type="hidden" value="<?php echo $saldo_Atual ?>" />
														
							</p>
                            <?php  
                               }
                            // unset($_SESSION['tid_caixa']);
                              ?>
                                   
								
								<p class="submit"align="center">        
									<input type="submit"value="SALVAR" colspan="2"/>  
								</p>	
																
						
									
								
					</form>	
			<div id="blRodape"> 
			<h1>Utilidade pública federal<text-align=center/h1>					
			</div>  
		</div>
			
	</body>
</html>