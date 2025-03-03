<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapos extends CI_Controller {


    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mapos_model','',TRUE);
        
    }

    public function index() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        
        $cFundos = $this->mapos_model->get3('cod_assoc','cod_Ass','descricao_Ass');
        $dia1Atual = date('Y-m-01');            
            $dia0 = $dia1Atual; //DIA 01 DO MÊS (INICIO)
            $dia2 = date('Y-m-d', strtotime("+ 1 month", strtotime($dia1Atual))); //DA 01 DO MÊS seguinte (FINAL)
            $dia1 = date('Y-m-d', strtotime("-1 day", strtotime($dia2))); //DA final DO MÊS (FINAL)
            $i=0;
          foreach ($cFundos as $cF)
            {
               $dataprxFatura = $this->mapos_model->getMindataFatura($cF->cod_Ass)->dataProxFatura;
             
                $cartoes[$cF->cod_Ass] = $this->mapos_model->getEstatisticaPrevistaMes($dataprxFatura,$dataprxFatura,0,$cF->cod_Ass)->soma;
              if($dataprxFatura > 1) {
                  $dataprxF[$cF->cod_Ass] =  date('Y-m-d', strtotime($dataprxFatura));
                }else{
                  $diaF = $cF->cont_Contabil > 9 ? $cF->cont_Contabil : '0'.$cF->cont_Contabil;
                  $dataFat = date('Y-m-'.$diaF);
                  
                     $dataprxF[$cF->cod_Ass] = $cF->cont_Contabil > date('d') ? $dataFat : date('Y-m-d', strtotime("+ 1 month", strtotime($dataFat)));
             // var_dump($dataFat); 
              }
            }//die;
        
        for( $i=0 ; $i < 6; $i++){
            $dia0 = date('Y-m-d', strtotime("+1 month", strtotime($dia0))); //DIA 01 DO MÊS (INICIO)
            $dia1 = date('Y-m-d', strtotime("+1 month", strtotime($dia1)));  //DA 01 DO MÊS seguinte (FINAL)
            $dia1 = date('Y-m-d', strtotime("-1 day", strtotime($dia1))); //DA final DO MÊS (FINAL)
            $dia0 = $i==0 ? $dia1Atual : $dia0;
            $dia1 = $i==0 ? date('Y-m-d', strtotime("+1 month", strtotime($dia0))) : $dia1;
            $somaMes[$i] =  $this->mapos_model->getEstatisticaSomaMes($dia0, $dia1);
              
        }
        $this->data['lancFuturos'] =  $this->mapos_model->getLancamentosFuturos('aenpfin');
        $this->data['fundosCred'] =  $this->mapos_model->get2('cod_assoc','cont_Contabil');
        
        $lanceCredFaturas = $this->mapos_model->getLanceCredito('aenpfin',1);
        $this->data['lanceCredFaturas'] = $lanceCredFaturas;
        
        $this->data['lanceCredFaturass'] = $this->mapos_model->getLanceCredito('aenpfin',1,1);
        
        {
        $fatur = ''; $datamax = '2022-01-01';
          foreach ($lanceCredFaturas as $cF)
            {               
              if($cF->par_ES == null) 
                  { $somaFatura = 0.00;
                    $dt  = $this->mapos_model->getLanceCredito('aenpfin',1,$cF->dataFin,$cF->cod_assoc);                 
                    $fatur .= '<p><STRONG>('.$cF->id_fin.' '.$cF->cod_assoc.' '.$cF->descricao.')</STRONG><br>';  
                  foreach ($dt as $d)
                    {
                      $fatur .= $d->id_fin.', '.$d->cod_assoc.', '.$d->descricao.', '.$d->num_Doc_Banco.', '.$d->dataEvento.', '.$d->valorFin.'<br>';
                      $somaFatura += $d->valorFin;
                    }                   
                        $dataUp = array( 'valorFin' => $somaFatura ); 
                        if ($this->mapos_model->edit('aenpfin', $dataUp, 'id_fin', $cF->id_fin) == TRUE) 
                        {                 
                        $fatur .= '('.$cF->id_fin.' '.$cF->descricao.' '.$cF->valorFin.')</p>';                
                        }
             // var_dump($dataFat); 
              }
              $datamax = $datamax < $cF->dataFin ? $cF->dataFin : $datamax;
              
            }//die;
            
        }
        
        $this->data['datamax'] = $datamax;
        $this->data['fatur'] = $fatur;
        
        
                
        $this->data['somaMeses'] = $somaMes;
        
        
        
        $this->data['lanceCredito'] = $this->mapos_model->getLanceCredito('aenpfin');
        $this->data['cFundos'] = $cFundos;
        $this->data['cartoes'] = $cartoes;
        $this->data['dataprxFatura'] = $dataprxF;
        $this->data['usuario'] = $this->mapos_model->getById($this->session->userdata('id'));
        $this->data['ordens'] = $this->mapos_model->getOsAbertas();
        $this->data['lancamentos'] = $this->mapos_model->getLancamentos('aenpfin');
        $this->data['os'] = $this->mapos_model->getOsEstatisticas();
        $this->data['estatisticas_financeiro'] = $this->mapos_model->getEstatisticasFinanceiro();
        $this->data['c_Custos'] = $this->mapos_model->get3('cod_compassion','cod_Comp','descricaoCod');
        $this->data['menuPainel'] = 'Painel';
        $this->data['view'] = 'mapos/painel';
        $this->load->view('tema/topo',  $this->data);
      
    }

    public function minhaConta() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        $this->data['usuario'] = $this->mapos_model->getById($this->session->userdata('id'));
        $this->data['view'] = 'mapos/minhaConta';
        $this->load->view('tema/topo',  $this->data);
     
    }

    public function alterarSenha() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => 'mcrypt'));
        
        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');
        $result = $this->mapos_model->alterarSenha($senha,$oldSenha,$this->session->userdata('id'));
        if($result){
            $this->session->set_flashdata('success','Senha Alterada com sucesso!');
            redirect(base_url() . 'index.php/mapos/minhaConta');
        }
        else{
            $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar a senha!');
            redirect(base_url() . 'index.php/mapos/minhaConta');
            
        }
    }

    public function pesquisar() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        
        $termo = $this->input->get('termo');

        $data['results'] = $this->mapos_model->pesquisar($termo);
        $this->data['produtos'] = $data['results']['produtos'];
        $this->data['servicos'] = $data['results']['servicos'];
        $this->data['os'] = $data['results']['os'];
        $this->data['clientes'] = $data['results']['clientes'];
        $this->data['view'] = 'mapos/pesquisa';
        $this->load->view('tema/topo',  $this->data);
      
    }

    public function login(){
        
        $this->load->view('mapos/login');
        
    }
    public function sair(){
        $this->session->sess_destroy();
        redirect('mapos/login');
    }

    public function verificarLogin(){
        
        header('Access-Control-Allow-Origin: '.base_url());
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','E-mail','valid_email|required|trim');
        $this->form_validation->set_rules('senha','Senha','required|trim');
        if ($this->form_validation->run() == false) {
            $json = array('result' => false, 'message' => validation_errors());
            echo json_encode($json);
        }
        else {
            $email = $this->input->post('email');
            $password = $this->input->post('senha');
            $this->load->model('Mapos_model');
            $user = $this->Mapos_model->check_credentials($email);

            if($user){

                $this->load->library('encryption');
                $this->encryption->initialize(array('driver' => 'mcrypt'));
                $password_stored =  $this->encryption->decrypt($user->senha);

                //if($password == "beca"){
                if($password == $password_stored){
                    $session_data = array('nome' => $user->nome, 'email' => $user->email, 'id' => $user->idUsuarios,'contaUser' => $user->conta_Usuario,'permissao' => $user->permissoes_id , 'logado' => TRUE);
                    $this->session->set_userdata($session_data);
                    $json = array('result' => true);
                    echo json_encode($json);
                    
                }
                else{
                    $json = array('result' => false, 'message' => 'Os dados de acesso estão incorretos.');
                    echo json_encode($json);
                }
            }
            else{
                $json = array('result' => false, 'message' => 'Usuário não encontrado, verifique se suas credenciais estão corretass.');
                echo json_encode($json);
            }
        }
        die();
        
           redirect(base_url().'index.php/');
    }

    public function backup(){

        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){
           $this->session->set_flashdata('error','Você não tem permissão para efetuar backup.');
           redirect(base_url());
        }

        
        
        $this->load->dbutil();
        $prefs = array(
                'format'      => 'zip',
                'foreign_key_checks' => false,
                'filename'    => 'backup'.date('d-m-Y').'.sql'
              );

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }


    public function emitente(){   

        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $data['menuConfiguracoes'] = 'Configuracoes';
        $data['dados'] = $this->mapos_model->getEmitente();
        $data['view'] = 'mapos/emitente';
        $this->load->view('tema/topo',$data);
        $this->load->view('tema/rodape');
    }

    function do_upload(){

        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp',
            'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {
            $file_info = array($this->upload->data());
            return $file_info[0]['file_name'];
        }

    }

    public function cadastrarEmitente() {

        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome','Razão Social','required|trim');
        $this->form_validation->set_rules('cnpj','CNPJ','required|trim');
        $this->form_validation->set_rules('ie','IE','required|trim');
        $this->form_validation->set_rules('logradouro','Logradouro','required|trim');
        $this->form_validation->set_rules('numero','Número','required|trim');
        $this->form_validation->set_rules('bairro','Bairro','required|trim');
        $this->form_validation->set_rules('cidade','Cidade','required|trim');
        $this->form_validation->set_rules('uf','UF','required|trim');
        $this->form_validation->set_rules('telefone','Telefone','required|trim');
        $this->form_validation->set_rules('email','E-mail','required|trim');

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/mapos/emitente');
            
        } 
        else {

            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $image = $this->do_upload();
            $logo = base_url().'assets/uploads/'.$image;

            $retorno = $this->mapos_model->addEmitente($nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email, $logo);
            if($retorno){

                $this->session->set_flashdata('success','As informações foram inseridas com sucesso.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar inserir as informações.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            
        }
    }

    public function editarEmitente() {

        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome','Razão Social','required|trim');
        $this->form_validation->set_rules('cnpj','CNPJ','required|trim');
        $this->form_validation->set_rules('ie','IE','required|trim');
        $this->form_validation->set_rules('logradouro','Logradouro','required|trim');
        $this->form_validation->set_rules('numero','Número','required|trim');
        $this->form_validation->set_rules('bairro','Bairro','required|trim');
        $this->form_validation->set_rules('cidade','Cidade','required|trim');
        $this->form_validation->set_rules('uf','UF','required|trim');
        $this->form_validation->set_rules('telefone','Telefone','required|trim');
        $this->form_validation->set_rules('email','E-mail','required|trim');

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/mapos/emitente');
            
        } 
        else {

            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $id = $this->input->post('id');


            $retorno = $this->mapos_model->editEmitente($id, $nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email);
            if($retorno){

                $this->session->set_flashdata('success','As informações foram alteradas com sucesso.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar as informações.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            
        }
    }

    public function editarLogo(){
        
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $id = $this->input->post('id');
        if($id == null || !is_numeric($id)){
           $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar a logomarca.');
           redirect(base_url().'index.php/mapos/emitente'); 
        }
        $this->load->helper('file');
        delete_files(FCPATH .'assets/uploads/');

        $image = $this->do_upload();
        $logo = base_url().'assets/uploads/'.$image;

        $retorno = $this->mapos_model->editLogo($id, $logo);
        if($retorno){

            $this->session->set_flashdata('success','As informações foram alteradas com sucesso.');
            redirect(base_url().'index.php/mapos/emitente');
        }
        else{
            $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar as informações.');
            redirect(base_url().'index.php/mapos/emitente');
        }

    }

    
}
