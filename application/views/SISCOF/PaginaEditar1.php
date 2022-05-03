<html>
	<head>
		<title>Alteração de cadastro</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<link rel="stylesheet" href="styles.css" media="all" />				
	</head>
	<body >
		<div id="bloco">  	
			<div id="blCabeca" title="sitename">  		
				<?php
							include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
							protegePagina(); // Chama a função que protege a página
					?>				
				Até aqui nos ajudou o Senhor  >>>>     
					<?php 
                
                    require_once 'funcao.php';
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
                           $senhaAdm =          $_SESSION['t_senhaAdm'];
                           $_POST["tipop"]=     $_SESSION['t_tipo'] ;
                           $_POST["termop"]=    $_SESSION['t_termo'] ;
                           $_POST["tab"] =      $_SESSION['t_tabela'] ;   
                           $_POST["tipoConsulta"] = $_SESSION['t_tipoCons'] ;   
                           $op_Exc_Edit= 1;					
                          } else
                           {
                               if(isset($_POST["tipoConsulta"]))    { $tipoCons = $_POST["tipoConsulta"]; $_SESSION['t_tipoCons'] = $tipoCons;}
                                if(isset($_POST["tipop"]))          { $tipo = $_POST["tipop"];            $_SESSION['t_tipo'] = $tipo;} 
                                if(isset($_POST["termop"]))         { $termo = $_POST["termop"] ;         $_SESSION['t_termo'] = $termo;} 
                                if(isset($_POST["tab"]))            { $tabela = $_POST["tab"];            $_SESSION['t_tabela'] = $tabela;}
                                 
                                 
                               $_SESSION['t_op_Exc_Edit'] = $_POST["op_Exc_Edit"];
                               $_SESSION['t_senhaAdm'] = $_POST["senhaAdm"];
                               $op_Exc_Edit = $_POST["op_Exc_Edit"];	
                               $senhaAdm = $_POST["senhaAdm"];
                           }
                        
                          if(isset($_SESSION['termo']))
                          {
                            $termmo= $_SESSION['termo'] ;
                            $tabella = $_SESSION['tabela'] ;
                            $op_Exc_Edit= 1;					
                          }
                
					echo  "<strong>".$_SESSION['usuarioNome']."</strong> | Nivel de acesso ".$nivel." | ".$caixaNome." | op_Exc_Edit - ".$op_Exc_Edit;
						if($op_Exc_Edit == "1")
							{$op_E = "edição";
							}else
							if($op_Exc_Edit == "2")
							{$op_E = "exclusão";
							}                        
					?>	
				  		
				<h1>Resultado para <?php echo $op_E ?>  	<text-align=center></h1>  	
			</div> 	
			<div id="blMenu">  	
			<?php
			include"menuFLateral.html";
			?>
			</div> 	
			<div id="blCorpo">  		
				<div class="blogentry">  	
				</div>
				<?php
                    require_once 'conexao.class.php';		
							$con = new Conexao();		 
							$con->connect(); $conex = $_SESSION['conex']; 			
							require_once"consultar.php";				
							$con->disconnect(); 
							//$tab= $_POST["tab"];
							//
               
                if($tabela == "aenpfin")
                {   
                    $mesPassado =date('m')-1;
                    $dataHoje	=date('Y-m-d');
                    $data_01Mpassado =  primeiroDiaMesPassado($dataHoje);
                    $data_001 =  primeiroDiaMes($dataHoje);								
					$data_007 =  setimoDiadoMes($dataHoje);
                   // $entrada_S = "Editar.php";
					//echo 'Dia hoje '.$dataHoje.'Dia do lançamento '.$dataFin.' Dia 1 do mês passado '.$data_01Mpassado.'<br/>';
                    if(($dataFin < $data_01Mpassado)  && ($senhaAdm <> "aenp@z18"))
                    { //echo "<font color = red size = 3>Este registro não pode ser alterado ou excluido, por ter data anterior ao mês ".$mesPassado.", Contate o administrador.</font>";
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaConsulta.php'>
											<script type=\"text/javascript\">
											alert(\"Este registro não pode ser alterado ou excluido, \ por ter data anterior ao mês ".$mesPassado.", Contate o administrador!\");											
											</script>";	
                     exit;
                    }
                else
					if(($dataFin < $data_001)  && ($dataHoje  >= $data_007) && ($senhaAdm <> "aenp@z18")) //Liberar temporariamente o lançament
                    {echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaConsulta.php'>
											<script type=\"text/javascript\">
											alert(\"Este registro não pode ser alterado ou excluido, \ por ser do mês ".$mesPassado.", Contate o administrador!\");											
											</script>";	
                     exit;
                    }
                }
                else 
                if($tabela == "idosos"){
                    
                  
                }  
                switch ($op_E) 
			     {
				case "edição": 
					 $entrada_S = "Editar.php";	
                   //  echo 'Opção de pagina 1 '.$entrada_S;
					break;                                 
				case "exclusão":
					 $entrada_S = "Excluir.php";
                 //    echo 'Opção de pagina 2 '.$entrada_S;
					break; 	  
                } 
                
                    
				?>
				<form  action="<?php echo $entrada_S ?>" method="post" onsubmit="validaForm(); return false;" class="form">	
				 <input type="hidden" name="tipoConsulta" value="<?php echo $tipoConsulta['9'] ?>" />					
						<?php
						//	echo 'Pagina '.$op_E.'<br/>';
							if($tabela == "cod_assoc")
								{
								}else 
								if($tabela == "funcionarios")
									$termo = $codF;
								else 
								if($tabela == "aenpfin")
								$termo = $id_fin;
                                else 
                                if($tabela == "idosos"){
                                    $termo = $id_idoso;
                                }  
							//echo "termo id_fin= ".$termo." tabela = ".$tabela;
							?>
							<p class="Historico">
							<label for="just">Justificativa</label>
							<textarea name ="just" type="text" placeholder="Justifique a exclusão" autofocus></textarea>
							</p>
						</p>			
					<h2><text-align=center><font color=#458B74>Para concluir a <?php echo $op_E ?>  clique em "Concluir".</font/></h2>
					<div id="blAux6">
					<?php
						
						
                        //  $op_Exc_Edit = $_POST["op_Exc_Edit"];
                        
						if($op_Exc_Edit == "1")
							{	
								if($tabela == "cod_assoc")
								{
									include"anexoEditacod_Assoc.php";
								}else
									if($tabela == "funcionarios")
									include"anexoEditaFuncionario.php";
								else
									if($tabela == "aenpfin")
								include"anexoEditarLanc.php";
                                else
                                if($tabela == "idosos"){
                                    include"anexoEditaIdoso.php";
                                }
				//				echo '<input type="submit" value="Editar" colspan="2"/></br>'; 
							}else
							if($op_Exc_Edit == "2")
							{
								$bt_Escolhe = "Excluir";
				//				echo '<input  type="submit" value="Excluir" colspan="2"/></br>'; 											
							}
					?>
						<p class="submit"align="center">        
							<input type="submit" value="Concluir"  colspan="2"/>  	    
						</p>
					</div >							
						
						<p class="tabela"><!--Campo oculto para guardar o tipo da tabela-->
							<input name ="cad"  type="hidden" value="<?php echo $tabela?>" />
                            <input name ="senhaAdmin"  type="hidden" value="<?php echo $senhaAdm?>" />
					</p>
                         <?php if($caixa == 99) {?>
                        <p class="senhaAdm">
										<input  type="password" id="senhaAdm" name="senhaAdm" placeholder="Senha de administrador" />
									<span class="style1">*</span>
							</p>
                       <?php } ?>
					<p class="term">								
							<input name ="termo"  type="hidden" value="<?php echo $termo?>" />
							<input name ="op_Exc_Edit"  type="hidden" value="<?php echo $op_Exc_Edit?>" />
							
					</p>
				</form>	
			</div>  
			<div id="blRodape">  	

				<h1>Utilidade pública federal<text-align=center/h1>
			</div>  
		</div>
		
	</body>
</html>