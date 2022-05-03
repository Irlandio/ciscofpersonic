
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
</script>
		<title>SISCOF - Lançamento Financeiro</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>	
	</head>
	<body bgcolor="#Feeeab">
		<div id="bloco">  	
            <?php 
            $base_url = 'http://127.0.0.1:80/SISCOF/Sisgef/';?>
         
       <link rel="stylesheet" href="<?php echo $base_url ;?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo $base_url?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo $base_url?>assets/js/jquery.validate.js"></script>     
         
            
			<div id="blCabeca" title="sitename">  		
				<?php
					include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
					protegePagina(); // Chama a função que protege a página
			?>				
		<div id="skipmenu">Até aqui nos ajudou o Senhor  >>>>     
			<?php 
			$contaA = $_SESSION['conta_acesso'];
			$nivel = $_SESSION['nivel_acesso'];	
			switch ($contaA) 
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
					<h1>SISCOF- Lançamento de saída </h1>  	
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
						
					
						<p><img class="imagefloat" src="aenpazHorizontal.png" alt="" width="200" height="45" border="0">
							<?php
                             if(!$_SESSION['tid_caixa'] )
                                   
                            {    
								$data	= $_POST["data"];
								$valorFin	= $_POST["valorFin"];
								$tipoCont	= $_POST["tipoCont"];
								$tipContNome	= $_POST["tipContNome"];
								$diaUm_mêsAtual	= $_POST["diaUm_mêsAtual"];
								$dataUlt_saldo	= $_POST["dataUlt_saldo"];
								$dataHoje	=date('Y-m-d');
								require_once 'funcao.php';
                 //       echo "</b></br> Valor recebdo <strong><td> R$  ".$valorFin."</td></strong></br>";            
                                
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
                      //   echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>";        
                  //      echo "</b></br> Valor p/ Exibir <strong><td> R$  ".$valorFinExibe."</td></strong></br>";
                 //    echo "</b></br>Linha: ". __LINE__ . " Valor p/ Guardar <strong><td> R$  ".$valorFin."</td></strong></br>";            
                //             
								require_once 'conexao.class.php';
								$data_01 =  primeiroDiaMes($dataHoje);								
								$data_07 =  setimoDiadoMes($dataHoje);
								$con = new Conexao();		 
								$con->connect(); $conex = $_SESSION['conex']; 			
								require_once"consultar.php";								
								//$con->disconnect();
								if($dataUlt_saldo < $diaUm_mêsAtual && $data >= $diaUm_mêsAtual)
									echo "<font color = grey size = 3>Primeiro lançamento deste mês para esta conta. </font><br/>";		
								$id_caixa =$_POST["caixa"];
								$cod_Ass =$_POST["cod_ass"];
								$cod_Comp = $_POST["compassion"];
								$numeroDoc= $_POST["numeroDocBanco"];
								$numDocFiscal= $_POST["numeroDocFiscal"];
								$razaoSoc	= $_POST["razaoSoc"];
								$descri	= $_POST["descri"];
								$id_presentes	= $_POST["presentes_pag"];
                                
                                 if($qtd_Presentes > 0){}
							//	$id_presentes = implode(",",$presentes_pag);// só se for para selecionar varios presentes
								//	echo "presentes especiais <strong><td>".$id_presenteS."</td></strong>  <br/>";
								$tipoPag	= $_POST['tipoPag'];
                                 $id_fin	= $_POST["id_fin"];//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
								$saldo_Atual	= $_POST["saldo_Atual"];
								$saldo_Final	= $saldo_Atual - $valorFin;
                            //    echo 'saldo Atual '.$saldo_Atual.' - ValorFin '.$valorFin.' - Saldo Final '.$saldo_Final;
								$ent_Sai = 0;//Código para SAÍDA  é ( 0 )
								$cadastrante= $_SESSION['usuarioID'];
										if($_POST['tipoPag'] == "cheq") 
                                            {
                                            $Pag ="cheque";
                                             if(isset($_POST["chequeCompen"])) 
                                                { 
                                                    $chequeCompen = $_POST["chequeCompen"];
                                                    $cheqCp = "Cheque já foi compensado";
                                                 echo '<input name ="chequeCompen"  type="hidden" value=".$chequeCompen."/>';
                                                } else $cheqCp = "Cheque ainda não foi compensado";
                                             }
								 	else if($_POST['tipoPag'] == "trans") $Pag ="transferência"; 
                                 
                                 if($contaA <> 3)
										{
								echo 'Saída feita através de <strong><td>'.$Pag.'</td></strong> número <strong><td>'.$numeroDoc.'</td></strong> - '.$cheqCp.'<br/>';
                                 }else{
                                    if($numeroDoc== "30_porcento") $porcentagem = "30%"; else $porcentagem = "70%";
                                       echo 'Saída feita referente à <strong><td>'.$porcentagem.'.</td></strong><br/>'; 
                                 }                               
								echo "Razão Social  - <strong><td>".$razaoSoc."</td></strong><br/>";
								echo "Documento Fiscal  - <strong><td>".$numDocFiscal."</td></strong><br/> ";
								echo "Descrição  - <strong><td>".$descri."</td></strong><br/>";
								$dataL= implode('/',array_reverse(explode('-',$data)));
								echo "<br/>Data  - <strong><td>".$dataL."</td></strong>  - ";
								echo "</b> Valor <strong><td> R$  ",$valorFinExibe,"</td></strong></br>";
								echo " ======== ======== ======== </br>";
								echo "</b> Saldo atual <td> R$  ",number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.'),"</td></br>";
								echo "</b> Saldo após o lançamento <td> R$  ",number_format(str_replace(",",".",$saldo_Final), 2, ',', '.'),"</td></br>";
								
                                 ?>
                           

             
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                            <?php     
                                 
                                 
                                 
                                 $res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
												<a href='menu1.php'>Voltar ao Menu</a></center>");
												exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente: " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
												<a href='menu1.php'>Voltar ao Menu</a></center>");
												exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max )) 
								{	$id_Maxaenp = $id_ultimo['id_fin']; }								
								$con->disconnect(); 
								echo  "<br><font color = grey size = 1> Registro com saldo atual - ".$id_fin."</font>";
								echo  "<br><font color = grey size = 1> Ultimo registro lançado - ".$id_Maxaenp."</font>";		
								if( isset($id_presentes) )//&& $nivel > 2 
								{
									//	$id_presentes = implode(",", $presentes_pag);
									//	echo "presentes especiais <strong><td>".$id_presentes."</td></strong>  <br/>";
									//echo "<br/><strong><td>".$qtd_Presentes."</td></strong>  presentes especiais <br/>";
									//echo "cod_compassion: ".$cod_Comp." qtd_Presentes: ".$qtd_Presentes."<br>";
									require_once 'conexao.class.php';		
									$con = new Conexao();		 
									$con->connect(); $conex = $_SESSION['conex']; 
									if($contaA == 99)//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
											$presentes_abertos = mysqli_query($conex, 'SELECT * FROM presentes_especiais, aenpfin
													WHERE id_fin = id_entrada and  id_presente =  '.$id_presentes.' LIMIT 1');
									else	$presentes_abertos = mysqli_query($conex, 'SELECT * FROM presentes_especiais, aenpfin
													WHERE id_fin = id_entrada and  id_presente =  '.$id_presentes.' and  conta like '.$id_caixa.' LIMIT 1');									
									if (mysqli_num_rows($presentes_abertos) == 0 ) 
									{	echo "<center><font color = red >Não foi selecionado nenhum presente especial!</font>";
									}else
									{
                                        if(isset($qtd_Presentes)) {} else $qtd_Presentes = "01";
										echo '<table border=1 bgcolor="LightGray" width="80%">';
										echo '<thead bgcolor="Grey"><tr><th colspan="7" bgcolor="white" align="center" >';
										echo '<strong>'.$qtd_Presentes.'</strong>  Presentes especiais selecionados para esta saída</th>  </tr>';
										//echo '<th>Opção</th>';	
										echo '<th>Registro</th>';	
										echo '<th>Conta</th>';	
										echo '<th>BR</th>';	
										echo '<th>Nome Beneficiário</th>';	
										echo '<th>Protocolo</th>';	
										echo '<th>Data</th>';
										echo '<th>Valor R$</th>';	
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
												$val_PresExib= number_format($rows_presentes['valor_pendente'], 2, ',', '.');
												$val_Pres= $rows_presentes['valor_pendente'];
												           
												 if ( $valorFin <= $val_Pres + 1)
                                                 {
                                                    echo '<tr> <td>'.$rows_presentes['id_presente'].'</td> <td>'.$contaN.'</td>';
                                                    echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                                                    echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                    echo '<td align="right" valign=bottom >'.$valorFin.'</td></tr>';	
                                                    $total = $rows_presentes['valor_pendente'];


                                                    if (  $valorFin < $val_Pres)
                                                    {		
                                                        $val_Restante = $val_Pres - $valorFin;
                                                        echo '<tr><td colspan="6" bgcolor="yellow" >Valor pendente para lançamento do restante do presente.</td>';	
                                                        echo '<td align="right" bgcolor="yellow"  valign=bottom >'.number_format($val_Restante, 2, ',', '.').'</td></tr>';								
                                                        echo '<tr><td colspan="3" ></td>';														
                                                        echo '<td colspan="3">Valor total do presente R$ </td>';	
                                                        echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_PresExib.'</h4></td></tr>';
                                                        echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                                                    }else
                                                     if ( $valorFin <= ($val_Pres + 1))
                                                        {																			
                                                        echo '<tr><td colspan="3" ></td>';														
                                                        echo '<td colspan="3">Valor total do presente R$ </td>';	
                                                        echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_PresExib.'</h4></td></tr>';
                                                        echo '</tbody></table>';

                                                        }
                                                        }else

                                                        {
                                                        echo '<tr> <td>'.$rows_presentes['id_presente'].'</td> <td>'.$contaN.'</td>';
                                                        echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                                                        echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                        echo '<td align="right" valign=bottom >'.$val_PresExib.'</td></tr>';	
                                                        $total = $rows_presentes['valor_pendente'];


                                                        echo '<td colspan="6"  bgcolor="red" font color= white >O valor do lançamento é maior que o valor do presente.';	
                                                        echo 'Retorne e refaça o lançamento!</td>';	
                                                        echo '<td align="right" valign=bottom >'.$valorFinExibe.'</td></tr>';								$val_Eced = $valorFin - $val_Pres;
                                                        echo '<td colspan="3" ></td>';														
                                                        echo '<td colspan="3">Valor Ecedente R$ </td>';	
                                                        echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',number_format($val_Eced, 2, ',', '.').'</h4></td></tr>';
                                                        echo '</tbody></table>';


                                                        }
													
												
										} 	
										
									}
								}	
								//	echo "cod_compassion: ".$cod_Comp." qtd_Presentes: ".$qtd_Presentes."<br>";						
								?>							
							<p class="variaveis"><!--Campo fica em oculto apenas para guardar o indicador da tabela "congregacao"-->
								
							<input name ="id_presentes"  type="hidden" value="<?php echo $id_presentes ?>"/>
							<input name ="qtd_Presentes"  type="hidden" value="<?php echo $qtd_Presentes ?>"/>
							<input name ="id_caixa"  type="hidden" value="<?php echo $id_caixa ?>"/>
							<input name ="tipoCont"  type="hidden" value="<?php echo $tipContNome?>"/>
							<input name ="cod_Comp"  type="hidden" value="<?php echo $cod_Comp ?>"/>	
							<input name ="cod_Ass"  type="hidden" value="<?php echo $cod_Ass ?>"/>	
							<input name ="numeroDoc"  type="hidden" value="<?php echo $numeroDoc ?>"/>	
							<input name ="numDocFiscal"  type="hidden" value="<?php echo $numDocFiscal ?>"/>						
							<input name="razaoSoc" type="hidden"  value="<?php echo $razaoSoc ?>"/>
							<input name="descri" type="hidden"  value="<?php echo $descri ?>"/>
							<input name ="valorFin"  type="hidden" value="<?php echo $valorFin ?>"/>
							<input name ="data"  type="hidden" value="<?php echo $data ?>"/>	
							<input name ="ent_Sai"  type="hidden" value="<?php echo $ent_Sai ?>"/>	
							<input name ="id_fin"  type="hidden" value="<?php echo $id_fin ?>" />
							<input name ="tipoPag"  type="hidden" value="<?php echo $Pag ?>" />
							<input name ="saldo_Final"  type="hidden" value="<?php echo $saldo_Final ?>" />
							<input name ="diaUm_mêsAtual"  type="hidden" value="<?php echo $diaUm_mêsAtual ?>" />
							<input name ="dataUlt_saldo"  type="hidden" value="<?php echo $dataUlt_saldo ?>" />
							<input name ="cadastrante"  type="hidden" value="<?php echo $cadastrante ?>"/>	
							</p>	
                        <?php  
                               }else {
                                $data	=         $_SESSION['tdata'];
								$valorFin	=     $_SESSION['tvalorFin'];
								$tipoCont	=     $_SESSION['ttipoCont'];
								$tipContNome	= $_POST["tipContNome"];
								$diaUm_mêsAtual	= $_SESSION['tdiaUm_mêsAtual'];
								$dataUlt_saldo	= $_POST["dataUlt_saldo"];
								$dataHoje	=date('Y-m-d');
									require_once 'funcao.php';                                 
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
								$razaoSoc	=   $_SESSION['trazaoSoc'];								
								$descri	=        $_SESSION['tdescri'];								
								$qtd_presentes	= $_SESSION['tqtd_presentes'];
                                $id_presentes	= $_SESSION['tid_presentes'];
                                $id_fin	=         $_SESSION['ttid_fin'];//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
								$saldo_Atual	= $_SESSION['saldo_AtualConsult'] ;
								$tipoPag	= $_SESSION['ttipoPag'];
								
							
								$saldo_Final	= $saldo_Atual - $valorFin;
								$ent_Sai = 0;//Código para SAÍDA  é ( 0 )
								$cadastrante= $_SESSION['usuarioID'];
										 
							
								?>
            
							<div id="blAux5">
                               
								<label for="cod_ass">tipo de pagamento *</label>
									<select id="tipoPag" name="tipoPag">
										<option value = "<?php echo $tipoPag ?>"><?php echo $tipoPag ?></option>								
										<option value = "transferência">Transferência</option>
										<option value = "cheque">Cheque</option>															
								    </select>
								
								
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
							<font color = red ><label for="hist" font color = red >Data do evento financeiro</label>
							<input  type="DATE" name="data" id = "data1" value="<?php echo implode('/',array_reverse(explode('-',$data))); ?>"  step="1"></font>			
							</div>
						<div id="blAux6">
							<p class="VALOR">
							<label for="valor">Valor do lançamento</label>
							<span class="style1">* R$ </span><input text-align="right" name="valorFin" value="<?php echo $valorFinExibe; ?>" >
							</p>
							<p class="Razão Social">
								<label for="razao">Razão Social</label>
								<input  name ="razaoSoc" type="text" value="<?php echo $razaoSoc; ?>" maxlength=35><font color=red> *</font>
								
							</p>
                            
							<p class="descri">
								<label for="descri">Descrição</label>
								<textarea name ="descri" type="text" value="<?php echo $descri; ?>" maxlength=100></textarea><font color=red> *</font>
								
							</p>
                        </div>
						    
                         <?php 
                                   
								ECHO "</br></br> ======== ======== ======== </br>";
								ECHO "</b> Saldo atual <td> R$  ",number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.'),"</td></br>";
								ECHO "</b> Saldo após o lançamento <td> R$  ",number_format(str_replace(",",".",$saldo_Final), 2, ',', '.'),"</td></br>";
							//	ECHO "</b> Registro do presente selecionado ".$id_presentes."</br>";
								
								
								$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
												<a href='menu1.php'>Voltar ao Menu</a></center>");
												exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	echo "Nao foi encontrado nenhum registro de lançamento. Tente novamente!"; exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max )) 
								{	$id_Maxaenp = $id_ultimo['id_fin']; }								
								$con->disconnect(); 
								echo  "<br><font color = grey size = 1> Registro com saldo atual - ".$id_fin."</font>";
								echo  "<br><font color = grey size = 1> Ultimo registro lançado - ".$id_Maxaenp."</font>";				
								
								
								if( isset($id_presentes) && ($cod_Comp == 'D06-010'))//&& $nivel > 2 
								{
									//	$id_presentes = implode(",", $presentes_pag);
										echo "<br/>presentes especiais <strong><td>".$id_presentes."</td></strong>  <br/>";
									//echo "<br/><strong><td>".$qtd_Presentes."</td></strong>  presentes especiais <br/>";
									//echo "cod_compassion: ".$cod_Comp." qtd_Presentes: ".$qtd_Presentes."<br>";
							


									require_once 'conexao.class.php';		
									$con = new Conexao();		 
									$con->connect(); $conex = $_SESSION['conex']; 
                                    
									if($contaA == 99)//id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo
											$presentes_abertos = mysqli_query($conex, 'SELECT * FROM presentes_especiais, aenpfin
													WHERE id_fin = id_entrada and  id_presente =  '.$id_presentes.' LIMIT 1');
									else	$presentes_abertos = mysqli_query($conex, 'SELECT * FROM presentes_especiais, aenpfin
													WHERE id_fin = id_entrada and  id_presente =  '.$id_presentes.' and  conta like '.$id_caixa.' LIMIT 1');
									
									if (mysqli_num_rows($presentes_abertos) == 0 ) 
									{	echo "<center><font color = red >Nao foi selecionado nenhum presente especial!</font>";
									}else
									{
										echo '<table border=1 bgcolor="LightGray" width="80%">';
										echo '<thead bgcolor="Grey"><tr><th colspan="7" bgcolor="white" align="center" >';
										echo '<strong>'.$qtd_Presentes.'</strong>  Presentes especiais selecionados para esta saída</th>  </tr>';
										//echo '<th>Opção</th>';	
										echo '<th>Registro</th>';	
										echo '<th>Conta</th>';	
										echo '<th>BR</th>';	
										echo '<th>Nome Beneficiário</th>';	
										echo '<th>Protocolo</th>';	
										echo '<th>Data</th>';
										echo '<th>Valor R$</th>';	
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
												$val_PresExib= number_format($rows_presentes['valor_pendente'], 2, ',', '.');
												$val_Pres= $rows_presentes['valor_pendente'];
												           
												 if ( $valorFin <= $val_Pres + 1)
                                                 {
                                                    echo '<tr> <td>'.$rows_presentes['id_presente'].'</td> <td>'.$contaN.'</td>';
                                                    echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                                                    echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                    echo '<td align="right" valign=bottom >'.$valorFin.'</td></tr>';	
                                                    $total = $rows_presentes['valor_pendente'];


                                                    if (  $valorFin < $val_Pres)
                                                    {		
                                                        $val_Restante = $val_Pres - $valorFin;
                                                        echo '<tr><td colspan="6" bgcolor="yellow" >Valor pendente para lançamento do restante do presente.</td>';	
                                                        echo '<td align="right" bgcolor="yellow"  valign=bottom >'.number_format($val_Restante, 2, ',', '.').'</td></tr>';								
                                                        echo '<tr><td colspan="3" ></td>';														
                                                        echo '<td colspan="3">Valor total do presente R$ </td>';	
                                                        echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_PresExib.'</h4></td></tr>';
                                                        echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                                                    }else
                                                     if ( $valorFin <= ($val_Pres + 1))
                                                        {																			
                                                        echo '<tr><td colspan="3" ></td>';														
                                                        echo '<td colspan="3">Valor total do presente R$ </td>';	
                                                        echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',$val_PresExib.'</h4></td></tr>';
                                                        echo '</tbody></table>';

                                                        }
                                                        }else

                                                        {
                                                        echo '<tr> <td>'.$rows_presentes['id_presente'].'</td> <td>'.$contaN.'</td>';
                                                        echo '<td>'.$rows_presentes['n_beneficiario'].'</td> <td>'.$rows_presentes['nome_beneficiario'].'</td>';
                                                        echo '<td>'.$rows_presentes['n_protocolo'].'</td> <td align="right" valign=bottom >'.$data_Ch.'</td> ';
                                                        echo '<td align="right" valign=bottom >'.$val_PresExib.'</td></tr>';	
                                                        $total = $rows_presentes['valor_pendente'];


                                                        echo '<td colspan="6"  bgcolor="red" font color= white >O valor do lançamento é maior que o valor do presente.';	
                                                        echo 'Retorne e refaça o lançamento!</td>';	
                                                        echo '<td align="right" valign=bottom >'.$valorFinExibe.'</td></tr>';								$val_Eced = $valorFin - $val_Pres;
                                                        echo '<td colspan="3" ></td>';														
                                                        echo '<td colspan="3">Valor Ecedente R$ </td>';	
                                                        echo '<td bgcolor="green"  ><h4 align="right" valign=bottom >',number_format($val_Eced, 2, ',', '.').'</h4></td></tr>';
                                                        echo '</tbody></table>';

                                                        }

												
										} 	
										
									}
								}	
								//	echo "cod_compassion: ".$cod_Comp." qtd_Presentes: ".$qtd_Presentes."<br>";
						
								?>
							
							<p class="variaveis"><!--Campo fica em oculto apenas para guardar o indicador da tabela "congregacao"-->
								
							<input name ="id_presentes"  type="hidden" value="<?php echo $id_presentes ?>"/>
							<input name ="qtd_Presentes"  type="hidden" value="<?php echo $qtd_Presentes ?>"/>
							<input name ="id_caixa"  type="hidden" value="<?php echo $id_caixa ?>"/>
							<input name ="tipoCont"  type="hidden" value="<?php echo $tipContNome?>"/>
							<input name ="cod_Comp"  type="hidden" value="<?php echo $cod_Comp ?>"/>	
							<input name ="cod_Ass"  type="hidden" value="<?php echo $cod_Ass ?>"/>	
							<input name ="ent_Sai"  type="hidden" value="<?php echo $ent_Sai ?>"/>	
							<input name ="id_fin"  type="hidden" value="<?php echo $id_fin ?>" /><!--
							-->
							<input name ="saldo_Final"  type="hidden" value="<?php echo $saldo_Final ?>" />
							<input name ="diaUm_mêsAtual"  type="hidden" value="<?php echo $diaUm_mêsAtual ?>" />
							<input name ="dataUlt_saldo"  type="hidden" value="<?php echo $dataUlt_saldo ?>" />
							<input name ="cadastrante"  type="hidden" value="<?php echo $cadastrante ?>"/>	
														
							</p>	
							
                   
                             <?php    
                             }							
							 echo '<p class="submit" align="center"><input type="submit" value="SALVAR"  colspan="2"/>	</p>';
							?>
					</form>	
                
                                 
       <!--Anexos-->
                     <div class="tab-pane" id="tab4">
                        <div class="span12" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="span12 well" style="padding: 1%; margin-left: 0" id="form-anexos">
                             <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" accept-charset="utf-8"s method="post">
                             <div class="span10">
                                <input type="hidden" id="id_Itens" name="id_Itens" value="<?php  echo $id_fin; ?>" />
                                <input type="hidden" id="id_OsItens" name="id_OsItens" value="<?php echo $id_caixa ?>" />
                                <label for="">Anexo</label>
                                <input type="file" class="span12" name="userfile[]" multiple="multiple" size="20" />
                             </div>
                             <div class="span2">
                                <label for="">.</label>
                                 <?php //if(isset($at->idItens)){ ?>
                                <button class="btn btn-success span12"><i class="icon-white icon-plus"></i>Anexar Doc Fiscal</button>
                                 <?php //} ?>
                                                          

                         </div>                                
                        </form>
                        </div>
                        <!--
                        <div class="span12" id="divAnexos" style="margin-left: 0">
                            <?php 
                            $cont = 1;
                            $flag = 5;
                            foreach ($anexos as $a) {

                                if($a->thumb == null){
                                    $thumb = base_url().'assets/img/icon-file.png';
                                    $link = base_url().'assets/img/icon-file.png';
                                }
                                else{
                                    $thumb = base_url().'assets/anexos/thumbs/'.$a->thumb;
                                    $link = $a->url.$a->anexo;
                                }

                                if($cont == $flag){
                                   echo '<div style="margin-left: 0" class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                   $flag += 4;
                                }
                                else{
                                   echo '<div class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                }
                                $cont ++;
                            } ?>
                        </div>
                            -->
                    </div>
                    </div> 
                
                
                
                
                
                
                
                
                </div>
			<div id="blRodape"> 
			<h1 text-align=center>Utilidade pública federal</h1>					
			</div>  
		</div>
        
<script type="text/javascript" src="<?php echo $base_url?>assets/js/validate.js"></script>
<script src="<?php echo $base_url;?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
$(document).ready(function(){
      $("#formAnexos").validate({
         
          submitHandler: function( form ){       
                //var dados = $( form ).serialize();
                var dados = new FormData(form); 
                $("#form-anexos").hide('1000');
                $("#divAnexos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: "<?php echo $base_url;?>index.php/vendas/anexar",
                  data: dados,
                  mimeType:"multipart/form-data",
                  contentType: false,
                  cache: false,
                  processData:false,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divAnexos" ).load("<?php echo current_url();?> #divAnexos" );
                        $("#userfile").val('');

                    }
                    else{
                        $("#divAnexos").html('<div class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> '+data.mensagem+'</div>');      
                    }
                  },
                  error : function() {
                      $("#divAnexos").html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><strong>Atenção!</strong> Ocorreu um erro. Verifique se você anexou o(s) arquivo(s).</div>');      
                  }

                  });

                  $("#form-anexos").show('1000');
                  return false;
                }

        });    
		   $(document).on('click', '.anexo', function(event) {
           event.preventDefault();
           var link = $(this).attr('link');
           var id = $(this).attr('imagem');
           var url = '<?php echo $base_url; ?>vendas/excluirAnexo/';
           $("#div-visualizar-anexo").html('<img src="'+link+'" alt="">');
           $("#excluir-anexo").attr('link', url+id);

           $("#download").attr('href', "<?php echo $base_url; ?>index.php/vendas/downloadanexo/"+id);

       });
   
    
    });
</script> 	
	</body>
</html>