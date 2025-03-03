<?php

class Vendas extends CI_Controller {
    

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    /*
                'conta'         => $caixa,
                'tipo_Conta'    => $tipoCont,
                'cod_compassion'=> CENTRO DE CUSTO,
                'cod_assoc'     => FUNDO FINANCEIRO,
                'num_Doc_Banco' => PARCELA ATUAL / TOTAL,
                'num_Doc_Fiscal'=> $numDocFiscal,
                'historico'     => $razaoSoc,
                'descricao'     => $descri,
                'dataFin'       => $dataF,
                'valorFin'      => $valorFin,
                'ent_Sai'       => $ent_Sai,
                'tipo_Pag'      => TIPO PERIODICIDADE,
                'conta_Destino' => QTD PARCELAS,
                'saldo'         => $saldo_Final,
                'saldo_Mes'     => 'S',
                'cadastrante'   => $cadastrante
                'par_ES'        => LANÇAMENTO PAI
    */
    
    function __construct() {
        parent::__construct();
        
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('vendas_model','',TRUE);
		$this->data['menuVendas'] = 'Vendas';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar lançamentos.');
           redirect(base_url());
        }

        $this->load->library('pagination');
        
        $where_array = array();
        $status = $stat = '';

        $arrpgn = explode("/", $_SERVER["PATH_INFO"]);
        if(isset($arrpgn[3]))
        {
            if(isset($_SESSION['centro']))
                $status = $_SESSION['centro'];
            if(isset($arrpgn[3]))
                $stat = $_SESSION['status'];
        }
        
        if(null != $this->input->get('centro'))
            $status = $this->input->get('centro');
        if(null != $this->input->get('status'))
            $stat = $this->input->get('status');
        
        $cod = $this->input->get('cod');
        $pesquisa = $this->input->get('pesquisa');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');
        $_SESSION['data'] = $de;
        $_SESSION['data2'] = $ate;
        
        $this->data['pesquisa'] = $pesquisa;
        $this->data['centro'] = $status;
        $this->data['status'] = $stat;
        $this->data['data'] = $de;
        $this->data['data2'] = $ate;
        $count = 20;
        if($cod){
           $where_array['cod'] = $cod;
        $count = 30;
        }
        if($pesquisa){
           $where_array['pesquisa'] = $pesquisa;
        $count = 100;
        }
        if($status){
            $where_array['status'] = $status;
        $count = 100;
        }
        if($de){
            $de = explode('/', $de);
            $de = $de[2].'-'.$de[1].'-'.$de[0];
            $where_array['de'] = $de;
        $count = 100;
        }
        if($ate){
            $ate = explode('/', $ate);
            $ate = $ate[2].'-'.$ate[1].'-'.$ate[0];
            $where_array['ate'] = $ate;
        $count = 100;
        }
        
        $config['base_url'] = base_url().'index.php/vendas/gerenciar/';
        $config['total_rows'] = $this->vendas_model->count('aenpfin');
        $config['per_page'] = $count;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        	
        $this->pagination->initialize($config); 
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        
        $user = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        
        $contaU = $user->conta_Usuario;
        ///* AJUSTES DESCRIÇÃO FATURA MES ANO
//            $rFaturas = $this->vendas_model->get0('aenpfin','*',$this->uri->segment(3));
//            $this->data['rFaturas'] = $rFaturas;        
//         $meses = array('01'=>"Jan",'02'=>"Fev",'03'=>"Mar",'04'=>"Abr",'05'=>"Mai",'06'=>"Jun",'07'=>"Jul",'08'=>"Ago",'09'=>"Set",10=>"Out",11=>"Nov",12=>"Dez" );                       
//             foreach ($rFaturas as $rF)
//                 {      
//                     $id_finUp = $rF->id_fin;
//                     
//                        $mes =  date('m', strtotime($rF->dataFin));
//                        $ano =  date('Y', strtotime($rF->dataFin));
//                        $descricaoFatura =  'Fatura ('.$meses[$mes].'/'.$ano.')';
//                        $dataUp = array( 'descricao' => $descricaoFatura ); 
//                        if ($this->vendas_model->edit('aenpfin', $dataUp, 'id_fin', $id_finUp) == TRUE) { }
//                   
//                 }
        
            $resultsAux2 = $this->vendas_model->get3('aenpfin','dataFin'); 
            $resultsAux = $this->vendas_model->get('aenpfin','*',$where_array,$config['per_page'],$this->uri->segment(3)); 
//            $this->data['results'] = $results; 
                       
     //   $this->data['resultsAux1'] = $resultsAux1;
            $resultsAgrupados = array(); 
            $utilizados = array();       
             foreach ($resultsAux as $rA)
                 {   
                 if(in_array($rA->id_fin, $utilizados) || $rA->num_Doc_Banco == '0/0')
                 {              }else
                 {
                    $grupo = ''; $previsto = 0;
                     foreach ($resultsAux2 as $rA2)
                         { 
                            if($rA->par_ES == $rA2->par_ES && $rA2->num_Doc_Banco != '0/0' && $rA->par_ES != NULL)
                            {     
                                $previsto = $rA2->num_Doc_Fiscal == 'Previsto' ? 1 : $previsto;                           
                                $corstatus1 = $rA2->num_Doc_Fiscal == 'Previsto' ? 'red' : 'blue';                                 
                                $separador = $grupo == '' ? $rA2->historico.', '.substr($rA2->descricao,0,-10).', <br>' : '';
                                $item = $separador.'<a href="'.base_url().'index.php/vendas/visualizar/'.$rA2->id_fin.'"> '.$rA2->num_Doc_Banco.' </a> '.', '.substr($rA2->descricao,-10).', '.date('d/m/Y', strtotime($rA2->dataFin)).', <font color="'.$corstatus1.'"><STRONG>'.$rA2->num_Doc_Fiscal.'</STRONG></font>, '.$rA2->id_fin.'<br>';
                              // $item = $separador.$rA2->id_fin.', '.$rA2->num_Doc_Banco.', '.substr($rA2->descricao,-10).', '.date('d/m/Y', strtotime($rA2->dataFin)).', '.$rA2->num_Doc_Fiscal;
                                $grupo .=$item;
                                array_push($utilizados,$rA2->id_fin);
                            }
                     }$rA->par_ES .= '<br>';
                     $rA->historico = $grupo == '' ? $rA->historico.', '.$rA2->descricao : $grupo;
                     switch ($stat)
                            {						    
                                case 1:	if($previsto == 1) $resultsAgrupados[] = $rA;	break;    
                                case 2:	if($previsto == 0) $resultsAgrupados[] = $rA;	break; 
                         default	:               
                                    $resultsAgrupados[] = $rA;	
                            }
                     
                   }
                 }
        
        $this->data['results'] = $resultsAgrupados;
//        var_dump($resultsAgrupados);
//            $resultsAgrupados = $this->vendas_model->get('aenpfin','*',$where_array,200,$this->uri->segment(3));  
               
        
        if(!$de){ 
            $dia1 = date("Y-m-d");
            $where_array['de'] = date('Y-m-d', strtotime("- 5 day", strtotime($dia1)));
            $where_array['ate'] = date('Y-m-d', strtotime("+1 month", strtotime($dia1)));
        }
            $this->data['resultsMes'] = $this->vendas_model->get('aenpfin','*',$where_array,$config['per_page'],$this->uri->segment(3));

        $this->data['result_codComp'] = $this->vendas_model->get2('cod_compassion');
        $this->data['result_codIead'] = $this->vendas_model->get2('cod_assoc');
        $this->data['result_caixas'] = $this->vendas_model->get2('caixas');        
        $this->data['anexos'] = $this->vendas_model->get2('anexos');                
//        $this->data['presentesEsp'] = $this->vendas_model->get2('presentes_especiais');
// Alterar toda coluna de data de Emissão
        /*
        $reconc = $this->vendas_model->get2('reconc_bank');
        
        foreach ($reconc as $rc) 
        {
            if($rc->status == 0)
            $dataEmiss = $rc->data_Pag; else  $dataEmiss = date('Y-m-d', strtotime($rc->data_Pag. ' -7 days')); 
            $data = array(
                'data_Emissao' => $dataEmiss
            );
        
        
        if ($this->vendas_model->edit('reconc_bank', $data, 'id_reconc', $rc->id_reconc ) == TRUE)
        {
            
        }
            }
        */
        
          
		if(null !==  $this->input->post('idLanc')){
            $idlanc = $this->input->post('idLanc');
            $this->data['result_A'] = $this->vendas_model->getById($this->input->post('idLanc'));
            }
        
	    $this->data['view'] = 'vendas/vendas';
       	$this->load->view('tema/topo',$this->data);
     
       
		
    }
	
    function adicionar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Vendas.');
          redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';        
        $conta   = $this->input->post('conta');
        $t_conta = $this->input->post('tipCont');        
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $datainicioLimite = '2020-01-01';
        if ($this->input->post('numDocFiscal') != null)
        if ($this->form_validation->run('vendas') == false) 
        {
           $this->session->set_flashdata('error','Falha na verificação');
           $this->data['custom_error'] = (validation_errors() ? true : false);
        
            if ($this->input->post('conta') !== null ) {
                $contta = $this->input->post('conta');
            }
        } 
        else {
            $user_id = $this->vendas_model->getByIdUser($this->session->userdata('id'));
            $permissoes_id = $user_id->permissoes_id;
            
            $dataVendaSecion = $this->input->post('dataVenda');
            $dataVenda = $this->input->post('dataVenda');
            try {                
             //   echo $dataVenda;
                $dataVenda     = explode('/', $dataVenda);
                $dataF    = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];          
                
           } catch (Exception $e) {
               $dataF = date('Y/m/d');  
            }
            
            include 'apoio/funcao.php';
