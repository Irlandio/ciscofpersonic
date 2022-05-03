<html>
	<head>
		<title>Cadastro de usuÃ¡ri</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<link rel="stylesheet" href="styles.css" media="all" />				
	</head>
	<body >
		<div id="bloco">  	
		 	
		<form action="PaginaEditar1.php" method="post" onsubmit="validaForm(); return false;" class="form">
				
        <?php

require_once 'conexao.class.php';
require_once 'inserir.class.php';

    $con = new Conexao();
   	$con->connect(); $conex = $_SESSION['conex']; 
	$cad= $_POST["cad"];
	
	
		if($cad== 'clientes')
		{
			$pagina = "menuF.php";	
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
		if ($cad== 'reconc_bank')
		{				
				$pagina = "reconcilia_Bank.php";
				$dataPag= $_POST["dataPag"];
                if(!$dataPag) { $dataPag = date("Y-m-d"); }
                $qtdch= $_POST["qtdch"];   
				$n = 1;
            echo ' - '.$qtdch.' Cheques baixados com sucesso!';  //exit;
            
            while ($n <= $qtdch) 
                {                               
                $codigo= $_POST['cheque'.$n];            
                    
                
				$up = "UPDATE reconc_bank SET data_Pag = '".$dataPag."', status = 1  WHERE (id_aenp=  ".$codigo.")";
                if ($n < $qtdch){ $atualiza = mysqli_query($conex, $up);}
                ++$n;
				}						 
		}
		else
		if ($cad== 'cod_Ass')
		{
			$pagina = "menuF.php";	
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
				$pagina = "menuF.php";
                $codF= $_POST["termo"];
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
                
                {$tabela = "funcionarios";$tipo = "id_fin";$tipoCons = 11;}
                ?> 
                <p class="tabela"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
									<input name ="tipop"  type="hidden" value="<?php echo $tipo?>" />
							        <input name ="tipoConsulta"  type="hidden" value="<?php echo $tipoCons?>" />
									<input name ="tab"  type="hidden" value="<?php echo $tabela?>" />
									<input name ="termop"  type="hidden" value="<?php echo $codF?>" />
																		
				</p>
            <?php
               //     echo $tabela; exit;
              if(!$senha && !$user)
				{
				$user=0;
				$senha= 0;
				$conta_acesso=0;
				$tipo_conta_acesso=0;
				$nivel_acesso=0;
				if(!$codF || !$nome || !$fone || !$lograd || !$bairro || !$numero || !$sexo || !$funcao)
				{
				
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0;'>
						<script type=\"text/javascript\">
						alert(\"Voce nao entrou com os dados necessarios.Volte a pagina anterior e preencha todos os campos\");
						</script>";
                     { echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>';}
				  exit;  
				}
				$up = "UPDATE funcionarios SET nomeF ='".$nome."',fone= '".$fone."',cidade= '".$cidade."',bairro = '".$bairro."', logradouro= '".$lograd."',numero= '".$numero ."', sexo = '".$sexo."', funcao = '".$funcao."' 
                WHERE (codF=  ".$codF.")";
		 		}
				else
				{	$cont=strlen($senha);
                 if($cont>7&&$cont<11)
                     {	
                     if(preg_match('/[[:punct:]]/U',$senha)&&preg_match('/[[:alpha:]]/U',$senha)&&preg_match('/[[:digit:]]/U',$senha))
                         {
                         //Senha VÃ¡lida
                         if (($senha == $senhac)) 
                             {
                             	if(!$nome || !$fone || !$lograd || !$bairro || !$cidade || !$numero || !$sexo || !$funcao || !$conta_acesso || !$tipo_conta_acesso || !$nivel_acesso)
                                    {
                                    	echo "<p><font color=red>Voce nao entrou com os dados necessarios.												Volte a pagina anterior e preencha todos os campos</font</p>";
                                    		  { echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>';} exit;
													}else
													{
                                    		$up = "UPDATE funcionarios SET nomeF ='".$nome."',fone= '".$fone."',cidade= '".$cidade."',bairro = '".$bairro."', logradouro= '".$lograd."',
				                                        numero= '".$numero ."', sexo = '".$sexo."', funcao = '".$funcao."', conta_acesso = '".$conta_acesso."',tipo_conta_acesso = '".$tipo_conta_acesso."', nivel_acesso = '".nivel_acesso."' 
                                                        WHERE (codF=  ".$codF.")";	
                                    	}										
												}else
												{
													echo "<p><font color=red>Senha InvÃ¡lida, 
													Os campos senha e confirmaÃ§Ã£o de 
													senha devem ser iguais, tente novamente </font</p>";
											echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>'; exit;
												}
											}else
											{
												//return 0; //Senha InvÃ¡lida
												echo "<p><font color=red>Senha InvÃ¡lida, 
												verifique se sua senha possui os crÃ­terios exigidos. Volte e tente novamente!</font</p>";
											echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>'; exit;
											}
										}else
										{	//return 0; //Senha InvÃ¡lida
											echo "<p><font color=red>Senha InvÃ¡lida, 
											sua Senha deve possuir de 8 e 10 caracteres!</font</p>";
											echo "<p><font color=red>Senha InvÃ¡lida no tamanho. Volte e tente novamente!</font</p>";
											echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>'; exit;
										}	
										//echo return;
									}						 
				}
				else
				{
				if ($cad== 'aenpfin')
					{
                             $pagina = "PagResultConsulta.php";          
                    require_once 'funcao.php';
						echo $_POST["tipContNome"];
						$id_fin = $_POST["id_fin"];
						$conta = $_POST["conta"];
						$tipoCont_Atual	= $_POST["tipo_conta_Atual"];	//recebe o novo tipo de conta
                    
						if(isset( $_POST["tipocont"] ))   {  $tipoCont	= $_POST["tipocont"];} 		//recebe o anterior tipo de conta	
                        if(isset( $_POST["cod_ass"] ))    {  $cod_assoc = $_POST["cod_ass"];}		
						if(isset( $_POST["cod_Comp"] ))   {  $cod_compassion = $_POST["cod_Comp"];}		
						if(isset( $_POST["numeroDoc"] ))  {  $num_Doc= $_POST["numeroDoc"];}		
						if(isset( $_POST["numDocFiscal"] )) {  $numDocFiscal= $_POST["numDocFiscal"];}		
						if(isset( $_POST["razaoSoc"] ))   {  $historico	= $_POST["razaoSoc"];}		
						if(isset( $_POST["descri"] ))     {  $descricao	= $_POST["descri"];}							
						$dataF	= $_POST["data"];
						$dataF= implode('-',array_reverse(explode('/',$dataF)));
						$valorFin	= $_POST["valorFin"]; 
                    
						 if(isset($_SESSION['t_op_Exc_Edit']))
                          {  $op_Exc_Edit  = $_SESSION['t_op_Exc_Edit'];                    
                          }
                        $_SESSION['t_tabela'] = "aenpfin";
                        $_SESSION['c_tabela'] = "aenpfin";
                        $_SESSION['t_idfin'] = $id_fin;
						$_SESSION['t_senhaAdm'] = $_POST["senhaAdm"];
                        $senhaAdm =  $_POST["senhaAdm"];
						
                       // FunÃ§Ã£o verifica se o valor Ã© vÃ¡lido para moeda, tendo o padrÃ£o 999.999.999,99   
                     if(formatoRealPntVrg($valorFin) == true) 
                       {    
                          $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));// echo " ===Ponto virg== </br>";
                       }else if(formatoRealInt($valorFin) == true)
                       {  
                           $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');//echo " ===Inteiro== </br>";
                       }else if(formatoRealPnt($valorFin) == true)
                       { 
                         $valorFin  =    $valorFin;                         
                       }else if(formatoRealVrg($valorFin) == true)
                       { 
                         $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                       }
                    
						$ent_Sai = $_POST["ent_Sai"];//código para ENTRADA  Ã© ( 1 ) para SAÃDA  Ã© ( 0 )
						$cadastrante= $_POST["cadastrante"];
						$tipo_Pag= $_POST["tipoPag"];
						$tip_PagAnt= $_POST["tip_PagAnt"];
						$dia = date("Y-m-d");
						$query = mysqli_query($conex, 'SELECT ent_Sai FROM cod_compassion 
											WHERE cod_comp LIKE "'.$cod_compassion.'" LIMIT 1  ');
						while($comp_row = mysqli_fetch_array($query))
						$cod_comp = $comp_row['ent_Sai']; 
							
						$queryA = mysqli_query($conex, 'SELECT ent_SaiAss FROM cod_assoc 
											WHERE cod_Ass LIKE "'.$cod_assoc.'" LIMIT 1  ');
						while($ass_row = mysqli_fetch_array($queryA))
						$cod_as = $ass_row['ent_SaiAss']; 				
							
						/*echo 'cod compassion '.$cod_comp.' cod Assoc do post '.$cod_assoc;
						echo ' cod Ass da query '.$cod_as.' tipo de conta '.$tipoCont;
						exit;
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaConsulta.php'>
											<script type=\"text/javascript\">
											alert(\"Voce nao selecionou os códigos IEADALPE  e Compassion.
											Volte a pagina anterior e preencha todos os campos!\");
											</script>";	
						
						*/
						if(!$cod_assoc || !$cod_compassion)
						{ echo "Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
											Volte a pagina anterior e preencha todos os campos!";
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaEditar1.php'>
											<script type=\"text/javascript\">
											alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída. Volte a pagina anterior e preencha todos os campos!\");
											</script>";						  
						 exit; 
						}else 
							//if(($ent_Sai == 1 && ($cod_as == 0 || $cod_comp == 0 )) || ($ent_Sai == 0 && ($cod_as == 1 || $cod_comp == 1 ))  )
						if($ent_Sai <> ($cod_as  || $cod_comp  ))
						{echo "<p><font color=red>Os códigos IEADALPE  e Compassion nÃ£o condizem com a escolha de entrada e saída.
											Volte a pagina anterior e preencha todos os campos!</font</p>";
						 
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaEditar1.php'>
											<script type=\"text/javascript\">
											alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída. Volte a pagina anterior e preencha todos os campos!\");
											</script>";						  
						  exit;  
						}else						
						if(!$conta  || !$tipoCont_Atual  || !$num_Doc  || !$numDocFiscal  || !$historico  || !$tipo_Pag  || !$dataF  ||  !$valorFin )
						{echo "<p><font color=red>Você não informou todos os dados nescessário. Tente novamente!. '<br>Linha: '" . __LINE__ . "<br> </font</p>";
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaEditar1.php'>
											<script type=\"text/javascript\">
											alert(\"Você não informou todos os dados nescessário. Tente novamente!\");
											</script>";	
						  exit;  
						}	
                                 $datahj = date('Y-m-d');
                                $data_001 =  primeiroDiaMes($datahj);								
								$data_007 =  setimoDiadoMes($datahj);
                    if(($datahj > $data_007) && ($dataF < $data_001) && ($senhaAdm <> "aenp@z18"))
								{echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lanÃ§amento referente ao mÃªs anterior aspirado. <br/> 
								Retorne e altere a data ou contate o administrador.</font><br/>";
                                 echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaEditar1.php'>
											<script type=\"text/javascript\">
											alert(\" Prazo Limite para lançamento referente ao mês anterior aspirado, tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
                                }
                                 
						/*
						*/
						$saldo_mes_lancamento = "S";
						//inseri o novo registro
						
						$up = "UPDATE aenpfin SET 
						 conta= '".$conta."', tipo_Conta=  '".$tipoCont_Atual."',cod_compassion=  '".$cod_compassion."',
						cod_assoc=  '".$cod_assoc."', num_Doc_Banco=  '".$num_Doc."', num_Doc_Fiscal=  '".$numDocFiscal."',
						historico=  '".$historico."',	descricao=  '".$descricao."',	dataFin=  '".$dataF."',	valorFin=  '".$valorFin."',	ent_Sai=  '".$ent_Sai."', 
						saldo=  '".$saldo_Final."',		saldo_Mes=  '".$saldo_mes_lancamento."', cadastrante= '".$cadastrante."' 
						WHERE (id_fin =  ".$id_fin.")";
                       
                        unset($_SESSION['t_tabela']);        
                        unset($_SESSION['t_idfin']);
                        unset($_SESSION['t_op_Exc_Edit']);
                        unset($_SESSION['t_senhaAdm']) ;
						unset($_SESSION['t_op_Exc_Edit']) ;
                    
								echo 'conta '.$conta.' tipo conta'.$tipoCont_Atual.'</br>';
//******busca do ultimo registro com o saldo do mÃªs marcado *********
						$sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2017-01-01" and 
											conta = '.$conta.'  and tipo_Conta = "'.$tipoCont_Atual.'"
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
							echo "Nao existem lançamentos. Linha " . __LINE__ . "</br>";
						   
						}		
						while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Atual)) 
						{//ID, valor do saldo e a data do registro com o ultimo saldo marcado
							$id_Ultimo_Saldo = $row_Saldo['id_fin']; 
							$saldo_Atual = $row_Saldo['saldo']; 	
							$dataUlt_saldo = $row_Saldo['dataFin'];
						}
//*****se pagamento for em cheque faz um lanÃ§amento de reconciliaÃ§Ã£o bancÃ¡ria
						//echo ' tipo pagamento anterior'.$tip_PagAnt.' tipo pagamento selecionado '.$tipo_Pag.' cod associa  '.$cod_assoc.'  cod comp '.$cod_compassion.'<br>';
						//exit;
						if($tip_PagAnt == 0  && $tipo_Pag == "cheq") 
						{							
							$status = 0;
							$crud = new Inserir('reconc_bank');				
							$crud->inserir("id_reconc, id_aenp, data_Pag, status, operador", 
							"'','$id_fin','$dataF','$status','$cadastrante'"); 							
						}else
						if($tip_PagAnt == 1  && $tipo_Pag == "trans"){
							$sql = mysqli_query($conex, "DELETE FROM reconc_bank WHERE id_aenp ='$id_fin'");
							$result = mysqli_query($conex, $sql);
						}
// ******* Se a data do ultimo saldo for maior que a do lanÃ§amento altera todos saldos posteriores			
						//$saldo_mes_lancamento = "S";
						//if( $dataF < $dataUlt_saldo)
					 //	{**** primeiro dia do mÃªs do lanÃ§amento
				 
							$dia_1_mes = primeiroDiaMes($dataF);
						//	$saldo_mes_lancamento = "N";
	//******busca do ultimo registro, anterior ao mÃªs do lanÃ§amento, que tenha o saldo do mÃªs marcado *********						
							$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2017-01-01" and dataFin < "'.$dia_1_mes.'" and
											conta = '.$conta.'  and tipo_Conta = "'.$tipoCont_Atual.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
						$result_saldo_Penultimo = mysqli_query($conex, $saldo_Penultimo);
						if (!$result_saldo_Penultimo) 
							{				die ("<center>Desculpe, erro na busca de saldo atual.:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
											//exit;
							}
						if (mysqli_num_rows($result_saldo_Penultimo) == 0  ) 
							{	echo "Nao existem lanÃ§amentos Linha " . __LINE__ . "</br>";}		
						while ($row_saldo_Penultimo = mysqli_fetch_assoc($result_saldo_Penultimo)) 
						{//ID, valor do saldo e a data do registro com o penultimo saldo marcado
							$id_saldo_Penultimo = $row_saldo_Penultimo['id_fin']; 
							$saldo_Penultimo = $row_saldo_Penultimo['saldo']; 	
							$data_saldo_Penultimo = $row_saldo_Penultimo['dataFin'];
												
						}
//******busca de todos registro, apÃ³s o penultimo saldo *********						
									$maisRecentes = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, dataFin, ent_Sai, valorFin, saldo FROM aenpfin 
															WHERE  dataFin > "'.$data_saldo_Penultimo.'" 
															and conta like "'.$conta.'" and tipo_Conta like "'.$tipoCont_Atual.'" 
															ORDER BY dataFin, id_fin ');
								if (!$maisRecentes) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menuF.php'>Voltar ao Menu</a></center>");
											//exit;
								}
								if (mysqli_num_rows($maisRecentes) == 0 ) 
								{	echo $data_saldo_Penultimo." Nao foi encontrado nenhum registro apÃ³s o penultimo saldo. Linha " . __LINE__ . "";
								}								
	//inicia variavel do dia final do mes do registro anterior com o dia fim do mÃªs do lanÃ§amento								
								$fim_mes = ultimoDiaMes($dataF);
								
								$s_anterior =	$saldo_Penultimo;
								while ($maisRecent = mysqli_fetch_assoc($maisRecentes)) 
								{	
									
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
											alert(\"AtualizaÃ§Ã£o de saldo realizada com sucesso.\");
											</script>";	*/							
											}else {
												die ("<center>Desculpe, Erro na atualizaÃ§Ã£o.:  " 
												. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
												<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
												}					
									//}
									$s_anterior =	$s_Atual;
									if(isset($dataX)) { $d_anterior = $dataX;} 
									$dataX = $maisRecent['dataFin'];
									$data_ultimo_dia = ultimoDiaMes($dataX);//inicia variavel do dia final do mes do registro atual
									
									if(isset($id_anterior))									
									{							
										if($dataX > $fim_mes)
										{	$saldo_mes = "S";// Marca se for o ultimos registro de saldos de cada mes 
										}else $saldo_mes = "N";
										
											$upd = "UPDATE aenpfin SET saldo_Mes = '".$saldo_mes."' WHERE (id_fin =  ".$id_anterior.")";
											$atualiz = mysqli_query($conex, $upd);
											if ($atualiz) {
											/*echo "<META HTTP-EQUIV=REFRESH CONTENT='0;'>
											<script type=\"text/javascript\">
											alert(\"AtualizaÃ§Ã£o de saldo realizada com sucesso.\");
											</script>";	*/							
											}else {
											die ("<center>Desculpe, Erro na atualizaÃ§Ã£o.:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
											<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
											}										
									}
									/*if(	$saldo_mes == "S") $s_mes = "| Saldo do mÃªs.";
									echo '<font color=red size="2"> Conta '.$maisRecent['conta'];
									echo ' | Tipo '.$maisRecent['tipo_Conta']. ' | Data </font> <font color=green>'.$d_anterior. ' </font> <font color=red>
									| Registro '.$id_anterior. ' | Saldo alterado para '.$s_Atual. '  
									'.$s_mes. ' <td></font><br />';	
									 */
									
									$id_anterior = $maisRecent['id_fin'];
									$fim_mes = $data_ultimo_dia;
									
								}
							/*	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaLancamento1.php'>
											<script type=\"text/javascript\">
											alert(\"AlteraÃ§Ãµes realizada com sucesso. Novo lanÃ§amento.\");
											</script>";		
						*/
							if( $tipoCont <> $tipoCont_Atual)
							{	
												
			//******busca do ultimo registro com o saldo do mÃªs marcado *********
									$sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
														WHERE dataFin > "2017-01-01" and 
														conta = '.$conta.'  and tipo_Conta = "'.$tipoCont_Atual.'"
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
										echo "Nao existem lanÃ§amentos</br>";
									   
									}		
									while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Atual)) 
									{//ID, valor do saldo e a data do registro com o ultimo saldo marcado
										$id_Ultimo_Saldo = $row_Saldo['id_fin']; 
										$saldo_Atual = $row_Saldo['saldo']; 	
										$dataUlt_saldo = $row_Saldo['dataFin'];
									}
		
			// ******* Se a data do ultimo saldo for maior que a do lanÃ§amento altera todos saldos posteriores			
									//$saldo_mes_lancamento = "S";
									//if( $dataF < $dataUlt_saldo)
								 //	{**** primeiro dia do mÃªs do lanÃ§amento
							 
										$dia_1_mes = primeiroDiaMes($dataF);
									//	$saldo_mes_lancamento = "N";
				//******busca do ultimo registro, anterior ao mÃªs do lanÃ§amento, que tenha o saldo do mÃªs marcado *********						
										$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
														WHERE dataFin > "2017-01-01" and dataFin < "'.$dia_1_mes.'" and
														conta = '.$conta.'  and tipo_Conta = "'.$tipoCont_Atual.'"
														and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
									$result_saldo_Penultimo = mysqli_query($conex, $saldo_Penultimo);
									if (!$result_saldo_Penultimo) 
										{				die ("<center>Desculpe, erro na busca de saldo atual.:  " 
													. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
														<a href='menu1.php'>Voltar ao Menu</a></center>");
														//exit;
										}
									if (mysqli_num_rows($result_saldo_Penultimo) == 0  ) 
										{	echo "Nao existem lanÃ§amentos</br>";}		
									while ($row_saldo_Penultimo = mysqli_fetch_assoc($result_saldo_Penultimo)) 
									{//ID, valor do saldo e a data do registro com o penultimo saldo marcado
										$id_saldo_Penultimo = $row_saldo_Penultimo['id_fin']; 
										$saldo_Penultimo = $row_saldo_Penultimo['saldo']; 	
										$data_saldo_Penultimo = $row_saldo_Penultimo['dataFin'];
															
									}
			//******busca de todos registro, apÃ³s o penultimo saldo *********						
									$maisRecentes = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, dataFin, ent_Sai, valorFin, saldo FROM aenpfin 
															WHERE  dataFin > "'.$data_saldo_Penultimo.'" 
															and conta like "'.$conta.'" and tipo_Conta like "'.$tipoCont_Atual.'" 
															ORDER BY dataFin, id_fin ');
								if (!$maisRecentes) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menuF.php'>Voltar ao Menu</a></center>");
											//exit;
								}
								if (mysqli_num_rows($maisRecentes) == 0 ) 
								{	echo "Nao foi encontrado nenhum registro apÃ³s o penultimo saldo. Tente novamente!" . __LINE__ . "";
								}								
	//inicia variavel do dia final do mes do registro anterior com o dia fim do mÃªs do lanÃ§amento								
								$fim_mes = ultimoDiaMes($dataF);
								
								$s_anterior =	$saldo_Penultimo;
								while ($maisRecent = mysqli_fetch_assoc($maisRecentes)) 
								{	
									
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
											alert(\"AtualizaÃ§Ã£o de saldo realizada com sucesso.\");
											</script>";	*/							
											}else {
												die ("<center>Desculpe, Erro na atualizaÃ§Ã£o.:  " 
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
										//Verifica se o registro  a ser cadastrado Ã© o ultimo do seu mÃªs para marcar
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
											alert(\"AtualizaÃ§Ã£o de saldo realizada com sucesso.\");
											</script>";	*/							
											}else {
											die ("<center>Desculpe, Erro na atualizaÃ§Ã£o.:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
											<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
											}										
									}
									if(	$saldo_mes == "S") $s_mes = "| Saldo do mÃªs.";
									/*
									echo '<font color=red size="2"> Conta '.$maisRecent['conta'];
									echo ' | Tipo '.$maisRecent['tipo_Conta']. ' | Data </font> <font color=green>'.$d_anterior. ' </font> <font color=red>
									| Registro '.$id_anterior. ' | Saldo alterado para '.$s_Atual. '  
									'.$s_mes. ' <td></font><br />';	
									*/
									
									$id_anterior = $maisRecent['id_fin'];
									$fim_mes = $data_ultimo_dia;
									
								}
							/*	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaLancamento1.php'>
											<script type=\"text/javascript\">
											alert(\"AlteraÃ§Ãµes realizada com sucesso. Novo lanÃ§amento.\");
											</script>";		
						*/
								
							}
                            
                       // $_SESSION['c_tabela'] = "aenpfin";
						//$_SESSION['c_tipoCons'] =10;
						}
						else
						{
                            if ($cad== 'idosos')
                        {
                            $pagina = "menuF.php";
                            $id_idoso= $_POST["termo"];
                            $nomeI= $_POST["nomeI"];			
                            $data_Nasc= $_POST["data_Nasc"];			
                            $data_entrada= $_POST["data_entrada"];			
                            $cpf_I= $_POST["cpf_I"];
                            $rg_I = $_POST["rg_I"];		
                            $status= $_POST["status"];		
                            $sexo= $_POST["sexo"];
                                
                                
                                
                        $_SESSION['tabela'] = "idosos";
						$_SESSION['termo'] = $_POST["termo"];
						$_SESSION['nomeI'] = $_POST["nomeI"];								
						$_SESSION['data_Nasc'] = $_POST["data_Nasc"];
						$_SESSION['data_entrada'] = $_POST["data_entrada"];
						$_SESSION['cpf_I'] = $_POST["cpf_I"];
						$_SESSION['rg_I'] = $_POST["rg_I"];
						$_SESSION['status'] = $_POST["status"];
						$_SESSION['sexo'] = $_POST["sexo"];
						 
                


                            {$tipoCons = 20;  $tabela = "idosos"; $tipo = "id_idoso";}
                            if(!$nomeI || !$data_Nasc || !$data_entrada || !$cpf_I || !$rg_I || !$status || !$sexo)							
                               {				
                                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaEditar1.php'>
                                    <script type=\"text/javascript\">
                                    alert(\"Voce nao entrou com os dados necessarios.Volte a pagina anterior e preencha todos os campos\");
                                    </script>";
                                 { //echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>';
                                 }
                            }else
                            {                               		
                            $up = "UPDATE idosos SET nomeI ='".$nomeI."',data_Nasc= '".$data_Nasc."',data_entrada= '".$data_entrada."',cpf_I = '".$cpf_I."', rg_I= '".$rg_I."',sexo= '".$sexo ."', status = '".$status."'
                            WHERE (id_idoso=  ".$id_idoso.")";
                            }
                            ?> 
                            <p class="tabela"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
                                                <input name ="tipop"  type="text" value="<?php echo $tipo?>" />
                                                <input name ="tipoConsulta"  type="text" value="<?php echo $tipoCons?>" />
                                                <input name ="tab"  type="text" value="<?php echo $tabela?>" />
                                                <input name ="termop"  type="text" value="<?php echo $id_idoso?>" />
                            </p>                            
                            <?php 
                           }
                             else
							if ($cad== 'bairro')
								{
									$pagina = "menuF.php";
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
				if ($atualiza) echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$pagina."'>
						<script type=\"text/javascript\">
						alert(\"Alteracao realizado com sucesso.\");
						</script>";				
						else if($tabela == "funcionarios")
                        {                                    
                         { echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>';}         
		                  {
							die ("<center>Desculpe, Nao foi possivel atualizar o cadastro, tente novamente.:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>									
									<a href='menuF.php'>Voltar ao Menu</a></center>");
									exit;}
						} 			
						else if($tabela == "idosos")
                        {                                    
                         { echo '<p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>';}         
		                  {
                            }
						} 
 $con-> disconnect();
 ?> 
           <p class="submit"align="center"><input type="submit" value="Tentar novamente"  colspan="2"/></p>
 		</form>
		<div id="blRodape">  	

			<h1 text-align=center>Utilidade pública federal</h1>
		</div> 
		</div> 
		
	</body>
<html>