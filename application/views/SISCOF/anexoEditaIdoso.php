<html>
	
	<body >
		<?php 
            $nomeI= $_POST["nomeI"];			
            $data_Nasc= $_POST["data_Nasc"];			
            $data_entrada= $_POST["data_entrada"];			
            $cpf_I= $_POST["cpf_I"];
            $rg_I = $_POST["rg_I"];		
            $status= $_POST["status"];		
            $sexo= $_POST["sexo"];
           if($sexo == "M") $sex = "Masculino";
           if($sexo == "F") $sex = "Feminino";
         ?>
         <p class="tabela"><!--Campo fica em oculto apenas para guardar o valor "funcionario"-->
                        <input name ="cad"  type="hidden" value="idosos" />
                </p>
                <p class="opcao"><!--Campo fica em oculto apenas para guardar o valor "funcionario"-->
                        <input name ="op"  type="hidden" value="opCad" />
                </p>							
            <div id="blAux5">
                <p class="nomeI">
                    <label for="nomeI">Nome do idoso</label>
                    <input name ="nomeI" id="nomeI" type="text" value="<?php echo $nomeI ?>" />
                </p>
                <p class="data_Nasc">
                    <label for="data_Nasc">Data Nascimento</label>
                    <input  name="data_Nasc" id="data_Nasc" type="DATE" value="<?php echo $data_Nasc ?>" />
                </p>
                <p class="cpf_I">
                    <label for="cpf_I">CPF</label>
                    <input name ="cpf_I" type="text" value="<?php echo $cpf_I?>" />
                </p>	
                <p class="rg_I">
                    <label for="rg_I">RG</label>
                    <input name ="rg_I"type="text" value="<?php echo $rg_I?>" />
                </p>	

            </div>
            <div id="blAux6"> 
                <p class="data_entrada">
                        <label for="data_entrada">Data de Entrada no ILPI</label>
                      <td>
                        <input type="DATE" id="data_entrada" name="data_entrada" value="<?php echo $data_entrada?>" />
                    <font color=red><span class="style1"> * </span></font>
                </p>
                <p class="status">
                    <label for="status">status</label>
                    <td><select id="status" name="status">
                    <option value="<?php echo $status?>"><?php echo $status?></option>
                    <option value="Ativo">Ativo</option>		
                    <option value="Inativo">Inativo</option>														
                      </select>
                    <font color=red><span class="style1"> * </span></font>
                </p>	
                <p class="sexo">
                    <label for="Genero">Sexo</label>
                    <td><select id="sexo" name="sexo">
                    <option value="<?php echo $sexo?>"><?php echo $sex ?></option>
                    <option value="M">Masculino</option>		
                    <option value="F">Feminino</option>														
                      </select>
                    <font color=red><span class="style1"> * </span></font>
                </p>
		</div>
						
	</body>
</html>