<html>
	<head>	
		<title>SISCOD - EXCLUIR</title><meta charset="iso-8859-1">
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
					<h1>SISCOF - EXCLUIR<text=center /h1>  	
			
			</div>  				
			<div id="blMenu">  		
				<?php
					include"menuFLateral.html";
				?>				
			</div>   
			<div id="blCorpo"> 
					<h3>Escolha o que excluir</h3> 

						<ul>  
							<li><a href='menuF.php'>Lançamento</a></li><br />
							<li><a href='menuF.php'>Código</a></li><br />							
							<li><a href='menuF.php'>Funcionário </a></li><br /><br />
						</ul>
				
			</div>  	
				
			<div id="blRodape"> 
			<h1>Utilidade pública federal<text-align=center/h1>
			</div>  
		</div>
			
	</body>
</html>