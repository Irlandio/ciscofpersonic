<html>
	<head>
		<script>
function cont(){
   var conteudo = document.getElementById('print').innerHTML;
   tela_impressao = window.open('about:blank');
   tela_impressao.document.write(conteudo);
   tela_impressao.window.print();
   tela_impressao.window.close();
}
function plan(){
   		 <?php /*
		header("Content-type: application/vnd.ms-excel"); 
		   header("Content-type: application/force-download");
		   header("Content-Disposition: attachment; filename=file.xls"); 
		   header("Pragma: no-cache");
		   echo $html;*/
   ?>
}

</script>
		<title>CONSULTA</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
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
					<h1>Resultado de consulta</h1> </text>
						 <h5><a href=PaginaConsulta.php><font color = #FFFFF0 >Nova consulta  |  
						</font> <a href=menuF.php><font color = #FFFFF0 >Página inicial</a><text-align=left/h5></font>
			</div> 
			<!--
			<div id="blMenu">  	
				
			</div>
			--><!--
			<div id="blCorpo">-->
				<div class="blogentry"> 
					<form action="menuF.php" method="post" name="form" class="form">
						<div id="print" >
							
								
                            <h2>CONSULTA
								<?php 								
								$tipoCons = $_POST["tipoConsulta"];							
							switch ($tipoCons) {
								case 0://Todas congregações
									echo ' de todos códigos';
									break;    
								case 1://Todos Funcionarios
									$tabela = "Funcionarios";
									echo ' de '.$tabela;
									break; 
								case 2://Todas doaçõess
									echo '<br/> de lançamento';
									break;
								case 3://Todas doações ordenados por valor 
									echo ' de data';
									break;
								case 4://Todas doações ordenados por valor 
									$tabela = "aenpfin";
									echo '<br/><br/> de todos lançamentos';
									break;
							}
                                
                                
                                if($tipoCons == 12 )
                                {
                                     $_SESSION["admP"] = $_POST["adm"];
                                     $_SESSION["caixaP"]  = $_POST["caixa"]; 
                                     $_SESSION["anoP"]  = $_POST["ano"];	 
                                     $_SESSION["mesNP"] = $_POST["mes"];  

                                   
                                }

								?>
                            </h2>
                            
						<div class="row espaco">
				<div class="pull-right">										
					<a href="gerar_planilha.php"><button type='button' class='btn btn-sm btn-success'>Gerar Excel</button></a>
				</div>
			</div>
							<!--<div id="blAuxRolagem"> -->
											<font size=\"10\">
											<?php
												require_once 'conexao.class.php';		
												$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex']; 			
									require_once"consultar.php";
									//require_once"consulta.php";
									$con->disconnect(); 
									if($tabela == "congregacao")
										$tipo = "codC";
									else {
										if($tabela == "produtos")
										$tipo = "codProd";
									else {
										if($tabela == "funcionarios")
										$tipo = "codF";
									}
									}
									
								?>
								</font>	<!--
							</div> -->
                        </div>			
							<p class="opcao"><!--Campo oculto para gurdar o valor
									/>>-->
							</p>
									<input name ="tipop"  type="hidden" value="<?php echo $tipo?>" 
							<p class="opcao"><!--Campo oculto para gurdar o valor-->
									<input name ="tipoConsulta"  type="hidden" value="10" />
							</p>
							<p class="tabela"><!--Campo fica em oculto apenas para guardar o indicador da tabela "congregacao"-->
									<input name ="tab"  type="hidden" value="<?php echo $tabela?>" />
							</p><b/><b/>
						
						<p class="termo">
						<label for="">**********</label>
						<b/><b/>
						</p>
						<?php
						// Converte o que esta na tela em excel e baixa
						/*
						   // Determina que o arquivo é uma planilha do Excel
						   header("Content-type: application/vnd.ms-excel");   
						   // Força o download do arquivo
						   header("Content-type: application/force-download");  
						   // Seta o nome do arquivo
						   header("Content-Disposition: attachment; filename=file.xls");
						   header("Pragma: no-cache");
						   // Imprime o conteúdo da nossa tabela no arquivo que será gerado
						   
						   echo $html;
						   */
						?>
						
						<p class="submit"align="center">
						<input type="submit" value="IMPRIMIR" onclick="cont()" colspan="2"/> <!--
						<input  type="submit" value="Excel" onclick="plan()" /> -->
						</p>
					
					</form>
				</div>  	
			<!--
			</div>  -->	
			<div id="blRodape">  	
					<h3>UTILIDADE PÚBLICA FEDERAL<text-align=center/h3>					
			</div>  
		</div>  
	 
	</body>
</html>
