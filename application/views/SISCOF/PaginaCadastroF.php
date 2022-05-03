
<html>
	<head>
		<title>Cadastro de operadores</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
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
				<h1>SISCOD - Cadastro de operadores do sistema<text-align=center></h1>  	
			</div> 
			<div id="blMenu">  	
				<?php
					include"menuFLateral.html";
				?> 						
			</div> 
			<div id="blCorpo">  		
							
				<form action="paginacadNivel.php" method="post" onsubmit="validaForm(); return false;" class="form">
						
						
							<p class="tabela"><!--Campo fica em oculto apenas para guardar o valor "funcionario"-->
									<input name ="cad"  type="hidden" value="funcionarios" />
							</p>
							<p class="opcao"><!--Campo fica em oculto apenas para guardar o valor "funcionario"-->
									<input name ="op"  type="hidden" value="opCad" />
							</p>
								</p>											
						<div id="blAux5">
							<p class="name">
								<label for="name">Nome do funcionario</label>
								<input name ="name" type="text" placeholder="Nome do Funcionário" autofocus/>
							</p>
							<p class="fone">
								<label for="fone">Telefone</label>
								<input name="foneF" type="text" placeholder="Telefone(9.0000-0000)" />
							</p>
							<p class="cidade">
									<?php
									require_once 'conexao.class.php';
									$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex'];									
									$query = mysqli_query($conex, "SELECT idC, nome, estado FROM cidade");
									?>									
									<label for="cidade">Cidade</label>
									  <td><select id="cidade" name="cidade">
										<option>Selecione a cidade</option>
										<?php while($cid = mysqli_fetch_array($query)) {?>
										<option value = "<?php echo $cid ['idC']?>"><?php echo $cid ['nome']?></option>
										<?php } ?>														
										  </select>
										<font color=red><span class="style1"> * </span></font>
										</td>
							</p>
							<p class="Bairro">
									<label for="bairro">Bairro</label>
								  <td>
									<input id="bairro" name="bairro"placeholder="Bairro" />
								<font color=red><span class="style1"> * </span></font>
							</p>
						</div>
						<div id="blAux6"> 
							<p class="lograd">
								<label for="lograd">Logradouro</label>
								<input name ="lograd" type="text" placeholder="Rua, Condominio, Travessa, etc..." />
							</p>	
							<p class="numero">
								<label for="numero">Numero</label>
								<input name ="numero"type="text" placeholder="Numero, Apartamento, casa, etc..." />
							</p>	
							<p class="Funcao">
								<label for="funcao">Funcao</label>
								<td><select id="funcao" name="funcao">
								<option>Selecione...</option>
								<option value="Assistente financeiro">Assistente financeiro</option>		
								<option value="Coordenador financeiro">Coordenador financeiro</option>
								<option value="Diretor(a) pedagógica">Diretor(a) pedagógica</option>		
								<option value="Presidente">Presidente</option>							
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
					<h3>Utilidade pública federal<text-align=center/h3>					
			</div>  
		</div>  
	</body>
</html>