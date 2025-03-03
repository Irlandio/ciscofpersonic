<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios extends CI_Controller{


    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    public function __construct() {
        parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        
        $this->load->model('Relatorios_model','',TRUE);
        $this->data['menuRelatorios'] = 'Relatórios';

    }
    public function clientes(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_clientes';
       	$this->load->view('tema/topo',$this->data);
    }

    public function produtos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_produtos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function clientesCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');

        $data['clientes'] = $this->Relatorios_model->clientesCustom($dataInicial,$dataFinal);

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    
    }

    public function clientesRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $data['clientes'] = $this->Relatorios_model->clientesRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    }

    public function produtosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirProdutos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function produtosRapidMin(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapidMin();

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
        
    }

    public function produtosCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $estoqueInicial = $this->input->get('estoqueInicial');
        $estoqueFinal = $this->input->get('estoqueFinal');

        $data['produtos'] = $this->Relatorios_model->produtosCustom($precoInicial,$precoFinal,$estoqueInicial,$estoqueFinal);

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function servicos(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_servicos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function servicosCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $data['servicos'] = $this->Relatorios_model->servicosCustom($precoInicial,$precoFinal);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function servicosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $data['servicos'] = $this->Relatorios_model->servicosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function os(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_os';
       	$this->load->view('tema/topo',$this->data);
    }

    public function osRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }

        $data['os'] = $this->Relatorios_model->osRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function osCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');
        $status = $this->input->get('status');
        $data['os'] = $this->Relatorios_model->osCustom($dataInicial,$dataFinal,$cliente,$responsavel,$status);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function contabil(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
        $this->data['result_caixas'] = $this->Relatorios_model->get2('caixas');
        $this->data['usuario'] = $this->Relatorios_model->getByIdUser($this->session->userdata('id'));   
        
        if(null !== ($this->input->post('conta')))
        {       
            $conta   = $this->input->post('conta');
            $_SESSION['contA'] = $this->input->post('conta');
            
            if(null !== ($this->input->post('ano'))) $ano   = $this->input->post('ano');else $ano   = date('Y');
            
            if(null !== ($this->input->post('mes'))){$mes = $this->input->post('mes');
            if('0' == $mes){                
                $mes   =  0;}else   $mes <= 9 ? $mess = '0'.$mes : $mess = $mes;
                            }else $mes   = date('m');
            if(0 == $mes){ 
                $dataInicial = date($ano.'-01-01');
                $dataIniciale = date('01/01/'.$ano);   
                $dataFinale = date('31/12/'.$ano);
                $dataFinal = date($ano.'-12-31');
              }else{   
                    $dataInicial = date($ano.'-'.$mess.'-01');
                    $dataIniciale = date('01/'.$mess.'/'.$ano);
                    $diass = cal_days_in_month(CAL_GREGORIAN, $mess, $ano);
                    $dataFinale = date($diass.'/'.$mess.'/'.$ano);
                    $dataFinal = date($ano.'-'.$mess.'-'.$diass);
            }
            
            if(null !== ($this->input->post('mesF'))){$mesF = $this->input->post('mesF');
            if('0' == $mesF){                
                $mesF   =  0;}else   $mesF <= 9 ? $mess = '0'.$mesF : $mess = $mesF;
                            }else $mesF   = date('m');
            if(0 == $mesF){
                
              }else{   
                    $dataFInicial = date($ano.'-'.$mess.'-01');
                    $dataFIniciale = date('01/'.$mess.'/'.$ano);
                    $diassF = cal_days_in_month(CAL_GREGORIAN, $mess, $ano);
                    $dataFFinale = date($diassF.'/'.$mess.'/'.$ano);
                    $dataFFinal = date($ano.'-'.$mess.'-'.$diassF);
            }
            
            if(0 == $mesF){
                    $dataFFinale = $dataFinale;
                    $dataFFinal = $dataFinal;
              }
            // $dataInicial = date('Y-m-01');
        //    $dataFinal = date('Y-m-t');
            $_SESSION['admini'] = $this->input->post('admini');
            $_SESSION['dataInicial'] = $dataInicial;
            $_SESSION['dataFinal'] = $dataFFinal;
            
            $_SESSION['dataIniciale'] = $dataIniciale;
            $_SESSION['dataFinale'] = $dataFFinale;
            
            $_SESSION['tipoPesquisa'] = 2;
            
         
      /*/  $result_caixas = $this->Relatorios_model->get2('caixas');   
           foreach ($result_caixas as $rC) 
                    {	
                      if($rC->id_caixa == $conta) $n_Conta = $rC->nome_caixa;
           }*/
             switch ($conta) 
					{			
						    
				        case 1: $cdiNome = "IEADALPE-1444-3";  $_SESSION['admini'] = "cod_assoc"; break;  
						case 2:	$cdiNome = "IEADALPE-22360-3"; $_SESSION['admini'] = "cod_assoc";   break;    
						case 3:	$cdiNome = "ILPI";  $_SESSION['admini'] = "cod_assoc";  break;  
						case 4: $cdiNome = "BR0214";   break;  
						case 5:	$cdiNome = "BR0518";  break;  
						case 6:	$cdiNome = "BR0542";  break;  
						case 7:	$cdiNome = "BR0549";   break;  
						case 8:	$cdiNome = "BR0579";  break; 
						case 9:	$cdiNome = "BB-28965-5"; $_SESSION['admini'] = "cod_assoc";   break;  
						case 10:$cdiNome = "CEF-1948-4"; $_SESSION['admini'] = "cod_assoc";  break;  
						case 0: $cdiNome = "Todas Contas"; $_SESSION['admini'] = "cod_contab";  break; 		
					}
        $data['res_CodComp'] = $this->Relatorios_model->get2('cod_compassion');
        $data['res_CodAssoc'] = $this->Relatorios_model->get2('cod_assoc');
        $data['res_Caix'] = $this->Relatorios_model->get2('caixas');
            $status = '0';
        $data['res_Concilio'] = $this->Relatorios_model->getChekPend($conta,$status);
        $data['saldo_Ant'] = $this->Relatorios_model->getSaldo_Ant($this->input->post('conta'),$dataInicial);
        $data['lancamentos'] = $this->Relatorios_model->financeiroRapid($conta,$dataInicial,$dataFFinal);
        $data['presentes_pagos'] = $this->Relatorios_model->presentes_pagos($conta,$cdiNome,$dataInicial,$dataFFinal);
            
        $this->session->set_flashdata('success','<strong> Relatório gerado com sucesso!</strong> Conta  '.$conta.' - '.$cdiNome.' Periodo (de  <strong> '.$dataIniciale.'</strong>  à <strong> '.$dataFinale.'</strong>  )');  
            
        $this->load->view('relatorios/imprimir/imprimirContabil', $data);
        }else
        {
        $this->data['view'] = 'relatorios/rel_financeiro';
        $this->load->view('tema/topo',$this->data);
        }
    }

