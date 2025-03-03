<?php
class Mapos_model extends CI_Model {

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function alterarSenha($newSenha,$oldSenha,$id){

        $this->db->where('idUsuarios', $id);
        $this->db->limit(1);
        $usuario = $this->db->get('usuarios')->row();

        $senha = $this->encryption->decrypt($usuario->senha);

        if($senha != $oldSenha){
            return false;
        }
        else{
            $this->db->set('senha',$this->encryption->encrypt($newSenha));
            $this->db->where('idUsuarios',$id);
            return $this->db->update('usuarios');    
        }

        
    }

    function pesquisar($termo){
         $data = array();
         // buscando clientes
         $this->db->like('nomeCliente',$termo);
         $this->db->limit(5);
         $data['clientes'] = $this->db->get('clientes')->result();

         // buscando os
         $this->db->like('idOs',$termo);
         $this->db->limit(5);
         $data['os'] = $this->db->get('os')->result();

         // buscando produtos
         $this->db->like('descricao',$termo);
         $this->db->limit(5);
         $data['produtos'] = $this->db->get('produtos')->result();

         //buscando serviços
         $this->db->like('nome',$termo);
         $this->db->limit(5);
         $data['servicos'] = $this->db->get('servicos')->result();

         return $data;


    }

    function get3($table,$fields,$fields2){
        
        $this->db->order_by($fields2,'desc');
        $this->db->order_by($fields);
        return $this->db->get($table)->result();
    }

