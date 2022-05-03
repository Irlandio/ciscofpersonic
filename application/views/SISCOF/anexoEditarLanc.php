<html>
	
	<body >	
			

			<?php				 
					/*	
				$conta =$_POST["conta"];
				$tipCont =$_POST["tipo_Conta"];
				$cod_Ass =$_POST["cod_ass"];
				$cod_Comp = $_POST["compassion"];
				$numeroDoc= $_POST["num_Doc_Banco"];
				$numDocFiscal= $_POST["num_Doc_Fiscal"];
				$hist	= $_POST["hist"];
				$dataFin	= $_POST["dataFin"];
				$valorFin	= $_POST["valorFin"];
				$valorFin =  number_format((float)str_replace(",",".",$valorFin ),2, ".", "");
				$id_fin	= $_POST["id_fin"];//Id do registro com o ultimo saldo pa ser desmarcado quando cadastrar
				$ent_Sai = $_POST["ent_Sai"];//Código para SAÍDA  é ( 0 )
				*/
				$cadastrante= $_SESSION['usuarioID'];
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
											conta = '.$conta.'  and tipo_Conta = "'.$tipo_Conta.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
				$result_Saldo_Ant = mysqli_query($conex, $sql_Saldo_Ant );
				if (!$result_Saldo_Ant) 
					{
								die ("<center>Desculpe, erro na busca de saldo atual.:  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}
				if (mysqli_num_rows($result_Saldo_Ant) == 0  ) 
				{
					echo "Nao existem lançamentos desde o primeiro dia do mês anterior!</br>";
				   
				}		
			while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Ant)) 
				{
					$id_fin_Saldo = $row_Saldo['id_fin']; 
					$saldo_Atual = $row_Saldo['saldo']; 	
					$dataUlt_saldo = $row_Saldo['dataFin'];
					$dataUlt_saldoExib= implode('/',array_reverse(explode('-',$dataUlt_saldo)));
					$saldo_AtualExib = number_format((float)str_replace(",",".",$saldo_Atual), 2, ',', '.');
										
					
				}	
				$sql_bank = 'SELECT * FROM reconc_bank WHERE id_aenp like '.$id_fin.'  LIMIT 1 ';		
				$result__bank = mysqli_query($conex, $sql_bank);
				if (!$result__bank) 
					{
								die ("<center>Não existem cheques para este lançamento.  " 
								. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
									<a href='menu1.php'>Voltar ao Menu</a></center>");
									exit;
					}//inicia a variavel que indica a a exstencia de cadastro de cheque deste lançamento
					$tip_Pag = 1;
				if (mysqli_num_rows($result__bank) == 0  ) 
				{
				//	echo "Nao há lançamento de cheque para este lançamento!</br>";
				   $tip_Pag = 0;	
				}		
			while ($row__bank = mysqli_fetch_assoc($result__bank)) 
				{
				//	echo "Há lançamento de cheque para este lançamento!</br>";
				   $id_ch = $row__bank['id_reconc']; 	
             //   echo "pagamento tipo ".$tip_Pag;				   				
				}	
			?>				
								<label for="caixa"><H3>Caixa - <?php echo $contaNome ?> | <?php echo $tipo_Conta ?> 
								| Saldo atual R$ <?php echo $saldo_AtualExib ?>
								 | em <?php echo $dataUlt_saldoExib; ?></H3></label>				
								
								<input name ="tab"  type="hidden" value="aenpFin" />
								<input name ="tip_PagAnt"  type="hidden" value="<?php echo $tip_Pag ?>" />
								<input name ="conta"  type="hidden" value="<?php echo $conta ?>" />
								<input name ="tipoCont"  type="hidden" value="<?php echo $tipCont ?>" />
								<input name ="tipContNome"  type="hidden" value="<?php // echo $tipContNome ?>" />
								<input name ="saldo_Atual"  type="hidden" value="<?php echo $saldo_Atual ?>" />
								<input name ="id_fin" type="hidden"  value="<?php echo $id_fin ?>" />
								<input name ="cadastrante"  type="hidden" value="<?php echo $cadastrante ?>" />
								<input name ="op"  type="hidden" value="opCad" />
								<input name ="tipoConsulta"  type="hidden" value=3 />
							
							<p class="compassion">
									<?php
									require_once 'conexao.class.php';
									$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex'];									
									$query_1 = mysqli_query($conex, "SELECT * FROM cod_compassion ");
									$query = mysqli_query($conex, "SELECT * FROM cod_compassion ");
									?>
                                <?php while($cod_Comp_1 = mysqli_fetch_array($query_1)) {
                                    
                                    if ($cod_compassion == $cod_Comp_1 ['cod_Comp'] )
                                    {
                                       $cod_compassion = $cod_Comp_1 ['cod_Comp'];
                                           $descricao = $cod_Comp_1 ['descricao'];
                                        $area_Cod = $cod_Comp_1 ['area_Cod'];
                                    }                                    
                                    
                                    } ?>
                                
									<label for="compassion">Código Compassion *</label>
									 <select maxlength="45" work-break: break-all; id="cod_Comp" name="cod_Comp"  value = "<?php echo $cod_compassion ?>">
										<option  value = "<?php echo $cod_compassion; ?>">
                                            <?php echo $cod_compassion." | ".$descricao." | ".$area_Cod; ?></option>
										<?php while($cod_Comp = mysqli_fetch_array($query)) {?>
										<option value = "<?php echo $cod_Comp ['cod_Comp']?>">
                                            <?php  echo $cod_Comp ['cod_Comp']." | ".$cod_Comp ['descricao']." | ".$cod_Comp ['area_Cod']?></option>
										<?php } ?>														
										  </select>	
							</p>
							<p class="cod_ass">
									<?php
									$queryA = mysqli_query($conex, "SELECT * FROM cod_assoc");
									$queryA_1 = mysqli_query($conex, "SELECT * FROM cod_assoc");
									?>
                                <?php while($cod_Ass_1 = mysqli_fetch_array($queryA_1)) {                                    
                                    if ($cod_assoc == $cod_Ass_1 ['cod_Ass'] )
                                    {
                                       $cod_assoc = $cod_Ass_1 ['cod_Ass'];
                                       $descricaoA = $cod_Ass_1 ['descricao_Ass'];
                                    }}
                                    ?>									
									<label for="cod_ass">Código Associação *</label>
									 <select id="cod_ass" name="cod_ass" value = <?php echo $cod_assoc?>>
										<option value = "<?php echo $cod_assoc; ?>">
                                            <?php echo $cod_assoc." | ".$descricaoA; ?></option>
										<?php while($cod_Ass = mysqli_fetch_array($queryA)) {?>
										<option value = "<?php echo $cod_Ass ['cod_Ass']?>"><?php echo $cod_Ass ['cod_Ass']." | ".$cod_Ass ['descricao_Ass']?></option>
										<?php } ?>														
										  </select>
							</p> <center>
						<div id="blAux5">
							<p class="numeroDoc">
									<label for="numeroDocBanco">Número do Documento Bancário</label>
									<input id="numeroDoc" name="numeroDoc" value="<?php echo $num_Doc_Banco?>" />
								<span class="style1">*</span>
							</p> 
							<p class="docFiscal">
									<label for="numDocFiscal">Número do Documento Fiscal</label>
								  <td>
									<input id="numDocFiscal" name="numDocFiscal" value="<?php echo $num_Doc_Fiscal?>" />
								<span class="style1">*</span></td>
							</p>
							<label for="hist">Data do evento financeiro</label>
							<input type="DATE" name="data" id = "data1" value=<?php echo date("'$dataFin'"); ?>  step="1"></br>	
							<?php if($tip_Pag == 0) {$transfe = "checked";$cheque = "";} else {$transfe = "";$cheque = "checked";}?>
							
                            <input <?php echo $transfe; ?> name="tipoPag" type="radio" value="trans" />Transferência
							<input <?php echo $cheque; ?> name="tipoPag" type="radio" value="cheq" />Cheque</br>
							<p class="tipo_conta">
									
									<label for="tipo_conta_Atual">Tipo de Conta *</label>
									  <select id="tipo_conta_Atual" name="tipo_conta_Atual" value = "<?php echo $tipo_Conta?>">
										<option><?php echo $tipo_Conta?></option>									
											<option value = "Suporte">Suporte</option>									
											<option value = "Corrente">Corrente</option>									
											<option value = "Poupança">Poupança</option>									
											<option value = "Investimento">Fundos de Investimento</option>
											
										  </select>
										<!--<span class="style1">*</span>  -->										
							</p>
						</div>
						<div id="blAux6">
							<p class="VALOR">
							<label for="valor">Valor do lançamento</label>
							* R$ </span><input text-align="right" name="valorFin" value="<?php echo number_format(str_replace(",",".",$valorFin ), 2, ',', '.')?>" >
							</p>
							<p class="Historico">
								<label for="razao">Razão Social</label>
								<input  name ="razaoSoc" type="text"  value="<?php echo $historico ?>"><font color=red> *</font>
								
							</p>
                            
							<p class="descri">
								<label for="descri">Descrição</label>
								<textarea name ="descri" type="text"  maxlength=100><?php echo $descricao ?></textarea><font color=red> *</font>
								
							</p>
							<p class="ent_Sai">
									<?php 
									$chek =""; $chekk ="";
									if($ent_Sai == "1") $chek ="checked";
									if($ent_Sai == "0") $chekk ="checked";
                                 //             echo 'Entrada/Saída '.$ent_Sai.' Shek '.$chek.' Shekk '.$chekk.'</br>';
									
									?>
									<label for="ent_Sai">Movimentação *</label>
									  			
											<input <?php echo $chek; ?>  name="ent_Sai"  type="radio" value = "1" />Entrada
											<input <?php echo $chekk; ?> name="ent_Sai"  type="radio" value = "0" />Saída</br>
										  
										<!--<span class="style1">*</span>  -->										
							</p>
						</div> 	
						<p class="submit"align="center">
						</p>
						
				
			
			 	
			 	
		</body>	
	
</html>