/*

        $this->db->select('aenpfin.*, caixas.*, cod_assoc.*');
        $this->db->from('aenpfin');
        $this->db->join('caixas', 'aenpfin.conta = caixas.id_caixa', 'left');
        $this->db->join('cod_assoc', 'aenpfin.cod_assoc = cod_assoc.cod_Ass', 'left');
        $this->db->where('conta',$conta);
*/

    public function financeiro(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
        $this->data['result_caixas'] = $this->Relatorios_model->get2('caixas');
        $this->data['usuario'] = $this->Relatorios_model->getByIdUser($this->session->userdata('id'));   
        
        if(null !== ($this->input->post('conta')))
        {
       
            $conta   = $this->input->post('conta');
            $_SESSION['contA'] = $this->input->post('conta');
            if(null !== ($this->input->post('ano'))) $ano   = $this->input->post('ano');else $ano   = date('Y');
            if(null !== ($this->input->post('mes'))){ $mes   = $this->input->post('mes');
                                        $mes <= 9 ? $mess = '0'.$mes : $mess = $mes;
                                                    }else $mes   = date('m');
            
            $dataInicial = date($ano.'-'.$mess.'-01');
            $dataIniciale = date('01/'.$mess.'/'.$ano);
            $diass = cal_days_in_month(CAL_GREGORIAN, $mess, $ano);
            
            
            $dataFinale = date($diass.'/'.$mess.'/'.$ano);
            $dataFinal = date($ano.'-'.$mess.'-'.$diass);
            // $dataInicial = date('Y-m-01');
        //    $dataFinal = date('Y-m-t');
            $_SESSION['admini'] = $this->input->post('admini');
            $_SESSION['dataInicial'] = $dataInicial;
            $_SESSION['dataFinal'] = $dataFinal;
            
            $_SESSION['dataIniciale'] = $dataIniciale;
            $_SESSION['dataFinale'] = $dataFinale;
         // $dataInicial = date('Y-m-01');
        //    $dataFinal = date('Y-m-t');
            $_SESSION['tipoPesquisa'] = 0;
         
         $data['somaMeses'] =  $this->Relatorios_model->getEstatisticaSomaMes($dataInicial, $dataFinal);
            
        $data['lanc'] =  $this->Relatorios_model->getLancamentosFuturos('aenpfin',$dataInicial, $dataFinal);
            
        $data['res_CodComp'] = $this->Relatorios_model->get2('cod_compassion');
            $status = '0';
        $this->session->set_flashdata('success','<strong> Relatório gerado com sucesso!</strong> Conta  '.' Periodo (de  <strong> '.$dataIniciale.'</strong>  à <strong> '.$dataFinale.'</strong>  )');  
        $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        }else
        {
        $this->data['view'] = 'relatorios/rel_financeiro';
        $this->load->view('tema/topo',$this->data);
        }
    }

    public function financeiroSaldos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
        
        if(null !== ($this->input->post('ajustar')))
        {   $ajustar = $this->input->post('ajustar');
            $conta = $this->input->post('conta');
         
            $lancamentos = $this->Relatorios_model->financeiroAjustarSaldos($conta); 
            $alterados = $alteradosN = 0;
                $tipo_ContaAnt ='';
            foreach ($lancamentos as $l)                                    
              { 
                if($tipo_ContaAnt != $l->tipo_Conta)  
                    {$saldo = $sal_Ant ='';}
                if($sal_Ant != '')
                    {
                        $id_fin     = $l->id_fin;
                        $saldo      = $l->saldo;
                        $valorFin   = $l->valorFin;
                        $ent_Sai    = $l->ent_Sai;
                        if($mesAnterior  != date('Y/m', strtotime( $l->dataFin)))
                         { $dataS = array('saldo_Mes'   => "S" );
                        if ($this->Relatorios_model->edit('aenpfin', $dataS, 'id_fin', $id_finAnterior) == TRUE) {
                        } }   
                        $saldo      = ($ent_Sai ==  0)  ? $sal_Ant - $valorFin : $sal_Ant + $valorFin;
                        $data = array(
                            'saldo_Mes'   => "N",
                            'saldo'       => $saldo
                        );
                        if ($this->Relatorios_model->edit('aenpfin', $data, 'id_fin', $id_fin) == TRUE) {
                            $alterados++;
                        } else {
                            $alteradosN++;
                        }                    
                    } $sal_Ant = ($saldo != '') ? $saldo : $l->saldo;
                    $tipo_ContaAnt     = $l->tipo_Conta;
                    $id_finAnterior     = $l->id_fin;
                    $mesAnterior  = date('Y/m', strtotime( $l->dataFin));
                }
                $_SESSION['contA']  = $conta;
                if ($alterados != '') {
                    $this->session->set_flashdata('success','Ajuste de saldos para conta '.$conta.' conclúido! '.$alterados.' Saldos Alterados! ');
                } 
         
        }else
        if(null !== ($this->input->post('conta')))
        {            
            $_SESSION['admini'] = $this->input->post('admini');
            $conta              = $this->input->post('conta');
            $_SESSION['contA']  = $this->input->post('conta');
            $adminSal           = $this->input->post('adminSal');
            $_SESSION['adminSal']= $this->input->post('adminSal');

        if(null !== ($this->input->post('ano'))) $ano   = $this->input->post('ano');else $ano   = date('Y');
        if(null !== ($this->input->post('mes'))) $mes   = $this->input->post('mes');else $mes   = date('m');
        $dataInicial = date($ano.'-'.$mes.'-01');
        $dataFinal = date($ano.'-'.$mes.'-t');
        
        $_SESSION['dataIniciale'] = $dataInicial;
        $_SESSION['dataFinale'] = $dataFinal;
            
        $this->data['res_CodComp'] = $this->Relatorios_model->get2('cod_compassion');
        $this->data['lancamentos'] = $this->Relatorios_model->financeiroSaldos($conta,$adminSal);
            
     //   $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
   //     $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
     //   pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
      //  redirect(base_url().'/relatorios/imprimir/imprimirFinanceiro');
        }
        $this->data['arrContas'] = $this->Relatorios_model->get2('caixas');
	    $this->data['view'] = '/relatorios/imprimir/imprimirFinanceiro';
       	$this->load->view('tema/topo',$this->data);
    }

    public function financeiroRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
           
        if(null !== ($this->input->post('conta')))
        {
            
            $conta   = $this->input->post('conta');
            $_SESSION['contA'] = $this->input->post('conta');

        if(null !== ($this->input->post('ano'))) $ano   = $this->input->post('ano');else $ano   = date('Y');
        if(null !== ($this->input->post('mes'))) $mes   = $this->input->post('mes');else $mes   = date('m');
        $dataInicial = date($ano.'-'.$mes.'-01');
        $dataFinal = date($ano.'-'.$mes.'-t');
        
        $this->data['res_CodComp'] = $this->Relatorios_model->get2('cod_compassion');
        $this->data['lancamentos'] = $this->Relatorios_model->financeiroRapid($conta,$dataInicial,$dataFinal);
     //   $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
   //     $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
     //   pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
      //  redirect(base_url().'/relatorios/imprimir/imprimirFinanceiro');
        }
	    $this->data['view'] = '/relatorios/imprimir/imprimirFinanceiro';
       	$this->load->view('tema/topo',$this->data);
    }

    public function financeiroCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }
        $this->data['result_caixas'] = $this->Relatorios_model->get2('caixas');
        $this->data['usuario'] = $this->Relatorios_model->getByIdUser($this->session->userdata('id'));   
        
        if(null !== ($this->input->post('conta')))
        {
            $conta   = $this->input->post('conta');
            $_SESSION['contA'] = $this->input->post('conta');
            if(null !== ($this->input->post('dataInicial'))) $dataInicio = $this->input->post('dataInicial'); else $dataInicial = date('d/(m-2)/Y');
            if(null !== ($this->input->post('dataFinal'))) $dataFim = $this->input->post('dataFinal');else $dataFinal   = date('d/m/Y');
            
            $dataInicial0     = explode('/', $dataInicio);
            $dataInicial    = $dataInicial0[2].'-'.$dataInicial0[1].'-'.$dataInicial0[0];          
                
            $dataFinal0     = explode('/', $dataFim);
            $dataFinal    = $dataFinal0[2].'-'.$dataFinal0[1].'-'.$dataFinal0[0];          
                
            
            $_SESSION['dataInicial'] = $dataInicial;
            $_SESSION['dataFinal'] = $dataFinal;
            
            
            $_SESSION['dataIniciale'] = $dataInicio;
            $_SESSION['dataFinale'] = $dataFim;
         // $dataInicial = date('Y-m-01');
        //    $dataFinal = date('Y-m-t');
            $_SESSION['tipoPesquisa'] = 1;
         
        $result_caixas = $this->Relatorios_model->get2('caixas');   
           foreach ($result_caixas as $rC) 
                    {	
                      if($rC->id_caixa == $conta) $n_Conta = $rC->nome_caixa;
           }
             switch ($conta) 
					{	   
				        case 1: $cdiNome = "IEADALPE-1444-3";  $_SESSION['admini'] = "cod_assoc"; break;  
						case 2:	$cdiNome = "IEADALPE-22360-3";  $_SESSION['admini'] = "cod_assoc";  break;    
						case 3:	$cdiNome = "ILPI";  $_SESSION['admini'] = "cod_assoc";  break;  
						case 4: $cdiNome = "BR0214";  $_SESSION['admini'] = "cod_compassion"; break;  
						case 5:	$cdiNome = "BR0518"; $_SESSION['admini'] = "cod_compassion";  break;  
						case 6:	$cdiNome = "BR0542"; $_SESSION['admini'] = "cod_compassion"; break;  
						case 7:	$cdiNome = "BR0549"; $_SESSION['admini'] = "cod_compassion";  break;  
						case 8:	$cdiNome = "BR0579"; $_SESSION['admini'] = "cod_compassion"; break; 
						case 9:	$cdiNome = "BB-28965-5";   $_SESSION['admini'] = "cod_assoc"; break;  
						case 10:$cdiNome = "CEF-1948-4";  $_SESSION['admini'] = "cod_assoc"; break; 		
					}   $status = '0';
        $data['res_Concilio'] = $this->Relatorios_model->getChekPend($conta,$status);
        $data['res_CodComp'] = $this->Relatorios_model->get2('cod_compassion');
        $data['saldo_Ant'] = $this->Relatorios_model->getSaldo_Ant($this->input->post('conta'),$dataInicial);
        $data['lancamentos'] = $this->Relatorios_model->financeiroRapid($conta,$dataInicial,$dataFinal);
        $data['presentes_pagos'] = $this->Relatorios_model->presentes_pagos($conta,$cdiNome,$dataInicial,$dataFinal);
            
            
        $this->data['res_Concilio'] = $this->Relatorios_model->getChekPend($conta,$status);
        $this->data['res_CodComp'] = $this->Relatorios_model->get2('cod_compassion');
        $this->data['saldo_Ant'] = $this->Relatorios_model->getSaldo_Ant($this->input->post('conta'),$dataInicial);
        $this->data['lancamentos'] = $this->Relatorios_model->financeiroRapid($conta,$dataInicial,$dataFinal);
        $this->data['presentes_pagos'] = $this->Relatorios_model->presentes_pagos($conta,$cdiNome,$dataInicial,$dataFinal);
            
        $this->session->set_flashdata('success','<strong> Relatório gerado com sucesso!</strong> Conta  '.$conta.' - '.$cdiNome.' Periodo (de  <strong> '.$dataInicio.'</strong>  à <strong> '.$dataFim.'</strong>  )'); 
            
        $pdf = 0;
            
        if($pdf == 0)  
            $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        else{
            $this->load->helper('mpdf');
            $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
            pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
            
        }
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        }else
        {
        $this->data['view'] = 'relatorios/rel_financeiro';
        $this->load->view('tema/topo',$this->data);
        }
    
    }
    public function vendas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_vendas';
        $this->load->view('tema/topo',$this->data);
    }

    public function vendasRapiddia(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $_SESSION['cont_a']         = "Todas";
        $_SESSION['dataInicio']         = date('d/m/y');
        $_SESSION['dataFim']         = date('d/m/y');
        $dataInicial = date('Y-m-d');
        $dataFinal   = date('Y-m-d');
        $data['vendas'] = $this->Relatorios_model->vendasRapidX($dataInicial ,$dataFinal);  
        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'Relat_SINT_'.date('d-m-y', strtotime($_SESSION['dataInicio'])).'a' .date('d-m-y', strtotime($_SESSION['dataFim'])).' ' . date('d_m H_i').'h', TRUE);
    }


    public function vendasRapidsemana(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $_SESSION['cont_a']         = "Todas";
        $_SESSION['dataInicio']         = date('d/m/y', strtotime('sunday last week', strtotime(date('Y-m-d'))));
        $_SESSION['dataFim']         = date('d/m/y');
        $dataInicial = date('Y-m-d', strtotime('sunday last week', strtotime(date('Y-m-d'))));
        $dataFinal   = date('Y-m-d');
        $data['vendas'] = $this->Relatorios_model->vendasRapidX($dataInicial ,$dataFinal);  
        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'Relat_SINT_'.date('d-m-y', strtotime($dataInicial)).'a' .date('d-m-y', strtotime($dataFinal)).' ' . date('d_m H_i').'h', TRUE);
    }


    public function vendasRapidmes(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $_SESSION['cont_a']         = "Todas";
        $_SESSION['dataInicio']         = date('01/m/y');
        $_SESSION['dataFim']         = date('d/m/y');
        $dataInicial = date('Y-m-01');
        $dataFinal   = date('Y-m-d');
        $data['vendas'] = $this->Relatorios_model->vendasRapidX($dataInicial ,$dataFinal);  
        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'Relat_SINT_'.date('d-m-y', strtotime($dataInicial)).'a' .date('d-m-y', strtotime($dataFinal)).' ' . date('d_m H_i').'h', TRUE);
    }


    public function vendasRapidano(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $_SESSION['cont_a']         = "Todas";
        $_SESSION['dataInicio']      = date('01/01/y');
        $_SESSION['dataFim']         = date('d/m/y');
        $dataInicial = date('Y-01-01');
        $dataFinal   = date('Y-m-d');
        $data['vendas'] = $this->Relatorios_model->vendasRapidX($dataInicial ,$dataFinal);  
        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'Relat_SINT_'.date('d-m-y', strtotime($_SESSION['dataInicio'])).'a' .date('d-m-y', strtotime($_SESSION['dataFim'])).' ' . date('d_m H_i').'h', TRUE);
    }

    public function vendasRapid($dataInicial ,$dataFinal){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        
       
        $data['vendas'] = $this->Relatorios_model->vendasRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }

    public function vendasCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        if(!isset ($_SESSION['tipo'] ) || null ==  ($_SESSION['tipo'] )) $_SESSION['tipo']       = "";
        if(null !== ($this->input->get('tipo'))) 
       // if(isset ($_SESSION['tipo'] )) 
        {
      //  if(null !== ($this->input->get('tipo'))) 
        $_SESSION['tipo']       = $this->input->get('tipo');
        }else if(!isset ($_SESSION['tipo'] )) $_SESSION['tipo']       = "";
        
        if(null !== ($this->input->get('conta_A')))        $_SESSION['cont_a']     = $this->input->get('conta_A'); 
        if(null !== ($this->input->get('dataInicial')))    $_SESSION['dataInicio'] = $this->input->get('dataInicial');
        if(null !== ($this->input->get('dataFinal')))      $_SESSION['dataFim']    = $this->input->get('dataFinal');
        if(null !== ($this->input->get('centros')))        $_SESSION['centros']    = $this->input->get('centros');
        if(null !== ($this->input->get('pdf')))             $pdf    = $this->input->get('pdf'); else $pdf = 0;
        
        $dataInicial            = $_SESSION['dataInicio'];
        $dataFinal              = $_SESSION['dataFim'];
        $cliente                = $_SESSION['cont_a'];
        $responsavel            = $_SESSION['centros'];
        
        $data['res_contas'] = $this->Relatorios_model->get2('contas');
        $_SESSION['centr']  = "";
        if($responsavel == "T-Contas" || $responsavel == "T-Suporte" )
                    { $_SESSION['centr'] = $responsavel; $responsavel= ""; }
        if($_SESSION['tipo'] != "")
        {
        if(null !== ($this->input->get('id_fin')))
            {
            $descric            = $this->input->get('descricao');
            $idFin              = $this->input->get('id_fin');
            $dataFn             = $this->input->get('dataFin');
            $ent_Sai            =$this->input->get('ent_Sai');            
            if($ent_Sai == 0)
              { $conta            =$this->input->get('saida');
                $conta_Destino    =$this->input->get('entrada');
            }else
              { $conta            =$this->input->get('entrada');
                $conta_Destino    =$this->input->get('saida');
              }
                $t_Conta          =$this->input->get('t_Conta'); 
                $par_ES           ="NULL";
            if(null !== ($this->input->get('id_fin2'))) /// Se houver o par do lançamento recebe id2            
                $par_ES        =$this->input->get('id_fin2');
            
            $termo = "combinar E-S ";
            $editar = 1;
            
            $dataDescric = " ";
            $pattern = '/' . $termo . '/';//Padrão a ser encontrado na string $tags
            if (preg_match($pattern, $descric))
                $descricao        =$descric." ".date('Y-m-d');else
                $descricao        =$descric."combinar E-S ".date('Y-m-d');
            
            $data = array(
                'conta'        => $conta,
                'conta_Destino'=> $conta_Destino,
                'descricao'    => $descricao,
                'tipo_Conta'   => $t_Conta,
                'par_ES'       => $par_ES
            );
            
            if (preg_match($pattern, $descric))
                $dataDescric = substr($descric, -10);
                $amanha = date('Y-m-d', strtotime("+1 day", strtotime('Y-m-d')));
                $ontem = date('Y-m-d', strtotime("-1 day", strtotime('Y-m-d')));
            
            if($dataDescric != " " && $dataDescric > $ontem && $dataDescric < $amanha) { $editar = 0;}else $editar = 1;
            
            if($editar == 1 )
            if($this->Relatorios_model->edit('aenpfin', $data, 'id_fin', $this->input->get('id_fin')) == TRUE)  
            {
            if(null !== ($this->input->get('ent_Sai2'))) /// Se houver o par do lançamento edita-o
                {  $ent_Sai2         =$this->input->get('ent_Sai2');
                    if($ent_Sai2 == 0)
                        {
                            $conta2            =$this->input->get('saida2');
                            $conta_Destino2    =$this->input->get('entrada2');
                        }else
                            {
                            $conta2            =$this->input->get('entrada2');
                            $conta_Destino2    =$this->input->get('saida2');
                            }
                    $t_Conta2          =$this->input->get('t_Conta2');
                    $par_ES2           =$idFin;
                 
                    $data2 = array(
                        'conta'         => $conta2,
                        'conta_Destino' => $conta_Destino2,
                        'tipo_Conta'    => $t_Conta2,
                        'par_ES'        => $par_ES2
                    );
                    if ($this->Relatorios_model->edit('aenpfin', $data2, 'id_fin', $this->input->get('id_fin2')) == TRUE)  
                    {
                        }
                }else{   /// Se não houver o par do lançamento Gera um.
                        $vendasdatafin = $this->Relatorios_model->vendasRapidX($dataFn,$dataFn );
                          $addc = 1;
                          foreach ($vendasdatafin as $vDatas) 
                          {                              
                            $idDescric    = $vDatas->par_ES;
                              
                              if($idDescric == $idFin) { $addc = 0;}   
                          }
                
                        $cod_assocN = "";
                        $vendas = $this->Relatorios_model->getByIdaenpfin($this->input->get('id_fin'));
                        if($ent_Sai == 0)$ent_SaiN = 1; else $ent_SaiN = 0;
                        if($vendas->conta_Destino == 0)
                            $conta_Destin = $vendas->conta; else 
                            $conta_Destin = $vendas->conta_Destino;
                        
                         if($vendas->cod_assoc == "T00-000") $cod_assocN = "T00";else
                         if($vendas->cod_assoc == "T00")     $cod_assocN = "T00-000";else
                         if($vendas->cod_assoc == "T01-000") {$cod_assocN = "T01";
                                                             }else
                         if($vendas->cod_assoc == "T01")     {$cod_assocN = "T01-000";}
                             
                            $t_Conta        =$this->input->get('t_Conta');
                            $t_ContaComb    =$this->input->get('t_ContaComb');
                            $par_ES2        =$idFin;
                
                        $data = array(
                            'conta'         => $conta_Destin,
                            'tipo_Conta'    => $t_ContaComb,
                            'cod_compassion'=> $vendas->cod_compassion,
                            'cod_assoc'     => $cod_assocN,
                            'num_Doc_Banco' => $vendas->num_Doc_Banco,
                            'num_Doc_Fiscal'=> $vendas->num_Doc_Fiscal,
                            'historico'     => $vendas->historico,
                            'descricao'     => "combinar E-S ".date('Y-m-d'),
                            'dataFin'       => $vendas->dataFin,
                            'valorFin'      => $vendas->valorFin,
                            'ent_Sai'       => $ent_SaiN,
                            'tipo_Pag'      => $vendas->tipo_Pag,
                            'conta_Destino' => $vendas->conta,
                            'saldo'         => $vendas->saldo,
                            'saldo_Mes'     => 'N',
                            'cadastrante'   => 1,
                            'par_ES'        => $par_ES2
                        );                        
                        if($addc == 1 )
			             if ($this->Relatorios_model->add('aenpfin',$data) == TRUE) { 
                            
                        $vendasdatafin = $this->Relatorios_model->vendasRapidX($dataFn,$dataFn );
                          $addc = 1;
                          foreach ($vendasdatafin as $vIdFin) 
                          {                              
                            $idfin01    = $vIdFin->par_ES;
                              
                              if($idfin01 == $idFin) 
                              { $idfin02    = $vIdFin->id_fin;
                                                     
                                    $data02 = array(
                                        'par_ES'        => $idfin02
                                    );
                                    if ($this->Relatorios_model->edit('aenpfin', $data02, 'id_fin', $idFin) == TRUE)  
                                    {
                                        }
                                }   
                          }
                
                         
                         }
                    }
                }
            }
            
        if(null !== ($this->input->get('similares')) && $this->input->get('similares') != 0)
        {
            $idSimilar  = $this->input->get('similares');
            $dat        = $this->input->get('data');
            $valor      = $this->input->get('valor');
            $_SESSION['similares']  = $this->input->get('similares');
            $data['similar'] = $this->Relatorios_model->vendasSimilares($idSimilar,$dat,$valor);
        }
        //$this->input->get('id_fin')  = "";
        //$_SESSION['tipo'] = "";
        $data['caixas'] = $this->Relatorios_model->get2('caixas');    
        $data['vendas'] = $this->Relatorios_model->vendasCustom($dataInicial,$dataFinal,$cliente,$responsavel);
        $this->load->view('relatorios/imprimir/imprimirVendas', $data);
        }else{
        $data['caixas'] = $this->Relatorios_model->get2('caixas');    
        $data['saldo'] = $this->Relatorios_model->vendasSaldoAnterior($dataInicial,$dataFinal,$cliente,$cliente);
            
            
        $data['vendas'] = $this->Relatorios_model->vendasCustom($dataInicial,$dataFinal,$cliente,$responsavel);
            
         
        
            
        if($pdf == 0)  
            $this->load->view('relatorios/imprimir/imprimirVendas', $data);
        else{
            $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
            $this->load->helper('mpdf');
            pdf_create($html, 'Relat_SINT_'.date('d-m-y', strtotime($_SESSION['dataInicio'])).'a' .date('d-m-y', strtotime($_SESSION['dataFim'])).' ' . date('d_m H_i').'h', TRUE);
        }   
            
            
        }
    }
}
