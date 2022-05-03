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
                            $conta = $_SESSION['conta_acesso'];
                            $nivel = $_SESSION['nivel_acesso'];			
                            $tipo_conta_acesso = $_SESSION['tipo_conta_acesso'];			
                            switch ($conta) 
                            {
                                case 1:	$contaNome = "IEADALPE - 1444-3"; break;    
                                case 2:	$contaNome = "22360-3"; break;  
                                case 3:	$contaNome = "ILPI"; break;  
                                case 4:	$contaNome = "BR518"; break;  
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
                <h1 text-align=center>SISCOF - Sistema de Controle financeiro</h1>  	
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
							
					<h2>Consultas predefinidas</h2>
					<form action="PagResultConsultaAvan.php" method="post">
						<p class="term"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
								<input name ="termop"  type="hidden" value="relat" />
						</p>
						<p class="tip"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
								<input name ="tipop"  type="hidden" value="relat" />
						</p>
							<p class="TipoCon">
								<label for="fone">Selecione uma consulta</label>
							  <td>
								<select id="cons" name="tipoConsulta">			
                                     <?php if ($conta== 3 || $conta== 99 ){?>
                                    <option value="200">Idosos Ativos</option>
                                    <option value="201">Idosos Inativos</option>
                                        <?php }	?>								
									<option value="0">01-Todos códigos</option>		
							<!--	<option value="1">02-Todos Funcionarios</option>-->
									<option value="1010">02-Entradas do mês atual </option>
									<option value="1020">03-Saídas do mês atual</option>
									<option value="1030">04-lançamentos do mês atual</option>
									<option value="1">05-Entradas dos ultimos dois meses </option>
									<option value="102">06-Saídas dos ultimos dois meses</option>
									<option value="103">07-lançamentos dos ultimos dois meses</option>
                                    <option value="104">08-Presentes do mês atual</option>
                                    <option value="105">09-Presentes dos ultimos dois meses</option>
                                    <option value="106">10-Presentes do mês atual (Detalhado)</option>
                                    <option value="107">11-Presentes dos ultimos dois meses  (Detalhado)</option>
								</select><span class="style1">*</span></td>
                        </p>
						<p class="submit"align="center">							
							<input type="submit" value="Consultar"  colspan="2"/>
						</p>
							<input type="text" name="field" style="visibility:hidden;"/>
						<!--
						<input type = "radio" name = "timetorce" id = "rd-time" value = "outro" style="margin-top:15px;" /> Periodo
							<input type = "radio" name = "timetorce" id = "rd-tim" value = "out" style="margin-top:15px;" checked="checked"/> Sem periodo
                        -->
					  
						  <div id = "palco">
						  <div id = "outro">
						  De <input type="DATE" name="data1" id = "data1" value="now"  step="1"> até 
						  <input type="DATE" name="data2" id = "data2" value="now"  step="1">
						  </div>
						  </div>
						<input name ="conta_acesso"  type="hidden" value="<?php echo $conta ?>"/>
							<input name ="tipo_conta_acesso"  type="hidden" value="<?php echo $tipo_conta_acesso?>"/>
							<input name ="nivel"  type="hidden" value="<?php echo $nivel ?>"/>	
										
					</form>
			</div>  	
			<div id="blRodape">  	
					<h3 text-align='center'>Utilidade pública federal</h3>					
			</div>  
		</div>  
	 
	</body>
</html>