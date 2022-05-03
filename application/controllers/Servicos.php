<?php

class Servicos extends CI_Controller {
    

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
        $this->load->model('servicos_model', '', TRUE);
        $this->data['menuServicos'] = 'Serviços';
    }
	
	function index(){
		$this->gerenciar();
	}

	
	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'index.php/servico/gerenciar/';
        $config['total_rows'] = $this->servicos_model->count('cod_compassion');
        $config['per_page'] = 200;
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
        
        $this->data['usuario'] = $this->servicos_model->getByIdUser($this->session->userdata('id'));
        
        $user = $this->servicos_model->getByIdUser($this->session->userdata('id'));
        
        $contaU = $user->conta_Usuario;
        
        
        
        {
           $this->data['results'] = $this->servicos_model->get('cod_compassion','*','',$config['per_page'],$this->uri->segment(3));
       	
        }
            $texto = '';
            $inicio = '';
        
        $altera = $this->input->post('altera');
        if($altera == 'tito')
        {
            
            $inicio = $this->input->post('inicio');
            $resultsVendas = $this->servicos_model->get22('aenpfin','id_fin',$inicio);
          //  $resultsCod = $this->servicos_model->get2('cod_compassion','cod_Comp');

             foreach ($resultsVendas as $r) {
                if (strlen($r->cod_compassion) == 8 && substr($r->cod_compassion, 3,1) == '-') 
                {
                    $codN = substr($r->cod_compassion, 0,3).' - '.substr($r->cod_compassion, -4);
                    
                        $texto .= $r->id_fin.': '.$r->cod_compassion.' ->'.$codN.' |';

                        $data = array(
                            'cod_compassion' => $codN
                        );

                    //    if ($this->servicos_model->edit('aenpfin', $data, 'id_fin', $r->id_fin) == TRUE) 
                        {
                        }

                        }   
                    
                    
                }
                    


        }
        
      //   $this->session->set_flashdata('success','Altera '.$altera.', Inicio '.$inicio.' | '.$texto);
            
         
	    
	    $this->data['view'] = 'servicos/servicos';
       	$this->load->view('tema/topo',$this->data);

	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aServico')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'nomeI' => set_value('nomeCliente'),
                'data_Nasc' => set_value('data_Nasc'),
                'data_entrada' => set_value('data_entrada'),
                'cpf_I' => set_value('documento'),
                'rg_I' => set_value('rg'),
                'sexo' => $this->input->post('sexo'),
                'status' => $this->input->post('status')
            );

            if ($this->servicos_model->add('idosos', $data) == TRUE) {
                $this->session->set_flashdata('success','idoso adicionado com sucesso!');
                redirect(base_url() . 'index.php/servicos/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'servicos/adicionarServico';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eServico')){
           $this->session->set_flashdata('error','Você não tem permissão para editar clientes.');
           redirect(base_url());
        }


        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'nomeI' => set_value('nomeCliente'),
                'data_Nasc' => $this->input->post('data_Nasc'),
                'data_entrada' => $this->input->post('data_entrada'),
                'cpf_I' => $this->input->post('documento'),
                'rg_I' => $this->input->post('rg'),
                'sexo' => $this->input->post('sexo'),
                'status' => $this->input->post('status')
            );

            if ($this->servicos_model->edit('idosos', $data, 'id_idoso', $this->input->post('id_idoso')) == TRUE) {
                $this->session->set_flashdata('success','idoso editado com sucesso!');
                redirect(base_url() . 'index.php/servicos/editar/'.$this->input->post('id_idoso'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result_caixas'] = $this->servicos_model->get2('caixas','id_caixa');  
        $this->data['result'] = $this->servicos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'servicos/editarServico';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->servicos_model->getById($this->uri->segment(3));
        $this->data['results'] = $this->servicos_model->getOsByCliente($this->uri->segment(3));
        $this->data['view'] = 'servicos/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            
            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dServico')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir Idoso.');
               redirect(base_url());
            }

            
            $id =  $this->input->post('id');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Idoso.');            
                redirect(base_url().'index.php/servicos/gerenciar/');
            }

            //$id = 2;
            // excluindo OSs vinculadas ao cliente
            $this->db->where('id_idoso', $id);
            $os = $this->db->get('idosos')->result();

            

            $this->servicos_model->delete('idosos','id_idoso',$id); 

            $this->session->set_flashdata('success','Idoso excluido com sucesso!');            
            redirect(base_url().'index.php/servicos/gerenciar/');
    }
}

