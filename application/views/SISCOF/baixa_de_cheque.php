<?php

require_once 'conexao.class.php';

    $con = new Conexao();
   	$con->connect(); $conex = $_SESSION['conex']; 
	$cad= $_POST["cad"];
	
	
		if($cad== 'clientes')
		{
				$codC= $_POST["termo"];
				$nome= $_POST["name"];
				$fone= $_POST["fone"];
				$lograd= $_POST["lograd"];
				$bairro = $_POST["bairro"];
				$numero= $_POST["numero"];
				$sexo= $_POST["sexo"];
				$PontoRef= $_POST["PntRef"];
				$sabore= $_POST["sabores"];
				$RefriPref= $_POST["refri"];
				$atendente= $_POST["atendente"];
				
				
				if(!$nome || !$fone || !$lograd || !$bairro || !$numero || !$atendente || !$sabore){
				  echo "<p><b/><font color=red>Voce nao entrou com os dados necessarios.
				  Volte a pagina anterior e tente novamente</font</p>";		  
				  exit;  
				}				
				$up = "UPDATE clientes SET nome ='".$nome."',fone= '".$fone."',bairro = '".$bairro."', logradouro= '".$lograd."',
				numero= '".$numero ."', sexo = '".$sexo."', PontoRef = '".$PontoRef."', sabores = '".$sabore."', RefriPref = '".$RefriPref."' ,
				atendente = '".$atendente. "' WHERE (codC=  ".$codC.")";
		 
				
		}else
		{
		if ($cad== 'cod_Ass')
		{
				$id_fin	= $_POST["id_fin"];//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
				$saldo_Final	= $saldo_Atual - $valorFin;
				
				$codigo=$_POST["termo"];
				$codigo= $_POST["termo"];
				$nome= $_POST["descricao"];			
				$fone= $_POST["area"];			
				$cidade= $_POST["mov"];		
				if(!$codF || !$nome || !$fone || !$lograd || !$bairro || !$numero || !$sexo || !$funcao)
				{
				  echo "<p><font color=red>Voce nao entrou com os dados necessarios.
				  Volte a pagina anterior e preencha todos os campos</font</p>";
				  exit;  
				}
				$up = "UPDATE cod_Ass SET  area ='".$codigo."' ";
										 
		}
		else
		{
			if ($cad== 'funcionarios')
			{
				$codF= $_POST["termo"];
				$nome= $_POST["name"];			
				$fone= $_POST["foneF"];			
				$cidade= $_POST["cidade"];		
				$lograd= $_POST["lograd"];
				$bairro = $_POST["bairro"];		
				$numero= $_POST["numero"];		
				$sexo= $_POST["sexo"];
				$funcao= $_POST["funcao"];
				if(!$codF || !$nome || !$fone || !$lograd || !$bairro || !$numero || !$sexo || !$funcao)
				{
				  echo "<p><font color=red>Voce nao entrou com os dados necessarios.
				  Volte a pagina anterior e preencha todos os campos</font</p>";
				  exit;  
				}
				$up = "UPDATE funcionarios SET nomeF ='".$nome."',fone= '".$fone."',cidade= '".$cidade."',bairro = '".$bairro."', logradouro= '".$lograd."',
				numero= '".$numero ."', sexo = '".$sexo."', funcao = '".$funcao."' WHERE (codF=  ".$codF.")";
		 								 
				}
				else
				{
				if ($cad== 'aenpfin')
					{
						function ultimoDiaMes($newData){/* recebe uma data e retorna uma data com o ultimo dia do mês*/
					  /*Desmembrando a Data*/
					  list($newAno, $newMes,$newDia ) = explode("-", $newData);
					  return date("Y-m-d", mktime(0, 0, 0, $newMes+1, 0, $newAno));
					}
						function primeiroDiaMes($newData){
					  /*Desmembrando a Data*/
					  list($newAno, $newMes,$newDia ) = explode("-", $newData);
					  return date("Y-m-d", mktime(0, 0, 0, $newMes, 1, $newAno));
				   }/*
						if(!$nome || !$tipo || !$valor || !$cadastrante )
						{
						  echo "<p><font color=red>Voce nao entrou com os dados necessarios.
						  Volte a pagina anterior e preencha todos os campos</font</p>";
						  exit;  
						}
						*/
						
						$id_fin = $_POST["id_fin"];
						$conta = $_POST["conta"];
						$tipoCont	= $_POST["tipoCont"];								
						$cod_assoc = $_POST["cod_Ass"];
						$cod_compassion = $_POST["cod_Comp"];
						$num_Doc= $_POST["numeroDoc"];
						$numDocFiscal= $_POST["numDocFiscal"];
						$historico	= $_POST["hist"];
						$tipoPag	= $_POST["tipoPag"];
						$dataF	= $_POST["data"];
						$dataF= implode('-',array_reverse(explode('/',$dataF)));
						$valorFin	= $_POST["valorFin"];
						$valorFin =  number_format(str_replace(",",".",$valorFin ),2, ".", "");//colocar float verificar
						$ent_Sai = $_POST["ent_Sai"];//Código para ENTRADA  é ( 1 ) para SAÍDA  é ( 0 )
						$cadastrante= $_POST["cadastrante"];
						$tipoPag= $_POST["tipoPag"];
						$tip_PagAnt= $_POST["tip_PagAnt"];
						$dia = date("Y-m-d");
						
						$saldo_mes_lancamento = "S";
						//inseri o novo registro
						echo "Data ".$dataF;
						$up = "UPDATE reconc_bank SET 
						 conta= '".$conta."' ,tipo_Conta=  '".$tipoCont."'cod_compassion=  '".$cod_compassion."'
						cod_assoc=  '".$cod_assoc."'num_Doc_Banco=  '".$num_Doc."'num_Doc_Fiscal=  '".$numDocFiscal."'
						historico=  '".$historico."'	dataFin=  '".$dataF."'	valorFin=  '".$valorFin."'	ent_Sai=  '".$ent_Sai."' 
						saldo=  '".$saldo_Final."'		saldo_Mes=  '".$saldo_mes_lancamento."' cadastrante= '".$cadastrante."' 
						WHERE (id_fin=  ".$id_fin.")";									 
									

//******busca do ultimo registro com o saldo do mês marcado *********
						$sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2017-01-01" and 
											conta = '.$conta.'  and tipo_Conta = "'.$tipoCont.'"
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
						
						if($tip_PagAnt == 0  && $tipo_Pag == "cheq") 
						{							
							$status = 0;
							$crud = new Inserir('reconc_bank');				
							$crud->inserir("id_reconc, id_aenp, data_Pag, status, operador", 
							"'','$id_fin','$dataF','$status','$cadastrante'"); 							
						}else
						if($tip_PagAnt == 1  && $tipo_Pag == "trans"){
							// colocar comando de excluir
						}
// ******* Se a data do ultimo saldo for maior que a do lançamento altera todos saldos posteriores			
						//$saldo_mes_lancamento = "S";
						//if( $dataF < $dataUlt_saldo)
					 //	{**** primeiro dia do mês do lançamento
				 
							$dia_1_mes = primeiroDiaMes($dataF);
						//	$saldo_mes_lancamento = "N";
	//******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********						
							$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2017-01-01" and dataFin < "'.$dia_1_mes.'" and
											conta = '.$conta.'  and tipo_Conta = "'.$tipoCont.'"
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
															and conta like "'.$conta.'" and tipo_Conta like "'.$tipoCont.'" 
															ORDER BY dataFin, id_fin ');
								if (!$maisRecentes) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menuF.php'>Voltar ao Menu</a></center>");
											//exit;
								}
								if (mysqli_num_rows($maisRecentes) == 0 ) 
								{	echo "Nao foi encontrado nenhum registro após o penultimo saldo. Tente novamente!" . __LINE__ . "";
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
								echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaLancamento1.php'>
											<script type=\"text/javascript\">
											alert(\"Alterações realizada com sucesso. Novo lançamento.\");
											</script>";		
					
					
					
					
						
						
						
						
						
						
						
						}
						else
						{
							if ($cad== 'bairro')
								{
									$nome= $_POST["nameBairro"];
									$cadastrante = $_POST["cadastrante"];		
									
									if(!$nomeBairro || !$cadastrante )
									{
									  echo "<p><font color=red>Voce nao entrou com os dados necessarios.
									  Volte a pagina anterior e preencha todos os campos</font</p>";
									  exit;  
									}
									$up = "UPDATE bairro SET nomeBairro ='".$nome."', cadastrante= '".$cadastrante.")";									 
								}
						}		
				}
			}
		}
$atualiza = mysqli_query($conex, $up);
				if ($atualiza) echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=menuF.php'>
						<script type=\"text/javascript\">
						alert(\"Alteracao realizado com sucesso.\");
						</script>";
					
								else {
							die ("<center>Desculpe, Nao foi possivel atualizar o cadastro, tente novamente.:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									
									<a href='menuF.php'>Voltar ao Menu</a></center>");
									
									exit;
							}
 
 $con-> disconnect();
 
 
?>
