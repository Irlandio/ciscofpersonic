<html>
	<head>
		<title>SISCOF - Lançamento financeiro de entrada</title>
		<link rel="stylesheet" href="styles.css" media="all" />		
	</head>
	<body bgcolor="#Feeeab">
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
			$tipo_conta_acesso = $_SESSION['tipo_conta_acesso'];			
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
			echo  "<strong>".$_SESSION['usuarioNome']."</strong> | Nivel de acesso ".$nivel." | ".$tipo_conta_acesso." | ".$contaNome;
			?>	
		</div>  	
		<h1>SISCOD - Lançamento financeiro<text-align=center></h1> 
	</div> 
			<div id="blMenu">  		
				<?php
					include"menuFLateral.html";
				?>				
			</div>  
			<div id="blCorpo">
				<form action="PaginaEntrada.php" method="post" name="form" class="form">
					<div id="blAux5">	
												
						<p class="nomeC">	
								<!--<label for="name">Nome do congregacao</label>-->					
								<input name ="termop" type="hidden" value="a" /><span class="style1"></span></td>								
						</p>
						<label for="CliCad"><H2>LANÇAMENTO FINANCEIRO DE ENTRADA </H2></label>						
						<p class="conta">
									<?php
									require_once 'conexao.class.php';
									$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex'];				
									if($contaA < 99){
									$query = mysqli_query($conex, "SELECT id_caixa, nome_caixa FROM caixas  WHERE id_caixa LIKE ".$contaA);
									}else if($contaA = 99)
									$query = mysqli_query($conex, "SELECT id_caixa, nome_caixa FROM caixas");
									
									?>									
									<label for="conta"><H3>Conta</H3></label>
									  <select id="conta" name="conta">
										<option value = 0> Selecione a conta </option>
										<?php while($cx = mysqli_fetch_array($query)) {?>
										<option value = "<?php echo $cx ['id_caixa']?>"><?php echo $cx ['id_caixa']." | ".$cx ['nome_caixa']?></option>
										<?php } ?>														
										  </select>
										<font color=red><span class="style1"> * </span></font>										
							</p>
						<p>
								<label for="tipCont"><H2>Tipo de conta</H2></label>
							   <td>	<?php
									
									switch ($tipo_conta_acesso)
									{
										case 1:	
											echo '<input  name="tipCont" type="radio" value="Suporte" />Suporte</br></br>'; 
											break;    
										case 2:	
											echo '<input checked="checked" name="tipCont" type="radio" value="Corrente" />Corrente</br></br>';
											break;  
										case 3:		
											echo '<input  name="tipCont" type="radio" value="Suporte" />Suporte</br></br>';
											echo '<input checked="checked" name="tipCont" type="radio" value="Corrente" />Corrente</br></br>';
											break;  
										case 4:		
											echo '<input  name="tipCont" type="radio" value="Suporte" />Suporte</br></br>';
											echo '<input checked="checked" name="tipCont" type="radio" value="Corrente" />Corrente</br></br>';
											echo '<input name="tipCont" type="radio" value="Investimento" />Fundos de Investimento</br></br>';
											echo '<input name="tipCont" type="radio" value="Poupança" />Poupança</br></br>';
											break; 				
									}	
									?>
									<font color=red><span class="style1"> * </span></font>
								</p>
						<p class="tabela"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
								<input name ="tab"  type="hidden" value="congregacao" />
								<input name ="tipop" type="hidden" value="nome" />
								<input name ="tipoES" type="hidden" value="entrada" />
								<input name ="tipoConsulta"  type="hidden" value="0" />
								<input name ="cadastrado"  type="hidden" value="sim"  />							
						</p>
					</div> 
					<div id="blAux6">
					<p><img class="imagefloat" src="Ieadalpe.png" alt="" width="80" height="80" border="0">  				
						<p><img class="imagefloat" src="aenpazHorizontal.png" alt="" width="180" height="50" border="0">  				
						
					</div>
						<p class="submit">
						<input type="submit" value="Proximo"  colspan="2"/>					
						</p>
				</form> 
			</div>  				
			<div id="blRodape"> 
			<h1>Utilidade pública federal<text-align=center/h1>
			</div>  
		</div>
			
	</body>
</html>