 <html> 
     <head>
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
           <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-list-alt"></i>
                    </span>
                    <h5>Relatórios Mensais</h5>
                </div>
                <div class="widget-content">
                    <form action="<?php echo base_url()?>index.php/relatorios/financeiro" method="post">
                        <div class="span12 well">
                        <div class="span3">
                            <?php    
                               ?>
                            <p class="conta">                    
                            <label for="conta">Conta</label>
                              <select  style="width:170px;"  id="conta" name="conta">
                             
                                <option value = "4">4 | TITOBECA</option>					
                                  </select>
                                <font color=red><span class="style1"> * </span></font>	                    
                            </p>
                        </div>
                        <div class="span2">             
                            <label for="conta">Ano</label>
                                      <?php 
                                      $ano =date("Y");
                                      $anoIni = 2009;
                                      ?>	
                                        <select style="width:100px;" id="ano" name="ano">
                                            <option value ='<?php echo $ano?>'><?php echo $ano ?></option>
                                            <?php --$ano;
                                                while($anoIni < $ano) {?>
                                            <option value = '<?php echo $ano ?>'><?php echo $ano?></option>										
                                            <?php --$ano;} ?>														
                                        </select><span class="style1">*</span>

                            </div>
                        <div class="span2">
                                    <label for="conta">Mês</label>	
                                      <?php
                                            $meses = array("", "janeiro", "fevereiro", "março", "abril",
                                            "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
                                            $data = date("m");
                                            $data <= 9 ? $data = $data[1] : $data = $data;
                                            ?>
                                            <select  style="width:100px;" id="mes" name="mes">
                                            <option value='<?php echo $data ?>'><?php echo ' '.$meses[$data] ?></option>
                                            <?php                                            
                                            for($i = 1; $i <= count($meses)-1; $i++) {
                                            $i == $data ? $valor = "selected" : $valor = "";
                                           // $i <= 9 ? $ii = "'0'.$i." : $ii = $i;
                                            ?>
                                            <option value='<?php echo $i ?>'><?php echo ' '.$meses[$i] ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>												
                                            <span class="style1">*</span>
                        </div>
                        <div class="modal-footer">
                            <div class="span6" style="margin-left: 0; text-align: center">
                                <button class="btn btn-success span4"><i class="icon-list-alt"></i> Relatório mensal</button>
                            </div>
                        </div>  
                        </div>
                        </form>
                        &nbsp
                    </div>
            </div>
    <?php
         if(isset($_SESSION['adminSal'] )) $adminSal = $_SESSION['adminSal']; else $adminSal = "cod_compassion";
          unset($_SESSION['tipoPesquisa']);    
  
          
     {
       $html = '';
       if(isset($_SESSION['dataInicial']))
        $dataInicial =  $_SESSION['dataInicial']; else $dataInicial = date("Y-01-01");
       if(isset($_SESSION['dataFinal']))
        $dataFinal =  $_SESSION['dataFinal']; else $dataFinal = date("Y-12-31");
       $datXX = $dataInicial;
    ?>       
       <div class="widget-box">
         <div ><?php //var_dump($somaMeses[0]->tr); ?>
                 <div class="span10">


                        <?php
                        $totalFaturas = $totalLimites = $qtdTot = $somaTotFundoPrevG = 0; $i= 0;
                        $saldoAtual = 0;
                  //  foreach ($somaMeses as $rSoma) 
                    { $i++; 
$rSoma = $somaMeses;
                     ?>

                     <?php 
                        if  ($i == 1) {?>                         
                        <div >
                            <div class="widget-title">
                                <span class="icon"></span>
                            <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="15%">MÊS</th>
                                            <th width="40%">SALDO</th>
                                            <th width="15%">ENTRADAS</th>
                                            <th width="15%">SAI (CRÉDITO)</th>
                                            <th width="15%">SAI (DÉBITO)</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div> 
                        </div> 
                       <?php 
                        }?>                        
                        <div >
                            <div class="widget-title">
                            <table class="table table-bordered">
                                    <thead>
                                       <tr>                 
                                           <th width="15%"><font color=black><H4><?= date('M/Y', strtotime($rSoma->dataI))?></H4></font></th>
                                           <?php $sm = $rSoma->tr-($rSoma->tdD+$rSoma->tdC); 
                                           $crS = $sm < 0 ? "red" : "blue"; ?>
                                           <th width="40%"><font color="<?= $crS ?>" ><H4><?=number_format($sm, 2, ',', '.')?></H4></font></th> 
                                           <th width="15%"><font color="#3252db"><H4><?=number_format($rSoma->tr, 2, ',', '.')?></H4></font></th>      
                                           <th width="15%"><font color="#d65b5b"><H4><?=number_format($rSoma->tdC, 2, ',', '.')?></H4></font></th> 
                                           <th width="15%"><font color=d65b5b><H4><?=number_format($rSoma->tdD, 2, ',', '.')?></H4></font></th> 
                                       </tr>
                                    </thead>
                                </table>
                                
                            </div> 
                        </div>          
                        <div >
                            <div  >
                              <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Dta</th>
                                                <th>Fundo Financeiro</th>
                                                <th>Descrição</th>
                                                <th>ENTRADAS</th>
                                                <th colspan="2">SAÍDAS</th>
                                                <th>SALDOs</th>
                                            </tr>
                                        </thead>
                                <body>
                                 <?php       
                                            //   var_dump($lancFuturos);
                                foreach ($lanc as $rF) 
                                { 
                                    if(($rF->cod_assoc != 'D-BT' && $rF->num_Doc_Banco == '0/0') || $rF->cod_assoc == 'D-BT'  || $rF->cod_assoc == 'C-ALT' )
                                    {
                                       $status = $rF->num_Doc_Fiscal;
                                       $corStatus = $status == 'Previsto' ? "#d15609" : "#10a527";
                                    if( date('m/Y', strtotime($rF->dataFin)) == date('m/Y', strtotime($rSoma->dataI))){
                                        $debdNum = $credNum = $entradNum = ''; 
                                        if($rF->ent_Sai == 0)
                                        {
                                            $saldoAtual -= $rF->valorFin;
                                            if($rF->cod_assoc != 'D-BT') 
                                                {
                                                    $credNum = number_format($rF->valorFin, 2, ',', '.'); 
                                                }else{
                                                        $debdNum = number_format($rF->valorFin, 2, ',', '.');
                                                    }
                                        }else
                                            {
                                                $saldoAtual += $rF->valorFin;
                                                $entradNum = number_format($rF->valorFin, 2, ',', '.');
                                            }
                                            $status != 'Previsto' ? 
                                            ($corSaldo = $saldoAtual < 0 ? 'red' : 'blue') :  
                                            ($corSaldo = $saldoAtual < 0 ? "#f78b48" : "#3f6acb");
                                            $saldoAtualText = number_format($saldoAtual, 2, ',', '.');
                                        ?> 
                                   <tr>                 
                                       <th width="15%">
                                           <font color=blue><?=date('d/m/Y', strtotime($rF->dataFin))?></font>
                                           <font color='<?=$corStatus?>'><?=$status?></font> 
                                       </th>      
                                       <th width="20%"><font color=green><?=$rF->descricao_Ass ?></font></th> 
                                       <th width="20%"  style="background:<?=$corStatus?>"><font color=green>
                                                 <?php
                                                if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
                                                    echo '<a style="margin-right: 1%" href="'.base_url().'index.php/vendas/visualizar/'.$rF->id_fin.'" target="_blank" class="btn tip-top" title="Ver mais detalhes">'.$rF->descricao.'</a>'; }?></font></th> 
                                       <th width="15%"><font color=blue><H5><?=$entradNum?></H5></font></th>
                                       <th width="15%"><font color=red><H5><?=$credNum?></H5></font></th>
                                       <th width="15%"><font color=red><H5><?=$debdNum?></H5></font></th> 
                                       <th width="15%" style="text-align: right"><font color='<?=$corSaldo?>'><H5><?=$saldoAtualText?></H5></font></th> 
                                   </tr>

                                  <?php } }     
                                }?>
                                </body>
                             </table>
                            </div>
                        </div>
                        <?php 
                    }  ?> 
                </div>
            </div>
              
      </div>
                       
    <?php
         }
    ?>       
</div>


     </body>
</html>