
<html>
	<head><link rel="stylesheet" href="styles.css"  />	
	<head><link rel="stylesheet" href="styleprint.css" media="print" />	
	<script>
function cont(){
   var conteudo = document.getElementById('print').innerHTML;
   tela_impressao = window.open('about:blank');
   tela_impressao.document.write(conteudo);
   tela_impressao.window.print();
   tela_impressao.window.close();
}
</script>
		<title>SISCOF - Baixa de cheque</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
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
			require_once 'funcao.php';
		  
		   ?>	
		</div>  	  		
					<h1>SISCOF- Baixa de cheque </h1>  	
			</div>  				
			<div id="blMenu">  		
				<?php
					include"menuFLateral.html";
				?>				
			</div>  
			<div id="blCorpo">
				<form action="Editar.php" method="post" onsubmit="validaForm(); return false;" class="form">		
						<p><img class="imagefloat" src="aenpazHorizontal.png" alt="" width="200" height="45" border="0">
							<?php
                            require_once 'conexao.class.php';		
								$con = new Conexao();		 
								$con->connect(); $conex = $_SESSION['conex']; 
                            echo "<br/>";
							$cheques	= $_POST["cheque"]; $num = 0;
                            foreach($cheques as $chq => $ch){
                                $cheque = $ch;
                               // echo "<h4></b>Baixa do cheque de registro. ".$cheque."</h4>";	
								
                                
								echo "<font color = grey size = 3>Dados do cheque do lançamento ".$cheque."</font><br/>";
								
                                $cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, 
											historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
											WHERE id_fin = id_aenp and  id_aenp = '.$cheque.' limit 1');
							
								if (!$cheques_abertos) 
									{	die ("<center>Desculpe, O registro do cheque não foi encontrado. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										exit;
									}
								if (mysqli_num_rows($cheques_abertos) == 0 ) 
									{	echo "Nao foi encontrado nenhum registro do cheque. Tente novamente!"; exit;
									}										
										$total = 0;	$inicio = 1;
								while ($rows_chek = mysqli_fetch_assoc($cheques_abertos)) 
								{	
                                    ++$num ;
                                    switch ($rows_chek['conta']) 
									{
										case 1:	$contaN = "IEADALPE - 1444-3"; break;    
										case 2:	$contaN = "22360-3"; break;  
										case 3:	$contaN = "ILPI"; break;  
										case 4:	$contaN = "BR214"; break;  
										case 5:	$contaN = "BR518"; break;  
										case 6:	$contaN = "BR542"; break;  
										case 7:	$contaN = "BR549"; break;  
										case 8:	$contaN = "BR579"; break;  
										case 9:	$contaN = "BB 28965-5"; break;  
										case 10:$contaN = "CEF 1948-4"; break;
										case 99:$contaN = "Todas contas"; break;  				
									}		
                                        
										$data_Ch= implode('/',array_reverse(explode('-',$rows_chek['dataFin'])));
									//	$val_Ch= number_format($rows_chek['valorFin'], 2, ',', '.');
										$valorFin= $rows_chek['valorFin'];
                                 
                                    // Função verifica se o valor é válido para moeda, tendo o padrão 999.999.999,99   
                     if(formatoRealPntVrg($valorFin) == true) 
                   {  $valorFinExibe  =    $valorFin;  
                      $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));// echo " ===Ponto virg== </br>";
                   }else if(formatoRealInt($valorFin) == true)
                   {$valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');//echo " ===Inteiro== </br>";
                   }else if(formatoRealPnt($valorFin) == true)
                   { $valorFin  =    $valorFin;
                     $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.'); // echo " ===Ponto == </br>";
                   }else if(formatoRealVrg($valorFin) == true)
                   {$valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));//echo " ===virg== </br>";
                   }
                      $val_Ch = $valorFinExibe;
                                 
											echo "Conta  - <strong><td>".$contaN."</td></strong><br/>";
											echo "Cheque número  - <strong><td>".$rows_chek['num_Doc_Banco']."</td></strong> - ";
											echo "Referente a  - <strong><td>".$rows_chek['historico']."</td></strong> - </br>";
											echo "<br/>Data da emissão - <strong><td>".$data_Ch."</td></strong>  - ";                               
											echo "</b> Valor <strong><td> R$  ".$val_Ch."</td></strong></br>";
											echo " ======== ======== ======== </br>";
                                            
                                 ?>
                                 <input name ="status<?php echo $num ?>"  type="hidden" value="<?php echo $rows_chek['status'] ?>"/>
							     <input name ="cheque<?php echo $num ?>"  type="hidden" value="<?php echo $cheque ?>"/>
							 <?php
								}
								} 
								$cadastrante= $_SESSION['usuarioID'];
								?>
								
								 <input type="DATE" name="dataPag" id = "data1" value="now"  step="1">
						   
								<h4>Para dar baixa neste registro de cheque, preencha a data e clique em próximo. </h4>
								
							<p class="variaveis"><!--Campo fica em oculto apenas para guardar o indicador da tabela "congregacao"-->
							<input name ="cad"  type="hidden" value="reconc_bank"/>
							<input name ="qtdch"  type="hidden" value="<?php echo $num ?>"/>
							</p>
								<p class="submit"align="center">        
									<input type="submit"value="Próximo" colspan="2"/>  
								</p>	
								
					</form>
					</div>	
			<div id="blRodape"> 
			<h1 text-align=center>Utilidade pública federal</h1>					
			</div>  
		</div>
			
	</body>
</html>