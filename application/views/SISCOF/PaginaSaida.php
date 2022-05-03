<html>
	<head>
		<title>SISCOD - Lancamento financeiro</title><meta charset="iso-8859-1">
		<link rel="stylesheet" href="styles.css" media="all" />		
	</head>
	<body>
		<div id="bloco">  	
			<div id="blCabeca" title="sitename">  
				<?php
					include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
					protegePagina(); // Chama a função que protege a página
				?>				
				<div id="skipmenu">Associação Evangelica Novas de Paz  >>>>     
					<?php 
					$contaA = $_SESSION['conta_acesso'];
					$nivel = $_SESSION['nivel_acesso'];			
					switch ($contaA) 
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
					echo  "<strong>".$_SESSION['usuarioNome']."</strong> | Nivel de acesso ".$nivel." | ".$contaNome." <br/>";
					//	echo  " | tipo de conta ".$_SESSION['t_Cont']." | Conta ".$_SESSION['Cont'];
					//	echo  " | E S = ".$_SESSION['tE_S']." | pagina = ".$_SESSION['tE_S_N'] ;
					?>	
				</div>  		
					<h1>SISCOF - Lancamento de saída<text=center /h1>  	
			</div>  				
				
					<?php	
                      
                        unset($_SESSION['tid_caixa']);        
                        unset($_SESSION['tid_presentes']);
                        unset($_SESSION['tid_caixa']);
                        unset($_SESSION['tcod_Ass']) ;
						unset($_SESSION['tcod_Comp']);
						unset($_SESSION['tnumeroDoc']);
						unset($_SESSION['tnumDocFiscal']);
						unset($_SESSION['thist']);	
                        unset($_SESSION['tqtd_presentes']);
                        unset($_SESSION['ttid_fin']);//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
						unset($_SESSION['saldo_AtualConsult']) ;
                        
					if($_SESSION['t_Cont'] == "0")//Se a pagina foi chamada pela página LançamentoS
					{
					$conta = $_POST["conta"];
					$tipCont = $_POST["tipCont"];
					$presentes = $_POST["presentes"];
					
						if($tipCont == "Suporte" && $presentes == "true" )
						{	echo "<center><font color = red >O tipo de conta selecionado foi Suporte (pequeno caixa).</font></center></br>";
							echo "<center><font color = red >Para presentes especiais você deve retornar e </font>";
							echo "<font color = red >selecionar tipo de conta Corrente!</font></center>";
							$presentes = "false";
						}
					}else {//Se a pagina foi chamada pela página cadatrarLançamento ou seja tentar denovo
					$conta = $_SESSION['Cont'];
					$tipCont = $_SESSION['t_Cont'];		
					}				
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
						
					require_once 'conexao.class.php';
										$con = new Conexao();
										$con->connect(); $conex = $_SESSION['conex'];	
										//Id do registro com o ultimo saldo pra ser desmarcado quando cadastrar
										$sql_Saldo_Ant = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
												WHERE dataFin > "2017-01-01" and 
												conta = '.$conta.'  and tipo_Conta = "'.$tipCont.'"
												and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
					$result_Saldo_Ant = mysqli_query($conex, $sql_Saldo_Ant );
					if (!$result_Saldo_Ant) 
						{
									die ("<center>Desculpe, erro na busca de saldo atual.:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='PaginaLancamento1.php'>Voltar a página lançamento</a></center>");
										exit;
						}
					if (mysqli_num_rows($result_Saldo_Ant) == 0  ) 
					{
						echo "Nao existem lançamentos desde o primeiro dia do mês anterior!</br>";
					   
					}		
					while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Ant)) 
					{
						$id_fin = $row_Saldo['id_fin']; 
						$saldo_Atual = $row_Saldo['saldo']; 	
						$dataUlt_saldo = $row_Saldo['dataFin'];
						$dataUlt_saldoExib= implode('/',array_reverse(explode('-',$dataUlt_saldo)));
						$saldo_AtualExib = number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.');
											
						//echo '  - mês atual '.$mes.' data prox mês '.$data2.' data mês anterior'.$data_mes_Anterior;
						//echo '</br>  Saldo em '.$row_Saldo['dataFin'].' R$ '. $row_Saldo['saldo'].'</br>';	
					}	//echo '  - mês atual '.$mes.' data prox mês '.$data2.' data mês anterior'.$data_mes_Anterior;
						//echo '</br>  Saldo em '.$dataUlt_saldo.' R$ '. $saldo_Atual.'</br>';	
					?>					
					<form action="PaginaSaida2.php" method="post" name="form" class="form">	
								<label for="conta"><H3>conta - <?php echo $conta.' '.$contaNome ?> | <?php echo $tipCont ?> 
								| Saldo atual R$ <?php if(isset($saldo_AtualExib)) echo $saldo_AtualExib ?>
								 | em <?php  if(isset($dataUlt_saldoExib)) echo $dataUlt_saldoExib ?></H3></label>				
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
							
							<p class="compassion">
									<?php /*
									if($presentes == "true" )//Implementar  
									{											
										$con = new Conexao();		 
										$con->connect(); $conex = $_SESSION['conex']; 			
										require_once"consultar.php";								
										//$con->disconnect();
									}
									*/	
						if( $presentes == "true" )
						{     ?>
                            </p>
							<p class="cod_Comp">
                                <label for="compassion">Código Compassion *</label>
									  <select id="compassion" name="compassion">
																	
											<option value = "D06-010">
											D06-010 | COMPASSION PRESENTES ESPECIAIS | FUNDOS ESPECIAIS COMPASSION</option>
										
										  </select>
                            </p>
							<p class="cod_ass">
                                <label for="cod_ass">Código Associação *</label>
									 <select id="cod_ass" name="cod_ass">
										<option value = "D06-010">
											D06-010 | PRESENTES ESPECIAIS (Compassion)</option>										
										  </select> 
                                </p>
                        <?php 
						} else
                                {
									require_once 'conexao.class.php';
									$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex'];									
									 if( $conta <  4 || $conta >  8 )
                                    {
                                       echo"<input name =compassion  type=hidden value=III-III />";
                                    }else{
									$query = mysqli_query($conex, "SELECT * FROM cod_compassion WHere  ent_Sai = 0 ");
									?>
								<p class="cod_Comp">
                                    <label for="compassion">Código Compassion *</label>
									  <select id="compassion" name="compassion">
										<option>Selecione a opção financeira para Compassion</option>
										
										<?php 
										while($cod_Comp = mysqli_fetch_array($query)) {?>
                                        <!-- if () -->
											<option value = "<?php echo $cod_Comp ['cod_Comp']?>">
											<?php echo ' '.$cod_Comp ['cod_Comp']." |
											".$cod_Comp ['descricao']." | ".$cod_Comp ['area_Cod'].' '?></option>
										<?php } ?>
										  </select>
                                <?php }    ?>
							</p>
							<p class="cod_ass">
									<?php
									$queryA = mysqli_query($conex, "SELECT * FROM cod_assoc WHere  ent_SaiAss = 0");
									?>									
									<label for="cod_ass">Código Associação *</label>
									 <select id="cod_ass" name="cod_ass">
										<option>Selecione a opção financeira para Aenpaz</option>
										<?php while($cod_Ass = mysqli_fetch_array($queryA)) {?>
										<option value = "<?php echo $cod_Ass ['cod_Ass']?>">
										<?php echo $cod_Ass ['cod_Ass']." | ".$cod_Ass ['descricao_Ass']?></option>
										<?php } //$con->disconnect();
										?>														
										  </select>
							</p>
                      <?php  }?>
				<div id="blMenu">  	
				<?php  
					include"menuFLateral.html"; 
				?>						
				</div>  	
			<div id="blCorpo">  		
				<div class="blogentry"> 			
						<div id="blAux5">
							<p class="numeroDocBancario">
                                <?php                                  					
										if($conta <> 3)
										{?>
									<label for="numeroDocBanco">Número do Documento Bancário</label>
									<input id="numeroDocBanco" name="numeroDocBanco"placeholder="Nº Bancário" />
                                <?php }	
									?>
								<span class="style1">*</span>
							</p> 
							<p class="docFiscal">
									<label for="numeroDocFiscal">Número do Documento Fiscal</label>
								  <td>
									<input id="numeroDocFiscal" name="numeroDocFiscal"placeholder="(NF ou CF)- Nº Fiscal" />
								<span class="style1">*</span></td>
							</p>
							<label for="hist">Data do evento financeiro</label>
							<input type="DATE" name="data" id = "data1" value=<?php echo date('d/m/Y'); ?>  step="1"></br>
								<?php                                  					
										if($conta == 3)
										{		
											echo '<label><input  checked="checked"  name="numeroDocBanco" type="radio" value= "70_porcento" />
							Pertence aos 70% </label>';                                            
											echo '<label><input name="numeroDocBanco" type="radio" value= "30_porcento" />Pertence aos 30%</label></br></br>';	
										}	
									
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
											<input  name="tipoPag"  id = "rd-time" type="radio" value="cheq" style="margin-top:15px;" >Cheque</br></br>
                                            
                                          <div id = "palco">
						                 <div id = "cheq">
                                        
                                            <label for="tiposaida"><input  name="chequeCompen" type="checkbox" value= "0">Cheque já compensado</label>
											
                                         </div>
						                 </div>
                                        <?php 
									}	
									?>
                           
						</div>
						<div id="blAux6">
							<p class="VALOR">
							<label for="valor">Valor do lançamento</label>
							<span class="style1">* R$ </span><input text-align="right" name="valorFin" placeholder="YY.XXX,xx" ><font color=red> **</font>
							</p>
							<p class="Historico">
								<label for="razao"><font color=red>Razão Social</font></label>
								<input  name ="razaoSoc" type="text" placeholder="Nome da Razão Social." maxlength=35><font color=red> *</font>
								
							</p>
                            
							<p class="descri">
								<label for="descri">Descrição</label>
								<textarea name ="descri" type="text" placeholder="- descrição." maxlength=100></textarea><font color=red> *</font>
								
							</p>
                            
                            
						</div> 
							<div id = "palco">
							<div id = "outro">
								
								<?php 
								if($presentes == "true")
								{
								if($nivel > 2)
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
										echo '<table border=1 bgcolor="LightGray" width="80%">';
										echo '<thead bgcolor="Grey"><tr><th colspan="7" bgcolor="white" align="center" >Presentes especiais em aberto conta '.$conta.' </th>  </tr>';
										
										echo '<th> </th>';	
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
								while ($rows_presentes = mysqli_fetch_assoc($presentes_abertos)) 
								{	switch ($rows_presentes['conta']) 
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
										$data_Ch= implode('/',array_reverse(explode('-',$rows_presentes['dataFin'])));
										$val_Ch= number_format($rows_presentes['valor_entrada'], 2, ',', '.');
										$valor_pendente= number_format($rows_presentes['valor_pendente'], 2, ',', '.');
										
										if ($contaY == $contaN)
										{//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
											if ($val_Ch <> $valor_pendente)
											{	echo '<tr bgcolor="Yellow">'; $presente_pendente = "true";
											}	else 	echo '<tr>';
																					
											echo '<td><input  name="presentes_pag" type="radio" value= "'.$rows_presentes['id_presente'].'"</td> ';
											
											echo '</td> <td>'.$rows_presentes['id_presente'].'</td> <td>'.$contaN.'</td>';
											echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
											echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
											echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
											echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
											$total = $total + $rows_presentes['valor_pendente'];
										}else
										{
											if ($inicio == 0)
											{$val_ChT= number_format($total, 2, ',', '.');
												echo '<tr>';
											
												echo '<td></td> <td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
												echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_ChT.'</h4></td></tr>';
												
												if ($val_Ch <> $valor_pendente)
											{	echo '<tr bgcolor="Yellow">'; $presente_pendente = "true";
											}	else 	echo '<tr>';
											
												echo '<td><input  name="presentes_pag" type="radio" value= "'.$rows_presentes['id_presente'].'"</td> ';
											
											echo '</td> <td>'.$rows_presentes['id_presente'].'</td> <td>'.$contaN.'</td>';
											echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
											echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
												echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
											echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
												$total = $total + $rows_presentes['valor_pendente'];
											}else
											{	
												echo '<td><input  name="presentes_pag" type="radio" value= "'.$rows_presentes['id_presente'].'"</td> ';
											
											echo '</td> <td>'.$rows_presentes['id_presente'].'</td> <td>'.$contaN.'</td>';
											echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
											echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
												echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
											echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
												$total = $total + $rows_presentes['valor_pendente'];
												$inicio = 0;
											}
										}	
										$inicio = 0;
										$contaY = $contaN;
								} 	
									$val_Ch= number_format($total, 2, ',', '.');
									echo '<td></td> <td></td> <td></td>  <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
									echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_Ch.'</h4></td></tr>';
									echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
								}	
								}	if( isset($presente_pendente)) 
                                    if( $presente_pendente == "true") 
									echo '* As linhas em amarelo são referentes a presentes com parte do valor ja lançado!';							
										?>	
							</div>
						</div>
						<p class="submit"align="center">
						<input type="submit" value="Visualizar"  colspan="2"/>					
						</p>
				</div>  	
			</div>  
					</form>
					
			<div id="blRodape">  	
								<h1>Utilidade pública federal<text-align=center/h1>		
                                     
			</div> 
                                    <font color=red>( ** )</font><font color = red></br>Obs: </font><font color = #458B74 size=2>Padrão para preenchimento de valores
								</br>99.999,99 ou 99999,99 ou 99999.99 ou 99999
								</font>
         <font color=red>( * )</font><font color = red></br>Obs: </font><font color = #458B74 size=2> No campo DOCUMENTO FISCAL  inserir NF ou CF antes do número e separando com traço. </br>Prencher o campo RAZÃO SOCIAL apenas com o a razão social do estabelecimento. </br>E no campo DESCRIÇÃO fica livre para descrever os detalhes que julgar nescessário.
								
         <!--<font color=red>( * )</font><font color = red></br>Obs: </font><font color = #458B74 size=2>Padrão para preenchimento do campo Histórico
								</br>Nome da Razão Social [espaço] - [espaço] Documento fiscal (NF ou CF) [espaço] - [espaço] descrição.
								</br>Ex: Maria Antonia de Souza LTDA - NF - 1573 - Presente do beneficiário BR021401457.</font>-->
		</div>  
	 
	</body>
</html>