    function get2($table,$fields){
        
        $this->db->order_by($fields);
        return $this->db->get($table)->result();
    }
    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }   
	
	function count($table){
		return $this->db->count_all($table);
	}

    function getOsAbertas(){
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status','Aberto');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    function getLancamentos($table){
        $this->db->select($table.'.*, caixas.nome_caixa, caixas.id_caixa, usuarios.nome');
        $this->db->from($table);
        $this->db->limit(5);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.conta');
        $this->db->join('usuarios',' usuarios.idUsuarios = aenpfin.cadastrante');
        $this->db->order_by('id_fin','desc');
        return $this->db->get()->result();
    }

    function getLanceCredito($table,$fatura=0,$dataFatura=0,$fundoFinanceiro=0){
        $menos2Meses = date('Y-m-d', strtotime("-2 month", strtotime(date('Y-m-d')))); //DA final DO MÊS (FINAL)
        $this->db->select($table.'.*, cont_Contabil');
        $this->db->join('cod_assoc', 'cod_assoc.cod_Ass = '.$table.'.cod_assoc');
        $this->db->from($table);
        
        if($fatura == 0){
            $this->db->where('cod_compassion !=','D10-01');
            $this->db->where('num_Doc_Fiscal','Previsto');
        $this->db->order_by('cod_assoc');
                $this->db->order_by('dataEvento');
        }else
        if($fatura == 1)// Somente faturas
        {
            if($dataFatura == 1)// Somente fundo expecifico e mês
            {
                $faturas = array('D10-01','D10-07');
                $this->db->where_in('cod_compassion',$faturas);
                $this->db->where('dataFin > ',$menos2Meses);
                $this->db->order_by('cont_Contabil');
                $this->db->order_by('cod_assoc');
                $this->db->order_by('dataFin');
            }else
            if($dataFatura != 0)// Somente fundo expecifico e mês
            {
                $this->db->where('cod_compassion !=','D10-01');
                $this->db->where('cod_compassion !=','D10-07');
                if($fundoFinanceiro != "C-EMP")
                    $this->db->where('dataFin',$dataFatura);
                else{
                    $this->db->where('YEAR(dataFin)',date('Y', strtotime($dataFatura)));
                    $this->db->where('MONTH(dataFin)',date('m', strtotime($dataFatura)));
                }
                $this->db->where('cod_assoc',$fundoFinanceiro);
        $this->db->order_by('cod_assoc');
                $this->db->order_by('dataEvento');
            }else{
                $faturas = array('D10-01','D10-07');
                $this->db->where_in('cod_compassion',$faturas);
                $this->db->where('num_Doc_Fiscal','Previsto');
        $this->db->order_by('cod_assoc');
                $this->db->order_by('dataEvento');
                }
        }
        return $this->db->get()->result();
    }
    function getLancamentosFuturos($table){
        $this->db->select($table.'.*, cc.descricaoCod, ca.descricao_Ass');
        $this->db->from($table);
        $this->db->where('dataFin >= ',date('Y-m-01'));
        $this->db->join('cod_compassion cc', 'cc.cod_Comp = '.$table.'.cod_compassion');
        $this->db->join('cod_assoc ca', 'ca.cod_Ass = '.$table.'.cod_assoc');
        $this->db->order_by('num_Doc_Fiscal');
        $this->db->order_by('dataFin');
        return $this->db->get()->result();
    }
    function getProdutosMinimo(){

        $sql = "SELECT * FROM produtos WHERE estoque <= estoqueMinimo LIMIT 10"; 
        return $this->db->query($sql)->result();

    }

    function getOsEstatisticas(){
        $dataInicial = date('Y-m-01');
        $dataFim = date('Y-m-d', strtotime("+1 month", strtotime($dataInicial)));
       // $dataFim = date('2022-06-01');
       // $sql = "SELECT conta, COUNT(conta) as total FROM aenpfin  WHERE dataFin >= ".$dataInicial." GROUP BY conta ORDER BY conta";
        $sql = "SELECT * FROM aenpfin  WHERE dataFin >= '".$dataInicial."' AND dataFin < '".$dataFim."' AND num_Doc_Banco != '0/0'  ORDER BY conta";
        return $this->db->query($sql)->result();
    }

    public function getEstatisticasFinanceiro(){
        $sql = "SELECT SUM(CASE WHEN  ent_Sai = '1' THEN valorFin END) as total_receita1C, 
                       SUM(CASE WHEN  ent_Sai = '0' THEN valorFin END) as total_despesa1C,
                       SUM(CASE WHEN  ent_Sai = '1' THEN valorFin END) as total_receita1S,
                       SUM(CASE WHEN  ent_Sai = '0' THEN valorFin END) as total_despesa1S
                       FROM aenpfin  ";
        return $this->db->query($sql)->row();
    }


    public function getMindataFatura($fundo){
        $hoje = date('Y-m-01');
        $sql = "SELECT MIN(CASE WHEN  cod_assoc = '".$fundo ."' AND num_Doc_Fiscal = 'Previsto' AND dataFin > '".$hoje."'  THEN dataFin END) as dataProxFatura FROM aenpfin  ";
        return $this->db->query($sql)->row();
    }

    public function getEstatisticaPrevistaMes($dia0,$dia1,$eS,$fundo){
      // $dia0 = '2022-06-01'; $dia1 = '2022-06-30';
        $whereText = "WHERE dataFin BETWEEN ".$dia0." AND ".$dia1." AND num_Doc_Banco != '0/0' AND num_Doc_Fiscal = 'Previsto' AND ent_Sai = ".$eS."  AND cod_assoc = '".$fundo."'";
        $whereText = "WHERE dataFin BETWEEN '".$dia0."' AND '".$dia1."' AND num_Doc_Banco != '0/0' AND num_Doc_Fiscal = 'Previsto' AND ent_Sai = ".$eS."  AND cod_assoc = '".$fundo."'";
        
       // $sql = "SELECT SUM(valorFin) AS soma FROM aenpfin ".$whereText." ";
        $sql = "SELECT SUM(valorFin) AS soma FROM aenpfin ".$whereText." ";
        return $this->db->query($sql)->row();
    }

    public function getEstatisticaSomaMes($dia0, $dia1){
       
        $whereText = "";
        $whereText .= "SUM(CASE WHEN  (cod_assoc = 'D-BT' OR num_Doc_Banco = '0/0' OR cod_assoc = 'C-ALT') AND ent_Sai = 1 AND dataFin BETWEEN '".$dia0."' AND '".$dia1."' THEN valorFin END) as tr, ";//tr ( Total receita)
        $whereText .= "SUM(CASE WHEN  num_Doc_Banco = '0/0'  AND ent_Sai = 0 AND dataFin BETWEEN '".$dia0."' AND '".$dia1."' THEN valorFin END) as tdC, ";//td ( Total despesa)      
        $whereText .= "SUM(CASE WHEN  (cod_assoc = 'D-BT' OR cod_assoc = 'C-ALT' ) AND ent_Sai = 0 AND dataFin BETWEEN '".$dia0."' AND '".$dia1."' THEN valorFin END) as tdD, ";//td ( Total despesa)           
        $whereText .= "MIN(CASE WHEN  dataFin BETWEEN '".$dia0."' AND '".$dia1."' THEN dataFin END) as dataI";//td ( Total despesa)
           
        $sql = "SELECT ".$whereText." FROM aenpfin ";
        return $this->db->query($sql)->row();
    }




    public function getEmitente()
    {
        return $this->db->get('emitente')->result();
    }

    public function addEmitente($nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email, $logo){
       
       $this->db->set('nome', $nome);
       $this->db->set('cnpj', $cnpj);
       $this->db->set('ie', $ie);
       $this->db->set('rua', $logradouro);
       $this->db->set('numero', $numero);
       $this->db->set('bairro', $bairro);
       $this->db->set('cidade', $cidade);
       $this->db->set('uf', $uf);
       $this->db->set('telefone', $telefone);
       $this->db->set('email', $email);
       $this->db->set('url_logo', $logo);
       return $this->db->insert('emitente');
    }


    public function editEmitente($id, $nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email){
        
       $this->db->set('nome', $nome);
       $this->db->set('cnpj', $cnpj);
       $this->db->set('ie', $ie);
       $this->db->set('rua', $logradouro);
       $this->db->set('numero', $numero);
       $this->db->set('bairro', $bairro);
       $this->db->set('cidade', $cidade);
       $this->db->set('uf', $uf);
       $this->db->set('telefone', $telefone);
       $this->db->set('email', $email);
       $this->db->where('id', $id);
       return $this->db->update('emitente');
    }


    public function editLogo($id, $logo){
        
        $this->db->set('url_logo', $logo); 
        $this->db->where('id', $id);
        return $this->db->update('emitente'); 
         
    }

    public function check_credentials($email) {
        $this->db->where('email', $email);
        $this->db->where('situacao', 1);
        $this->db->limit(1);
        return $this->db->get('usuarios')->row();
    }
}