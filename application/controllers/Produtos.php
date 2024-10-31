<?php

class Produtos extends CI_Controller {
    
    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {
        parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('produtos_model', '', TRUE);
        $this->data['menuProdutos'] = 'Combustivel';
    }

    function index(){
	   $this->gerenciar();
    }

    function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar produtos.');
           redirect(base_url());
        }
        
        $contaUser = $this->session->userdata('contaUser'); 
        $pesquisa = $this->input->get('pesquisa');
        $contas = $this->input->get('contas');
        $benef = $this->input->get('benef');
        $where_array = array();

        if($pesquisa)
        {
            if($contas)
            {
             switch ($contas) 
                    {	        
                        case 4: $contP      = "BR0214";             break;  
                        case 5:	$contP      = "BR0518";             break;  
                        case 6:	$contP      = "BR0542";             break;  
                        case 7:	$contP      = "BR0549";             break;  
                        case 8:	$contP      = "BR0579";             break;  
                    } 
                $where_array['contas'] = $contP;
                $count = 30;
            }
            if($benef)
            {
                $where_array['benef'] = $benef;
                $_SESSION['benef'] = $benef;
            }
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/produtos/gerenciar/';
        $config['total_rows'] = $this->produtos_model->count('combustivel');
        $config['per_page'] = 10;
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

         switch ($contaUser) 
                {	        
                    case 4: $contN      = "BR0214";             break;  
                    case 5:	$contN      = "BR0518";             break;  
                    case 6:	$contN      = "BR0542";             break;  
                    case 7:	$contN      = "BR0549";             break;  
                    case 8:	$contN      = "BR0579";             break;  
                    case 99:$contN      = 99;                   break; 	
                } 
        $this->data['results'] = $this->produtos_model->get('combustivel','*',0,$contN,$where_array,$config['per_page'],$this->uri->segment(3));
        $periodos = $this->produtos_model->get('combustivel','*',1,$contN,$where_array,$config['per_page'],$this->uri->segment(3));
        $mensal = $semanal = array();
        $mesAnterior = date('Y-m');
        $mesAnterior = $semanaAnterior = '55';
        $i = $m = 0;
        
        foreach ($periodos as $p) {
            $semana = date('W', strtotime($p->data_abast));
            $mesAtual = date('Y-m', strtotime($p->data_abast));
            if($semana != $semanaAnterior){

                $quilometragemF = $semanaAnterior != '55' ? $semanal[$i]['quilometragemI'] : $p->quilometragem;
                if( $semanaAnterior != '55' ) {
                    $semanal[$i]['quilometragemPercorrida'] = $semanal[$i]['quilometragemF'] - $semanal[$i]['quilometragemI'] ;
                    $semanal[$i]['consumo'] = number_format($semanal[$i]['quilometragemPercorrida'] / $semanal[$i]['litros'],2,',','.');
                    ++$i;
                    }
                $semanal[$i]['consumo'] = 0;
                $semanal[$i]['quilometragemPercorrida'] = 0;
                $semanal[$i]['valor'] = 0;
                $semanal[$i]['litros'] = 0;
                $semanal[$i]['quilometragemF'] = $quilometragemF;
                $semanal[$i]['dataF'] = $p->data_abast;
            }
            if($mesAtual != $mesAnterior){

                $quilometragemF = $mesAnterior != '55' ? $mensal[$m]['quilometragemI'] : $p->quilometragem;
                if( $mesAnterior != '55' ) {
                    $mensal[$m]['quilometragemPercorrida'] = $mensal[$m]['quilometragemF'] - $mensal[$m]['quilometragemI'] ;
                    if($mensal[$m]['litros'] == 0){
                        $mensal[$m]['consumo'] = 10.00;
                    } else
                    $mensal[$m]['consumo'] = number_format($mensal[$m]['quilometragemPercorrida'] / $mensal[$m]['litros'],2,',','.');
                    ++$m;
                    }
                $mensal[$m]['consumo'] = 0;
                $mensal[$m]['quilometragemPercorrida'] = 0;
                $mensal[$m]['valor'] = 0;
                $mensal[$m]['litros'] = 0;
                $mensal[$m]['quilometragemF'] = $quilometragemF;
                $mensal[$m]['dataF'] = $p->data_abast;
                
            }
            
            if( $semanaAnterior != '55' ) {
                $semanal[$i]['valor'] += $p->valor;
                $semanal[$i]['litros'] += $p->litros;
            }
            $semanal[$i]['quilometragemI'] = $p->quilometragem;
            $semanal[$i]['dataI'] = $p->data_abast;
            
            if( $mesAnterior != '55' ) {
                $mensal[$m]['valor'] += $p->valor;
                $mensal[$m]['litros'] += $p->litros;
            }
            $mensal[$m]['quilometragemI'] = $p->quilometragem;
            $mensal[$m]['dataI'] = $p->data_abast;
        
            $semanaAnterior = $semana;
            $mesAnterior = $mesAtual;
        }
        $this->data['semanal'] = $semanal;
        $this->data['mensal'] = $mensal;

        // var_dump($semanal);
        // var_dump($quilometragemF);
        // die();

	    
        $this->data['contas'] = $this->produtos_model->get2('caixas');
	    $this->data['beneficiarios'] = $this->produtos_model->getBeneficiarios('clientes',$contN);
       
	    $this->data['view'] = 'produtos/produtos';
       	$this->load->view('tema/topo',$this->data);
       
		
    }
	
    function adicionar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar produtos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $precoCompra = $this->input->post('precoCompra');
            $precoCompra = str_replace(",","", $precoCompra);
            
            $dataC = explode('/', set_value('dataCompra'));
            $dataCompra = $dataC[2].'-'.$dataC[1].'-'.$dataC[0];
            
            // $dataCompra = date('Y-m-d', strtotime(set_value('dataCompra')));
            
            $data = array(
                'quilometragem' => set_value('quilometragem'),
                'data_abast' => $dataCompra,
                'litros' => set_value('litros'),
                'valor' => $precoCompra,
                'posto' => set_value('posto'),
                'veiculo' => set_value('veiculo')
            );

            if ($this->produtos_model->add('combustivel', $data) == TRUE) {
                $this->session->set_flashdata('success','Abastecimento adicionado com sucesso!');
                redirect(base_url() . 'index.php/produtos/produtos/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['resultUltimo']     = $this->produtos_model->getIdultimo('combustivel','data_abast');
        $this->data['postos'] = $this->produtos_model->get2('postos');

        $this->data['view'] = 'produtos/adicionarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para editar produtos.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $result = $this->produtos_model->getById('clientes','documento',$this->input->post('benef'));          
            $data = array(
                'nome_beneficiario' => $result->nomeCliente,
                'n_beneficiario'    => $result->documento,
                'n_protocolo'       => $this->input->post('protocolo')   
            );
            
            if ($this->produtos_model->edit('presentes_especiais', $data, 'id_presente', $this->input->post('id_presente')) == TRUE) {
                $this->session->set_flashdata('success','Presente editado com sucesso!');
                redirect(base_url() . 'index.php/produtos/editar/'.$this->input->post('idProdutos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Um Erro ocorreu!</p></div>';
            }
        }
        $result = $this->produtos_model->getById('presentes_especiais','id_presente',$this->uri->segment(3));
        $contBR = substr($result->n_beneficiario,-11,6); 
             switch ($contBR) 
                    {	        
                        case "BR0214":  $contN     = 4; break;  
                        case "BR0518":	$contN     = 5; break;  
                        case "BR0542":	$contN     = 6; break;  
                        case "BR0549":	$contN     = 7; break;  
                        case "BR0579":	$contN     = 8; break;  
                    } 
        $this->data['contBR'] = $contBR;
        $this->data['result'] = $this->produtos_model->getById('presentes_especiais','id_presente',$this->uri->segment(3));
	    $this->data['beneficiarios'] = $this->produtos_model->getBeneficiarios('clientes',$contN);

        $this->data['view'] = 'produtos/editarProduto';
        $this->load->view('tema/topo', $this->data);     
    }
    
    function visualizar() {
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar produtos.');
           redirect(base_url());
        }

        $result = $this->produtos_model->getById('presentes_especiais','id_presente',$this->uri->segment(3));
        $resultProtocolo = $this->produtos_model->getByIds('presentes_especiais','n_protocolo',$result->n_protocolo);
    //    $qtd = array_count_values($resultProtocolo);
        $qt =0;
        foreach ($resultProtocolo as $r) 
            {  $qt++;
                $var='resultFin'.$qt;
            //    $this->data['resultFin'] = $this->produtos_model->getById('aenpfin','id_fin',$r->id_saida);
                $this->data[$var] = $this->produtos_model->getById('aenpfin','id_fin',$r->id_saida);
        //       var_dump($$var); echo $var;
            }
     //   exit;

    //    $this->data[$$var] = $resultFin;
        $this->data['result'] = $resultProtocolo;

        if($this->data['result'] == null){
            $this->session->set_flashdata('error','Produto não encontrado.');
            redirect(base_url() . 'index.php/produtos/editar/'.$this->input->post('idProdutos'));
        }

        $this->data['view'] = 'produtos/visualizarProduto';
        $this->load->view('tema/topo', $this->data);
     
    }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir produtos.');
           redirect(base_url());
        }

        
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir produto.');            
            redirect(base_url().'index.php/produtos/gerenciar/');
        }

        $this->db->where('produtos_id', $id);
        $this->db->delete('produtos_os');


        $this->db->where('produtos_id', $id);
        $this->db->delete('itens_de_vendas');
        
        $this->produtos_model->delete('produtos','idProdutos',$id);             
        

        $this->session->set_flashdata('success','Produto excluido com sucesso!');            
        redirect(base_url().'index.php/produtos/gerenciar/');
    }
}

