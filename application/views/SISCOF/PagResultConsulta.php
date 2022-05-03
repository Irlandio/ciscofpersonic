<html>
	<head>
        <script language="JavaScript" type="text/javascript">
  if (screen.width >= "1024") {
    window.resizeTo(1024, 768);
  }
  if (screen.width == "800") {
    window.resizeTo(800, 600);
  }
  if (screen.width <= "800") {
    window.resizeTo(640, 420);
  }
</script>
		<script>
function cont(){
   var conteudo = document.getElementById('print').innerHTML;
   tela_impressao = window.open('about:blank');
   tela_impressao.document.write(conteudo);
   tela_impressao.window.print();
   tela_impressao.window.close();
}
</script>
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
            
            
               if(isset($_SESSION['t_op_Exc_Edit']))// erro na edção tentar denovo
                  {
                   unset($_SESSION['t_tabela']);        
                    unset($_SESSION['t_idfin']);
                    unset($_SESSION['t_op_Exc_Edit']);
                    unset($_SESSION['t_senhaAdm']) ;
                    unset($_SESSION['t_op_Exc_Edit']) ;
               }
			echo  "<strong>".$_SESSION['usuarioNome']."</strong> | Nivel de acesso ".$nivel." | ".$caixaNome;
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
					<form action="PaginaEditar1.php" method="post" name="form" class="form"> <!--	-->
								<h2>Consulta
								<?php 
                                    		
                               if(($_SESSION['c_tabela']) <> "0" )// erro na edção tentar denovo
                                {     
                                 $tabela =          $_SESSION['c_tabela'];
                                 $tipoCons =        $_SESSION['c_tipoCons'];
                                   
                               //  $_POST["data1"] =   $_SESSION['c_data1'];
                               //  $_POST["data2"] =   $_SESSION['c_data2'];
                               } else 
                               {
								if(isset( $_POST["tipoConsulta"] )) $_SESSION['c_tipoCons'] =   $_POST["tipoConsulta"];
								if(isset( $_POST["tab"] ))          $_SESSION['c_tabela'] =     $_POST["tab"];
                                if(isset( $_POST["tipop"] ))    {   $_SESSION['c_tipop'] =      $_POST["tipop"];}	
                                if(isset( $_POST["caixa"] ))    {   $_SESSION['c_caixa'] =      $_POST["caixa"];}	
                                if(isset( $_POST["tipCont"] ))  {   $_SESSION['c_tipCont'] =    $_POST["tipCont"];}	
                                if(isset( $_POST["termop"] ))   {   $_SESSION['c_termop'] =     $_POST["termop"];}	
                                $tipoCons = $_POST["tipoConsulta"];
                                $tabela = $_POST["tab"];
                                }   
                                 //  echo  $tipoCons."  ".$tabela;
                                    
                                    
								if($tabela == "cod_compassion"){echo ' de códigos financeiros da Compassion';
								}else if($tabela == "cod_assoc"){echo ' de códigos financeiros IEADALPE';
								}else if($tabela == "funcionarios"){echo ' de funcionarios';
								}else if($tabela == "idosos"){echo ' de idosos';}
                                else if($tabela == ("aenpfin" || "aenpfinT")){echo ' de lançamentos financeiros';} 
                                else if($tabela == ( "aenpfinS" )){echo ' de lançamentos financeiros de SAÍDA';} 
                                else if($tabela == ( "aenpfinE" )){echo ' de lançamentos financeiros de ENTRADA';} else {echo ' de '.$tabela;}
                                    
								
                                    ?></h2>
							<div id="blAuxRolagem1"> 
											<!--<font size=\"1\">-->
											<?php
												require_once 'conexao.class.php';		
												$con = new Conexao();
									$con->connect(); $conex = $_SESSION['conex']; 			
									require_once"consultar.php";
									//require_once"consulta.php";
									$con->disconnect(); 
									$tipoc = $tipo;
									if($tabela == "cod_compassion"){
										$tipo = "cod_Comp";
									$tipoCons = 11;}
									else 
										if($tabela == "cod_assoc"){
										$tipo = "ent_SaiAss";
										
										$tipoCons =  11;}
									else 
										if($tabela == "funcionarios"){
										$tipo = "codF";
									$tipoCons = 11;
									}else
                                         if($tabela == "idosos" ) {$tipoCons = 200; $tipo = "id_idoso"; }
                                    else 
										if($tabela == ("aenpfin" || "aenpfinS" || "aenpfinE" || "aenpfinT")){
										$tabela = "aenpfin";
										$tipo = "id_fin";
									$tipoCons = 11;
									}
									
								?>
								<!--</font>	-->
							</div>
								
							<p class="opcao"><!--Campo oculto para gurdar o valor/>>-->
									<input name ="tipop"  type="hidden" value="<?php echo $tipo?>" />
							</p>
									 
							<p class="opcao"><!--Campo oculto para gurdar o valor-->
									<input name ="tipoConsulta"  type="hidden" value="<?php echo $tipoCons?>" />
							</p>
							<p class="tabela"><!--Campo fica em oculto apenas para guardar o indicador da tabela "congregacao"-->
									<input name ="tab"  type="hidden" value="<?php echo $tabela?>" />
							</p><b/><b/>
						
						<p class="termo">
							<label for="">****Pesquisa por - "<?php echo $tipoc?>" - contendo - "<?php echo $termo?>"******</label>
							<b/><b/><label for="termo">Codigo de Cadastro</label>
							<input name ="termop" type="text" placeholder="Digite para Editar" />
							<?php
								//if($nivel < 4) $nivel = 1;
									switch ($_SESSION['nivel_acesso']) 
									{
										case 3:	
                                            echo '<input  name="op_Exc_Edit" type="radio" value="1"  /><font color=green>EDITAR';
										//	echo '<input checked="checked" name="op_Exc_Edit" type="radio" value="2"  /><font color=green>EXCLUIR</font/>';
											break;    
										case 4:													
											echo '<input  name="op_Exc_Edit" type="radio" value="1"  /><font color=green>EDITAR';
											echo '<input checked="checked" name="op_Exc_Edit" type="radio" value="2" />EXCLUIR</font/>';
											break;  
										case 5:													
											echo '<input  name="op_Exc_Edit" type="radio" value="1"  /><font color=green>EDITAR';
											echo '<input checked="checked" name="op_Exc_Edit" type="radio" value="2" />EXCLUIR</font/>';
											break;  
													
									}	//echo '<input checked="checked"  name="op_Exc_Edit" type="radio" value="1" />Excluir</br>'; 
											
									?>
						
							
						<p class="submit"align="center">
						<input type="submit" value="Próximo"  colspan="6"/><!--
						<input type="submit" value="Imprimir" onclick="cont()" colspan="6"/>	-->
						</p>
                        <?php if($caixa == 99) {?>
                        <p class="senhaAdm">
										<input  type="password" id="senhaAdm" name="senhaAdm" placeholder="Senha de administrador" />
									<span class="style1">*</span>
							</p>
                       <?php } ?>
					</form>
				<!--
				</div>  -->	 	
			</div>  	
			<div id="blRodape">  	
					<h3>UTILIDADE PÚBLICA FEDERAL<text-align=center/h3>					
			</div>  
		</div>  
	 
	</body>
</html>