//****** VARIAVEIS RECEBIDAS******
             //{ 
                $caixa         = $this->input->post('conta');
                $tipoCont      = $this->input->post('tipoCont');								
                $fundoFin      = $this->input->post('fundoF');
                $cod_compassion = $this->input->post('cCustos');
                $num_Doc       = $this->input->post('numeroDoc');
                $numDocFiscal  = $this->input->post('numDocFiscal');
                $razaoSoc      = $this->input->post('razaoSoc');
                $descri        = $this->input->post('descricao');
                $saldo_Final   = $this->input->post('saldo_Atual');
                $diaUm_mêsAtual = $this->input->post('diaUm_mêsAtual');
                $valorFin      = $this->input->post('valorFin');
                if(null !== (  $this->input->post('v_Valores') )) {  $v_Valores = $this->input->post('v_Valores'); }
                $pular = null !== (  $this->input->post('pular') ) ? 1 : 0; 
                $tipo_Pag     = $this->input->post('tipoPag');
                $ent_Sai       = $this->input->post('tipoES');//Código para ENTRADA  é ( 1 ) para SAÍDA  é ( 0 )
                $conta_Destino = $this->input->post('conta_Destino');//Registra Qual a conta beneficiada pelo  lançamento                 
                $cadastrante   = $this->input->post('cadastrante');
                $dia = date('Y-m-d');
                  if($ent_Sai == 0) $entrada_Saida = "saída";
                        else if($ent_Sai == 1) $entrada_Saida = "entrada";
                $saldo_mes_lancamento = 'S';
                $tip_Cont      = $tipoCont;
                $contaX        = $caixa;
                $saldo_AtualConsult  = $this->input->post('saldo_AtualConsult');
                if(null !== ( $this->input->post('qtd_presentes'))) {$qtd_presentes = $this->input->post('qtd_presentes');}else {$qtd_presentes = 0;}
                if(null !== ( $this->input->post('presentes'))) $id_presentes = ($this->input->post('presentes'));
                if(null !== ( $this->input->post('id_presentes'))) $id_presentes =  ($this->input->post('id_presentes'));	
                if(null !== (   $this->input->post('senhaAdm') )) {  $senhaAdm  = $this->input->post('senhaAdm');} 
                $p_Origem = base_url().'index.php/vendas/adicionar';  
                
                
                    $fundoF = ($this->vendas_model->getByIdChek('cod_assoc','cod_Ass',$fundoFin));
                $diaVenc   = $fundoF->cont_Contabil;
                $diaMelhor = $fundoF->ent_SaiAss;
                $descricao_Ass = $fundoF->descricao_Ass;
                $cred_deb   = $fundoF->area;
                $tipo_Pag   = $cred_deb != 'CRÉDITO' ? $tipo_Pag : 'Parcelado';
            
            $lancamento = array(
                'conta'         => $caixa,
                'tipo_Conta'    => $tipoCont,
                'cCustos'       => $cod_compassion,
                'fundoF'        => $fundoFin,
                'num_Doc_Banco' => $num_Doc,
                'num_Doc_Fiscal'=> $numDocFiscal,
                'historico'     => $razaoSoc,
                'descricao'     => $descri,
                'dataFin'       => date('d/m/Y', strtotime($dataF)),
                'valorFin'      => $valorFin,
                'ent_Sai'       => $ent_Sai,
                'tipo_Pag'      => $tipo_Pag,
                'conta_Destino' => $conta_Destino,
                'saldo'         => $saldo_Final,
                'cadastrante'   => $cadastrante
            ); 
               $_SESSION['lancamento'] = $lancamento;
            
 //*******Verifica se o valor foi digitado adequadamente.
            {
                     if(formatoRealPntVrg($valorFin) == true) 
               {//Verific se o numero digitado é com (.) milhar e (,) decimal
                   //serve pra validar  valores acima e abaixo de 1000
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    $valorFin;   
                   $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
               }else if(formatoRealInt($valorFin) == true)
               {//Verific se o numero digitado é inteiro sem ponto nem virgula
                   //serve pra validar  valores acima e abaixo de 1000
                   //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                   $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
               }else if(formatoRealPnt($valorFin) == true)
               { 
                   //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                   $valorFin  =    $valorFin;
                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
               }else if(formatoRealVrg($valorFin) == true)
               { 
                 //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                   $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
               }else
               {
                   echo "O valor digitado não esta nos parametros solicitados";
                          echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                        <script type=\"text/javascript\">
                                        alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
                                        </script>";	
                      exit;  


               }
            }

                $dia = date('Y-m-d');
                $entrada_Saida = $ent_Sai;
                $saldo_mes_lancamento = 'S';
                $tip_Cont      =  $tipoCont;
                $contaX        = $caixa;
                $_SESSION['saldo_AtualConsult']  = $this->input->post('saldo_AtualConsult');
                if(null !== (   $this->input->post('senhaAdm') )) {  
                    $_SESSION['senhaAdm']  = $this->input->post('senhaAdm');} 
            
                    $id_Maxaenp = ($this->vendas_model->getMaxId('aenpfin','id_fin')->maxId)+1;
            $data = array(
                'conta'         => $caixa,
                'tipo_Conta'    => $tipoCont,
                'cod_compassion'=> $cod_compassion,
                'cod_assoc'     => $fundoFin,
                'num_Doc_Banco' => $num_Doc,
                'num_Doc_Fiscal'=> $numDocFiscal,
                'historico'     => $razaoSoc,
                'descricao'     => $descri,
                'dataFin'       => $dataF,
                'dataEvento'    => $dataF,
                'valorFin'      => $valorFin,
                'ent_Sai'       => $ent_Sai,
                'tipo_Pag'      => $tipo_Pag,
                'conta_Destino' => $conta_Destino,
                'saldo'         => $saldo_Final,
                'saldo_Mes'     => 'S',
                'par_ES'        => $id_Maxaenp,
                'cadastrante'   => $cadastrante
            ); 
 //***** VERIFICAÇÕES PARA LANÇAMENTO           
            {
                $p_Origem = base_url().'index.php/vendas/adicionar';
                $contar = 1;
                    while (($contar <= $qtd_presentes) ) 
                        {
                            $nome = 'nome'.$contar;
                            $CodigoIdId = 'Codigo'.$contar;
                            $Protocolo = 'Protocolo'.$contar;
                            $valorPre = 'valorPre'.$contar;
                            $entraSai = 'entraSai'.$contar;
                          //  $_SESSION[$nome] = $_POST[$nome];
                            $_SESSION[$CodigoId]	= $_POST[$CodigoId];								
                            $_SESSION[$Protocolo] = $_POST[$Protocolo];
                            $_SESSION[$valorPre] = $_POST[$valorPre];	
                            $_SESSION[$entraSai] = $_POST[$entraSai];	

                            $contar = $contar+1;							

                        }
                {
                if(!$fundoF || !$cod_compassion)
                { echo 'O Cetntro de Custo e Fundo Financeiro não Foram identificados.
                                    Volte a pagina anterior e preencha todos os campos! Caixa '.$lancamento[$caixa].$caixa.' tipo '.$lancamento[$tipoCont].' C comp '.$lancamento[$cod_compassion].' doc '.$lancamento[$num_Doc].'- Cod ASS  '.$lancamento[$numDocFiscal].' '.$numDocFiscal.' - R soc '.$lancamento[$razaoSoc].' '.$razaoSoc.' '.$fundoF.' - cod Comp '.$cod_compassion.' - tipo pag '.$lancamento[$tipo_Pag].' - ent sai '.$lancamento[$ent_Sai].' - '.$lancamento[$cadastrante].' ent sai '.$lancamento[$entrada_Saida].' '.$lancamento[$tip_Cont].' qtd pres '.$lancamento[$qtd_presentes].' ';
                  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                    <script type=\"text/javascript\">
                                    alert(\"O Cetntro de Custo e Fundo Financeiro não Foram identificados. Volte a pagina anterior e preencha todos os campos! - Linha: ". __LINE__ . "\");
                                    </script>";						  
                 exit; 
                }
                // echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
                $faltaCampo = "";

                if(!$caixa  ) $faltaCampo .= "Conta, ";
                if(!$tipoCont ) $faltaCampo .= "tipoCont, ";
                if(!$num_Doc ) $faltaCampo .= "num_Doc, ";
                if(!$numDocFiscal) $faltaCampo .= "numDocFiscal, ";
                if(!$razaoSoc) $faltaCampo .= "razaoSoc, ";
                if(!$dataF) $faltaCampo .= "dataF, ";
                if(!$valorFin ) $faltaCampo .= "valorFin, ";
                if(!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin )
                {
                    echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
                echo "<p><font color=red>Voce nao entrou com os dados necessarios.
                        Você não informou todos os dados nescessário. Tente novamente!</font</p>";
                  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                    <script type=\"text/javascript\">
                                    alert(\" Você não informou todos os dados nescessário. ".$faltaCampo." Tente novamente! Linha: ". __LINE__ . "\");
                                    </script>";	
                 // exit;  
                }	//URL=PaginaLancamento1.php
                
                $datahj = date('Y-m-d');
                $data_R = date('Y-m-d', strtotime("-6 month", strtotime($datahj)));
                if($permissoes_id < 3 && $dataF > $data_R)  $senhaAdm = "aenp@z18";
                if(!(isset($senhaAdm))){ $senhaAdm = "0000";}else if($senhaAdm == "vid@18") $senhaAdm = "aenp@z18";
                //echo $datahj;
                //	$dataF= implode('-',array_reverse(explode('/',$data)));
                $data_001 =  primeiroDiaMes($datahj);								
                $data_007 =  setimoDiadoMes($datahj);
            if($dataF < $datainicioLimite)
                {
                             echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
                             echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                        <script type=\"text/javascript\">
                                        alert(\" A data não é uma data válida, tente novamente! Linha: ". __LINE__ . "\");
                                        </script>";	
                      exit;  
                            }
                }
            }
//******Verifica se existem parcelas a acrescentar
                {
                    $maxId = ($this->vendas_model->getMaxId('aenpfin','id_fin')->maxId);
                    $maxId++;
                    $data['par_ES'] = $maxId;
                    $meses = array('01'=>"Jan",'02'=>"Fev",'03'=>"Mar",'04'=>"Abr",'05'=>"Mai",'06'=>"Jun",'07'=>"Jul",'08'=>"Ago",'09'=>"Set",10=>"Out",11=>"Nov",12=>"Dez",
                    );                    
                   $adicionado = 0;
                if($tipo_Pag == "Eventual")$parcelas =1;else{
                   $parcelas = $tipo_Pag != "Fixo" ? $conta_Destino : 18;}
                    
                    if($tipo_Pag == "Parcelado"){
                        $mesmoMes = $diaMelhor < $diaVenc ? 1 : 0;
                        $mesmoMes = $diaMelhor  != "0" ? $mesmoMes : 1;    
//                        $dataF0 = date('Y-m-d', strtotime("-1 month", strtotime($dataF)));
//                        $dataF1 = date('Y-m-d', strtotime("+1 month", strtotime($dataF)));
                        $mesAnoLancamento = date('Y-m',  strtotime($dataF));                        
                        $diaMelhorText = $diaMelhor < 10 ? '0'.$diaMelhor : $diaMelhor;
                        $diaMelhorText = $diaMelhorText == '00' ? '01' : $diaMelhorText;
                        $dataMelhor = $mesAnoLancamento."-".$diaMelhorText;                        
                        
                        $diaVencText = $diaVenc < 10 ? '0'.$diaVenc : $diaVenc;
                        $diaVencText = $diaVencText == '00' ? '01' : $diaVencText;                        
                        $dataVencimento = $mesAnoLancamento."-".$diaVencText;
                        
                        if($dataF >= $dataMelhor){
                            $dataI = $mesmoMes == 1 ? date('Y-m-d',strtotime("+1 month", strtotime($dataVencimento))) : date('Y-m-d',strtotime("+2 month", strtotime($dataVencimento)));
                        }else
                        {
                            $dataI = $mesmoMes == 1 ? date('Y-m-d', strtotime($dataVencimento)) : date('Y-m-d',strtotime("+1 month", strtotime($dataVencimento)));
                        }
                        
                        if($diaMelhor != "0"){
                            $dataParcela = $dataI;
                            $dataI = $pular == 0 ? $dataI : date('Y-m-d',strtotime("+1 month", strtotime($dataI))) ;
                            $data['dataFin'] = $dataI;
                            $faturaText = 'Fatura';
                            $faturaCod = 'D10-01';
                        }else{ //   SE LANÇAMENTO FOR CRÉDITO BANCÁRIO - EMPRESTIMO
                            if($dataF >= $dataMelhor){
                                $dataParcela = $mesmoMes == 1 ? date('Y-m-d',strtotime("+1 month", strtotime($dataF))) : date('Y-m-d',strtotime("+2 month", strtotime($dataF)));
                            }else
                            {
                                $dataParcela = $mesmoMes == 1 ? date('Y-m-d', strtotime($dataF)) : date('Y-m-d',strtotime("+1 month", strtotime($dataF)));
                            }
                            $dataI = $pular == 0 ? $dataI : date('Y-m-d',strtotime("+1 month", strtotime($dataI))) ;
                            $dataParcela = $pular == 0 ? $dataParcela : date('Y-m-d',strtotime("+1 month", strtotime($dataParcela))) ;
                            $data['dataFin'] = $dataParcela;
                            $faturaText = 'Fatura Emprestimos';
                            $faturaCod = 'D10-07';
                        }
//                        var_dump($faturaText);
//                        var_dump($faturaCod);
//                        var_dump($dataF);
//                        var_dump($dataF);
//                        var_dump($diaMelhor);
//                        var_dump($dataMelhor);
//                        var_dump($dataVencimento);
//                        var_dump($dataI);
//                         die;
                    }
                    $dataFatura = array(
                        'conta'         => $caixa,
                        'tipo_Conta'    => $tipoCont,
                        'cod_compassion'=> $faturaCod,
                        'cod_assoc'     => $fundoFin,
                        'num_Doc_Banco' => '0/0',
                        'num_Doc_Fiscal'=> 'Previsto',
                        'historico'     => $descricao_Ass,
                        'descricao'     => $faturaText,
                        'dataFin'       => $dataI,
                        'dataEvento'    => $dataI,
                        'valorFin'      => $valorFin,
                        'ent_Sai'       => $ent_Sai,
                        'tipo_Pag'      => $tipo_Pag,
                        'conta_Destino' => 0,
                        'saldo'         => $saldo_Final,
                        'saldo_Mes'     => 'S',
                        'par_ES'        => $id_Maxaenp,
                        'cadastrante'   => $cadastrante,
                        'par_ES'        => null
                    ); 
//                    var_dump($fundoFin, $dataMelhor,$data['dataEvento'],$data['dataFin']); exit;;
                    for( $i=1; $i<=$parcelas; $i++)
                    {
//                    var_dump($data['dataFin']);
//                    exit;
                        $data['num_Doc_Banco'] = $tipo_Pag == "Parcelado" ? $i.'/'.$parcelas : '1';
                       if($i != 1){
                        $dataI =  date('Y-m-d', strtotime("+1 month", strtotime($dataI)));
                        $data['dataFin'] =  date('Y-m-d', strtotime("+1 month", strtotime($data['dataFin'])));
                        }
                       if($data['dataFin'] > date('Y-m-d'))
                        $data['num_Doc_Fiscal'] =  "Previsto";
                       
                       $mes =  date('m', strtotime($data['dataFin']));
                       $ano =  date('Y', strtotime($data['dataFin']));
                       $data['descricao'] =  $descri.' ('.$meses[$mes].'/'.$ano.')';
                        $ok = true;
                        if($cred_deb == 'CRÉDITO')
                            {
                                $faturaMes = $this->vendas_model->getFaturaMes('aenpfin',$fundoFin,'*',$mes,$ano);
                                if(!empty($faturaMes))
                                {
                                    if($faturaMes->num_Doc_Fiscal == 'Efetuado')
                                    { 
                                        $data['num_Doc_Fiscal'] = 'Efetuado';
                                        $compleFaturaMes = $this->vendas_model->getByIdComplemento($faturaMes->id_fin);
                                        if(!empty($compleFaturaMes))
                                        {
                                            if($compleFaturaMes->valorFin < $valorFin)
                                                $ok = false; 
                                        }                                        
                                    }
                                }
                            }
                       $textErro = '';
//                    die;
//******Insere o lançamento na tabela aenpfin*********   descricao  
                      if($ok == true){ 
                        if (is_numeric($id = $this->vendas_model->add('aenpfin', $data, true)))
//                            if(1==1)
                        {    
                            if($cred_deb == 'CRÉDITO')
                            {
                                $field = 'id_fin,valorFin,num_Doc_Fiscal';
                                // Busca o lançamento da fatura do mês deste cartão e se existir acrescenta o valor. Se não, cria.
                                $faturaMes = $this->vendas_model->getFaturaMes('aenpfin',$fundoFin,$field,$mes,$ano);
                                if(!empty($faturaMes))
                                {
                                    if($faturaMes->num_Doc_Fiscal == 'Previsto')
                                    {
//                                        $aqui = 1;
                                        $id_finUp = $faturaMes->id_fin;
                                        $valorFinUp = $faturaMes->valorFin + $valorFin;
                                        $dataUp = array( 'valorFin' => $valorFinUp ); 
                                        if ($this->vendas_model->edit('aenpfin', $dataUp, 'id_fin', $id_finUp) == TRUE) { }
                                    }else{
//                                        $aqui = 2;
                                        $compleFaturaMes = $this->vendas_model->getByIdComplemento($faturaMes->id_fin);
                                         if(!empty($compleFaturaMes))
                                         {
                                            $id_finUp = $compleFaturaMes->id_fin;
                                            $valorFinUp = $compleFaturaMes->valorFin - $valorFin;
                                            $dataUp = array( 'valorFin' => $valorFinUp ); 
                                            if ($this->vendas_model->edit('aenpfin', $dataUp, 'id_fin', $id_finUp) == TRUE) { }
                                        } 
                                        
                                    }
//                                    var_dump($aqui, ' Aqui ');
//                                    var_dump($faturaMes);
//                                    var_dump( ' valorFinUp ',$valorFinUp);
//                                    die();
                                }else
                                {
//                                    die();
                                    $dataFatura['cod_compassion'] = $faturaCod;
                                    $dataFatura['valorFin'] = $valorFin;
                                    $dataFatura['dataFin'] = $dataI;
                                    $dataFatura['descricao'] =  $faturaText.' ('.$meses[$mes].'/'.$ano.')';
                                    if (is_numeric($id = $this->vendas_model->add('aenpfin', $dataFatura, true)) ) 
                                    { }
                                }
                            }
                         //   var_dump($i); 
        //****** Resgata o ID do lançamento feito
                            $adicionado++;
                        }
                      }else $textErro = 'Valor do lançamento é maor que a fatura fechada.';
                        
                    }
                    
                   if($adicionado > 0)
                    {
                       $this->session->set_flashdata('success','Lançamento efetuado com sucesso! '.$descri.' - em '.$razaoSoc.' . | '.$data['num_Doc_Banco'].' <strong>Adicione o ANEXO do documento fiscal.</strong> ');  
                        redirect(base_url() . 'index.php/vendas/');
                    }else 
                    {                
                            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.  '.$textErro.'</p></div>';
                        }
                }
           
        }
          
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $this->data['result_caixas']    = $this->vendas_model->get2('caixas');
        $this->data['resultUltimo']     = $this->vendas_model->getIdultimo($conta, $t_conta);
        $this->data['resultss_Benefic']   = $this->vendas_model->get3('clientes','nomeCliente','celular');
        $this->data['result_codComp']   = $this->vendas_model->get3('cod_compassion','area_Cod');
        $this->data['result_codIead']   = $this->vendas_model->get3('cod_assoc','cod_Ass','ent_SaiAss');
        $this->data['pre']              = $this->vendas_model->getPresentes($conta);
        $this->data['view']             = 'vendas/adicionarVenda';
        $this->load->view('tema/topo', $this->data);
    }     
    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Lançamento');
          redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->input->post('numDocFiscal') != null)
        if ($this->form_validation->run('vendas') == false) {
           $this->session->set_flashdata('error','Falha na verificação'.validation_errors());
           $this->data['custom_error'] = (validation_errors() ? true : false);        
        }else 
        {        
            $user_id = $this->vendas_model->getByIdUser($this->session->userdata('id'));
            $permissoes_id = $user_id->permissoes_id;        
                $conta          = $this->input->post('conta');        
            $datainicioLimite = '2022-01-01';        
        if ($this->input->post('numDocFiscal') != null)
        {
            
            include 'apoio/funcao.php';
            require_once 'apoio/conexao.class.php';
           // require_once 'funcao.php';
            $con = new Conexao();
			$con->connect(); $conex = $_SESSION['conex'];
            $p_Origem = base_url() . 'index.php/vendas/editar/'.$this->input->post('id_fin');
            
                $fundoFAnterior        = $this->input->post('fundoFAnterior');
                $numDocFiscalAnterior  = $this->input->post('numDocFiscalAnterior');
                $dataVendaAnterior     = $this->input->post('dataVendaAnterior');
                $valorFinAnterior      = $this->input->post('valorFinAnterior');
                $id_fin         = $this->input->post('id_fin');
                $caixa          = $this->input->post('conta');
                $tipoCont       = $this->input->post('tipo_Conta');
                $cod_compassion = $this->input->post('cCustos');			
                $fundoF      = $this->input->post('fundoF');
                $num_Doc        = $this->input->post('numeroDoc');
                $numDocFiscal   = $this->input->post('numDocFiscal');
                $razaoSoc       = $this->input->post('razaoSoc');
                $descri         = $this->input->post('descricao');
                $valorFin       = $this->input->post('valorFin');
                $ent_Sai        = $this->input->post('ent_Sai');
                $tipo_Pag       = $this->input->post('tipoPag');
                $conta_Destino  = $this->input->post('conta_Destino');
                $dataFin        = $this->input->post('dataVenda');
                $dataEvento        = $this->input->post('dataEvento');
                $tip_PagAnt     = $this->input->post('tip_PagAnt');
                $saldo          = $this->input->post('saldo');
                $cadastrante    = $this->input->post('cadastrante');
                $fatura         = $this->input->post('fatura');
                $faturapar_ES   = $this->input->post('faturapar_ES');
           // var_dump($this->input->post('senhaAdm'));
                if(null !== (   $this->input->post('senhaAdm') )) {  $senhaAdm  = $this->input->post('senhaAdm');}else  
                    $senhaAdm = 'sem';
//                $adm = $senhaAdm == 'admim' ? 1 : 0;
                $adm = $senhaAdm;
                    try {                
                        $dataVenda = explode('/', $dataFin);
                        $dataF = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];
                    } catch (Exception $e) {
                       $dataF = date('Y-m-d'); 
                    }
                try {                
                        $dataEvent = explode('/', $dataEvento);
                        $dataE = $dataEvent[2].'-'.$dataEvent[1].'-'.$dataEvent[0];
                    } catch (Exception $e) {
                       $dataE = date('Y-m-d'); 
                    }
                
                $fundoFin = ($this->vendas_model->getByIdChek('cod_assoc','cod_Ass',$fundoF));
                $dataVenc   = $fundoFin->cont_Contabil;
                $dataMelhor = $fundoFin->ent_SaiAss;
                $descricao_Ass = $fundoFin->descricao_Ass;
                $cred_deb   = $fundoFin->area;
                $tipo_Pag   = $cred_deb != 'CRÉDITO' ? $tipo_Pag : 'Parcelado';
            
                    $meses = array('01'=>"Jan",'02'=>"Fev",'03'=>"Mar",'04'=>"Abr",'05'=>"Mai",'06'=>"Jun",'07'=>"Jul",'08'=>"Ago",'09'=>"Set",10=>"Out",11=>"Nov",12=>"Dez",
                    );
            $lancamento = array(
                'conta'         => $caixa,
                'tipo_Conta'    => $tipoCont,
                'cCustos'       => $cod_compassion,
                'fundoF'        => $fundoF,
                'num_Doc_Banco' => $num_Doc,
                'num_Doc_Fiscal'=> $numDocFiscal,
                'historico'     => $razaoSoc,
                'descricao'     => $descri,
                'dataFin'       => date('d/m/Y', strtotime($dataF)),
                'dataEvento'    => $dataE,
                'valorFin'      => $valorFin,
                'ent_Sai'       => $ent_Sai,
                'tipo_Pag'      => $tipo_Pag,
                'conta_Destino' => $conta_Destino,
                'saldo'         => 0,
                'cadastrante'   => $cadastrante,
                'adm'           => $adm
            ); 
               $_SESSION['lancamento'] = $lancamento;     
 //*******Verifica se o valor foi digitado adequadamente.
            {
                     if(formatoRealPntVrg($valorFin) == true) 
               {//Verific se o numero digitado é com (.) milhar e (,) decimal
                   //serve pra validar  valores acima e abaixo de 1000
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    $valorFin;   
                   $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
               }else if(formatoRealInt($valorFin) == true)
               {//Verific se o numero digitado é inteiro sem ponto nem virgula
                   //serve pra validar  valores acima e abaixo de 1000
                   //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                   $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
               }else if(formatoRealPnt($valorFin) == true)
               { 
                   //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                   $valorFin  =    $valorFin;
                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
               }else if(formatoRealVrg($valorFin) == true)
               { 
                 //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                   $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
               }else
               {
                   echo "O valor digitado não esta nos parametros solicitados";
                          echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                        <script type=\"text/javascript\">
                                        alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
                                        </script>";	
                      exit;  


               }
            }
            $e_S = $faturapar_ES;
            if($num_Doc == '0/0'){
                $e_S = $fatura == 1 ? $id_fin : null;}
             
            $data = array(
                'conta'         => $caixa,
                'tipo_Conta'    => $tipoCont,
                'cod_compassion'=> $cod_compassion,
                'cod_assoc'     => $fundoF,
                'num_Doc_Banco' => $num_Doc,
                'num_Doc_Fiscal'=> $numDocFiscal,
                'historico'     => $razaoSoc,
                'descricao'     => $descri,
                'dataFin'       => $dataF,
                'dataEvento'    => $dataE,
                'valorFin'      => $valorFin,
                'ent_Sai'       => $ent_Sai,
                'tipo_Pag'      => $tipo_Pag,
                'conta_Destino' => $conta_Destino,
                'saldo'         => 0,
                'saldo_Mes'     => 'S',
                'cadastrante'   => $cadastrante
            ); //var_dump($faturapar_ES); die;
            if($e_S != null && $e_S != 0 && $e_S != '') $data['par_ES'] = $e_S;
 //***** VERIFICAÇÕES PARA LANÇAMENTO           
            {
                $p_Origem = base_url().'index.php/vendas/adicionar';
               
                if(!$fundoF || !$cod_compassion)
                { echo 'O Cetntro de Custo e Fundo Financeiro não Foram identificados.
                                    Volte a pagina anterior e preencha todos os campos! Caixa '.$lancamento[$caixa].$caixa.' tipo '.$lancamento[$tipoCont].' C comp '.$lancamento[$cod_compassion].' doc '.$lancamento[$num_Doc].'- Cod ASS  '.$lancamento[$numDocFiscal].' '.$numDocFiscal.' - R soc '.$lancamento[$razaoSoc].' '.$razaoSoc.' '.$fundoF.' - cod Comp '.$cod_compassion.' - tipo pag '.$lancamento[$tipo_Pag].' - ent sai '.$lancamento[$ent_Sai].' - '.$lancamento[$cadastrante].' ent sai '.$lancamento[$entrada_Saida].' '.$lancamento[$tip_Cont].' qtd pres '.$lancamento[$qtd_presentes].' ';
                  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                    <script type=\"text/javascript\">
                                    alert(\"O Cetntro de Custo e Fundo Financeiro não Foram identificados. Volte a pagina anterior e preencha todos os campos! - Linha: ". __LINE__ . "\");
                                    </script>";						  
                 exit; 
                }
                // echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
                $faltaCampo = "";

                if(!$caixa  ) $faltaCampo .= "Conta, ";
                if(!$tipoCont ) $faltaCampo .= "tipoCont, ";
                if(!$num_Doc ) $faltaCampo .= "num_Doc, ";
                if(!$numDocFiscal) $faltaCampo .= "numDocFiscal, ";
                if(!$razaoSoc) $faltaCampo .= "razaoSoc, ";
                if(!$dataF) $faltaCampo .= "dataF, ";
                if(!$valorFin ) $faltaCampo .= "valorFin, ";
                if(!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin )
                {
                    echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
                echo "<p><font color=red>Voce nao entrou com os dados necessarios.
                        Você não informou todos os dados nescessário. Tente novamente!</font</p>";
                  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                    <script type=\"text/javascript\">
                                    alert(\" Você não informou todos os dados nescessário. ".$faltaCampo." Tente novamente! Linha: ". __LINE__ . "\");
                                    </script>";	
                 // exit;  
                }	//URL=PaginaLancamento1.php
                
                $datahj = date('Y-m-d');
                $data_R = date('Y-m-d', strtotime("-6 month", strtotime($datahj)));
                if($permissoes_id < 3 && $dataF > $data_R)  $senhaAdm = "aenp@z18";
                if(!(isset($senhaAdm))){ $senhaAdm = "0000";}else if($senhaAdm == "vid@18") $senhaAdm = "aenp@z18";
                //echo $datahj;
                //	$dataF= implode('-',array_reverse(explode('/',$data)));
                $data_001 =  primeiroDiaMes($datahj);								
                $data_007 =  setimoDiadoMes($datahj);
            if($dataF < $datainicioLimite)
                {
                                echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
                             echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                        <script type=\"text/javascript\">
                                        alert(\" A data não é uma data válida, tente novamente! Linha: ". __LINE__ . "\");
                                        </script>";	
                      exit;  
                            }
            }
               $texto = '';
            
                       $mes =  date('m', strtotime($data['dataFin']));
                       $ano =  date('Y', strtotime($data['dataFin']));
                if($num_Doc == '0/0' || $cod_compassion == 'D10-01')                
                           $data['num_Doc_Banco'] = '0/0';
           // var_dump($data); exit;
            if ($this->vendas_model->edit('aenpfin', $data, 'id_fin', $id_fin) == TRUE) 
                if($num_Doc == '0/0' || $cod_compassion == 'D10-01')
                { 
                    $field = 'id_fin,valorFin';
                    $faturaLMes = $this->vendas_model->getFaturaLancamentosMes('aenpfin',$fundoF,$field,$mes,$ano);
                    //SE EFETUOU A BAIXA POR PAGAMENTOde fatura mensal
                if($numDocFiscal == 'Efetuado' && $numDocFiscalAnterior == 'Previsto') 
                   {
                    if(!empty($faturaLMes))
                    {
                       $dataUp = array( 'num_Doc_Fiscal' => 'Efetuado' ); 
                        $somaItensFatura = 0;
                       foreach ($faturaLMes as $fLMes) 
                       { 
                           $somaItensFatura += $fLMes->valorFin;
                           // Atualiza o valor total da fatura
                        if ($this->vendas_model->edit('aenpfin', $dataUp, 'id_fin', $fLMes->id_fin) == TRUE) { }
                       }
                        if($somaItensFatura != $valorFin)
                        { //Cria complemento de fatura
                           $data['cod_compassion'] = 'D10-02';
                           $data['num_Doc_Banco'] = '1/1';
                           $data['par_ES'] = $id_fin;
                           $data['descricao'] = 'Complemento da Fatura ('.$meses[$mes].'/'.$ano.')';
                           $data['valorFin'] = $valorFin-$somaItensFatura;                              
                            if (is_numeric($id = $this->vendas_model->add('aenpfin', $data, true))) 
                            { $texto .= ' Criado lançamento complementar no valor de R$'.$data['valorFin'] ;  }
                        }
                    }
                   }else
                    { // Se for só atualização atualiza o valor total da fatura
                        if(!empty($faturaLMes) && $fatura == 0)
                        { 
                            $somaItensFatura = 0;
                           foreach ($faturaLMes as $fLMes) { $somaItensFatura += $fLMes->valorFin; }
                            $dataUp = array( 'valorFin' => $somaItensFatura ); 
                            if ($this->vendas_model->edit('aenpfin', $dataUp, 'id_fin', $id_fin) == TRUE) { 
                             $texto .= ' Atualizado o valor da fatura em R$'.$data['valorFin'] ;}                         
                        }
                    }
                }else
                if($num_Doc != '0/0' || $fundoF == 'C-EMP')
                    { // Se for só atualização atualiza o valor total da fatura
//                        if(!empty($faturaLMes) && $fatura == 0)
                        {
                            $faturaLMesEMP = $this->vendas_model->getFaturaMes('aenpfin','C-EMP','*',$mes,$ano);
                            $somaItensFatura = 0;
                            $status = $faturaLMesEMP->num_Doc_Fiscal;
                        if($numDocFiscalAnterior == 'Previsto' && $numDocFiscal == 'Efetuado') 
                            { $somaItensFatura += $faturaLMesEMP->valorFin - $valorFin; }
                        if($numDocFiscalAnterior == 'Efetuado' && $numDocFiscal == 'Previsto')
                            { 
                                $somaItensFatura += $faturaLMesEMP->valorFin + $valorFin; 
                                $status = 'Previsto';
                            }                            
                  //  die($somaItensFatura);
                            $status = $somaItensFatura < 3.00 ? 'Efetuado' : $status;
                            
                            $dataUp = array( 'valorFin' => $somaItensFatura, 'num_Doc_Fiscal' => $status ); 
                            if ($this->vendas_model->edit('aenpfin', $dataUp, 'id_fin', $faturaLMesEMP->id_fin) == TRUE) 
                            { 
                             $texto .= ' Atualizado o valor da fatura em R$'.$somaItensFatura ;}                         
                        }
                    }
               $this->session->set_flashdata('success','Lançamento Editado com sucesso! '.$descri.' - em '.$razaoSoc.' . | '.$data['num_Doc_Banco'].$texto.' <strong>Adicione o ANEXO do documento fiscal.</strong>');  
                redirect(base_url() . 'index.php/vendas/editar/'.$id_fin);
            }else 
            {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                $this->session->set_flashdata('error','Lançamento não efetuado.');
            }
        }
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['result_caixas'] = $this->vendas_model->get2('caixas');
        
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['result_codComp'] = $this->vendas_model->get2('cod_compassion');
        $this->data['result_codIead'] = $this->vendas_model->get2('cod_assoc');
        $this->data['anexos'] = $this->vendas_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'vendas/editarVenda';
        $this->load->view('tema/topo', $this->data);   
    }
    
    public function anexar(){
     //   $this->session->set_flashdata('error','nome de arquivo. - ');   // Linha para testar variavel  
      //  exit;
        $this->load->library('upload');
        $this->load->library('image_lib');
        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para anexos de os
            'max_size'      => 0,
            );
        
        $fin_id = $this->input->post('fin_id');
        $this->upload->initialize( $upload_conf );  
        
              //   $upload_data['file_name'] = $upload_data['file_name'].$id_OsItens."_".$id_OsItens;
               
        foreach($_FILES['userfile'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;                 
            }
        }
        unset($_FILES['userfile']);  
        $error = array();
        $success = array();               
        foreach($_FILES as $field_name => $file)
        {
            if ( ! $this->upload->do_upload($field_name))
            {
       
                $error['upload'][] = $this->upload->display_errors();
            }
            else
            {
                $upload_data = $this->upload->data();  
                if($upload_data['is_image'] == 1){
                   // set the resize config
                    $resize_conf = array(    
                        'source_image'  => $upload_data['full_path'], 
                        'new_image'     => $upload_data['file_path'].'thumbs/thumb_'.$upload_data['file_name'],
                        'width'         => 200,
                        'height'        => 125
                        );
                    $this->image_lib->initialize($resize_conf);
                    if ( ! $this->image_lib->resize())
                    {
                        $error['resize'][] = $this->image_lib->display_errors();
                    }
                    else
                    {
                        $success[] = $upload_data;
                
                        $this->load->model('Vendas_model');
                        $this->Vendas_model->anexar( $this->input->post('fin_id'), $upload_data['file_name'] ,base_url().'assets/anexos/', 'thumb_'.$upload_data['file_name'],realpath('./assets/anexos/')); 
                    } 
                }
                else{
                    
                    $success[] = $upload_data;
                  //  $arquivo_antigo =  base_url().'assets/anexos/'.$upload_data['file_name'];
                  //    $arquivo_novo =  base_url().'assets/anexos/'.$id_OsItens."_".$id_OsItens."_".$upload_data['file_name'];
                  //  rename($arquivo_antigo, $arquivo_novo);
                    
                    $this->load->model('Vendas_model'); 
                    $this->Vendas_model->anexar( $fin_id, $upload_data['file_name'] ,base_url().'assets/anexos/', '',realpath('./assets/anexos/')); 
                }                
            }
        }
        if(count($error) > 0)
        {
            echo json_encode(array('result'=> false, 'mensagem' => 'Nenhum arquivo foi anexado.'));
        }
        else
        {
            //      $arquivo_antigo =  base_url().'assets/anexos/thumbs/'.$upload_data['file_name'];
            //     $arquivo_novo =  base_url().'assets/anexos/thumbs/'.$id_OsItens."_".$id_OsItens."_".$upload_data['file_name'];
             //     rename($arquivo_antigo, $arquivo_novo);
                        
            echo json_encode(array('result'=> true, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso .'));
        }
    }
    
    public function excluirAnexo($id = null){
        $this->session->set_flashdata('success','Teste com sucesso!'); 
        if($id == null || !is_numeric($id)){
            echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
        }
        else{
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();
            unlink($file->path.'/'.$file->anexo);
            
            if($file->thumb != null){
                unlink($file->path.'/thumbs/'.$file->thumb);    
            }            
            if($this->vendas_model->delete('anexos','idAnexos',$id) == true){
              //  echo json_encode(array('result'=> true, 'mensagem' => 'Anexo excluído com sucesso.'));
                $this->session->set_flashdata('success','<H3>Anexo excluído com sucesso!</H3>'); 
            }
            else{
                //echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
                  $this->session->set_flashdata('error','<H3>Erro ao tentar excluir anexo.</H3>');
            }           
            echo "<body onload='window.history.back();'>";
        }
    }
    public function downloadanexo($id = null){
        
        if($id != null && is_numeric($id)){
            
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();

            $this->load->library('zip');

            $path = $file->path;

            $this->zip->read_file($path.'/'.$file->anexo); 

            $this->zip->download('file'.date('d-m-Y-H.i.s').'.zip'); 

        }
      
    }

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar lançamentos.');
          redirect(base_url());
        }
        $this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['result_codComp'] = $this->vendas_model->get2('cod_compassion');
        $this->data['result_codIead'] = $this->vendas_model->get2('cod_assoc');
        
        $this->data['anexos'] = $this->vendas_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'vendas/visualizarVenda';
        $this->load->view('tema/topo', $this->data);
       
    }
    public function imprimir(){
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->mapos_model->getEmitente();
        
        $this->load->view('vendas/imprimirVenda', $this->data);
        
    }	
    public function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir vendas');
          redirect(base_url());
        }
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Erro ao tentar excluir Lançamento.');            
            redirect(base_url().'index.php/vendas/gerenciar/');
        } else
            
        {
            $datainicioLimite = '2020-01-01';
            include 'apoio/funcao.php';
        $user_id = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $permissoes_id = $user_id->permissoes_id;  
            
        $lancamento = $this->vendas_model->getById1($id);
                $conta          = $lancamento->conta;
                $tipo_Conta     = $lancamento->tipo_Conta;
                $valorFin       = $lancamento->valorFin;
                $ent_Sai        = $lancamento->ent_Sai;
                $dataFin        = $lancamento->dataFin;
        {
            $this->db->where('id_fin', $id);
            $this->db->delete('aenpfin');
           //**** Execução de RECALCULAR OS SALDOS desde o mês anterior a alteração
           {$this->session->set_flashdata('success','Lançamento  excluído com sucesso! Saldos alterados: ');}
            redirect(base_url().'index.php/vendas/gerenciar/'); 
        }
}
    }
    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteProduto($q);
        }

    }
    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteCliente($q);
        }

    }
    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteUsuario($q);
        }

    }
    public function adicionarProduto(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar vendas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required');
        $this->form_validation->set_rules('idVendasProduto', 'Vendas', 'trim|required');
        
        if($this->form_validation->run() == false){
           echo json_encode(array('result'=> false)); 
        }
        else{

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = array(
                'quantidade'=> $quantidade,
                'subTotal'=> $subtotal,
                'produtos_id'=> $produto,
                'vendas_id'=> $this->input->post('idVendasProduto'),
            );

            if($this->vendas_model->add('itens_de_vendas', $data) == true){
                $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
                $this->db->query($sql, array($quantidade, $produto));
                
                echo json_encode(array('result'=> true));
            }else{
                echo json_encode(array('result'=> false));
            }

        }
        
      
    }
    function excluirProduto(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
              redirect(base_url());
            }

            $ID = $this->input->post('idProduto');
            if($this->vendas_model->delete('itens_de_vendas','idItens',$ID) == true){
                
                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');


                $sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";

                $this->db->query($sql, array($quantidade, $produto));
                
                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }           
    }
    public function faturar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Vendas');
              redirect(base_url());
            }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
 

        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

	        $venda_id = $this->input->post('vendas_id');
            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

                if($recebimento != null){
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2].'-'.$recebimento[1].'-'.$recebimento[0];

                }
            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }

            $data = array(
	            'vendas_id' => $venda_id,
                'descricao' => set_value('descricao'),
                'valor' => $this->input->post('valor'),
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->vendas_model->add('lancamentos',$data) == TRUE) {
                
                $venda = $this->input->post('vendas_id');

                $this->db->set('faturado',1);
                $this->db->set('valorTotal',$this->input->post('valor'));
                $this->db->where('idVendas', $venda);
                $this->db->update('vendas');

                $this->session->set_flashdata('success','Venda faturada com sucesso!');
                $json = array('result'=>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar venda.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }     
    public function cadastrar() {
					$p_Origem = base_url().'index.php/vendas';
                    $contar = 1;
							while (($contar <= $qtd_presentes) ) 
								{
									$nome = 'nome'.$contar;
									$Codigo = 'Codigo'.$contar;
									$Protocolo = 'Protocolo'.$contar;
									$valorPre = 'valorPre'.$contar;
                                    $entraSai = 'entraSai'.$contar;
									$_SESSION[$nome] = $_POST[$nome];
									$_SESSION[$Codigo]	= $_POST[$Codigo];								
									$_SESSION[$Protocolo] = $_POST[$Protocolo];
									$_SESSION[$valorPre] = $_POST[$valorPre];
									$_SESSION[$entraSai] = $_POST[$entraSai];		
                                
									$contar = $contar+1;							
				
                                }
                    
						if(!$fundoF || !$cod_compassion)
						{ echo 'Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
											Volte a pagina anterior e preencha todos os campos! Caixa '.$_SESSION[$caixa].$caixa.' tipo '.$_SESSION[$tipoCont].' C comp '.$_SESSION[$cod_compassion].' doc '.$_SESSION[$num_Doc].'- Cod ASS  '.$_SESSION[$numDocFiscal].' '.$numDocFiscal.' - R soc '.$_SESSION[$razaoSoc].' '.$razaoSoc.' '.$fundoF.' - cod Comp '.$cod_compassion.' - tipo pag '.$_SESSION[$tipo_Pag].' - ent sai '.$_SESSION[$ent_Sai].' - '.$_SESSION[$cadastrante].' ent sai '.$_SESSION[$entrada_Saida].' '.$_SESSION[$tip_Cont].' qtd pres '.$_SESSION[$qtd_presentes].' ';
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída. Volte a pagina anterior e preencha todos os campos! - Linha: ". __LINE__ . "\");
											</script>";						  
						 exit; 
						}
						// echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
												
						if(!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin )
                        {echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
						echo "<p><font color=red>Voce nao entrou com os dados necessarios.
								Você não informou todos os dados nescessário. Tente novamente!</font</p>";
						  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Você não informou todos os dados nescessário. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
						}	//URL=PaginaLancamento1.php
                        $datahj = date('Y-m-d');
							//echo $datahj;
						//	$dataF= implode('-',array_reverse(explode('/',$data)));
                                $data_001 =  primeiroDiaMes($datahj);								
								$data_007 =  setimoDiadoMes($datahj);
                    if(($datahj > $data_007) && ($dataF < $data_001) && ($senhaAdm <> "aenp@z18"))
								{echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lançamento referente ao mês anterior aspirado. <br/> 
								Retorne e altere a data ou contate o administrador.</font><br/>";
                                 echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Prazo Limite para lançamento referente ao mês anterior aspirado, tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
                                }
                                 
                                 
							if($dataF < "2010-01-01" || $dataF > $datahj )
								{
									echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
								 echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" A data não é uma data válida, tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
								}
                 //   echo "</b></br> Valor recebdo <strong><td> R$  ".$valorFin."</td></strong></br>";            
                     /*  
                    //Verifica se o valor foi digitado adequadamente.
						 if(formatoRealPntVrg($valorFin) == true) 
                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                       //serve pra validar  valores acima e abaixo de 1000
                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    $valorFin;   
                       $valorFin  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                   }else if(formatoRealInt($valorFin) == true)
                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                       //serve pra validar  valores acima e abaixo de 1000
                       //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =    number_format(str_replace("." , "" ,$valorFin), 2, '.', '');
                   }else if(formatoRealPnt($valorFin) == true)
                   { 
                       //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                       $valorFin  =    $valorFin;
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                   }else if(formatoRealVrg($valorFin) == true)
                   { 
                     //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",",".",$valorFin), 2, ',', '.');  
                       $valorFin  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorFin)) ));
                   }else
                   {
                       echo "O valor digitado não esta nos parametros solicitados";
                              echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						  exit;  
                            
						  
                   }
                    */
								 
						
						if($cod_compassion == ( "R01 - 1030") )//Entrada com presentes especiais
						{
							$contar = 1;
                            $valorFinTotal =   "0.00";
							while (($contar <= $qtd_presentes) ) 
								{
									$n_nome = 'nome'.$contar;// Nomes das variaveis de cada cadastro
									$n_codigo = 'Codigo'.$contar;
									$n_protocolo = 'Protocolo'.$contar;
									$n_valorPre = 'valorPre'.$contar;
                                
									$nome = $_POST[$n_nome];
									$Codigo	= $_POST[$n_codigo];								
									$Protocolo = $_POST[$n_protocolo];
									$valorPre = $_POST[$n_valorPre];								
									if( !$nome  || !$Codigo  || !$Protocolo  || !$valorPre  )
									{				echo "Algum campo do ".$contar."º Presente da lista não foi preenchido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
                                     
									   echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
														<script type=\"text/javascript\">
														alert(\"Algum campo do ".$contar."º Prsente da lista não foi preenchido.Volte a pagina anterior e preencha todos os campos! Linha: ". __LINE__ . "\");
														</script>";	
                                     
									 exit; 
									}	
                                
                               /*
                                    formatoValor == true;
                                 if(formatoRealPntVrg($valorPre) == true) 
                                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                       //serve pra validar  valores acima e abaixo de 1000
                                       //      echo "Ponto e virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPreExibe  =    $valorPre;   
                                       $valorPre  =    (str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else if(formatoRealInt($valorPre) == true)
                                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                       //serve pra validar  valores acima e abaixo de 1000
                                       //      echo "Inteiro!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                      $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                       $valorPre  =    number_format(str_replace("." , "" ,$valorPre), 2, '.', '');
                                   }else if(formatoRealPnt($valorPre) == true)
                                   { 
                                       //     echo "Ponto!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPre  =    $valorPre;
                                       $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                   }else if(formatoRealVrg($valorPre) == true)
                                   { 
                                        //    echo "Virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                       $valorPreExibe  =    number_format(str_replace(",",".",$valorPre), 2, ',', '.');  
                                       $valorPre  =   (str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else
                                   {
                                       formatoValor == false;
                                   }
                                */
                                
									if($valorPre = 0 )
									{				echo "Atenção! O valor do  ".$contar."º Presente é inválido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
									  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
														<script type=\"text/javascript\">
														alert(\"Atenção! O valor do  ".$contar."º Prsente é inválido. Volte a pagina anterior e preencha todos os campos!\");
														</script>";						  
									 exit; 
									}
                                 
									$valorFinTotal = $valorFinTotal + $valorPre;
                                    echo "presente ".$contar."  = R$ <strong>".$valorPreExibe."</strong><br>";
									$contar = $contar+1;	
								}
                            $val_Total = $valorFinTotal;
                          
							$valorTotExibe  =    number_format(str_replace(",",".",$val_Total), 2, ',', '.');		
                       //     echo  "<br><font color = #0cb20c size = 2> Verificar valor =  ".$v_Valores;// variavel pra não cadastrar e voltar
                            echo "<br><font color = red size = 2> Soma Total =  R$ <strong>".$valorTotExibe."</strong></font><br><br>";
                        //    echo gettype($valorFinTotal), "<br>";
                            echo "<font color = red size = 2>Valor lançado =  R$ <strong>".$valorFinExibe."</strong></font><br><br>";
                           // echo gettype($valorFin), "<br>";
                             
                            if( ($valorFin !==  $val_Total) )
                        	 echo "<font color = red size = 2>Valor lançado é diferente do somatório</strong></font><br><br>";
                            
                            
                            if(formatoValor == false)
                            {
                             echo "Um ou mais valores inseridos não esta nos parametros solicitados";
                              echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Um ou mais valores inseridos não esta nos parametros solicitados. Tente novamente! Linha: ". __LINE__ . "\");
											</script>";	
						      exit;
                            }
							if($qtd_presentes > 0 )
							{
							}else{				echo "Não há presentes especiais.
												Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
							  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
												<script type=\"text/javascript\">
												alert(\"Não há presentes especiais.	Volte a pagina anterior e preencha todos os campos! <br>Linha: ". __LINE__ . "\");
												</script>";						  
							 exit; 
							}
                            
                             if($v_Valores == "1")                                
                            {
							if( ($valorFin !==  $val_Total) )
                        	{
                               
                                echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=".$p_Origem."'> 
												<script type=\"text/javascript\">
												alert(\"Verifique se o somatório  é igual ao valor total do lançamento. Preencha todos os campos! - Linha: ". __LINE__ . "\");
												</script>";						  
							 exit; 
							}}
                            
                            
						}	
//*****se for presente especial faz um lançamento 
						if($cod_compassion == ( "D07 - 0730"))//Saída com presentes especiais
						{
						//	echo 'linha '. __LINE__;
							if(!$id_presentes)//Saída com presentes especiais
							{						
							//echo "cod_compassion: ".$cod_compassion." qtd_presentes: ".$qtd_presentes."<br>";
							echo "Linha: ". __LINE__ . "<br>Nenhum Beneficiário foi selecionado para este presente especial.
												Volte a pagina anterior e preencha todos os campos!";
							  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos! Linha: ". __LINE__ . "\");
											</script>";						  
							 exit; 
							}	
							if($id_presentes == 0 ) 
								{	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=".$p_Origem."'> 
												<script type=\"text/javascript\">
												alert(\"Desculpe, Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos!\");
												</script>";			
										exit;
								}
                          
								$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
								if (!$res_max  ) 
								{			die ("<center>Desculpe, Nao foi encontrado o ultimo registro. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");
											exit;
								}
								if (mysqli_num_rows($res_max ) == 0 ) 
								{	echo "Nao foi encontrado nenhum ultimo registro. Tente novamente!"; //exit;
								}
								while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
								{	$id_Maxaenp = $id_ultimo['id_fin'] +1; }
							
								$presentes_saida = mysqli_query($conex, 'SELECT * FROM presentes_especiais
													WHERE  id_presente =  '.$id_presentes.' LIMIT 1');
								if (!$presentes_saida  ) 
								{			die ("<center>Desculpe, Nao foi encontrado o registro de presente ".$id_presentes.". Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");											
								}	
								if (mysqli_num_rows($presentes_saida) == 0 ) 
									{	echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";exit;
									}							
								
								while ($rows_presentes = mysqli_fetch_assoc($presentes_saida)) 
								{							
									  if ( $valorFin > $rows_presentes['valor_pendente'] + 4.5)
								        {echo "Linha: ". __LINE__ . "<br>Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento!";
                                          echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\" Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento! Linha: ". __LINE__ . "\");
											</script>";	
                                        		
										exit;
                                
                                        }
                                    
                                    
                                    $val_Restante = $rows_presentes['valor_pendente'] - $valorFin;
									
									$upd = "UPDATE presentes_especiais 
									SET id_saida = '".$id_Maxaenp."',data_presente= '".$dataF."',valor_saida = '".$valorFin."',valor_pendente = '".$val_Restante."'
									WHERE (id_presente =  ".$rows_presentes['id_presente'].")";
												$atualiz = mysqli_query($conex, $upd);
												if ($atualiz) 
												{					
												}else {
													die ("<center>Desculpe, Erro na atualização.:  " 
													. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
													<a href='menuF.php'>Voltar ao Menu</a></center>");	exit;												
													}
												$id_entrada = $rows_presentes['id_entrada'];
												$data_presente = $rows_presentes['data_presente'];
												$n_beneficiario = $rows_presentes['n_beneficiario'];
												$nome_beneficiario = $rows_presentes['nome_beneficiario'];
												$n_protocolo = $rows_presentes['n_protocolo'];
												$valor_entrada = $rows_presentes['valor_entrada'];
								}			
									if($val_Restante > 0 )
									{
										$crud = new Inserir('presentes_especiais');				
										$crud->inserir("id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario,
                                        n_protocolo, valor_entrada, valor_pendente", 
										"'','$id_entrada','$id_saida','$data_presente','$n_beneficiario','$nome_beneficiario','$n_protocolo',
										'$valor_entrada','$val_Restante'"); 
                                        
                                      //  $razaoSoc = $razaoSoc." - ".$n_beneficiario;
									}
						}
				 
						echo "Conta lançaento - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;
						//exit;	
					/*		
						$crud = new Inserir('aenpfin');				
						$crud->inserir("id_fin, conta,tipo_Conta,cod_compassion,cod_assoc,num_Doc_Banco,num_Doc_Fiscal,
						historico,	descricao, dataFin,	valorFin,	ent_Sai, 	saldo,		saldo_Mes, cadastrante", 
						"'','$caixa','$tipoCont','$cod_compassion','$fundoF','$num_Doc','$numDocFiscal',
						'$razaoSoc','$descri','$dataF','$valorFin','$ent_Sai','$saldo_Final','$saldo_mes_lancamento','$cadastrante'"); 
						*/
//******busca do ultimo registro com o saldo do mês marcado *********
						$sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2019-01-01" and 
											conta = '.$caixa.'  and tipo_Conta = "'.$tipoCont.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
						$result_Saldo_Atual = mysqli_query($conex, $sql_Saldo_Atual );
						if (!$result_Saldo_Atual) 
							{
										die ("<center>Desculpe, erro na busca de saldo atual.:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
											//exit;
							}
						if (mysqli_num_rows($result_Saldo_Atual) == 0  ) 
						{
							echo "Nao existem lançamentos</br>";
						   
						}		
						while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Atual)) 
						{//ID, valor do saldo e a data do registro com o ultimo saldo marcado
							$id_Ultimo_Saldo = $row_Saldo['id_fin']; 
							$saldo_Atual = $row_Saldo['saldo']; 	
							$dataUlt_saldo = $row_Saldo['dataFin'];
												
						}
//*****se pagamento for em cheque faz um lançamento de reconciliação bancária
						
						if($tipo_Pag == "cheque") 
						{	$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
							if (!$res_max  ) 
							{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										//exit;
							}
							if (mysqli_num_rows($res_max ) == 0 ) 
							{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
							}
							while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
							{	$id_Maxaenp = $id_ultimo['id_fin']; }
						
							$data_Pag = $dataF;
							//$id_Maxaenp = $id_Maxaenp + 1;//guarda o id do registro atual pra referenciar o id do cheque
                         //Ja marca se o cheque ja foi compensado
                         if(isset($_POST["chequeCompen"])) { $status = 1;} else $status = 0;
                         
							$crud = new Inserir('reconc_bank');				
							$crud->inserir("id_reconc, id_aenp, data_Emissao, data_Pag, status, operador", 
							"'','$id_Maxaenp','$data_Pag',''$data_Pag','$status','$cadastrante'"); 							
						}
						
                                    

//*****se for presente especial faz um lançamento 
											
						if($cod_compassion == ( "R01 - 1030"))//Entrada com presentes especiais
						{	$res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
							if (!$res_max  ) 
							{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
									. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
										//exit;
							}
							if (mysqli_num_rows($res_max ) == 0 ) 
							{	echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
							}
							while ($id_ultimo = mysqli_fetch_assoc($res_max)) 
							{	$id_Maxaenp = $id_ultimo['id_fin']; }
						
						 	$contar = 1;
							while (($contar <= $qtd_presentes) || $contar == 50) 
							{
								
								
                                $n_nome = 'nome'.$contar;// Nomes das variaveis de cada cadastro
								$n_codigo = 'Codigo'.$contar;
								$n_protocolo = 'Protocolo'.$contar;
								$n_valorPre = 'valorPre'.$contar;
                                									
                                $nome = $_POST[$n_nome];
								$Codigo	= $_POST[$n_codigo];								
								$Protocolo = $_POST[$n_protocolo];
								$valorPre = $_POST[$n_valorPre];	
                              							
								$data_presente = $dataF;
                                
                                
                                 if(formatoRealPntVrg($valorPre) == true) 
                                   {//Verific se o numero digitado é com (.) milhar e (,) decimal
                                       //serve pra validar  valores acima e abaixo de 1000
                                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                        $valorPre  =    ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }else if(formatoRealInt($valorPre) == true)
                                   {//Verific se o numero digitado é inteiro sem ponto nem virgula
                                       //serve pra validar  valores acima e abaixo de 1000
                                      //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                        $valorPre  =    number_format(str_replace("." , "" ,$valorPre), 2, '.', '');
                                   }else if(formatoRealPnt($valorPre) == true)
                                   { 
                                       //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                       $valorPre  =    $valorPre;
                                 }else if(formatoRealVrg($valorPre) == true)
                                   { 
                                     //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                       $valorPre  =   ((float)str_replace("," , "." , (str_replace("." , "" , $valorPre)) ));
                                   }
                                
                                
                                
                                
								$crud = new Inserir('presentes_especiais');				
								$crud->inserir("id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo,
                                valor_entrada, valor_pendente", 
								"'','$id_Maxaenp','$id_saida','$data_presente','$Codigo','$nome','$Protocolo', '$valorPre', '$valorPre'"); 
													
										
								$contar = $contar+1;							
							}
						}	
// ******* Se a data do ultimo saldo for maior que a do lançamento altera todos saldos posteriores			
						//$saldo_mes_lancamento = "S";
						//if( $dataF < $dataUlt_saldo)
					 //	{**** primeiro dia do mês do lançamento
							$dia_1_mes = primeiroDiaMes($dataF);
						//	$saldo_mes_lancamento = "N";
	//******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********				
                $id_anterior = null;
                $saldo_mes = 'N';
							$saldo_Penultimo = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin < "2019-01-01" and
											conta = '.$caixa.'  and tipo_Conta = "'.$tipoCont.'"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';	
                    
						$result_saldo_Penultimo = mysqli_query($conex, $saldo_Penultimo);
						if (!$result_saldo_Penultimo) 
							{				die ("<center>Desculpe, erro na busca de saldo atual.:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
											//exit;
							}
						if (mysqli_num_rows($result_saldo_Penultimo) == 0  ) 
							{	echo "Nao existem lançamentos</br>";}		
						while ($row_saldo_Penultimo = mysqli_fetch_assoc($result_saldo_Penultimo)) 
						{//ID, valor do saldo e a data do registro com o penultimo saldo marcado
							$id_saldo_Penultimo = $row_saldo_Penultimo['id_fin']; 
							$saldo_Penultimo = $row_saldo_Penultimo['saldo']; 	
							$data_saldo_Penultimo = $row_saldo_Penultimo['dataFin'];
												
						}
//******busca de todos registro, após o penultimo saldo *********						
									$maisRecentes = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, dataFin, ent_Sai, valorFin, saldo FROM aenpfin 
															WHERE  dataFin > "'.$data_saldo_Penultimo.'" 
															and conta like "'.$caixa.'" and tipo_Conta like "'.$tipoCont.'" 
															ORDER BY dataFin, id_fin ');
								if (!$maisRecentes) 
								{			die ("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  " 
										. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menuF.php'>Voltar ao Menu</a></center>");
											//exit;
								}
								if (mysqli_num_rows($maisRecentes) == 0 ) 
								{	echo "Nao foi encontrado nenhum registro após o penultimo saldo. Tente novamente!";
								}								
	//inicia variavel do dia final do mes do registro anterior com o dia fim do mês do lançamento								
								$fim_mes = ultimoDiaMes($dataF);
								
								$s_anterior =	$saldo_Penultimo;
								while ($maisRecent = mysqli_fetch_assoc($maisRecentes)) 
								{	
									//if ($maisRecent['dataFin'] > $dataF) 
									//{
										$ent_Sai = $maisRecent['ent_Sai'];
										if ($ent_Sai == 0) {
										$s_Atual = $s_anterior - $maisRecent['valorFin'];//$valorFin;
										}else if ($ent_Sai == 1){
											$s_Atual = $s_anterior + $maisRecent['valorFin'];
										}										
											$upd = "UPDATE aenpfin SET saldo = ".$s_Atual." WHERE (id_fin =  ".$maisRecent['id_fin'].")";
											$atualiz = mysqli_query($conex,$upd);
											if ($atualiz) 
											{
																	
											}else {
												die ("<center>Desculpe, Erro na atualização.:  " 
												. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
												<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
												}					
									//}
									$s_anterior =	$s_Atual;
									$dataX = $maisRecent['dataFin'];
									$d_anterior = $dataX;
									$data_ultimo_dia = ultimoDiaMes($dataX);//inicia variavel do dia final do mes do registro atual
									
									if(null !== $id_anterior)
									
									{							
										if($dataX > $fim_mes)
										{	$saldo_mes = "S";// Marca se for o ultimos registro de saldos de cada mes 
										}else $saldo_mes = "N";
										
											$upd = "UPDATE aenpfin SET saldo_Mes = '".$saldo_mes."' WHERE (id_fin =  ".$id_anterior.")";
											$atualiz = mysqli_query($conex, $upd);
											if ($atualiz) {
																	
											}else {
											die ("<center>Desculpe, Erro na atualização.:  " 
											. '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
											<a href='menuF.php'>Voltar ao Menu</a></center>");	//exit;												
											}										
									}
									if(	$saldo_mes == "S") $s_mes = "| Saldo do mês."; else $s_mes = "";
									echo '<font color=red size="2"> Conta '.$maisRecent['conta'];
									echo ' | Tipo '.$maisRecent['tipo_Conta']. ' | Data </font> <font color=green>'.$d_anterior. ' </font> <font color=red>
									| Registro '.$id_anterior. ' | Saldo alterado para '.$s_Atual. '  
									'.$s_mes. ' <td></font><br />';	
									
									$id_anterior = $maisRecent['id_fin'];
									$fim_mes = $data_ultimo_dia;
								}
								
									$_SESSION['tE_S_N'] = $entrada_S;
									$_SESSION['tE_S'] = $entrada_Saida;
									$_SESSION['t_Cont'] = $tip_Cont;
									$_SESSION['Cont'] = $contaX;
								echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
											<script type=\"text/javascript\">
											alert(\"Alterações realizada com sucesso. Novo lançamento. \");										
											</script>";	
									//		formulario.submit();
									//		</script>";	
					}


}



