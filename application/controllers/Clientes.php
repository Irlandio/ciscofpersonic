<?php

class Clientes extends CI_Controller {
    
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
            $this->load->helper(array('codegen_helper'));
            $this->load->model('clientes_model','',TRUE);
            $this->data['menuClientes'] = 'clientes';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
        $where_array = array();

        $tipo = $this->input->get('tipo');
        $pesquisa = $this->input->get('pesquisa');
        $count = 25;
        if($pesquisa){
           $where_array['pesquisa'] = $pesquisa;
        $count = 10;
        }
        if($tipo){
           $where_array['tipo'] = $tipo;
        if($tipo == 3)$count = 250;
        }
   
        $config['base_url'] = base_url().'index.php/clientes/gerenciar/';
        $config['total_rows'] = $this->clientes_model->count('clientes');
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
        
        $this->data['usuario'] = $this->clientes_model->getByIdUser($this->session->userdata('id'));
        
        $user = $this->clientes_model->getByIdUser($this->session->userdata('id'));
        
        $contaU = $user->conta_Usuario;
        
        if($contaU == 99)
        {
            $this->data['results'] = $this->clientes_model->get('clientes','idClientes,nomeCliente,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep',$where_array, $config['per_page'],$this->uri->segment(3));
       	
        }else
           {
        $this->data['results'] = $this->clientes_model->get0('clientes','idClientes,nomeCliente,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep',$contaU,$where_array,  $config['per_page'],$this->uri->segment(3));
            }
	    
       	$this->data['view'] = 'clientes/clientes';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $brProjeto = $this->input->post('brProjeto');
            
            switch ($brProjeto) 
                    {					
                        case 4:	$br_Proj = "BR0214";	break;  
                        case 5:	$br_Proj = "BR0518";	break;  
                        case 6:	$br_Proj = "BR0542";	break;  
                        case 7:	$br_Proj = "BR0549";	break;  
                        case 8:	$br_Proj = "BR0579";	break;  				
                    }             
            
            $brBenefic = $br_Proj.'0'.set_value('documento');
                
                $dataNascim     = set_value('dataNasc');
            
                $dataNasc     = explode('/', $dataNascim);
                $dataN    = $dataNasc[2].'-'.$dataNasc[1].'-'.$dataNasc[0];          
                
            $data = array(
                'nomeCliente' => set_value('nomeCliente'),
                'documento' => $brBenefic,
                'telefone' => $brProjeto,
                'celular' => $this->input->post('celular'),
                'pessoa_fisica' => set_value('statu'),
                'sexo' => $this->input->post('sexo'),
                'dataCadastro' => $dataN
            );

            if ($this->clientes_model->add('clientes', $data) == TRUE) {
                $this->session->set_flashdata('success','Beneficiário adicionado com sucesso!');
                redirect(base_url() . 'index.php/clientes/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'clientes/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para editar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $brProjeto = $this->input->post('brProjeto');
            
            switch ($brProjeto) 
                    {					
                        case 4:	$br_Proj = "BR0214";	break;  
                        case 5:	$br_Proj = "BR0518";	break;  
                        case 6:	$br_Proj = "BR0542";	break;  
                        case 7:	$br_Proj = "BR0549";	break;  
                        case 8:	$br_Proj = "BR0579";	break;  				
                    }             
            
            $brBenefic = $br_Proj.'0'.set_value('documento');
                
                $dataNascim     = set_value('dataNasc');
            
                $dataNasc     = explode('/', $dataNascim);
                $dataN    = $dataNasc[2].'-'.$dataNasc[1].'-'.$dataNasc[0];          
                
            $data = array(
                'nomeCliente' => set_value('nomeCliente'),
                'documento' => $brBenefic,
                'telefone' => $brProjeto,
                'celular' => $this->input->post('celular'),
                'pessoa_fisica' => set_value('statu'),
                'sexo' => $this->input->post('sexo'),
                'dataCadastro' => $dataN
            );

            if ($this->clientes_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == TRUE) {
                $this->session->set_flashdata('success','Cliente editado com sucesso!');
                redirect(base_url() . 'index.php/clientes/editar/'.$this->input->post('idClientes'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result_caixas'] = $this->clientes_model->get2('caixas','id_caixa');  
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'clientes/editarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['results'] = $this->clientes_model->getOsByCliente($this->uri->segment(3));
        $this->data['view'] = 'clientes/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            
            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir clientes.');
               redirect(base_url());
            }

            
            $id =  $this->input->post('id');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir cliente.');            
                redirect(base_url().'index.php/clientes/gerenciar/');
            }

            //$id = 2;
            // excluindo OSs vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $os = $this->db->get('os')->result();

            if($os != null){

                foreach ($os as $o) {
                    $this->db->where('os_id', $o->idOs);
                    $this->db->delete('servicos_os');

                    $this->db->where('os_id', $o->idOs);
                    $this->db->delete('produtos_os');


                    $this->db->where('idOs', $o->idOs);
                    $this->db->delete('os');
                }
            }

            // excluindo Vendas vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $vendas = $this->db->get('vendas')->result();

            if($vendas != null){

                foreach ($vendas as $v) {
                    $this->db->where('vendas_id', $v->idVendas);
                    $this->db->delete('itens_de_vendas');


                    $this->db->where('idVendas', $v->idVendas);
                    $this->db->delete('vendas');
                }
            }

            //excluindo receitas vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $this->db->delete('lancamentos');



            $this->clientes_model->delete('clientes','idClientes',$id); 

            $this->session->set_flashdata('success','Cliente excluido com sucesso!');            
            redirect(base_url().'index.php/clientes/gerenciar/');
    }
}

