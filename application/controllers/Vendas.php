<?php

class Vendas extends CI_Controller
{


    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */

    function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('vendas_model', '', TRUE);
        $this->data['menuVendas'] = 'Vendas';
        $_SESSION['DATA_FIM_BR518'] = '2022-11-30';
        $_SESSION['DATA_LIMITE_INICIO'] = '2023-01-01';
        $this->load->library('user_agent');
    }

    function verificaPermissoesData($dataFin, $ct, $acao = 'e')
    {
        $ct = $ct < 10 ? '0' . $ct : $ct;
        $mesAtual01 = date('Y-m-01');
        $mes_atraz_1 = date('Y-m-d', strtotime("-1 month", strtotime($mesAtual01)));
        $mes_atraz_3  = date('Y-m-d', strtotime("-3 month", strtotime($mesAtual01)));
        $mes_atraz_6  = date('Y-m-d', strtotime("-6 month", strtotime($mesAtual01)));
        $mes_atraz_12  = date('Y-m-d', strtotime("-12 month", strtotime($mesAtual01)));
        $atraz_2ano  = date('Y-m-d', strtotime("-24 month", strtotime($mesAtual01)));
        $atraz_3ano  = date('Y-m-d', strtotime("-36 month", strtotime($mesAtual01)));
        $atraz_1ano  = date('Y-01-d', strtotime($mes_atraz_12));
        $atraz_Definido  = '2023-01-01';
        if ($dataFin >= $mes_atraz_1) {
            if ($this->permission->checkPermission($this->session->userdata('permissao'), $acao . 'C' . $ct . '_01')) {
                echo 'aLancamento_antigos_1mes';
                echo '1 mês ';
                return true;
            }
        } else
            if ($dataFin >= $mes_atraz_3) {
            if ($this->permission->checkPermission($this->session->userdata('permissao'), $acao . 'C' . $ct . '_03')) {
                echo 'aLancamento_antigos_3mes';
                echo '3 mês ';
                return true;
            }
        } else
                if ($dataFin >= $mes_atraz_6) {
            if ($this->permission->checkPermission($this->session->userdata('permissao'), $acao . 'C' . $ct . '_06')) {
                echo 'aLancamento_antigos_6mes';
                echo '6 mês ';
                return true;
            }
        } else
                    if ($dataFin >= $mes_atraz_12) {
            if ($this->permission->checkPermission($this->session->userdata('permissao'), $acao . 'C' . $ct . '_12')) {
                echo 'aLancamento_antigos_1ano';
                return true;
            }
        } else
                        if ($dataFin >= $atraz_1ano) {
            if ($this->permission->checkPermission($this->session->userdata('permissao'), $acao . 'C' . $ct . '_12')) {
                //     echo 'aLancamento_antigos_1ano'; return true;
                // } else 
                if ($this->session->userdata('id') == 24 || ($this->session->userdata('id') == 29 && ($ct == "01" || $ct == "02" || $ct == "09"))) {
                    echo 'aLancamento_antigos_1ano';
                    return true;
                }
            }
        } else
                            if ($dataFin >=  $atraz_Definido) {
            if ($this->permission->checkPermission($this->session->userdata('permissao'), $acao . 'C' . $ct . '_12')) {
                //     echo 'aLancamento_antigos_1ano'; return true;
                // } else 
                if ($this->session->userdata('id') == 24 || ($this->session->userdata('id') == 29 && ($ct == "01" || $ct == "02" || $ct == "09"))) {
                    echo 'aLancamento_antigos_1ano';
                    return true;
                }
            }
        } {
            // echo $acao.'Lancamento_antigos_1ano '.$dataFin.' '.$mes_atraz_1.' '.$mes_atraz_2.' '.$mes_atraz_3.' '.$mes_atraz_12; 
            return false;
        }
    }

    function index()
    {
        $this->gerenciar();
    }

    function gerenciar()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $where_array = array();

        $cod = $this->input->get('cod');
        $pesquisa = $this->input->get('pesquisa');
        $status = $this->input->get('status');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');
        $count = 20;
        if ($cod) {
            $where_array['cod'] = $cod;
            $count = 30;
        }
        if ($pesquisa) {
            $where_array['pesquisa'] = $pesquisa;
            $count = 30;
        }
        if ($status) {
            $where_array['status'] = $status;
            $count = 100;
        }
        if ($de) {

            $de = explode('/', $de);
            $de = $de[2] . '-' . $de[1] . '-' . $de[0];
            $where_array['de'] = $de;
            $count = 100;
        }
        if ($ate) {
            $ate = explode('/', $ate);
            $ate = $ate[2] . '-' . $ate[1] . '-' . $ate[0];
            $where_array['ate'] = $ate;
            $count = 100;
        }


        $config['base_url'] = base_url() . 'index.php/vendas/gerenciar/';
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

        if ($contaU == 99) {
            $contaUser = array();
            for ($i = 1; $i < 11; $i++) {
                $permissVConta = 'vC' . $i;
                if ($this->permission->checkPermission($this->session->userdata('permissao'), $permissVConta))
                    $contaUser[] = $i;
                var_dump($permissVConta);

                // string(3) "vC1" string(3) "vC2" string(3) "vC3" string(3) "vC4" string(3) "vC5" string(3) "vC6" string(3) "vC7" string(3) "vC8" string(3) "vC9" string(4) "vC10"
            }
            //  var_dump($this->permission->checkPermission($this->session->userdata('permissao'), 'vC1', true));
            //  var_dump($contaUser);
            //  die();
            $this->data['results'] = $this->vendas_model->get('aenpfin', '*', $contaUser, $where_array, $config['per_page'], $this->uri->segment(3));
        } else {
            $this->data['results'] = $this->vendas_model->get0('aenpfin', '*', $contaU, '', $config['per_page'], $this->uri->segment(3));
        }


        $this->data['result_codComp'] = $this->vendas_model->get2('cod_compassion');
        $this->data['result_codIead'] = $this->vendas_model->get2('cod_assoc');
        $this->data['result_caixas'] = $this->vendas_model->get2('caixas');
        $this->data['anexos'] = $this->vendas_model->get2('anexos');
        $this->data['presentesEsp'] = $this->vendas_model->get2('presentes_especiais');
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


        if (null !==  $this->input->post('idLanc')) {
            $idlanc = $this->input->post('idLanc');
            $this->data['result_A'] = $this->vendas_model->getById($this->input->post('idLanc'));
            $this->data['result_chekk'] = $this->vendas_model->getByIdChek($this->input->post('idLanc'));

            require_once 'apoio/conexao.class.php';
            $con = new Conexao();
            $con->connect();
            $conex = $_SESSION['conex'];

            //echo $this->input->post('idLanc');  
            if ($this->input->post('ent_Sai') == 0) {
                $queryPres = "SELECT * FROM presentes_especiais WHERE id_saida = " . $idlanc;
                $result_queryPres = mysqli_query($conex, $queryPres);
                if (!$result_queryPres) {
                    die("<center>Desculpe, erro na busca de saldo atual.:  "
                        . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
                                    <a href='menu1.php'>Voltar ao Menu</a></center>");
                    //exit;
                }
                if (mysqli_num_rows($result_queryPres) == 0) {
                    echo "Nao existem lançamentos de presentes </br>";
                } else {
                    while ($row_queryPres = mysqli_fetch_assoc($result_queryPres)) {
                        $protocolPres = $row_queryPres['n_protocolo'];
                    }
                    $this->data['presentesE'] = $this->vendas_model->getPresente($protocolPres, $this->input->post('ent_Sai'));
                }
            } else if ($this->input->post('ent_Sai') == 1)
                $this->data['presentesE'] = $this->vendas_model->getPresente($this->input->post('idLanc'), $this->input->post('ent_Sai'));

            //  $this->data['result_A'] = $this->vendas_model->getById($this->uri->segment(3));
        }

        $this->data['view'] = 'vendas/vendas';
        $this->load->view('tema/topo', $this->data);
    }

    function ajusteSaldo($caixa, $t_conta, $dataF)
    {
        $id_anterior = null;
        $saldo_mes = 'N';


        $datainicioLimite = $_SESSION['DATA_LIMITE_INICIO'];
        if (($caixa == 4 || $caixa == 5) && $dataF > $_SESSION['DATA_FIM_BR518'])
            $cCaixArr = array(4, 5);
        else
            $cCaixArr = array($caixa);
        $menorMaior = 'dataFin <';
        $saldoAtualID = $this->vendas_model->getSaldo($cCaixArr, $t_conta, $datainicioLimite, $menorMaior);

        $id_saldo_Penultimo = $saldoAtualID->id_fin;
        $saldo_Penultimo = $saldoAtualID->saldo;
        $data_saldo_Penultimo = $saldoAtualID->dataFin;


        //******busca de todos registro, após o penultimo saldo *********
        if (($caixa == 4 || $caixa == 5) && $dataF > $_SESSION['DATA_FIM_BR518'])
            $cCaixArr = array(4, 5);
        else
            $caixArr = array($caixa);
        $menorMaior = 'dataFin >';

        $maisRecentes = $this->vendas_model->getAtualizarOsSaldo($cCaixArr, $t_conta, $data_saldo_Penultimo, $menorMaior);

        //inicia variavel do dia final do mes do registro anterior com o dia fim do mês do lançamento

        $fim_mes = ultimoDiaMes($dataF);

        $s_anterior =    $saldo_Penultimo;
        //                while ($maisRecent = mysqli_fetch_assoc($maisRecentes))

        foreach ($maisRecentes as $r) {
            $oK = 0;
            if ($dataF > $_SESSION['DATA_FIM_BR518']) {
                if ($caixa == 5 || $caixa == 4) {
                    if (($r->conta == 5 || $r->conta == 4) && ($r->dataFin > $_SESSION['DATA_FIM_BR518'])) {
                        $oK = 1;
                    } else if ($caixa == $r->conta) $oK = 1;
                } else if ($caixa == $r->conta) $oK = 1;
            } else if ($caixa == $r->conta) $oK = 1;
            if ($oK == 1) {
                //if ($maisRecent['dataFin > $dataF) 
                //{
                $ent_Sai = $r->ent_Sai;
                if ($ent_Sai == 0) {
                    $s_Atual = $s_anterior - $r->valorFin; //$valorFin;
                } else if ($ent_Sai == 1) {
                    $s_Atual = $s_anterior + $r->valorFin;
                }
                $dataS = array(
                    'saldo' => $s_Atual
                );
                if ($this->vendas_model->edit('aenpfin', $dataS, 'id_fin', $r->id_fin) == TRUE)
                //                            $upd = "UPDATE aenpfin SET saldo = ".$s_Atual." WHERE (id_fin =  ".$r->id_fin.")";
                //                            $atualiz = mysqli_query($conex,$upd);
                //                            if ($atualiz) 
                {
                } else {
                    die("<center>Desculpe, Erro na atualização.:  "
                        . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>				
                    <a href='menuF.php'>Voltar ao Menu</a></center>");    //exit;												
                }
                //}
                $s_anterior =    $s_Atual;
                $dataX = $r->dataFin;
                $d_anterior = $dataX;
                $data_ultimo_dia = ultimoDiaMes($dataX); //inicia variavel do dia final do mes do registro atual
                if (null !== $id_anterior) {
                    if ($dataX > $fim_mes) {
                        $saldo_mes = "S"; // Marca se for o ultimos registro de saldos de cada mes 
                    } else $saldo_mes = "N";


                    $dataS = array(
                        'saldo_Mes' => $saldo_mes
                    );
                    if ($this->vendas_model->edit('aenpfin', $dataS, 'id_fin', $id_anterior) == TRUE)

                    //                                $upd = "UPDATE aenpfin SET saldo_Mes = '".$saldo_mes."' WHERE (id_fin = ".$id_anterior.")";
                    //                                $atualiz = mysqli_query($conex, $upd);
                    //                                if ($atualiz) 
                    {
                    } else {
                        die("<center>Desculpe, Erro na atualização.:  "
                            . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
                        <a href='menuF.php'>Voltar ao Menu</a></center>");    //exit;												
                    }
                }
                if ($saldo_mes == "S") $s_mes = "| Saldo do mês.";
                else $s_mes = "";
                //                    echo '<font color=red size="2"> Conta '.$r->conta;
                //                    echo ' | Tipo '.$r->tipo_Conta. ' | Data </font> <font color=green>'.$d_anterior. ' </font> <font color=red>
                //                    | Registro '.$id_anterior. ' | Saldo alterado para '.$s_Atual. '  
                //                    '.$s_mes. ' <td></font><br />';
                $id_anterior = $r->id_fin;
                $fim_mes = $data_ultimo_dia;
            }
        }
        return TRUE;
    }
    function adicionar()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar Vendas.');
            redirect(base_url());
        }
        //        $_SESSION['textoSomatorio'] = '';
        //        $_SESSION['textoSomatorioItens'] = '';
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $conta   = $this->input->post('conta');
        $t_conta = $this->input->post('tipCont');
        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $datainicioLimite = $_SESSION['DATA_LIMITE_INICIO'];
        // if ($this->form_validation->run('vendas') == false) {
        if ($this->input->post('razaoSoc') == null) {
            //  $this->session->set_flashdata('error','Falha na verificação');
            $this->data['custom_error'] = (validation_errors() ? true : false);

            if ($this->input->post('conta') !== null) {
                $contta = $this->input->post('conta');
                if ($this->input->post('presentes') !== null) {

                    $presentess = $this->input->post('presentes');

                    //  if($conta > 8)  $datainicioLimite = '2022-01-01';else   $datainicioLimite = '2022-01-01';

                    if (($contta < 4 || $contta > 8) &&  $presentess == "true") {
                        //  $this->session->set_flashdata('error','Falha na verificação');
                        $this->session->set_flashdata('error', 'Para a conta selecionada não existe presente especial! Selecione novamente.');
                        redirect(base_url() . 'index.php/vendas');
                    }
                }
            }
        } else {

            $user_id = $this->vendas_model->getByIdUser($this->session->userdata('id'));
            $permissoes_id = $user_id->permissoes_id;

            $dataVendaSecion = $this->input->post('dataVenda');
            $dataVenda = $this->input->post('dataVenda');
            try {
                //   echo $dataVenda;
                $dataVenda     = explode('/', $dataVenda);
                $dataF    = $dataVenda[2] . '-' . $dataVenda[1] . '-' . $dataVenda[0];
            } catch (Exception $e) {
                $dataF = date('Y/m/d');
            }

            include 'apoio/funcao.php';
            require_once 'apoio/conexao.class.php';
            // require_once 'funcao.php';
            $con = new Conexao();
            $con->connect();
            $conex = $_SESSION['conex'];
            // if(null !==  ( $this->input->post('id_caixa')))
            //****** VARIAVEIS RECEBIDAS******
            {
                $caixa         = $this->input->post('conta');
                $tipoCont      = $this->input->post('tipoCont');
                $cod_assoc     = $this->input->post('cod_Ass');
                $cod_compassion  = $this->input->post('cod_Comp');
                $num_Doc       = $this->input->post('numeroDoc');
                $numDocFiscal  = $this->input->post('numDocFiscal');
                $razaoSoc      = $this->input->post('razaoSoc');
                $descri        = $this->input->post('descri');
                $saldo_Final   = $this->input->post('saldo_Atual');
                $diaUm_mêsAtual = $this->input->post('diaUm_mêsAtual');
                $valorFin      = $this->input->post('valorFin');
                if (null !== ($this->input->post('v_Valores'))) {
                    $v_Valores = $this->input->post('v_Valores');
                }
                $tipo_Pag     = $this->input->post('tipoPag');
                $ent_Sai       = $this->input->post('tipoES'); //Código para ENTRADA  é ( 1 ) para SAÍDA  é ( 0 )
                $conta_Destino = $this->input->post('conta_Destino'); //Registra Qual a conta beneficiada pelo  lançamento                 
                $cadastrante   = $this->input->post('cadastrante');
                $dia = date('Y-m-d');
                if ($ent_Sai == 0) $entrada_Saida = "saída";
                else if ($ent_Sai == 1) $entrada_Saida = "entrada";
                $saldo_mes_lancamento = 'S';
                $tip_Cont      = $tipoCont;
                $contaX        = $caixa;
                $saldo_AtualConsult  = $this->input->post('saldo_AtualConsult');
                if (null !== ($this->input->post('qtd_presentes'))) {
                    $qtd_presentes = $this->input->post('qtd_presentes');
                } else {
                    $qtd_presentes = 0;
                }
                if (null !== ($this->input->post('presentes'))) $id_presentes = ($this->input->post('presentes'));
                if (null !== ($this->input->post('id_presentes'))) $id_presentes =  ($this->input->post('id_presentes'));
                if (null !== ($this->input->post('senhaAdm'))) {
                    $senhaAdm  = $this->input->post('senhaAdm');
                }
                $fin_id_form = $this->input->post('fin_id');
                
                $p_Origem = base_url() . 'index.php/vendas/adicionar';
                //*******Verifica se o valor foi digitado adequadamente.
                {
                     if ($valorFin == 0.00) {
                        
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                        <script type=\"text/javascript\">
                                        alert(\"Nenhum valor de lançamento encontrado. Tente novamente! Linha: " . __LINE__ . "\");
                                        </script>";
                        exit;
                    } else if (formatoRealPntVrg($valorFin) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                        //serve pra validar  valores acima e abaixo de 1000
                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    $valorFin;
                        $valorFin  =    ((float)str_replace(",", ".", (str_replace(".", "", $valorFin))));
                    } else if (formatoRealInt($valorFin) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                        //serve pra validar  valores acima e abaixo de 1000
                        //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                        $valorFin  =    number_format(str_replace(".", "", $valorFin), 2, '.', '');
                    } else if (formatoRealPnt($valorFin) == true) {
                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFin  =    $valorFin;
                        $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                    } else if (formatoRealVrg($valorFin) == true) {
                        //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                        $valorFin  =   ((float)str_replace(",", ".", (str_replace(".", "", $valorFin))));
                    } else {
                        echo "O valor digitado não esta nos parametros solicitados";
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                        <script type=\"text/javascript\">
                                        alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: " . __LINE__ . "\");
                                        </script>";
                        exit;
                    }
                }

                $_SESSION['conta']          = $this->input->post('conta');
                $_SESSION['tipoCont']       = $this->input->post('tipoCont');
                $_SESSION['cod_Ass']        = $this->input->post('cod_Ass');
                $_SESSION['cod_Comp']       = $this->input->post('cod_Comp');
                $_SESSION['numeroDoc']      = $this->input->post('numeroDoc');
                $_SESSION['numDocFiscal']   = $this->input->post('numDocFiscal');
                $_SESSION['razaoSoc']       = $this->input->post('razaoSoc');
                $_SESSION['descri']         = $this->input->post('descri');
                $_SESSION['saldo_Atual']    = $this->input->post('saldo_Atual');
                $_SESSION['diaUm_mêsAtual'] = $this->input->post('diaUm_mêsAtual');
                $_SESSION['valorFin']       = $valorFin;
                if (null !== ($this->input->post('v_Valores'))) {
                    $_SESSION['v_Valores'] = $this->input->post('v_Valores');
                }
                $_SESSION['tipoPag']        = $this->input->post('tipoPag');
                $_SESSION['tipoES']         = $this->input->post('tipoES'); //Código para ENTRADA  é ( 1 ) para SAÍDA  é ( 0 )
                $_SESSION['conta_Destino']  = $this->input->post('conta_Destino'); //Registra Qual a conta beneficiada pelo  lançamento
                $_SESSION['cadastrante']    = $this->input->post('cadastrante');
                $_SESSION['dataVenda']      =  $dataVendaSecion;
                $dia = date('Y-m-d');
                $entrada_Saida = $_SESSION['tipoES'];
                $saldo_mes_lancamento = 'S';
                $tip_Cont      =  $_SESSION['tipoCont'];
                $contaX        = $_SESSION['conta'];
                $_SESSION['saldo_AtualConsult']  = $this->input->post('saldo_AtualConsult');

                if (null !== ($this->input->post('presentes'))) {
                    $_SESSION['presentes'] = $this->input->post('presentes');
                    if (null !== ($this->input->post('qtd_presentes'))) $_SESSION['qtd_presentes'] = $this->input->post('qtd_presentes');
                }
                if (null !== ($this->input->post('id_presentes')))   $_SESSION['id_presentes'] = $this->input->post('id_presentes');
                if (null !== ($this->input->post('senhaAdm'))) {
                    $_SESSION['senhaAdm']  = $this->input->post('senhaAdm');
                }


                if (null !== $qtd_presentes && ($qtd_presentes) > 0) {
                    for ($contar = 1; $contar <= $qtd_presentes; $contar++) {
                        $nome = 'nome' . $contar;
                        $CodigoId = 'Codigo' . $contar;
                        $Protocolo = 'Protocolo' . $contar;
                        $valorPre = 'valorPre' . $contar;
                        //	$_SESSION[$nome] = $_POST[$nome];
                        $_SESSION[$CodigoId]    = $_POST[$CodigoId];
                        $_SESSION[$Protocolo] = $_POST[$Protocolo];
                        $_SESSION[$valorPre] = $_POST[$valorPre];
                    }
                }
            }

            $alteracoes = '[' . date('d/m/Y H:i') . '] ' . $this->session->userdata('nome') . ': Criado.';
            $data = array(
                'conta'         => $caixa,
                'tipo_Conta'    => $tipoCont,
                'cod_compassion' => $cod_compassion,
                'cod_assoc'     => $cod_assoc,
                'num_Doc_Banco' => $num_Doc,
                'num_Doc_Fiscal' => $numDocFiscal,
                'historico'     => $razaoSoc,
                'descricao'     => $descri,
                'dataFin'       => $dataF,
                'valorFin'      => $valorFin,
                'ent_Sai'       => $ent_Sai,
                'tipo_Pag'      => $tipo_Pag,
                'conta_Destino' => $conta_Destino,
                'saldo'         => $saldo_Final,
                'saldo_Mes'     => 'S',
                'cadastrante'   => $cadastrante,
                'dataCadastro'  => date('Y-m-d H:i'),
                'alteracoes'    => $alteracoes
            );
            //***** VERIFICAÇÕES PARA LANÇAMENTO           
            {
                $p_Origem = base_url() . 'index.php/vendas/adicionar';
                for ($contar = 1; $contar <= $qtd_presentes; $contar++) {
                    $nome = 'nome' . $contar;
                    $CodigoIdId = 'Codigo' . $contar;
                    $Protocolo = 'Protocolo' . $contar;
                    $valorPre = 'valorPre' . $contar;
                    $entraSai = 'entraSai' . $contar;
                    //  $_SESSION[$nome] = $_POST[$nome];
                    $_SESSION[$CodigoId]    = $_POST[$CodigoId];
                    $_SESSION[$Protocolo] = $_POST[$Protocolo];
                    $_SESSION[$valorPre] = $_POST[$valorPre];
                    $_SESSION[$entraSai] = $_POST[$entraSai];
                }

                if (!$cod_assoc || !$cod_compassion) {
                    echo 'Os códigos IEADALPE  e Compassion não Foram identificados.
                                    Volte a pagina anterior e preencha todos os campos! Caixa ' . $_SESSION[$caixa] . $caixa . ' tipo ' . $_SESSION[$tipoCont] . ' C comp ' . $_SESSION[$cod_compassion] . ' doc ' . $_SESSION[$num_Doc] . '- Cod ASS  ' . $_SESSION[$numDocFiscal] . ' ' . $numDocFiscal . ' - R soc ' . $_SESSION[$razaoSoc] . ' ' . $razaoSoc . ' ' . $cod_assoc . ' - cod Comp ' . $cod_compassion . ' - tipo pag ' . $_SESSION[$tipo_Pag] . ' - ent sai ' . $_SESSION[$ent_Sai] . ' - ' . $_SESSION[$cadastrante] . ' ent sai ' . $_SESSION[$entrada_Saida] . ' ' . $_SESSION[$tip_Cont] . ' qtd pres ' . $_SESSION[$qtd_presentes] . ' ';
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                    <script type=\"text/javascript\">
                                    alert(\"Os códigos IEADALPE  e Compassion não Foram identificados. Volte a pagina anterior e preencha todos os campos! - Linha: " . __LINE__ . "\");
                                    </script>";
                    exit;
                }
                // echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;

                if (!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin) {
                    echo "Conta - " . $caixa . " | Tipo - " . $tipoCont . " | Doc Banco - " . $num_Doc . " | Doc Fiscal " . $numDocFiscal . " | Histórico " . $razaoSoc . " | Data - " . $dataF . " | Valor - " . $valorFin;
                    echo "<p><font color=red>Voce nao entrou com os dados necessarios.
                        Você não informou todos os dados nescessário. Tente novamente!</font</p>";
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                    <script type=\"text/javascript\">
                                    alert(\" Você não informou todos os dados nescessário. Tente novamente! Linha: " . __LINE__ . "\");
                                    </script>";
                    exit;
                }    //URL=PaginaLancamento1.php

                $datahj = date('Y-m-d');
                $data_R = date('Y-m-d', strtotime("-3 month", strtotime($datahj)));
                if ($permissoes_id < 3 && $dataF > $data_R)  $senhaAdm = "aenp@z2023";
                if (!(isset($senhaAdm))) {
                    $senhaAdm = "0000";
                } else if ($senhaAdm == "vid@23") $senhaAdm = "aenp@z2023";
                //echo $datahj;
                //	$dataF= implode('-',array_reverse(explode('/',$data)));
                $data_001 =  primeiroDiaMes($datahj);
                $data_007 =  setimoDiadoMes($datahj);

                if (($datahj > $data_007) && ($dataF < $data_001)) {
                    if (false == $this->verificaPermissoesData($dataF, $caixa, 'a')) //PARAMETRO 'e' editar
                    {
                        echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lançamento referente a esta data foi aspirado. <br/> 
                            Retorne e altere a data ou contate o administrador.</font><br/>";
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                    <script type=\"text/javascript\">
                                    alert(\" Você não possui Permissão para lançamento referente a esta data, Procure o administrador do sistema! Linha: " . __LINE__ . "\");
                                    </script>";
                        exit;
                    } else
                    if ($dataF < $datainicioLimite) {
                        echo "<br/><font color = #458B74 size = 3 text-align:center>Data não autorizada para lançamento. <br/> 
                            Retorne e altere a data ou contate o administrador.</font><br/>";
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                    <script type=\"text/javascript\">
                                    alert(\" Data anterior ao Fechamento do relatório contábil ANUAL não autorizada edição. Tente novamente! Linha: " . __LINE__ . "\");
                                    </script>";
                        exit;
                    }
                }
                if ($dataF < $datainicioLimite || $dataF > $datahj) {
                    echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                        <script type=\"text/javascript\">
                                        alert(\" A data não é uma data válida, tente novamente! Linha: " . __LINE__ . "\");
                                        </script>";
                    exit;
                }
                //   echo "</b></br> Valor recebdo <strong><td> R$  ".$valorFin."</td></strong></br>";            

                //*******Verifica se o valor foi digitado adequadamente.
                {
                    if (formatoRealPntVrg($valorFin) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                        //serve pra validar  valores acima e abaixo de 1000
                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    $valorFin;
                        $valorFin  =    ((float)str_replace(",", ".", (str_replace(".", "", $valorFin))));
                    } else if (formatoRealInt($valorFin) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                        //serve pra validar  valores acima e abaixo de 1000
                        //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                        $valorFin  =    number_format(str_replace(".", "", $valorFin), 2, '.', '');
                    } else if (formatoRealPnt($valorFin) == true) {
                        //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFin  =    $valorFin;
                        $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                    } else if (formatoRealVrg($valorFin) == true) {
                        //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                        $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                        $valorFin  =   ((float)str_replace(",", ".", (str_replace(".", "", $valorFin))));
                    } else {
                        echo "O valor digitado não esta nos parametros solicitados";
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                        <script type=\"text/javascript\">
                                        alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: " . __LINE__ . "\");
                                        </script>";
                        exit;
                    }
                }


                if ($cod_compassion == ("R01 - 1030")) //Entrada com presentes especiais
                {

                    if ($qtd_presentes > 0) {
                    } else {
                        echo "Não há presentes especiais.
                                    Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__;
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                    <script type=\"text/javascript\">
                                    alert(\"Não há presentes especiais.	Volte a pagina anterior e preencha todos os campos! <br>Linha: " . __LINE__ . "\");
                                    </script>";
                        exit;
                    }
                    $textoSomatorioItens = '';
                    $textoSomatorio = '';
                    $valorFinTotal =   "0.00";
                    for ($contar = 1; $contar <= $qtd_presentes; $contar++) {
                        $n_nome = 'nome' . $contar; // Nomes das variaveis de cada cadastro
                        $n_codigo = 'Codigo' . $contar;
                        $n_protocolo = 'Protocolo' . $contar;
                        $n_valorPre = 'valorPre' . $contar;
                        $n_entraSai = 'entraSai' . $contar;

                        $CodigoId    = $_POST[$n_codigo];

                        $Protocolo = $_POST[$n_protocolo];
                        $valorPre = $_POST[$n_valorPre];
                        $entraSai = $_POST[$n_entraSai];

                        if (!$CodigoId  || !$Protocolo  || !$valorPre) {
                            echo "Algum campo do " . $contar . "º Presente da lista não foi preenchido.
                                            Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__;
                            $_SESSION['textoSomatorio'] = $textoSomatorio;
                            $_SESSION['textoSomatorioItens'] = $textoSomatorioItens;
                            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                            <script type=\"text/javascript\">
                                            alert(\"Algum campo do " . $contar . "º Prsente da lista não foi preenchido.Volte a pagina anterior e preencha todos os campos! Linha: " . __LINE__ . "\");
                                            </script>";

                            exit;
                        }
                        $negativ = 0;
                        /*   if ( $valorPre < 0 ) {
                                   $valorPre = abs($valorPre);
                             $negativ = 1;
                            }*/
                        $formatoValor = true;
                        //Verificação dos formatos dos valores
                        {
                            if (formatoRealPntVrg($valorPre) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                                //serve pra validar  valores acima e abaixo de 1000
                                //      echo "Ponto e virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                $valorPreExibe  =    $valorPre;
                                $valorPre  =    (str_replace(",", ".", (str_replace(".", "", $valorPre))));
                            } else if (formatoRealInt($valorPre) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                                //serve pra validar  valores acima e abaixo de 1000
                                //      echo "Inteiro!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                $valorPreExibe  =    number_format(str_replace(",", ".", $valorPre), 2, ',', '.');
                                $valorPre  =    number_format(str_replace(".", "", $valorPre), 2, '.', '');
                            } else if (formatoRealPnt($valorPre) == true) {
                                //     echo "Ponto!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                $valorPre  =    $valorPre;
                                $valorPreExibe  =    number_format(str_replace(",", ".", $valorPre), 2, ',', '.');
                            } else if (formatoRealVrg($valorPre) == true) {
                                //    echo "Virgula!  - <strong><td> ;Linha: ". __LINE__ . ", OK!</td></strong><br/>"; 
                                $valorPreExibe  =    number_format(str_replace(",", ".", $valorPre), 2, ',', '.');
                                $valorPre  =   (str_replace(",", ".", (str_replace(".", "", $valorPre))));
                            } else {
                                $formatoValor = false;
                            }
                            /*  
                            if($valorPre <= 0 )
                            {				echo "Verifique o valor do  ".$contar."º Prsente é inválido.
                                                Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__ ;
                              echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                                <script type=\"text/javascript\">
                                                alert(\"Verifique o valor do  ".$contar."º Prsente é inválido. Volte a pagina anterior e preencha todos os campos!\");
                                                </script>";						  
                             exit; 
                            }*/
                        }

                        //  if($negativ == 1) { $valorPre = number_format($valorPre) * -1;}
                        //   $valorPreExibe = number_format($valorPreExibe) * -1;
                        if ($formatoValor == false) {
                            $textoSomatorio .= "Um ou mais valores inseridos não esta nos parametros solicitados";
                            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                        <script type=\"text/javascript\">
                                        alert(\"Um ou mais valores inseridos não esta nos parametros solicitados. Tente novamente! Linha: " . __LINE__ . "\");
                                        </script>";
                            exit;
                        }
                        if ($entraSai == "0") {
                            $valorFinTotal = $valorFinTotal - $valorPre;
                            $valorPen = 0.00;
                            $idPre = $this->vendas_model->getByIdPre($Protocolo);
                            if (isset($idPre)) {
                                if ($idPre->valor_entrada == $valorPre)
                                    echo $idPre->nome_beneficiario . ' - ' . $idPre->id_presente . '</BR>';
                                else {
                                    echo ' O valor do presente a ser devolvido NÃO esta igual.</BR> Presente' . $idPre->id_presente . ', Data ' . $idPre->data_presente . ' - Valor em aberto R$' . $idPre->valor_entrada . ' - Valor lançado R$' . $valorPreExibe;
                                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=" . $p_Origem . "'> 
                                                    <script type=\"text/javascript\">
                                                    alert(\"O valor do presente a ser devolvido NÃO esta igual. Presente " . $idPre->id_presente . " " . $idPre->n_protocolo . ", Data " . $idPre->data_presente . " ( Valor a devolver R$" . $idPre->valor_entrada . " - Valor lançado R$" . $valorPreExibe . ") - Linha: " . __LINE__ . "\");
                                                    </script>";
                                    exit;
                                }
                            } else {
                                echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=" . $p_Origem . "'> 
                                                    <script type=\"text/javascript\">
                                                    alert(\"NÃo foi encontrado nenhum presente com NÚMERO DE PROTOCOLO " . $Protocolo . ", para ser devolvido. Verifique se este presente é realmente para devolução. - Linha: " . __LINE__ . "\");
                                                    </script>";
                                exit;
                            }
                        } else
                            $valorFinTotal = $valorFinTotal + $valorPre;
                        $textoSomatorioItens .= "Presente " . $contar . "  = R$ <strong>" . $valorPreExibe . "</strong><br>";
                    }
                    $val_Total = $valorFinTotal;

                    $valorTotExibe  =    number_format(str_replace(",", ".", $val_Total), 2, ',', '.');
                    //     echo  "<br><font color = #0cb20c size = 2> Verificar valor =  ".$v_Valores;// variavel pra não cadastrar e voltar
                    $textoSomatorio .= "<br><font color = red size = 2> Soma Total =  R$ <strong>" . $valorTotExibe . "</strong></font> <br><br>";
                    //    echo gettype($valorFinTotal), "<br>";
                    $textoSomatorio .= "<font color = red size = 2>Valor lançado =  R$ <strong>" . $valorFinExibe . "</strong></font><br><br>";
                    // echo gettype($valorFin), "<br>";
                    $val_Total_float = floatval($val_Total);
                    $valorFin_float = floatval($valorFin);
                    if ($v_Valores == "1") {

                        if (($valorFin_float !==  $val_Total_float)) {
                            $textoSomatorio .= "<font color = red><H3>Valor lançado é diferente do somatório</H3></font><br><br>";
                            $textoSomatorio .= "<br><font color = red size = 2> Soma Total =  R$ <strong>" . $valorTotExibe . "</strong></font> (" . $val_Total_float . " " . gettype($val_Total_float) . ") <br><br>";
                            //    echo gettype($valorFinTotal), "<br>";
                            $textoSomatorio .= "<font color = red size = 2>Valor lançado =  R$ <strong>" . $valorFinExibe . "</strong></font> (" . $valorFin_float . " " . gettype($valorFin_float) . ")<br><br>";
                            $_SESSION['textoSomatorio'] = $textoSomatorio;
                            $_SESSION['textoSomatorioItens'] = $textoSomatorioItens;
                            echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=" . $p_Origem . "'> 
                                        <script type=\"text/javascript\">
                                        alert(\"Valor lançado é diferente do somatório! - Linha: " . __LINE__ . "\");
                                        </script>";
                            // echo $textoSomatorio;
                            exit;
                        } else {
                            $textoSomatorio .= "<font color = BLUE><H3>Somatório  é igual ao valor total do lançamento!</H3></font>";
                            $_SESSION['textoSomatorio'] = $textoSomatorio;
                            $_SESSION['textoSomatorioItens'] = $textoSomatorioItens;
                            echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=" . $p_Origem . "'> 
                                        <script type=\"text/javascript\">
                                        alert(\"  Nada foi alterado, retorne e desmarque -visualizar- !\");
                                        </script>";
                            //  echo $textoSomatorio;					  
                            exit;
                        }
                    }

                    $_SESSION['textoSomatorioItens'] = $textoSomatorioItens;

                    var_dump($_SESSION['textoSomatorioItens']);
                }

                //*****se for presente especial faz um lançamento 
                if ($cod_compassion == ("D07 - 0730")) //Saída com presentes especiais
                {
                    //	echo 'linha '. __LINE__;
                    if (!$id_presentes) //Saída com presentes especiais
                    {
                        //echo "cod_compassion: ".$cod_compassion." qtd_presentes: ".$qtd_presentes."<br>";
                        echo "Linha: " . __LINE__ . "<br>Nenhum Beneficiário foi selecionado para este presente especial.
                                    Volte a pagina anterior e preencha todos os campos!";
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                <script type=\"text/javascript\">
                                alert(\" Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos! Linha: " . __LINE__ . "\");
                                </script>";
                        exit;
                    }
                    if ($id_presentes == 0) {
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=" . $p_Origem . "'> 
                                    <script type=\"text/javascript\">
                                    alert(\"Desculpe, Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos!\");
                                    </script>";
                        exit;
                    }

                    $res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
                    if (!$res_max) {
                        die("<center>Desculpe, Nao foi encontrado o ultimo registro. Tente novamente:  "
                            . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
                                <a href='PaginaLancamento1.php'> Tente novamente</a></center>");
                        exit;
                    }
                    if (mysqli_num_rows($res_max) == 0) {
                        echo "Nao foi encontrado nenhum ultimo registro. Tente novamente!"; //exit;
                    }
                    while ($id_ultimo = mysqli_fetch_assoc($res_max)) {
                        $id_Maxaenp = $id_ultimo['id_fin'] + 1;
                    }




                    $presentes_saida = mysqli_query($conex, 'SELECT * FROM presentes_especiais
                                        WHERE  id_presente =  ' . $id_presentes . ' LIMIT 1');

                    if (!$presentes_saida) {
                        die("<center>Desculpe, Nao foi encontrado o registro de presente " . $id_presentes . ". Tente novamente:  "
                            . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
                                <a href='PaginaLancamento1.php'> Tente novamente</a></center>");
                    }



                    if (mysqli_num_rows($presentes_saida) == 0) {
                        echo "<center><font color = red >Nao existem registros do presentes especiais " . $id_presentes . " Linha " . __LINE__ . "</font>";

                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=" . $p_Origem . "'> 
                                    <script type=\"text/javascript\">
                                    alert(\"VNao existem registros do presentes especiais " . $id_presentes . "! - Linha: " . __LINE__ . "\");
                                    </script>";
                        exit;
                    }


                    while ($rows_presentes = mysqli_fetch_assoc($presentes_saida)) {
                        if ($valorFin > $rows_presentes['valor_pendente'] + 4.5) {
                            echo "Linha: " . __LINE__ . "<br>Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento!";
                            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                <script type=\"text/javascript\">
                                alert(\" Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento! Linha: " . __LINE__ . "\");
                                </script>";
                            exit;
                        }
                        $val_Restante = $rows_presentes['valor_pendente'] - $valorFin;
                        $datapresUp = array(
                            'id_saida' => $id_Maxaenp,
                            'data_presente' => $dataF,
                            'valor_saida' => $valorFin,
                            'valor_pendente' => $val_Restante
                        );

                        if ($this->vendas_model->edit('presentes_especiais', $datapresUp, 'id_presente', $rows_presentes['id_presente']) == TRUE) {
                            $this->session->set_flashdata('success', 'presente editado com sucesso!');
                            //  redirect(base_url() . 'index.php/vendas/editar/'.$this->input->post('idVendas'));

                            $id_entrada = $rows_presentes['id_entrada'];
                            $data_presente = $rows_presentes['data_presente'];
                            $n_beneficiario = $rows_presentes['n_beneficiario'];
                            $nome_beneficiario = $rows_presentes['nome_beneficiario'];
                            $n_protocolo = $rows_presentes['n_protocolo'];
                            $valor_entrada = $rows_presentes['valor_entrada'];
                        } else {
                            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                        }
                    }
                    if ($val_Restante > 0) {
                        $datapres = array(
                            'id_entrada'        => $id_entrada,
                            'id_saida'          => 0,
                            'data_presente'     => $data_presente,
                            'projeto'           => $caixa,
                            'n_beneficiario'    => $n_beneficiario,
                            'nome_beneficiario' => $nome_beneficiario,
                            'n_protocolo'       => $n_protocolo,
                            'valor_entrada'     => $valor_entrada,
                            'valor_pendente'    => $val_Restante
                        );
                        if (is_numeric($id = $this->vendas_model->add('presentes_especiais', $datapres, true))) {
                        } else {
                        }
                    }
                }

                echo "Conta lançaento - " . $caixa . " | Tipo - " . $tipoCont . " | Doc Banco - " . $num_Doc . " | Doc Fiscal " . $numDocFiscal . " | Histórico " . $razaoSoc . " | Data - " . $dataF . " | Valor - " . $valorFin . " | conta_Destino - " . $conta_Destino . " | ent_Sai - " . $ent_Sai;
                //exit;	
            }
            //******Insere o lançamento na tabela aenpfin*********
            /*  {				
                  echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=".$p_Origem."'>
                                    <script type=\"text/javascript\">
                                    alert(\"Lançamento OK. Retornando ! <br>Linha: ". __LINE__ . "\");
                                    </script>";						  
                 exit; 
                }*/
            if (is_numeric($id = $this->vendas_model->add('aenpfin', $data, true)))
            //                if (1==1)
            {
                $paginaDestino = "adicionar/";
                //****** Resgata o ID do lançamento feito
                
                $id_Maxaenp = $this->vendas_model->getUltimoId('aenpfin', 'id_fin');
                
                //******busca do ultimo registro com o saldo do mês marcado *********
                //                    echo '<br> Caixa '.(int)$caixa.'<br>';
                if (($caixa == 4 || $caixa == 5) && $dataF > $_SESSION['DATA_FIM_BR518']) {
                    $cCaixArr = array(4, 5);
                } else {
                    $cCaixArr = array((int)$caixa);
                }
                //                  var_dump('<br> Caixa',$cCaixArr); echo '<br>';
                $menorMaior = 'dataFin >';
                $saldoAtualID = $this->vendas_model->getSaldo($cCaixArr, $t_conta, $datainicioLimite, $menorMaior);

                $id_Ultimo_Saldo = $saldoAtualID->id_fin;
                $saldo_Atual = $saldoAtualID->saldo;
                $dataUlt_saldo = $saldoAtualID->dataFin;

                //*****se pagamento for em cheque faz um lançamento de reconciliação bancária
                if ($tipo_Pag == "cheq") {
                    $data_Pag = $dataF;
                    //*********Ja marca se o cheque ja foi compensado e guarda o id do registro atual pra referenciar o id do cheque
                    if (isset($_POST["chequeCompen"])) {
                        $status = 1;
                    } else $status = 0;
                    $datachq = array(
                        'id_aenp'   => $id_Maxaenp,
                        'data_Emissao'  => $data_Pag,
                        'data_Pag'  => $data_Pag,
                        'status'    => $status,
                        'operador'  => $cadastrante
                    );
                    if (is_numeric($id = $this->vendas_model->add('reconc_bank', $datachq, true))) {
                    }
                }
                //*****se for presente especial faz um lançamento 
                if ($cod_compassion == ("R01 - 1030")) //Entrada com presentes especiais
                {
                    for ($contar = 1; $contar <= $qtd_presentes; $contar++) {
                        $n_nome = 'nome' . $contar; //Nomes das variaveis de cada cadastro
                        $n_codigo = 'Codigo' . $contar;
                        $n_protocolo = 'Protocolo' . $contar;
                        $n_valorPre = 'valorPre' . $contar;
                        $n_entraSai = 'entraSai' . $contar;

                        $CodigoId    = $_POST[$n_codigo];
                        $benef   = $this->vendas_model->get2('clientes');
                        foreach ($benef as $rBnf) {
                            if (($rBnf->idClientes  == $CodigoId)) {
                                $nome = $rBnf->nomeCliente;
                                $CodigoBR = $rBnf->documento;
                                $contaBR = $rBnf->telefone;
                            }
                        }
                        $Protocolo = $_POST[$n_protocolo];
                        $valorPre = $_POST[$n_valorPre];
                        $entraSai = $_POST[$n_entraSai];
                        $negativ = 0;
                        $data_presente = $dataF;
                        /*  if ( $valorPre < 0.00 ) {
                               $valorPre = abs($valorPre);
                            $negativ = 1;
                            }*/ {
                            if (formatoRealPntVrg($valorPre) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                                //serve pra validar  valores acima e abaixo de 1000
                                //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                $valorPre  =    ((float)str_replace(",", ".", (str_replace(".", "", $valorPre))));
                            } else if (formatoRealInt($valorPre) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                                //serve pra validar  valores acima e abaixo de 1000
                                //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                $valorPre  =    number_format(str_replace(".", "", $valorPre), 2, '.', '');
                            } else if (formatoRealPnt($valorPre) == true) {
                                //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                $valorPre  =    $valorPre;
                            } else if (formatoRealVrg($valorPre) == true) {
                                $valorPre  =   ((float)str_replace(",", ".", (str_replace(".", "", $valorPre))));
                            }
                        }
                        //  if($negativ == 1) { $valorPre = number_format($valorPre) * -1;}
                        $valorPen = $valorPre;
                        $id_saida = 0;
                        if ($entraSai == "0") // *** SE FOR VALOR DE DEVOLUÇÃO (NEGATIVO)
                        {
                            $valorPre = 0.00 - $valorPre;
                            $valorPen = 0.00;
                            $idPre = $this->vendas_model->getByIdPre($Protocolo); //** PROCURA O PRESENTE A SER DEVOLVIDO
                            if (isset($idPre))
                                echo $idPre->$nome;
                            $id_saida = $id_Maxaenp;
                            $dataP = array(
                                'id_saida'          => $id_Maxaenp,
                                'valor_pendente'    => $valorPen
                            );
                            if ($this->vendas_model->edit('presentes_especiais', $dataP, 'id_presente', $idPre->id_presente) == TRUE) {
                            }
                        }

                        //****Colocar condição para se o valor for negativo procurar o lançamento identico anterior e lançar como saída

                        $datapres = array(
                            'id_entrada'        => $id_Maxaenp,
                            'id_saida'          => $id_saida,
                            'data_presente'     => $data_presente,
                            'projeto'           => $contaBR,
                            'n_beneficiario'    => $CodigoBR,
                            'nome_beneficiario' => $nome,
                            'n_protocolo'       => $Protocolo,
                            'valor_entrada'     => $valorPre,
                            'valor_pendente'    => $valorPen
                        );
                        if (is_numeric($id = $this->vendas_model->add('presentes_especiais', $datapres, true))) {
                        }
                    }
                    $paginaDestino = "gerenciar";
                }
                // ******* Se a data do ultimo saldo for maior que a do lançamento altera todos saldos posteriores			

                //	{**** primeiro dia do mês do lançamento
                $dia_1_mes = primeiroDiaMes($dataF);

                //******AJUSTE DE SALDO
                //******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********	
                //******No caso aqui esta usando como refencia o ultimo saldo de 2018 e recalcula todos os saldos dos lançamentos posteriores***			

                if ($this->ajusteSaldo($caixa, $t_conta, $dataF) == TRUE)
                    echo "<center> "
                        . '<br>Linha: ' . __LINE__ . "<br>													
                        <a href='" . base_url() . "index.php/vendas/gerenciar'>Voltar a Lançamentos</a></center>";
                switch ($caixa) {
                    case 1:
                        $contaNome = "IEADALPE - 1444-3";
                        break;
                    case 2:
                        $contaNome = "22360-3";
                        break;
                    case 3:
                        $contaNome = "ILPI";
                        break;
                    case 4:
                        $contaNome = "BR214";
                        break;
                    case 5:
                        $contaNome = "BR518";
                        break;
                    case 6:
                        $contaNome = "BR542";
                        break;
                    case 7:
                        $contaNome = "BR549";
                        break;
                    case 8:
                        $contaNome = "BR579";
                        break;
                    case 9:
                        $contaNome = "BB 28965-5";
                        break;
                    case 10:
                        $contaNome = "CEF 1948-4";
                        break;
                }
                
                if($fin_id_form != null) {
                    $this->anexarDefinitivo($id_Maxaenp, $fin_id_form);
                    $this->excluirAnexosTemporarios($fin_id_form);
                }
                
                $this->session->set_flashdata('success', 'Lançamento efetuado com sucesso! Conta ' . $contaNome . ' - ' . $tipoCont . ' doc ' . $num_Doc . ' doc Fiscal ' . $numDocFiscal . 'Razão social ' . $razaoSoc . ' ' . $descri . ' - tipo pag ' . $tipo_Pag . '. | <strong>Adicione o ANEXO do documento fiscal.</strong>');
                redirect(base_url() . 'index.php/vendas/' . $paginaDestino);
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . base_url() . "index.php/vendas/'.$paginaDestino>
                            <script type=\"text/javascript\">
                            alert(\"Alterações realizada com sucesso. 
                            Novo lançamento. \");										
                            </script>";
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }


        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $this->data['result_caixas']    = $this->vendas_model->get2('caixas');
        $this->data['resultUltimo']     = $this->vendas_model->getIdultimo($conta, $t_conta);
        $this->data['resultss_Benefic']   = $this->vendas_model->get3('clientes', 'nomeCliente', 'telefone');
        $this->data['result_codComp']   = $this->vendas_model->get3('cod_compassion', 'cod_Comp', 'ent_SaiComp');
        $this->data['result_codIead']   = $this->vendas_model->get3('cod_assoc', 'cod_Ass', 'ent_SaiAss');
        $this->data['pre']              = $this->vendas_model->getPresentes($conta);
        $this->data['anexos'] = $this->vendas_model->getAnexos('anexos', 0);
        $this->data['view']             = 'vendas/adicionarVenda';
        $this->load->view('tema/topo', $this->data);
    }
    function editar()
    {

        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Lançamento');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        //if ($this->form_validation->run('vendas') == false)         
        $user_id = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $permissoes_id = $user_id->permissoes_id;

        $conta          = $this->input->post('conta');

        if ($conta > 8)  $datainicioLimite = '2020-01-01';
        else   $datainicioLimite = '2020-01-01';

        if ($this->input->post('razaoSoc') == null) {
        } else {

            include 'apoio/funcao.php';
            require_once 'apoio/conexao.class.php';
            // require_once 'funcao.php';
            $con = new Conexao();
            $con->connect();
            $conex = $_SESSION['conex'];
            $p_Origem = base_url() . 'index.php/vendas/editar/' . $this->input->post('id_fin');

            $id_fin         = $this->input->post('id_fin');
            $conta          = $this->input->post('conta');
            $tipo_Conta     = $this->input->post('tipo_Conta');
            $tipoCont_Atual = $tipo_Conta;
            $cod_compassion = $this->input->post('cod_Comp');
            $cod_assoc      = $this->input->post('cod_Ass');
            $num_Doc_Banco  = $this->input->post('numeroDoc');
            $num_Doc_Fiscal = $this->input->post('numDocFiscal');
            $razaoSoc       = $this->input->post('razaoSoc');
            $descricao      = $this->input->post('descri');
            $valorFin       = $this->input->post('valorFin');
            $ent_Sai        = $this->input->post('ent_Sai');
            $tipo_Pag       = $this->input->post('tipo_Pag');
            $conta_Destino  = $this->input->post('conta_Destino');
            $dataFin        = $this->input->post('dataVenda');
            $tip_PagAnt     = $this->input->post('tip_PagAnt');
            $cadastrante   = $this->input->post('cadastrante');
            if (null !== ($this->input->post('senhaAdm'))) {
                $senhaAdm  = $this->input->post('senhaAdm');
            }
            try {
                $dataVenda = explode('/', $dataFin);
                $dataF = $dataVenda[2] . '-' . $dataVenda[1] . '-' . $dataVenda[0];
            } catch (Exception $e) {
                $dataF = date('Y-m-d');
            }

            //*******Verifica se o valor foi digitado adequadamente.
            {
                if (formatoRealPntVrg($valorFin) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                    //serve pra validar  valores acima e abaixo de 1000
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    $valorFin;
                    $valorFin  =    ((float)str_replace(",", ".", (str_replace(".", "", $valorFin))));
                } else if (formatoRealInt($valorFin) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                    //serve pra validar  valores acima e abaixo de 1000
                    //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                    $valorFin  =    number_format(str_replace(".", "", $valorFin), 2, '.', '');
                } else if (formatoRealPnt($valorFin) == true) {
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFin  =    $valorFin;
                    $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                } else if (formatoRealVrg($valorFin) == true) {
                    //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorFinExibe  =    number_format(str_replace(",", ".", $valorFin), 2, ',', '.');
                    $valorFin  =   ((float)str_replace(",", ".", (str_replace(".", "", $valorFin))));
                } else {
                    echo "O valor digitado não esta nos parametros solicitados";
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                        <script type=\"text/javascript\">
                                        alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: " . __LINE__ . "\");
                                        </script>";
                    exit;
                }
            }

            if (!$cod_assoc || !$cod_compassion) {
                echo 'Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
                                    Volte a pagina anterior e preencha todos os campos!';
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                    <script type=\"text/javascript\">
                                    alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída. Volte a pagina anterior e preencha todos os campos! - Linha: " . __LINE__ . "\");
                                    </script>";
                exit;
            }
            $query = mysqli_query($conex, 'SELECT ent_SaiComp FROM cod_compassion 
                                        WHERE cod_comp LIKE "' . $cod_compassion . '" LIMIT 1  ');
            if (!$query) {
                die("<center>Desculpe, erro na busca de saldo atual.:  "
                    . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
                //exit;
            }
            if (mysqli_num_rows($query) == 0) {
                echo "Nao existem lançamentos. cod comassion " . $cod_compassion . " .Linha " . __LINE__ . "</br>";
            }
            while ($comp_row = mysqli_fetch_array($query))
                $cod_compES = $comp_row['ent_SaiComp'];

            $queryA = mysqli_query($conex, 'SELECT ent_SaiAss FROM cod_assoc 
                                        WHERE cod_Ass LIKE "' . $cod_assoc . '" LIMIT 1  ');
            while ($ass_row = mysqli_fetch_array($queryA))
                $cod_asES = $ass_row['ent_SaiAss'];

            if (($ent_Sai <> $cod_asES)) {
                echo "<p><font color=red>Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
                                        Volte a pagina anterior e preencha todos os campos!</font</p>";

                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaEditar1.php'>
                                        <script type=\"text/javascript\">
                                        alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída. Volte a pagina anterior e preencha todos os campos! Linha: " . __LINE__ . "\");
                                        </script>";
                exit;
            }

            // echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;

            if (!$conta  || !$tipo_Conta  || !$num_Doc_Banco  || !$num_Doc_Fiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin) {
                echo "Conta - " . $conta . " | Tipo - " . $tipo_Conta . " | Doc Banco - " . $num_Doc_Banco . " | Doc Fiscal " . $num_Doc_Fiscal . " | Histórico " . $razaoSoc . " | Data - " . $dataF . " | Valor - " . $valorFin;
                echo "<p><font color=red>Voce nao entrou com os dados necessarios.
                        Você não informou todos os dados nescessário. Tente novamente!</font</p>";
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                    <script type=\"text/javascript\">
                                    alert(\" Você não informou todos os dados nescessário. Tente novamente! Linha: " . __LINE__ . "\");
                                    </script>";
                exit;
            }    //URL=PaginaLancamento1.php
            if ($permissoes_id < 3)  $senhaAdm = "aenp@z2023";
            $datahj = date('Y-m-d');
            // if(!(isset($senhaAdm))){ $senhaAdm = "0000";}else if($senhaAdm == "vid@19") $senhaAdm = "aenp@z2023";
            $data_001 =  primeiroDiaMes($datahj);
            $data_007 =  setimoDiadoMes($datahj);

            if (($datahj > $data_007) && ($dataF < $data_001)) {
                if (false == $this->verificaPermissoesData($dataF, $conta, 'e')) //PARAMETRO 'e' editar
                {
                    echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lançamento referente a esta data foi aspirado. <br/> 
                        Retorne e altere a data ou contate o administrador.</font><br/>";
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                <script type=\"text/javascript\">
                                alert(\" Você não possui Permissão para lançamento referente a esta data, Procure o administrador do sistema! Linha: " . __LINE__ . "\");
                                </script>";
                    exit;
                } else
                if ($dataF < $datainicioLimite) {
                    echo "<br/><font color = #458B74 size = 3 text-align:center>Data não autorizada para lançamento. <br/> 
                        Retorne e altere a data ou contate o administrador.</font><br/>";
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                <script type=\"text/javascript\">
                                alert(\" Data anterior ao Fechamento do relatório contábil ANUAL não autorizada edição. Tente novamente! Linha: " . __LINE__ . "\");
                                </script>";
                    exit;
                }
            }
            if ($dataF > $datahj) {
                echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                            <script type=\"text/javascript\">
                            alert(\" A data não é uma data válida, tente novamente! Linha: " . __LINE__ . "\");
                            </script>";
                exit;
            }

            $reg_Alteracao      = $this->input->post('reg_Alteracao');
            $conta_Old          = $this->input->post('conta_Old');
            $tipo_Conta_Old     = $this->input->post('tipo_Conta_Old');
            $cod_compassion_Old = $this->input->post('cod_Comp_Old');
            $cod_assoc_Old      = $this->input->post('cod_Ass_Old');
            $num_Doc_Banco_Old  = $this->input->post('numeroDoc_Old');
            $num_Doc_Fiscal_Old = $this->input->post('numDocFiscal_Old');
            $razaoSoc_Old       = $this->input->post('razaoSoc_Old');
            $descricao_Old      = $this->input->post('descri_Old');
            $valorFin_Old       = $this->input->post('valorFin_Old');
            $ent_Sai_Old        = $this->input->post('ent_Sai_Old');
            $tipo_Pag_Old       = $this->input->post('tipo_Pag_Old');
            $conta_Destino_Old  = $this->input->post('conta_Destino_Old');
            $dataFin_Old        = $this->input->post('dataFin_Old');
            $tip_PagAnt_Old     = $this->input->post('tip_PagAnt_Old');

            $conta_Text = $tipo_Conta_Text = $cod_Comp_Text = $cod_Ass_Text = $numeroDoc_Text = $numDocFiscal_Text = $razaoSoc_Text = $descri_Text = $ent_Sai_Text = $tipo_Pag_Text = $conta_Destino_Text = $dataFin_Text = $valorFin_Text = '';


            $conta_Text      =  $conta_Old !=  $conta           ? 'conta: ' . $conta_Old . '->' . $conta . '; ' : '';
            $tipo_Conta_Text =  $tipo_Conta_Old !=  $tipo_Conta ? 'tipo_Conta: ' . $tipo_Conta_Old . '->' . $tipo_Conta . '; ' : '';
            $cod_Comp_Text   =  $cod_compassion_Old !=  $cod_compassion ? 'cod_compassion: ' . $cod_compassion_Old . '->' . $cod_compassion . '; ' : '';
            $cod_Ass_Text    =  $cod_assoc_Old !=  $cod_assoc    ? 'cod_assoc: ' . $cod_assoc_Old . '->' . $cod_assoc . '; ' : '';
            $numeroDoc_Text  =  $num_Doc_Banco_Old !=  $num_Doc_Banco ? 'num_Doc_Banco: ' . $num_Doc_Banco_Old . '->' . $num_Doc_Banco . '; ' : '';
            $numDocFiscal_Text  =  $num_Doc_Fiscal_Old !=  $num_Doc_Fiscal ? 'num_Doc_Fiscal: ' . $num_Doc_Fiscal_Old . '->' . $num_Doc_Fiscal . '; ' : '';
            $razaoSoc_Text   =  $razaoSoc_Old !=  $razaoSoc      ? 'razaoSoc: ' . $razaoSoc_Old . '->' . $razaoSoc . '; ' : '';
            $descri_Text     =  $descricao_Old !=  $descricao    ? 'descricao: ' . $descricao_Old . '->' . $descricao . '; ' : '';
            $ent_Sai_Text    =  $ent_Sai_Old !=  $ent_Sai        ? 'ent_Sai: ' . $ent_Sai_Old . '->' . $ent_Sai . '; ' : '';
            $tipo_Pag_Text   =  $tipo_Pag_Old !=  $tipo_Pag      ? 'tipo_Pag: ' . $tipo_Pag_Old . '->' . $tipo_Pag . '; ' : '';
            $conta_Destino_Text =  $conta_Destino_Old !=  $conta_Destino ? 'conta_Destino: ' . $conta_Destino_Old . '->' . $conta_Destino . '; ' : '';
            $dataFin_Text    =  $dataFin_Old !=  $dataFin        ? 'dataFin: ' . $dataFin_Old . '->' . $dataFin . '; ' : '';
            $valorFin_Text   =  $valorFin_Old !=  $valorFin      ? 'valorFin: ' . $valorFin_Old . '->' . $valorFin . '; ' : '';

            $altera_Text = $conta_Text . $tipo_Conta_Text . $cod_Comp_Text . $cod_Ass_Text . $numeroDoc_Text . $numDocFiscal_Text . $razaoSoc_Text . $descri_Text . $ent_Sai_Text . $tipo_Pag_Text . $conta_Destino_Text . $dataFin_Text . $valorFin_Text;

            $alteracoesHoje = $reg_Alteracao;
            if ($altera_Text != '') {
                $alteracoesHoje = '[' . date('d/m/Y H:i') . '] ' . $this->session->userdata('nome') . ': ' . $altera_Text . ' &#013' . $reg_Alteracao;
            }

            $data = array(
                'conta'         => $this->input->post('conta'),
                'tipo_Conta'    => $this->input->post('tipo_Conta'),
                'cod_compassion' => $this->input->post('cod_Comp'),
                'cod_assoc'     => $this->input->post('cod_Ass'),
                'num_Doc_Banco' => $this->input->post('numeroDoc'),
                'num_Doc_Fiscal' => $this->input->post('numDocFiscal'),
                'historico'     => $this->input->post('razaoSoc'),
                'descricao'     => $this->input->post('descri'),
                'dataFin'       => $dataF,
                'valorFin'      => $valorFin,
                'ent_Sai'       => $this->input->post('ent_Sai'),
                'tipo_Pag'      => $this->input->post('tipo_Pag'),
                'conta_Destino' => $this->input->post('conta_Destino'),
                'alteracoes'    => $alteracoesHoje
            );
            echo "Conta lançaento - " . $conta . " | Tipo - " . $tipoCont_Atual . " | Doc Banco - " . $this->input->post('numeroDoc') . " | Doc Fiscal " . $this->input->post('numDocFiscal') . " | Histórico " . $this->input->post('razaoSoc') . " | Data - " . $dataF . " | Valor - " . $valorFin . " | conta_Destino - " . $this->input->post('conta_Destino') . " | ent_Sai - " . $this->input->post('ent_Sai') . '<br>';
            //exit;	
            if ($this->vendas_model->edit('aenpfin', $data, 'id_fin', $this->input->post('id_fin')) == TRUE) {


                //	{**** primeiro dia do mês do lançamento
                //******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********	
                //******No caso aqui esta usando como refencia o ultimo saldo de 2016 e recalcula todos os saldos dos lançamentos posteriores***			
                //******busca do ultimo registro com o saldo do mês marcado *********
                //                    echo '<br> Caixa '.(int)$caixa.'<br>';
                if (($conta == 4 || $conta == 5) && $dataF > $_SESSION['DATA_FIM_BR518']) {
                    $cCaixArr = array(4, 5);
                } else {
                    $cCaixArr = array((int)$conta);
                }
                //                  var_dump('<br> Caixa',$cCaixArr); echo '<br>';
                $menorMaior = 'dataFin >';
                $saldoAtualID = $this->vendas_model->getSaldo($cCaixArr, $tipoCont_Atual, $datainicioLimite, $menorMaior);

                $id_Ultimo_Saldo = $saldoAtualID->id_fin;
                $saldo_Atual = $saldoAtualID->saldo;
                $dataUlt_saldo = $saldoAtualID->dataFin;

                //               $sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin				
                //											WHERE dataFin > "'.$datainicioLimite.'" and 
                //											conta = '.$conta.'  and tipo_Conta = "'.$tipoCont_Atual.'"
                //											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';		
                //						$result_Saldo_Atual = mysqli_query($conex, $sql_Saldo_Atual );
                //						
                //                
                //						while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Atual)) 
                //						{//ID, valor do saldo e a data do registro com o ultimo saldo marcado
                //							$id_Ultimo_Saldo = $row_Saldo['id_fin']; 
                //							$saldo_Atual = $row_Saldo['saldo']; 	
                //							$dataUlt_saldo = $row_Saldo['dataFin'];
                //						}

                //******Verifica se existe  registro de cheque para este lançamento independente da informação em tipo_Pag***               
                $querychek = mysqli_query($conex, 'SELECT id_aenp FROM reconc_bank 
                                        WHERE id_aenp LIKE "' . $id_fin . '" LIMIT 1  ');
                if (!$querychek) {
                    die("<center>Desculpe, erro na busca de saldo atual.:  "
                        . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
                            <a href='menu1.php'>Voltar ao Menu</a></center>");
                    //exit;
                }
                if (mysqli_num_rows($querychek) == 0) {
                    echo "Nao existia lançamento de cheque. Linha " . __LINE__ . "</br>";
                    $chekk = 0; // Não há registro de cheque para este lançamento
                } else
            if (mysqli_num_rows($querychek) > 0) {
                    echo "Existia lançamento de cheque. Linha " . __LINE__ . "</br>";
                    $chekk = 1; // Há registro de cheque para este lançamento
                }

                if ($chekk == 1) {
                    if ($tipo_Pag == "cheq") {
                    } else                            
            if ($tipo_Pag == "trans") {
                        $sql = mysqli_query($conex, "DELETE FROM reconc_bank WHERE id_aenp = '$id_fin'");
                        $result = mysqli_query($conex, $sql);
                    }
                } else                            
        if ($chekk == 0) {
                    if ($tipo_Pag == "trans") {
                    } else                            
            if ($tip_PagAnt == "cheq") {
                        $status = 0;
                        $datachq = array(
                            'id_aenp'   => $id_fin,
                            'data_Emissao'  => $dataF,
                            'data_Pag'  => $dataF,
                            'status'    => $status,
                            'operador'  => $cadastrante
                        );
                        if (is_numeric($id = $this->vendas_model->add('reconc_bank', $datachq, true))) {
                        }
                    }
                }


                $dia_1_mes = primeiroDiaMes($dataF);

                //******AJUSTE DE SALDO
                //******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********	
                //******No caso aqui esta usando como refencia o ultimo saldo de 2018 e recalcula todos os saldos dos lançamentos posteriores***			
                if ($this->ajusteSaldo($conta, $tipoCont_Atual, $dataF) == TRUE)
                    echo "<center> "
                        . '<br>Linha: ' . __LINE__ . "<br>													
                        <a href='" . base_url() . "index.php/vendas/gerenciar'>Voltar a Lançamentos</a></center>";
                //exit;

                $alterados = '';
                $alterados = ' Alterados:' . $alterados;
                $this->session->set_flashdata('success', 'Lançamento editado com sucesso!  Saldos alterados! ' . $alterados);
                redirect(base_url() . 'index.php/vendas/editar/' . $this->input->post('id_fin'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                $this->session->set_flashdata('error', 'Lançamento não efetuado.');
            }
        }
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['result_caixas'] = $this->vendas_model->get2('caixas');

        $this->data['usuario'] = $this->vendas_model->getByIdUser($this->session->userdata('id'));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['result_codComp'] = $this->vendas_model->get2('cod_compassion');
        $this->data['result_codIead'] = $this->vendas_model->get2('cod_assoc');
        $this->data['anexos'] = $this->vendas_model->getAnexos('anexos', $this->uri->segment(3));
        $this->data['view'] = 'vendas/editarVenda';
        $this->load->view('tema/topo', $this->data);
    }
    public function buscarAnexos()
    {    
        $this->load->model('Vendas_model'); // Certifique-se de carregar o modelo aqui
        // Obtém o ID do formulário (fin_id) enviado pela requisição AJAX
        $fin_id = $this->input->post('fin_id');
        $tabela = $this->input->post('tabela');
    
        // Busca os anexos no banco de dados
        $anexos = $this->Vendas_model->getAnexos($tabela, $fin_id);
        
            
        // $campos = [
        //     'idAnexos' => $field = $tabela == 'auxiliarTab' ? $anexo['id1'] : $anexo['idAnexos'],
        //     'thumb' =>  $field = $tabela == 'auxiliarTab' ? $anexo['descricao1'] : $anexo['thumb'],
        //     'anexo' => $field = $tabela == 'auxiliarTab' ? $anexo['nome1'] : $anexo['anexo'],
        //     'url' => base_url() . 'assets/anexos/' // Ajuste o caminho conforme necessário
        // ];
        
        // Monta a resposta JSON
        if (!empty($anexos)) {
            $data = [];
            foreach ($anexos as $anexo) {
                $data[] = [
                    'idAnexos'  => $field = $tabela == 'auxiliarTab' ? $anexo->id1          : $anexo->idAnexos,
                    'thumb'     => $field = $tabela == 'auxiliarTab' ? $anexo->descricao1   : $anexo->thumb,
                    'anexo'     => $field = $tabela == 'auxiliarTab' ? $anexo->nome1        : $anexo->anexo,
                    'url'       => base_url() . 'assets/anexos/' // Ajuste o caminho conforme necessário
                ];
            }
    
            echo json_encode(['result' => true, 'anexos' => $data]);
        } else {
            echo json_encode(['result' => false, 'message' => 'Nenhum anexo encontrado.']);
        }
    }

    public function excluirAnexosTemporarios($id = null)
    {
        $this->load->model('Vendas_model'); // Certifique-se de carregar o modelo aqui
        
        // Define o limite de tempo: registros com mais de 1 hora
        $limite_tempo = date('Y-m-d H:i:s', strtotime('-1 hour'));
        
        // Obtém os registros temporarios ou específicos ao ID
        $condicao_tempo = $id === null ? 'dataInsert <' : 'id1';
        $valor_condicao = $id === null ? $limite_tempo : $id;
        $registros = $this->Vendas_model->get4('auxiliarTab', $condicao_tempo, $valor_condicao);
        
        if (!$registros) {
            $response = [
                'success' => false,
                'message' => 'Nenhum registro encontrado para exclusão.'
            ];
            echo json_encode($response);
            return;
        }
    
        // Exclui os registros no banco de dados
        $excluido = $this->Vendas_model->excluirAnexosTemporarios($id);
        
        // Remove os arquivos relacionados
        $erros = [];
        foreach ($registros as $anexo) {
            $caminho_arquivo = $anexo->descricao2 . DIRECTORY_SEPARATOR . $anexo->nome1;
    
            // Tenta excluir o arquivo principal
            if (file_exists($caminho_arquivo)) {
                if (!unlink($caminho_arquivo)) {
                    $erros[] = "Erro ao excluir o arquivo: " . $caminho_arquivo;
                }
            }
    
            // Tenta excluir o thumbnail, se existir
            if ($anexo->descricao1) {
                $caminho_thumb = $anexo->descricao2 . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . $anexo->descricao1;
                if (file_exists($caminho_thumb)) {
                    if (!unlink($caminho_thumb)) {
                        $erros[] = "Erro ao excluir o thumbnail: " . $caminho_thumb;
                    }
                }
            }
        }
    
        if ($excluido && empty($erros)) {
            $response = [
                'success' => true,
                'message' => $id === null
                    ? "Registros temporarios excluídos com sucesso."
                    : "Anexos do ID $id excluídos com sucesso."
            ];
        } elseif (!empty($erros)) {
            $response = [
                'success' => false,
                'message' => 'Erros encontrados ao excluir anexos: ' . implode(', ', $erros)
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Erro ao excluir registros no banco.'
            ];
        }

        // Retorna a resposta em formato JSON
        echo json_encode($response);
        return;
    }


public function anexarDefinitivo($id_fin, $id_temp)
{
    // Seleciona os registros da tabela auxiliarTab com base no id_temp
    $this->db->where('id1', $id_temp);
    $query = $this->db->get('auxiliarTab');
    $anexos_temp = $query->result();

    if (!$anexos_temp) {
        return false; // Nenhum registro encontrado para o id_temp
    }

    // Obtém o número atual de anexos associados a este $id_fin
    $this->db->where('fin_id', $id_fin);
    $qtd_anexos = $this->db->count_all_results('anexos');
    $sequencia = $qtd_anexos + 1;

    foreach ($anexos_temp as $anexo) {
        // Define o novo nome do arquivo
        $extensao = pathinfo($anexo->nome1, PATHINFO_EXTENSION);
        $novo_nome = $id_fin . 'Anexo_' . $sequencia . '.' . $extensao;

        // Renomeia o arquivo físico no diretório
        $caminho_antigo = $anexo->descricao2 . DIRECTORY_SEPARATOR . $anexo->nome1;
        $caminho_novo = $anexo->descricao2 . DIRECTORY_SEPARATOR . $novo_nome;

        if (file_exists($caminho_antigo)) {
            rename($caminho_antigo, $caminho_novo);
        }

        // Renomeia o thumbnail, se existir
        if (!empty($anexo->descricao1)) {
            $thumb_antigo = $anexo->descricao2 . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . $anexo->descricao1;
            $thumb_novo = $anexo->descricao2 . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . 'thumb_' . $novo_nome;

            if (file_exists($thumb_antigo)) {
                rename($thumb_antigo, $thumb_novo);
            }
        } else {
            $thumb_novo = null;
        }

        // Prepara os dados para inserir na tabela anexos
        $data = array(
            'fin_id' => $id_fin,
            'anexo'  => $novo_nome,
            'url'    => $anexo->nome2,
            'thumb'  => $thumb_novo ? 'thumb_' . $novo_nome : null,
            'path'   => $anexo->descricao2,
        );

        // Insere na tabela anexos
        $this->db->insert('anexos', $data);

        // Incrementa a sequência para o próximo arquivo
        $sequencia++;
    }

    // Após inserir, deleta os registros da tabela auxiliarTab
    $this->db->where('id1', $id_temp);
    $this->db->delete('auxiliarTab');

    return true;
}

    
   public function anexar()
    { 
        $this->load->model('Vendas_model'); // Certifique-se de carregar o modelo aqui
        $this->load->library('upload');
        $this->load->library('image_lib');

        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt',
            'max_size'      => 0,
        );

        $fin_id = $this->input->post('fin_id');
        $servico = $this->input->post('servico');

        // Inicializa o upload
        $this->upload->initialize($upload_conf);

        // Reorganiza os arquivos no formato esperado pela biblioteca de upload
        foreach ($_FILES['userfile'] as $key => $val) {
            $i = 1;
            foreach ($val as $v) {
                $field_name = "file_" . $i;
                $_FILES[$field_name][$key] = $v;
                $i++;
            }
        }
        unset($_FILES['userfile']);

        $error = array();
        $success = array();

        // Processa cada arquivo
        foreach ($_FILES as $field_name => $file) {
            if (!$this->upload->do_upload($field_name)) {
                $error = $this->upload->display_errors();
                log_message('error', 'Upload Error: ' . $error);
                echo json_encode(['result' => false, 'mensagem' => $error]);
                return;
            } else {
                $upload_data = $this->upload->data();

                if ($upload_data['is_image'] == 1) {
                    // Configuração para criar o thumbnail
                    $resize_conf = array(
                        'source_image'  => $upload_data['full_path'],
                        'new_image'     => $upload_data['file_path'] . 'thumbs/thumb_' . $upload_data['file_name'],
                        'width'         => 200,
                        'height'        => 125,
                    );
                    $this->image_lib->initialize($resize_conf);

                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $upload_data;
                        if ($servico == "anexoTemp") {
                            // Salva na tabela temporária
                            $this->Vendas_model->anexarTemp(
                                $fin_id,
                                $upload_data['file_name'],
                                base_url() . 'assets/anexos/',
                                'thumb_' . $upload_data['file_name'],
                                realpath('./assets/anexos/'),
                                $servico
                            );
                        } else {
                            // Salva na tabela definitiva
                            $this->Vendas_model->anexar(
                                $fin_id,
                                $upload_data['file_name'],
                                base_url() . 'assets/anexos/',
                                'thumb_' . $upload_data['file_name'],
                                realpath('./assets/anexos/')
                            );
                        }
                    }
                } else {
                    $success[] = $upload_data;
                    if ($servico == "anexoTemp") {
                        // Salva na tabela temporária
                        $this->Vendas_model->anexarTemp(
                            $fin_id,
                            $upload_data['file_name'],
                            base_url() . 'assets/anexos/',
                            '',
                            realpath('./assets/anexos/'),
                            $servico
                        );
                    } else {
                        // Salva na tabela definitiva
                        $this->Vendas_model->anexar(
                            $fin_id,
                            $upload_data['file_name'],
                            base_url() . 'assets/anexos/',
                            '',
                            realpath('./assets/anexos/')
                        );
                    }
                }
            }
        }

        // Retorna o resultado do upload
        if (count($error) > 0) {
            echo json_encode(array('result' => false, 'mensagem' => 'Nenhum arquivo foi anexado.'));
        } else {
            echo json_encode(array('result' => true, 'fin_id' => $fin_id, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso.'));
        }
    }
    

    public function excluirAnexo($id = null)
    {
        $this->session->set_flashdata('success', 'Teste com sucesso!');
        if ($id == null || !is_numeric($id)) {
            echo json_encode(array('result' => false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
        } else {
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos', 1)->row();
            unlink($file->path . '/' . $file->anexo);

            if ($file->thumb != null) {
                unlink($file->path . '/thumbs/' . $file->thumb);
            }
            if ($this->vendas_model->delete('anexos', 'idAnexos', $id) == true) {
                //  echo json_encode(array('result'=> true, 'mensagem' => 'Anexo excluído com sucesso.'));
                $this->session->set_flashdata('success', '<H3>Anexo excluído com sucesso!</H3>');
            } else {
                //echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
                $this->session->set_flashdata('error', '<H3>Erro ao tentar excluir anexo.</H3>');
            }
            echo "<body onload='window.history.back();'>";
        }
    }
    public function downloadanexo($id = null)
    {

        if ($id != null && is_numeric($id)) {

            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos', 1)->row();

            $this->load->library('zip');

            $path = $file->path;

            $this->zip->read_file($path . '/' . $file->anexo);

            $this->zip->download('file' . date('d-m-Y-H.i.s') . '.zip');
        }
    }

    public function visualizar()
    {

        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar lançamentos.');
            redirect(base_url());
        }
        $this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['result_codComp'] = $this->vendas_model->get2('cod_compassion');
        $this->data['result_codIead'] = $this->vendas_model->get2('cod_assoc');

        $this->data['anexos'] = $this->vendas_model->getAnexos('anexos', $this->uri->segment(3));
        $this->data['view'] = 'vendas/visualizarVenda';
        $this->load->view('tema/topo', $this->data);
    }
    public function imprimir()
    {

        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->mapos_model->getEmitente();

        $this->load->view('vendas/imprimirVenda', $this->data);
    }
    public function excluir()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir vendas');
            redirect(base_url());
        }
        $id =  $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir Lançamento.');
            redirect(base_url() . 'index.php/vendas/gerenciar/');
        } else {
            $datainicioLimite = '2020-01-01';
            include 'apoio/funcao.php';
            $user_id = $this->vendas_model->getByIdUser($this->session->userdata('id'));
            $permissoes_id = $user_id->permissoes_Geral;

            $dhoje = date('Y-m-d');
            $dia7 = date('Y-m-07');
            $dia1 = date('Y-m-01');
            $data_1mesAnt = date('Y-m-d', strtotime("-1 month", strtotime($dia1)));

            $lancamento = $this->vendas_model->getById1($id);

            $conta          = $lancamento->conta;
            $tipo_Conta     = $lancamento->tipo_Conta;
            $tipoCont_Atual = $tipo_Conta;
            $valorFin       = $lancamento->valorFin;
            $ent_Sai        = $lancamento->ent_Sai;
            $dataFin        = $lancamento->dataFin;

            $datahj = date('Y-m-d');
            $data_001 =  primeiroDiaMes($datahj);
            $data_007 =  setimoDiadoMes($datahj);
            // echo $dataFin;
            if ($permissoes_id < 3)
                //|| ($dhoje < $dia7 && $dataFin >= $data_1mesAnt) || ($dhoje >= $dia7 && $dataFin >= $dia1))           
                if (($datahj > $data_007) && ($dataFin < $data_001)) {
                    if (false == $this->verificaPermissoesData($dataFin, $conta, 'd')) //PARAMETRO 'd' deletar
                    {
                        echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lançamento referente a esta data foi aspirado. <br/> 
                        Retorne e altere a data ou contate o administrador.</font><br/>";
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='menu1.php''>
                                <script type=\"text/javascript\">
                                alert(\" Você não possui Permissão para Excluir lançamento referente a esta data, Procure o administrador do sistema! Linha: " . __LINE__ . "\");
                                </script>";
                        exit;
                    } else
                if ($dataFin < $datainicioLimite) {
                        echo "<br/><font color = #458B74 size = 3 text-align:center>Data não autorizada para lançamento. <br/> 
                        Retorne e altere a data ou contate o administrador.</font><br/>";
                        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='menu1.php''>
                                <script type=\"text/javascript\">
                                alert(\" Data anterior ao Fechamento do relatório contábil ANUAL não autorizada edição. Tente novamente! Linha: " . __LINE__ . "\");
                                </script>";
                        exit;
                    }
                }
            if ($dataFin < $datainicioLimite || $dataFin > $datahj) {
                echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='menu1.php''>
                                    <script type=\"text/javascript\">
                                    alert(\" A data não é uma data válida, tente novamente! Linha: " . __LINE__ . "\");
                                    </script>";
                exit;
            }
            // die();
            {
                $ent_Sai =  $this->input->post('ent_Sai');
                $id_reconc =  $this->input->post('id_reconc');
                if ($id_reconc !== null  && 2 == 2) {
                    $this->db->where('id_reconc', $id);
                    $this->db->delete('reconc_bank');
                }
                if (isset($contPre) && 2 == 2) {
                    if ($ent_Sai == 1) {
                        $contar = 1;
                        while ($contar <= $contPre) {
                            $id_presente =  $this->input->post('id_presente' . $contar);
                            $this->db->where('id_presente', $id_presente);
                            $this->db->delete('presentes_especiais');
                        }
                    } else if ($ent_Sai == 0) {
                        //  $this->data['protocoloPres'] = $this->vendas_model->getProtocPres($this->input->post('protocoloPres'));               
                        $valor_pendenteAnt = 0;
                        $contar = 1;
                        while ($contar <= $contPre) {
                            $id_presente =  $this->input->post('id_presente' . $contar);
                            $id_entrada =  $this->input->post('id_entrada' . $contar);
                            $id_saida =  $this->input->post('id_saida' . $contar);
                            $data_presente =  $this->input->post('data_presente');
                            $valor_saida =  $this->input->post('valor_saida' . $contar);
                            $valor_entrada =  $this->input->post('valor_entrada' . $contar);
                            $contPre =  $this->input->post('contPre' . $contar);
                            //*******Verifica se o valor foi digitado adequadamente.
                            {
                                if (formatoRealPntVrg($valor_saida) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                                    //serve pra validar  valores acima e abaixo de 1000
                                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valorFinExibe  =    $valor_saida;
                                    $valor_saida  =    ((float)str_replace(",", ".", (str_replace(".", "", $valor_saida))));
                                } else if (formatoRealInt($valorFin) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                                    //serve pra validar  valores acima e abaixo de 1000
                                    //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valorFinExibe  =    number_format(str_replace(",", ".", $valor_saida), 2, ',', '.');
                                    $valor_saida  =    number_format(str_replace(".", "", $valor_saida), 2, '.', '');
                                } else if (formatoRealPnt($valor_saida) == true) {
                                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valor_saida  =    $valor_saida;
                                    $valorFinExibe  =    number_format(str_replace(",", ".", $valor_saida), 2, ',', '.');
                                } else if (formatoRealVrg($valor_saida) == true) {
                                    //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valorFinExibe  =    number_format(str_replace(",", ".", $valor_saida), 2, ',', '.');
                                    $valor_saida  =   ((float)str_replace(",", ".", (str_replace(".", "", $valor_saida))));
                                } else {
                                    echo "O valor digitado não esta nos parametros solicitados";
                                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                                    <script type=\"text/javascript\">
                                                    alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: " . __LINE__ . "\");
                                                    </script>";
                                    exit;
                                }
                            } {
                                if (formatoRealPntVrg($valor_entrada) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                                    //serve pra validar  valores acima e abaixo de 1000
                                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valorFinExibe  =    $valor_entrada;
                                    $valor_entrada  =    ((float)str_replace(",", ".", (str_replace(".", "", $valor_entrada))));
                                } else if (formatoRealInt($valorFin) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                                    //serve pra validar  valores acima e abaixo de 1000
                                    //       echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valorFinExibe  =    number_format(str_replace(",", ".", $valor_entrada), 2, ',', '.');
                                    $valor_entrada  =    number_format(str_replace(".", "", $valor_entrada), 2, '.', '');
                                } else if (formatoRealPnt($valor_entrada) == true) {
                                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valor_entrada  =    $valor_entrada;
                                    $valorFinExibe  =    number_format(str_replace(",", ".", $valor_entrada), 2, ',', '.');
                                } else if (formatoRealVrg($valor_entrada) == true) {
                                    //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                                    $valorFinExibe  =    number_format(str_replace(",", ".", $valor_entrada), 2, ',', '.');
                                    $valor_entrada  =   ((float)str_replace(",", ".", (str_replace(".", "", $valor_entrada))));
                                } else {
                                    echo "O valor digitado não esta nos parametros solicitados";
                                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
                                                    <script type=\"text/javascript\">
                                                    alert(\"O valor digitado não esta nos parametros solicitados. Tente novamente! Linha: " . __LINE__ . "\");
                                                    </script>";
                                    exit;
                                }
                            }
                            if ($id_saida == $id) {
                                $this->db->where('id_presente', $id_presente);
                                $this->db->delete('presentes_especiais');
                            } else {
                                if ($contar == 1) {
                                    $valor_pendente = $valor_entrada;
                                } else {
                                    $valor_pendente = $valor_pendente - $id_saidaAnt;
                                    if ($contar == $contPre) {
                                        $datapresUp = array(
                                            'id_saida'      => $id_saidaAnt,
                                            'data_presente' => $data_presenteAnt,
                                            'valor_saida'   => $valor_saidaAnt,
                                            'valor_pendente' => $valor_pendente
                                        );
                                        $datapresUpFIm = array(
                                            'id_saida'      => 0,
                                            'data_presente' => $data_presente,
                                            'valor_saida'   => $valor_saida,
                                            'valor_pendente' => $valor_pendente
                                        );
                                        if ($this->vendas_model->edit('presentes_especiais', $datapresUpFIm, 'id_presente', $id_presente) == TRUE) {
                                        }
                                    } else {
                                        $datapresUp = array(
                                            'id_saida'      => $id_saidaAnt,
                                            'data_presente' => $data_presenteAnt,
                                            'valor_saida'   => $valor_saidaAnt,
                                            'valor_pendente' => $valor_pendente
                                        );
                                    }
                                    if ($this->vendas_model->edit('presentes_especiais', $datapresUp, 'id_presente', $id_Ant) == TRUE) {
                                    }
                                }
                                $id_Ant = $id_presente;
                            }
                            $data_presenteAnt = $data_presente;
                            $id_saidaAnt = $id_saida;
                            $valor_saidaAnt = $valor_saida;
                            ++$contar;
                        }
                        if ($id_reconc !== null) {
                            $this->db->where('id_reconc', $id);
                            $this->db->delete('reconc_bank');
                        }
                    }
                }

                $this->db->where('id_fin', $id);
                $this->db->delete('aenpfin');
                //**** Execução de RECALCULAR OS SALDOS desde o mês anterior a alteração 
                {

                    $dia_1_mes = primeiroDiaMes($dataFin);
                    //	$saldo_mes_lancamento = "N";
                    //******busca do ultimo registro, anterior ao mês do lançamento, que tenha o saldo do mês marcado *********		
                    $sAnt_Fin = $this->vendas_model->getS_antesFin('aenpfin', $datainicioLimite, $dia_1_mes, $conta, $tipoCont_Atual);

                    //ID, valor do saldo e a data do registro com o penultimo saldo marcado
                    $id_saldo_Penultimo = $sAnt_Fin->id_fin;
                    if (null != $sAnt_Fin->saldo) $saldo_Penultimo = $sAnt_Fin->saldo;
                    else $saldo_Penultimo = $datainicioLimite;
                    $data_saldo_Penultimo = $sAnt_Fin->dataFin;
                    $alterados = '';
                    //******busca de todos registro, após o penultimo saldo *********		
                    $lancaments = $this->vendas_model->getLancPosSaldo('aenpfin', '*', $data_saldo_Penultimo, $conta, $tipoCont_Atual);

                    //inicia variavel do dia final do mes do registro anterior com o dia fim do mês do lançamento								
                    $fim_mes = ultimoDiaMes($dataF);

                    $s_anterior =    $saldo_Penultimo;
                    //	while ($maisRecent = mysqli_fetch_assoc($maisRecentes)) 
                    $alterados = '';
                    foreach ($lancaments as $lanc) {

                        $ent_Sai = $lanc->ent_Sai;
                        if ($ent_Sai == 0) {
                            $s_Atual = $s_anterior - $lanc->valorFin; //$valorFin;
                        } else if ($ent_Sai == 1) {
                            $s_Atual = $s_anterior + $lanc->valorFin;
                        }
                        $dataSal = array(
                            'saldo' => $s_Atual
                        );

                        if ($this->vendas_model->edit('aenpfin', $dataSal, 'id_fin', $lanc->id_fin) == TRUE) {
                            $alterados = $alterados . 'Id:' . $lanc->id_fin . ' saldo:' . $s_Atual;
                        }

                        $s_anterior =    $s_Atual;
                        if (isset($dataX)) {
                            $d_anterior = $dataX;
                        }
                        $dataX =  $lanc->dataFin;
                        $data_ultimo_dia = ultimoDiaMes($dataX); //inicia variavel do dia final do mes do registro atual

                        $sMes = 'N';
                        if (isset($id_anterior)) {
                            if ($dataX > $fim_mes) {
                                $dataSalM = array('saldo_Mes' => "S"); // Marca se for o ultimos registro de saldos de cada mes 
                                $sMes = '><font color = blue ><strong> S </strong></font>';
                            } else
                                $dataSalM = array('saldo_Mes' => "N");

                            if ($this->vendas_model->edit('aenpfin', $dataSalM, 'id_fin', $id_anterior) == TRUE) {
                                $alterados = $alterados . ' -' . $sMes . '-, ';
                            }
                        }
                        $iD_Fin = $lanc->id_fin;
                        //   $alterados = $alterados.'Id:'.$lanc->id_fin.' saldo:'.$s_Atual;
                        //*****Para verificar lista com as alterações feitas e encontrar erros
                        //  echo '<font color=red size="2"> Conta '.$maisRecent['conta'].' | Tipo '.$maisRecent['tipo_Conta'].' | Data '.$maisRecent['dataFin']. ' | Valor </font> <font color=green>'.$maisRecent['valorFin']. ' </font> <font color=red> | Registro '.$iD_Fin. ' | Saldo alterado para '.$s_Atual. ' </font><br />';	                                    
                        $id_anterior = $lanc->id_fin;
                        $fim_mes = $data_ultimo_dia;
                    }
                }
                $alterados = ' Alterados:' . $alterados;
                if ($contPre !== null) {
                    $this->session->set_flashdata('success', 'Lançamento e registro de presente excluído com sucesso! Saldos alterados: ' . $alterados);
                } else {
                    $this->session->set_flashdata('success', 'Lançamento  excluído com sucesso! Saldos alterados: ' . $alterados);
                }

                redirect(base_url() . 'index.php/vendas/gerenciar/');
            }
        }
    }
    public function autoCompleteProduto()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteProduto($q);
        }
    }
    public function autoCompleteCliente()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteCliente($q);
        }
    }
    public function autoCompleteUsuario()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteUsuario($q);
        }
    }
    public function adicionarProduto()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar vendas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required');
        $this->form_validation->set_rules('idVendasProduto', 'Vendas', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode(array('result' => false));
        } else {

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = array(
                'quantidade' => $quantidade,
                'subTotal' => $subtotal,
                'produtos_id' => $produto,
                'vendas_id' => $this->input->post('idVendasProduto'),
            );

            if ($this->vendas_model->add('itens_de_vendas', $data) == true) {
                $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
                $this->db->query($sql, array($quantidade, $produto));

                echo json_encode(array('result' => true));
            } else {
                echo json_encode(array('result' => false));
            }
        }
    }
    function excluirProduto()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Vendas');
            redirect(base_url());
        }

        $ID = $this->input->post('idProduto');
        if ($this->vendas_model->delete('itens_de_vendas', 'idItens', $ID) == true) {

            $quantidade = $this->input->post('quantidade');
            $produto = $this->input->post('produto');


            $sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";

            $this->db->query($sql, array($quantidade, $produto));

            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }
    public function faturar()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Vendas');
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
                $vencimento = $vencimento[2] . '-' . $vencimento[1] . '-' . $vencimento[0];

                if ($recebimento != null) {
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2] . '-' . $recebimento[1] . '-' . $recebimento[0];
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

            if ($this->vendas_model->add('lancamentos', $data) == TRUE) {

                $venda = $this->input->post('vendas_id');

                $this->db->set('faturado', 1);
                $this->db->set('valorTotal', $this->input->post('valor'));
                $this->db->where('idVendas', $venda);
                $this->db->update('vendas');

                $this->session->set_flashdata('success', 'Venda faturada com sucesso!');
                $json = array('result' =>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar venda.');
                $json = array('result' =>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar venda.');
        $json = array('result' =>  false);
        echo json_encode($json);
    }
    public function cadastrar()
    {
        $p_Origem = base_url() . 'index.php/vendas';
        $contar = 1;
        while (($contar <= $qtd_presentes)) {
            $nome = 'nome' . $contar;
            $Codigo = 'Codigo' . $contar;
            $Protocolo = 'Protocolo' . $contar;
            $valorPre = 'valorPre' . $contar;
            $entraSai = 'entraSai' . $contar;
            $_SESSION[$nome] = $_POST[$nome];
            $_SESSION[$Codigo]    = $_POST[$Codigo];
            $_SESSION[$Protocolo] = $_POST[$Protocolo];
            $_SESSION[$valorPre] = $_POST[$valorPre];
            $_SESSION[$entraSai] = $_POST[$entraSai];

            $contar = $contar + 1;
        }

        if (!$cod_assoc || !$cod_compassion) {
            echo 'Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída.
											Volte a pagina anterior e preencha todos os campos! Caixa ' . $_SESSION[$caixa] . $caixa . ' tipo ' . $_SESSION[$tipoCont] . ' C comp ' . $_SESSION[$cod_compassion] . ' doc ' . $_SESSION[$num_Doc] . '- Cod ASS  ' . $_SESSION[$numDocFiscal] . ' ' . $numDocFiscal . ' - R soc ' . $_SESSION[$razaoSoc] . ' ' . $razaoSoc . ' ' . $cod_assoc . ' - cod Comp ' . $cod_compassion . ' - tipo pag ' . $_SESSION[$tipo_Pag] . ' - ent sai ' . $_SESSION[$ent_Sai] . ' - ' . $_SESSION[$cadastrante] . ' ent sai ' . $_SESSION[$entrada_Saida] . ' ' . $_SESSION[$tip_Cont] . ' qtd pres ' . $_SESSION[$qtd_presentes] . ' ';
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\"Os códigos IEADALPE  e Compassion não condizem com a escolha de entrada e saída. Volte a pagina anterior e preencha todos os campos! - Linha: " . __LINE__ . "\");
											</script>";
            exit;
        }
        // echo "Conta - ".$caixa." | Tipo - ".$tipoCont." | Doc Banco - ".$num_Doc." | Doc Fiscal ".$numDocFiscal." | Histórico ".$razaoSoc." | Data - ".$dataF." | Valor - ".$valorFin;

        if (!$caixa  || !$tipoCont  || !$num_Doc  || !$numDocFiscal  || !$razaoSoc   || !$dataF  ||  !$valorFin) {
            echo "Conta - " . $caixa . " | Tipo - " . $tipoCont . " | Doc Banco - " . $num_Doc . " | Doc Fiscal " . $numDocFiscal . " | Histórico " . $razaoSoc . " | Data - " . $dataF . " | Valor - " . $valorFin;
            echo "<p><font color=red>Voce nao entrou com os dados necessarios.
								Você não informou todos os dados nescessário. Tente novamente!</font</p>";
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\" Você não informou todos os dados nescessário. Tente novamente! Linha: " . __LINE__ . "\");
											</script>";
            exit;
        }    //URL=PaginaLancamento1.php
        $datahj = date('Y-m-d');
        //echo $datahj;
        //	$dataF= implode('-',array_reverse(explode('/',$data)));
        $data_001 =  primeiroDiaMes($datahj);
        $data_007 =  setimoDiadoMes($datahj);
        if (($datahj > $data_007) && ($dataF < $data_001) && ($senhaAdm <> "aenp@z2023")) {
            echo "<br/><font color = #458B74 size = 3 text-align:center>Prazo Limite para lançamento referente ao mês anterior aspirado. <br/> 
								Retorne e altere a data ou contate o administrador.</font><br/>";
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\" Prazo Limite para lançamento referente ao mês anterior aspirado, tente novamente! Linha: " . __LINE__ . "\");
											</script>";
            exit;
        }


        if ($dataF < "2010-01-01" || $dataF > $datahj) {
            echo "ERRO!  - <strong><td> A data não é uma data válida, tente novamente!</td></strong><br/>";
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\" A data não é uma data válida, tente novamente! Linha: " . __LINE__ . "\");
											</script>";
            exit;
        }

        if ($cod_compassion == ("R01 - 1030")) //Entrada com presentes especiais
        {
            $contar = 1;
            $valorFinTotal =   "0.00";
            while (($contar <= $qtd_presentes)) {
                $n_nome = 'nome' . $contar; // Nomes das variaveis de cada cadastro
                $n_codigo = 'Codigo' . $contar;
                $n_protocolo = 'Protocolo' . $contar;
                $n_valorPre = 'valorPre' . $contar;

                $nome = $_POST[$n_nome];
                $Codigo    = $_POST[$n_codigo];
                $Protocolo = $_POST[$n_protocolo];
                $valorPre = $_POST[$n_valorPre];
                if (!$nome  || !$Codigo  || !$Protocolo  || !$valorPre) {
                    echo "Algum campo do " . $contar . "º Presente da lista não foi preenchido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__;

                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
														<script type=\"text/javascript\">
														alert(\"Algum campo do " . $contar . "º Prsente da lista não foi preenchido.Volte a pagina anterior e preencha todos os campos! Linha: " . __LINE__ . "\");
														</script>";

                    exit;
                }

                if ($valorPre = 0) {
                    echo "Atenção! O valor do  " . $contar . "º Presente é inválido.
														Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__;
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
														<script type=\"text/javascript\">
														alert(\"Atenção! O valor do  " . $contar . "º Prsente é inválido. Volte a pagina anterior e preencha todos os campos!\");
														</script>";
                    exit;
                }

                $valorFinTotal = $valorFinTotal + $valorPre;
                echo "presente " . $contar . "  = R$ <strong>" . $valorPreExibe . "</strong><br>";
                $contar = $contar + 1;
            }
            $val_Total = $valorFinTotal;

            $valorTotExibe  =    number_format(str_replace(",", ".", $val_Total), 2, ',', '.');
            //     echo  "<br><font color = #0cb20c size = 2> Verificar valor =  ".$v_Valores;// variavel pra não cadastrar e voltar
            echo "<br><font color = red size = 2> Soma Total =  R$ <strong>" . $valorTotExibe . "</strong></font><br><br>";
            //    echo gettype($valorFinTotal), "<br>";
            echo "<font color = red size = 2>Valor lançado =  R$ <strong>" . $valorFinExibe . "</strong></font><br><br>";
            // echo gettype($valorFin), "<br>";

            if (($valorFin !==  $val_Total))
                echo "<font color = red size = 2>Valor lançado é diferente do somatório</strong></font><br><br>";


            if (formatoValor == false) {
                echo "Um ou mais valores inseridos não esta nos parametros solicitados";
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\"Um ou mais valores inseridos não esta nos parametros solicitados. Tente novamente! Linha: " . __LINE__ . "\");
											</script>";
                exit;
            }
            if ($qtd_presentes > 0) {
            } else {
                echo "Não há presentes especiais.
												Volte a pagina anterior e preencha todos os campos! Linha " . __LINE__;
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
												<script type=\"text/javascript\">
												alert(\"Não há presentes especiais.	Volte a pagina anterior e preencha todos os campos! <br>Linha: " . __LINE__ . "\");
												</script>";
                exit;
            }

            if ($v_Valores == "1") {
                if (($valorFin !==  $val_Total)) {

                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0;  URL=" . $p_Origem . "'> 
												<script type=\"text/javascript\">
												alert(\"Verifique se o somatório  é igual ao valor total do lançamento. Preencha todos os campos! - Linha: " . __LINE__ . "\");
												</script>";
                    exit;
                }
            }
        }
        //*****se for presente especial faz um lançamento 
        if ($cod_compassion == ("D07 - 0730")) //Saída com presentes especiais
        {
            //	echo 'linha '. __LINE__;
            if (!$id_presentes) //Saída com presentes especiais
            {
                //echo "cod_compassion: ".$cod_compassion." qtd_presentes: ".$qtd_presentes."<br>";
                echo "Linha: " . __LINE__ . "<br>Nenhum Beneficiário foi selecionado para este presente especial.
												Volte a pagina anterior e preencha todos os campos!";
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\" Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos! Linha: " . __LINE__ . "\");
											</script>";
                exit;
            }
            if ($id_presentes == 0) {
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=" . $p_Origem . "'> 
												<script type=\"text/javascript\">
												alert(\"Desculpe, Nenhum Beneficiário foi selecionado para este presente especial. Volte a pagina anterior e preencha todos os campos!\");
												</script>";
                exit;
            }

            $res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
            if (!$res_max) {
                die("<center>Desculpe, Nao foi encontrado o ultimo registro. Tente novamente:  "
                    . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");
                exit;
            }
            if (mysqli_num_rows($res_max) == 0) {
                echo "Nao foi encontrado nenhum ultimo registro. Tente novamente!"; //exit;
            }
            while ($id_ultimo = mysqli_fetch_assoc($res_max)) {
                $id_Maxaenp = $id_ultimo['id_fin'] + 1;
            }

            $presentes_saida = mysqli_query($conex, 'SELECT * FROM presentes_especiais
													WHERE  id_presente =  ' . $id_presentes . ' LIMIT 1');
            if (!$presentes_saida) {
                die("<center>Desculpe, Nao foi encontrado o registro de presente " . $id_presentes . ". Tente novamente:  "
                    . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='PaginaLancamento1.php'> Tente novamente</a></center>");
            }
            if (mysqli_num_rows($presentes_saida) == 0) {
                echo "<center><font color = red >Nao existem registros de presentes especiais!</font>";
                exit;
            }

            while ($rows_presentes = mysqli_fetch_assoc($presentes_saida)) {
                if ($valorFin > $rows_presentes['valor_pendente'] + 4.5) {
                    echo "Linha: " . __LINE__ . "<br>Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento!";
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\" Desculpe, O valor do lançamento é maior que o valor do presente.Retorne e refaça o lançamento! Linha: " . __LINE__ . "\");
											</script>";

                    exit;
                }


                $val_Restante = $rows_presentes['valor_pendente'] - $valorFin;

                $upd = "UPDATE presentes_especiais 
									SET id_saida = '" . $id_Maxaenp . "',data_presente= '" . $dataF . "',valor_saida = '" . $valorFin . "',valor_pendente = '" . $val_Restante . "'
									WHERE (id_presente =  " . $rows_presentes['id_presente'] . ")";
                $atualiz = mysqli_query($conex, $upd);
                if ($atualiz) {
                } else {
                    die("<center>Desculpe, Erro na atualização.:  "
                        . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
													<a href='menuF.php'>Voltar ao Menu</a></center>");
                    exit;
                }
                $id_entrada = $rows_presentes['id_entrada'];
                $data_presente = $rows_presentes['data_presente'];
                $n_beneficiario = $rows_presentes['n_beneficiario'];
                $nome_beneficiario = $rows_presentes['nome_beneficiario'];
                $n_protocolo = $rows_presentes['n_protocolo'];
                $valor_entrada = $rows_presentes['valor_entrada'];
            }
            if ($val_Restante > 0) {
                $crud = new Inserir('presentes_especiais');
                $crud->inserir(
                    "id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario,
                                        n_protocolo, valor_entrada, valor_pendente",
                    "'','$id_entrada','$id_saida','$data_presente','$n_beneficiario','$nome_beneficiario','$n_protocolo',
										'$valor_entrada','$val_Restante'"
                );

                //  $razaoSoc = $razaoSoc." - ".$n_beneficiario;
            }
        }

        echo "Conta lançaento - " . $caixa . " | Tipo - " . $tipoCont . " | Doc Banco - " . $num_Doc . " | Doc Fiscal " . $numDocFiscal . " | Histórico " . $razaoSoc . " | Data - " . $dataF . " | Valor - " . $valorFin;
        //exit;	
        /*		
						$crud = new Inserir('aenpfin');				
						$crud->inserir("id_fin, conta,tipo_Conta,cod_compassion,cod_assoc,num_Doc_Banco,num_Doc_Fiscal,
						historico,	descricao, dataFin,	valorFin,	ent_Sai, 	saldo,		saldo_Mes, cadastrante", 
						"'','$caixa','$tipoCont','$cod_compassion','$cod_assoc','$num_Doc','$numDocFiscal',
						'$razaoSoc','$descri','$dataF','$valorFin','$ent_Sai','$saldo_Final','$saldo_mes_lancamento','$cadastrante'"); 
						*/
        //******busca do ultimo registro com o saldo do mês marcado *********
        $sql_Saldo_Atual = 'SELECT id_fin, saldo, dataFin FROM aenpfin 					
											WHERE dataFin > "2019-01-01" and 
											conta = ' . $caixa . '  and tipo_Conta = "' . $tipoCont . '"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';
        $result_Saldo_Atual = mysqli_query($conex, $sql_Saldo_Atual);
        if (!$result_Saldo_Atual) {
            die("<center>Desculpe, erro na busca de saldo atual.:  "
                . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
            //exit;
        }
        if (mysqli_num_rows($result_Saldo_Atual) == 0) {
            echo "Nao existem lançamentos</br>";
        }
        while ($row_Saldo = mysqli_fetch_assoc($result_Saldo_Atual)) { //ID, valor do saldo e a data do registro com o ultimo saldo marcado
            $id_Ultimo_Saldo = $row_Saldo['id_fin'];
            $saldo_Atual = $row_Saldo['saldo'];
            $dataUlt_saldo = $row_Saldo['dataFin'];
        }
        //*****se pagamento for em cheque faz um lançamento de reconciliação bancária

        if ($tipo_Pag == "cheque") {
            $res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
            if (!$res_max) {
                die("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  "
                    . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
                //exit;
            }
            if (mysqli_num_rows($res_max) == 0) {
                echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
            }
            while ($id_ultimo = mysqli_fetch_assoc($res_max)) {
                $id_Maxaenp = $id_ultimo['id_fin'];
            }

            $data_Pag = $dataF;
            //$id_Maxaenp = $id_Maxaenp + 1;//guarda o id do registro atual pra referenciar o id do cheque
            //Ja marca se o cheque ja foi compensado
            if (isset($_POST["chequeCompen"])) {
                $status = 1;
            } else $status = 0;

            $crud = new Inserir('reconc_bank');
            $crud->inserir(
                "id_reconc, id_aenp, data_Emissao, data_Pag, status, operador",
                "'','$id_Maxaenp','$data_Pag',''$data_Pag','$status','$cadastrante'"
            );
        }



        //*****se for presente especial faz um lançamento 

        if ($cod_compassion == ("R01 - 1030")) //Entrada com presentes especiais
        {
            $res_max = mysqli_query($conex, 'SELECT id_fin FROM aenpfin ORDER BY id_fin DESC LIMIT 1 ');
            if (!$res_max) {
                die("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  "
                    . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
										<a href='menu1.php'>Voltar ao Menu</a></center>");
                //exit;
            }
            if (mysqli_num_rows($res_max) == 0) {
                echo "Nao foi encontrado nenhum id_aenpfin. Tente novamente!"; //exit;
            }
            while ($id_ultimo = mysqli_fetch_assoc($res_max)) {
                $id_Maxaenp = $id_ultimo['id_fin'];
            }

            $contar = 1;
            while (($contar <= $qtd_presentes) || $contar == 50) {


                $n_nome = 'nome' . $contar; // Nomes das variaveis de cada cadastro
                $n_codigo = 'Codigo' . $contar;
                $n_protocolo = 'Protocolo' . $contar;
                $n_valorPre = 'valorPre' . $contar;

                $nome = $_POST[$n_nome];
                $Codigo    = $_POST[$n_codigo];
                $Protocolo = $_POST[$n_protocolo];
                $valorPre = $_POST[$n_valorPre];

                $data_presente = $dataF;


                if (formatoRealPntVrg($valorPre) == true) { //Verific se o numero digitado é com (.) milhar e (,) decimal
                    //serve pra validar  valores acima e abaixo de 1000
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorPre  =    ((float)str_replace(",", ".", (str_replace(".", "", $valorPre))));
                } else if (formatoRealInt($valorPre) == true) { //Verific se o numero digitado é inteiro sem ponto nem virgula
                    //serve pra validar  valores acima e abaixo de 1000
                    //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorPre  =    number_format(str_replace(".", "", $valorPre), 2, '.', '');
                } else if (formatoRealPnt($valorPre) == true) {
                    //      echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorPre  =    $valorPre;
                } else if (formatoRealVrg($valorPre) == true) {
                    //        echo "ERRO!  - <strong><td> ;Linha: ". __LINE__ . ", tente novamente!</td></strong><br/>"; 
                    $valorPre  =   ((float)str_replace(",", ".", (str_replace(".", "", $valorPre))));
                }




                $crud = new Inserir('presentes_especiais');
                $crud->inserir(
                    "id_presente, id_entrada, id_saida, data_presente, n_beneficiario, nome_beneficiario, n_protocolo,
                                valor_entrada, valor_pendente",
                    "'','$id_Maxaenp','$id_saida','$data_presente','$Codigo','$nome','$Protocolo', '$valorPre', '$valorPre'"
                );


                $contar = $contar + 1;
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
											conta = ' . $caixa . '  and tipo_Conta = "' . $tipoCont . '"
											and saldo_Mes = "S" ORDER BY dataFin DESC LIMIT 1 ';

        $result_saldo_Penultimo = mysqli_query($conex, $saldo_Penultimo);
        if (!$result_saldo_Penultimo) {
            die("<center>Desculpe, erro na busca de saldo atual.:  "
                . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menu1.php'>Voltar ao Menu</a></center>");
            //exit;
        }
        if (mysqli_num_rows($result_saldo_Penultimo) == 0) {
            echo "Nao existem lançamentos</br>";
        }
        while ($row_saldo_Penultimo = mysqli_fetch_assoc($result_saldo_Penultimo)) { //ID, valor do saldo e a data do registro com o penultimo saldo marcado
            $id_saldo_Penultimo = $row_saldo_Penultimo['id_fin'];
            $saldo_Penultimo = $row_saldo_Penultimo['saldo'];
            $data_saldo_Penultimo = $row_saldo_Penultimo['dataFin'];
        }
        //******busca de todos registro, após o penultimo saldo *********						
        $maisRecentes = mysqli_query($conex, 'SELECT id_fin, conta, tipo_Conta, dataFin, ent_Sai, valorFin, saldo FROM aenpfin 
															WHERE  dataFin > "' . $data_saldo_Penultimo . '" 
															and conta like "' . $caixa . '" and tipo_Conta like "' . $tipoCont . '" 
															ORDER BY dataFin, id_fin ');
        if (!$maisRecentes) {
            die("<center>Desculpe, Nao foi encontrado nenhum item com esse criterio. Tente novamente:  "
                . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
											<a href='menuF.php'>Voltar ao Menu</a></center>");
            //exit;
        }
        if (mysqli_num_rows($maisRecentes) == 0) {
            echo "Nao foi encontrado nenhum registro após o penultimo saldo. Tente novamente!";
        }
        //inicia variavel do dia final do mes do registro anterior com o dia fim do mês do lançamento								
        $fim_mes = ultimoDiaMes($dataF);

        $s_anterior =    $saldo_Penultimo;
        while ($maisRecent = mysqli_fetch_assoc($maisRecentes)) {
            //if ($maisRecent['dataFin'] > $dataF) 
            //{
            $ent_Sai = $maisRecent['ent_Sai'];
            if ($ent_Sai == 0) {
                $s_Atual = $s_anterior - $maisRecent['valorFin']; //$valorFin;
            } else if ($ent_Sai == 1) {
                $s_Atual = $s_anterior + $maisRecent['valorFin'];
            }
            $upd = "UPDATE aenpfin SET saldo = " . $s_Atual . " WHERE (id_fin =  " . $maisRecent['id_fin'] . ")";
            $atualiz = mysqli_query($conex, $upd);
            if ($atualiz) {
            } else {
                die("<center>Desculpe, Erro na atualização.:  "
                    . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
												<a href='menuF.php'>Voltar ao Menu</a></center>");    //exit;												
            }
            //}
            $s_anterior =    $s_Atual;
            $dataX = $maisRecent['dataFin'];
            $d_anterior = $dataX;
            $data_ultimo_dia = ultimoDiaMes($dataX); //inicia variavel do dia final do mes do registro atual

            if (null !== $id_anterior) {
                if ($dataX > $fim_mes) {
                    $saldo_mes = "S"; // Marca se for o ultimos registro de saldos de cada mes 
                } else $saldo_mes = "N";

                $upd = "UPDATE aenpfin SET saldo_Mes = '" . $saldo_mes . "' WHERE (id_fin =  " . $id_anterior . ")";
                $atualiz = mysqli_query($conex, $upd);
                if ($atualiz) {
                } else {
                    die("<center>Desculpe, Erro na atualização.:  "
                        . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>													
											<a href='menuF.php'>Voltar ao Menu</a></center>");    //exit;												
                }
            }
            if ($saldo_mes == "S") $s_mes = "| Saldo do mês.";
            else $s_mes = "";
            echo '<font color=red size="2"> Conta ' . $maisRecent['conta'];
            echo ' | Tipo ' . $maisRecent['tipo_Conta'] . ' | Data </font> <font color=green>' . $d_anterior . ' </font> <font color=red>
									| Registro ' . $id_anterior . ' | Saldo alterado para ' . $s_Atual . '  
									' . $s_mes . ' <td></font><br />';

            $id_anterior = $maisRecent['id_fin'];
            $fim_mes = $data_ultimo_dia;
        }

        $_SESSION['tE_S_N'] = $entrada_S;
        $_SESSION['tE_S'] = $entrada_Saida;
        $_SESSION['t_Cont'] = $tip_Cont;
        $_SESSION['Cont'] = $contaX;
        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=" . $p_Origem . "'>
											<script type=\"text/javascript\">
											alert(\"Alterações realizada com sucesso. Novo lançamento. \");										
											</script>";
        //		formulario.submit();
        //		</script>";	
    }
}
