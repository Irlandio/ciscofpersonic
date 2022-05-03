<html>
	<head>

		<title>CONSULTA</title>
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
			$caixa = $_SESSION['conta_acesso'];
			$nivel = $_SESSION['nivel_acesso'];			
			switch ($caixa) 
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
		<h1>SISCOD - Sistema de Controle de Doações<text-align=center></h1>  	
	</div> 		
			<div id="blMenu">  	
				<?php
					include"menuFLateral.html";
				?> 						
			</div>  
		
			<div id="blCorpo">  		
				
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
									{
											tags[i].style.display = 'none';
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
							
					<h2>Relatório mensal</h2>
					<form action="PagResultConsultaAvan.php" method="post">
						<p class="term"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
								<input name ="termop"  type="hidden" value="relat" />
								<input name ="tipop"  type="hidden" value="relat" />
								
						</p>
						<p>						
								<label for="Adm">Administração do relatório</label>

							  <td><input name="adm" type="radio" value="cod_assoc" />IEADALPE
							  <input name="adm"  checked="checked" type="radio" value="cod_compassion" />COMPASSION 
							  <span class="style1">*</span> </td>
							<p class="caixa">
									<?php
									$conta = $_SESSION['conta_acesso'];
										require_once 'conexao.class.php';
										$con = new Conexao();
										$con->connect(); $conex = $_SESSION['conex'];									
										if($conta < 99){
										$query = mysqli_query($conex, "SELECT id_caixa, nome_caixa FROM caixas  WHERE id_caixa LIKE ".$conta);
										}else if($conta = 99)
										$query = mysqli_query($conex, "SELECT id_caixa, nome_caixa FROM caixas");									
									?>										
									<H3>Conta</H3>
									  <select id="caixa" name="caixa"><!--
										<option value = 0> Selecione o caixa </option>-->
										<?php while($cx = mysqli_fetch_array($query)) {?>
										<option value = "<?php echo $cx ['id_caixa']?>"><?php echo $cx ['id_caixa']." | ".$cx ['nome_caixa']?></option>
										<?php } ?>														
										  </select>
										<span class="style1">*</span>										
									
							
								<H3>Ano</H3>
							  <td>
							  <?php 
							  $ano =date("Y");
							  $anoIni = 2009;
							  ?>	
								<select id="ano" name="ano">
										<option value =<?php echo $ano?>><?php echo $ano ?> </option>
										<?php --$ano;
                                            while($anoIni < $ano) {?>
										<option value = "<?php echo $ano ?>"><?php echo $ano?></option>
										
										<?php --$ano;} ?>														
										  </select><span class="style1">*</span></td>
							
								<H3>Mês</H3>
							  <?php
									$meses = array("", "janeiro", "fevereiro", "março", "abril",
									"maio", "junho", "julho", "agosto",
									"setembro", "outubro", "novembro", "dezembro");
									$data = date("m");
									$data <= 9 ? $data = $data[1] : $data = $data;
									?>

									<select id="mes" name="mes">
									<?php
									for($i = 1; $i <= count($meses)-1; $i++) {
									$i == $data ? $valor = "selected" : $valor = "";
									echo "<option value='$meses[$i]' $valor>$meses[$i]</option>";
									}
									?>
									</select>												
										 <span class="style1">*</span></td>
							</p>
						<p class="submit"align="center">							
							<input type="submit" value="Consultar"  colspan="2"/>
						</p>
					
							<input type="text" name="field" style="visibility:hidden;"/>
						
						
						  </span>
						  <div id = "palco">
						  <div id = "outro">
						  De <input type="DATE" name="data1" id = "data1" value="now"  step="1"> até 
						  <input type="DATE" name="data2" id = "data2" value="now"  step="1">
						  </div>
						  
						  </div>
								<input name ="tab"  type="hidden" value= "aenpfin" />	
								<input name ="tipoConsulta"  type="hidden" value= 12 />	
					</form>
					
			</div>  	
			<div id="blRodape">  	
					<h3>Utilidade pública federal<text-align=center/h3>					
			</div>  
		</div>  
	 
	</body>
</html>