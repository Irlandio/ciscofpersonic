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
				<h1>SISCOF - Lancamento financeiro<text-align=center></h1> 
			</div> 
			<div id="blMenu">  		
				<?php
					include"menuFLateral.html";
				?>				
			</div>  
			<div id="blCorpo">
				<div id="blAux5">							
									
	
					<form action="PaginaEntrada.php" method="post" name="form" class="form">
					<p class="tabela"><!--Campo fica em oculto apenas para guardar o indicador para consulta completa-->
								<input name ="tipoConsulta"  type="hidden" value="0" />
								<input name ="cadastrado"  type="hidden" value="sim"  />
						</p>	<br><br>						
						<p class="nomeC">	
								<!--<label for="name">Nome do congregacao</label>	-->					
								<input name ="termop" type="hidden" value="a" /><span class="style1"></span>							
						</p>
						<label for="CliCad"><H2>LANÇAMENTO FINANCEIRO </H2></label>						
						<td>
							<!--<input checked="checked"name="cadastrado" type="radio" value="sim" />Sim      
							<input name="cadastrado" type="radio" value="nao" />Nao  <br />-->	
							<?php
					
								if( $conta == 99 || 3)
								echo "<h2><a href=PaginaLancamentoE.php>Entrada</a></h2>";					
							?>	
							<h2><a href=PaginaLancamentoS.php>Saída</a></h2>
						</td>
						<p class="tabela"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
								<input name ="tab"  type="hidden" value="congregacao" />
						</p><br><br>
						<p class="tipo"><!--Campo fica em oculto apenas para gurdar o valor "nome"-->								
								<input name ="tipop" type="hidden" value="nome" />
						</p><br><br>
						
					</form>
				</div> 
				<div id="blAux6">
				<p><img class="imagefloat" src="Ieadalpe.png" alt="" width="80" height="80" border="0">  				
					<p><img class="imagefloat" src="aenpazHorizontal.png" alt="" width="180" height="50" border="0">  				
					
				</div> 
			</div>  	
			



			
			<div id="blRodape"> 
			<h1>Utilidade pública federal<text-align=center/h1>
			</div>  
		</div>
			
	</body>
</html>
