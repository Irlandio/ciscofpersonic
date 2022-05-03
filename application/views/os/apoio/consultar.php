<?php
header('Content-Type: text/html; charset=UTF-8');


        {
        if(isset($tipoCons)) {} else {$tipoCons = null;}
        if(isset($_POST["tipop"])) { $tipo = $_POST["tipop"];} else $tipo = null;
		if(isset($_POST["termop"])) { $termo = $_POST["termop"] ;} 
		if(isset($_POST["tab"])) { $tabela = $_POST["tab"];}
		if(isset($_POST["tipoConsulta"])) {  $tipoCons = $_POST["tipoConsulta"];}
		if(isset($_POST["conta_acesso"] )) {$conta_acesso = $_POST["conta_acesso"];}
		if(isset( $_POST["nivel"]  )) {  $nivel =  $_POST["nivel"];}
		if(isset( $_POST["tipo_conta_acesso"]  )) { $tipo_conta_acesso =  $_POST["tipo_conta_acesso"];}
        if(isset($_SESSION['tid_caixa'] )) {$tipoCons = 3;}
            //                if(isset(        )) {         =         ;}       
       if(isset($tabela))  if($tabela == "idosos") {$tipoCons = 200;}         
        }
		
		//echo 'Tipo   ',$tipo.', Termo  '.$termo.', Tabela '.$tabela. ', Tipo Consulta '.$tipoCons.'  <td><br />Linha '. __LINE__.' consultar.php.<br />' ;
		//echo 'Conta   ',$tipo.', Termo  '.$termo.', Tabela '.$tabela. ', Tipo Consulta '.$tipoCons.'  <td><br />'. __LINE__ ;
		require_once 'funcao.php';

	//	$data1 = date("Y-m-d");
      //  $data2 = date("Y-m-d");

			$data_1 = date("Y-m-d");
			$data_01 =  primeiroDiaMes($data_1);
			$data_00 = primeiroDiaMesPassado($data_1);
			$data_03 = primeiroDia_a3meses($data_1);
			$data_02 = ultimoDiaMes($data_1);
			
			
			if($tipoCons == "1010" || $tipoCons == "1020" || $tipoCons == "1030"  || $tipoCons == "104"   || $tipoCons == "106" )
				$data_00 = $data_01;
            
		   /*Exemplo de chamada da função*/
		//  echo 'primeiroDiaMesPassado   ',$data_00.', ultimoDiaMes  '.$data_02.', Hoje '.$data_1;
		
				if($tipoCons == 12 )
				{
					$adm = $_POST["adm"];
					$caixa = $_POST["caixa"]; 
					$ano = $_POST["ano"];	 
					$mesN = $_POST["mes"];  
                    
					if($adm == "cod_assoc" ){$admN = "IEADALPE"; 
                                             $adm_C = "cod_assoc"; 
                                             $admCod = "cod_Ass"; 
                                             $admArea = "area"; 
                                             $admDescri = "descricao_Ass";}  
					else if($adm == "cod_compassion" ){$admN = "Compassion";  
                                                        $adm_C = "cod_compassion"; 
                                                       $admCod = "cod_Comp";  
                                                        $admArea = "area_Cod"; 
                                                       $admDescri = "descricao";}
					
					$resultado = mysqli_query($conex, 'SELECT * FROM caixas WHERE id_caixa LIKE '.$caixa. ' Limit 1');
					if (!$resultado ) 
					{			die ("<center>Desculpe, Não foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
					if (mysqli_num_rows($resultado) == 0 ) 
					{
						echo "Nao foi encontrado nenhum Item com estes criterios. Tente novamente!"; exit;
					}
					while ($box = mysqli_fetch_assoc($resultado)) 
					{					
						$caixaNome = $box['nome_caixa'];
						$banco = $box['banco'];
						$agencia = $box['agencia'];
						$n_conta = $box['n_conta'];
					}									
						$ano2 = $ano ;
						$ano0 = $ano ;
						
						switch ($mesN) 
					{
						case "janeiro":		$mes0 = "12"; $mes = "01"; $mes2 = "02"; $ano0 = $ano - 1 ; break;  	
						case "fevereiro":	$mes0 = "01"; $mes = "02"; $mes2 = "03"; break;  
						case "março":		$mes0 = "02"; $mes = "03"; $mes2 = "04"; break;  	
						case "abril":		$mes0 = "03"; $mes = "04"; $mes2 = "05"; break;  
						case "maio":		$mes0 = "04"; $mes = "05"; $mes2 = "06"; break;  	
						case "junho":		$mes0 = "05"; $mes = "06"; $mes2 = "07"; break;  
						case "julho":		$mes0 = "06"; $mes = "07"; $mes2 = "08"; break;  	
						case "agosto":		$mes0 = "07"; $mes = "08"; $mes2 = "09"; break;  
						case "setembro":	$mes0 = "08"; $mes = "09"; $mes2 = "10"; break;  	
						case "outubro":		$mes0 = "09"; $mes = "10"; $mes2 = "11"; break;
						case "novembro":	$mes0 = "10"; $mes = "11"; $mes2 = "12"; break;	
						case "dezembro":	$mes0 = "11"; $mes = "12"; $mes2 = "01"; $ano2 = $ano + 1 ; break;  				
					}
		/* O lançamento com a data mais avançada do mês recebe uma indicação (s) que o campo saldo é o saldo do mês
		   Caso o lançamento sejs feito numa dsts posterior que foi feito o lançamento que tem marcado a indicação
		   de  saldo do mês porem se referindo a uma data anterior entâo todos os lançamentos com data pósterior
		   serão alterados os valores do campo saldo.
		   Porém se for de uma data posterior a indicação do registro com o saldo do mês é desabilitada (n) e o 
		   novo registro recebe uma indicação (s) que o campo saldo é o saldo do mês*/		
		   
					$data1= date($ano.'-'.$mes.'-01');//Cria a variavel data inicial com o mês e o ano indicado sendo dia 01
					$data2= date($ano2.'-'.$mes2.'-01');//Cria a variavel data final com o mês seguinte sendo dia 01
					$data_mes_Anterior= date($ano0.'-'.$mes0.'-01');//Cria a variavel data final com o mês seguinte sendo dia 01
					//echo '<font color=Brown size="2">data1   ',$data1.', data2  '.$data2.', adm '.$adm. ', caixa '.$caixa. ' <td></font><br />'. __LINE__ ;
			
					//exit;
				}else
				if($tipoCons == 10 )
				{
					if(($_SESSION['c_tabela']) <> "0")// erro na edção tentar denovo
                      {
                        $tipoCons =  ($_SESSION['c_tipoCons']);       
                        $tabela = ($_SESSION['c_tabela']);       
                        if(isset( $_SESSION["c_data1"] ))     {  $data1 = $_SESSION["c_data1"] ;}		
                        if(isset( $_SESSION["c_data2"] ))     {  $data2 = ($_SESSION['c_data2']);}		
                        if(isset( $_SESSION["c_tipop"] ))     {  $tipo = ($_SESSION['c_tipop']);}		
                        if(isset( $_SESSION["c_caixa"] ))     {  $conta = ($_SESSION['c_caixa']);}		
                        if(isset( $_SESSION["c_tipCont"] ))   { $tipCont = ($_SESSION['c_tipCont']);}		
                        if(isset( $_SESSION["c_termop"] ))    { $termo = ($_SESSION['c_termop']);}
                        
                     //  echo '<font color=Brown size="2">Com Sessão <> 0 | Tabela Global  '.$_SESSION['c_tabela'].' Termo Global '.$_SESSION['c_termop'].'  data1   '.$data1.', data2  '.$data2.', adm '.$adm. ', caixa '.$caixa. ' <td></font><br />'. __LINE__ ;
                     } else 
                        {                             
                                $conta = $_POST["caixa"];
                                $tipCont = $_POST["tipCont"];
                                if(isset( $_POST["data1"])) $data1 = $_POST["data1"]; 
                                if(isset( $_POST["data2"])) $data2 = $_POST["data2"]; 
                                
                        
                         echo '<font color=Brown size="2">Com Sessão = 0  | Tabela Global '.$_SESSION['c_tabela'].' Termo Global '.$_SESSION['c_termop'].' Tipo Global '.$_SESSION['c_tipop'].'   data1   '.$data1.', data2  '.$data2.', adm '.$adm. ', caixa '.$caixa. ' <td></font><br />'. __LINE__ ;
                        }
                    
					if (isset($data1) ) {} else $data1 = $data_03;
					if (isset($data2) ) {} else $data2 = date("Y-m-d");
                    $_SESSION["c_data1"] = $data1 ;
                    $_SESSION["c_data2"] = $data2 ;
                    
                   // echo '<font color=Brown size="2"> | data1   '.$data1.', data2  '.$data2.', adm '.$adm. ', caixa '.$caixa. ' <td></font><br />'. __LINE__ ;
					switch ($tabela) 
					{
						case "funcionarios":	$tipo = "nomeF";//condicionar o criterio nome para nome funcionario
												if(!$termo)$termo = "a"; 
												$tipoCons = 9;
												break;    
						case "cod_compassion":	//echo ' - Linha: ' . __LINE__ . " - "	;	
												$tipoCons = 9;
												if(!$termo)
												{	$tipo = "ent_Sai";
													$termo = 2;	 
												}else 	
												{ 	
													$tipo = "descricao";										
												} break;  
						case "cod_assoc":	//echo ' - Linha: ' . __LINE__ . " - "	;						
												$tipoCons = 9;
												if(!$termo )
												{	$tipo = "ent_SaiAss";
													$termo = 2;	 
												}else 	{ 	
															$tipo = "descricao_Ass";										
														} break;  
						case "aenpfinE":	$tabela = "aenpfin";
											//echo ' - Linha: ' . __LINE__ . " - "	;	
												if(!$termo)
												{	$tipo = "ent_Sai";
													$termo = 1;	
												}else 																					
												{	 $todasContas = 1; $e_ou_saida = 1; }
											break;  
						case "aenpfinS":	$tabela = "aenpfin"; 
											//echo ' - Linha: ' . __LINE__ . " - "	;	
												if(!$termo)
												{	$tipo = "ent_Sai";
													$termo = 0;		
												}else 
												{	 $todasContas = 1; $e_ou_saida = 0;}
											break;    
						case "aenpfinT":	$tabela = "aenpfin"; 
											//echo ' - Linha: ' . __LINE__ . " - "	;	
												if(!$termo)
												{	
													if(isset($conta) &&  $conta ==0)
													{
													$tipo = "ent_Sai";	$termo = 2;	
													}else
													{
													$tipo = "ent_Sai";	$termo = 2;		
													}												
													
												}else
												{	 $todasContas = 1;}
											break;  									
					}								
				}else
				if($tipoCons == 11 )
				{	
				}else
				if($tipoCons == 4 )
				{//echo ' - Linha: ' . __LINE__ . " - "	;
						$tabela = 'aenpfin';
						$tipo = "caixa";
						$termo = 1;
				}else//condicionar o criterio  
				if($tipoCons == 3 )
				{//echo ' - Linha: ' . __LINE__ . " - "	;
                        
                                if(isset($_SESSION['tid_caixa'] )){ 
                                $termo =     $_SESSION['tid_caixa'];
								$termo1 =      $_SESSION['tcod_Ass'] ;
								$termo2 =     $_SESSION['tcod_Comp'];
                                } else{
                                    $termo = $_POST["caixa"];
                                    $termo1 = $_POST["cod_ass"];
                                    $termo2 = $_POST["compassion"];
                                }
							$tipo = "id_caixa";							
							$tabela = "caixas";
							
							$tipo1 = "cod_ass";   
							$tabela1 = "cod_assoc";
							
							$tipo2 = "cod_Comp";
							$tabela2 = "cod_compassion";							
							//echo "- <strong><td> Cod Caixa  ".$termo." Cod Ass  ".$termo1." Cod Compass ".$termo2."</td></strong><br/>";
						
							if($termo == 0 ||$termo1 == "0" ||$termo2 == "0" )
							{//echo ' - Linha: ' . __LINE__ . " - "	;
								echo "<strong><td>ERRO!  - </td></strong><br/> Selecione as opções nos campos obrigatórios, tente novamente!";
								exit;
							}	$datahj = date('Y-m-d');
							//echo $datahj;
							$dataF= implode('-',array_reverse(explode('/',$data)));
							if($dataF < "2010-01-01" || $data > $datahj )
								{
									echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/> Linha ";
								//	exit;
								}
				}else
				if($tipoCons == 0 )
				{		//echo ' - Linha: ' . __LINE__ . " - "	;		
								$tipoAss = "ent_SaiAss";												
								$tipoComp = "ent_Sai";
								$tabela = "comp_e_Assoc";									
				}else
				if($tipoCons == 1 ||  $tipoCons == 1010 )//02-Entradas dos ultimos dois meses
				{	//	echo ' - Linha: ' . __LINE__ . " - "	;
								if($conta_acesso == 99) { $todasContas = 1;} else $todasContas = 0;
								$tipo = "ent_Sai";												
								$termo = "1";
								$tabela = "aenpfin";	
								$tipoCons = 1;
				}else
				if($tipoCons == 102  ||  $tipoCons == 1020 )//03-Saídas dos ultimos dois meses
				{	//	echo ' - Linha: ' . __LINE__ . " - "	;		
								if($conta_acesso == 99) { $todasContas = 1;} else $todasContas = 0;
								$tipo = "ent_Sai";												
								$termo = "0";
								$tabela = "aenpfin";
								$tipoCons = 1;
				}else
				if($tipoCons == 103  ||  $tipoCons == 1030 )//04-lançamentos dos ultimos dois meses
				{		//echo ' - Linha: ' . __LINE__ . " - "	;		
								if($conta_acesso == 99) { $todasContas = 1;} else $todasContas = 0;
								$tipo = "ent_Sai";												
								$termo = "2";
								$tabela = "aenpfin";	
								$tipoCons = 1;								
				}
                if($tipoCons == 104  ||  $tipoCons == 105 || $tipoCons == 106  ||  $tipoCons == 107 )//05-Presentes do mês e dos ultimos dois meses
				{	//	echo ' - Linha: ' . __LINE__ . " - "	;		
								if($conta_acesso == 99) { $todasContas = 1;} else $todasContas = 0;
								if($tipoCons == 106  ||  $tipoCons == 107 ) { $detalhes = 1;} else $detalhes = 0;
								$tabela = "presentes_especiais";
                                
								$tipoCons = 5;								
				}
                if($tipoCons == 201 )
				{	$tipoCons = 20; $tabela = "idosos"; $tipo = "status"; $termo = "Inativo";
                
				}else
                if($tipoCons == 200 )
				{	$tipoCons = 20;  $tabela = "idosos"; $tipo = "status"; $termo = "Ativo";
                // else {$tipo = "nomeI"; $op = 1;} 
				}
			
		 if(!$tipo || !$tabela )
			{
			  echo "<p><font color=red>Que pena, Voce nao entrou com os dados necessarios.
			  Volte a pagina anterior e tente novamente</font</p>";
			  echo ' - Linha: ' . __LINE__ . " - tipo ".$tipo." tabela ".$tabela." Sess tab ".$_SESSION['c_tabela']." sess t cons ".$_SESSION['c_tipoCons']." consul ".$tipoCons	;										
			  exit;
			}
			switch ($tipoCons) 
			{
				case 0://Todos CODIGOS 
					$sql ="SELECT * FROM cod_compassion UNION SELECT * FROM cod_assoc";											
					break;    
				case 1://Lançamentos do mês ou dos ultimos dois meses
                    {if($tabela == "aenpfin" && $termo == 2)
					{if($todasContas == 1)
							{$sql = 'SELECT * FROM '.$tabela.' 
						WHERE  dataFin >= "'.$data_00.'" and dataFin <= "'.$data_02.'"
									ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
							}else
								{$sql = 'SELECT * FROM '.$tabela.' 
									WHERE  conta LIKE "'.$conta.'"  and dataFin >= "'.$data_00.'" and dataFin <= "'.$data_02.'"
									ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
								}
					}else if($todasContas == 1)
							{$sql = 'SELECT * FROM '.$tabela.' 
						WHERE '.$tipo.' LIKE "'.$termo.'" and dataFin >= "'.$data_00.'" and dataFin <= "'.$data_02.'"
									ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
							}else
								{$sql = 'SELECT * FROM '.$tabela.' 
									WHERE '.$tipo.' LIKE "'.$termo.'"  and conta LIKE "'.$conta.'"  
									and dataFin >= "'.$data_00.'" and dataFin <= "'.$data_02.'"
									ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
                                 //	echo "Conta ".$conta. " data1 ".$data_00." data2 ".$data_02." tipo ".$tipo." termo ".$termo."<br>";
								}}
					break; 
				case 2://Todos funcionarios    
					// Ficou junta com o 1. Nâo Usar
					break; 
				case 3://Todos codigos e contas
                    {$sql = 'SELECT * FROM '.$tabela.' WHERE '.$tipo.' LIKE '.$termo;
					$sql1 = 'SELECT * FROM '.$tabela1.' WHERE '.$tipo1.' LIKE "'.$termo1.'"';
					$sql2 = 'SELECT * FROM '.$tabela2.' WHERE '.$tipo2.' LIKE "'.$termo2.'"';
					$tabela = "aenpfin";}
					break;
				case 4://
					$sql = 'SELECT * FROM '.$tabela.' ORDER BY dataFin';					
					break;	
                case 5:// Lista os presentes especiais do período selecionado e ordena por BR, Protocolo e data		
					{if($todasContas == 1)
							{$sql = 'SELECT * FROM '.$tabela.' 
						WHERE  data_presente >= "'.$data_00.'" and data_presente <= "'.$data_02.'"
									ORDER BY SUBSTRING(n_beneficiario,4,6),month(data_presente),  n_protocolo, id_presente ASC'; 
                             
                       //      ORDER BY SUBSTRING(n_beneficiario,4,6), n_protocolo, data_presente DESC'; 
                          //   echo "Linha: ". __LINE__ ."<br>";
							}else
								{
                        switch ($conta) 
					{						
						case 4:	$contN = "BR0214"; $cidadde = "Abreu e Lima"; $cdi = "1";     break;  
						case 5:	$contN = "BR0518"; $cidadde = "Paulista";     $cdi = "2";     break;  
						case 6:	$contN = "BR0542"; $cidadde = "Bezerros";     $cdi = "3";     break;  
						case 7:	$contN = "BR0549"; $cidadde = "Catende";      $cdi = "4";     break;
						case 8:	$contN = "BR0579"; $cidadde = "Jurema";       $cdi = "5";     break;  
                        case 99:$contN = "Todas contas"; break;  				
					}					                   
                        
                        
                        
                            $sql = 'SELECT * FROM '.$tabela.' 
									WHERE  SUBSTRING(n_beneficiario,1,6) LIKE "'.$contN.'"  and data_presente >= "'.$data_00.'" and data_presente <= "'.$data_02.'"
									ORDER BY  SUBSTRING(n_beneficiario,4,6), month(data_presente), n_protocolo, id_presente ASC'; 
                                  //echo "Tabela ".$tabela. "Conta ".$conta. " data1 ".$data_00." data2 ".$data_02." tipo ".$tipo." termo ".$termo."<br>";   
                        
                        
                        
								}   
					}	
					break; 
                    
				case 9://
                    {if( $termo == 2)
					{$sql = 'SELECT * FROM '.$tabela.' WHERE '.$tipo.' < '.$termo;
					}else
						$sql = 'SELECT * FROM '.$tabela.' WHERE '.$tipo.' LIKE  "%'.$termo.'%" ORDER BY '.$tipo;}						
					break;					
				case 10://Consultas simples
                    {	/*
					*/
				if($conta ==0)
					{
						if($tabela == "aenpfin" && $termo == 2)
						{$sql = 'SELECT * FROM '.$tabela.' 
								WHERE '.$tipo.' < '.$termo.' and dataFin >= "'.$data1.'" and dataFin <= "'.$data2.'"
								ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
						}else
							if($tabela == "aenpfin" && $tipo == "ent_Sai")
							{$sql = 'SELECT * FROM '.$tabela.' 
									WHERE  dataFin >= "'.$data1.'" and dataFin <= "'.$data2.'" and '.$tipo.' LIKE "'.$termo.'"
									ORDER BY conta, tipo_Conta, dataFin DESC';//echo "Linha: ". __LINE__ ."<br>";
							}else if(!$e_ou_saida) 
								{if($todasContas == 1)
									{$sql = 'SELECT * FROM '.$tabela.' 
											WHERE '.$tipo.' LIKE "%'.$termo.'%" and dataFin >= "'.$data1.'" and dataFin < "'.$data2.'"
											ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
											echo "Conta ".$conta. " tipCont ".$tipCont. " data1 ".$data1." data2 ".$data2." tipo ".$tipo." termo ".$termo;
								
									}else
										{$sql = 'SELECT * FROM '.$tabela.' 
												WHERE '.$tipo.' LIKE "%'.$termo.'%"  and conta LIKE '.$conta.'  and dataFin >= "'.$data1.'" and dataFin < "'.$data2.'"
												ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
									}
								}else 
									{if($todasContas == 1)
									{$sql = 'SELECT * FROM '.$tabela.' 
											WHERE ent_Sai LIKE '.$e_ou_saida.' and '.$tipo.' LIKE "%'.$termo.'%" and dataFin >= "'.$data1.'" and dataFin < "'.$data2.'"
											ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
									}else
										{$sql = 'SELECT * FROM '.$tabela.' 
											WHERE ent_Sai LIKE '.$e_ou_saida.' and '.$tipo.' LIKE "%'.$termo.'%"  and conta LIKE '.$conta.'  and dataFin >= "'.$data1.'" and dataFin < "'.$data2.'"
											ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
										}}
					}else
					{
						if($tabela == "aenpfin" && $termo == 2)
					{	$sql = 'SELECT * FROM '.$tabela.' 
								WHERE conta = '.$conta.' and tipo_Conta = "'.$tipCont.'"  
								and dataFin >= "'.$data1.'" and dataFin <= "'.$data2.'"
								ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: ". __LINE__ ."<br>";
								//	echo "Conta ".$conta. " tipCont ".$tipCont. " data1 ".$data1." data2 ".$data2." tipo ".$tipo." termo ".$termo;
									
					}else
							if($tabela == "aenpfin" && $tipo == "ent_Sai")
					{				$sql = 'SELECT * FROM '.$tabela.' 
									WHERE  conta = "'.$conta.'" and tipo_Conta = "'.$tipCont.'" and  dataFin >= "'.$data1.'" 
									and dataFin <= "'.$data2.'" and ent_Sai LIKE "'.$termo.'"
									ORDER BY conta, tipo_Conta, dataFin DESC'; 
					}		else if(!$e_ou_saida) 
								{if($todasContas == 1)
										{$sql = 'SELECT * FROM '.$tabela.' 
										WHERE  conta = '.$conta.' and tipo_Conta = "'.$tipCont.'" 
										and '.$tipo.' LIKE "%'.$termo.'%" and dataFin >= "'.$data1.'" and dataFin <= "'.$data2.'"
										ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: " . __LINE__ . "<br>";
											//echo "Conta ".$conta. " tipCont ".$tipCont. " data1 ".$data1." data2 ".$data2." tipo ".$tipo." termo ".$termo."<br>";
										}	else
									{$sql = 'SELECT * FROM '.$tabela.' 
											WHERE  conta = '.$conta.' and tipo_Conta = "'.$tipCont.'" 
											and '.$tipo.' LIKE "%'.$termo.'%"  and conta LIKE '.$conta.'  and dataFin >= "'.$data1.'" and dataFin <= "'.$data2.'"
											ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: " . __LINE__ . "<br>";
									}
								}else 
									{if($todasContas == 1)
										{$sql = 'SELECT * FROM '.$tabela.' 
											WHERE  conta = '.$conta.' and tipo_Conta = "'.$tipCont.'" and ent_Sai LIKE '.$e_ou_saida.' 
											and '.$tipo.' LIKE "%'.$termo.'%" and dataFin >= "'.$data1.'" and dataFin <= "'.$data2.'"
											ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: " . __LINE__ . "<br>";
										}else
										{$sql = 'SELECT * FROM '.$tabela.' 
											WHERE  conta = '.$conta.' and tipo_Conta = "'.$tipCont.'" and ent_Sai LIKE '.$e_ou_saida.' 
											and '.$tipo.' LIKE "%'.$termo.'%"  and conta LIKE '.$conta.'  and dataFin >= "'.$data1.'" and dataFin <= "'.$data2.'"
											ORDER BY conta, tipo_Conta, dataFin DESC'; //echo "Linha: " . __LINE__ . "<br>";
										}
									}
					}}				
					break;
				case 11://PADRAO de cnsulto por term exato
					$sql = 'SELECT * FROM '.$tabela.' WHERE '.$tipo.' LIKE "'.$termo.'" limit 1';					
					break;
				case 12://PADRAO
                    {$termo = "0";//SELECIONA TODOS LANÇAMENTOS do mês, da conta e da administração selecionados
					$sql = 'SELECT * FROM aenpfin 
						WHERE dataFin >= "'.$data1.'" and dataFin < "'.$data2.'" and conta = "'.$caixa.'"  
						and "'.$adm.'" is Not Null 
						ORDER BY tipo_Conta, dataFin';	
					$sql_Saldo_Ant = 'SELECT * FROM aenpfin 					
						WHERE dataFin >= "'.$data_mes_Anterior.'" and dataFin < "'.$data1.'" and 
						conta = "'.$caixa.'"  and "'.$adm.'" is Not Null and saldo_Mes = "S" ORDER BY dataFin ';	}
					break;
				case 20://
                    {
                    if($op == 1)
					$sql = 'SELECT * FROM '.$tabela.' WHERE '.$tipo.' LIKE "%'.$termo.'%"  ORDER BY nomeI ';	
                    else
					$sql = 'SELECT * FROM '.$tabela.' WHERE '.$tipo.' = "'.$termo.'"  ORDER BY nomeI ';}					
					break;	
			}

		
			if ($tipoCons == 3  ) 
			{
				$result = mysqli_query($conex, $sql);
				$result1 = mysqli_query($conex, $sql1);
				$result2 = mysqli_query($conex, $sql2);
				if (!$result || !$result1  || !$result2) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
				if (mysqli_num_rows($result) == 0 || mysqli_num_rows($result1) == 0 || mysqli_num_rows($result2) == 0 ) 
				//if (mysqli_num_rows($result1) == 0 ) 
				{
					echo "Nao foi encontrado nenhum Item com estes criterios. Tente novamente!";
				   exit;
				}
			}else
				if ($tipoCons == 12  ) 
			{
				$result = mysqli_query($conex, $sql);
				$result_Saldo_Ant = mysqli_query($conex, $sql_Saldo_Ant );
				if (!$result || !$result_Saldo_Ant) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
				if (mysqli_num_rows($result) == 0 ) 
				{	echo "Nao foi encontrado nenhum Item com estes criterios. Tente novamente!";   exit;
				}
				if ( mysqli_num_rows($result_Saldo_Ant) == 0  ) 
				{
					echo "Nao foi encontrado nenhum lançameto no mês anterior para indicação de saldo existente!";	
                    $saldo_Ant_Corr = 0; echo "sem saldo";
				}
			}else
			{					
				$result = mysqli_query($conex, $sql);
				if (!$result) 
					{
								die ("<center>Desculpe, Não foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error($link) . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
				if (mysqli_num_rows($result) == 0)  
					{
						echo "Não foi encontrado nenhum Item com estes criterios. Tente novamente!  <br>";//Linha:. __LINE__ . "<br>";
					   exit;
					}				
			}
		$camp = $termo;		
		if($tabela=='aenpfin')
		{
			if( $tipoCons == 12)
			{
			
				$html = '';
				while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Ant)) 
				{
					if($row_Saldo['tipo_Conta'] == "Corrente") 	{$saldo_Ant_Corr = $row_Saldo['saldo'];} 
					else if($row_Saldo['tipo_Conta'] == "Suporte") 	{$saldo_Ant_Sup = $row_Saldo['saldo']; 
																	$ncontaS = "Suporte ";}
					else if($row_Saldo['tipo_Conta'] == "Poupança") {$saldo_Ant_Poup = $row_Saldo['saldo']; }
					$tipo_Contas = 0;	//	echo 'saldo corrente '.$saldo_Ant_Corr. ' saldo Suporte '.$saldo_Ant_Sup;			
				}
                if(isset($saldo_Ant_Corr)) {} else $saldo_Ant_Corr = 0;
                if(isset($saldo_Ant_Sup)) {} else  $saldo_Ant_Sup = 0;
                if(isset($saldo_Ant_Poup)) {} else  $saldo_Ant_Poup = 0;
                
            if($adm == "cod_compassion" )
             {
				while ($row = mysqli_fetch_assoc($result)) 
				{ 	
                    
                    switch ($caixa) 
					{						 
						case 4:	$cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA";  break;  
						case 5:	$cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  break;  
						case 6:	$cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS";  break;  
						case 7:	$cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  break;  
						case 8:	$cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  break; 		
					}	
					if($row['tipo_Conta'] == "Corrente"){$saldo_Ant = 	$saldo_Ant_Corr;	$tipo_Conta_Atual = 1;	$abrev = "C/C:";}else		
					if($row['tipo_Conta'] == "Suporte")	{$saldo_Ant = 	$saldo_Ant_Sup;		$tipo_Conta_Atual = 2;	$abrev = "C/S:";}else
					if($row['tipo_Conta'] == "Poupança"){$saldo_Ant = 	$saldo_Ant_Poup;	$tipo_Conta_Atual = 3;	$abrev = "C/P:";}	
                    
					/*{$admN = "Compassion"; $adm_C = "cod_compassion";  $admCod = "cod_Comp";  $admArea = "area_Cod";  $admDescri = "descricao";}*/
                   // echo $adm.' - codigo do registro $row[$adm} - ] '.$row[$adm].' -  $admCod '.$admCod.' - ';
                    $sqlCod = 'SELECT * FROM  '.$adm.' WHERE   '.$admCod.'  = "'.$row[$adm].'" limit 1';
                        $queryCodigo = mysqli_query($conex, $sqlCod);
                    
                    if (!$queryCodigo ) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									//exit;
					}
				if (mysqli_num_rows($queryCodigo) == 0 ) 
				{	echo '<br>Linha: ' . __LINE__ . '<br>Nao foi encontrado nenhum Item com estes criterios. Tente novamente!';  // exit;
				}
				
                    while($cod_row = mysqli_fetch_assoc($queryCodigo)) { $admAr = $cod_row[$admArea]; $admDesc = $cod_row[$admDescri]; }
                    
                   // echo '<br /><font color=red size="3"> Coluna '.$adm_C. ' | Area '.$admAr.' | descri '.$admDesc.' | Codigo '.$row[$adm].' | <td></font><br /><br />';
                   
					if($tipo_Contas == 0)
						{$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; $total = $saldo_Ant;
						}else	if($tipo_Contas <> $tipo_Conta_Atual)
						{	$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; 
							$total =  number_format($total, 2, ',', '.');
						  $html .=  '<td></td> <td></td> <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>'; 
                         
							$html .=  '<td><h4 align="right" valign=bottom >'.$total.'</h4></td>';
				            $html .=  '</tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
 
							echo '<td></td> <td></td> <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;	
						}	
						if($primeiroReg == "S") 
						{
							
							$html .= '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							  if($row['tipo_Conta'] == "Corrente")
                            {
                                $html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >CONTA CORRENTE - BANCO
							         </th> <th align="center" >Folha Nº4</th>  </tr>';
                            }else 
                                if($row['tipo_Conta'] == "Suporte")
							$html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >CAIXA PEQUENO
							         </th> <th align="center" >Folha Nº5</th>  </tr>';							
							$html .=   '<tr><th colspan="3">Projeto</th> <th colspan="3" align="center"  align="center" >'.$cdiNome.'</th>';
							$html .=   '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Cidade</th> <th colspan="3" align="center"  align="center" >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Estado</th> <th colspan="3" align="center"  align="center" >PE</th>';
							$html .=   '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';
                            $html .=   '<tr><th colspan="9" bgcolor="yellow" style="font-size:70%">ATENÇÃO: Esta página está identica a planilha               Compassion. Copie apenas os campos em "amarelo".</th>';
                            $html .=    ' </tr>';
                            
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro" ><th width="30" rowspan="3"> Registro</th>';	
							$html .=   '<th width="30" rowspan="3">Data</th>';	
							$html .=   '<th width="30" rowspan="3">Conta</th>';	
							$html .=   '<th width="30" rowspan="3">Forma ou cheque</th>';	
							$html .=   '<th rowspan="3"> Área </th> <th rowspan="3"> Descrição </th>';	
							$html .=   '<th width="100" rowspan="3">Histórico</th>';	
							$html .=   '<th width="80" rowspan="3">Entrada(R$)</th>';	
							$html .=   '<th width="50" rowspan="3">Saída(R$)</th>';	
							$html .=   '<th width="50" rowspan="1">Saldo MÊS</th>';	
							$html .=   '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr> </tr><tr>';
							$html .=  '<td  colspan="9" ></td>  ';
							$html .=  '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=  '</tr>';		
                            
                            
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
                            if($row['tipo_Conta'] == "Corrente")
                            {
                                echo '<thead ><tr bgcolor="Gainsboro" ><th ROWSPAN="5"></th> <th colspan="8" >CONTA CORRENTE - BANCO
							         </th> <th align="center" >Folha No4</th>  </tr>';
                            }else 
                                if($row['tipo_Conta'] == "Suporte")
							     echo '<thead ><tr bgcolor="Gainsboro"><th ROWSPAN="5"></th> <th colspan="8" >CAIXA PEQUENO
							         </th> <th align="center" >Folha No5</th>  </tr>';							
							echo '<tr><th colspan="3">Projeto</th> <th colspan="3" align="center"  align="center" >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="3">Cidade</th> <th colspan="3" align="center"  align="center" >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="3">Estado</th> <th colspan="3" align="center"  align="center" >PE</th>';
							echo '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="9" bgcolor="yellow" style="font-size:70%">ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
							echo ' </tr>';		
							//echo '<tr><th rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
							echo ' </tr>';
                            
							//echo '<tr><th width="60" rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th></tr>';	
							echo '<tr rowspan="3" bgcolor="Gainsboro" style="font-size:70%" ><th width="30" rowspan="3"> Registro</th>';	
							echo '<th rowspan="3">Data</th>';	
							echo '<th  rowspan="3">Conta</th>';	
							echo '<th width="10" rowspan="3">Forma ou cheque</th>';	
							echo '<th  width="10" rowspan="3"> Área </th> <th width="5" rowspan="3">Descrição</th>';	
							echo '<th width="150" rowspan="3"> Histórico</th>';	
							echo '<th width="50" rowspan="3">Entrada(R$)</th>';	
							echo '<th width="50" rowspan="3">Saída(R$)</th>';	
							echo '<th width="50" rowspan="1">Saldo MÊS</th>';	
							echo '</tr> <tr><th> ',number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							echo '<tbody style="font-size:50%">';														
							echo '<tr>';
							echo '<td  colspan="9" ></td>  ';
							echo '<td bgcolor="yellow"  >',number_format($saldo_Ant, 2, ',', '.').'</td>';
                            echo '</tr>';							
													
								$primeiroReg = "N";
						}					
						if($row['ent_Sai'] == 0) {		$Sai = number_format($row['valorFin'], 2, ',', '.'); $ent = "";	}
						else if($row['ent_Sai'] == 1){ 	$ent = number_format($row['valorFin'], 2, ',', '.'); $Sai = "";}
							$val = $row['valorFin'];
							if($row['ent_Sai'] == 0) $total = $total - $val;
							else $total = $total + $val;
								$datX= implode('/',array_reverse(explode('-',$row['dataFin'])));
						
                    
						$html .=  '<tr heigth="100" >';
						$html .=  '<td>' . $row['id_fin'] . '</td>';                      
						$html .=  '<td bgcolor="yellow">' . $datX . '</td>';                      
						$html .=  '<td bgcolor="yellow">' .$row[$adm]. '</strong></td>';
						$html .=  '<td bgcolor="yellow">' .$row['num_Doc_Banco'] . '</td>';
                        $html .=  ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
						$html .=  '<td bgcolor="yellow" >' . $row['historico'] . '</td>';
						if($ent == 0) 
                            $html .=  '<td align="right">'.$ent.'</td>';
                        else 
                            $html .=  '<td bgcolor="yellow" align="right">'.$ent.'</td>';
						if($Sai == 0) 
                            $html .=  '<td align="right">'.$Sai.'</td>';
                        else 
                            $html .=  '<td bgcolor="yellow" align="right">'.$Sai.'</td>';
						$html .=  '<td align="right">'.number_format($total, 2, ',', '.').'</td>';
						$html .=  '</tr>';
                    
						echo '<tr  heigth="100" >';
						echo '<td  heigth="50">' . $row['id_fin'] . '</td>';                      
						echo '<td  heigth="50" bgcolor="yellow"  >' . $datX . '</td>';                      
						echo '<td  heigth="50" bgcolor="yellow">' .$row[$adm]. '</strong></td>';
						echo '<td  heigth="50" bgcolor="yellow">' .$row['num_Doc_Banco'] . '</td>';
                        echo ' <td  heigth="50">'.$admAr.'</td> <td>'.$admDesc.'</td>';
						echo '<td  heigth="50" bgcolor="yellow" >' . $row['historico'] . '</td>';
                        if($ent == 0) 
                            echo '<td  heigth="50" align="right">'.$ent.'</td>';
                        else 
                            echo '<td  heigth="50" bgcolor="yellow" align="right">'.$ent.'</td>';
                        if($Sai == 0) 
                            echo '<td  heigth="50x" align="right">'.$Sai.'</td>';
                        else 
                            echo '<td  heigth="50" bgcolor="yellow" align="right">'.$Sai.'</td>';
						echo '<td  heigth="50" align="right">'.number_format($total, 2, ',', '.').'</td>';
						echo '</tr>';
							
				}
                            
							$total =  number_format($total, 2, ',', '.');
                            $html .=  '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';
							$html .=  '<td bgcolor="green"  ><h4 align="right" valign=bottom >'.$total.'</h4></td></tr>';
							$html .=  '</tbody></table></br>';
                    
							echo '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                
                $html .=   '<br>';
                    echo '<br>';
                
                
          //PRESENTES PAGOS NO MÊS      >>>>>
                        switch ($caixa) 
					{						
						case 4:	$contN = "BR0214"; $cidadde = "Abreu e Lima"; $cdi = "1";     break;  
						case 5:	$contN = "BR0518"; $cidadde = "Paulista";     $cdi = "2";     break;  
						case 6:	$contN = "BR0542"; $cidadde = "Bezerros";     $cdi = "3";     break;  
						case 7:	$contN = "BR0549"; $cidadde = "Catende";      $cdi = "4";     break;
						case 8:	$contN = "BR0579"; $cidadde = "Jurema";       $cdi = "5";     break;  
                        case 99:$contN = "Todas contas"; break;  				
					}
                        $data_x1 = date($ano.'-'.$mes.'-01');
                        $data_x2 = ultimoDiaMes($data_x1);
                
                $presentes_pagos = mysqli_query($conex, 'SELECT * FROM presentes_especiais
													WHERE SUBSTRING(n_beneficiario,1,6) LIKE "'.$contN.'"  and valor_pendente < 1  
                                                    and data_presente >= "'.$data_x1.'" and data_presente <= "'.$data_x2.'"
									               ORDER BY  SUBSTRING(n_beneficiario,4,6), month(data_presente), n_protocolo, id_presente ASC'); 
                    if (!$presentes_pagos ) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									//exit;
					}		
            if (mysqli_num_rows($presentes_pagos) == 0 ) 
                {	echo "<br>Linha: ". __LINE__ ."<br><center><font color = red >Nao existem registros de presentes especiais!</font>";
                }
                else
                { 
                    
							$html .=   '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							$html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="4"></th> <th colspan="7" >PAGAMENTOS DE PRESENTES ESPECIAIS
							         </th> <th align="center" >Folha Nº6-1</th>  </tr>';							
							$html .=   '<tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							$html .=   '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							$html .=   '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							$html .=   '<tr><th colspan="9" style="font-size:70%"></th>';
							$html .=   ' </tr>';								
							$html .=   ' </tr >';
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro"><th width="60" rowspan="2"> Registro</th>';	
							$html .=   '<th width="60" >DATA</th>';	
							$html .=   '<th width="50" >NÚMERO DA CRIANÇA</th>';	
							$html .=   '<th width="360">NOME DA CRIANÇA</th>';	
							$html .=   '<th width="130" >MÊS/ANO DA LISTAGEM</th>';	
							$html .=   '<th width="80" >NÚMERO DO PROTOCOLO</th>';	
							$html .=   '<th width="80">VALOR RECEBIDO (ENTRADAS)</th>';	
							$html .=   '<th width="80">VALOR PAGO (SAÍDAS)</th>';	
							$html .=   '<th width="80">SALDO</th></tr>';	
							$html .=   '</thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr>';
							$html .=   '<td  colspan="7" align="right">SALDO INICIAL DO MÊS > > > > ></td>  ';
							$html .=   '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=   '</tr>';		
                   
                    
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							echo '<thead ><tr bgcolor="Gainsboro"><th ROWSPAN="5"></th> <th colspan="7" >PAGAMENTOS DE PRESENTES ESPECIAIS
							         </th> <th align="center" >Folha Nº6-1</th>  </tr>';							
							echo '<tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							echo '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="8" style="font-size:70%"></th>';
							echo ' </tr>';
							echo '<tr rowspan="3" bgcolor="Gainsboro" style="font-size:70%"><th width="60" rowspan="3"> Registro</th>';	
							echo '<th width="60" >DATA</th>';	
							echo '<th width="50" >NÚMERO DA CRIANÇA</th>';	
							echo '<th width="360" >NOME DA CRIANÇA</th>';	
							echo '<th width="130">MÊS/ANO DA LISTAGEM</th>';	
							echo '<th width="80">NÚMERO DO PROTOCOLO</th>';	
							echo '<th width="80">VALOR RECEBIDO (ENTRADAS)</th>';	
							echo '<th width="80">VALOR PAGO (SAÍDAS)</th>';	
							echo '<th width="80" >SALDO</th></tr>';	
							echo '</thead>';
							echo '<tbody style="font-size:70%">';														
							echo '<tr>';
							echo '<td></td><td  colspan="7" align="right">SALDO INICIAL DO MÊS > > > > ></td>  ';
							echo '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            echo '</tr>';		
                   

                    $total = 0;	$inicio = 1; $totalG = 0; $totalData = 0; $contaY = 0;
                    while ($rows_presentes = mysqli_fetch_assoc($presentes_pagos)) 
                    {	
                          //$data_Ch= implode('/',array_reverse(explode('-',$rows_presentes['dataFin'])));
                        $val_Ch= number_format($rows_presentes['valor_entrada'], 2, ',', '.');
                        $valor_pendente= number_format($rows_presentes['valor_pendente'], 2, ',', '.');
                        
                        $sqlDATAlanc = 'SELECT dataFin FROM aenpfin WHERE id_fin LIKE "'.$rows_presentes['id_entrada'].'" limit 1';
                        $presentes_sqlDATAlanc = mysqli_query($conex, $sqlDATAlanc);
                        
                         while ($rows_sqlDATAlanc = mysqli_fetch_assoc($presentes_sqlDATAlanc))
                         { $mesPresente_Entrada =  $rows_sqlDATAlanc['dataFin'];}
                        
                           $mes_extenso = array(
                            'Jan' => 'Janeiro', 'Feb' => 'Fevereiro', 'Mar' => 'Marco', 'Apr' => 'Abril', 
                            'May' => 'Maio', 'Jun' => 'Junho', 'Jul' => 'Julho', 'Aug' => 'Agosto', 
                            'Sep' => 'Setembro', 'Oct' => 'Outubro', 'Nov' => 'Novembro', 'Dec' => 'Dezembro'
                        );
                        $mesPresente_Entrada = date('M', strtotime($mesPresente_Entrada));

                        $mes_extenso = $mes_extenso[$mesPresente_Entrada] ;
                        	
                        
                            $html .=    '<tr  bgcolor="Yellow">';
                            $html .=    ' <td bgcolor="white">'.$rows_presentes['id_presente'].'</td> 
                            <td><strong>'.$rows_presentes['data_presente'].'</td>';
                            $html .=    '<td align="right">'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                            $html .=    '<td align="right">'.$mes_extenso.' -- '.$ano.'</td>';
                            $html .=    '<td align="right">'.$rows_presentes['n_protocolo'].'</td>';
                           	$html .=    '<td align="right">'.$rows_presentes['valor_entrada'].'</td> 
                            <td align="right">'.$rows_presentes['valor_saida'].'</td> <td bgcolor="white"></td> </tr>';
                           		
                            echo '<tr  bgcolor="Yellow">';
                            echo ' <td bgcolor="white">'.$rows_presentes['id_presente'].'</td> 
                            <td><strong>'.$rows_presentes['data_presente'].'</td>';
                            echo '<td align="right">'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                            echo '<td align="right">'.$mes_extenso.' -'.$ano.'</td>';
                            echo '<td align="right">'.$rows_presentes['n_protocolo'].'</td>';
                           	echo '<td align="right">'.$rows_presentes['valor_entrada'].'</td> 
                            <td align="right">'.$rows_presentes['valor_saida'].'</td> <td bgcolor="white"></td></tr>';
                           							
                              //  $total += $rows_presentes['valor_pendente'];
                            
                    } 	
                   $html .=    '<tr><td colspan="9"></td> </tr>';
                            
                    
                    $html .=   '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                    echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante

                }
                 $html .=   '<br>';
                    echo '<br>';
                
          //RECONCILIAÇÃO BANCÁRIA      >>>>>
           	$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
                            WHERE id_fin = id_aenp and  conta like '.$caixa.' and status like 0 ORDER BY dataFin ');
            if (mysqli_num_rows($cheques_abertos) == 0 ) 
                {	echo "<center><font color = red >Nao existem registros de cheques á compensar!</font>";
                }else
                if (mysqli_num_rows($cheques_abertos) > 0 )
                {
                   
							$contaBanco = mysqli_query($conex, 'SELECT * FROM caixas
                                                        WHERE id_caixa like '.$caixa.' LIMIT 1');
                        if (mysqli_num_rows($contaBanco) == 0 ) 
                            {	echo "<center><font color = red >Nao encontrada conta!</font>"; exit;
                            }
                    
                            while ($rows_contaBanco = mysqli_fetch_assoc($contaBanco)) 
                                {
                                $nomecaixa = $rows_contaBanco['nome_caixa'];
                                $banco = $rows_contaBanco['banco'];
                                $agencia = $rows_contaBanco['agencia'];
                                $n_conta = $rows_contaBanco['n_conta'];
                                }
                    
                            $html .=  '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							$html .=  '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th bgcolor="white"  ROWSPAN="9"></th> <th colspan="7" >RECONCILIAÇÃO BANCARIA
							         </th> <th align="center" >Folha Nº3</th>  </tr>';							
							$html .=  '<tr><th colspan="8">.</th></tr><tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							$html .=  '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=  '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							$html .=  '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							$html .=  '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							$html .=  '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							$html .=  '<tr><th colspan="8">.</th> </tr>';
							$html .=  '<tr bgcolor="Gainsboro"><th colspan="8" >SALDO DO EXTRATO BANCÁRIO <br> (Conforme aparece no extrato) </th>  </tr>';		
							$html .=  '<tr><th width="130">BANCO</th> <th bgcolor="yellow" >'.$banco.'</th> <th width="130">AGENCIA</th> <th bgcolor="yellow" >'.$agencia.'</th>';		
							$html .=  '<th width="130">CONTA Nº</th> <th bgcolor="yellow" width="130">'.$n_conta.'</th> <th>SALDO</th> <th bgcolor="yellow" >SALDO</th> </tr>';		
							$html .=  '<tr><th colspan="8" >.</th> </tr>';
							
							$html .=  ' </tr >';
							$html .=  '<tr bgcolor="Gainsboro" ><th width="60" > Registro</th>';	
							$html .=  '<th width="60" >DATA</th>';	
							$html .=  '<th width="50" colspan="5">HISTÓRICO</th>';	
							$html .=  '<th width="360" >Nº CHEQUE</th>';	
							$html .=  '<th width="130" >VALOR</th>';
							$html .=  '</tr>';	
							$html .= '</thead>';		
                            $html .=  '<tbody bgcolor="yellow"  style="font-size:100%">';
                    
                    
                            echo '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							echo '<thead ><tr bgcolor="Gainsboro"><th bgcolor="white"  ROWSPAN="9"></th> <th colspan="7" >RECONCILIAÇÃO BANCARIA
							         </th> <th align="center" >Folha Nº3</th>  </tr>';							
							echo '<tr><th colspan="8">.</th></tr><tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							echo '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="8" style="font-size:70%">.</th> </tr>';
							echo '<tr bgcolor="Gainsboro"><th colspan="9" >SALDO DO EXTRATO BANCÁRIO <br> (Conforme aparece no extrato) </th>  </tr>';		
							echo '<tr style="font-size:80%"><th width="130">BANCO</th> <th bgcolor="yellow" >'.$banco.'</th> <th width="130">AGENCIA</th> <th bgcolor="yellow" >'.$agencia.'</th>';		
							echo '<th width="130">CONTA Nº</th> <th bgcolor="yellow" width="130">'.$n_conta.'</th> <th>SALDO</th> <th bgcolor="yellow" >SALDO</th> </tr>';		
							echo '<tr><th colspan="8" style="font-size:70%">.</th> </tr>';							
							echo ' </tr >';
							echo '<tr bgcolor="Gainsboro" style="font-size:70%"><th width="60" > Registro</th>';	
							echo '<th width="60" >DATA</th>';	
							echo '<th width="50" colspan="5">HISTÓRICO</th>';	
							echo '<th width="360" >Nº CHEQUE</th>';	
							echo '<th width="130" >VALOR</th>';
							echo '</tr>';	
							echo '</thead>';		
                            echo '<tbody bgcolor="yellow"  style="font-size:70%">';
                    
                    
                    $total = 0;	$inicio = 1; 
                    while ($rows_chek = mysqli_fetch_assoc($cheques_abertos)) 
                    {	switch ($rows_chek['conta']) 
                        {
                            case 1:	$contaN = "IEADALPE - 1444-3"; $cor = '#9b0f0f';  break;    
                            case 2:	$contaN = "22360-3"; $cor = '#dd9431'; break;  
                            case 3:	$contaN = "ILPI"; $cor = '#B266FF';break;  
                            case 4:	$contaN = "BR214"; $cor = '#aa3636'; break;  
                            case 5:	$contaN = "BR518"; $cor = '#B266FF'; break;  
                            case 6:	$contaN = "BR542";$cor = '#2d3607'; break;  
                            case 7:	$contaN = "BR549"; $cor = '#23862e'; break;  
                            case 8:	$contaN = "BR579"; $cor = '#7562c3'; break;  
                            case 9:	$contaN = "BB 28965-5"; break;  
                            case 10:$contaN = "CEF 1948-4"; break;
                            case 99:$contaN = "Todas contas"; break;  				
                        }		
                        $data_Ch= implode('/',array_reverse(explode('-',$rows_chek['dataFin'])));
                        $val_Ch= number_format($rows_chek['valorFin'], 2, ',', '.');
                        $total = $total + $rows_chek['valorFin'];
                        {	
                            $html .=  '</td> <td>'.$rows_chek['id_fin'].'</td> <td>'.$data_Ch.'</td>';
                            $html .=  '<td colspan="5">'.$rows_chek['historico'].'</td> <td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$val_Ch.'</td>';
                            $html .=  '</tr>';
                            
                            echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td>'.$data_Ch.'</td>';
                            echo '<td colspan="5">'.$rows_chek['historico'].'</td> <td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$val_Ch.'</td>';
                            echo '</tr>';
                            $total = $total + $rows_chek['valorFin'];
                          //  $inicio = 0;
                        }
                            }	
                    } 	
                        $val_Ch= number_format($total, 2, ',', '.');
                
                        $html .= '<tr bgcolor="Gainsboro"> <td></td> <td colspan="7">TOTAL DE CHEQUES PENDENTES:.....................................</td>';	
                        $html .= '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                         $html .= '<tr><td colspan="8"  bgcolor="white">.</td> </tr>';
				        $html .= '<tr bgcolor="Gainsboro" > <td></td> <td colspan="7">SALDO BANCÁRIO AJUSTADO:.....................................</td>';	
                        $html .= '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                        $html .= '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                        echo '<tr bgcolor="Gainsboro"> <td></td> <td colspan="7">TOTAL DE CHEQUES PENDENTES:.....................................</td>';	
                        echo '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                         echo '<tr><td colspan="8"  bgcolor="white">.</td> </tr>';
				        echo '<tr bgcolor="Gainsboro" > <td></td> <td colspan="7">SALDO BANCÁRIO AJUSTADO:.....................................</td>';	
                        echo '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                        echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                    $_SESSION['html'] = $html;
                } 
            else if($adm == "cod_assoc" )
            {
				while ($row = mysqli_fetch_assoc($result)) 
				{ 				
					if($row['tipo_Conta'] == "Corrente"){$saldo_Ant = 	$saldo_Ant_Corr;	$tipo_Conta_Atual = 1;	$abrev = "C/C:";}else		
					if($row['tipo_Conta'] == "Suporte")	{$saldo_Ant = 	$saldo_Ant_Sup;		$tipo_Conta_Atual = 2;	$abrev = "C/S:";}else
					if($row['tipo_Conta'] == "Poupança"){$saldo_Ant = 	$saldo_Ant_Poup;	$tipo_Conta_Atual = 3;	$abrev = "C/P:";}	
                    
					/*{$admN = "Compassion"; $adm_C = "cod_compassion";  $admCod = "cod_Comp";  $admArea = "area_Cod";  $admDescri = "descricao";}*/
                    //echo $adm.' - codigo do registro $row[$adm} - ] '.$row[$adm].' -  $admCod '.$admCod.' - ';
                    
               //Procura o nome da Área e da Descrição refente ao código Assoc da linha selecionada     
                    $sqlCod = 'SELECT * FROM  cod_assoc WHERE  cod_Ass  = "'.$row[$adm].'" limit 1';
                        $queryCodigo = mysqli_query($conex, $sqlCod);
                    
                    if (!$queryCodigo ) 
					{
								die ("<center>Desculpe, Erro ao tentar procurar o código IEADALPE ".$row[$adm].", Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									//exit;
					}
				if (mysqli_num_rows($queryCodigo) == 0 ) 
				{	echo '<br>Linha: ' . __LINE__ . '<br> O código '.$row[$adm].' pode não esta registrado devidamente. Tente novamente!';  
                    $admAr = "Não encontrado"; $admDesc = "Não encontrado"; 
                    // exit;
				} else			
                    while($cod_row = mysqli_fetch_assoc($queryCodigo)) { $admAr = $cod_row[$admArea]; $admDesc = $cod_row[$admDescri]; }
                    
                   // echo '<br /><font color=red size="3"> Coluna '.$adm_C. ' | Area '.$admAr.' | descri '.$admDesc.' | Codigo '.$row[$adm].' | <td></font><br /><br />';
                   
					if($tipo_Contas == 0)
						{$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; $total = $saldo_Ant;
						}else	if($tipo_Contas <> $tipo_Conta_Atual)
						{	$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; 
							$total =  number_format($total, 2, ',', '.');
						  $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          $html .=  '<td></td>'; 
                          
                            $html .=  '<td colspan="2">Saldo Final R$ </td>';	
							$html .=  '<td bgcolor="green"><h4 align="right" valign=bottom >'.$total.'</h4></td>';
				            $html .=  '</tr>';
							$html .= '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							$html .=  "<div style='page-break-before:always;'> </div>";
 
							echo '<td></td> <td></td> <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;	
						}	
						if($primeiroReg == "S") 
						{
							
							$html .= '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							$html .=  '<thead bgcolor="Gainsboro" ><tr><th></th> <th rowspan="5" colspan="5" bgcolor="white" > 
							<img class="imagefloat" src="aenpazVertical.png" alt="" width="90" height="75" border="0">  				
							</th> <th colspan="4" align="center" >RELATÓRO ANALÍTICO</th>  </tr>';							
							$html .=  '<tr><th></th> <th colspan="4" align="center"  align="center" ><font color="red">Conta contábil '.$admN.' - '.$caixaNome.'</font></th> </tr>';
							$html .=  '<tr><th></th> <th colspan="4" bgcolor="white" align="center" >'.$mesN.' de '.$ano.'</th> </tr>';
							$html .=  '<tr><th></th> <th rowspan="2" colspan="1" align="center" width="100"><font color="red">Conta  '.$row['tipo_Conta'].'</font></th> 
							<th colspan="2" align="center" > Banco: <font color="red">'.$banco.'</font></th> 
							<td rowspan="2" align="center" ><strong> '.$abrev.' </br><font color="red">'.$n_conta.'</font></strong></td> </tr>';
							$html .=  '<tr><th></th> <th colspan="2" align="center" > Agência: <font color="red">'.$agencia.'</font></th> </tr>';
							
							//echo '<table border=1 bgcolor="yellow" width="100%">';	
							//echo '<thead><tr>';
							$html .=  '<th width="60"Registro</th>';	
							$html .=  '<th width="60">Data</th>';	
							$html .=  '<th width="50">Código</th>';	
							$html .=  '<th width="60">Doc Bancário</th>';	
							$html .=  '<th> Área </th> <th> Descrição </th>';	
							$html .=  '<th width="350">Histórico</th>';	
							$html .=  '<th width="80">Entrada valor (R$)</th>';	
							$html .=  '<th width="80">Saída valor (R$)</th>';	
							$html .=  '<th width="80">Saldo do mês anterior (R$)</th>';	
							$html .=  '</tr></thead>';
							$html .=  '<tbody style="font-size:70%">';
							$html .=  '<tr>';
							$html .=  '<td></td> <td></td> <td></td>  <td></td> <td></td>';
							$html .=  '<td></td><td></td><td></td><td></td>';
							$html .=  '<td bgcolor="yellow"  ><h4 align="right" valign=bottom >'.number_format($saldo_Ant, 2, ',', '.').'</h4></td>';
                            $html .=  '</tr>';		
                            
                            
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							echo '<thead bgcolor="Gainsboro" ><tr><th></th> <th rowspan="5" colspan="5" bgcolor="white" > 
							<img class="imagefloat" src="aenpazVertical.png" alt="" width="90" height="75" border="0">  				
							</th> <th colspan="4" align="center" >RELATÓRO ANALÍTICO</th>  </tr>';							
							echo '<tr><th></th> <th colspan="4" align="center"  align="center" ><font color="red">Conta contábil '.$admN.' - '.$caixaNome.'</font></th> </tr>';
							echo '<tr><th></th> <th colspan="4" bgcolor="white" align="center" >'.$mesN.' de '.$ano.'</th> </tr>';
							echo '<tr><th></th> <th rowspan="2" colspan="1" align="center" width="100"><font color="red">Conta  '.$row['tipo_Conta'].'</font></th> 
							<th colspan="2" align="center" > Banco: <font color="red">'.$banco.'</font></th> 
							<td rowspan="2" align="center" ><strong> '.$abrev.' </br><font color="red">'.$n_conta.'</font></strong></td> </tr>';
							echo '<tr><th></th> <th colspan="2" align="center" > Agência: <font color="red">'.$agencia.'</font></th> </tr>';
							
							//echo '<table border=1 bgcolor="yellow" width="100%">';	
							//echo '<thead><tr>';
							echo '<th width="60"Registro</th>';	
							echo '<th width="60">Data</th>';	
							echo '<th width="50">Código</th>';	
							echo '<th width="60">Doc Bancário</th>';	
							echo '<th> Área </th> <th> Descrição </th>';	
							echo '<th width="350">Histórico</th>';	
							echo '<th width="80">Entrada valor (R$)</th>';	
							echo '<th width="80">Saída valor (R$)</th>';	
							echo '<th width="80">Saldo do mês anterior (R$)</th>';	
							echo '</tr></thead>';
							echo '<tbody style="font-size:50%">';														
							echo '<tr>';
							echo '<td></td> <td></td> <td></td>  <td></td> <td></td>';
							echo '<td></td><td></td><td></td><td></td>';
							echo '<td bgcolor="yellow"  ><h4 align="right" valign=bottom >',number_format($saldo_Ant, 2, ',', '.').'</h4></td>';
							//	echo '<td></td>';
                            echo '</tr>';							
													
								$primeiroReg = "N";
						}					
						if($row['ent_Sai'] == 0) {		$Sai = number_format($row['valorFin'], 2, ',', '.'); $ent = "";	}
						else if($row['ent_Sai'] == 1){ 	$ent = number_format($row['valorFin'], 2, ',', '.'); $Sai = "";}
							$val = $row['valorFin'];
							if($row['ent_Sai'] == 0) $total = $total - $val;
							else $total = $total + $val;
								$datX= implode('/',array_reverse(explode('-',$row['dataFin'])));
						
                    
						$html .=  '<tr>';
						$html .=  '<td>' . $row['id_fin'] . '</td>';                      
						$html .=  '<td>' . $datX . '</td>';                      
						$html .=  '<td>' .$row[$adm]. '</strong></td>';
						$html .=  '<td>' .$row['num_Doc_Banco'] . '</td>';
                        $html .=  ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
                       // echo ' <td>A '.$admAr.'  </td> <td>D '.$admDesc .'</td>';
                    
						//echo '<td>' . $row['num_Doc_Fiscal'] . '</td>';
						$html .=  '<td>' . $row['historico'] . '</td>';
						$html .=  '<td><h4 align="right" valign=bottom  >'.$ent.'</h4></td>';
						$html .=  '<td><h4 align="right" valign=bottom  >'.$Sai.'</h4></td>';
						$html .=  '<td><h4 align="right" valign=bottom  >'.number_format($total, 2, ',', '.').'</h4></td>';
						$html .=  '</tr>';
                    
						echo '<tr>';
						echo '<td>' . $row['id_fin'] . '</td>';                      
						echo '<td>' . $datX . '</td>';                      
						echo '<td>' .$row[$adm]. '</strong></td>';
						echo '<td>' .$row['num_Doc_Banco'] . '</td>';
                        echo ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
                       // echo ' <td>A '.$admAr.'  </td> <td>D '.$admDesc .'</td>';
                    
						//echo '<td>' . $row['num_Doc_Fiscal'] . '</td>';
						echo '<td>' . $row['historico'] . '</td>';
						echo '<td><h4 align="right" valign=bottom  >',$ent.'</h4></td>';
						echo '<td><h4 align="right" valign=bottom  >',$Sai.'</h4></td>';
						echo '<td><h4 align="right" valign=bottom  >',number_format($total, 2, ',', '.').'</h4></td>';
						echo '</tr>';
							
				}
                            $html .=  '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';
							$html .=  '<td bgcolor="green"  ><h4 align="right" valign=bottom >'.$total.'</h4></td></tr>';
							$html .=  '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante 
                    
                    $_SESSION['html'] = $html;
							$total =  number_format($total, 2, ',', '.');
							echo '<td></td> <td></td>  <td></td> <td></td> <td></td><td></td><td></td><td colspan="2">Saldo Final R$ </td>';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                }
                   
			}else 
			if( $tipoCons == 10 || $tipoCons == 1)
			{
				//echo '<font color=red size="3"> Relatório '.$admN. ' | caixa '.$caixaNome. '  | Mês '.$mesN. '  | dia mes anterior '.$data_mes_Anterior.'<td></font><br />';
				$contas = 0; $tipo_Contas = 0; 
				if($tipoCons == 1) {$saldo_noInicio = ""; $saldo_noFim = "Total R$";}
				else {$saldo_noInicio = ""; $saldo_noFim = "Total R$";}
				$t_e = 0; $t_Sai = 0;
				while ($row = mysqli_fetch_assoc($result)) 
				{
					/*if($tipoCons == 1) 
					{	$tot = $row['valorFin'];
						if($termo == "2")
						{$en_Sai = $row['ent_Sai'];
						if ($en_Sai == 0) {$total = $total - $tot;//$valorFin;
						}else if ($ent_Sai == 1){$total = $total + $tot;}						
						}														
						$total = $tot + $total;
					}else {$total = $row['saldo'];}
					*/
					$conta = $row['conta'];
					switch ($conta) 
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
					if($row['tipo_Conta'] == "Corrente"){$tipo_Conta_Atual = 1;	$abrev = "C/C:";}else						
					if($row['tipo_Conta'] == "Suporte")	{$tipo_Conta_Atual = 2;	$abrev = "C/S:";}else
					if($row['tipo_Conta'] == "Poupança"){$tipo_Conta_Atual = 3;	$abrev = "C/P:";}					
					
					if($contas  == 0)
						{$primeiroReg = "S";	$contas = $conta; 	$tipo_Contas = $tipo_Conta_Atual; $total = 0;
						}else	 
						if($conta <> $contas)
						{$primeiroReg = "S";	$contas = $conta; 	$tipo_Contas = $tipo_Conta_Atual;
							$t_en = number_format($t_e, 2, ',', '.'); $t_Said = number_format($t_Sai, 2, ',', '.');
							$tot = $t_e - $t_Sai;
							$total =  number_format($tot, 2, ',', '.');
							echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">"'.$saldo_noFim.'"</td><td></td> <td>',$t_en.'</td> <td>',$t_Said.'</td> ';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante							
							$total = 0; $t_e = 0; $t_Sai = 0;
						}else	
						if($tipo_Contas <> $tipo_Conta_Atual)
						{	$primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; 
							$t_en = number_format($t_e, 2, ',', '.'); $t_Said = number_format($t_Sai, 2, ',', '.');
							$tot = $t_e - $t_Sai;
							$total =  number_format($tot, 2, ',', '.');
							echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">"'.$saldo_noFim.'"</td><td></td> <td>',$t_en.'</td> <td>',$t_Said.'</td> ';	
							echo '<td bgcolor="yellow"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante							
							$total = 0;	$t_e = 0; $t_Sai = 0;
						}	
						if($primeiroReg == "S") 
						{						if(!(isset( $mesN)))  { $mesN = "";}
                                                if(!(isset( $ano))){ $ano = "";}
                                                if(!(isset( $banco))){ $banco = "";}
                                                if(!(isset( $n_conta))){ $n_conta = "";}
                                                if(!(isset( $agencia))){ $agencia = "";}
                                                if(!(isset( $saldo_Ant))){ $saldo_Ant = 0;}	
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="830">';
							echo '<thead bgcolor="Grey"><tr><th rowspan="5" colspan="5" bgcolor="white" > 
							<img class="imagefloat" src="aenpazVertical.png" alt="" width="90" height="75" border="0">  				
							</th> <th colspan="5" align="center" >RELATÓRO ANALÍTICO</th>  </tr>';							
							echo '<tr> <th colspan="5" align="center"  align="center" font color=red >Conta contábil Compassion - '.$caixaNome.'</th> </tr>';
							echo '<tr> <th colspan="5" bgcolor="white" align="center" >'.$mesN.' de '.$ano.'</th> </tr>';
							echo '<tr> <th rowspan="2" colspan="2" align="center" >Conta  '.$row['tipo_Conta'].'</th> <th colspan="2" align="center" > Banco: '.$banco.'</th> <td rowspan="2" align="center" > '.$abrev.' '.$n_conta.'</td> </tr>';
							echo '<tr> <th colspan="2" align="center" > Agência: '.$agencia.'</th> </tr>';							
							
							echo '<th width="60">Reg</th>';	
							echo '<th width="50">Data</th>';	
							echo '<th width="50">IEADALPE</th>';
							echo '<th width="50">Compass</th>';	
							echo '<th width="60">Doc Bancário</th>';
							echo '<th width="60">Doc Fiscal</th>';
							echo '<th width="350">Histórico</th>';	
							echo '<th width="80">Entrada valor (R$)</th>';	
							echo '<th width="80">Saída valor (R$)</th>';	
							echo '<th width="80">Saldo (R$)</th>';	
							echo '</tr></thead>';
							echo '<tbody style="font-size:70%">';	
							
								echo '<tr>';
								echo '<td></td> <td></td> <td></td> <td></td> <td></td> <td></td>';
								echo '<td></td> <td colspan="2">"'.$saldo_noInicio.'"</td>';
								echo '<td bgcolor="yellow"  ><h4 align="right" valign=bottom >',number_format($saldo_Ant, 2, ',', '.').'</h4></td>';
								echo '<td></td>';echo '</tr>';													
								$primeiroReg = "N";
						}					
						if($row['ent_Sai'] == 0) {	$t_Sai = $t_Sai + $row['valorFin']; 
						$Sai = number_format($row['valorFin'], 2, ',', '.'); $ent = "";	}
						else if($row['ent_Sai'] == 1){ $t_e = $t_e + $row['valorFin']; 
						$ent = number_format($row['valorFin'], 2, ',', '.'); $Sai = "";}
						$datX= implode('/',array_reverse(explode('-',$row['dataFin'])));
						$cod_compassion = $row['cod_compassion'];
                        $id_fin = $row['id_fin'];
                    
						echo '<tr>';
						echo '<td>' . $id_fin . '</td>';
						echo '<td>' . $datX . '</td>';
						echo '<td>' . $row['cod_assoc'] . '</strong></td>';
						echo '<td>' . $cod_compassion. '</strong></td>';
						echo '<td>' . $row['num_Doc_Banco'] . '</td>';
						echo '<td>' . $row['num_Doc_Fiscal'] . '</td>';
                    $historico = $row['historico'];
                    
                    if($cod_compassion == ( "D06-010"))//Saída com presentes especiais
						{
                          $presentes_saida = mysqli_query($conex, 'SELECT * FROM presentes_especiais
													WHERE  id_saida =  '.$id_fin.' LIMIT 1');
                        if (!$presentes_saida || mysqli_num_rows($presentes_saida ) == 0  ) 
								{			
                                	
								}
								else
                          while ($rows_presentes = mysqli_fetch_assoc($presentes_saida)) 
								{				
												$historico = $historico." - Pres Esp ".$rows_presentes['n_beneficiario'];
                                    
								}		  
                        }
						echo '<td>' .$historico .'</td>';
						echo '<td><h4 align="right" valign=bottom  >',$ent.'</h4></td>'; //- '.$caixaNome.' - '.$abrev.'
						echo '<td><h4 align="right" valign=bottom  >'.$Sai.'</h4></td>';
						echo '<td><h4 align="right" valign=bottom  ></h4></td>';
						echo '</tr>';							
				}
				
					
							$t_en = number_format($t_e, 2, ',', '.'); $t_Said = number_format($t_Sai, 2, ',', '.');
							$tot = $t_e - $t_Sai;
							$total =  number_format($tot, 2, ',', '.');
							echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">"'.$saldo_noFim.'"</td><td></td> <td>',$t_en.'</td> <td>',$t_Said.'</td> ';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante							
							
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante		
			}else 
			if( $tipoCons == 11)
			{
				while ($row = mysqli_fetch_assoc($result))					
				{		
						$conta = $row['conta'];
						$id_fin = $row['id_fin'];
						$dataFin = $row['dataFin'];
						$tipo_Conta = $row['tipo_Conta'];
						$cod_compassion = $row['cod_compassion'];
						$cod_assoc = $row['cod_assoc'];
						$num_Doc_Banco = $row['num_Doc_Banco'];
						$num_Doc_Fiscal = $row['num_Doc_Fiscal'];
						$historico = $row['historico'];
						$descricao = $row['descricao'];
						$valorFin = $row['valorFin'];
						$ent_Sai = $row['ent_Sai'];						
						$salddo = $row['saldo'];	
                    	
						
						echo 'Registro <strong>' . $id_fin . '</strong> | ';
						$dataL= implode('/',array_reverse(explode('-',$dataFin)));
						switch ($conta) 
					{
						case 1:	$contaNome = "IEADALPE - 1444-3"; break;    
						case 2:	$contaNome = "22360-3"; break;  
						case 3:	$contaNome = "ILPI"; break;  
						case 4:	$contaNome = "BR214"; break;  
						case 5:	$contaNome = "BR518"; break;  
						case 6:	$contaNome = "BR542"; break;  
						case 7:	$contaNome = "BR549"; break;  
						case 8:	$contaNome = "BR579"; break;  
						case 9:	$contaNome = "BB 28965-5"; break;  
						case 10:$contaNome = "CEF 1948-4"; break;
						case 99:$contaNome = "Todas contas"; break;  				
					}							
						echo 'Data <strong>' . $dataL . '</strong> |  <br/>';
						
						$result_chek = mysqli_query($conex, "SELECT id_reconc FROM reconc_bank WHERE id_aenp = ".$termo."  ");
							if (!$result_chek  ) 
							{			die ("<center>Desculpe, Não foi encontrado nenhum item com esse criterio. Tente novamente!  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										//exit;
							}
							if (mysqli_num_rows($result_chek ) == 0 ) 
							{	echo 'Número do documento bancário <strong>' .$num_Doc_Banco. '</strong> | ';
							}else								
							echo 'Pagamento em  <strong>cheque Nº ' . $num_Doc_Banco. '</strong> | ';
                            echo 'Número do documento fiscal <strong>' . $num_Doc_Fiscal. '</strong> | <br/>';
						
						echo 'Razão Social ' .$historico. ' |  <br/>';
						echo 'Descrição ' .$descricao. ' |  <br/>';
						echo "Conta -  ";
						echo "<strong><td>".stripslashes($contaNome)."</td></strong>";
						echo " - Conta <strong>".$tipo_Conta."</strong> |  ";
								if($ent_Sai == "1") { $entr_S = "Entrada de "; }else
								if($ent_Sai == "0") $entr_S = "Saída de ";
						echo " - ".$entr_S;
						echo "</b>  <strong><td> R$  ",number_format(str_replace(",",".",$valorFin ), 2, ',', '.'),"</td></strong></br>";
					 //  echo " Codigo compassion - ".$cod_compassion;
					  // echo " Codigo IEADALPE  - ".$cod_assoc."<br>";
					$resultcomp = mysqli_query($conex, 'SELECT * FROM cod_compassion WHere cod_Comp like "'.$cod_compassion.'"');
							if (!$resultcomp) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
					if (mysqli_num_rows($resultcomp) == 0 ) 
					//if (mysqli_num_rows($result1) == 0 ) 
					{
						echo "Não foi encontrado nenhuma refeência do codigo Compassion ".$cod_compassion."<br>";
					   //exit;
					}
					while ($rowcomp = mysqli_fetch_assoc($resultcomp)) 
							{echo "Codigo Compassion -x- ";
								echo " <strong><td>".stripslashes($rowcomp['cod_Comp'])."</strong> - ".stripslashes($rowcomp['descricao'])."</td><br/>";
							}
					$resultass = mysqli_query($conex, 'SELECT * FROM cod_assoc WHere  cod_Ass = "'.$cod_assoc.'"');
							if (!$resultass) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
					if (mysqli_num_rows($resultass) == 0 ) 
					//if (mysqli_num_rows($result1) == 0 ) 
					{
						echo "Nao foi encontrado nenhuma refeência do código IEADALPE ".$cod_assoc."<br>";
					  // exit;
					}
					while ($rowass = mysqli_fetch_assoc($resultass)) 
						{echo "Codigo Aenpaz -- ";
					echo " <strong><td>".stripslashes($rowass['cod_Ass'])."</strong> - ".stripslashes($rowass['descricao_Ass'])."</td><br/><br/>";
						}
							
					}/*		
					echo "Codigo Aenpaz -- ";
						echo " <strong><td>".stripslashes($cod_assoc)."</strong> </td><br/>";
					echo "Codigo Compassion -- ";
						echo " <strong><td>".stripslashes($cod_compassion)."</strong> </td><br/>";
				
				echo 	'"<input name = id_conta  type = hidden value= "'.$id_conta.'"/>"';
				echo 	'"<input name = dataFin  type = hidden value= "'.$dataFin.'"/>"';
				echo 	'"<input name = conta  type = hidden value= "'.$conta.'"/>"';
				echo 	'"<input name = tipo_Conta  type = hidden value= "'.$tipo_Conta.'"/>"';
				echo 	'"<input name = cod_assoc  type = hidden value= "'.$cod_assoc.'"/>"';
				echo 	'"<input name = cod_compassion  type = hidden value= "'.$cod_compassion.'"/>"';
				echo 	'"<input name = num_Doc_Banco  type = hidden value= "'.$num_Doc_Banco.'"/>"';
				echo 	'"<input name = num_Doc_Fiscal  type = hidden value= "'.$num_Doc_Fiscal.'"/>"';
				echo 	'"<input name = hist  type = hidden value= "'.$historico.'"/>"';
				echo 	'"<input name = valorFin  type = hidden value= "'.$valorFin.'"/>"';
				echo 	'"<input name = ent_Sai  type = hidden value= "'.$ent_Sai.'"/>"';
					*/		
							
			}else
			{				
				
                if(isset($_SESSION['tid_caixa'] ))                   
               {$tipContNome	=     $_SESSION['ttipoCont'];}  else {$tipContNome	= $_POST["tipContNome"];}
				while ($row = mysqli_fetch_assoc($result))
				{echo "Conta -  ";
					echo "<strong><td>".stripslashes($row['nome_caixa'])."</td></strong>";
					echo " - Conta ".$tipContNome."<br/><br/>";
				}
				while ($row1 = mysqli_fetch_assoc($result1)) 
				{echo "Codigo Aenpaz -- ";
					echo " <strong><td>".stripslashes($row1['cod_Ass'])."</strong> - ".stripslashes($row1['descricao_Ass'])."</td><br/><br/>";
				}
				while ($row2 = mysqli_fetch_assoc($result2)) 
				{echo "Codigo Compassion -- ";
                 
					echo " <strong><td>".stripslashes($row2['cod_Comp'])."</strong> - ".stripslashes($row2['descricao'])."</td><br/><br/>";
				}
			}
		}else
		if($tabela=='cod_assoc'){	
				//echo 'Opcao congregacao - Tipo   ',$tipo.', Termo  '.$termo.', Tabela '.$tabela. '  <td><br />';				
				echo '<table width="100%">';
				echo '<thead><tr>';	
				echo '<th>Código</th>';	
				echo '<th>Descrição</th>';
				echo '<th>função</th>';			
				echo '</tr></thead>';
				echo '<tbody style="font-size:80%">';
				while ($row = mysqli_fetch_assoc($result)) 
				{  	 
					echo '<tr>';
					echo '<td><strong>' . $row['cod_Ass'] . '</strong></td>';
					echo '<td>' . $row['descricao_Ass'] . '</td>';
					$entSai = $row['ent_SaiAss'];
					if($entSai == 0) $e_S ="Saída";					
					if($entSai== 1) $e_S ="Entrada";
					echo '<td>' .$e_S. '</td>';
					echo '</tr>';
				
					//echo "<strong><td>".$row["descricao_Ass"]."</td></strong>";
					$nome = $row["nome"];
					//echo ' - '.stripslashes($row['cod_Ass'])."<br/>";						
					}
					echo '</tbody></table>';
			}else
			if($tabela=='cod_compassion')
			{	
				//echo 'Opcao congregacao - Tipo   ',$tipo.', Termo  '.$termo.', Tabela '.$tabela. '  <td><br />';				
				echo '<table width="100%">';
				echo '<thead><tr>';
				echo '<th>Código</th>';	
				echo '<th>Descrição</th>';	
				echo '<th>Área</th>';	
				echo '<th>função</th>';			
				echo '</tr></thead>';
				echo '<tbody style="font-size:80%">';
				while ($row = mysqli_fetch_assoc($result)) 
				{  	 
					echo '<tr>';
					echo '<td><strong>' . $row['cod_Comp'] . '</strong></td>';
					echo '<td>' . $row['descricao'] . '</td>';
					echo '<td>' . $row['area_Cod'] . '</td>';
					$entSai = $row['ent_Sai'];
					if($entSai == 0) $e_S ="Saída";					
					if($entSai== 1) $e_S ="Entrada";
					echo '<td>' .$e_S. '</td>';
					echo '</tr>';
				
					//echo "<strong><td>".$row["descricao_Ass"]."</td></strong>";
					$nome = $row["nome"];
					//echo ' - '.stripslashes($row['cod_Ass'])."<br/>";						
					}
					echo '</tbody></table>';
			}else
				if($tabela=='funcionarios')
				{
					echo '<table border=1  width="100%">';
							echo '<thead bgcolor="Grey"><tr>';
							echo '<th>Codigo</th>';	
							echo '<th>Nome</th>';	
							echo '<th>Funcao</th>';		
							
							echo '<th>Endereco</th>';	
							echo '<th>Telefone</th>';	
							echo '<th>Sexo</th>';	
							echo '</tr></thead>';
							echo '<tbody style="font-size:80%">';
						
					while ($row = mysqli_fetch_assoc($result)) 
					{  	
							
						if($row['sexo'] ==  "m" || $row['sexo'] == "M" || $row['sexo'] == "masculino" 
						|| $row['sexo'] == "Masculino" || $row['sexo'] == "MASCULINO" )
						{
							$camp = "Masculino";
						}else
						{
							$camp = "Feminino";
						}														
								echo '<tr>';
								echo '<td>'.$row["codF"].'</td> <td>'.$row["nomeF"].'</td> <td>'.$row["funcao"];
								echo '<td>'.$row["logradouro"].', '.$row["numero"].', '.$row["bairro"].', </td> <td>';
								echo $row["cidade"].'</td> <td>'.$camp.'</td> </tr>';	
								
						
						$codF = $row['codF'];
						$nomeF = $row["nomeF"];
						$Endereco = $row["logradouro"];	
						$fone = $row["fone"];
						$numero = $row["numero"];
						$bairro = $row["bairro"];
						$cidade = $row["cidade"];
						$funcao = $row["funcao"];
						
						 //Exibe na tela a relação dos congregacao encontrados pelos criterios escolhidos
					}
					echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante							
				}else
					if($tabela=='comp_e_Assoc')
					{				
						echo '<table width="100%">';
						echo '<thead><tr>';
					//	echo '<th>Controle</th>';	
						echo '<th>Código</th>';	
						echo '<th>Descrição</th>';	
						echo '<th>Área</th>';	
						echo '<th>função</th>';			
						echo '</tr></thead>';
						echo '<tbody style="font-size:80%">';
						while ($row = mysqli_fetch_assoc($result)) 
						{  	 
							if($row['area']<> 'IEADALPE')
							{
								echo '<tr>';
								//echo '<td>Compassion </td>';
								echo '<td><strong>' . $row['cod_Comp'] . '</strong></td>';
								echo '<td>' . $row['descricao'] . '</td>';
								echo '<td>' . $row['area_Cod'] . '</td>';
								$entSai = $row['ent_Sai'];
								if($entSai == 0) $e_S ="Saída";					
								if($entSai== 1) $e_S ="Entrada";
								echo '<td>' .$e_S. '</td>';
								echo '</tr>';
							}else
							{
								echo '<tr>';
								//echo '<td>IEADALPE</td>';
								echo '<td><strong>' . $row['cod_Ass'] . '</strong></td>';
								echo '<td>' . $row['descricao_Ass'] . '</td>';
								echo '<td>' . $row['area'] . '</td>';								
								$entSai = $row['ent_SaiAss'];
								if($entSai == 0) $e_S ="Saída";					
								if($entSai== 1) $e_S ="Entrada";
								echo '<td>' .$e_S. '</td>';
								echo '</tr>';						
							}
						}	
							echo '</tbody></table>';
					}
                    if($tabela=='presentes_especiais')                        
					{
                        $mes1 = date( 'm', strtotime($data_00)); 
                        $mes2 = date( 'm', strtotime($data_02)); 
                        $anoo = date( 'y', strtotime($data_00));  
                        $ano2 = date( 'y', strtotime($data_02));
                  
                        if($anoo <> $ano2){$mes1 = $mes1.'/'.$anoo; $mes2 = " e ".$mes2."/".$ano2; $ano2 = " e ".$ano2;}else{ $ano2 = " "; 
                        $ano = date( 'Y', strtotime($data_00));
                        if($mes1 <> $mes2){$mes2 = " e ".$mes2;}else $mes2 = " ";} 
                        
                        echo '<table border=1 bgcolor="white" width="850">';
						echo '<thead bgcolor="Grey"><tr><th>*</th> <th>*</th> <th colspan="8" bgcolor="white" > 
						PAGAMENTO DE PRESENTES ESPECIAIS </th> </tr>';							
						echo '<tr> <tr><th>*</th> <th>*</th> <th  colspan="8" align="center" font color=red >Todos presentes recebidos e pagos no período</th> </tr>';
						echo '<tr> <th>*</th> <th>*</th> <th colspan="2" bgcolor="white" align="center" >Nome do projeto  </th>  <th colspan="4" bgcolor="white" align="center" >CDI NOVAS DE PAZ '.$cdi.' </th> <th>BR:</th>  <th>'.$contN.'</th> </tr>';
						echo '<tr> <th>*</th> <th>*</th> <th colspan="2" bgcolor="white" align="center" >Cidade</th>  <th colspan="4" bgcolor="white" align="center" >'.$cidadde.'</th> <th>Mês</th>  <th>'.$mes1.$mes2.'</th> </tr>';
						echo '<tr> <th>*</th> <th>*</th> <th colspan="2" bgcolor="white" align="center" >Estado</th>  <th colspan="4" bgcolor="white" align="center" >PE</th> <th>Ano</th>  <th>'.$ano.$ano2.'</th> </tr>';
							
							
							echo '<th>Reg Entrada</th>';	
							echo '<th >Reg Saída</th>';	
							echo '<th >Data</th>';	
							echo '<th >Número da criança</th>';
							echo '<th >Nome da criança</th>';	
							echo '<th >mês/Ano da listagem</th>';
							echo '<th >Número do protócolo</th>';;	
							echo '<th >valor Recebido (Entrada)</th>';	
							echo '<th >Valor pago (Saída)</th>';	
							echo '<th >Saldo (R$)</th>';	
							echo '</tr></thead>';
							echo '<tbody style="font-size:80%"><tr>
                            <td colspan="9">SALDO INICIAL DO MÊS >>>>>>></td> <td>COLOCAR SLADO</td></tr>';													
				$contas = 0; 
				
				$t_e = 0; $t_Sai = 0;
				while ($row = mysqli_fetch_assoc($result)) 
				{
					
					$conta = $row['SUBSTRING(n_beneficiario,4,6)'];
					$proto = $row['n_protocolo'];
                    		
					
					if($contas  == 0)
						{$primeiroReg = "S";	$contas = $conta; 	$total = 0;
						}
                 /*  	
					*/	if($primeiroReg == "S") 
						{	 $rimeiroReg = "N";}					
					
                         if($protoc == $proto)
                         {
                             if($detalhes == 1){
                              //          $t_e = $t_e + $row['valorFin']; 
                                $ent = number_format($row['valor_entrada'], 2, ',', '.');
                                $sai = number_format($row['valor_saida'], 2, ',', '.'); 
                                $pend = number_format($row['valor_pendente'], 2, ',', '.'); 
                                $datX= implode('/',array_reverse(explode('-',$row['data_presente'])));

                                echo '<tr>';
                                echo '<td>' . $row['id_entrada'] . '</td>';
                                echo '<td>' . $row['id_saida'] . '</td>';
                                echo '<td>' . $datX . '</td>';
                                echo '<td>' . $row['n_beneficiario'] . '</strong></td>';
                                echo '<td>' . $row['nome_beneficiario'] . '</strong></td>';
                                echo '<td>'.date( 'm', strtotime($row['data_presente']) ).'/'.date( 'y', strtotime($row['data_presente']) ).'</td>';
                                echo '<td>' . $proto . '</td>';
                                echo '<td>' . $ent . '</td>';
                                echo '<td>' . $sai . '</td>';
                                echo '<td>' . $pend . '</td>';
                                echo '</tr>';	
                             }
                             $t_Sai = $t_Sai + $row['valor_saida'];
                            $protoc = $proto;
                             $t_e = $row['valor_entrada'];
                             $n_benef = $row['n_beneficiario'];
                             $nome_benef = $row['nome_beneficiario'];
                             $protolo = $proto;
                             $mesAno = date( 'm', strtotime($row['data_presente']) ).'/'.date( 'y', strtotime($row['data_presente']) );
                             $datY= implode('/',array_reverse(explode('-',$row['data_presente'])));
                    
				}else {
                      //          $t_e = $t_e + $row['valorFin']; 
                          $ped =    $t_e - $t_Sai;
                    
                             $zero = $ped -$ped;
                          $pend =  $t_e - $t_Sai; 
						$t_e = number_format($t_e, 2, ',', '.');
						$t_Sai = number_format($t_Sai, 2, ',', '.');
						$pend = number_format($pend, 2, ',', '.');
                             if(($ped) > $zero && ($ped) < 3) {$cor = '#dd3831';}elseif(($ped) > $zero  ) $cor = '#dd9431';else $cor = '#70f5a3';
						echo '<tr style=" background-color: '.$cor.';">';
						echo '<td></td>';
						echo '<td></td>';
						echo '<td>' . $datY . '</td>';
						echo '<td>' . $n_benef . '</strong></td>';
						echo '<td>' . $nome_benef . '</strong></td>';
						echo '<td>'.$mesAno.'</td>';
						echo '<td>' . $protolo . '</td>';
						echo '<td>' . $t_e . '</td>';
						echo '<td>' . $t_Sai . '</td>';
						echo '<td>' . $pend . '</td>';
						echo '</tr>';
                        $t_e = 0;  $t_Sai = 0; $pend = 0;      
                         if($detalhes == 1){     
                            $ent = number_format($row['valor_entrada'], 2, ',', '.');
                            $sai = number_format($row['valor_saida'], 2, ',', '.'); 
                            $pend = number_format($row['valor_pendente'], 2, ',', '.'); 
                            $datX= implode('/',array_reverse(explode('-',$row['data_presente'])));

                            echo '<tr>';
                            echo '<td>' . $row['id_entrada'] . '</td>';
                            echo '<td>' . $row['id_saida'] . '</td>';
                            echo '<td>' . $datX . '</td>';
                            echo '<td>' . $row['n_beneficiario'] . '</strong></td>';
                            echo '<td>' . $row['nome_beneficiario'] . '</strong></td>';
                            echo '<td>'.date( 'm', strtotime($row['data_presente']) ).'/'.date( 'Y', strtotime($row['data_presente']) ).'</td>';
                            echo '<td>' . $proto . '</td>';
                            echo '<td>' . $ent . '</td>';
                            echo '<td>' . $sai . '</td>';
                            echo '<td>' . $pend . '</td>';
                            echo '</tr>';	
                         }
                            
                             $t_Sai = $t_Sai + $row['valor_saida'];
                                $protoc = $proto;
                                 $t_e = $row['valor_entrada'];      
                                 $n_benef = $row['n_beneficiario'];
                                 $nome_benef = $row['nome_beneficiario'];
                                 $protolo = $proto;
                                 $mesAno = date( 'm', strtotime($row['data_presente']) ).'/'.date( 'y', strtotime($row['data_presente']) );	
                                $datY= implode('/',array_reverse(explode('-',$row['data_presente'])));

                    
				}
                             
                }
				
					/*
							$t_en = number_format($t_e, 2, ',', '.'); $t_Said = number_format($t_Sai, 2, ',', '.');
							$tot = $t_e - $t_Sai;
							$total =  number_format($tot, 2, ',', '.');
							echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">"'.$saldo_noFim.'"</td><td></td> <td>',$t_en.'</td> <td>',$t_Said.'</td> ';	
							echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$total.'</h4></td></tr>';
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante							
							*/
							echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
					}
                        if($tabela=='idosos')
                        {
                            echo '<table  border=1 cellspacing=0 bgcolor="white"   width="100%">';
                                    echo '<thead bgcolor="Grey"><tr>';
                                    echo '<th>Codigo</th>';
                                    echo '<th>Nome</th>';
                                    echo '<th>Data nascimento</th>';
                                    echo '<th>Idade</th>';
                                    echo '<th>Data entrada</th>';
                                    echo '<th>CPF</th>';
                                    echo '<th>Identidade</th>';
                                    echo '<th>Sexo</th>';
                                    echo '<th>Status</th>';
                                    echo '</tr></thead>';
                                    echo '<tbody style="font-size:70%">';                           
                            while ($row = mysqli_fetch_assoc($result)) 
                            {  	
                                if($row['sexo'] == "M" ){  $sex = "Masculino"; }else
                                {  $sex = "Feminino";  }			                                        
                                    $ano = date( 'Y', strtotime($row["data_Nasc"]));
                                $hoje = date('Y');                                
                                $idade = $hoje - $ano;
                                    echo '<tr>';
                                        echo '<td>'.$row["id_idoso"].'</td> <td>'.$row["nomeI"].'</td> <td>'.$row["data_Nasc"];
                                        echo '</td> <td>'.$idade.'</td>  <td>'.$row["data_entrada"].'</td> <td>'.$row["cpf_I"].'</td> <td>'.$row["rg_I"].'</td> <td>'.$sex.'</td> <td>'.$row["status"].'</td> </tr>';
                                        	
                                $codF = $row['codF'];
                                $nomeF = $row["nomeF"];
                                $Endereco = $row["logradouro"];	
                                $fone = $row["fone"];
                                $numero = $row["numero"];
                                $bairro = $row["bairro"];
                                $cidade = $row["cidade"];
                                $funcao = $row["funcao"];

                                 //Exibe na tela a relação dos congregacao encontrados pelos criterios escolhidos
                            }
                            echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante							
                        }
//echo '<font color=Brown size="2">Tipo   ',$tipo.', Termo  '.$termo.', Tabela '.$tabela. ', Tipo Consulta '.$tipoCons.'  <td></font><br />'. __LINE__ ;exit;
?>
