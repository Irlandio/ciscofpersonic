 <html> <head>
    <title>SISCOF</title>
    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/blue.css" class="skin-color" />
    <script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
 
  <body style="background-color: transparent">



      <div class="container-fluid">
           
    <?php
          
         function formatoRealPntVrg($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}([.]([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
     function formatoRealVrg($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}(([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
         function formatoRealPnt($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}(([0-9]{3}))*[.]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
    function formatoRealInt($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}(([0-9]{3}))*([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
         //else        
          unset($_SESSION['tipoPesquisa']);    
   if((null == ($lancamentos)))
   {
       echo "Não há lançamentos neste período!";
   }else
     {
       
        $tipo_Contas = 0;
        $dataInicial =  $_SESSION['dataInicial'] ;
       $datXX = $dataInicial;
    ?>       
          <div class="row-fluid">
          <?php    
            //   $adm =  "cod_assoc";
              $adm =  $_SESSION['admini'] ;
              $total =  0;
            if($adm == "cod_compassion" )
             {
                
               $dataInicial = $_SESSION['dataInicial'];
               $dataFinal  = $_SESSION['dataFinal'];
                $mes_num = $dataInicial;// Nome do mês
                $data_separada     = explode('-', $mes_num);
                $mes_num    = $data_separada[1];          
                
                $meses = array(
                    '01'=>'Janeiro',
                    '02'=>'Fevereiro',
                    '03'=>'Março',
                    '04'=>'Abril',
                    '05'=>'Maio',
                    '06'=>'Junho',
                    '07'=>'Julho',
                    '08'=>'Agosto',
                    '09'=>'Setembro',
                    '10'=>'Outubro',
                    '11'=>'Novembro',
                    '12'=>'Dezembro'
                );

               $mes_num = $meses[$mes_num];
                $pri_CC = 1;
                $pri_CS = 1;
                $pri_CP = 1;
                $ano  = $data_separada[0];  // Ano
                $mesN = $mes_num; 
                $tipo_Contas = 0;
                $t_Conta_Ant = 0;
                $tipo_Conta_Atual = 0;
                $totalE = 0; $totalS = 0;
            foreach ($lancamentos as $l)                                   
            {	
                    $conta   = $l->conta;
                    $cdiNome = "CDI NOVAS DE PAZ"; $cidadeNome = "sede"; $caixaNome = '0000'; 
                    $saldo_Mes     = $l->saldo_Mes;
              $html = '';
                    if($dataInicial <= $l->dataFin && $dataFinal >= $l->dataFin)
                   {
                       
                           
                    switch ($conta) 
					{						 
						case 1:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; $banco = 'Bradesco'; break;  
						case 2:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000';  $banco = 'Bradesco'; break;  
						case 3:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; $banco = 'Suporte'; break;  
						case 4:	$cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '0214'; $banco = 'Bradesco'; break;  
						case 5:	$cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  $caixaNome = '0518'; $banco = 'Bradesco'; break;  
						case 6:	$cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS"; $caixaNome = '0542'; $banco = 'Bradesco';  break;  
						case 7:	$cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  $caixaNome = '0549'; $banco = 'Bradesco'; break;  
						case 8:	$cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  $caixaNome = '0579'; $banco = 'Bradesco'; break; 	 
						case 9:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = '000'; $banco = 'do Brasil'; break; 	 
						case 10:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = '000'; $banco = 'CEF'; break; 		
					}	
					if( $l->tipo_Conta == "Corrente")
                        {if(  $pri_CC == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CC = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 1;	$abrev = "C/C:";
                        }else		
					if( $l->tipo_Conta == "Suporte")
                        {if(  $pri_CS == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CS = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 2;	$abrev = "C/S:";
                        }else			
					if( $l->tipo_Conta == "Poupança")
                        {if(  $pri_CP == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CP = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 3;	$abrev = "C/P:";
                        }
                    
					
                       { $admAr = "Admin"; $admDesc = "Admin Desc"; }
                    
                  
                    
					if($tipo_Contas == 0)
						{
                        $primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; $total = $saldo_Ant;
						}else	
                        if($tipo_Contas <> $tipo_Conta_Atual)
						{	$primeiroReg = "S";
							
                         $tipo_Conta_Ant = $tipo_Contas;
                            
                    switch ($tipo_Conta_Ant) 
					{						 
						case 1:	 $t_Conta_Ant = "Corrente"; break;  
						case 2:	 $t_Conta_Ant = "Suporte"; break;  
						case 3:	$t_Conta_Ant = "Poupança"; break;  
						case 4:	$t_Conta_Ant = "Investimento"; break;  		
					}	
                         $Pendente = 0.00; $lan = '';
                       //  $datXX= implode('-',array_reverse(explode('/',$datX)));
                            foreach ($res_Concilio as $rCheks)                                   
                            {	
                                if( $rCheks->data_Emissao <=  $datXX && $rCheks->tipo_Conta ==  $t_Conta_Ant )
                                    $Pendente = $Pendente + $rCheks->valorFin;
                                $lan = $lan.' ('.$rCheks->id_aenp.' | '.$rCheks->dataFin.' R$'.$rCheks->valorFin.' ) ';
                            }
                         $saldo_Reconc = $total + $Pendente;
                         
							$total =  number_format($total, 2, ',', '.');
						      $ent = number_format($totalE, 2, ',', '.');
                            $sai = number_format($totalS, 2, ',', '.');
                            $Pendent = number_format($Pendente, 2, ',', '.');
                            $saldo_Reconcil = number_format($saldo_Reconc, 2, ',', '.');
                         
                         	$tipo_Contas = $tipo_Conta_Atual;
							$html .=  '<td colspan="6"></td> <td colspan="2">Saldo Final R$ </td>';	
							$html .=  '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';
							$html .= '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="2">Conciliação Bancária R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
                            	
							echo '<td colspan="6"></td> <td colspan="2"> Saldo Final R$ </td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                         
							echo '<tr><td colspan="6"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
							echo '<tr><td colspan="6"></td> <td colspan="2">Saldo Bancária R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;  $totalE = 0; $totalS = 0;	
						}	
						if($primeiroReg == "S") 
						{
							
							$html .= '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							  if( $l->tipo_Conta == "Corrente")
                            {
                                $html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >'.$_SESSION['admini'].' CONTA CORRENTE - BANCO '.$banco.'
							         </th> <th align="center" >Folha Nº4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							$html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >CAIXA PEQUENO
							         </th> <th align="center" >Folha Nº5</th>  </tr>';							
							$html .=   '<tr><th colspan="3">Projeto</th> <th colspan="4" align="center"  align="center" >'.$cdiNome.'</th>';
							$html .=   '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Cidade</th> <th colspan="4" align="center"  align="center" >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Estado</th> <th colspan="4" align="center"  align="center" >PE</th>';
							$html .=   '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';
                            $html .=   '<tr><th colspan="9" bgcolor="yellow" style="font-size:70%">ATENÇÃO: Esta página está identica a planilha               Compassion. Copie apenas os campos em "amarelo".</th>';
                            $html .=    ' </tr>';
                            
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro" ><th width="30" rowspan="3"> Registro</th>';	
							$html .=   '<th width="30" rowspan="3">Data</th>';	
							$html .=   '<th width="30" rowspan="3">Conta</th>';	
							$html .=   '<th width="30" rowspan="3">Forma ou cheque</th>';	
							$html .=   '<th rowspan="3"> Área </th> <th rowspan="3"> Descrição </th>';	
							$html .=   '<th width="100" rowspan="3">Histórico</th>';	
							$html .=   '<th width="80" rowspan="3">Entrada(R$)</th>';	
							$html .=   '<th width="50" rowspan="3">Saída(R$)</th>';	
							$html .=   '<th width="50" rowspan="1">Saldo MÊS</th>';	
							$html .=   '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr> </tr><tr>';
							$html .=  '<td  colspan="10" ></td>  ';
							$html .=  '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=  '</tr>';		
                            
                            
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="100%">';
                            if( $l->tipo_Conta == "Corrente")
                            {
                                echo '<thead ><tr bgcolor="Gainsboro" ><th ROWSPAN="5"></th> <th colspan="9" > CONTA CORRENTE - BANCO '.$banco.'</th> <th align="center" >Folha No4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							     echo '<thead ><tr bgcolor="Gainsboro"><th ROWSPAN="5"></th> <th colspan="9" >CAIXA PEQUENO
							         </th> <th align="center" >Folha No5</th>  </tr>';							
							echo '<tr><th colspan="3">Projeto</th> <th colspan="4" align="center"  align="center" >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="3">Cidade</th> <th colspan="4" align="center"  align="center" >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="3">Estado</th> <th colspan="4" align="center"  align="center" >PE</th>';
							echo '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="10" bgcolor="yellow" style="font-size:70%">ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
							echo ' </tr>';		
							//echo '<tr><th rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
							echo ' </tr>';
                            
							//echo '<tr><th width="60" rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th></tr>';	
							echo '<tr rowspan="3" bgcolor="Gainsboro" style="font-size:70%" ><th  rowspan="3"> Registro</th>';	
							echo '<th rowspan="3">Data</th>';	
							echo '<th  rowspan="3">Conta</th>';	
							echo '<th  rowspan="3">Forma ou cheque</th>';	
							echo '<th  rowspan="3"> Área </th> <th rowspan="3">Descrição</th>';	
							echo '<th width="150" rowspan="3" colspan="2" > Histórico</th>';	
							echo '<th width="50" rowspan="3">Entrada(R$)</th>';	
							echo '<th width="50" rowspan="3">Saída(R$)</th>';	
							echo '<th width="50" rowspan="1">Saldo MÊS</th>';	
							echo '</tr> <tr><th> ',number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							echo '<tbody style="font-size:100%">';														
							echo '<tr>';
							echo '<td  colspan="10" ></td>  ';
							echo '<td bgcolor="yellow"  >',number_format($saldo_Ant, 2, ',', '.').'</td>';
                            echo '</tr>';							
													
					$primeiroReg = "N";
						}					
						if($l->ent_Sai == 0) {		$Sai = number_format($l->valorFin, 2, ',', '.'); $ent = "";	}
						else if($l->ent_Sai == 1){ 	$ent = number_format($l->valorFin, 2, ',', '.'); $Sai = "";}
							$val = $l->valorFin;
							if($l->ent_Sai == 0) {$total = $total - $val; $totalS += $val; }
							else {$total = $total + $val;  $totalE += $val;}
						  $datX= implode('/',array_reverse(explode('-',$l->dataFin)));
						  $datXX = $l->dataFin;
						
                    
                       
                        foreach ($res_CodComp as $rCodComp) 
                        { 
                            if($l->$adm == $rCodComp-> cod_Comp){ 
                                $admAr = $rCodComp-> area_Cod; 
                                $descricao = $rCodComp-> descricao; 
                        }}
                        
                        $ok = 0;
                        $bR = " ";
                        foreach ($presentes_pagos as $pPr) 
                    {	
                            if($pPr->id_saida == $l->id_fin){ $bR = " - ".$pPr->n_beneficiario; }
                        }
                       if($l->num_Doc_Fiscal == "RECIBO" || $l->num_Doc_Fiscal == "S/N") {$docFiscal = " ";} else $docFiscal = " - ".$l->num_Doc_Fiscal;
                        
                        $historico = $l->historico.$docFiscal.$bR;
                        
                        
                        
						$html .=  '<tr heigth="100" >';
						$html .=  '<td>' . $l->id_fin . '</td>';                      
						$html .=  '<td bgcolor="yellow">' . $datX . '</td>';                      
						$html .=  '<td bgcolor="yellow">' .$l->$adm. '</strong></td>';
						$html .=  '<td bgcolor="yellow">' .$l->num_Doc_Banco . '</td>';
                        $html .=  ' <td>'.$admAr.'</td> <td>'.$descricao.'</td>';
						$html .=  '<td bgcolor="yellow"  colspan="2" >' .$historico . '</td>';
						if($ent == 0) 
                            $html .=  '<td align="right">'.$ent.'</td>';
                        else 
                            $html .=  '<td bgcolor="yellow" align="right">'.$ent.'</td>';
						if($Sai == 0) 
                            $html .=  '<td align="right">'.$Sai.'</td>';
                        else 
                            $html .=  '<td bgcolor="yellow" align="right">'.$Sai.'</td>';
						$html .=  '<td align="right">'.number_format($total, 2, ',', '.').'</td>';
						$html .=  '</tr>';
                    
						echo '<tr>';
						echo '<td  > ' . $l->id_fin . ' </td>';                      
						echo '<td  heigth="100" bgcolor="yellow"  > ' . $datX . ' </td>';                      
						echo '<td  heigth="100" bgcolor="yellow"> ' .$l->$adm. '</strong> </td>';
						echo '<td  heigth="100" bgcolor="yellow"> ' .$l->num_Doc_Banco . ' </td>';
                        echo ' <td  heigth="100"> '.$admAr.' </td> <td> '.$descricao.' </td>';
                        
                        
						echo '<td  heigth="100" bgcolor="yellow"  colspan="2" > ' .$historico.' </td>';
                        if($ent == 0) 
                            echo '<td  heigth="100" align="right"> '.$ent.' </td>';
                        else 
                            echo '<td  heigth="100" bgcolor="yellow" align="right"> '.$ent.' </td>';
                        if($Sai == 0) 
                            echo '<td  heigth="100x" align="right"> '.$Sai.' </td>';
                        else 
                            echo '<td  heigth="100" bgcolor="yellow" align="right"> '.$Sai.' </td>';
						echo '<td  heigth="100" align="right"> '.number_format($total, 2, ',', '.').' </td>';
						echo '</tr>';
                }
                
				}
                            
							
                         $tipo_Conta_Ant = $tipo_Contas;
                            
                    switch ($tipo_Conta_Ant) 
					{						 
						case 1:	 $t_Conta_Ant = "Corrente"; break;  
						case 2:	 $t_Conta_Ant = "Suporte"; break;  
						case 3:	$t_Conta_Ant = "Poupança"; break;  
						case 4:	$t_Conta_Ant = "Investimento"; break;  		
					}	
                         $Pendente = 0.00; $lan = '';
                        // $datXX= implode('-',array_reverse(explode('/',$datX)));
                            foreach ($res_Concilio as $rCheks)                                   
                            {	
                                if( $rCheks->data_Emissao <=  $datXX && $rCheks->tipo_Conta ==  $t_Conta_Ant )
                                    $Pendente = $Pendente + $rCheks->valorFin;
                                $lan = $lan.' ('.$rCheks->id_aenp.' | '.$rCheks->dataFin.' R$'.$rCheks->valorFin.' ) ';
                            }
                         $saldo_Reconc = $total + $Pendente;
                         
							$total =  number_format($total, 2, ',', '.');
						    $ent = number_format($totalE, 2, ',', '.');
                            $sai = number_format($totalS, 2, ',', '.');
                            $Pendent = number_format($Pendente, 2, ',', '.');
                            $saldo_Reconcil = number_format($saldo_Reconc, 2, ',', '.');
                         
                         	$tipo_Contas = $tipo_Conta_Atual;
							$html .=  '<td colspan="6"></td> <td colspan="2">Saldo Final R$ </td>';	
							$html .=  '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';
							$html .= '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="2">Conciliação Bancária R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
                            	
							echo '<td colspan="6"></td> <td colspan="2"> Saldo Final R$ </td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                         
							echo '<tr><td colspan="6"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
							echo '<tr><td colspan="6"></td> <td colspan="2">Saldo Bancária R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;  $totalE = 0; $totalS = 0;	
                $html .=   '<br>';
                    echo '<br>';
                
                    $conta   = 5;
                foreach ($lancamentos as $l){  $conta   = $l->conta; }
          //PRESENTES PAGOS NO MÊS      >>>>>WHERE SUBSTRING(n_beneficiario,1,6) LIKE "'.$contN.'"  and valor_pendente < 1  
                                                 //   and data_presente >= "'.$data_x1.'" and data_presente <= "'.$data_x2.'"
                
                        switch ($conta) 
					{	
						case 1:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "1";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 2:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 3:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 4:	$contN = "BR0214"; $cidadde = "Abreu e Lima"; $cdi = "000";     $cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '0214'; break; 
						case 5:	$contN = "BR0518"; $cidadde = "Paulista";     $cdi = "2";     $cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  $caixaNome = '0518'; break;   
						case 6:	$contN = "BR0542"; $cidadde = "Bezerros";     $cdi = "3";     $cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS"; $caixaNome = '0542';  break;  
						case 7:	$contN = "BR0549"; $cidadde = "Catende";      $cdi = "4";     $cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  $caixaNome = '0549'; break;
						case 8:	$contN = "BR0579"; $cidadde = "Jurema";       $cdi = "5";     $cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  $caixaNome = '0579'; break;  
                        case 9:	$contN = "000"; $cidadde = "Abreu e Lima";       $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "JUREMA";  $caixaNome = '000'; break;  
                        case 10:	$contN = "000"; $cidadde = "Abreu e Lima";       $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "JUREMA";  $caixaNome = '000'; break;  
                        case 99:$contN = "Todas contas"; break;  				
					}
                       					 
                
              
            if (!$presentes_pagos ) 
                {	echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";
                }
                else
                { 
                    
							$html .=   '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							$html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="4"></th> <th colspan="7" >PAGAMENTOS DE PRESENTES ESPECIAIS
							         </th> <th align="center" >Folha Nº6-1</th>  </tr>';							
							$html .=   '<tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							$html .=   '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							$html .=   '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							$html .=   '<tr><th colspan="9" style="font-size:70%"></th>';
							$html .=   ' </tr>';								
							$html .=   ' </tr >';
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro"><th width="60" rowspan="2"> Registro</th>';	
							$html .=   '<th width="60" >DATA</th>';	
							$html .=   '<th width="50" >NÚMERO DA CRIANÇA</th>';	
							$html .=   '<th width="360">NOME DA CRIANÇA</th>';	
							$html .=   '<th width="130" >MÊS/ANO DA LISTAGEM</th>';	
							$html .=   '<th width="80" >NÚMERO DO PROTOCOLO</th>';	
							$html .=   '<th width="80">VALOR RECEBIDO (ENTRADAS)</th>';	
							$html .=   '<th width="80">VALOR PAGO (SAÍDAS)</th>';	
							$html .=   '<th width="80">SALDO</th></tr>';	
							$html .=   '</thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr>';
							$html .=   '<td  colspan="7" align="right">SALDO INICIAL DO MÊS > > > > ></td>  ';
							$html .=   '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=   '</tr>';		
                   
                    
							echo '<table  border=1 cellspacing=0 bgcolor="white">';
							echo '<thead ><tr bgcolor="Gainsboro"><th ROWSPAN="5"></th> <th colspan="7" >PAGAMENTOS DE PRESENTES ESPECIAIS
							         </th> <th align="center" >Folha Nº6-1</th>  </tr>';							
							echo '<tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							echo '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="8" style="font-size:70%"></th>';
							echo ' </tr>';
							echo '<tr rowspan="3" bgcolor="Gainsboro" style="font-size:70%"><th width="60" rowspan="3"> Registro</th>';	
							echo '<th width="60" >DATA</th>';	
							echo '<th width="50" >NÚMERO DA CRIANÇA</th>';	
							echo '<th width="360" >NOME DA CRIANÇA</th>';	
							echo '<th width="130">MÊS/ANO DA LISTAGEM</th>';	
							echo '<th width="80">NÚMERO DO PROTOCOLO</th>';	
							echo '<th width="80">VALOR RECEBIDO (ENTRADAS)</th>';	
							echo '<th width="80">VALOR PAGO (SAÍDAS)</th>';	
							echo '<th width="80" >SALDO</th></tr>';	
							echo '</thead>';
							echo '<tbody >';														
							echo '<tr>';
							echo '<td></td><td  colspan="7" align="right">SALDO INICIAL DO MÊS > > > > ></td>  ';
							echo '<td bgcolor="yellow"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            echo '</tr>';	
                    
                    
                            $id_Pres_Ant = 0;
                            $data_pres_Ant ='0';
                            $n_benef_Ant = '0';
                            $nome_benef_Ant = '0';
                            $mes_extenso_Ant = '0';
                            $anoE_Ant = '0';
                            $n_protoc_Ant = '0';
                            $valor_ent_Ant = '0.00';
                            $valor_sai_Ant = '0.00';

                    $total = 0;	$inicio = 1; $totalG = 0; $totalData = 0; $contaY = 0;
                   foreach ($presentes_pagos as $pP) 
                    {	
                       
                    if($dataInicial <= $pP->data_presente)
                        if((substr($pP->n_beneficiario,-11,6) == $contN ))
                    {
                          //$data_Ch= implode('/',array_reverse(explode('-',$pP->dataFin )));
                        $val_Ch= number_format($pP->valor_entrada , 2, ',', '.');
                        $valor_pendente= number_format($pP->valor_pendente , 2, ',', '.');
                        $mesPresente_Entrada =  $pP->dataFin;
                        $anoE =  date('Y', strtotime($mesPresente_Entrada));
                           $mes_extenso = array(
                            'Jan' => 'Janeiro', 'Feb' => 'Fevereiro', 'Mar' => 'Marco', 'Apr' => 'Abril', 
                            'May' => 'Maio', 'Jun' => 'Junho', 'Jul' => 'Julho', 'Aug' => 'Agosto', 
                            'Sep' => 'Setembro', 'Oct' => 'Outubro', 'Nov' => 'Novembro', 'Dec' => 'Dezembro'
                        );
                        $mesPresente_Entrada = date('M', strtotime($mesPresente_Entrada));

                        $mes_extenso = $mes_extenso[$mesPresente_Entrada] ;
                        if($pP->n_protocolo == $n_protoc_Ant || $inicio == 1)
                        {
                            $id_Pres_Ant = $pP->id_presente;
                            $data_pres_Ant =$pP->data_presente;
                            $n_benef_Ant = $pP->n_beneficiario;
                            $nome_benef_Ant = $pP->nome_beneficiario;
                            $mes_extenso_Ant = $mes_extenso;
                            $anoE_Ant = $anoE;
                            $n_protoc_Ant = $pP->n_protocolo;
                            $valor_ent_Ant = $pP->valor_entrada;
                            $valor_sai_Ant = $valor_sai_Ant + $pP->valor_saida;
                            
                              $inicio = 0;
                        }else
                            if($inicio == 0)
                            {
                                $s_Ant = $valor_ent_Ant - $valor_sai_Ant;
                                if($s_Ant == '0.00') $core = "blue"; else  if($s_Ant >= '-1.00' && $s_Ant <= '1.00') $core = "yellow";
                                else  $core = "red";
                            if($valor_sai_Ant == 0) $cor = "#F7F8E0"; else $cor = "yellow";
                                $html .=    '<tr  bgcolor=   '.$cor.'>';
                                $html .=    ' <td bgcolor="white">'.$id_Pres_Ant.'</td> 
                                <td><strong>'.$data_pres_Ant .'</td>';
                                $html .=    '<td align="right">'.$n_benef_Ant .'</td> <td>'.$nome_benef_Ant .'</td>';
                                $html .=    '<td align="right">'.$mes_extenso_Ant.' -- '.$anoE_Ant.'</td>';
                                $html .=    '<td align="right">'.$n_protoc_Ant.'</td>';
                                $html .=    '<td align="right">'.number_format($valor_ent_Ant, 2, ',', '.') .'</td> 
                                <td align="right">'.number_format($valor_sai_Ant, 2, ',', '.') .'</td> <td bgcolor="white"></td> </tr>';

                                echo '<tr  bgcolor='.$cor.'>';
                                echo ' <td bgcolor="white">'.$id_Pres_Ant.'</td> 
                                <td><strong>'.$data_pres_Ant.'</td>';
                                echo '<td align="right">'.$n_benef_Ant.'</td> <td>'.$nome_benef_Ant.'</td>';
                                echo '<td align="right">'.$mes_extenso_Ant.' -'.$anoE_Ant.'</td>';
                                echo '<td align="right">'.$n_protoc_Ant.'</td>';
                                echo '<td align="right">'.number_format($valor_ent_Ant, 2, ',', '.').'</td> 
                                <td align="right">'.number_format($valor_sai_Ant, 2, ',', '.').'</td> 
                                <td bgcolor="white"  valign=bottom style="text-align: right; color: '.$core.'">R$ '.number_format($s_Ant, 2, ',', '.').'</td></tr>';
                                $valor_sai_Ant = '0.00';
                                
                            $id_Pres_Ant = $pP->id_presente;
                            $data_pres_Ant =$pP->data_presente;
                            $n_benef_Ant = $pP->n_beneficiario;
                            $nome_benef_Ant = $pP->nome_beneficiario;
                            $mes_extenso_Ant = $mes_extenso;
                            $anoE_Ant = $anoE;
                            $n_protoc_Ant = $pP->n_protocolo;
                            $valor_ent_Ant = $pP->valor_entrada;
                            $valor_sai_Ant = $valor_sai_Ant + $pP->valor_saida;
                            
                              $inicio = 0;
                            }
                              
                            
                    } 	
                   //    echo $pP->n_beneficiario.'  '.$contN.'  - ';
                   }
                   $html .=    '<tr><td colspan="9"></td> </tr>';
                            
                    
                    $html .=   '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                    echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante

                }
                 $html .=   '<br>';
                    echo '<br>';
                
                    $_SESSION['html'] = $html;
                
              if(isset($_POST["excel"]))
              {
                session_start();
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <head>
                    <meta charset="utf-8">
                    <title>Contato</title>
                </head>
                <body>
                    <?php
                    // Definimos o nome do arquivo que será exportado
                    $arquivo = 'relatorio_Compassion.xls';
                    // Configurações header para forçar o download
                    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                    header ("Cache-Control: no-cache, must-revalidate");
                    header ("Pragma: no-cache");
                    header ("Content-type: application/x-msexcel");
                    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
                    header ("Content-Description: PHP Generated Data" );
                    // Envia o conteúdo do arquivo
                    echo $_SESSION['html'];
                    exit; ?>
                </body>
              </html>
            <?php 
              }
                } 
            else if($adm == "cod_assoc" && 1==1)
             {
                $tipo_Contas = 0;
               $dataInicial = $_SESSION['dataInicial'];
               $dataFinal  = $_SESSION['dataFinal'];
                
                $ano =  date('Y',strtotime($dataInicial));
                $pri_CC = 1;
                $pri_CS = 1;
                $pri_CP = 1;
                $mes_num = $dataInicial;// Nome do mês
                $data_separada     = explode('-', $mes_num);
                $mes_num    = $data_separada[1];          
               $mesN = $mes_num;
                $tipo_Contas = 0;
                $totalE = 0; $totalS = 0;
                $html = ''; 
				foreach ($lancamentos as $l)                                   
				{	// echo 'CONTA '.$l->conta;
               
                    
                    $conta   = " ";
                    $contaA   = $_SESSION['contA'];
                    if($contaA == 0)
                    $conta   = $l->conta." - ";
                    
                    $cdiNome = "CDI NOVAS DE PAZ"; $cidadeNome = "sede"; $caixaNome = '0000'; 
                    $saldo_Mes     = $l->saldo_Mes;
               // echo    $l->valorFin;
                    if($dataInicial <= $l->dataFin && $dataFinal >= $l->dataFin)
                   {
                       
            //  $conta   = $l->conta; 
                    
					if( $l->tipo_Conta == "Corrente")
                        {if(  $pri_CC == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CC = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 1;	$abrev = "C/C:";
                        }else		
					if( $l->tipo_Conta == "Suporte")
                        {if(  $pri_CS == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CS = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 2;	$abrev = "C/S:";
                        }else			
					if( $l->tipo_Conta == "Poupança")
                        {if(  $pri_CP == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CP = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 3;	$abrev = "C/P:";
                        }else			
					if( $l->tipo_Conta == "Investimento")
                        {if(  $pri_CP == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CP = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 4;	$abrev = "C/I:";
                        }
                    
					
                       { $admAr = "Admin"; $admDesc = "Admin Desc"; }
                    
                  
              
					if($tipo_Contas == 0)
						{
                        $primeiroReg = "S";	$tipo_Contas = $tipo_Conta_Atual; $total = $saldo_Ant;
						}else	
                        if($tipo_Contas <> $tipo_Conta_Atual)
						{	
                            $primeiroReg = "S";	
                             $tipo_Conta_Ant = $tipo_Contas;

                            switch ($tipo_Conta_Ant) 
                            {						 
                            case 1:	 $t_Conta_Ant = "Corrente"; break;  
                            case 2:	 $t_Conta_Ant = "Suporte"; break;  
                            case 3:	$t_Conta_Ant = "Poupança"; break;  
                            case 4:	$t_Conta_Ant = "Investimento"; break;  		
                        }	
                             $Pendente = 0.00; $lan = '';
                           //  $datXX= implode('-',array_reverse(explode('/',$datX)));
                                foreach ($res_Concilio as $rCheks)                                   
                                {	
                                    if( $rCheks->data_Emissao <=  $datXX && $rCheks->tipo_Conta ==  $t_Conta_Ant )
                                        $Pendente = $Pendente + $rCheks->valorFin;
                                    $lan = $lan.' ('.$rCheks->id_aenp.' | '.$rCheks->dataFin.' R$'.$rCheks->valorFin.' ) ';
                                }
                             $saldo_Reconc = $total + $Pendente;

                                $total =  number_format($total, 2, ',', '.');
                                $ent = number_format($totalE, 2, ',', '.');
                                $sai = number_format($totalS, 2, ',', '.');
                                $Pendent = number_format($Pendente, 2, ',', '.');
                                $saldo_Reconcil = number_format($saldo_Reconc, 2, ',', '.');

                                $tipo_Contas = $tipo_Conta_Atual;

							$html .=   '<td colspan="5"></td> <td colspan="2"> </td>';	
							$html .=   '<td><h5 align="right" valign=bottom style="color: green"> Receitas</strong></td>';	
							$html .=   '<td><strong align="right" valign=bottom style="text-align: left; color: blue">'.$ent.'</strong></td>';	
							$html .=   '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
                         
							$html .=   '<tr><td colspan="7"></td>';	
							$html .=   '<td><h5 align="right" valign=bottom style="color: green">Despesas</h5></td>';	
							$html .=   '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .=   '<td><h5 align="right" valign=bottom style="text-align: left; color: blue"></h5></td></tr>';
							$html .=   '<tr><td colspan="5"></td> <td colspan="2">Saldo Final R$ </td>';	
							$html .=   '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .=   '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .=   '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                                $html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                             $html .=   '<br>';
                            echo '<br>';
                                $html .=  "<div style='page-break-before:always;'> </div>";

							echo '<td colspan="5"></td> <td colspan="2"> </td>';	
							echo '<td><h5 align="right" valign=bottom style="color: green"> Receitas</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: blue">'.$ent.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
                         
							echo '<tr><td colspan="7"></td>';	
							echo '<td><h5 align="right" valign=bottom style="color: green">Despesas</h5></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h5 align="right" valign=bottom style="text-align: left; color: blue"></h5></td></tr>';
							echo '<tr><td colspan="5"></td> <td colspan="2">Saldo Final R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                                echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                ?>
              <table  cellspacing=0 bgcolor="white" width="100%">
                  <tbody><tr><th><td align="center">__________*******____________</td></tr> </tbody></table><br>
                
                <?php
                                echo "<div style='page-break-before:always;'> </div>";
                                $total = $saldo_Ant;  $totalE = 0; $totalS = 0;	

						}	
						if($primeiroReg == "S") 
						{
                                   
                    switch ($contaA) 
					{						 
						case 1:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = '1444-3';$banco = 'Bradesco'; break;  
						case 2:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = '22360-3';$banco = 'Bradesco'; break;  
						case 3:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = 'ILPI';$banco = 'Suporte'; break;  
						case 4:	$cdiNome = "CDI NOVAS DE PAZ I -BR-0214"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = '22361-1';$banco = 'Bradesco'; break;  
						case 5:	$cdiNome = "CDI NOVAS DE PAZ II -BR-0518"; $cidadeNome = "PAULISTA"; $agenc = '2080';  $caixaNome = '23613-6';$banco = 'Bradesco'; break;  
						case 6:	$cdiNome = "CDI NOVAS DE PAZ III -BR-0542"; $cidadeNome = "BEZERROS"; $agenc = '2080'; $caixaNome = '23615-2';$banco = 'Bradesco';  break;  
						case 7:	$cdiNome = "CDI NOVAS DE PAZ IV -BR-0549"; $cidadeNome = "CATENDE"; $agenc = '2080';  $caixaNome = '23617-9';$banco = 'Bradesco'; break;  
						case 8:	$cdiNome = "CDI NOVAS DE PAZ V -BR-0579"; $cidadeNome = "JUREMA"; $agenc = '2080';  $caixaNome = '1447-8';$banco = 'Bradesco'; break; 	 
						case 9:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '3503-3';  $caixaNome = 'BB-28965-5';$banco = 'do Brasil'; break; 	 
						case 10:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '3122';  $caixaNome = 'CEF-31948-4';$banco = 'CEF'; break;  
						case 0:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "TODAS CONTAS"; $agenc = '-';  $caixaNome = '-';$banco = '-'; break; 
					}	
							
							$html .= '<table   cellspacing=0 bgcolor="white" width="260">';
							  if( $l->tipo_Conta == "Corrente")
                            {
                                $html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >IEADALPE - CONTA CORRENTE - BANCO '.$banco.'
							         </th> <th align="center" >Folha Nº4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							$html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >IEADALPE - CAIXA PEQUENO
							         </th> <th align="center" >Folha Nº 5</th>  </tr>';							
							else 
                                if( $l->tipo_Conta == "Poupança")
							     $html .=   '<thead ><tr ><th ROWSPAN="5"></th> <th colspan="8" > IEADALPE - POUPANÇA
							         </th> <th >Folha No5</th>  </tr>';							
							else 
                                if( $l->tipo_Conta == "Investimento")
							     $html .=   '<thead ><tr ><th ROWSPAN="5"></th> <th colspan="8" > IEADALPE - INVESTIMENTO
							         </th> <th >Folha No5</th>  </tr>';							
							$html .=   '<tr><th colspan="3">Projeto</th> <th colspan="3" align="center"  align="center" > '.$cdiNome.'</th>';
							$html .=   '<th>Ag: '.$agenc.' - Conta:</th> <th colspan="2" align="center" > '.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Cidade</th> <th colspan="3" align="center"  align="center" >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th colspan="2" align="center" > ' .$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Estado</th> <th colspan="3" align="center"  align="center" >PE</th>';
							$html .=   '<th>Ano:</th> <th colspan="2" align="center" > ' .$ano.' </th> </tr>';
                            $html .=   '<tr><th colspan="9"  style="font-size:70%"></th>';
                            $html .=    ' </tr>';
                            
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro" ><th width="30" rowspan="2"> Registro</th>';	
							$html .=   '<th width="30" rowspan="3">Data</th>';	
							$html .=   '<th width="30" rowspan="3">Conta</th>';	
							$html .=   '<th width="30" rowspan="3">Forma ou cheque</th>';	
							//$html .=   '<th rowspan="3"> Área </th> <th rowspan="3"> Descrição </th>';	
							$html .=   '<th width="100" rowspan="3" colspan="3" >Histórico</th>';	
							$html .=   '<th width="80" rowspan="3">RE-1|S-0</th>';	
							$html .=   '<th width="50" rowspan="3">Valor(R$)</th>';	
							$html .=   '<th width="50" rowspan="1">Saldo MÊS</th>';	
							$html .=   '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr> </tr><tr>';
							$html .=  '<td  colspan="9" ></td>  ';
							$html .=  '<td bgcolor="white"  >'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=  '</tr>';		
							echo '<table  border=0 cellspacing=0 bgcolor="white" width="100%">';
                            if( $l->tipo_Conta == "Corrente")
                            {
                                echo '<thead bgcolor="white" ><tr  ><th ROWSPAN="5"></th> <th colspan="8" >IEADALPE - CONTA CORRENTE - BANCO '.$banco.'
							         </th> <th align="center" >Folha No4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							     echo '<thead ><tr ><th ROWSPAN="5"></th> <th colspan="8" > IEADALPE - CAIXA PEQUENO
							         </th> <th >Folha No5</th>  </tr>';							
							else 
                                if( $l->tipo_Conta == "Poupança")
							     echo '<thead ><tr ><th ROWSPAN="5"></th> <th colspan="8" > IEADALPE - POUPANÇA
							         </th> <th >Folha No5</th>  </tr>';							
							else 
                                if( $l->tipo_Conta == "Investimento")
							     echo '<thead ><tr ><th ROWSPAN="5"></th> <th colspan="8" > IEADALPE - INVESTIMENTO
							         </th> <th >Folha No5</th>  </tr>';							
							echo '<tr><th colspan="3">Projeto: '.$cdiNome.'</th> <th colspan="3" >Ag: '.$agenc.' - Conta: '.$caixaNome.'</th>';
							echo '<th></th> <th colspan="2"> </th> </tr>';			
							echo '<tr><th colspan="3">Cidade:'.$cidadeNome.'</th> <th colspan="3" align="center"  align="center" >Estado: PE</th>';
							echo '<th></th> <th colspan="2"  ></th> </tr>';			
							echo '<tr><th colspan="3">Período: De '. $_SESSION['dataIniciale'].' à '.$_SESSION['dataFinale'].'</th> <th colspan="3"   align="center" ></th>';
							echo '<th>Ano: </th> <th colspan="2" > '.date("Y",strtotime($l->dataFin)).'</th> </tr>';			
							echo '<tr><th colspan="9" bgcolor="white" style="font-size:70%"> </th>';
							echo ' </tr>';		
							//echo '<tr><th rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
							echo ' </tr>';
                            
							//echo '<tr><th width="60" rowspan="8" bgcolor="Gainsboro" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th></tr>';	
							echo '<tr rowspan="3"  border=1 cellspacing=0 cellpadding=2 bgcolor="white" style="font-size:70%" ><th  rowspan="2"> Registro</th>';	
							echo '<th rowspan="3">Data</th>';	
							echo '<th  rowspan="3">Conta</th>';	
							echo '<th  rowspan="3">Documento</th>';	
						//	echo '<th  rowspan="3"> Área </th> <th rowspan="3">Histórico</th>';	
							echo '<th width="150" rowspan="3" colspan="3" > Histórico</th>';	
							echo '<th width="50" rowspan="3">Receita-1 &#013 Despesa-0</th>';	
							echo '<th width="50" rowspan="3">Valor(R$)</th>';	
							echo '<th width="50" rowspan="1">Saldo MÊS</th>';	
							echo '</tr> <tr><th> ',number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							echo '<tbody style="font-size:100%">';														
							echo '<tr  bgcolor="#121212" >';
							echo '<td  colspan="9" ></td>  ';
							echo '<td ></td>';
                            echo '</tr>';							
													
					$primeiroReg = "N";
						}
                        
                        if(formatoRealInt($l->valorFin) == true)//Verific se o numero digitado é inteiro sem ponto nem virgula
                           { $valorFinExibe  =    number_format(str_replace(",",".",$l->valorFin), 2, ',', '.');  
                           }else if(formatoRealPnt($l->valorFin) == true)
                           {    $valorFinExibe  =    number_format(str_replace(",",".",$l->valorFin), 2, ',', '.');  }
                        
                        
                        $core = "black";	
						if($l->ent_Sai == 0) {$core = "red";	$Sai = $valorFinExibe; $ent = "";	}
						else if($l->ent_Sai == 1){$core = "blue";	 	$ent = $valorFinExibe; $Sai = "";}
							$val = $l->valorFin;
							if($l->ent_Sai == 0) {$total = $total - $val; $totalS += $val; }
							else {$total = $total + $val;  $totalE += $val;}
                        
								$datX= implode('/',array_reverse(explode('-',$l->dataFin)));
						$datXX = $l->dataFin;
						
                    
                        $ok = 0;
                        $bR = " ";
                        foreach ($presentes_pagos as $pPr) 
                    {	
                            if($pPr->id_saida == $l->id_fin){ $bR = " - ".$pPr->n_beneficiario; }
                        }
                       if($l->num_Doc_Fiscal == "RECIBO" || $l->num_Doc_Fiscal == "S/N") {$docFiscal = " ";} else $docFiscal = " - ".$l->num_Doc_Fiscal;
                        
                        
                        $historico = $l->historico.$docFiscal.$bR;
                    
						$html .=  '<tr  bgcolor="white"  heigth="100" >';
						$html .=  '<td>' . $l->id_fin . '</td>';                      
						$html .=  '<td >' . $datX . '</td>';                      
						$html .=  '<td >'.$conta.$l->$adm. '</strong></td>';
						$html .=  '<td >' .$l->num_Doc_Banco . '</td>';
                     //   $html .=  ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
						$html .=  '<td   colspan="3" >' .$l->historico . '</td>';
                        
						$html .=  '<td  heigth="100"  colspan="3" > ' .$historico.' </td>';
                        
                        $html .=  '<td  heigth="100" align="right"> '.$l->ent_Sai.' </td>';                        
                        
                        $html .=  '<td  heigth="100x" align="right"><font color = '.$core.' > '.$ent.$Sai.' </font ></td>';
                        /*
						if($ent == 0) 
                            $html .=  '<td align="right">'.$ent.'</td>';
                        else 
                            $html .=  '<td  align="right">'.$ent.'</td>';
                        
						if($Sai == 0) 
                            $html .=  '<td align="right">'.$Sai.'</td>';
                        else 
                            $html .=  '<td  align="right">'.$Sai.'</td>';
                        */
						$html .=  '<td align="right">'.number_format($total, 2, ',', '.').'</td>';
						$html .=  '</tr>';
                    
						echo '<tr  bgcolor="white"  heigth="100" >';
						echo '<td  > ' . $l->id_fin . ' </td>';                      
						echo '<td  heigth="100"   > ' . $datX . ' </td>';                      
						echo '<td  heigth="100" > '.$conta.$l->$adm. '</strong> </td>';
						echo '<td  heigth="100" > ' .$l->num_Doc_Banco . ' </td>';
                      //  echo ' <td  heigth="100"> '.$admAr.' </td> <td> '.$admDesc.' </td>';
                        
                        
                        
						echo '<td  heigth="100"  colspan="3" > ' .$historico.' </td>';
                        
                        echo '<td  heigth="100" align="right"> '.$l->ent_Sai.' </td>';
                        
                        
                        echo '<td  heigth="100x" align="right"><font color = '.$core.' > '.$ent.$Sai.' </font ></td>';
                        /*
                        if($ent == 0) 
                            echo '<td  heigth="100" align="right"> '.$l->ent_Sai.' </td>';
                        else 
                            echo '<td  heigth="100"  align="right"> '.$ent.' </td>';
                        
                        if($Sai == 0) 
                            echo '<td  heigth="100x" align="right"> '.$Sai.' </td>';
                        else 
                            echo '<td  heigth="100"  align="right"> '.$Sai.' </td>';
                        */
						echo '<td  heigth="100" align="right"> '.number_format($total, 2, ',', '.').' </td>';
						echo '</tr>';
                }
                
				}
                            
							
                         $tipo_Conta_Ant = $tipo_Contas;
                            
                    switch ($tipo_Conta_Ant) 
					{						 
						case 1:	 $t_Conta_Ant = "Corrente"; break;  
						case 2:	 $t_Conta_Ant = "Suporte"; break;  
						case 3:	$t_Conta_Ant = "Poupança"; break;  
						case 4:	$t_Conta_Ant = "Investimento"; break;  		
					}	
                         $Pendente = 0.00; $lan = '';
                       //  $datXX= implode('-',array_reverse(explode('/',$datX)));
                            foreach ($res_Concilio as $rCheks)                                   
                            {	
                                if( $rCheks->data_Emissao <=  $datXX && $rCheks->tipo_Conta ==  $t_Conta_Ant )
                                    $Pendente = $Pendente + $rCheks->valorFin;
                                $lan = $lan.' ('.$rCheks->id_aenp.' | '.$rCheks->dataFin.' R$'.$rCheks->valorFin.' ) ';
                            }
                         $saldo_Reconc = $total + $Pendente;
                         
							$total =  number_format($total, 2, ',', '.');
						      $ent = number_format($totalE, 2, ',', '.');
                            $sai = number_format($totalS, 2, ',', '.');
                            $Pendent = number_format($Pendente, 2, ',', '.');
                            $saldo_Reconcil = number_format($saldo_Reconc, 2, ',', '.');
                         
                         	$tipo_Contas = $tipo_Conta_Atual;
                
							$html .=   '<td colspan="5"></td> <td colspan="2"> </td>';	
							$html .=   '<td><h5 align="right" valign=bottom style="color: green"> Receitas</strong></td>';	
							$html .=   '<td><strong align="right" valign=bottom style="text-align: left; color: blue">'.$ent.'</strong></td>';	
							$html .=   '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
                         
							$html .=   '<tr><td colspan="7"></td>';	
							$html .=   '<td><h5 align="right" valign=bottom style="color: green">Despesas</h5></td>';	
							$html .=   '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .=   '<td><h5 align="right" valign=bottom style="text-align: left; color: blue"></h5></td></tr>';
							$html .=   '<tr><td colspan="5"></td> <td colspan="2">Saldo Final R$ </td>';	
							$html .=   '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .=   '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .=   '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                                $html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                             $html .=   '<br>';
                            echo '<br>';
                                $html .=  "<div style='page-break-before:always;'> </div>";

							echo '<td colspan="5"></td> <td colspan="2"> </td>';	
							echo '<td><h5 align="right" valign=bottom style="color: green"> Receitas</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: blue">'.$ent.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue"></h4></td></tr>';
                         
							echo '<tr><td colspan="7"></td>';	
							echo '<td><h5 align="right" valign=bottom style="color: green">Despesas</h5></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h5 align="right" valign=bottom style="text-align: left; color: blue"></h5></td></tr>';
							echo '<tr><td colspan="5"></td> <td colspan="2">Saldo Final R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                ?>
              <table><tbody><tr><th><td>__________*******____________</td></tr> </tbody></table><br>
                
                <?php
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;  $totalE = 0; $totalS = 0;	
                
                $html .=   '<br>';
                    echo '<br>';
                
                 $html .=   '<br>';
                    echo '<br>';
                
                
                    $_SESSION['html'] = $html;
                
            
                } 
            else if($adm == "cod_contab" && 1==1)
                {
                $tipo_Contas = 0;
               $dataInicial = $_SESSION['dataInicial'];
               $dataFinal  = $_SESSION['dataFinal'];
                
                $ano =  date('Y',strtotime($dataInicial));
                $pri_CC = 1;
                $pri_CS = 1;
                $pri_CP = 1;
                $mes_num = $dataInicial;// Nome do mês
                $data_separada     = explode('-', $mes_num);
                $mes_num    = $data_separada[1];          
                $mesN = $mes_num;
                $tipo_Contas = 0;
                $totalE = 0; $totalS = 0;
                $html = '';  $docsAnt = " ";               
                
                	
                echo '<table  border=0 cellspacing=0 bgcolor="white" width="100%">';

                {
                    echo '<thead bgcolor="white" >';

                } ?>
                <thead>	                            
                <tr rowspan="3"  border=1 cellspacing=0 cellpadding=2 bgcolor="white" style="font-size:70%" >
                <th rowspan="3"> Data</th>	
                <th rowspan="3"> Cód. Conta Débito</th>	
                <th rowspan="3"> Cód. Conta Credito</th>	
                <th rowspan="3">  Valor</th>	
                <th rowspan="3">  Cód. Histórico</th>	
                <th rowspan="3">  Complemento Histórico</th>	
                <th width="150" rowspan="3"   > Inicia Lote</th>	
                <th width="50"  rowspan="3"> Código Matriz/Filial</th>	
                <th width="50"  rowspan="3"> Centro de Custo Débito</th>	
                <th width="50"  rowspan="3"> Centro de Custo Crédito</th>
                </tr>	
                </thead>
                <tbody style="font-size:100%">														
               
                
                <?php
                /*
                echo '<tr rowspan="3"  border=1 cellspacing=0 cellpadding=2 bgcolor="white" style="font-size:70%" >
                      <th  rowspan="3"> Cód. Conta Credito</th>';	
                echo '<th rowspan="3">  Valor</th>';	
                echo '<th rowspan="3">  Cód. Histórico</th>';	
                echo '<th rowspan="3">  Complemento Histórico</th>';	
                echo '<th width="150" rowspan="3"  colspan="3" > Inicia Lote</th>';	
                echo '<th width="50"  rowspan="3"> Código Matriz/Filial</th>';	
                echo '<th width="50"  rowspan="3"> Centro de Custo Débito</th>';	
                echo '<th width="50"  rowspan="3"> Centro de Custo Crédito</th></tr>';	
                echo '</thead>';
                echo '<tbody style="font-size:100%">';														
                echo '<tr  bgcolor="#121212" >';
                echo '<td  colspan="10" ></td>  ';
                echo '<td ></td>';
                echo '</tr>';
                */
                $id = array("0");
                $primeiroReg = "S";
				foreach ($lancamentos as $l)  
                {
                  $verificado = 0;
                  foreach ($id as $lanc) {
                      if($lanc == $l->id_fin) $verificado = 1;
                  }
                 if($verificado == 0)   //Se o laç. for combinado com outro ja exibido
				{	
                    
                    $conta   = " ";
                    $contaA   = $_SESSION['contA'];
                    if($contaA == 0)
                    $conta   = $l->contabCCusto;
                    
                    $cdiNome = "CDI NOVAS DE PAZ"; $cidadeNome = "sede"; $caixaNome = '0000'; 
                    $saldo_Mes     = $l->saldo_Mes;
               // echo    $l->valorFin;
                    if($dataInicial <= $l->dataFin && $dataFinal >= $l->dataFin)
                   {
                    $docs = $l->num_Doc_Banco;
            //  $conta   = $l->conta; 
                    
					if( $l->tipo_Conta == "Corrente")
                        {if(  $pri_CC == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CC = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 1;	$abrev = "C/C:";
                        }else		
					if( $l->tipo_Conta == "Suporte")
                        {if(  $pri_CS == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CS = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 2;	$abrev = "C/S:";
                        }else			
					if( $l->tipo_Conta == "Poupança")
                        {if(  $pri_CP == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CP = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 3;	$abrev = "C/P:";
                        }else			
					if( $l->tipo_Conta == "Investimento")
                        {if(  $pri_CP == 1)
                            {
                               if($l->ent_Sai == 0 ) $sal_do = $l->saldo + $l->valorFin;
                                 else if($l->ent_Sai == 1 ) $sal_do = $l->saldo - $l->valorFin;
                                {$saldo_Ant = 	$sal_do;  $pri_CP = 0;
                                }
                            }//$saldo_Ant->saldo;	
                          $tipo_Conta_Atual = 4;	$abrev = "C/I:";
                        }                    
					
                       { $admAr = "Admin"; $admDesc = "Admin Desc"; }
						/*	
						if($primeiroReg == "S") 
						{
                                   
                            switch ($contaA) 
                            {						 
                                case 1:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = '1444-3';$banco = 'Bradesco'; break;  
                                case 2:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = '22360-3';$banco = 'Bradesco'; break;  
                                case 3:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = 'ILPI';$banco = 'Suporte'; break;  
                                case 4:	$cdiNome = "CDI NOVAS DE PAZ I -BR-0214"; $cidadeNome = "ABREU E LIMA"; $agenc = '2080'; $caixaNome = '22361-1';$banco = 'Bradesco'; break;  
                                case 5:	$cdiNome = "CDI NOVAS DE PAZ II -BR-0518"; $cidadeNome = "PAULISTA"; $agenc = '2080';  $caixaNome = '23613-6';$banco = 'Bradesco'; break;  
                                case 6:	$cdiNome = "CDI NOVAS DE PAZ III -BR-0542"; $cidadeNome = "BEZERROS"; $agenc = '2080'; $caixaNome = '23615-2';$banco = 'Bradesco';  break;  
                                case 7:	$cdiNome = "CDI NOVAS DE PAZ IV -BR-0549"; $cidadeNome = "CATENDE"; $agenc = '2080';  $caixaNome = '23617-9';$banco = 'Bradesco'; break;  
                                case 8:	$cdiNome = "CDI NOVAS DE PAZ V -BR-0579"; $cidadeNome = "JUREMA"; $agenc = '2080';  $caixaNome = '1447-8';$banco = 'Bradesco'; break; 	 
                                case 9:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '3503-3';  $caixaNome = 'BB-28965-5';$banco = 'do Brasil'; break; 	 
                                case 10:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $agenc = '3122';  $caixaNome = 'CEF-31948-4';$banco = 'CEF'; break;  
                                case 0:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "TODAS CONTAS"; $agenc = '-';  $caixaNome = '-';$banco = '-'; break; 
                            }	
							
							$html .= '<table   cellspacing=0 bgcolor="white" width="260">';
							  
                            {
                                $html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" > IEADALPE - CONTA CORRENTE - BANCO '.$banco.'
							    </th> 
                                <th align="center" >Folha Nº4</th>  </tr>';
                            }						
							$html .=   '<tr><th colspan="3">Projeto</th> <th colspan="3" align="center"  align="center" > '.$cdiNome.'</th>';
							$html .=   '<th>Ag: '.$agenc.' - Conta:</th> <th colspan="2" align="center" > '.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Cidade</th> <th colspan="3" align="center"  align="center" >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th colspan="2" align="center" > ' .$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Estado</th> <th colspan="3" align="center"  align="center" >PE</th>';
							$html .=   '<th>Ano:</th> <th colspan="2" align="center" > ' .$ano.' </th> </tr>';
                            $html .=   '<tr><th colspan="9"  style="font-size:70%"></th>';
                            $html .=    ' </tr>';
                            
							$html .=   '<tr rowspan="3" bgcolor="Gainsboro" ><th width="30" rowspan="2"> Registro</th>';	
							$html .=   '<th width="30" rowspan="3"> Data</th>';	
							$html .=   '<th width="30" rowspan="3"> Conta</th>';	
							$html .=   '<th width="30" rowspan="3"> Forma ou cheque</th>';	
							//$html .=   '<th rowspan="3"> Área </th> <th rowspan="3"> Descrição </th>';	
							$html .=   '<th width="100" rowspan="3" colspan="3" >Histórico</th>';	
							$html .=   '<th width="80" rowspan="3"> RE-1|S-0</th>';	
							$html .=   '<th width="50" rowspan="3"> Valor(R$)</th>';	
							$html .=   '<th width="50" rowspan="1"> Saldo MÊS</th>';	
							$html .=   '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr> </tr><tr>';
							$html .=  '<td  colspan="9"></td>  ';
							$html .=  '<td bgcolor="white">'.number_format($saldo_Ant, 2, ',', '.').'</td>';
                            $html .=  '</tr>';	
													
					$primeiroReg = "N";
						}
                       */ 
                        if(formatoRealInt($l->valorFin) == true)//Verific se o numero digitado é inteiro sem ponto nem virgula
                           { $valorFinExibe  =    number_format(str_replace(",",".",$l->valorFin), 2, ',', '.');  
                           }else if(formatoRealPnt($l->valorFin) == true)
                           {    $valorFinExibe  =    number_format(str_replace(",",".",$l->valorFin), 2, ',', '.');  }
                        
                        
                        $core = "black";	
						if($l->ent_Sai == 0) {$core = "red";	$Sai = $valorFinExibe; $ent = "";	}
						else if($l->ent_Sai == 1){$core = "blue";	 	$ent = $valorFinExibe; $Sai = "";}
							$val = $l->valorFin;
							if($l->ent_Sai == 0) {$total = $total - $val; $totalS += $val; }
							else {$total = $total + $val;  $totalE += $val;}
                        
								$datX= implode('/',array_reverse(explode('-',$l->dataFin)));
						$datXX = $l->dataFin;
						
                    
                        $ok = 0;
                        $bR = " ";
                        foreach ($presentes_pagos as $pPr) 
                        {	//SE FOR PRESENTE ESPECIAL BUSCA O BR DO BNEFICIÁRIO
                            if($pPr->id_saida == $l->id_fin){ $bR = " - ".$pPr->n_beneficiario; }
                        }
                       if($l->num_Doc_Fiscal == "RECIBO" || $l->num_Doc_Fiscal == "S/N") {$docFiscal = " ";} else                $docFiscal = " - ".$l->num_Doc_Fiscal;
                            $lot = "";
                        if($docsAnt != $docs ||($docs == "S/N" || $docs == "RECIBO") ) $lot = 1;
                        
                        $lot = 1; //Coloca todos em lote 1 ate verificar como selecionar
                        
                        
                        if($l->conta == $l->conta_Destino) $destino = $l->contabCCusto;
                        else{
                            foreach ($res_Caix as $cxD)
                               {
                                if($cxD->id_caixa == $l->conta_Destino) $destino = $cxD->contabCCusto;
                                }
                            }                        
                        $historico = $l->historico.$docFiscal.$bR;
                        
                        
                        $cont_Contabil_Deb = "";
                        $cont_Contabil_Cred = "";
                        $l2id_fin = "0";
        //Seleçao de CONTAS CONTÁBEIS
            //SE ILPI CONT CONTAB 6 caixa fundo fixo ILPI   
               if($conta == 11) {                  
                    if($l->ent_Sai == 1)  {$cont_Contabil_Deb = ""; $cont_Contabil_Cred = 6;} 
                    if($l->ent_Sai == 0)  {$cont_Contabil_Deb = 6; $cont_Contabil_Cred = "";}
               }   else     
            //SE transfer entre Cont Contab ( Caixa Geral Suport 5, Bancos Corrts 7, Investm e Poup 10)
             if(($l->cod_assoc == "T00-000" )   || ($l->cod_assoc == "T01-000" ) || 
                 ($l->cod_assoc == "T01" )      || ($l->cod_assoc == "T00" ))
                {  
                    $menos2 = date('Y-m-d', strtotime("-5 day", strtotime( $l->dataFin)));
                    $mais2  = date('Y-m-d', strtotime("+5 day", strtotime( $l->dataFin)));
                    $prim = 1;
                    $l2id_fin = "0";
                 

                  foreach ($lancamentos as $l2) 
                  {
                      //VERIFICAÇÃO DE LANÇAMENTOS COMBINADOS E/S
                     if((($l->cod_assoc == "T00-000"&& $l2->cod_assoc == "T00") ||
                        ($l->cod_assoc  == "T00"    && $l2->cod_assoc == "T00-000") ||
                        ($l->cod_assoc  == "T01-000"&& $l2->cod_assoc == "T01") ||
                        ($l->cod_assoc  == "T01"    && $l2->cod_assoc == "T01-000")) && 
                        ($l->valorFin   == $l2->valorFin ) && ($l->num_Doc_Banco == $l2->num_Doc_Banco ) && ($l2->dataFin > $menos2 && $l2->dataFin < $mais2 ))
                         {  
                            array_push($id, $l2->id_fin);
                            //Se for saída de mov ent contas
                            if($l->cod_assoc == "T00-000" || $l->cod_assoc == "T00" )  
                            {$cont_Contabil_Deb = $cont_Contabil_Cred = 7;}
                            //Se for saída de mov entre corr suporte e investimento
                            if($l->cod_assoc == "T01-000" ) 
                                { if($l->tipo_Conta == "Suporte" )
                                    {$cont_Contabil_Deb = 5; $cont_Contabil_Cred = 7;}
                                      if($l->tipo_Conta == "Corrente" )
                                      if($l2->tipo_Conta == "Poupança" || $l2->tipo_Conta == "Investimento" )
                                      {$cont_Contabil_Deb = 7; $cont_Contabil_Cred = 10; }
                                         else                                    
                                            {$cont_Contabil_Deb = 7; $cont_Contabil_Cred = 5;}
                                }
                            //Se for saída de mov entre corr suporte investimento
                            if( $l->cod_assoc == "T01") 
                              { if($l->tipo_Conta == "Suporte")
                                {$cont_Contabil_Deb = 7; $cont_Contabil_Cred = 5;}else
                                  if($l->tipo_Conta == "Corrente") 
                                      if($l2->tipo_Conta == "Poupança" || $l2->tipo_Conta == "Investimento" )
                                    {$cont_Contabil_Deb = 10; $cont_Contabil_Cred = 7;}
                                     else                                    
                                        {$cont_Contabil_Deb = 5; $cont_Contabil_Cred = 7;}
                              }
                            $l2id_fin = $l2->id_fin;
                         }
                  }
                }else
                     
                 //   $pattern = '/13º SALÁRIO/';//Padrão a ser encontrado na string $tags
                    if(preg_match('/13º SALÁRIO/', $historico))
                       {$cont_Contabil_Deb = 193; $cont_Contabil_Cred = "";} 
                    else  
                 {
                    foreach ($res_CodAssoc as $codAss)
                       {
                        if($codAss->cod_Ass == $l->cod_assoc) $cont_Contab = $codAss->cont_Contabil;
                        }
                        if($l->ent_Sai == 1) {$cont_Contabil_Deb = $cont_Contab; $cont_Contabil_Cred = "";} 
                        if($l->ent_Sai == 0) {$cont_Contabil_Deb = ""; $cont_Contabil_Cred = $cont_Contab;} 
                    }  
                 


						$html .= '<tr  bgcolor="white"  heigth="100" >';
						$html .=  '<td> '.date("d/m/Y",strtotime($l->dataFin)).' </td>';      
						$html .=  '<td> '.$cont_Contabil_Deb.' </td>';      
						$html .=  '<td> '.$cont_Contabil_Cred.' </td>';                           
						$html .= '<td >  heigth="100"   ' . $ent.$Sai . '</td>';                      
						$html .= '<td >  heigth="100"   '.$l->id_fin.'-'.$l2id_fin.'-'.$docs.'</strong> </td>';
						$html .= '<td >  heigth="100"   ' .$historico. '</td>';
						$html .= '<td    >' .$lot. '</td>';
                        
						$html .= '<td  heigth="100" align="right">  </td>';
                        $html .= '<td  heigth="100x" align="right"> '.$conta.' </td>';                        
                        
                        $html .= '<td  heigth="100x" align="right">'.$destino.' </td>';
						$html .= '</tr>';
                    
						echo '<tr bgcolor="white"  heigth="100" >';
						echo '<td> '.date("d/m/Y",strtotime($l->dataFin)).' </td>';      
						echo '<td> '.$cont_Contabil_Deb.' </td>';      
						echo '<td> '.$cont_Contabil_Cred.' </td>';                      
						echo '<td  heigth="100"   > '.$ent.$Sai.  ' </td>';                      
						echo '<td  heigth="100" > '.$l->id_fin.'-'.$l2id_fin.'-'.$docs.'</strong> </td>';
						echo '<td  heigth="100" > ' .$historico . ' </td>';
						echo '<td  heigth="100"   > '.$lot.' </td>';
                        
                        echo '<td  heigth="100" align="right">  </td>'; 
                        echo '<td  heigth="100x" align="right"> '.$conta.' </td>'; 
                        $corDif = "";
                    //    if($conta != $destino) $corDif = "bgcolor='red'";
                        echo '<td  heigth="100x" '.$corDif.' align="right">'.$destino.' </td>';
						echo '</tr>';
                    $docsAnt = $docs;
                }                
				}                           
                }
                ?>                
                <?php
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;  $totalE = 0; $totalS = 0;	
                
                $html .=   '<br>';
                    echo '<br>';
                
                 $html .=   '<br>';
                    echo '<br>';                
                
                    $_SESSION['html'] = $html;  
                }
            ?>
      </div>  
</div>


     </body>
</html>

    <?php
   }  if(isset($_POST["excel"]))
              {
                //session_start();
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <head>
                    <meta charset="utf-8">
                    <title>Relatório cont aenpaz</title>
                </head>
                <body>
                    <?php
                    // Definimos o nome do arquivo que será exportado
                    $arquivo = 'relatorio_Compassion.xls';
                    // Configurações header para forçar o download
                    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                    header ("Cache-Control: no-cache, must-revalidate");
                    header ("Pragma: no-cache");
                    header ("Content-type: application/x-msexcel");
                    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
                    header ("Content-Description: PHP Generated Data" );
                    // Envia o conteúdo do arquivo
                    echo $_SESSION['html'];
                    exit; ?>
                </body>
            </html>
            <?php 
              }
    ?>       





