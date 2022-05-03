<html>
	
	<body >
		<div id="blAux5">
						
			<p class="name">
			<label for="name">Nome do funcionario <font color=red>*</font></label>
			<input name ="name" type="text" value="<?php echo $nomeF?>" />
			</p>
			<p class="fone">
			<label for="fone">Telefone <font color=red>*</font></label>
			<input name="foneF" type="text" value="<?php if(isset($foneF)) echo $foneF?>" />
			</p>
						
			<p class="cidade">
			<?php
				require_once 'conexao.class.php';
				$con = new Conexao();
				$con->connect(); $conex = $_SESSION['conex'];
            /*    $qN = mysqli_query($conex, 'SELECT * FROM cidade WHERE nome  =  '.$cidade.' LIMIT 1');  
                  while($Ncid = mysqli_fetch_assoc($qN)) { $idCid = $Ncid ['idC'];}
           /*       if (!$queryN  ) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
												<a href='menu1.php'>Voltar ao Menu</a></center>");
												exit;
								}
								if (mysqli_num_rows($queryN ) == 0 ) 
								{	echo "Nao foi encontrado nenhum registro de lançamento. Tente novamente!"; exit;
								}
                   */
				$query = mysqli_query($conex, "SELECT idC, nome, estado FROM cidade");
			?>
						
			<label for="cidade">Cidade <font color=red>*</font></label>
			<td><select id="cidade" name="cidade">
			<option value = "<?php echo $cidade ?>"><?php echo $cidade ?></option>
			<?php while($cid = mysqli_fetch_array($query)) {?>
			<option value = "<?php echo $cid ['idC']?>"><?php echo $cid ['nome']?></option>
			<?php } ?>
			</select>
			
			</td>
			</p>
			<p class="Bairro">
			<label for="bairro">Bairro <font color=red>*</font></label>
			 <td>
			<input id="bairro" name="bairro" value="<?php echo $bairro?>" 
			</p> 
			<p class="lograd">
			<label for="lograd">Logradouro <font color=red> *</font></label>
			<input name ="lograd" type="text" value="<?php if(isset($lograd)) echo $lograd?>" />
			</p>	
			<p class="numero">
			<label for="numero">Numero <font color=red> *</font></label>
			<input name ="numero"type="text" value="<?php echo $numero?>" />
			</p>	
			<p class="Funcao">
			<label for="funcao">Funcao <font color=red> *</font></label>
			<td><select id="funcao" name="funcao">
			<option><?php echo $funcao?></option>
			<option value="Assistente financeiro">Assistente financeiro</option>		
			<option value="Coordenador financeiro">Coordenador financeiro</option>
			<option value="Diretor(a) pedagógica">Diretor(a) pedagógica</option>		
			<option value="Presidente">Presidente</option>							
			</select>
			
			</p>					
			<p>					
			<label for="Genero">Sexo <font color=red>*</font></label>
			<td><input checked="checked" name="sexo" type="radio" value="M" />Masculino<br />
			<input name="sexo" type="radio" value="F" />Feminino 
			</p>
			</p><br /><br />
			<p class="tabela"><!--Campo fica em oculto apenas para gurdar o valor "congregacao"-->
			<input name ="cad"  type="hidden" value="funcionarios" />
			<input name ="op"  type="hidden" value="opCad" />
			</p>								  
			<label ><span class="style1">(<font color=red>*</font>)</span>Campos Obrigatórios </label>
			<br /><br /><br /><br /><br />
		</div >		
		<div id="blAux6">	
			<p class="user">
			<label for="user">Nome de usuário <font color=red>*</font></label>
			<input name ="user" type="text" placeholder="USUÁRIO" autofocus/>								
			</p>
			<p class="senha">
			<label for="senha">Senha de usuário <font color=red>*</font></label>
			<input name ="senha" type="password" placeholder="SENHA" >
			<label for="senhac">Repetir a Senha de usuário <font color=red>*</font></label>
			<input name ="senhac" type="password" placeholder="REPETIR SENHA" >
			<div id="pswd_info">
				<label h4>Criterios para criação de senha</h4>
				<ul>
				<li id="length" class="invalid">Pelo menos <strong>8 characters</strong></li>
				<li id="capital" class="invalid">Pelo menos <strong>1 letra</strong></li>
				<li id="number" class="invalid">Pelo menos <strong>1 número</strong></li>
				<li id="space" class="invalid">Possuir pelo menos um dos caracteres <strong>[~,!,@,#,$,%,^,&,*,-,=,.,;,']</strong></li>
				</ul></label>
			</div>
			</p>
							
			<td><center><label for="conta_acesso">CONTAS PARA ACESSO <font color=red>*</font></label>					
							<table width="50%">
							<tbody>
							<tr>
							<td><input type="radio" name="conta_acesso" value=1/> IEADALPE - 1444-3</td>
							<td><input type="radio" name="conta_acesso" value=4/> BR-214 - 22361-1</td>
							</tr><tr>
							<td><input type="radio" name="conta_acesso" value=2/> 22360-3</td>
							<td><input type="radio" name="conta_acesso" value=5/> BR-518 - 23613-6</td>
							</tr><tr>
							<td><input type="radio" name="conta_acesso" value=3/> ILPI</td>
							<td><input type="radio" name="conta_acesso" value=6/> BR-542 - 23615-2</td>
							</tr><tr>
							<td><input type="radio" name="conta_acesso" value=9/> CD-BB - 28965-5</td>
							<td><input type="radio" name="conta_acesso" value=7/> BR-849 - 23617-9</td>
							</tr><tr>
							<td><input type="radio" name="conta_acesso" value=10/> CD-CEF - 1948-4</td>
							<td><input type="radio" name="conta_acesso" value=8/> BR-579 - 1447-8</td>
							</tr><tr>
							<td><input type="radio" name="conta_acesso" value=0/> Nenhuma conta</td>
							<td><input type="radio" name="conta_acesso" value=99/> Todas as contas</td>
							</tr></tbody></table>
								<p>
								<label for="tipCont">Tipo de conta <font color=red>*</font></label>
								<table width="60%">
							<tbody>
							<tr>
							<td><input checked="checked" type="radio" name="tipo_conta_acesso" value=1/> Suporte</td>
							<td><input type="radio" name="tipo_conta_acesso" value=3/> Suporte e Corrente</td>
							</tr><tr>
							<td><input type="radio" name="tipo_conta_acesso" value=2/> Corrente</td>
							<td><input type="radio" name="tipo_conta_acesso" value=4/> Todas <font size= 2 color=green>(Suporte, corrente e pupança)</font></td>
								</tr></tbody></table>
								</p>
			<td><label for="nivel_acesso">NÍVEIS DE ACESSO<font color=red>*</font></label></center>						
			<input checked="checked" name="nivel_acesso" type="radio" value="1" /><strong>1 </strong>- Consulta de movimentação financeira<br />
			<input name="nivel_acesso" type="radio" value="2" /><strong>2 </strong> - Consulta simples  e Lançamento  de movimentação financeira;<br />
			<input name="nivel_acesso" type="radio" value="3" /><strong>3 </strong> - Consulta simples, Lançamento e Edição de movimentação financeira;<br />
			<input name="nivel_acesso" type="radio" value="4" /><strong>4 </strong> - Consulta simples, Lançamento, Edição e Exclusão de movimentação financeira; <br />
			<input name="nivel_acesso" type="radio" value="5" /><strong>5 </strong> - Consulta avançada, Lançamento, Edição e Exclusão de movimentação financeira, Cadastro de Cooperadores e Códigos Financeiros<br />
				 
			</td>	<br /><br />
								
			</p>								
										 
		</div>
						
	</body>
</html>