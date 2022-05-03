  <head>
    <title>CisCOF</title>
    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/blue.css" class="skin-color" />
    <script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

  <body style="background-color: transparent">



      <div class="container-fluid">

          <div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                      <div class="widget-title">
                          <h5 style="text-align: center">Associação Evangélica Novas de Paz</h5>
                      
                      </div>
                      <div class="widget-content nopadding">
                    <?php
                           $html = '';
                          $contA = $_SESSION['cont_a'];
                            if($contA !== null)
                            {
                                 switch ($contA) 
                                        {	   
                                            case "": $contN     = "Todas";              break;  
                                            case "Todas": $contN   = "Todas";           break;  
                                            case 1: $contN      = "IEADALPE-1444-3";    break;  
                                            case 2:	$contN      = "IEADALPE-22360-3";   break;    
                                            case 3:	$contN      = "ILPI";               break;  
                                            case 4: $contN      = "BR0214";             break;  
                                            case 5:	$contN      = "BR0518";             break;  
                                            case 6:	$contN      = "BR0542";             break;  
                                            case 7:	$contN      = "BR0549";             break;  
                                            case 8:	$contN      = "BR0579";             break; 
                                            case 9:	$contN      = "BB-28965-5";         break;  
                                            case 10:$contN      = "CEF-1948-4";         break; 		
                                        }
                            } else { $contN  = "Todas";   }
                    if(!isset ($_SESSION['tipo'] ) || null ==  ($_SESSION['tipo'] )) $_SESSION['tipo']       = "";
                    if($_SESSION['tipo'] == "")  {     
                    ?>
                 <!-- <table class="table  border=0  padding: 4px">
                      <tbody> -->
                      <?php
                        $contaC = '0'; $tContaT = '0'; $tem = 0;
                        $ct = $contaC."-".$tContaT;
                        $contas = array($ct);
                        $saldoAnt = 0;
                     foreach ($saldo as $s) {
                         
                         foreach ($contas as $c) {
                             if($c == $s->conta."-".$s->tipo_Conta)
                                $tem = 1;
                             }                         
                        if($tem == 0) 
                        {
                        array_push($contas,$s->conta."-".$s->tipo_Conta);
                        $contaC = $s->conta; $tContaT = $s->tipo_Conta;
                        ?> <!-- <tr>
                              <td ><?php echo $s->conta; ?></td>
                              <td ><?php echo $s->tipo_Conta; ?></td>  
                              <td ><?php echo $s->saldo; ?></td>                                
                          </tr>  -->
                        <?php
                        $saldoAnt += $s->saldo;
                        }
                     }
                        if($saldoAnt >= 0 ) $corTS = "BLUE"; else $corTS = "RED";
                        $saldoAntExibe  =    number_format(str_replace(",",".",$saldoAnt), 2, ',', '.');
                        // foreach ($contas as $c) {    echo $c." | "; }
                    ?><!--<tr>
                              <td ></td>
                              <td ></td>       
                              <td ><?php echo $saldoAnt; ?></td>                              
                          </tr>  
                      </tbody>
                    </table>
                          -->
                  <table class="table  border=0  padding: 4px">
                      <thead> 
                          <tr>
                              <td colspan=3>Relatório Sintético AENPAZ</td>
                              
                          </tr>  <tr>
                              <td >Conta</td>
                              <td ><?php echo $contN; ?></td>
                              <td >Período de <?php echo $_SESSION['dataInicio']; ?> à </td>
                              <td ><?php echo $_SESSION['dataFim']; ?></td>
                              
                          </tr>                         
                          <tr>
                              <th style="font-size: 1.2em; padding: 5px;">Centro de custo</th>
                              <th style="font-size: 1.2em; padding: 5px;">Descrição</th>
                              <th style="font-size: 1.2em; padding: 5px;">Acumulado</th> <!--  -->
                              <th style="font-size: 1.2em; padding: 5px;">Valor Total R$</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr> <td bgcolor=#111211 height=1px  colspan=4 ></td></tr>                       
                          <tr border=1 ><td colspan="2">Saldo Anterior</td>
                          <td align="right"><font color = '<?php echo $corTS ?>' ><?php echo $saldoAntExibe  ?></font></td><td></td></tr>
                          
                          <?php
                          //    $dataInicial = date('2017-m-01');
                          $cod = 'A'; $prim = 1; $totalES = 2;  $totalES = 0; $es_Anterior = 0; $valor = 0; $valorT = 0; $valorTE = $valorTS = 0;
                          foreach ($vendas as $c) {
                           //   if($c->dataFin >= $dataInicial)
                              {                                  
                                  if($prim == 1)
                                  { $dataInicial = $c->dataFin; }       
                                  
                                  if($c->cod_assoc !== $cod &&  $prim !== 1)
                                  {             
                                      if($valorT >= 0) $corES = "BLUE"; else $corES = "RED";
                                      $valorTFinExibe  =    number_format(str_replace(",",".",$valorT), 2, ',', '.');
                                      $valorFinExibe  =    number_format(str_replace(",",".",$valor), 2, ',', '.');  
                                      echo '<tr>';
                                      echo '<td>' .$cod. '</td>';
                                      echo '<td>' .$desc. '</td>'; 
                                      echo '<td align="right"><font color = '.$corES.' >' .$valorTFinExibe. '</font></td>';
                                     // echo '<td>' .$dataInicial.' à '.$dataFinal. '</td>';
                                      if($c->ent_Sai == 1) $corES = "BLUE"; else $corES = "RED"; 
                                      echo '<td align="right"><font color = '.$corES.' >' .$valorFinExibe. '</font></td>';
                                      echo '</tr>';                  
                                      
                                      if($c->ent_Sai <> $es_Anterior)
                                      {                                          
                                        $valorT += $valor;
                                        $valorTE = $valorT;
                                        if($valorT >= 0) $corES = "BLUE"; else $corES = "RED";
                                        $valorTFinExibe  =    number_format(str_replace(",",".",$valorT), 2, ',', '.');
                                        ?>
                                        <tr border=1 ><td colspan="2">Total acumulado</td>
                                            <td align="right"><strong><font color = '<?php echo $corES ?>' ><?php echo $valorTFinExibe ?></font></strong></td><td></td></tr>
                                        <?php
                                        $valorT = 0; $valor = 0;
                                          
                                      }
                                      
                                      $dataInicial = $c->dataFin;
                                      $es_Anterior = $c->ent_Sai;
                                      $dataFinal = $c->dataFin;
                                      
                                      $valorT += $valor;
                                      $valor = $c->valorFin;
                                      $prim = 0;
                                  }else
                                  {
                                      $es_Anterior = $c->ent_Sai;
                                      $dataFinal = $c->dataFin;
                                      $valor += $c->valorFin;
                                      $prim = 0;
                                  }
                                  $cod = $c->cod_assoc;
                                  $desc = $c->descricao_Ass;
                              }
                          }
                          
                          $valorTFinExibe  =    number_format(str_replace(",",".",$valorT), 2, ',', '.'); 
                          $valorFinExibe  =    number_format(str_replace(",",".",$valor), 2, ',', '.');  
                          echo '<tr>';
                          echo '<td>' .$cod. '</td>';
                          echo '<td>' .$desc. '</td>';
                    
                            if($valorT >= 0) $corES = "BLUE"; else $corES = "RED";
                          echo '<td align="right"><font color = '.$corES.' >' .$valorTFinExibe. '</font></td>';
                         // echo '<td>' .$dataInicial.' à '.$dataFinal. '</td>';
                            if($es_Anterior == 1) $corES = "BLUE"; else $corES = "RED"; 
                          echo '<td align="right"><font color = '.$corES.' >' .$valorFinExibe. '</font></td>';
                          echo '</tr>';      
                          
                        $valorT     += $valor;
                        $valorTS    = $valorT;
                        $valorTFim  = $valorTE - $valorTS;
                        if($valorTFim >= 0 ) $corTF = "BLUE"; else $corTF = "RED";
                        $valorTcomSaldo = $valorTFim + $saldoAnt;
                        if($valorTcomSaldo >= 0 ) $corTcS = "BLUE"; else $corTcS = "RED";
                        
                          $valorTEinExibe  =    number_format(str_replace(",",".",$valorTE), 2, ',', '.'); 
                          $valorTSExibe  =    number_format(str_replace(",",".",$valorTS), 2, ',', '.'); 
                          $valorTFinExibe  =    number_format(str_replace(",",".",$valorTFim), 2, ',', '.'); 
                          $valorTcomSaldoExibe  =    number_format(str_replace(",",".",$valorTcomSaldo), 2, ',', '.'); 
                         ?>
                            <tr border=1 ><td colspan="2">Total acumulado</td>
                                <td align="right">
                                <strong><font color = '<?php echo $corES; ?>' > <?php echo $valorTSExibe ?></font></strong></td><td></td></tr>
                            
                         <tr> <td bgcolor=#111211 height=1px  colspan=4 ></td></tr>                        
                          <tr border=1 ><td colspan="2">Total Entradas</td>
                          <td align="right"><font color = BLUE ><?php echo $valorTEinExibe ?></font></td><td></td></tr>
                          <tr border=1 ><td colspan="2">Total Saídas</td>
                          <td align="right"><font color = red ><?php echo $valorTSExibe ?></font></td><td></td></tr>
                          <tr border=1 ><td colspan="2">Total acumulado do período</td>
                          <td align="right"><font color = '<?php echo $corTF ?>' ><?php echo $valorTFinExibe ?></font></td><td></td></tr>
                          
                          <tr border=1 ><td colspan="2">Saldo Anterior</td>
                          <td align="right"><font color = '<?php echo $corTS ?>' ><?php echo $saldoAntExibe  ?></font></td><td></td></tr>
                          
                          <tr border=1 ><td colspan="2">Total acumulado mais saldo anterior</td>
                          <td align="right"><font color = '<?php echo $corTcS ?>' ><?php echo $valorTcomSaldoExibe ?></font></td><td></td></tr>
                      </tbody>
                  </table>

                 <?php } 
                          //TELA RELATÓRIO DE LANÇAMENTOS COMBINADOS//*******
                          
                          else{        
                    ?>
                 <table class="table  border=0  padding: 4px">
                      <thead> 
                          <tr>
                              <td colspan=3>Relatório de verificação de lançamentos combinados</td>
                              
                          </tr>  <tr>
                              <td >Conta</td>
                              <td ><?php echo $contN; ?></td>
                              <td >Período de <?php echo $_SESSION['dataInicio']; ?> à </td>
                              <td ><?php echo $_SESSION['dataFim']; ?></td>
                              
                          </tr>                         
                          <tr>
                              <th style="font-size: 1.2em; padding: 5px;">Código</th>
                              <th style="font-size: 1.2em; padding: 5px;">Data</th>
                              <th style="font-size: 1.2em; padding: 5px; width: 8%;">C. de custo</th>
                              <th style="font-size: 1.2em; padding: 5px;">Doc</th>
                              <th style="font-size: 1.2em; padding: 5px; width: 20%;">Histórico | Descrição</th>
                              <th style="font-size: 1.2em; padding: 5px; width: 10%;">C.Saida</th>
                              <th style="font-size: 1.2em; padding: 5px; width: 10%;" >C.Entrada</th> 
                              <th style="font-size: 1.2em; padding: 5px;">Tipo</th> <!--  -->
                              <th style="font-size: 1.2em; padding: 5px;">Valor R$</th>
                              <th style="font-size: 1.2em; padding: 5px; width: 11%;">#</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr> <td bgcolor=#111211 height=1px  colspan=10 ></td></tr>
                          <?php
                    $dataIni    = $_SESSION['dataInicio'];
                    $dataF      = $_SESSION['dataFim'];
                    $html .= '
                  <table class="table  border=0  padding: 4px">
                      <thead> 
                          <tr>
                              <td colspan=3>Relatório de lançamentos Combinados E/S</td>
                              
                          </tr
                          </tr>  <tr>
                              <td >Conta</td>
                              <td ><?php echo $contN; ?></td>
                              <td >Período de '.$dataIni.' à </td>
                              <td >'.$dataF.'</td>
                              
                          </tr>        
                 <table class="table  border=0  padding: 4px">
                      <thead> 
                          <tr>
                              <td colspan=3>Relatório de verificação de lançamentos combinados</td>
                              
                          </tr>                       
                          <tr>
                              <th style="font-size: 1.2em; padding: 5px;">Id/Data</th>
                              <th style="font-size: 1.2em; padding: 5px;">Códigos</th>
                              <th style="font-size: 1.2em; padding: 5px; width: 8%;">Docmt</th>
                              <th style="font-size: 1.2em; padding: 5px; width: 20%;">Histórico | Descrição</th>
                              <th style="font-size: 1.2em; padding: 5px;">Valor R$</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr> <td bgcolor=#111211 height=1px  colspan=5 ></td></tr>';
                        //echo $this->session->userdata('id');
                          //    $dataInicial = date('2017-m-01');
                          $cod = 'A'; $prim = 1; $totalES = 2;  $totalES = 0; $es_Anterior = 0; $valor = 0; $valorT = 0;
                            
                            $id = array("0");
                          foreach ($vendas as $c) 
                          { $ok = 0;
                              $sai = 0;  $ent = 0;  $par = 0; $par_Linha =  0;

                              $verificado = 0;
                              foreach ($id as $lanc) {
                                  if($lanc == $c->id_fin) $verificado = 1;
                              }
                              if($verificado == 0)
                               // if($c->cod_assoc == "T00-000" || $c->cod_assoc == "T00" || 
                                //   $c->cod_assoc == "T01" || $c->cod_assoc == "T01-000"  )
                            { $sai2 =  $ent2 = $c_SaidaCad2 = $c_SaidaCad2 = 0; $ok2 = 0;  
                                 
                            $menos2 = date('Y-m-d', strtotime("-5 day", strtotime( $c->dataFin)));
                            $mais2 = date('Y-m-d', strtotime("+5 day", strtotime( $c->dataFin)));
                             $prim = 1;
                              array_push($id, $c->id_fin);
                              foreach ($vendas as $c2) 
                              {
                                  $verificado = 0;
                                      foreach ($id as $lanc) {
                                          if($lanc == $c2->id_fin) $verificado = 1;
                                      }
                                  if($verificado == 0)
                                     if((($c->cod_assoc == "T00-000" && $c2->cod_assoc == "T00") ||
                                        ($c->cod_assoc == "T01-000" && $c2->cod_assoc == "T01") ||
                                        ($c->cod_assoc == "T00" && $c2->cod_assoc == "T00-000") ||
                                        ($c->cod_assoc == "T01" && $c2->cod_assoc == "T01-000")) && 
                                        ($c->valorFin == $c2->valorFin ) && ($c->num_Doc_Banco == $c2->num_Doc_Banco ) && 
                                        ($c2->dataFin > $menos2 && $c2->dataFin < $mais2 ))
                                         {  
                                            $ent_Sai2 = $c2->ent_Sai;
                                            $blocS2 = $blocE2 = 'type="number" mim="0" max="11"' ;
                                            $c_EntradaCad2 = $c_SaidaCad2 = "" ;
                                             if($c2->ent_Sai == 0) //SE O SEGUNDO FOR SAIDA
                                                    {$sai2 = $c2->conta; 
                                                     $ent2 = $c->conta; 
                                                     $corDif2 = "color:red";
                                                     $blocS2 = 'Readonly type="text"' ;  
                                                     $c_EntradaCad2 = $c2->conta_Destino;
                                                     $c_SaidaCad2 = $c2->nome_caixa;
                                                     if($ent2 == $c_EntradaCad2) $ok2 = 1;
                                                    }
                                             else { //SE O SEGUNDO FOR ENTRADA
                                                   $sai2 = $c->conta; 
                                                   $ent2 = $c2->conta; 
                                                   $corDif2 = "color:blue";
                                                   $blocE2 = 'Readonly type="text"'  ; 
                                                   $c_SaidaCad2 = $c2->conta_Destino; 
                                                   $c_EntradaCad2 = $c2->nome_caixa;
                                                   if($sai2 == $c_SaidaCad2) $ok2 = 1;
                                                  }
                                             $par = 1;
                                                $id_fin2        = $c2->id_fin;
                                                $dataFin2       = $c2->dataFin;
                                                $cod_assoc2     = $c2->cod_assoc;
                                                $num_Doc_Banco2 = $c2->num_Doc_Banco;
                                                $historico2     = $c2->historico;
                                                $tipo_Conta2    = $c2->tipo_Conta;
                                                $valorFin2      = $c2->valorFin;
                                                $cod_compassion2= $c2->cod_compassion;
                                                $cadastrante2   = $c2->cadastrante;
                                                $par_ES2         = $c2->par_ES;

                                            array_push($id, $c2->id_fin);
                                         $par_Linha =  1;
                                        }
                                    }
                                    $blocS = $blocE = 'type="number" mim="0" max="11"' ; 
                                    $c_EntradaCad = $c_SaidaCad = "" ; $ent_Sai = $c->ent_Sai;
                                    {
                                        if($c->ent_Sai == 0) //Se for saida
                                                 {$sai = $c->conta; 
                                                  
                                                if($par == 1) $ent = $ent2; else $ent = 0;
                                                  $corDif = "color:red" ; 
                                                  $blocS = 'Readonly type="text"' ; 
                                                  {
                                                  $c_EntradaCad = $c->conta_Destino;
                                                  $c_SaidaCad  = $c->nome_caixa;
                                                  if($ent == $c_EntradaCad) $ok = 1;
                                                 }
                                                 }//Se for entrada
                                                 else {$ent = $c->conta; 
                                                        if($par == 1) $sai = $sai2; else $sai = 0;
                                                       
                                                       $corDif = "color:blue"; 
                                                       $blocE = 'Readonly type="text"'  ;
                                                       
                                                       $c_SaidaCad  = $c->conta_Destino;
                                                       $c_EntradaCad = $c->nome_caixa;
                                                  if($sai == $c_SaidaCad) $ok = 1;}
                                     
                                        $exibe_Linha = 0;
                                        switch ($_SESSION['tipo']) 
                                        {						 
                                            case 1:	  $exibe_Linha = 1; break;  
                                            case 2:	  if($par_Linha == 1) $exibe_Linha = 1; break;  
                                            case 3:	  if($par_Linha == 0) $exibe_Linha = 1; break; 
                                            case 4:	  if($par_Linha == 1 && ($ok == 0 || $ok2 == 0))
                                                        $exibe_Linha = 1; break;
                                            case 5:	  if(($ok == 0 || $ok2 == 0))
                                                        $exibe_Linha = 1; break;
                                        }	
                                     if($exibe_Linha == 1) 
                                     {  
                                    if($par == 0){ $corPar = "#fab1b1";$corPar1 = "#ffffff"; 
                                                echo "<tr bgcolor='".$corPar."'>";
                                                  ?>                                                  
                                           <td>
                                            <form action="<?php echo current_url(); ?>" method="get" id="form">
                                              <input type="hidden" name="similares" value="<?php echo $c->id_fin ?>" />
                                              <input type="hidden" name="data"  value="<?php echo $c->dataFin ?>" />
                                              <input type="hidden" name="valor"  value="<?php echo $c->valorFin ?>" />
                                              <button class="btn btn-success"><i class="icon-list icon-white" title="Exibir similares" ></i> <?php echo $c->id_fin ?></button>
                                               
                                            </form>
                                           </td>
                                                  <?php
                                                 }else 
                                       { if($ok == 1 && $ok2 == 1 ) {$corPar =  "#1eaf45";$corPar1 =  "#9ffab7";} else {$corPar = "Yellow";$corPar1 = "#fafaca";}     
                                        echo "<tr bgcolor='".$corPar."'>";      
                                        
                                            if($c->id_fin > 121170 && $c->cadastrante == 1 )$corId = "color:red" ;
                                        else $corId = "color:blue" ;
                          ?>                                        
                                           <td style="<?php echo $corId ?>"><?php echo $c->id_fin ?></td>
                                           <?php } 
                                $editar =  ""; 
                                $termo = "combinar E-S ";
                                $editar = 1;
                                $descric = $c->descricao;
                                $dataDescric = " Sem ";
                                $pattern = '/' . $termo . '/';//Padrão a ser encontrado na string $tags
                                if (preg_match($pattern, $descric))
                                    $dataDescric = substr($descric, -10);
                                if(date($dataDescric) != date('Y-m-d'))  $editar =  " igual";else $editar = " Difer";
                                  
                          ?>
                                <form action="<?php echo current_url(); ?>" method="get" id="form_<?php echo $c->id_fin ?>">
                                              <input type="hidden" name="similares"  value=0 />
                                           <td><?php echo $c->dataFin ?></td>
                                           <td><?php echo $c->cod_assoc." | ".$c->cod_compassion ?> </td>
                                           <td><?php echo $c->num_Doc_Banco ?></td>
                                           <td><?php echo $c->historico." | ".$c->descricao." ( ".$c->par_ES." )" ?></td>
                                           <td>
                                           <input type="hidden" name="par"  value="<?php echo $par ?>" />
                                           <input type="hidden" name="descricao"  value="<?php echo $c->descricao ?>" />
                                           <input type="hidden" name="id_fin"  value="<?php echo $c->id_fin ?>" />
                                           <input type="hidden" name="ent_Sai"  value="<?php echo $ent_Sai ?>" />
                                           <input type="hidden" name="dataFin"  value="<?php echo $c->dataFin ?>" />
                                           <input  id="saida" name="saida" <?php echo $blocS ?> value="<?php echo $sai ?>"  class="span6"/>
                                           <?php echo $c_SaidaCad ?></td>
                                           <td>
                                           <input  id="entrada" name="entrada" <?php echo $blocE ?> value="<?php echo $ent ?>" class="span6"/>
                                           <?php echo $c_EntradaCad ?></td>

                                           <td>
                                          <select class="span6" id="t_Conta" name="t_Conta">   
                                            <option value = "<?php echo $c->tipo_Conta; ?>"><?php echo $c->tipo_Conta; ?></option>
                                            <option value = "Corrente">   Corrente</option>	
                                            <option value = "Suporte">    Suporte</option>
                                            <option value = "Poupança">   Poupança</option> 
                                            <option value = "Investimento">Investimento</option>
                                          </select>
                                          <?php if($par == 0) { ?>
                                          <select class="span6" id="t_ContaComb" name="t_ContaComb">   
                                            <option value = "<?php echo $c->tipo_Conta; ?>"><?php echo $c->tipo_Conta; ?></option>
                                            <option value = "Corrente">   Corrente</option>	
                                            <option value = "Suporte">    Suporte</option>
                                            <option value = "Poupança">   Poupança</option> 
                                            <option value = "Investimento">Investimento</option>
                                          </select>
                                           <?php  } ?>
                                            </td>
                                           <td style="<?php echo $corDif ?>"><?php echo $c->valorFin ?></td>
                                           <td>
                                                <a href="<?php echo base_url(); ?>index.php/vendas/editar/<?php echo $c->id_fin ?>" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Doação" target="_blank"><i class="icon-pencil icon-white"></i> Edit</a>
                                                
                                                <?php 
                                                $idUser = $this->session->userdata('id');
                                                if($ok == 1 && $ok2 == 1  && $idUser != 20) { }else 
                                                {
                                               if(($par != 1 || $corPar == "Yellow") && 1==1 || $idUser == 20)
                                               {?>
                                                <button class="btn btn-success"><i class="icon-play-circle icon-white" title="Executar lançamento combinado" ></i> Exec</button><?php }} ?>
                                                
                                            </td>
                                    <?php  echo "</tr>";
                                         
                                          $html .= '<td>'.$c->id_fin .' '.$c->dataFin.'</td>
                                           <td>'.$c->cod_assoc." | ".$c->cod_compassion .'</td>
                                           <td>'.$c->num_Doc_Banco .'</td>
                                           <td>'.$c->historico." | ".$c->descricao.'</td>  
                                           <td style="'.$corDif .'">'.$c->valorFin .'</td>
                                           </tr> ';
                                         
                                         
                                    if($par == 1) 
                                    {
                                            if($id_fin2 > 121170 && $cadastrante2 == 1 )$corId = "color:red" ;
                                        else $corId = "color:blue" ;
                                    ?>
                                           <tr bgcolor="<?php echo $corPar1 ?>">  
                                           <td  style="<?php echo $corId ?>"><?php echo $id_fin2 ?></td>
                                            <td><?php echo $dataFin2 ?></td>
                                            <td><?php echo $cod_assoc2." | ".$cod_compassion2 ?> </td>
                                            <td><?php echo $num_Doc_Banco2 ?></td>
                                            <td><?php echo $historico2." ( ".$par_ES2." )" ?></td>
                                            <td>
                                              <input type="hidden" name="id_fin2"  value="<?php echo $id_fin2 ?>" />
                                               <input type="hidden" name="ent_Sai2"  value="<?php echo $ent_Sai2 ?>" />
                                               <input  id="saida2" name="saida2" <?php echo $blocS2 ?> value="<?php echo $sai2 ?>" class="span6"/>
                                            <?php echo $c_SaidaCad2 ?></td>
                                            <td>
                                               <input id="entrada2" name="entrada2" <?php echo $blocE2 ?> value="<?php echo $ent2 ?>" class="span6"/>
                                            <?php echo $c_EntradaCad2 ?></td>
                                            <td>
                                          <select class="span12" id="t_Conta2" name="t_Conta2">   
                                            <option value = "<?php echo $tipo_Conta2; ?>"><?php echo $tipo_Conta2; ?></option>
                                            <option value = "Corrente">   Corrente</option>	
                                            <option value = "Suporte">    Suporte</option>
                                            <option value = "Poupança">   Poupança</option> 
                                            <option value = "Investimento">Investimento</option>
                                          </select>
                                            <td style="<?php echo $corDif2 ?>"><?php echo $valorFin2 ?></td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>index.php/vendas/editar/<?php echo $id_fin2 ?>" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Doação" target="_blank"><i class="icon-pencil icon-white"></i> Edit</a>
                                            </td></tr>
                                <?php 
                                    
                                    
                                          $html .= '<tr><td>'.$id_fin2.' '.$dataFin2.'</td>
                                           <td>'.$cod_assoc2." | ".$cod_compassion2 .'</td>
                                           <td>'.$num_Doc_Banco2.'</td>
                                           <td>'.$historico2.'</td>  
                                           <td style="'.$corDif2 .'">'.$valorFin2 .'</td>
                                           </tr> ';
                                    
                                    
                                    }  ?>  
                                </form> <?php 
                                         
                                        if(isset($similar) &&  $c->id_fin == $_SESSION['similares'])
                                        {
                                         
                                          foreach ($similar as $sm) 
                                          { 
                                          if( $prim == 1){ 
                                          ?>
                                            <tr bgcolor="#fccbcb" style="Yellow">   
                                           <td> <strong>Lançamento</strong></td>
                                           <td></td>
                                           <td> </td>
                                           <td> <strong>DOC</strong></td>
                                           <td> </td>
                                           <td> <strong>Conta</strong></td>
                                           <td> <strong>Destino</strong></td>

                                           <td> 
                                            <td ></td>
                                            <td>  
                                            </td></tr> 
                                            <?php $prim = 0; }?>
                                            <tr bgcolor="#fccbcb" style="Yellow">   
                                           <td><?php echo $sm->id_fin ?></td>
                                           <td><?php echo $sm->dataFin ?></td>
                                           <td><?php echo $sm->cod_assoc." | ".$sm->cod_compassion ?> </td>
                                           <td><?php echo $sm->num_Doc_Banco ?></td>
                                           <td><?php echo $sm->historico ?></td>
                                           <td>
                                           <?php echo $sm->conta." > ".$sm->nome_caixa ?></td>
                                           <td> 
                                            <?php
                                          foreach ($caixas as $cx) 
                                          { 
                                            if( $sm->conta_Destino == $cx->id_caixa) 
                                             echo $sm->conta_Destino." > ".$cx->nome_caixa; 
                                            } ?>
                                            </td>
                                           <td>
                                             <?php echo $sm->tipo_Conta; 
                                               if($sm->ent_Sai == 0) $corDif3 = "color:red"; else 
                                                   $corDif3 = "color:blue";  ?>
                                            <td style="<?php echo $corDif3 ?>"><?php echo $sm->valorFin ?></td>
                                            <td> Similar 
                                            <?php
                                                if($sm->id_fin == $_SESSION['similares']){}else
                                                { ?>
                                                    
                                                <a href="<?php echo base_url(); ?>index.php/vendas/editar/<?php echo $sm->id_fin ?>" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Doação" target="_blank"><i class="icon-pencil icon-white"></i> Edit</a>
                                                <?php
                                                }
                                            ?>
                                            </td></tr> <?php
                                             
                                         }
                                         }
                                     }
                                    }                                
                              }    
                          }
                            
                            if(isset($_SESSION['similares']))  unset($_SESSION['similares']);
                          ?>
                      </tbody>
                  </table>

                 <?php 
                
                                    
                      $html .= '</tbody></table>';
                
                
                }         
                    ?>
                  </div>

              </div>
                  <h5 style="text-align: right">Data do Relatório: <?php echo date('d/m/Y');?></h5>

          </div>

    <?php
              
                    $_SESSION['html'] = $html; 
     if(isset($_GET["excel"]))
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
            <?php }
              ?>


      </div>
</div>


  </body>
</html>