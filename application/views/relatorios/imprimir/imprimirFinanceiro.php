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
         if(isset($_SESSION['adminSal'] )) $adminSal = $_SESSION['adminSal']; else $adminSal = "cod_compassion";
          unset($_SESSION['tipoPesquisa']);    
   if(!(isset($lancamentos)))
   {?>
       <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-list-alt"></i>
                    </span>
                    <h5>Relatório de Saldos </h5>
                </div>
                <div class="widget-content">
                    <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiroSaldos" method="post">
                    <div class="span12 well">
                         <div class="modal-footer" style="margin-left: 0; align: left">
                            
                            <input  name="adminSal"  type="hidden" value="<?php echo $adminSal ?>" />
                    
                            <input id="admini" name="admini"  type="hidden" value="saldos"/>
                    </div>
                    <div class="span3">
                        <p class="conta">                    
                        <label for="conta">Conta</label>
                          <select  style="width:170px;"  id="conta" name="conta">
                        <option value = "0"> Todas</option>
                         <?php
                            foreach ($arrContas as $rcx) 
                            {  
                              if(isset($_SESSION['contA'] ))
                                {
                                foreach ($arrContas as $rcxx)
                                {                                        
                                    if($_SESSION['contA'] == $rcxx->id_caixa) 
                                    {?>
                                   <option value = "<?php echo $rcxx->id_caixa ?>"><?php echo $rcxx->id_caixa." | ".$rcxx->nome_caixa ?></option>
                                   <?php 
                                }}
                                    unset($_SESSION['contA']) ;
                                }                                  
                                  {                                     
                                  ?>
                                    <option value = "<?php echo $rcx->id_caixa ?>"><?php echo $rcx->id_caixa." | ".$rcx->nome_caixa; ?></option>
                                        <?php
                                  }
                            }
                              ?>														
                              </select>
                            <font color=red><span class="style1"> * </span></font>	                    
                        </p>
                    </div>
                    
                    <div class="modal-footer">

                        <div class="span3" style="margin-left: 0; text-align: center">
                            <button class="btn btn-success span12"><i class="icon-list-alt"></i> Voltar ao Relatório de Saldos</button>
                        </div>
                    </div>  
                    </div>
                    </form>
                        &nbsp
                    </div>
            </div>
            <?php
   }else if(1==12){
       
                $tipo_Contas = 0;   
                    $date1 = "2018-01-01";
                    $date2 = "Y-m-d";
                    $ts1 = strtotime($date1);
                    $ts2 = strtotime($date2);
                    $year1 = date('Y', $ts1);
                    $year2 = date('Y', $ts2);
                    $month1 = date('m', $ts1);
                    $month2 = date('m', $ts2);
                    $qtdM = (($year2 - $year1) * 12) + ($month2 - $month1);
                ?>
                <h3><?php echo $qtdM; ?></h3>
                <?php
    //   var_dump($lancamentos);
       
   }else
     {
       $html = '';
       if(isset($_SESSION['dataInicial']))
        $dataInicial =  $_SESSION['dataInicial']; else $dataInicial = date("Y-01-01");
       if(isset($_SESSION['dataFinal']))
        $dataFinal =  $_SESSION['dataFinal']; else $dataFinal = date("Y-12-31");
       $datXX = $dataInicial;
    ?>       
          <div class="row-fluid">
          <?php    
            //   $adm =  "cod_assoc";
              $ano =  date('Y',strtotime($dataInicial));
              $adm =  $_SESSION['admini'] ;
              $total =  0;
            $tipo_Conta_Atual = 0;
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
						case 1:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break;  
						case 2:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break;  
						case 3:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break;  
						case 4:	$cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '0214'; break;  
						case 5:	$cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  $caixaNome = '0518'; break;  
						case 6:	$cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS"; $caixaNome = '0542';  break;  
						case 7:	$cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  $caixaNome = '0549'; break;  
						case 8:	$cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  $caixaNome = '0579'; break; 	 
						case 9:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = '000'; break; 	 
						case 10:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = '000'; break; 		
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
							$html .=  '<td colspan="6"></td> <td colspan="3">Saldo Final R$ </td>';	
							$html .=  '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';
							$html .= '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="3">Cheques pendentes R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="3">Conciliação Bancária R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
                            	
							echo '<td colspan="6"></td> <td colspan="3"> Saldo Final R$ </td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                         
							echo '<tr><td colspan="6"></td> <td colspan="3">Cheques pendentes R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							echo '<tr><td colspan="6"></td> <td colspan="3">Saldo Bancária R$ </td>';	
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
                                $html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >'.$_SESSION['admini'].' CONTA CORRENTE - BANCO
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
                            
                            
							$html .= '<table  border=1 cellspacing=0 bgcolor="white" width="100%">';
                            if( $l->tipo_Conta == "Corrente")
                            {
                                $html .= '<thead ><tr bgcolor="#110571"><th></th> <th colspan="10" style="text-align: center; color: #f6f6fa"> IV - CONTA CORRENTE - BANCO
							         </th> <th align="center" >Folha No4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							     echo '<thead ><tr bgcolor="#110571"><th ></th> <th colspan="10"  style="text-align: center; color: #f6f6fa"> V - CAIXA PEQUENO
							         </th> <th align="center" >Folha No5</th>  </tr>';							
							$html .= '<tr ><th  style="border:none; font-size: 22px; height:20px;" colspan="8"> </th></tr> 
                            <tr ><th ROWSPAN="4" style="border:none;"></th> 
                            <th style="border:none; text-align: left;"  colspan="3">Nome do Projeto:</th> <th  style="border:none" bgcolor="#dbdaf7"  colspan="4"  >'.$cdiNome.'</th>
                            <th style="border:none;"></th>
                            <th  colspan="2" style="border:none;; text-align: left;">Id do Parceiro:</th> <th align="center" bgcolor="#dbdaf7" style="border:none" >'.$caixaNome.' </th> </tr>';			
							$html .= '<tr  style="border:none" >
                            <th  style="border:none; text-align: left;"  colspan="3">Cidade:</th> <th  style="border:none"  colspan="4" align="center"  bgcolor="#dbdaf7" >'.$cidadeNome.'</th>
                            <th style="border:none;"></th>
                            <th  colspan="2" style="border:none; text-align: left;"  >Mês:</th> <th align="center" bgcolor="#dbdaf7" style="border:none">'.$mesN.' </th> </tr>';			
							$html .= '<tr  style="border:none" >
                            <th colspan="3"   style="border:none; text-align: left;">Estado:</th> 
                            <th style="border:none" colspan="4" bgcolor="#dbdaf7" align="center" >PE</th>
                            <th style="border:none;"></th>
                            <th  colspan="2" style="border:none; text-align: left;" >Ano:</th> <th style="border:none" align="center" bgcolor="#dbdaf7">'.$ano.' </th> </tr>
                            <tr ><th  style="border:none; font-size: 22px; height:20px;" colspan="7"> </th></tr> ';	
                            $html .= '<tr rowspan="3" bgcolor="#3a2da3" style="font-size:70%; text-align: center; color: #f6f6fa" ><th  rowspan="3"> Registro</th>';	
							$html .= '<th rowspan="3">Data</th>';	
							$html .= '<th  rowspan="3">Conta</th>';	
							$html .= '<th  rowspan="3">Forma ou cheque</th>';	
							$html .= '<th  rowspan="3"> Área </th> <th rowspan="3">Descrição</th>';	
							$html .= '<th width="150" rowspan="3" colspan="2" > Histórico</th>';	
							$html .= '<th width="20" rowspan="3"  > Despesa referente a</th>';	
							$html .= '<th width="50" rowspan="3">Receita(R$)</th>';	
							$html .= '<th width="50" rowspan="3">Despesa(R$)</th>';	
							$html .= '<th width="50" rowspan="2">Saldo MÊS</th>';	
							$html .= '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>'; 
							$html .=  '<tbody style="font-size:100%">';														
							$html .=  '<tr>';
							$html .=  '<td></td>  ';
                            $html .=  '</tr>';							
                            
                            
                            
							echo '<table  border=1 cellspacing=0 bgcolor="white" width="100%">';
                            if( $l->tipo_Conta == "Corrente")
                            {
                                echo '<thead ><tr bgcolor="#110571"><th></th> <th colspan="10" style="text-align: center; color: #f6f6fa"> IV - CONTA CORRENTE - BANCO
							         </th> <th align="center" >Folha No4</th>  </tr>';
                            }else 
                                if( $l->tipo_Conta == "Suporte")
							     echo '<thead ><tr bgcolor="#110571"><th ></th> <th colspan="10"  style="text-align: center; color: #f6f6fa"> V - CAIXA PEQUENO
							         </th> <th align="center" >Folha No5</th>  </tr>';							
							echo '<tr ><th  style="border:none; font-size: 22px; height:20px;" colspan="8"> </th></tr> 
                            <tr ><th ROWSPAN="4" style="border:none;"></th> 
                            <th style="border:none; text-align: left;"  colspan="3">Nome do Projeto:</th> <th  style="border:none" bgcolor="#dbdaf7"  colspan="4"  >'.$cdiNome.'</th>
                            <th style="border:none;"></th>
                            <th  colspan="2" style="border:none;; text-align: left;">Id do Parceiro:</th> <th align="center" bgcolor="#dbdaf7" style="border:none" >'.$caixaNome.' </th> </tr>';			
							echo '<tr  style="border:none" >
                            <th  style="border:none; text-align: left;"  colspan="3">Cidade:</th> <th  style="border:none"  colspan="4" align="center"  bgcolor="#dbdaf7" >'.$cidadeNome.'</th>
                            <th style="border:none;"></th>
                            <th  colspan="2" style="border:none; text-align: left;"  >Mês:</th> <th align="center" bgcolor="#dbdaf7" style="border:none">'.$mesN.' </th> </tr>';			
							echo '<tr  style="border:none" >
                            <th colspan="3"   style="border:none; text-align: left;">Estado:</th> 
                            <th style="border:none" colspan="4" bgcolor="#dbdaf7" align="center" >PE</th>
                            <th style="border:none;"></th>
                            <th  colspan="2" style="border:none; text-align: left;" >Ano:</th> <th style="border:none" align="center" bgcolor="#dbdaf7">'.$ano.' </th> </tr>
                            <tr ><th  style="border:none; font-size: 22px; height:20px;" colspan="7"> </th></tr> ';			
							//echo '<tr><th colspan="10" bgcolor="yellow" style="font-size:70%">ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
						//	echo ' </tr>';		
							//echo '<tr><th rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th>';
						//	echo ' </tr>';
                            
							//echo '<tr><th width="60" rowspan="8" bgcolor="yellow" >ATENÇÃO: Esta página está identica a planilha Compassion. Copie apenas os campos em "amarelo".</th></tr>';	
							echo '<tr rowspan="3" bgcolor="#3a2da3" style="font-size:70%; text-align: center; color: #f6f6fa" ><th  rowspan="3"> Registro</th>';	
							echo '<th rowspan="3">Data</th>';	
							echo '<th  rowspan="3">Conta</th>';	
							echo '<th  rowspan="3">Forma ou cheque</th>';	
							echo '<th  rowspan="3"> Área </th> <th rowspan="3">Descrição</th>';	
							echo '<th width="150" rowspan="3" colspan="2" > Histórico</th>';	
							echo '<th width="20" rowspan="3"  > Despesa referente a</th>';	
							echo '<th width="50" rowspan="3">Receita(R$)</th>';	
							echo '<th width="50" rowspan="3">Despesa(R$)</th>';	
							echo '<th width="50" rowspan="1">Saldo MÊS</th>';	
							echo '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							echo '<tbody style="font-size:100%">';														
							echo '<tr>';
							echo '<td  ></td>  ';
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
						
                    $descricao = "";
                       
                        foreach ($res_CodComp as $rCodComp) 
                        { 
                            if($l->$adm == $rCodComp-> cod_Comp){ 
                                $admAr = $rCodComp-> area_Cod; 
                                $descricao = $rCodComp-> descricao; 
                        }}
                        if(strlen($l->$adm ) < 8) $cor = "#fd737d"; else $cor = "#dbdaf7"; 
                        
						$html .=  '<tr heigth="100" >';
						$html .=  '<td>' . $l->id_fin . '</td>';                      
						$html .=  '<td bgcolor="#dbdaf7">' . $datX . '</td>';                      
						$html .=  '<td bgcolor="#'.$cor.'">' .$l->$adm. '</strong></td>';
						$html .=  '<td bgcolor="#dbdaf7">' .$l->num_Doc_Banco . '</td>';
                        $html .=  ' <td>'.$admAr.'</td> <td>'.$descricao.'</td>';
						$html .=  '<td bgcolor="#dbdaf7"  colspan="2" >' .$l->historico . '</td><td bgcolor="#dbdaf7" ></td>';
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
						echo '<td  heigth="100" bgcolor="#dbdaf7"  > ' . $datX . ' </td>';                      
						echo '<td  heigth="100" bgcolor="'.$cor.'"> ' .$l->$adm. '</strong> </td>';
						echo '<td  heigth="100" bgcolor="#dbdaf7"> ' .$l->num_Doc_Banco . ' </td>';
                        echo ' <td  heigth="100"> '.$admAr.' </td> <td> '.$descricao.' </td>';
                        
                        $ok = 0;
                        $bR = " ";
                        foreach ($presentes_pagos as $pPr) 
                    {	
                            if($pPr->id_saida == $l->id_fin){ $bR = " - ".$pPr->n_beneficiario; }
                        }
                       if($l->num_Doc_Fiscal == "RECIBO" || $l->num_Doc_Fiscal == "S/N") {$docFiscal = " ";} else $docFiscal = " - ".$l->num_Doc_Fiscal;
                        
                        $historico = $l->historico.$docFiscal.$bR;
                        
                        
                        
						echo '<td  heigth="100" bgcolor="#dbdaf7"  colspan="2" > ' .$historico.' </td><td bgcolor="#dbdaf7" ></td>';
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
							$html .=  '<td colspan="6"></td> <td colspan="3">Saldo Final R$ </td>';	
							$html .=  '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';
							$html .= '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="3">Cheques pendentes R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							$html .=  '<td colspan="6"></td> <td colspan="3">Conciliação Bancária R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
                            	
							echo '<td colspan="6"></td> <td colspan="3"> Saldo Final R$ </td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                         
							echo '<tr><td colspan="6"></td> <td colspan="3">Cheques pendentes R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							echo '<tr><td colspan="6"></td> <td colspan="3">Saldo Bancária R$ </td>';	
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
							$html .=   '<tr rowspan="2" bgcolor="Gainsboro"><th width="60" rowspan="2"> Registro</th>';	
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
							echo '<tr rowspan="2" bgcolor="Gainsboro" style="font-size:70%"><th width="60" rowspan="2"> Registro</th>';	
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
                       
                    if($dataInicial <= $pP->data_presente && $dataFinal >= $pP->data_presente ) 
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
                                if($s_Ant == '0.00') $core = "blue"; else  if($s_Ant >= '-1.00' && $s_Ant <= '1.00') $core = "#a05e34";
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
                    
                    
                                $s_Ant = $valor_ent_Ant - $valor_sai_Ant;
                                if($s_Ant == '0.00') $core = "blue"; else  if($s_Ant >= '-1.00' && $s_Ant <= '1.00') $core = "#a05e34";
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
            else if($adm == "cod_assoc" )
             {
                $tipo_Contas = 0;
               $dataInicial = $_SESSION['dataInicial'];
               $dataFinal  = $_SESSION['dataFinal'];
                
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
               
                    $conta   = $l->conta;
                    $cdiNome = "CDI NOVAS DE PAZ"; $cidadeNome = "sede"; $caixaNome = '0000'; 
                    $saldo_Mes     = $l->saldo_Mes;
               // echo    $l->valorFin;
                    if($dataInicial <= $l->dataFin && $dataFinal >= $l->dataFin)
                   {
                       
            //  $conta   = $l->conta; 
                           
                    switch ($conta) 
					{						 
						case 1:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '1444-3'; break;  
						case 2:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '22360-3'; break;  
						case 3:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = 'ILPI'; break;  
						case 4:	$cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '0214'; break;  
						case 5:	$cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  $caixaNome = '0518'; break;  
						case 6:	$cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS"; $caixaNome = '0542';  break;  
						case 7:	$cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  $caixaNome = '0549'; break;  
						case 8:	$cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  $caixaNome = '0579'; break; 	 
						case 9:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = 'BB-28965-5'; break; 	 
						case 10:	$cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA";  $caixaNome = 'CEF-1948-4'; break; 		
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
							$html .=  '<td colspan="5"></td> <td colspan="2">Saldo Final R$ </td>';	
							$html .=  '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';
							$html .= '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
							$html .=  '<td colspan="5"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							$html .=  '<td colspan="5"></td> <td colspan="2">Conciliação Bancária R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
                            	
							echo '<td colspan="5"></td> <td colspan="2"> Saldo Final R$ </td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                         
							echo '<tr><td colspan="5"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							echo '<tr><td colspan="5"></td> <td colspan="2">Saldo Bancária R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;  $totalE = 0; $totalS = 0;	
                
						}	
						if($primeiroReg == "S") 
						{
							
							$html .= '<table   cellspacing=0 bgcolor="white" width="260">';
							  if( $l->tipo_Conta == "Corrente")
                            {
                                $html .=   '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th ROWSPAN="5"></th> <th colspan="8" >IEADALPE - CONTA CORRENTE - BANCO
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
							$html .=   '<th>Conta:</th> <th colspan="2" align="center" > '.$caixaNome.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Cidade</th> <th colspan="3" align="center"  align="center" >'.$cidadeNome.'</th>';
							$html .=   '<th>Mês:</th> <th colspan="2" align="center" > ' .$mesN.' </th> </tr>';			
							$html .=   '<tr><th colspan="3">Estado</th> <th colspan="3" align="center"  align="center" >PE</th>';
							$html .=   '<th>Ano:</th> <th colspan="2" align="center" > ' .$ano.' </th> </tr>';
                            $html .=   '<tr><th colspan="9"  style="font-size:70%"></th>';
                            $html .=    ' </tr>';
                            
							$html .=   '<tr bgcolor="Gainsboro" ><th width="30" rowspan="2"> Registro</th>';	
							$html .=   '<th width="30" rowspan="3">Data</th>';	
							$html .=   '<th width="30" rowspan="3">Conta</th>';	
							$html .=   '<th width="30" rowspan="3">Forma ou cheque</th>';	
							//$html .=   '<th rowspan="3"> Área </th> <th rowspan="3"> Descrição </th>';	
							$html .=   '<th width="100" rowspan="3" colspan="3" >Histórico</th>';	
							$html .=   '<th width="80" rowspan="3">Receita(R$)</th>';	
							$html .=   '<th width="50" rowspan="3">Despesa(R$)</th>';	
							$html .=   '<th width="50" rowspan="2">TSaldo MÊS</th>';	
							$html .=   '</tr> <tr><th> '.number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							$html .=   '<tbody style="font-size:100%">';														
							$html .=   '<tr> </tr>';
                            
							echo '<table  border=0 cellspacing=0 bgcolor="white" width="100%">';
                            if( $l->tipo_Conta == "Corrente")
                            {
                                echo '<thead bgcolor="white" ><tr  ><th ROWSPAN="5"></th> <th colspan="8" >IEADALPE - CONTA CORRENTE - BANCO
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
							echo '<tr><th colspan="3">Projeto: '.$cdiNome.'</th> <th colspan="3" >Conta: '.$caixaNome.'</th>';
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
							echo '<th width="50" rowspan="3">Receita(R$)</th>';	
							echo '<th width="50" rowspan="3">Despesa(R$)</th>';	
							echo '<th width="50" rowspan="1">TSaldo MÊS</th>';	
							echo '</tr> <tr><th> ',number_format($saldo_Ant, 2, ',', '.').' </th></tr></thead>';
							echo '<tbody style="font-size:100%">';														
							echo '<tr  bgcolor="#121212" >';
							echo '<td  colspan="9" ></td>  ';
							echo '<td ></td>';
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
						
                    
                    
						$html .=  '<tr  bgcolor="white"  heigth="100" >';
						$html .=  '<td>' . $l->id_fin . '</td>';                      
						$html .=  '<td >' . $datX . '</td>';                      
						$html .=  '<td >' .$l->$adm. '</strong></td>';
						$html .=  '<td >' .$l->num_Doc_Banco . '</td>';
                     //   $html .=  ' <td>'.$admAr.'</td> <td>'.$admDesc.'</td>';
						$html .=  '<td   colspan="3" >' .$l->historico . '</td>';
						if($ent == 0) 
                            $html .=  '<td align="right">'.$ent.'</td>';
                        else 
                            $html .=  '<td  align="right">'.$ent.'</td>';
						if($Sai == 0) 
                            $html .=  '<td align="right">'.$Sai.'</td>';
                        else 
                            $html .=  '<td  align="right">'.$Sai.'</td>';
						$html .=  '<td align="right">'.number_format($total, 2, ',', '.').'</td>';
						$html .=  '</tr>';
                    
						echo '<tr  bgcolor="white"  heigth="100" >';
						echo '<td  > ' . $l->id_fin . ' </td>';                      
						echo '<td  heigth="100"   > ' . $datX . ' </td>';                      
						echo '<td  heigth="100" > ' .$l->$adm. '</strong> </td>';
						echo '<td  heigth="100" > ' .$l->num_Doc_Banco . ' </td>';
                      //  echo ' <td  heigth="100"> '.$admAr.' </td> <td> '.$admDesc.' </td>';
                        
                        $ok = 0;
                        $bR = " ";
                        foreach ($presentes_pagos as $pPr) 
                    {	
                            if($pPr->id_saida == $l->id_fin){ $bR = " - ".$pPr->n_beneficiario; }
                        }
                       if($l->num_Doc_Fiscal == "RECIBO" || $l->num_Doc_Fiscal == "S/N") {$docFiscal = " ";} else $docFiscal = " - ".$l->num_Doc_Fiscal;
                        
                        $historico = $l->historico.$docFiscal.$bR;
                        
                        
                        
						echo '<td  heigth="100"  colspan="3" > ' .$historico.' </td>';
                        if($ent == 0) 
                            echo '<td  heigth="100" align="right"> '.$ent.' </td>';
                        else 
                            echo '<td  heigth="100"  align="right"> '.$ent.' </td>';
                        if($Sai == 0) 
                            echo '<td  heigth="100x" align="right"> '.$Sai.' </td>';
                        else 
                            echo '<td  heigth="100"  align="right"> '.$Sai.' </td>';
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
						case 0:	$t_Conta_Ant = "Inexistente"; break;  		
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
							$html .=  '<td colspan="5"></td> <td colspan="2">Saldo Final R$ </td>';	
							$html .=  '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';
							$html .= '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
							$html .=  '<td colspan="5"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							$html .=  '<td colspan="5"></td> <td colspan="2">Conciliação Bancária R$ </td>';	
							$html .=  '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h5 align="right" valign=bottom ></h5></td>';	
							$html .= '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							$html .= '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                         $html .=   '<br>';
                        echo '<br>';
							$html .=  "<div style='page-break-before:always;'> </div>";
                            	
							echo '<td colspan="5"></td> <td colspan="2"> Saldo Final R$ </td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: green">'.$ent.'</strong></td>';	
							echo '<td><strong align="right" valign=bottom style="text-align: left; color: red">'.$sai.'</strong></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$total.'</h4></td></tr>';
                         
							echo '<tr><td colspan="5"></td> <td colspan="2">Cheques pendentes R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$Pendent.'</h4></td></tr>';
							echo '<tr><td colspan="5"></td> <td colspan="2">Saldo Bancária R$ </td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h5 align="right" valign=bottom ></h5></td>';	
							echo '<td><h4 align="right" valign=bottom style="text-align: left; color: blue">'.$saldo_Reconcil.'</h4></td></tr>';
							echo '</tbody></table></br>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                if($tipo_Conta_Ant == 0)	
							echo '<tr><td  colspan="5"><h4 align="right" valign=bottom style="text-align: left; color: RED"> SEM REGISTROS PARA ESTE MÊS</h4></td></tr>';
                
							echo "<div style='page-break-before:always;'> </div>";
							$total = $saldo_Ant;  $totalE = 0; $totalS = 0;	
                
                $html .=   '<br>';
                    echo '<br>';
                
                  //  $conta   = 5;
                foreach ($lancamentos as $l){  $conta   = $l->conta; }
          //PRESENTES PAGOS NO MÊS      >>>>>WHERE SUBSTRING(n_beneficiario,1,6) LIKE "'.$contN.'"  and valor_pendente < 1  
                                                 //   and data_presente >= "'.$data_x1.'" and data_presente <= "'.$data_x2.'"
                
                        switch ($conta) 
					{	
						case 1:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "1";        $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 2:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "000";      $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 3:	$contN = "000"; $cidadde = "Abreu e Lima"; $cdi = "000";      $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '000'; break; 
						case 4:	$contN = "BR0214"; $cidadde = "Abreu e Lima"; $cdi = "000";   $cdiNome = "CDI NOVAS DE PAZ I"; $cidadeNome = "ABREU E LIMA"; $caixaNome = '0214'; break; 
						case 5:	$contN = "BR0518"; $cidadde = "Paulista";     $cdi = "2";     $cdiNome = "CDI NOVAS DE PAZ II"; $cidadeNome = "PAULISTA";  $caixaNome = '0518'; break;   
						case 6:	$contN = "BR0542"; $cidadde = "Bezerros";     $cdi = "3";     $cdiNome = "CDI NOVAS DE PAZ III"; $cidadeNome = "BEZERROS"; $caixaNome = '0542';  break;  
						case 7:	$contN = "BR0549"; $cidadde = "Catende";      $cdi = "4";     $cdiNome = "CDI NOVAS DE PAZ IV"; $cidadeNome = "CATENDE";  $caixaNome = '0549'; break;
						case 8:	$contN = "BR0579"; $cidadde = "Jurema";       $cdi = "5";     $cdiNome = "CDI NOVAS DE PAZ V"; $cidadeNome = "JUREMA";  $caixaNome = '0579'; break;  
                        case 9:	$contN = "000"; $cidadde = "Abreu e Lima";       $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "JUREMA";  $caixaNome = '000'; break;  
                        case 10:	$contN = "000"; $cidadde = "Abreu e Lima";       $cdi = "000";     $cdiNome = "NOVAS DE PAZ"; $cidadeNome = "JUREMA";  $caixaNome = '000'; break;  
                        case 99:$contN = "Todas contas"; break;  				
					}
                     
    //Suspende a exibição de presentes especiais no relatório IEADALPE            
        if( 1==2)   {              
            if (!$presentes_pagos || $conta < 4 ||  $conta > 8) 
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
                        	
                        if($pP->valor_saida == 0) $cor = "#F7F8E0"; else $cor = "Yellow";
                            $html .=    '<tr  bgcolor=   '.$cor.'>';
                            $html .=    ' <td bgcolor="white">'.$pP->id_presente .'</td> 
                            <td><strong>'.$pP->data_presente .'</td>';
                            $html .=    '<td align="right">'.$pP->n_beneficiario .'</td> <td>'.$pP->nome_beneficiario .'</td>';
                            $html .=    '<td align="right">'.$mes_extenso.' -- '.$anoE.'</td>';
                            $html .=    '<td align="right">'.$pP->n_protocolo .'</td>';
                           	$html .=    '<td align="right">'.number_format($pP->valor_entrada, 2, ',', '.') .'</td> 
                            <td align="right">'.number_format($pP->valor_saida, 2, ',', '.') .'</td> <td bgcolor="white"></td> </tr>';
                           		
                            echo '<tr  bgcolor='.$cor.'>';
                            echo ' <td bgcolor="white">'.$pP->id_presente .'</td> 
                            <td><strong>'.$pP->data_presente .'</td>';
                            echo '<td align="right">'.$pP->n_beneficiario .'</td> <td>'.$pP->nome_beneficiario .'</td>';
                            echo '<td align="right">'.$mes_extenso.' -'.$anoE.'</td>';
                            echo '<td align="right">'.$pP->n_protocolo .'</td>';
                           	echo '<td align="right">'.number_format($pP->valor_entrada, 2, ',', '.') .'</td> 
                            <td align="right">'.number_format($pP->valor_saida, 2, ',', '.') .'</td> <td bgcolor="white"></td></tr>';
                           							
                              //  $total += $pP->valor_pendente;
                            
                    } 	
                   //    echo $pP->n_beneficiario.'  '.$contN.'  - ';
                   }
                   $html .=    '<tr><td colspan="9"></td> </tr>';
                            
                    
                    $html .=   '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                    echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante

                }}
                 $html .=   '<br>';
                    echo '<br>';
                
                /*
                
          //RECONCILIAÇÃO BANCÁRIA      >>>>>
           	$cheques_abertos = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, num_Doc_Banco, historico, dataFin, valorFin, id_aenp, status FROM aenpfin, reconc_bank
                            WHERE id_fin = id_aenp and  conta like '.$caixa.' and status like 0 ORDER BY dataFin ');
            if (mysqli_num_rows($cheques_abertos) == 0 ) 
                {	echo "<center><font color = red >Nao existem registros de cheques á compensar!</font>";
                }else
                if (mysqli_num_rows($cheques_abertos) > 0 )
                {
                   
							$contaBanco = mysqli_query($conex, 'SELECT * FROM caixas
                                                        WHERE id_caixa like '.$caixa.' LIMIT 1');
                        if (mysqli_num_rows($contaBanco) == 0 ) 
                            {	echo "<center><font color = red >Nao encontrada conta!</font>"; exit;
                            }
                    
                            while ($rows_contaBanco = mysqli_fetch_assoc($contaBanco)) 
                                {
                                $nomecaixa = $rows_contaBanco['nome_caixa'];
                                $banco = $rows_contaBanco['banco'];
                                $agencia = $rows_contaBanco['agencia'];
                                $n_conta = $rows_contaBanco['n_conta'];
                                }
                    
                            $html .=  '<table  border=1 cellspacing=0 bgcolor="white" width="260">';
							$html .=  '<thead ><tr bgcolor="Gainsboro" style="font-size:200%"><th bgcolor="white"  ROWSPAN="9"></th> <th colspan="7" >RECONCILIAÇÃO BANCARIA
							         </th> <th align="center" >Folha Nº3</th>  </tr>';							
							$html .=  '<tr><th colspan="8">.</th></tr><tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							$html .=  '<th>BR:</th> <th align="center" >'.$caixaNome.' </th> </tr>';			
							$html .=  '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							$html .=  '<th>Mês:</th> <th align="center" >'.$mesN.' </th> </tr>';			
							$html .=  '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							$html .=  '<th>Ano:</th> <th align="center" >'.$ano.' </th> </tr>';			
							$html .=  '<tr><th colspan="8">.</th> </tr>';
							$html .=  '<tr bgcolor="Gainsboro"><th colspan="8" >SALDO DO EXTRATO BANCÁRIO <br> (Conforme aparece no extrato) </th>  </tr>';		
							$html .=  '<tr><th width="130">BANCO</th> <th bgcolor="yellow" >'.$banco.'</th> <th width="130">AGENCIA</th> <th bgcolor="yellow" >'.$agencia.'</th>';		
							$html .=  '<th width="130">CONTA Nº</th> <th bgcolor="yellow" width="130">'.$n_conta.'</th> <th>SALDO</th> <th bgcolor="yellow" >SALDO</th> </tr>';		
							$html .=  '<tr><th colspan="8" >.</th> </tr>';
							
							$html .=  ' </tr >';
							$html .=  '<tr bgcolor="Gainsboro" ><th width="60" > Registro</th>';	
							$html .=  '<th width="60" >DATA</th>';	
							$html .=  '<th width="50" colspan="5">HISTÓRICO</th>';	
							$html .=  '<th width="360" >Nº CHEQUE</th>';	
							$html .=  '<th width="130" >VALOR</th>';
							$html .=  '</tr>';	
							$html .= '</thead>';		
                            $html .=  '<tbody bgcolor="yellow"  style="font-size:100%">';
                    
                    
                            echo '<table  border=1 cellspacing=0 bgcolor="white" width="760">';
							echo '<thead ><tr bgcolor="Gainsboro"><th bgcolor="white"  ROWSPAN="9"></th> <th colspan="7" >RECONCILIAÇÃO BANCARIA
							         </th> <th align="center" >Folha Nº3</th>  </tr>';							
							echo '<tr><th colspan="8">.</th></tr><tr><th colspan="2">Projeto</th> <th colspan="4" align="center"   >'.$cdiNome.'</th>';
							echo '<th>BR:</th> <th colspan="2" align="center" >'.$caixaNome.' </th> </tr>';			
							echo '<tr><th colspan="2">Cidade</th> <th colspan="4" align="center"  >'.$cidadeNome.'</th>';
							echo '<th>Mês:</th> <th colspan="2" align="center" >'.$mesN.' </th> </tr>';			
							echo '<tr><th colspan="2">Estado</th> <th colspan="4" align="center"  >PE</th>';
							echo '<th>Ano:</th> <th colspan="2" align="center" >'.$ano.' </th> </tr>';			
							echo '<tr><th colspan="8" style="font-size:70%">.</th> </tr>';
							echo '<tr bgcolor="Gainsboro"><th colspan="9" >SALDO DO EXTRATO BANCÁRIO <br> (Conforme aparece no extrato) </th>  </tr>';		
							echo '<tr style="font-size:80%"><th width="130">BANCO</th> <th bgcolor="yellow" >'.$banco.'</th> <th width="130">AGENCIA</th> <th bgcolor="yellow" >'.$agencia.'</th>';		
							echo '<th width="130">CONTA Nº</th> <th bgcolor="yellow" width="130">'.$n_conta.'</th> <th>SALDO</th> <th bgcolor="yellow" >SALDO</th> </tr>';		
							echo '<tr><th colspan="8" style="font-size:70%">.</th> </tr>';							
							echo ' </tr >';
							echo '<tr bgcolor="Gainsboro" style="font-size:70%"><th width="60" > Registro</th>';	
							echo '<th width="60" >DATA</th>';	
							echo '<th width="50" colspan="5">HISTÓRICO</th>';	
							echo '<th width="360" >Nº CHEQUE</th>';	
							echo '<th width="130" >VALOR</th>';
							echo '</tr>';	
							echo '</thead>';		
                            echo '<tbody bgcolor="yellow"  style="font-size:70%">';
                    
                    
                    $total = 0;	$inicio = 1; 
                    while ($rows_chek = mysqli_fetch_assoc($cheques_abertos)) 
                    {	switch ($rows_chek['conta']) 
                        {
                            case 1:	$contaN = "IEADALPE - 1444-3"; $cor = '#9b0f0f';  break;    
                            case 2:	$contaN = "22360-3"; $cor = '#dd9431'; break;  
                            case 3:	$contaN = "ILPI"; $cor = '#B266FF';break;  
                            case 4:	$contaN = "BR214"; $cor = '#aa3636'; break;  
                            case 5:	$contaN = "BR518"; $cor = '#B266FF'; break;  
                            case 6:	$contaN = "BR542";$cor = '#2d3607'; break;  
                            case 7:	$contaN = "BR549"; $cor = '#23862e'; break;  
                            case 8:	$contaN = "BR579"; $cor = '#7562c3'; break;  
                            case 9:	$contaN = "BB 28965-5"; break;  
                            case 10:$contaN = "CEF 1948-4"; break;
                            case 99:$contaN = "Todas contas"; break;  				
                        }		
                        $data_Ch= implode('/',array_reverse(explode('-',$rows_chek['dataFin'])));
                        $val_Ch= number_format($rows_chek['valorFin'], 2, ',', '.');
                        $total = $total + $rows_chek['valorFin'];
                        {	
                            $html .=  '</td> <td>'.$rows_chek['id_fin'].'</td> <td>'.$data_Ch.'</td>';
                            $html .=  '<td colspan="5">'.$rows_chek['historico'].'</td> <td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$val_Ch.'</td>';
                            $html .=  '</tr>';
                            
                            echo '</td> <td>'.$rows_chek['id_fin'].'</td> <td>'.$data_Ch.'</td>';
                            echo '<td colspan="5">'.$rows_chek['historico'].'</td> <td>'.$rows_chek['num_Doc_Banco'].'</td> <td>'.$val_Ch.'</td>';
                            echo '</tr>';
                            $total = $total + $rows_chek['valorFin'];
                          //  $inicio = 0;
                        }
                            }	
                    } 	
                        $val_Ch= number_format($total, 2, ',', '.');
                
                        $html .= '<tr bgcolor="Gainsboro"> <td></td> <td colspan="7">TOTAL DE CHEQUES PENDENTES:.....................................</td>';	
                        $html .= '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                         $html .= '<tr><td colspan="8"  bgcolor="white">.</td> </tr>';
				        $html .= '<tr bgcolor="Gainsboro" > <td></td> <td colspan="7">SALDO BANCÁRIO AJUSTADO:.....................................</td>';	
                        $html .= '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                        $html .= '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                        echo '<tr bgcolor="Gainsboro"> <td></td> <td colspan="7">TOTAL DE CHEQUES PENDENTES:.....................................</td>';	
                        echo '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                         echo '<tr><td colspan="8"  bgcolor="white">.</td> </tr>';
				        echo '<tr bgcolor="Gainsboro" > <td></td> <td colspan="7">SALDO BANCÁRIO AJUSTADO:.....................................</td>';	
                        echo '<td ><h4 align="right" valign=bottom >'.$val_Ch.'</h4></td></tr>';
                        echo '</tbody></table>';//caixa,cod_compassion,cod_assoc,num_Doc,historico,dataFin,valorFin,ent_Sai, cadastrante
                
                */
                
                
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
            else if($adm == "saldos" )
             {?>
                <table class="table table-bordered " >
                <body>
                    <tr>
                    <?php 
                $contasAdmI = "4,5,6,7,8";
                if(isset($_SESSION['adminSal'])){
                $lista_ContasC = "4,5,6,7,8";
                $lista_ContasI = "1,2,9,10";
                $contasAdmI  = ("cod_compassion" == $_SESSION['adminSal']) ? $lista_ContasC : $lista_ContasI;
                }
                $cont = 1;$s_Anterior = 0.0;$s_Atual = 0.0;
                foreach ($arrContas as $ct)                                    
                  { 
                        $tipo_ContaAnterior = '';
                        $data_Anterior = ''; 
                        $e_s_Anterior = ''; 
                        $valor_Anterior = 0.0;
                        $s_Anterior = 0.0; $difer ='';
                    if (preg_match("/{$ct->id_caixa}/", $contasAdmI)) {
                        ?>
                   <td>
                    <table  class="table table-bordered " >
                        <tr><th><H4><?php echo $ct->id_caixa.'-'.$ct->nome_caixa ?></H4></th></tr>
                    
                    <tr><th>
                    <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/financeiroSaldos" method="post">
                       <input  name="ajustar"  type="hidden" value="1" />
                       <input  name="conta"  type="hidden" value="<?php echo $ct->id_caixa ?>" />
                        <div class="span12" style="margin-left: 0; text-align: center">
                            <button class="btn btn-success span12"><i class="icon-list-alt"></i> Ajustar Saldos</button>
                        </div>
                    </form>
                    </tr>
                    <body>
                    <?php    
                    foreach ($lancamentos as $l)                                    
                        {   $corTr = '';$sAntes = '';
                         $mesAnteriormenos1  = date('Y/m', strtotime("-1 month", strtotime($data_Anterior)));
                         $mesAnterior  = date('Y/m', strtotime( $data_Anterior));
                         $mesAtual     = date('Y/m', strtotime( $l->dataFin));
                           if($ct->id_caixa == $l->conta)
                           {                               
                                $dataMA = date('M/y', strtotime( $l->dataFin));
                                $valorFinE = number_format($l->valorFin, 2, ',', '.');
                                $saldoE = number_format($l->saldo, 2, ',', '.');
                               $oper = ($l->ent_Sai == 0) ? " + " : " - ";
                               if($l->tipo_Conta == $tipo_ContaAnterior)
                                {
                                   if($mesAnterior != $mesAtual)
                                   {    
                                       if($e_s_Anterior == 0) 
                                            $s_Anterior = $s_Anterior + $valor_Anterior; else 
                                            $s_Anterior = $s_Anterior - $valor_Anterior;
                                       $difer = abs($s_Anterior - $l->saldo);
                                       if($difer < 0.01001)
                                       {
                                       }else 
                                       if($mesAnteriormenos1 == $mesAtual)
                                       { $corTr =  'bgcolor="#fc7a7a"'; $sAntes = $s_Anterior;
                                       }else 
                                       { $corTr =  'bgcolor="#defc7a"'; $sAntes = $s_Anterior;
                                       }
                                       $diferE = ($difer > 0.01)? " (".$difer.")":'';
                                       $valores = $dataMA."<STRONG>  ".$saldoE.$diferE."</STRONG>";
                                   }else 
                                   $valores = "<font color='#837332'>".$dataMA."  (".$saldoE.$oper.$valorFinE.")</font>";
                               }else{ 
                                    $valores = $dataMA."<STRONG>  ".$saldoE."</STRONG>";
                                ?>
                                <tr><th><?php echo $l->tipo_Conta; ?></th></tr>
                            <?php } 
                               
                            //$diferE = number_format($difer, 2, ',', '.');
                                ?>
                                 <tr><td  <?php echo $corTr ?> >
                                 <?php echo $valores ?>
                                 </td></tr>
                            <?php  
                           }$difer ='';
                            $tipo_ContaAnterior = $l->tipo_Conta;
                            $data_Anterior = $l->dataFin; 
                            $valor_Anterior = $l->valorFin; 
                            $s_Anterior = $l->saldo; 
                            $e_s_Anterior = $l->ent_Sai; 
                        } ?>
                        </body>
                        </table>
                    </td>
                    <?php 
                  }
                }?>
                   
                    <td></td></tr>
                </body>
                          </table>
                
                <?php                
            
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
            ?>
              
      </div>
                       
    <?php
         }
    ?>       
</div>


     </body>
</html>