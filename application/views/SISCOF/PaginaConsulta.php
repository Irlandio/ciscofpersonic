
<html>
	<head>
		<title>CONSULTAS filtradas</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" href="styles.css" media="all" />		
	</head>
	<body>
		<div id="bloco">  	
			<div id="blCabeca" title="sitename">  		
				<?php
							include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
							protegePagina(); // Chama a função que protege a página
				?>				
				<div id="skipmenu">Até aqui nos ajudou o Senhor  >>>>     
					<?php 
					$conta = $_SESSION['conta_acesso'];
					$nivel = $_SESSION['nivel_acesso'];			
					$tipo_conta_acesso = $_SESSION['tipo_conta_acesso'];			
					switch ($conta) 
					{
						case 1:	$contaNome = "IEADALPE - 1444-3"; break;    
						case 2:	$contaNome = "22360-3"; break;  
						case 3:	$contaNome = "ILPI"; break;  
						case 4:	$contaNome = "BR518"; break;  
						case 5:	$contaNome = "BR518"; break;  
						case 6:	$contaNome = "BR542"; break;  
						case 7:	$contaNome = "BR549"; break;  
						case 8:	$contaNome = "BR579"; break;  
						case 9:	$contaNome = "BB 28965-5"; break;  
						case 10:$contaNome = "CEF 1948-4"; break;
						case 99:$contaNome = "Todas contas"; break;  				
					}							
					echo  "<strong>".$_SESSION['usuarioNome']."</strong> | Nivel de acesso ".$nivel." | ".$tipo_conta_acesso." | ".$contaNome;
                    
                     // erro na edção tentar denovo
                      { unset($_SESSION['c_tipoCons']); unset($_SESSION['c_tabela']); $_SESSION['c_tabela'] = "0"; }
                    if(isset( $_SESSION["c_data1"] )) {  unset($_SESSION['c_data1']);}		
                    if(isset( $_SESSION["c_data2"] )) {  unset($_SESSION['c_data2']);}		
                    if(isset( $_SESSION["c_tipop"] )) {  unset($_SESSION['c_tipop']);}		
                    if(isset( $_SESSION["c_caixa"] )) {  unset($_SESSION['c_caixa']);}		
                    if(isset( $_SESSION["c_tipCont"] )) { unset($_SESSION['c_tipCont']);}		
                    if(isset( $_SESSION["c_termop"] )) { unset($_SESSION['c_termop']);}	
                    
                   //  echo '<font color=Brown size="2"> | Tabela Global '.$_SESSION['c_tabela'].' Termo Global '.$_SESSION['c_termop'].'  caixa '.$caixa. ' <td></font><br />'. __LINE__ ;
			?>	
				</div>  			
				<h1>SISCOF - Sistema de Controle financeiro<text-align=center></h1>  	
			</div>  				
			<div id="blMenu">  	
				<?php
					include"menuFLateral.html";
				?> 
			</div>  
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
			<div id="blCorpo">  		
				<div class="blogentry">  	
                      <?php //echo '<font color=Brown size="2"> | Tabela Global '.$_SESSION['c_tabela'].' Termo Global '.$_SESSION['c_termop'].'  c_data1 Global '.$_SESSION['c_data1'].' c_data2 Global '.$_SESSION['c_data2'].'<td></font><br />'. __LINE__ ;
                    ?>
					<h2>Consulta expecifica</h2>
					<form action="PagResultConsulta.php" method="post">
						<p class="tcons"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
								<input name ="tipoConsulta"  type="hidden" value="10" />
						</p>
					<div id="blAux5">
						<p class="tab">		
							<td><label for="name">Consulta de:</label>
							<select id="tab" name="tab">					
								<option value="cod_assoc">Códigos Financeiros Aenpaz</option>		
								<option value="cod_compassion">Códigos Financeiros Compassion</option>	
								<option value="aenpfinE">Entradas</option>		
								<option value="aenpfinS">Saídas</option>
								<option value="aenpfinT">Todos lançamentos</option>
								<?php 								 
								unset($_SESSION['tid_caixa']);
									if ($nivel== 5 ){
										$linkfuncionarios = "funcionarios";
										$linkfunc = "Funcionarios";}
									else { $linkfuncionarios = " "; $linkfunc = " ";}
								?>
								<option value="<?php  echo  $linkfuncionarios  ?>"><?php  echo  $linkfunc  ?></option>	
                                     <?php if ($conta== 3 || $conta== 99 ){?>
                                    <option value="idosos">Idosos Ativos</option>
                                        <?php }	?>												
							</select>
							<font color=red> *</font>
			</td>
						<input type = "radio" name = "timetorce" id = "rd-time" value = "outro" style="margin-top:15px;" /> Mais especificos<br />
						<input type = "radio" name = "timetorce" id = "rd-tim" value = "out" style="margin-top:15px;" checked="checked"/> Menos especifico
						  
						  <div id = "palco">
						  <div id = "outro">
						  De <input type="DATE" name="data1" id = "data1"   step="1"> </br>
						   até <input type="DATE" name="data2" id = "data2"   step="1">						
						<p class="tipop">
							<label for="name">Consultar por:</label>
							<td><select id="tipop" name="tipop">										
								<option value="historico">Histórico</option>		
								<option value="cod_compassion">Código Compassion</option>	
								<option value="cod_assoc">Código IEADALPE</option>		
								<option value="num_Doc_Banco">Nº documento do banco</option>
								<option value="num_Doc_Fiscal">Nº documento fiscal</option>														
							</select>
							</td>
						</p>
						<p class="conta">
									<label for="conta"><H3>Contas</H3></label>
									  <select id="conta" name="caixa">
									<?php
										require_once 'conexao.class.php';
										$con = new Conexao();
										$con->connect(); $conex = $_SESSION['conex'];									
										if($conta < 99){
										$query = mysqli_query($conex, "SELECT id_caixa, nome_caixa FROM caixas  WHERE id_caixa LIKE ".$conta);
										}else if($conta == 99)
										{$query = mysqli_query($conex, "SELECT id_caixa, nome_caixa FROM caixas");									
										echo "<option value = 0> Todas as contas </option>";
										}
										?>										
										<?php while($cx = mysqli_fetch_array($query)) {?>
										<option value = "<?php echo $cx ['id_caixa']?>"><?php echo $cx ['id_caixa']." | ".$cx ['nome_caixa']?></option>
										<?php } ?>														
										  </select>
										<span class="style1">*</span>										
							</p>
						<p>
								<label for="tipCont"><H3>Tipo de conta</H3></label>
							  <td>								  
										<select id="conta" name="tipCont">										
									<?php									
									switch ($tipo_conta_acesso) 
									{
										case 1:	
											echo '<option value =  "Suporte"> Suporte </option></br>'; 
											break;    
										case 2:	
											echo '<option value =  "Corrente"> Corrente </option></br>';
											break;  
										case 3:		
											echo '<option value =  "Corrente"> Corrente </option></br>';
											echo '<option value =  "Suporte"> Suporte </option></br>'; 
											break;  
										case 4:		
											echo '<option value =  "Suporte"> Suporte </option></br>'; 
											echo '<option value =  "Corrente"> Corrente </option></br>';
											echo '<option value =  "Investimento"> Fundos de Investimento </option></br>'; 
											echo '<option value =  "Poupança"> Poupança </option></br>';
											break; 				
									}	
									?></select>
									<span class="style1">*</span> </td>
								</p>
								 </div>
						  </div>
						  <h4><a href=PaginaConsultaAvan.php>Consultas predefinidas</a></h4>
						<h4><a href=PaginaRelatMensal.php>Relatórios Mensais</a></h4>						
					</div>	
					<div id="blAux6"><!--
						<label for="tip">Digite a palavra a ser filtrada ou parte dela:</label>	-->			 
						<p class="termo">
								<label for="termop">Termo para pesquisa</label>
								<input name ="termop" type="text" placeholder="Termo para pesquisa" <autofocus/>
						</p>
							<input type="text" name="field" style="visibility:hidden;"/>						
						<p class="submit"align="center">	
							<input type="submit" value="Consultar"  colspan="2"/>
						</p>
					</form>
					
				</div>
			</div>  	
			<div id="blRodape">  	
					<h3>Utilidade pública federal<text-align=center/h3>					
			</div>  
		</div>  
	 
	</body>
</html>