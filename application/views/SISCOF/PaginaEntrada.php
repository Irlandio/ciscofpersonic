<html>
	<head>
		<title>SISCOF - Lancamento financeiro</title><meta charset="iso-8859-1">
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
			//echo  " | tipo de conta ".$_SESSION['t_Cont']." | Conta ".$_SESSION['Cont'];
			//echo  " | E S = ".$_SESSION['tE_S']." | pagina = ".$_SESSION['tE_S_N'] ;
			?>
		</div>   		
					<h1>SISCOF - Lancamento de entrada<text=center /h1>  	
			</div>  				
			
			<?php
				unset($_SESSION['tid_caixa']);
                        
				if($_SESSION['t_Cont'] == "0")
				{
				$conta = $_POST["conta"];
				$tipCont = $_POST["tipCont"];
				}else {
				$conta = $_SESSION['Cont'];
				$tipCont = $_SESSION['t_Cont'];		
				}
               if($conta == "3") { $tipCont =  "Suporte";}       
                        
				switch ($conta)
			{
				case 0:	$caixaNome = "Retorne a pagina anterior o selecione uma conta para lançamento";	break;    
				case 1:	$caixaNome = "IEADALPE - 1444-3";	break;    
				case 2:	$caixaNome = "22360-3";	break;  
				case 3:	$caixaNome = "ILPI";	break;  
				case 4:	$caixaNome = "BR214";	break;  
				case 5:	$caixaNome = "BR518";	break;  
				case 6:	$caixaNome = "BR542";	break;  
				case 7:	$caixaNome = "BR549";	break;  
				case 8:	$caixaNome = "BR579";	break;  
				case 9:	$caixaNome = "BB 28965-5";	break;  
				case 10:$caixaNome = "CEF 1948-4";	break; 				
			}/*
			switch ($tipCont) 
			{
				case 1:	$tipContNome = "Suporte";	break;    
				case 2:	$tipContNome = "Corrente";	break;    
				case 3:	$tipContNome = "Poupança";	break;  
				case 4: $tipContNome = "Investimento";	break;				
			}*/
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
			$data_mes_Anterior= date($ano0.'-'.$mes0.'-01');//Cria a variavel data final com o mês seguinte sendo dia 01
					
					
				//	echo 'conta '.$caixa.' tipo conta '.$tipCont.' data mes ant '.$data_mes_Anterior.' data 2 '.$data2;
				require_once 'conexao.class.php';
									$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex'];									
									$sql_Saldo_Ant = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin >= "'.$data_mes_Anterior.'" and dataFin < "'.$data2.'" and 
											conta = '.$conta.'  and tipo_Conta = "'.$tipCont.'"
											and saldo_Mes = "S" ORDER BY dataFin';		
				$result_Saldo_Ant = mysqli_query($conex, $sql_Saldo_Ant );
				if (!$result_Saldo_Ant) 
					{
								die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
				if (mysqli_num_rows($result_Saldo_Ant) == 0  ) 
				{
					echo "<font color = grey >Nao existem lançamentos desde o primeiro dia do mês anterior!</font></br>";
				   
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
			<form action="PaginaEntrada2.php" method="post" name="form" class="form">	
								<label for="caixa"><H3>Conta - <?php echo $caixaNome ?> | <?php echo $tipCont ?> 
								| Saldo atual R$ <?php echo $saldo_AtualExib ?>
								 | em <?php echo $dataUlt_saldoExib ?></H3></label>				
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
									<?php
									require_once 'conexao.class.php';
									$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex'];
                                     if( $conta <  4 || $conta >  8 )
                                    {
                                       echo"<input name =compassion  type=hidden value=III-III />";
                                    }else{
									$query = mysqli_query($conex, "SELECT * FROM cod_compassion WHere  ent_Sai = 1 ");
									?>
									<label for="compassion">Código Compassion *</label>
									  <select id="compassion" name="compassion">
										<option>Selecione a opção financeira para Compassion</option>
										<table>
										<?php while($cod_Comp = mysqli_fetch_array($query)) {?>										
											<tr><option value = "<?php echo $cod_Comp ['cod_Comp']?>">
											<td><?php echo $cod_Comp ['cod_Comp']." | "?></td>
											<td><?php echo$cod_Comp ['descricao']." | "?></td>
											<td><?php echo $cod_Comp ['area_Cod']." | "?></td></option>
											</tr>
											</table>
											<!--<option value = "<?php echo $cod_Comp ['cod_Comp']?>"><?php echo $cod_Comp ['cod_Comp']." |
											".$cod_Comp ['descricao']." | ".$cod_Comp ['area_Cod']." | "?></option>  -->
										<?php } ?>
										  </select>
										<span class="style1">*</span>
										
                        <?php	}
									?>
							</p>
                
							<p class="cod_ass">
									<?php									
									$queryA = mysqli_query($conex, "SELECT * FROM cod_assoc WHere  ent_SaiAss = 1");
									?>
									<label for="cod_ass">Código Associação *</label>
									 <select id="cod_ass" name="cod_ass">
										<option>Selecione a opção financeira para Aenpaz</option>
										<?php while($cod_Ass = mysqli_fetch_array($queryA)) {?>
										<option value = "<?php echo $cod_Ass ['cod_Ass']?>"><?php echo $cod_Ass ['cod_Ass']." | ".$cod_Ass ['descricao_Ass']?></option>
										<?php } ?>														
										  </select>
										
										
							</p>
			<div id="blMenu">  	
				<?php
					include"menuFLateral.html";
				?>
			</div>  	
			<div id="blCorpo">  		
				<div class="blogentry"> 	
						<div id="blAux5">
							<p class="numeroDocBancario">
									<label for="numeroDocBanco">Número do Documento Bancário</label>
									<input id="numeroDocBanco" name="numeroDocBanco"placeholder="Nº Bancário" />
								<span class="style1">*</span>
							</p> 
							<p class="docFiscal">
									<label for="numeroDocFiscal">Número do Documento Fiscal</label>
								  <td>
									<input id="numeroDocFiscal" name="numeroDocFiscal"placeholder="Nº Fiscal" />
								<span class="style1">*</span></td>
							</p>
                            <p class="data">
							<label for="hist">Data do evento financeiro</label>
							<input type="DATE" name="data" id = "data1" value="<?php echo date('d/m/Y'); ?>"  step="1" />
                            </br>			
							</p>
							
							
								
							<?php
							if($tipCont == "Corrente")
								{
								echo '<label for="pres">Presente especial</label>';
								echo '<label for="qtd ben">Quantidade de beneficiários</label>';
								echo '<select id="presentes" name="qtd_presentes">';
										echo '<option>presentes</option>';										
										$contar = 1; 
										while(($contar <= 30)) {										
											echo '<option value = '.$contar.'>'.$contar.'</option>';
											 $contar = $contar+1; }
										 echo ' </select>';
								}		 
							?>
						</div>
						<div id="blAux6">
							<p class="VALOR">
							<label for="valor">Valor do lançamento</label>
							<span class="style1">* R$ </span><input text-align="right" name="valorFin" class="money" placeholder="YYXXX,xx"  >
							</p>
							<p class="Historico">
								<label for="razaoSoc">Histórico</label>
								<textarea name ="razaoSoc" type="text" placeholder="Histórico do lançamento" maxlength=100></textarea>
							</p>
						</div> 	
						<p class="submit"align="center">
						<input type="submit" value="Visualizar"  colspan="2"/>					
						</p>
				
			</form>
			</div>  	
			</div>  	
			<div id="blRodape">  	
								<h1>Utilidade pública federal<text-align=center/h1>					
			</div>  
		</div>  
	 
	</body>
</html>