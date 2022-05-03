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
     //   $this->db->join('caixas', 'usuarios.conta_Usuario = caixas.id_caixa', 'left');
        $this->db->order_by('id_fin','desc');
        return $this->db->get()->result();

    }
    function getProdutosMinimo(){

        $sql = "SELECT * FROM produtos WHERE estoque <= estoqueMinimo LIMIT 10"; 
        return $this->db->query($sql)->result();

    }

    function getOsEstatisticas(){
        $dataInicial = date('Y-m-01');
       // $sql = "SELECT conta, COUNT(conta) as total FROM aenpfin  WHERE dataFin >= ".$dataInicial." GROUP BY conta ORDER BY conta";
        $sql = "SELECT conta FROM aenpfin  WHERE dataFin >= '".$dataInicial."'  ORDER BY conta";
        return $this->db->query($sql)->result();
    }

    public function getEstatisticasFinanceiro(){
        $sql = "SELECT SUM(CASE WHEN conta = 1 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita1C, 
                       SUM(CASE WHEN conta = 1 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa1C,
                       SUM(CASE WHEN conta = 1 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita1S,
                       SUM(CASE WHEN conta = 1 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa1S,
                       
                       SUM(CASE WHEN conta = 2 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita2C, 
                       SUM(CASE WHEN conta = 2 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa2C,
                       SUM(CASE WHEN conta = 2 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita2S,
                       SUM(CASE WHEN conta = 2 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa2S,
                       
                       SUM(CASE WHEN conta = 3 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita3S,
                       SUM(CASE WHEN conta = 3 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa3S,
                       
                       SUM(CASE WHEN conta = 4 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita4C, 
                       SUM(CASE WHEN conta = 4 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa4C,
                       SUM(CASE WHEN conta = 4 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita4S,
                       SUM(CASE WHEN conta = 4 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa4S,
                       
                       SUM(CASE WHEN conta = 5 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita5C, 
                       SUM(CASE WHEN conta = 5 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa5C,
                       SUM(CASE WHEN conta = 5 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita5S,
                       SUM(CASE WHEN conta = 5 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa5S,
                       
                       SUM(CASE WHEN conta = 6 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita6C, 
                       SUM(CASE WHEN conta = 6 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa6C,
                       SUM(CASE WHEN conta = 6 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita6S,
                       SUM(CASE WHEN conta = 6 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa6S,
                       
                       SUM(CASE WHEN conta = 7 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita7C, 
                       SUM(CASE WHEN conta = 7 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa7C,
                       SUM(CASE WHEN conta = 7 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita7S,
                       SUM(CASE WHEN conta = 7 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa7S,
                       
                       
                       SUM(CASE WHEN conta = 8 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita8C, 
                       SUM(CASE WHEN conta = 8 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa8C,
                       SUM(CASE WHEN conta = 8 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita8S,
                       SUM(CASE WHEN conta = 8 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa8S,
                       
                       
                       SUM(CASE WHEN conta = 9 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita9C, 
                       SUM(CASE WHEN conta = 9 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa9C,
                       SUM(CASE WHEN conta = 6 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita9S,
                       SUM(CASE WHEN conta = 9 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa9S,
                       
                       
                       SUM(CASE WHEN conta = 10 AND tipo_Conta = 'Corrente'  AND ent_Sai = '1' THEN valorFin END) as total_receita10C, 
                       SUM(CASE WHEN conta = 10 AND tipo_Conta = 'Corrente'  AND ent_Sai = '0' THEN valorFin END) as total_despesa10C,
                       SUM(CASE WHEN conta = 10 AND tipo_Conta = 'Suporte'  AND ent_Sai = '1' THEN valorFin END) as total_receita10S,
                       SUM(CASE WHEN conta = 10 AND tipo_Conta = 'Suporte'  AND ent_Sai = '0' THEN valorFin END) as total_despesa10S
                       FROM aenpfin  ";
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