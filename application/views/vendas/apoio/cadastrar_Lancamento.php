<html>
	<head>
		<title>Lançamento</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<link rel="stylesheet" href="styles.css" media="all" />				
	</head>
	<body>
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
			
		  
					require_once 'funcao.php';
					?>	
				</div>  		
				<h1>SISCOF - Registro do Lançamento<text-align=center></h1>  	
			</div> 	
			
			 	
						
				<?php
				
				require_once 'conexao.class.php';
				require_once 'inserir.class.php';

					$con = new Conexao();
					$con->connect(); $conex = $_SESSION['conex']; 
                    $opcao= $_POST["op"];
                    $cad= $_POST["cad"];					
                    $entrada_Saida = $_POST["ent_Sai"];
					$entrada_S = "PaginaLancamento1.php";
					if($entrada_Saida == "1" && $_POST["cod_Comp"] <> "R01-020") { $entrada_S = "PaginaEntrada.php"; }else
					if($entrada_Saida == "0" && $_POST["cod_Comp"] <> "D06-010") $entrada_S = "PaginaSaida.php";
					if($entrada_Saida == "1" ) { $p_Origem = "PaginaEntrada2.php"; }else
					if($entrada_Saida == "0" ) $p_Origem = "PaginaSaida2.php";
					
				?>
			<form action="<?php echo $entrada_S ?>" method="post" name = "formulario" onsubmit="validaForm(); return false;" class="form">
												
				<?php	
				if($cad== 'aenpfin')
					{
						$caixa = $_POST["id_caixa"];
						$tipoCont	= $_POST["tipoCont"];								
						$cod_assoc = $_POST["cod_Ass"];
						$cod_compassion = $_POST["cod_Comp"];
						$num_Doc= $_POST["numeroDoc"];
						$numDocFiscal= $_POST["numDocFiscal"];
						$razaoSoc	= $_POST["razaoSoc"];
						$descri	= $_POST["descri"];
						$dataF	= $_POST["data"];
						$dataF= implode('-',array_reverse(explode('/',$dataF)));
						$saldo_Final	= $_POST["saldo_Final"];
						$saldo_Final =  number_format(str_replace(",",".",$saldo_Final ),2, ".", "");//colocar float verificar
                        $diaUm_mêsAtual	= $_POST["diaUm_mêsAtual"];
                        $valorFin	= $_POST["valorFin"];
                        if(isset($_POST["v_Valores"] )) {  $v_Valores = $_POST["v_Valores"];} 
						$tipo_Pag	= $_POST["tipoPag"];
                        $ent_Sai = $_POST["ent_Sai"];//Código para ENTRADA  é ( 1 ) para SAÍDA  é ( 0 )
						$cadastrante= $_POST["cadastrante"];
						$dia = date("Y-m-d");
						$entrada_Saida = $ent_Sai;
						$saldo_mes_lancamento = "S";
						$tip_Cont = $tipoCont;
						$contaX = $caixa;
						$saldo_AtualConsult = $_POST["saldo_AtualConsult"];
						$qtd_presentes= $_POST["qtd_presentes"];
                        if(isset($_POST["id_presentes"]))                  
						$id_presentes= $_POST["id_presentes"];	
                        if(isset(  $_POST["senhaAdm"] )) {  $senhaAdm = $_POST["senhaAdm"];} 
					
                   
                        $_SESSION['tid_caixa'] = $_POST["id_caixa"];
						$_SESSION['ttipoCont'] = $_POST["tipoCont"];								
						$_SESSION['tcod_Ass'] = $_POST["cod_Ass"];
						$_SESSION['tcod_Comp'] = $_POST["cod_Comp"];
						$_SESSION['tnumeroDoc'] = $_POST["numeroDoc"];
						$_SESSION['tnumDocFiscal'] = $_POST["numDocFiscal"];
						$_SESSION['trazaoSoc'] = $_POST["razaoSoc"];
						$_SESSION['tdescri'] = $_POST["descri"];
						$_SESSION['tdata'] = $_POST["data"];
						$_SESSION['tsaldo_Final'] = $_POST["saldo_Final"];
						$_SESSION['tdiaUm_mêsAtual'] = $_POST["diaUm_mêsAtual"];
						$_SESSION['tvalorFin'] = $valorFin;
						$_SESSION['ttipoPag'] = $tipo_Pag;
						$_SESSION['tent_Sai'] = $_POST["ent_Sai"];//Código para ENTRADA  é ( 1 ) para SAÍDA  é ( 0 )
						$_SESSION['tcadastrante'] = $_POST["cadastrante"];
						$_SESSION['tdiahoje'] = date("Y-m-d");
						$_SESSION['ttid_fin'] = $_POST["id_fin"];	
						$_SESSION['saldo_AtualConsult'] = $_POST["saldo_AtualConsult"];	
						$_SESSION['tqtd_presentes'] = $_POST["qtd_presentes"];	
                      if(isset($_POST["id_presentes"]))  
						$_SESSION['tid_presentes'] = $_POST["id_presentes"];	
                  
                    
                    $contar = 1;
							while (($contar <= $qtd_presentes) ) 
								{
									$nome = 'nome'.$contar;
									$Codigo = 'Codigo'.$contar;
									$Protocolo = 'Protocolo'.$contar;
									$valorPre = 'valorPre'.$contar;
									$_SESSION[$nome] = $_POST[$nome];
									$_SESSION[$Codigo]	= $_POST[$Codigo];								
									$_SESSION[$Protocolo] = $_POST[$Protocolo];
									$_SESSION[$valorPre] = $_POST[$valorPre];	
                                
									$contar = $contar+1;							
				
                                }
                    
						if(!$cod_assoc || !$cod_compassion)
						{ echo "Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
											Volte a pagina anterior e preencha todos os campos!";
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
											Volte a pagina anterior e preencha todos os campos! - Linha: ". __LINE__ . "\");
											</script>";						  
						 exit; 
						}
						// echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
												
						if(!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin )
                        {echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
						echo "<p><font color=red>Voce nao entrou com os dados necessarios.
								Você não informou todos os dados nescessário. Tente novamente!</font</p>";
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Você não informou todos os dados nescessário. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
						}	//URL=PaginaLancamento1.php
                        $datahj = date('Y-m-d');
							//echo $datahj;
						//	$dataF= implode('-',array_reverse(explode('/',$data)));
                                $data_001 =  primeiroDiaMes($datahj);								
								$data_007 =  setimoDiadoMes($datahj);
                    if(($datahj > $data_007) && ($dataF < $data_001) && ($senhaAdm <> "aenp@z18"))
								{echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lançamento referente ao mês anterior aspirado. <br/> 
								Retorne e altere a data ou contate o administrador.</font><br/>";
                                 echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Prazo Limite para lançamento referente ao mês anterior aspirado, tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
                                }
                                 
                                 
							if($dataF < "2010-01-01" || $dataF > $datahj )
								{
									echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
								 echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" A data não é uma data válida, tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
								}
                 //   echo "</b></br> Valor recebdo <strong><td> R$  ".$valorFin."</td></strong></br>";            
                       
                    //Verifica se o valor foi digitado adequadamente.
						 if(formatoRealPntVrg($valorFin) == true) 
                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                       //serve pra validar  valores acima e abaixo de 1000
                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    $valorFin;   
                       $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                   }else if(formatoRealInt($valorFin) == true)
                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                       //serve pra validar  valores acima e abaixo de 1000
                       //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
                   }else if(formatoRealPnt($valorFin) == true)
                   { 
                       //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                       $valorFin  =    $valorFin;
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                   }else if(formatoRealVrg($valorFin) == true)
                   { 
                     //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                   }else
                   {
                       echo "O valor digitado não esta nos parametros solicitados";
                              echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
                            
						  
                   }
                    /*    echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>";        
                        echo "</b></br> Valor p/ Exibir <strong><td> R$  ".$valorFinExibe."</td></strong></br>";
                       echo "</b></br> Valor p/ Guardar <strong><td> R$  ".$valorFin."</td></strong></br>";            
                          ECHO "</b> formato para o bd <strong><td> ", number_format(str_replace(",",".",$valorFin ),2, ".", ""),"</td></strong></br>";   */ 
								 
						
						if($cod_compassion == ( "R01-020") )//Entrada com presentes especiais
						{
							$contar = 1;
                            $valorFinTotal =   "0.00";
							while (($contar <= $qtd_presentes) ) 
								{
									$n_nome = 'nome'.$contar;// Nomes das variaveis de cada cadastro
									$n_codigo = 'Codigo'.$contar;
									$n_protocolo = 'Protocolo'.$contar;
									$n_valorPre = 'valorPre'.$contar;
                                
									$nome = $_POST[$n_nome];
									$Codigo	= $_POST[$n_codigo];								
									$Protocolo = $_POST[$n_protocolo];
									$valorPre = $_POST[$n_valorPre];								
									if( !$nome  || !$Codigo  || !$Protocolo  || !$valorPre  )
									{				echo "Algum campo do ".$contar."º Prsente da lista não foi preenchido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
                                     
									   echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
														<script type=\"text/javascript\">
														alert(\"Algum campo do ".$contar."º Prsente da lista não foi preenchido.Volte a pagina anterior e preencha todos os campos! Linha: ". __LINE__ . "\");
														</script>";	
                                     
									 exit; 
									}	
                                
                               
                                    formatoValor == true;
                                 if(formatoRealPntVrg($valorPre) == true) 
                                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                       //serve pra validar  valores acima e abaixo de 1000
                                       //      echo "Ponto e virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPreExibe  =    $valorPre;   
                                       $valorPre  =    (str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else if(formatoRealInt($valorPre) == true)
                                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                       //serve pra validar  valores acima e abaixo de 1000
                                       //      echo "Inteiro!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                      $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                       $valorPre  =    number_format(str_replace("." , "" ,$valorPre), 2, '.', '');
                                   }else if(formatoRealPnt($valorPre) == true)
                                   { 
                                       //     echo "Ponto!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPre  =    $valorPre;
                                       $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                   }else if(formatoRealVrg($valorPre) == true)
                                   { 
                                        //    echo "Virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                       $valorPre  =   (str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else
                                   {
                                       formatoValor == false;
                                   }
                                
                                
									if($valorPre <= 0 )
									{				echo "Verifique o valor do  ".$contar."º Prsente é inválido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
									  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
														<script type=\"text/javascript\">
														alert(\"Verifique o valor do  ".$contar."º Prsente é inválido. Volte a pagina anterior e preencha todos os campos!\");
														</script>";						  
									 exit; 
									}
                                 
									$valorFinTotal = $valorFinTotal + $valorPre;
                                    echo "presente ".$contar."  = R$ <strong>".$valorPreExibe."</strong><br>";
									$contar = $contar+1;	
								}
                            $val_Total = $valorFinTotal;
                          
							$valorTotExibe  =    number_format(str_replace(",",".",$val_Total), 2, ',', '.');		
                       //     echo  "<br><font color = #0cb20c size = 2> Verificar valor =  ".$v_Valores;// variavel pra não cadastrar e voltar
                            echo "<br><font color = red size = 2> Soma Total =  R$ <strong>".$valorTotExibe."</strong></font><br><br>";
                        //    echo gettype($valorFinTotal), "<br>";
                            echo "<font color = red size = 2>Valor lançado =  R$ <strong>".$valorFinExibe."</strong></font><br><br>";
                           // echo gettype($valorFin), "<br>";
                             
                            if( ($valorFin !==  $val_Total) )
                        	 echo "<font color = red size = 2>Valor lançado é diferente do somatório</strong></font><br><br>";
                            
                            
                            if(formatoValor == false)
                            {
                             echo "Um ou mais valores inseridos não esta nos parametros solicitados";
                              echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Um ou mais valores inseridos não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						      exit;
                            }
							if($qtd_presentes > 0 )
							{
							}else{				echo "Não há presentes especiais.
												Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
							  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
												<script type=\"text/javascript\">
												alert(\"Não há presentes especiais.	Volte a pagina anterior e preencha todos os campos! <br>Linha: ". __LINE__ . "\");
												</script>";						  
							 exit; 
							}
                            
                             if($v_Valores == "1")                                
                            {
							if( ($valorFin !==  $val_Total) )
                        	{
                               
                                echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=".$p_Origem."'> 
												<script type=\"text/javascript\">
												alert(\"Verifique se o somatório  é igual ao valor total do lançamento. Preencha todos os campos! - Linha: ". __LINE__ . "\");
												</script>";						  
							 exit; 
							}}
                            
                            
						}	
//*****se for presente especial faz um lançamento 
						if($cod_compassion == ( "D06-010"))//Saída com presentes especiais
						{
						//	echo 'linha '. __LINE__;
							if(!$id_presentes)//Saída com presentes especiais
							{						
							//echo "cod_compassion: ".$cod_compassion." qtd_presentes: ".$qtd_presentes."<br>";
							echo "Linha: ". __LINE__ . "<br>Nenhum Beneficiário foi selecionado para este presente especial.
												Volte a pagina anterior e preencha todos os campos!";
							  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos! Linha: ". __LINE__ . "\");
											</script>";						  
							 exit; 
							}	
							if($id_presentes == 0 ) 
								{	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=".$p_Origem."'> 
												<script type=\"text/javascript\">
												alert(\"Desculpe, Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos!\");
												</script>";			
										exit;
								}
                          
								$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado o ultimo registro. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");
											exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	echo "Nao foi encontrado nenhum ultimo registro. Tente novamente!"; //exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
								{	$id_Maxaenp = $id_ultimo['id_fin'] +1; }
							
								$presentes_saida = mysqli_query($conex, 'SELECT * FROM presentes_especiais
													WHERE  id_presente =  '.$id_presentes.' LIMIT 1');
								if (!$presentes_saida  ) 
								{			die ("<center>Desculpe, Nao foi encontrado o registro de presente ".$id_presentes.". Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");											
								}	
								if (mysqli_num_rows($presentes_saida) == 0 ) 
									{	echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";exit;
									}							
								
								while ($rows_presentes = mysqli_fetch_assoc($presentes_saida)) 
								{							
									  if ( $valorFin > $rows_presentes['valor_pendente'] + 1.5)
								        {echo "Linha: ". __LINE__ . "<br>Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento!";
                                          echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento! Linha: ". __LINE__ . "\");
											</script>";	
                                        		
										exit;
                                
                                        }
                                    
                                    
                                    $val_Restante = $rows_presentes['valor_pendente'] - $valorFin;
									
									$upd = "UPDATE presentes_especiais 
									SET id_saida = '".$id_Maxaenp."',data_presente= '".$dataF."',valor_saida = '".$valorFin."',valor_pendente = '".$val_Restante."'
									WHERE (id_presente =  ".$rows_presentes['id_presente'].")";
												$atualiz = mysqli_query($conex, $upd);
												if ($atualiz) 
												{/*
												echo "<META HTTP-EQUIV=REFRESH CONTENT='0;'>
												<script type=\"text/javascript\">
												alert(\"Atualização de registro de presente especial realizada com sucesso.\");
												</script>";		*/						
												}else {
													die ("<center>Desculpe, Erro na atualização.:  " 
													. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
													<a href='menuF.php'>Voltar ao Menu</a></center>");	exit;												
													}
												$id_entrada = $rows_presentes['id_entrada'];
												$data_presente = $rows_presentes['data_presente'];
												$n_beneficiario = $rows_presentes['n_beneficiario'];
												$nome_beneficiario = $rows_presentes['nome_beneficiario'];
												$n_protocolo = $rows_presentes['n_protocolo'];
												$valor_entrada = $rows_presentes['valor_entrada'];
								}			
									if($val_Restante > 0 )
									{
										$crud = new Inserir('presentes_especiais');				
										$crud->inserir("id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario,
                                        n_protocolo, valor_entrada, valor_pendente", 
										"'','$id_entrada','$id_saida','$data_presente','$n_beneficiario','$nome_beneficiario','$n_protocolo',
										'$valor_entrada','$val_Restante'"); 
                                        
                                      //  $razaoSoc = $razaoSoc." - ".$n_beneficiario;
									}
						}
					//	 	if(!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin )
                       // {//echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
			/*		echo "<p><font color=red>Voce nao entrou com os dados necessarios.
								Você não informou todos os dados nescessário. Tente novamente!</font</p>";
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" OK. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
						echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
						exit;	*/ 
							
						$crud = new Inserir('aenpfin');				
						$crud->inserir("id_fin, conta,tipo_Conta,cod_compassion,cod_assoc,num_Doc_Banco,num_Doc_Fiscal,
						historico,	descricao, dataFin,	valorFin,	ent_Sai, 	saldo,		saldo_Mes, cadastrante", 
						"'','$caixa','$tipoCont','$cod_compassion','$cod_assoc','$num_Doc','$numDocFiscal',
						'$razaoSoc','$descri','$dataF','$valorFin','$ent_Sai','$saldo_Final','$saldo_mes_lancamento','$cadastrante'"); 
						
//******busca do ultimo registro com o saldo do mês marcado *********
						$sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2017-01-01" and 
											conta = '.$caixa.'  and tipo_Conta = "'.$tipoCont.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
						$result_Saldo_Atual = mysqli_query($conex, $sql_Saldo_Atual );
						if (!$result_Saldo_Atual) 
							{
										die ("<center>Desculpe, erro na busca de saldo atual.:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
											//exit;
							}
						if (mysqli_num_rows($result_Saldo_Atual) == 0  ) 
						{
							echo "Nao existem lançamentos</br>";
						   
						}		
						while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Atual)) 
						{//ID, valor do saldo e a data do registro com o ultimo saldo marcado
							$id_Ultimo_Saldo = $row_Saldo['id_fin']; 
							$saldo_Atual = $row_Saldo['saldo']; 	
							$dataUlt_saldo = $row_Saldo['dataFin'];
												
						}
//*****se pagamento for em cheque faz um lançamento de reconciliação bancária
						
						if($tipo_Pag == "cheque") 
						{	$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
							if (!$res_max  ) 
							{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										//exit;
							}
							if (mysqli_num_rows($res_max ) == 0 ) 
							{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
							}
							while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
							{	$id_Maxaenp = $id_ultimo['id_fin']; }
						
							$data_Pag = $dataF;
							//$id_Maxaenp = $id_Maxaenp + 1;//guarda o id do registro atual pra referenciar o id do cheque
                         //Ja marca se o cheque ja foi compensado
                         if(isset($_POST["chequeCompen"])) { $status = 1;} else $status = 0;
                         
							$crud = new Inserir('reconc_bank');				
							$crud->inserir("id_reconc, id_aenp, data_Pag, status, operador", 
							"'','$id_Maxaenp','$data_Pag','$status','$cadastrante'"); 							
						}
						

//*****se for presente especial faz um lançamento 
											
						if($cod_compassion == ( "R01-020"))//Entrada com presentes especiais
						{	$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
							if (!$res_max  ) 
							{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										//exit;
							}
							if (mysqli_num_rows($res_max ) == 0 ) 
							{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
							}
							while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
							{	$id_Maxaenp = $id_ultimo['id_fin']; }
						
						 	$contar = 1;
							while (($contar <= $qtd_presentes) || $contar == 50) 
							{
								
								
                                $n_nome = 'nome'.$contar;// Nomes das variaveis de cada cadastro
								$n_codigo = 'Codigo'.$contar;
								$n_protocolo = 'Protocolo'.$contar;
								$n_valorPre = 'valorPre'.$contar;
                                									
                                $nome = $_POST[$n_nome];
								$Codigo	= $_POST[$n_codigo];								
								$Protocolo = $_POST[$n_protocolo];
								$valorPre = $_POST[$n_valorPre];	
                              							
								$data_presente = $dataF;
                                
                                
                                 if(formatoRealPntVrg($valorPre) == true) 
                                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                       //serve pra validar  valores acima e abaixo de 1000
                                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                        $valorPre  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else if(formatoRealInt($valorPre) == true)
                                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                       //serve pra validar  valores acima e abaixo de 1000
                                      //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                        $valorPre  =    number_format(str_replace("." , "" ,$valorPre), 2, '.', '');
                                   }else if(formatoRealPnt($valorPre) == true)
                                   { 
                                       //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                       $valorPre  =    $valorPre;
                                 }else if(formatoRealVrg($valorPre) == true)
                                   { 
                                     //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                       $valorPre  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }
                                
                                
                                
                                
								$crud = new Inserir('presentes_especiais');				
								$crud->inserir("id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo,
                                valor_entrada, valor_pendente", 
								"'','$id_Maxaenp','$id_saida','$data_presente','$Codigo','$nome','$Protocolo', '$valorPre', '$valorPre'"); 
													
										
								$contar = $contar+1;							
							}
						}	
// ******* Se a data do ultimo saldo for maior que a do lançamento altera todos saldos posteriores			
						//$saldo_mes_lancamento = "S";
						//if( $dataF < $dataUlt_saldo)
					 //	{**** primeiro dia do mês do lançamento
							$dia_1_mes = primeiroDiaMes($dataF);
						//	$saldo_mes_lancamento = "N";
	//******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********						
							$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin < "2017-01-01" and
											conta = '.$caixa.'  and tipo_Conta = "'.$tipoCont.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';	
                    /*
							$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2017-01-01" and dataFin < "'.$dia_1_mes.'" and
											conta = '.$caixa.'  and tipo_Conta = "'.$tipoCont.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';	
                    */	
						$result_saldo_Penultimo = mysqli_query($conex, $saldo_Penultimo);
						if (!$result_saldo_Penultimo) 
							{				die ("<center>Desculpe, erro na busca de saldo atual.:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
											//exit;
							}
						if (mysqli_num_rows($result_saldo_Penultimo) == 0  ) 
							{	echo "Nao existem lançamentos</br>";}		
						while ($row_saldo_Penultimo = mysqli_fetch_assoc($result_saldo_Penultimo)) 
						{//ID, valor do saldo e a data do registro com o penultimo saldo marcado
							$id_saldo_Penultimo = $row_saldo_Penultimo['id_fin']; 
							$saldo_Penultimo = $row_saldo_Penultimo['saldo']; 	
							$data_saldo_Penultimo = $row_saldo_Penultimo['dataFin'];
												
						}
//******busca de todos registro, após o penultimo saldo *********						
									$maisRecentes = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, dataFin, ent_Sai, valorFin, saldo FROM aenpfin 
															WHERE  dataFin > "'.$data_saldo_Penultimo.'" 
															and conta like "'.$caixa.'" and tipo_Conta like "'.$tipoCont.'" 
															ORDER BY dataFin, id_fin ');
								if (!$maisRecentes) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menuF.php'>Voltar ao Menu</a></center>");
											//exit;
								}
								if (mysqli_num_rows($maisRecentes) == 0 ) 
								{	echo "Nao foi encontrado nenhum registro após o penultimo saldo. Tente novamente!";
								}								
	//inicia variavel do dia final do mes do registro anterior com o dia fim do mês do lançamento								
								$fim_mes = ultimoDiaMes($dataF);
								
								$s_anterior =	$saldo_Penultimo;
								while ($maisRecent = mysqli_fetch_assoc($maisRecentes)) 
								{	
									//if ($maisRecent['dataFin'] > $dataF) 
									//{
										$ent_Sai = $maisRecent['ent_Sai'];
										if ($ent_Sai == 0) {
										$s_Atual = $s_anterior - $maisRecent['valorFin'];//$valorFin;
										}else if ($ent_Sai == 1){
											$s_Atual = $s_anterior + $maisRecent['valorFin'];
										}										
											$upd = "UPDATE aenpfin SET saldo = ".$s_Atual." WHERE (id_fin =  ".$maisRecent['id_fin'].")";
											$atualiz = mysqli_query($conex,$upd);
											if ($atualiz) 
											{
											/*echo "<META HTTP-EQUIV=REFRESH CONTENT='0;'>
											<script type=\"text/javascript\">
											alert(\"Atualização de saldo realizada com sucesso.\");
											</script>";	*/							
											}else {
												die ("<center>Desculpe, Erro na atualização.:  " 
												. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
												<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
												}					
									//}
									$s_anterior =	$s_Atual;
									$d_anterior = $dataX;
									$dataX = $maisRecent['dataFin'];
									$data_ultimo_dia = ultimoDiaMes($dataX);//inicia variavel do dia final do mes do registro atual
									
									if(!$id_anterior)
									{ //echo "inicio. ";
										//Verifica se o registro  a ser cadastrado é o ultimo do seu mês para marcar
										//if($dataX > $fim_mes ){ $saldo_mes_lancamento = "S";}										
									}else
									{							
										if($dataX > $fim_mes)
										{	$saldo_mes = "S";// Marca se for o ultimos registro de saldos de cada mes 
										}else $saldo_mes = "N";
										
											$upd = "UPDATE aenpfin SET saldo_Mes = '".$saldo_mes."' WHERE (id_fin =  ".$id_anterior.")";
											$atualiz = mysqli_query($conex, $upd);
											if ($atualiz) {
											/*echo "<META HTTP-EQUIV=REFRESH CONTENT='0;'>
											<script type=\"text/javascript\">
											alert(\"Atualização de saldo realizada com sucesso.\");
											</script>";	*/							
											}else {
											die ("<center>Desculpe, Erro na atualização.:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
											<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
											}										
									}
									if(	$saldo_mes == "S") $s_mes = "| Saldo do mês.";
									echo '<font color=red size="2"> Conta '.$maisRecent['conta'];
									echo ' | Tipo '.$maisRecent['tipo_Conta']. ' | Data </font> <font color=green>'.$d_anterior. ' </font> <font color=red>
									| Registro '.$id_anterior. ' | Saldo alterado para '.$s_Atual. '  
									'.$s_mes. ' <td></font><br />';	
									/*echo '<font color=red size="2"> Conta '.$maisRecent['conta'];
									echo ' | Tipo '.$maisRecent['tipo_Conta']. ' | Data </font> <font color=green>'.$dataX. ' </font> <font color=red>
									| Ultimo dia mês '.$data_ultimo_dia. ' | Valor '.$maisRecent['valorFin']. '  
									| Ultimo dia Reg anterior'.$fim_mes. ' | id anterior '.$id_anterior. '  
									| SaldoMes '.$saldo_mes.'| Saldo '.$maisRecent['saldo'].'<td></font><br />';	
									*/
									$id_anterior = $maisRecent['id_fin'];
									$fim_mes = $data_ultimo_dia;
								}
								//$caixa $tipoCont $entrada_Saida
								/* switch ($tipo_Cont) 
									{
										
										case "Suporte": $tip_Cont = "1";	break;    
										case "Corrente":$tip_Cont = "2";	break;    
										case "Poupança":	$tip_Cont = "3";	break;  
										case "Investimento": $tip_Cont = "4";	break;				
									}*/
									$_SESSION['tE_S_N'] = $entrada_S;
									$_SESSION['tE_S'] = $entrada_Saida;
									$_SESSION['t_Cont'] = $tip_Cont;
									$_SESSION['Cont'] = $contaX;
								echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$entrada_S."'>
											<script type=\"text/javascript\">
											alert(\"Alterações realizada com sucesso. Novo lançamento. \");										
											</script>";	
									//		formulario.submit();
									//		</script>";	
					}
				 $con-> disconnect();
				 
				?>			
						<!--	<input name ="tipCont"  type="text" value="<?php // echo $t_Cont?>"/>
							<input name ="conta"  type="text" value="<?php // echo $contaX ?>"/>
						-->	<input name ="termop" type="hidden" value="a" />								
							<input name ="tipop" type="hidden" value="nome" />
							<input name ="tipoES" type="hidden" value="entrada" />
							<input name ="tipoConsulta"  type="hidden" value="0" />
							<input name ="cadastrado"  type="hidden" value="sim"  />
					<!--		
					<p class="submit"align="center">
					<input type="submit" value="Novo lançamento"  colspan="2"/>					
					</p>-->
			</form>			
				
			
		</div> 			
		<div id="blRodape">  	

			<h1>Utilidade pública federal<text-align=center/h1>
		</div> 
		
	</body>
</html>



