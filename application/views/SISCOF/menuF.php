<html>
	<head>
		<title>SISCOF - Lancamento financeiro</title>
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
				<h1>SISCOF - - Lancamento financeiro<text-align=center></h1> 
			</div> 
			<div id="blMenu">  		
				<?php
					include"menuFLateral.html";
				?>				
			</div>  
			<div id="blCorpo">
				<div id="blAux6">
				<form action="PaginaCheque.php" method="post">
						<p><img class="imagefloat" src="aenpazVertical.png" alt="" width="250" height="220" border="0"><br/>
					<h2> 					
					<?php
						if($nivel > 2)
						echo "<a href='reconcilia_Bank.php' title=Permanent link to this item>Reconciliação bancária.<text-align=center></a> "; 			
						?>
						</h2> 	
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
									id('outro').style.display = 'none';
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
						
						<input type = "radio" name = "timetorce" id = "rd-time" value = "outro" style="margin-top:15px;" /> <font color = #458B74> Mais detalhes</font>
						<input type = "radio" name = "timetorce" id = "rd-tim" value = "out" style="margin-top:15px;" checked="checked"/> <font color = #458B74> Menos detalhes</font>
						
						<div id="blAuxRolagem2">
						<div id = "palco">
							<div id = "outro">
                              
								             
								<?php
                                
								if($nivel > 2)
								{
																		
									require_once 'conexao.class.php';		
									$con = new Conexao();		 
									$con->connect(); $conex = $_SESSION['conex']; 
									//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
									if($conta == 99)
											$presentes_abertos = mysqli_query($conex, 'SELECT * FROM presentes_especiais, aenpfin
													WHERE id_fin = id_entrada and  id_saida like 0 ORDER BY conta, dataFin');
									
									else	$presentes_abertos = mysqli_query($conex, 'SELECT * FROM presentes_especiais, aenpfin
													WHERE id_fin = id_entrada and  id_saida like 0 and  conta like '.$conta.' ORDER BY dataFin');
									
									if (mysqli_num_rows($presentes_abertos) == 0 ) 
										{	echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";
										}
										else
										{ 
											echo '<table border=1 bgcolor="LightGray" >';
											echo '<thead bgcolor="Grey"><tr><th colspan="9" bgcolor="white" align="center" >Presentes especiais em aberto</th>  </tr>';
											
											//echo '<th>*</th>';	
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
                                            
                                            require_once 'funcao.php';
											$total = 0;	$inicio = 1; $totalG = 0; $totalData = 0; $contaY = 0;
                                            
											while ($rows_presentes = mysqli_fetch_assoc($presentes_abertos)) 
											{	
                                                $data_1 = date("Y-m-d");
			                                    $data_003 =  primeiroDia_a3meses($data_1);
                                                
                                                if ($rows_presentes['valor_pendente'] > 2 || $rows_presentes['dataFin'] > $data_003)
												{
                                                    switch ($rows_presentes['conta']) 
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
                                                    $data_Ch= implode('/',array_reverse(explode('-',$rows_presentes['dataFin'])));
                                                    $val_Ch= number_format($rows_presentes['valor_entrada'], 2, ',', '.');
                                                    $valor_pendente= number_format($rows_presentes['valor_pendente'], 2, ',', '.');

                                                    if ($contaY == $contaN)
                                                    {//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
                                                        if ($val_Ch <> $valor_pendente)
                                                        {	echo '<tr bgcolor="Yellow">'; $presente_pendente = "true";
                                                        }	else 	echo '<tr>';
                                                         //   echo '<td><input  name="presentes_pag" type="radio" value= "'.$rows_presentes['id_presente'].'"</td> ';
                                                          //  echo '<td></td> ';

                                                        echo '</td> <td>'.$rows_presentes['id_presente'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
                                                        echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                                                        echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                        echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
                                                        echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
                                                        $total = $total + $rows_presentes['valor_pendente'];	
                                                        $totalG = $totalG + $rows_presentes['valor_entrada'];					
                                                        /*	if ($data_Ch == $data_Anterior)
                                                        {																										
                                                        $totalData = $totalData + $rows_presentes['valor_pendente'];
                                                        }*/
                                                    }else
                                                    {
                                                        if ($inicio == 0)
                                                        {
                                                            $val_ChT= number_format($total, 2, ',', '.');
                                                            $val_PresT= number_format($totalG, 2, ',', '.');
                                                            echo '<tr>';

                                                            echo '<td bgcolor="white"  colspan="4"></td> <td colspan="2">Total em presentes R$ </td>';	
                                                            echo '<td><h4 align="right" valign=bottom >',$val_PresT.'</h4></td> <td><h4 align="right" valign=bottom >',$val_ChT.'</h4></td></tr>';

                                                            if ($val_Ch <> $valor_pendente)
                                                            {	echo '<tr bgcolor="Yellow">'; $presente_pendente = "true";
                                                            }	else 	echo '<tr>';

                                                                //   echo '<td><input  name="presentes_pag" type="radio" value= "'.$rows_presentes['id_presente'].'"</td> ';
                                                                //     echo '<td></td> ';

                                                            echo '</td> <td>'.$rows_presentes['id_presente'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
                                                            echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                                                            echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                                echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
                                                            echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
                                                            $total = $rows_presentes['valor_pendente'];
                                                        }else
                                                        {	
                                                             //   echo '<td><input  name="presentes_pag" type="radio" value= "'.$rows_presentes['id_presente'].'"</td> ';
                                                            //  echo '<td></td> ';

                                                            echo '</td> <td>'.$rows_presentes['id_presente'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
                                                            echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                                                            echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                                echo '<td align="right" valign=bottom >'.$val_Ch.'</td>';								
                                                            echo '<td align="right" valign=bottom >'.$valor_pendente.'</td></tr>';								
                                                            $total = $rows_presentes['valor_pendente'];
                                                            $inicio = 0;
                                                        }
                                                    }	
                                                    $inicio = 0;
                                                    $contaY = $contaN;
											     }
                                            }
											$val_Ch= number_format($total, 2, ',', '.');
											echo '<td></td> <td></td>  <td></td> <td></td> <td></td> <td colspan="2">Total em presentes R$ </td>';	
											echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_Ch.'</h4></td></tr>';
											
											echo '<tr bgcolor="Yellow">';
											if( $presente_pendente == "true") 
												echo '<tr bgcolor="Yellow"><td colspan="9">* As linhas em amarelo são referentes a presentes com parte do valor ja lançado!</tr>';
                                           
                                            echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                                            
										}
									
									if($conta == 99)
											$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
													WHERE id_fin = id_aenp and  status like 0 ORDER BY conta, dataFin');
									else	$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
													WHERE id_fin = id_aenp and  conta like '.$conta.' and status like 0 ORDER BY dataFin ');
									
									if (mysqli_num_rows($cheques_abertos) == 0 ) 
										{	echo "<center><font color = red >Nao existem registros de cheques á compensar!</font>";
										}else
										if (mysqli_num_rows($cheques_abertos) > 0 )
                                        {
											echo '<table border=1 bgcolor="LightGray" width="100%">';
											echo '<thead bgcolor="Grey"><tr><th colspan="7" bgcolor="white" align="center" >Cheques a serem compensados</th>  </tr>';
											
										//	echo '<th>Opção</th>';	
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
													echo '<td></td>  <td></td> <td></td> <td colspan="2">Total a compensar R$ </td>';	
													echo '<td bgcolor="#c7f40b"  ><h4 align="right" valign=bottom >',$val_ChT.'</h4></td></tr>';
													
													echo '<tr>';
													
													echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td><strong><font color ="'.$cor.'">'.$contaN.'</td>';
													echo '<td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$data_Ch.'</td>';
													echo '<td>'.$rows_chek['historico'].'</td> <td align="right" valign=bottom >'.$val_Ch.'</td> ';
													echo '</tr>';
													$total = $rows_chek['valorFin'];
												}else
												{	
													
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
												echo '<td></td>   <td></td> <td colspan="2">Total a compensar R$ </td>';	
												echo '<td bgcolor="#c7f40b"  ><h4 align="right" valign=bottom >',$val_Ch.'</h4></td></tr>';
												echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                                        }	
                                    }
										?>	
                                    										
                                   <!--<p class="submit"align="center">	
										<input type="submit" value="Consultar"  colspan="2"/>
									</p>-->
								
							</div>
						</div>
						</div>
                                                        

				</form>	
				<?php
						if($_SESSION['usuarioNome'] == "Irlandio Oliveira"){
						echo "<h3><a href=http://imprimadesign.tk/aenpazFin2/menuF.php>Paginas de Testes</a></h3>";
						echo "<h3><a href='http://127.0.0.1:80/SISCOF/Sisgef/index.php/os'>Paginas de SISGEF</a></h3>";}
                    
						
				?>	
				</div>  	
			</div>  	
			



			
			<div id="blRodape"> 
			<h1>Utilidade pública federal<text-align=center/h1>
			</div>  
		</div>
			
	</body>
</html>

