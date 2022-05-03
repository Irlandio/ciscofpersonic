<html>
	<head>
		<title>SISCOF - Reconciliação bancária</title>
		<link rel="stylesheet" href="styles.css" media="all" />				
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
					$_SESSION['t_Cont'] = "0";
					$conta = $_SESSION['conta_acesso'];
					$nivel = $_SESSION['nivel_acesso'];			
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
					echo  "<strong>".$_SESSION['usuarioNome']."</strong> | Nivel de acesso ".$nivel." | ".$contaNome;
					?>	
				</div>  		
				<h1>SISCOF - Reconciliação bancária<text-align=center></h1> 
			</div> 
			<div id="blMenu">  		
				<?php
					include"menuFLateral.html";
				?>				
			</div>  
			<div id="blCorpo">
				<div id="blAux6">
				<form action="PaginaCheque.php" method="post">
						
					<div id="blAuxRolagem2">	
								<?php 
                                if($nivel > 3)
								{
																		
									require_once 'conexao.class.php';		
									$con = new Conexao();		 
									$con->connect(); $conex = $_SESSION['conex']; 
									//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
									
									
									if($conta == 99)
											$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
													WHERE id_fin = id_aenp and  status like 0 ORDER BY conta, dataFin');
									else	$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
													WHERE id_fin = id_aenp and  conta like '.$conta.' and status like 0 ORDER BY dataFin ');
									
									if (mysqli_num_rows($cheques_abertos) == 0 ) 
										{	echo "<center><font color = red >Nao existem registros de cheques á vencer!</font>";
										}else
										if (mysqli_num_rows($cheques_abertos) > 0 )
										{
											echo '<table border=1 bgcolor="LightGray" width="100%">';
											echo '<thead bgcolor="Grey"><tr><th colspan="7" bgcolor="white" align="center" >Cheques a serem compensados</th>  </tr>';
											
											echo '<th>Opção</th>';	
											echo '<th>Codigo</th>';	
											echo '<th>Conta</th>';	
											echo '<th>Número</th>';	
											echo '<th>Data</th>';	
											echo '<th style="width"":"80">historico</th>';
											echo '<th>Valor R$</th>';	
											echo '</tr></thead>';
											echo '<tbody style="font-size:80%">';
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
												
												if ($contaY == $contaN)
												{
													echo '<tr>';
													if($nivel > 3) echo '<td><input  name="cheque[]" type="checkbox" value= "'.$rows_chek['id_fin'].'"</td> ';
													else echo ' <td></td>';
													echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
													echo '<td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$data_Ch.'</td>';
													echo '<td>'.$rows_chek['historico'].'</td> <td align="right" valign=bottom >'.$val_Ch.'</td> ';
													echo '</tr>';								
													$total = $total + $rows_chek['valorFin'];
												}else
												{
													if ($inicio == 0)
												{$val_ChT= number_format($total, 2, ',', '.');
													echo '<tr>';
													echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
													echo '<td bgcolor="#c7f40b"  ><h4 align="right" valign=bottom >',$val_ChT.'</h4></td></tr>';
													
													echo '<tr>';
													if($nivel > 3) echo '<td><input  name="cheque[]" type="checkbox" value= "'.$rows_chek['id_fin'].'"</td> ';
													else echo ' <td></td>';
													echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
													echo '<td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$data_Ch.'</td>';
													echo '<td>'.$rows_chek['historico'].'</td> <td align="right" valign=bottom >'.$val_Ch.'</td> ';
													echo '</tr>';
													$total = $rows_chek['valorFin'];
												}else
												{	
													if($nivel > 3) echo '<td><input  name="cheque[]" type="checkbox" value= "'.$rows_chek['id_fin'].'"</td> ';
													else echo ' <td></td>';
													echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
													echo '<td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$data_Ch.'</td>';
													echo '<td>'.$rows_chek['historico'].'</td> <td align="right" valign=bottom >'.$val_Ch.'</td> ';
													echo '</tr>';
													$total = $rows_chek['valorFin'];
													$inicio = 0;
												}
													}	
													$inicio = 0;
													$contaY = $contaN;
											} 	
												$val_Ch= number_format($total, 2, ',', '.');
												echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
												echo '<td bgcolor="#c7f40b"  ><h4 align="right" valign=bottom >',$val_Ch.'</h4></td></tr>';
												echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
										}				
								}		 else
								if($nivel == 3)
								{
																		
									require_once 'conexao.class.php';		
									$con = new Conexao();		 
									$con->connect(); $conex = $_SESSION['conex']; 
									//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
									
									
									if($conta == 99)
											$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
													WHERE id_fin = id_aenp and  status like 0 ORDER BY conta, dataFin');
									else	$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
													WHERE id_fin = id_aenp and  conta like '.$conta.' and status like 0 ORDER BY dataFin ');
									
									if (mysqli_num_rows($cheques_abertos) == 0 ) 
										{	echo "<center><font color = red >Nao existem registros de cheques á vencer!</font>";
										}else
										if (mysqli_num_rows($cheques_abertos) > 0 )
										{
											echo '<table border=1 bgcolor="LightGray" width="100%">';
											echo '<thead bgcolor="Grey"><tr><th colspan="7" bgcolor="white" align="center" >Cheques a serem compensados</th>  </tr>';
											
											echo '<th>Opção</th>';	
											echo '<th>Codigo</th>';	
											echo '<th>Conta</th>';	
											echo '<th>Número</th>';	
											echo '<th>Data</th>';	
											echo '<th style="width"":"80">historico</th>';
											echo '<th>Valor R$</th>';	
											echo '</tr></thead>';
											echo '<tbody style="font-size:80%">';
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
												
												if ($contaY == $contaN)
												{
													echo '<tr>';
													if($nivel > 3) echo '<td><input  name="cheque" type="radio" value= "'.$rows_chek['id_fin'].'"</td> ';
													else echo ' <td></td>';
													echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
													echo '<td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$data_Ch.'</td>';
													echo '<td>'.$rows_chek['historico'].'</td> <td align="right" valign=bottom >'.$val_Ch.'</td> ';
													echo '</tr>';								
													$total = $total + $rows_chek['valorFin'];
												}else
												{
													if ($inicio == 0)
												{$val_ChT= number_format($total, 2, ',', '.');
													echo '<tr>';
													echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
													echo '<td bgcolor="#c7f40b"  ><h4 align="right" valign=bottom >',$val_ChT.'</h4></td></tr>';
													
													echo '<tr>';
													if($nivel > 3) echo '<td><input  name="cheque" type="radio" value= "'.$rows_chek['id_fin'].'"</td> ';
													else echo ' <td></td>';
													echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
													echo '<td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$data_Ch.'</td>';
													echo '<td>'.$rows_chek['historico'].'</td> <td align="right" valign=bottom >'.$val_Ch.'</td> ';
													echo '</tr>';
													$total = $rows_chek['valorFin'];
												}else
												{	
													if($nivel > 3) echo '<td><input  name="cheque" type="radio" value= "'.$rows_chek['id_fin'].'"</td> ';
													else echo ' <td></td>';
													echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
													echo '<td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$data_Ch.'</td>';
													echo '<td>'.$rows_chek['historico'].'</td> <td align="right" valign=bottom >'.$val_Ch.'</td> ';
													echo '</tr>';
													$total = $rows_chek['valorFin'];
													$inicio = 0;
												}
													}	
													$inicio = 0;
													$contaY = $contaN;
											} 	
												$val_Ch= number_format($total, 2, ',', '.');
												echo '<td></td> <td></td> <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
												echo '<td bgcolor="#c7f40b"  ><h4 align="right" valign=bottom >',$val_Ch.'</h4></td></tr>';
												echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
										}				
								}		?>
                         </div>
									<p class="submit"align="center">	
										<input type="submit" value="Consultar"  colspan="2"/>
									</p>
                       
															
				</form>	
				<?php
						if($_SESSION['usuarioNome'] == "Irlandio Oliveira")
						echo "<h3><a href=http://imprimadesign.tk/aenpazFin2/menuF.php>Pagina Teste</a></h3>";
						
				?>	
				</div>  	
			</div>  	
			



			
			<div id="blRodape"> 
			<h1>Utilidade pública federal<text-align=center/h1>
			</div>  
		</div>
			
	</body>
</html>

