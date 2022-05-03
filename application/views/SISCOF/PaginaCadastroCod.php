
<html>
	<head>
		<title>Cadastro Códigos financeiros</title>
		<meta charset="iso-8859-1">
		<link rel="stylesheet" href="styles.css" media="all" />		
	</head>
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
						case 4:	$caixaNome = "BR518"; break;  
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
				<h1>SISCOD - Cadastro de Códigos financeiros<text-align=center></h1>  	
			</div> 	
			<div id="blMenu">  	
			<?php
			include"menuFLateral.html";
			?>			
			</div> 	
			<div id="blCorpo">  		
				<div class="blogentry">  	
				</div> 			
				<form action="cadastrar.php" method="post" onsubmit="validaForm(); return false;" class="form">	
								
						<p class="tabela"><!--Campo fica em oculto apenas para guardar o valor "clientes"-->
								<input name ="cad"  type="hidden" value="produtos" />
						</p>
						<p class="opcao"><!--Campo fica em oculto apenas para guardar o valor "clientes"-->
								<input name ="op"  type="hidden" value="opCadProd" />
						</p>
							</p>							
						<div id="blAux5">							
							<p class="codigo">
								<label for="codigo">Código</label>
								<input name ="codigo" type="text" placeholder="Código" /><span class="style1">*</span></td>
							</p>
							<p class="descricao">
								<label for="descricao">Descrição</label>
								<input name="descricao" type="text" placeholder="Descrição" /><span class="style1">*</span></td>
							</p>							
							<p class="Area">
								<label for="area">Área</label>
								<input name ="area" type="text" placeholder="Área" /><span class="style1">*</span></td>
							</p>								
													
							<p>						
								<label for="mov">Movimentação</label>

							  <td><input checked="checked" name="mov" type="radio" value="1" />Entrada<br />
							  <input name="mov" type="radio" value="0" />Saída 
							  <span class="style1">*</span> </td>
							</p>						
								 	
								</p><br /><br /><br /><br />					
							<p class="submit"align="center">        
								<input type="submit" value="Cadastrar"  colspan="2"/>  	    
							</p>		
						</div>  
					</form>	
				<div id="blRodape">  	

					<h1>Utilidade pública federal<text-align=center/h1>
				</div>  
			</div>
		</div>
	</body>
</html>