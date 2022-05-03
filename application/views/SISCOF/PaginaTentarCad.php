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
				<h1 text-align=center>SISCOD - Cadastro de operadores do sistema</h1>  	
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
				 <input type="hidden" name="tipoConsulta" value="<?php echo $tipoConsulta['9'] ?>" />
					<p>
						<?php						
							$tabela= $_POST["cad"];	                        
                       if($tabela == "funcionarios"){
							$nomeF= $_POST["name"];			
                            $foneF= $_POST["foneF"];			
                            $cidade= $_POST["cidade"];			
                            $lograd= $_POST["lograd"];
                            $bairro = $_POST["bairro"];		
                            $numero= $_POST["numero"];		
                            $sexo= $_POST["sexo"];
                            $funcao= $_POST["funcao"];	
                            $user= $_POST["user"];		
                            $senha= $_POST["senha"];
                            $senhac= $_POST["senhac"];	
                            $conta_acesso= $_POST["conta_acesso"];
                            $tipo_conta_acesso= $_POST["tipo_conta_acesso"];
                            $nivel_acesso= $_POST["nivel_acesso"];
							?>
						      <input name ="termo"  type="hidden" value="<?php echo $codF?>" />
                        <?php	
                       }else  
                           if($tabela == "idosos")
                                {                                          
                                    $nomeI= $_POST["nomeI"];			
                                    $data_Nasc= $_POST["data_Nasc"];			
                                    $data_entrada= $_POST["data_entrada"];			
                                    $cpf_I= $_POST["cpf_I"];
                                    $rg_I = $_POST["rg_I"];		
                                    $status= $_POST["status"];		
                                    $sexo= $_POST["sexo"];                               
                                }
							?>						
					<input name ="termo"  type="hidden" value="<?php echo $id_idoso?>" />                       
						</p>						
					<div id="blAux6">
					<?php
						if($tabela == "cod_assoc")
                                include"anexoEditacod_Assoc.php"; 
                                else 
								if($tabela == "funcionarios")
								include"anexoEditaFuncionario.php";
							    else 
								if($tabela == "idosos")
								include"anexoEditaIdoso.php";							
												
					?>
						<p class="submit"align="center">        
							<input type="submit" value="Cadastrar"  colspan="2"/>  	    
						</p>
					</div >						
						<p class="tabela"><!--Campo oculto para guardar o tipo da tabela-->
							<input name ="cad"  type="hidden" value="<?php echo $tabela?>" />													
							<input name ="termo"  type="hidden" value="<?php echo $termo?>" />							
					</p>
				</form>	
			</div>  
			<div id="blRodape">  	

				<h1 text-align=center>Utilidade pública federal</h1>
			</div>  
		</div>
		
	</body>
</html>