<html>
	<head>
		<title>Cadastro de Idoso</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<link rel="stylesheet" href="styles.css" media="all" />
	</head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<body >
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
				<h1 text-align=center>SISCOF - Cadastro de Idoso</h1>  	
			</div> 
			<div id="blMenu">  	
				<?php
					include"menuFLateral.html";
				?> 						
			</div> 
			<div id="blCorpo">  		
							
				<form action="cadastrar.php" method="post" onsubmit="validaForm(); return false;" class="form">
						
						
							<p class="tabela"><!--Campo fica em oculto apenas para guardar o valor "funcionario"-->
									<input name ="cad"  type="hidden" value="idosos" />
							</p>
							<p class="opcao"><!--Campo fica em oculto apenas para guardar o valor "funcionario"-->
									<input name ="op"  type="hidden" value="opCad" />
							</p>							
						<div id="blAux5">
							<p class="name">
								<label for="name">Nome do idoso</label>
								<input name ="nameI" type="text" placeholder="Nome do Idoso" autofocus/>
							</p>
							<p class="fone">
								<label for="data_Nasc">Data Nascimento</label>
								<input  name="data_Nasc" id="data_Nasc" type="DATE" placeholder="Data Nascimento" />
							</p>
							<p class="cpf_I">
								<label for="cpf_I">CPF</label>
								<input name ="cpf_I" type="text" placeholder="XXX.XXX.XXX-XX" />
							</p>	
							<p class="rg_I">
								<label for="rg_I">RG</label>
								<input name ="rg_I"type="text" placeholder="XX.XXX.XXX" />
							</p>	
							
						</div>
						<div id="blAux6"> 
							<p class="data_entrada">
									<label for="data_entrada">Data de Entrada no ILPI</label>
								  <td>
									<input type="DATE" id="data_entrada" name="data_entrada" placeholder="Data Entrada" />
								<font color=red><span class="style1"> * </span></font>
							</p>
							<p class="status">
								<label for="status">status</label>
								<td><select id="status" name="status">
								<option value="Ativo">Ativo</option>		
								<option value="Inativo">Inativo</option>														
								  </select>
								<font color=red><span class="style1"> * </span></font>
							</p>					
							<p>						
								<label for="Genero">Sexo</label>

							  <td><input checked="checked" name="sexo" type="radio" value="M" />Masculino<br />
							  <input name="sexo" type="radio" value="F" />Feminino 
							  <font color=red><span class="style1"> * </span></font>
							</p>
						</div> 	
						<p class="submit"align="center">
						<input type="submit" value="Avançar"  colspan="2"/>					
						</p>
				</form>			
			</div>  	
			<div id="blRodape">  	
					<h3 text-align=center>Utilidade pública federal</h3>					
			</div>  
		</div>  
	</body>
</html>