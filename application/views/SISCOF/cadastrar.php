<html>
	<head>
		<title>Cadastro de usuári</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<link rel="stylesheet" href="styles.css" media="all" />				
	</head>
	<body >
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
						case 4:	$caixaNome = "BR518"; break;  
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
				<h1 text-align=center>SISCOD - Cadastro de operadores do sistema</h1>  	
			</div> 	
			<div id="blMenu">  	
			<?php
			include"menuFLateral.html";
			?>			
			</div> 	
			<div id="blCorpo">  	
			<form action="PaginaTentarCad.php" method="post" onsubmit="validaForm(); return false;" class="form">
						
				<?php

				require_once 'conexao.class.php';
				require_once 'inserir.class.php';

					$con = new Conexao();
					$con->connect(); $conex = $_SESSION['conex']; 
					$opcao= $_POST["op"];
					$cad= $_POST["cad"];
					
				if($cad== 'aenpfin')
					{
							$caixa = $_POST["id_caixa"];
							$tipoCont	= $_POST["tipoCont"];								
							$cod_assoc = $_POST["cod_Ass"];
							$cod_compassion = $_POST["cod_Comp"];
							$num_Doc= $_POST["numeroDoc"];
							$numDocFiscal= $_POST["numDocFiscal"];
							$historico	= $_POST["hist"];
							$tipoPag	= $_POST["tipoPag"];
							$dataF	= $_POST["data"];
							$dataFin= implode('-',array_reverse(explode('/',$dataF)));
							$id_fin	= $_POST["id_fin"];//Id do registro com o ultimo saldo pra ser desmarcado quando cadastrar
							$saldo_Final	= $_POST["saldo_Final"];
							$diaUm_mêsAtual	= $_POST["diaUm_mêsAtual"];
							$dataUlt_saldo	= $_POST["dataUlt_saldo"];
							$valorFin	= $_POST["valorFin"];
							$tipo_Pag	= $_POST["tipoPag"];
							//$valor = number_format($valor, 2, '.', '')
							$valorFin =  number_format(str_replace(",",".",$valorFin ),2, ".", "");
							//$valor = str_replace(".","",$valor); tira os pontos(.) caso o usuário tenha colocado. Ex: "1.000" fica assim "1000" 
							// $valor = str_replace(",",".",$valor );troca a vírgula(,) decimal pelo ponto(.). Ex.: "1000,00" fica assim "1000.00"// aí insere no BD
							// Depois pra mostrar $valor = number_format($valor,2,",",".");// Ficaria assim: "1.000,00" no formato brasileiro
							$ent_Sai = $_POST["ent_Sai"];//Código para ENTRADA  é ( 1 ) para SAÍDA  é ( 0 )
							$cadastrante= $_POST["cadastrante"];
							$dia = date("Y-M-D");
							//*****se pagamento for em cheque faz um lançamento de reconciliação bancária
							if($tipo_Pag == "cheq") 
							{	$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
												<a href='menu1.php'>Voltar ao Menu</a></center>");
												exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
								{	$id_Maxaenp = $id_ultimo['id_fin']; }	
								$data_Pag = $dataF;
								
								
								$crud = new Inserir('reconc_bank');				
								$crud->inserir("id_reconc, id_aenp, data_Pag, operador", 
								"'','$id_Maxaenp','$data_Pag','$cadastrante'"); 
								
							}
				// ******* Se a data do ultimo saldo for do mês anterior altera a indicação de saldo atual do registro anterior para "N" negativo			
								if($dataUlt_saldo >= $diaUm_mêsAtual)
								{	$up = "UPDATE aenpfin SET saldo_Mes = 'N' WHERE (id_fin=  ".$id_fin.")";
									$atualiza = mysqli_query($conex, $up);
									if ($atualiza) echo "<META HTTP-EQUIV=REFRESH CONTENT='0;'>
											<script type=\"text/javascript\">
											alert(\"Alteracao realizado com sucesso.\");
											</script>";									
													else {
												die ("<center>Desculpe, Nao existem lançamentos a menos de dois meses.:  " 
													. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
														<a href='menuF.php'>Voltar ao Menu</a></center>");													
												}	
								}
						
								$crud = new Inserir('aenpfin');				
								$crud->inserir("id_fin, conta,tipo_Conta,cod_compassion,cod_assoc,num_Doc_Banco,num_Doc_Fiscal,
								historico,	dataFin,	valorFin,	ent_Sai, 	saldo,		saldo_Mes, cadastrante", 
								"'','$caixa','$tipoCont','$cod_compassion','$cod_assoc','$num_Doc','$numDocFiscal',
								'$historico','$dataFin','$valorFin','$ent_Sai','$saldo_Final','S','$cadastrante'"); 
								
							
							echo "id aenp - ".$id_Maxaenp;								
							echo " - data - ".$data_Pag;	
					}else
					{
					if($cad== 'pedidos')
					{
							$codC= $_POST["termop"];
							$atend= $_POST["atendente"];		
							$cupom1= $_POST["cupom1"];		
							$cupom2= $_POST["cupom2"];
							$cupom3= $_POST["cupom3"];	
							$cupom4= $_POST["cupom4"];
							//Trata o formato DATE do php (d/m/Y)formatando para o DATE do MySql (Y-m-d)
							$dataPed= implode('-',array_reverse(explode('/',$_POST["dataPed"])));
							$valtotal= $_POST["valtotal"];
							$dia = date("Y-M-D");
							$crud = new Inserir('pedidos');				
							$crud->inserir("codP, codC,codF,cupom1,cupom2,cupom3,cupom4,valtotal,dataPed", 
							"'','$codC','$atend','$cupom1','$cupom2','$cupom3','$qcupom4','$valtotal','$dataPed'");  				
																	
						/*	$crud = new Inserir('pagamentos');		
							$crud->inserir("codPag,Valor,cartao,FormaPag,dataPag,horaIP", 
											"'','$codC','$cupom1','$cupom2','$dataPed','$qcupom4'"); 				
							*/				
					}else
					{
						if($cad== 'congregacao')
						{
								$nome= $_POST["name"];
								$area= $_POST["area"];
								$lograd= $_POST["lograd"];
								$bairro = $_POST["bairro"];
								$numero= $_POST["numero"];
								$campo= $_POST["campo"];
								$PontRef= $_POST["PntRef"];
								//$sabore= $_POST["sabor"];
								$sabores= '';
								$cidade= $_POST["cidade"];
								$atendente= $_POST["atendente"];
								if(!$nome ){
								  echo "<p><font color=red>Voce nao entrou com os dados necessarios.
								  Volte a pagina anterior e tente novamente</font</p>";		  
								  exit;  
								}
								$crud = new Inserir('congregacao');
								$crud->inserir("codC,nome,area,cidade,bairro,logradouro,numero,PontoRef,campo,atendente", 
								"'','$nome','$aea','$bairro','$lograd','$numero','$campo','$PontRef','$cidade','$atendente'");  
						}else
							{
								if ($cad== 'funcionarios')
								{
									$nome= $_POST["name"];			
									$fone= $_POST["foneF"];			
									$cidade= $_POST["cidade"];			
									$lograd= $_POST["lograd"];
									$bairro = $_POST["bairro"];		
									$numero= $_POST["numero"];		
									$sexo= $_POST["sexo"];
									$funcao= $_POST["funcao"];	
									$user= $_POST["user"];		
									$senha= $_POST["senha"];
									$senhac= $_POST["senhac"];	
									$conta_acesso= $_POST["conta_acesso"];
									$tipo_conta_acesso= $_POST["tipo_conta_acesso"];
									$nivel_acesso= $_POST["nivel_acesso"];
								?>			
									<p class="tabela"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
											<input name ="cad"  type="hidden" value="funcionarios" />
											<input name ="op"  type="hidden" value="opCad" />
											<input name ="name"  type="hidden" value="<?php echo $nome?>" />
											<input name ="foneF"  type="hidden" value="<?php echo $fone?>" />
											<input name ="cidade"  type="hidden" value="<?php echo $cidade?>" />
											<input name ="lograd"  type="hidden" value="<?php echo $lograd?>" />
											<input name ="bairro"  type="hidden" value="<?php echo $bairro?>" />
											<input name ="numero"  type="hidden" value="<?php echo $numero?>" />
											<input name ="sexo"  type="hidden" value="<?php echo $sexo?>" />
											<input name ="funcao"  type="hidden" value="<?php echo $funcao?>" />							
										</p>	
								<?php			
									if(!$senha && !$user)
									{
										$user=0;
										$senha= 0;
										$conta_acesso=0;
										$tipo_conta_acesso=0;
										$nivel_acesso=0;
										if(!$nome || !$fone || !$lograd || !$bairro || !$cidade || !$numero || !$sexo || !$funcao)
												{
												echo "<p><font color=red>Voce nao entrou com os dados necessarios.
												Volte a pagina anterior e preencha todos os campos</font</p>"; 
											}else
											{			
												$crud = new Inserir('funcionarios');									
												$crud->inserir("codF,nomeF,usuario,senha,fone,cidade,bairro,logradouro,numero,sexo,funcao, conta_acesso, tipo_conta_acesso, nivel_acesso", 
												"'','$nome','$user','$senha','$fone','$cidade','$bairro','$lograd','$numero','$sexo','$funcao','$conta_acesso','$tipo_conta_acesso','$nivel_acesso'");  
											}
									}
									else
									{	$cont=strlen($senha);
										if($cont>7&&$cont<11)
										{	
											if(preg_match('/[[:punct:]]/U',$senha)&&preg_match('/[[:alpha:]]/U',$senha)&&preg_match('/[[:digit:]]/U',$senha))
											{
												//Senha Válida
												if (($senha == $senhac)) 
												{
													if(!$nome || !$fone || !$lograd || !$bairro || !$cidade || !$numero || !$sexo || !$funcao || !$conta_acesso || !$tipo_conta_acesso || !$nivel_acesso)
													{
														echo "<p><font color=red>Voce nao entrou com os dados necessarios.
														Volte a pagina anterior e preencha todos os campos</font</p>";
														  
													}else
													{
														
														$crud = new Inserir('funcionarios');									
														$crud->inserir("codF,nomeF,usuario,senha,fone,cidade,bairro,logradouro,numero,sexo,funcao, conta_acesso, tipo_conta_acesso, nivel_acesso", 
														"'','$nome','$user','$senha','$fone','$cidade','$bairro','$lograd','$numero','$sexo','$funcao','$conta_acesso','$tipo_conta_acesso','$nivel_acesso'");  
													}										
												}else
												{
													echo "<p><font color=red>Senha Inválida, 
													Os campos senha e confirmação de 
													senha devem ser iguais, tente novamente </font</p>";
											
												}
											}else
											{
												//return 0; //Senha Inválida
												echo "<p><font color=red>Senha Inválida, 
												verifique se sua senha possui os críterios exigidos. Volte e tente novamente!</font</p>";
											
											}
										}else
										{	//return 0; //Senha Inválida
											echo "<p><font color=red>Senha Inválida, 
											sua Senha deve possuir de 8 e 10 caracteres!</font</p>";
											echo "<p><font color=red>Senha Inválida no tamanho. Volte e tente novamente!</font</p>";
											
										}	
										//echo return;
									}
								}else
								{
									if ($cad== 'idosos')
										{                                          
											$nomeI= $_POST["nomeI"];			
                                            $data_Nasc= $_POST["data_Nasc"];			
                                            $data_entrada= $_POST["data_entrada"];			
                                            $cpf_I= $_POST["cpf_I"];
                                            $rg_I = $_POST["rg_I"];		
                                            $status= $_POST["status"];		
                                            $sexo= $_POST["sexo"];
                                        ?>			
                                            <p class="tabela"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
                                            <input name ="cad"          type="hidden" value="idosos" />
                                            <input name ="op"           type="hidden" value="opCad" />
                                            <input name ="nomeI"        type="hidden" value="<?php echo $nomeI ?>" />
                                            <input name ="data_Nasc"    type="hidden" value="<?php echo $data_Nasc ?>" />
                                            <input name ="data_entrada" type="hidden" value="<?php echo $data_entrada ?>" />
                                            <input name ="cpf_I"        type="hidden" value="<?php echo $cpf_I ?>" />
                                            <input name ="rg_I"         type="hidden" value="<?php echo $rg_I ?>" />
                                            <input name ="status"       type="hidden" value="<?php echo $status ?>" />
                                            <input name ="sexo"         type="hidden" value="<?php echo $sexo ?>" />      	
                                           </p>	
                                        <?php
											if(!$nomeI || !$data_Nasc || !$data_entrada || !$cpf_I || !$rg_I || !$status || !$sexo)
											{
											  echo "<p><font color=red>Voce nao entrou com os dados necessarios.
											  Volte a pagina anterior e preencha todos os campos</font</p>";
											    
											}else{
											$crud = new Inserir('idosos');
												
											$crud->inserir("id_idoso,nomeI,data_Nasc,data_entrada,cpf_I,rg_I,sexo,status", 
												"'','$nomeI','$data_Nasc','$data_entrada','$cpf_I','$rg_I','$sexo','$status'"); 
										}
								}	
                                }
                        }	
					}
				 }
				 $con-> disconnect();
				 /*
				 
				$cep = '22710-045';
				$names = array('Diogo', 'Renato', 'Gomes', 'Thiago', 'Leonardo');
				$text = 'Lorem ipsum dolor sit amet, consectetuer adipiscing.';
				 
				// Validação de CEP
				$er = '/^(\d){5}-(\d){3}$/';
				if(preg_match($er, $cep)) {
					echo "O cep casou com a expressão.";
				}
				// Resultado: O cep casou com a expressão.
				 
				// Busca e substitui nomes que tenham "go", case-insensitive
				$er = '/go/i';
				$pregReplace = preg_replace($er, 'GO', $names);
				print_r($pregReplace);
				// Resultado: DioGO, Renato, GOmes, ThiaGO, Leonardo
				 
				// Busca e substitui nomes que terminam com "go"
				$er = '/go$/';
				$pregFilter = preg_filter($er, 'GO', $names);
				print_r($pregFilter);
				// Resultado: DioGO, ThiaGO
				 
				// Resgatar nomes que começam com "go", case-insensitive
				$er = '/^go/i';
				$pregGrep = preg_grep($er, $names);
				print_r($pregGrep);
				// Resultado: Gomes
				 
				// Divide o texto por pontos e espaços, que podem ser seguidos por espaços
				$er = '/[[:punct:]\s]\s* /';
				$pregSplit = preg_split($er, $text);
				print_r($pregSplit);
				// Resultado: Array de palavras
				 
				// callback, retorna em letras maiúsculas
				$callback = function($matches) {
					return strtoupper($matches[0]);
				};
				 
				// Busca e substitui de acordo com o callback
				$er = '/(.*)go$/';
				$pregCallback = preg_replace_callback($er, $callback, $names);
				print_r($pregCallback);
				// Resultado: DIOGO, Renato, Gomes, THIAGO, Leonardo
				*/
				?>			
					<p class="submit"align="center">
					<input type="submit" value="Tentar novamente"  colspan="2"/>					
					</p>
				</form>			
				
			</div> 
		</div> 			
		<div id="blRodape">  	

			<h1 text-align=center>Utilidade pública federal</h1>
		</div> 
		
	</body>
</html>



