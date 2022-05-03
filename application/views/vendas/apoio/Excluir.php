<html>
	<head>
		<title>EXCLUIDO</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
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
				<h1>SISCOF - EXCLUIDO<text-align=center></h1>  	
			</div> 	

			<?php
			require_once 'conexao.class.php';
			require_once 'inserir.class.php';
			require_once 'funcao.php';

			$tipo = $_POST["tipop"];
			$termo = $_POST["termo"];
			$tabela = $_POST["cad"];
			//$tipoCons = $_POST["tipoConsulta"];
			date_default_timezone_set('America/Sao_Paulo');
			$con = new Conexao();
			$con->connect(); $conex = $_SESSION['conex']; 
				if($tabela == 'aenpfin')
				{	
					$justificativa	= $_POST["just"];
					$cont_caracter =strlen($justificativa);
					if(!$justificativa )
									{ echo "É nescessário preencher o campo justificativa para efetuar um exclusão.
														Volte a pagina anterior e preencha o campo!";
									  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaConsulta.php'>
														<script type=\"text/javascript\">
														alert(\"É nescessário preencher o campo justificativa para efetuar um exclusão.
														Volte a pagina anterior e preencha o campo!\");
														</script>";						  
									 exit; 
									}
					//echo "termo id_fin= ".$termo. '<br>Linha: ' . __LINE__;
					$sql = mysqli_query($conex, "SELECT * FROM aenpfin WHERE id_fin=".$termo." LIMIT 1 ");	
					$result = $sql;
						if (!$result  ) 
						{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente: Nada foi alterado! " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
						}
						if (mysqli_num_rows($result ) == 0 ) 
						{	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaConsulta.php'>
														<script type=\"text/javascript\">
														alert(\"O número de registro inserido não existe. Tente novamente!  Nada foi alterado!\");
														</script>";	
									exit;					
						}
									
						$operador = $_SESSION['usuarioID'];
											
						while ($row = mysqli_fetch_assoc($result)) 
						{	$id_fin = $row['id_fin']; 
							$conta = $row['conta']; 
							$tipo_Conta = $row['tipo_Conta']; 
							$cod_compassion = $row['cod_compassion']; 
							$cod_assoc = $row['cod_assoc']; 
							$ent_Sai = $row['ent_Sai']; 
							$num_Doc_Banco = $row['num_Doc_Banco']; 
							$num_Doc_Fiscal= $row['num_Doc_Fiscal']; 
							$historico = $row['historico']; 
							$dataF = $row['dataFin']; 
							$valorFin = $row['valorFin'];
							$cadastrante = $row['cadastrante']; 				
							$data_Esclusao = date('Y-m-d H:i');; 
						}
									 
								/*Verifica a existência de registro de cheque vinculado ao lançamento a ser excluido
								
								*/
										$result_chek = mysqli_query($conex, "SELECT id_reconc FROM reconc_bank WHERE id_aenp = ".$termo." LIMIT 1 ");
										if (!$result_chek  ) 
										{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
												. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
													<a href='menu1.php'>Voltar ao Menu</a></center>");
													//exit;
										}
										if (mysqli_num_rows($result_chek ) == 0 ) 
										{	echo "Nao foi encontrado nenhum cheque para esse lançamento!"; //exit;
										}
										if (mysqli_num_rows($result_chek ) == 1 ) 
										{						
											$sql_chek = mysqli_query($conex, "DELETE FROM reconc_bank WHERE id_aenp=".$termo);
											$result_chekDel = mysqli_query($conex, $sql_chek);								
											echo '<h2> O registro do cheque '.$num_Doc_Banco.' foi excluido com exito!</h2>';								
										}
					//	{**** Exclui o registro selecionado					
										$sql_del = mysqli_query($conex, "DELETE FROM aenpfin WHERE id_fin=".$termo);
											$result_del = $sql_del;
										
										echo '<h1>O registro '.$termo.' foi excluido com exito!</h1>';
										
							//	{**** Registro Excluido		
				//	{**** primeiro dia do mês do lançamento
										$dia_1_mes = primeiroDiaMes($dataF);
									//	$saldo_mes_lancamento = "N";
				//******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********						
										$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
														WHERE dataFin > "2017-01-01" and dataFin < "'.$dia_1_mes.'" and
														conta = '.$conta.'  and tipo_Conta = "'.$tipo_Conta.'"
														and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
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
																		and conta like "'.$conta.'" and tipo_Conta like "'.$tipo_Conta.'" 
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
														$atualiz = mysqli_query($conex, $upd);
														if ($atualiz) 
														{
														/*echo "<META HTTP-EQUIV=REFRESH CONTENT='0;'>
														<script type=\"text/javascript\">
														alert(\"Atualização de saldo realizada com sucesso.\");
														</script>";	*/							
														}else {
															die ("<center>Desculpe, Erro na atualização dos saldo do dia ".$maisRecent['dataFin'].".:  " 
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
				}
				else
					if($tabela == 'funcionarios')
				{
					$sqlc = "SELECT * FROM funcionarios WHERE codF = '$termo'";
					$resultc = mysqli_query($conex, $sqlc);
					while ($row = mysqli_fetch_assoc($resultc)) 
						{ 
						echo 'Funcionario  :'.stripslashes($row['nomeF']).'  <td><br />';
						echo 'Telefone  :'.stripslashes($row['fone']).'  <td><br />';	
						echo 'Endereco :'.stripslashes($row['logradouro']).', '.stripslashes($row['numero']).', '.stripslashes($row['bairro']).'  <td><br />';
						echo 'Funcao  :'.stripslashes($row['funcao']).'  <td><br />';
						}
					$sql = mysqli_query($conex, "DELETE FROM funcionarios WHERE codF='$termo'");
					$result = mysqli_query($conex, $sql)	;
				
					
					if (!$resultc) 
						{
									die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu.php'>Voltar ao Menu</a></center>");
										exit;
						}
					if (mysqli_num_rows($resultc) == 0) 
					{
						echo "Nao foi encontrado nenhum Item. Tente novamente!";
					   exit;
					}else
					echo '<h1>O cadastro acima foi excluido com exito!</h1>';
					$row = mysqli_fetch_assoc($resultc);
				}
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaConsulta.php'>
														<script type=\"text/javascript\">
														alert(\"Exclusão realizada com SUCESSO!\");
														</script>";	
				
			?>
		</div>
		
	</body>
</html>