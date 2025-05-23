<?php
class Produtos_model extends CI_Model {

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {
        parent::__construct();
    }

    
    function get($table, $fields, $tudo, $contN, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array') {
        $this->db->select("$table.*, p.nome as nome_posto, p.endereco as end_posto, c.nome as nome_cidade, c.estado, v.marca, v.modelo");
        $this->db->from($table);
        
        if ($tudo == 0) {
            $this->db->limit($perpage, $start);
        }
        
        // JOIN com a tabela de postos
        $this->db->join('postos p', "p.id_posto = {$table}.posto");
        $this->db->join('veiculos v', "v.id = {$table}.veiculo");
    
        // JOIN com a tabela de cidades (p.idC representa o código da cidade)
        $this->db->join('cidade c', "c.idC = p.cidade", 'left');
    
        $this->db->order_by('data_abast', 'desc');
        $this->db->order_by('quilometragem', 'desc');
    
        $query = $this->db->get();
        
        $result = !$one ? $query->result() : $query->row();
        return $result;
    }
    

    function getBeneficiarios($table,$contN){
        $this->db->from($table);
        if($contN != 99)
        $this->db->where('telefone',$contN);
        $this->db->order_by('telefone');
        $this->db->order_by('nomeCliente');
        return $this->db->get()->result();
    }

    function get2($table){
        
        return $this->db->get($table)->result();
    }

    function get2Join($tabela1, $campoTabela1, $tabela2, $campoTabela2, $selectCampos = '*') {
        $this->db->select($selectCampos);
        $this->db->from($tabela1);
        $this->db->join($tabela2, "$tabela2.$campoTabela2 = $tabela1.$campoTabela1", 'left'); 
        return $this->db->get()->result();
    }
    
    
    function getById($table,$fields,$id){
        $this->db->where($fields,$id);
        $this->db->limit(1);
        return $this->db->get($table)->row();
    }
    function getByIds($table,$fields,$id){
        $this->db->from($table);
        $this->db->where($fields,$id);
    //    $this->db->limit(1);
        $query = $this->db->get();
        
        $result =  $query->result();
        return $result;
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
	
    public function getMenorUltimoKm() {
    $sql = "
        SELECT c.*
        FROM combustivel c
        INNER JOIN veiculos v ON c.veiculo = v.id
        INNER JOIN (
            SELECT veiculo, MAX(data_abast) AS max_data
            FROM combustivel
            GROUP BY veiculo
        ) ult ON ult.veiculo = c.veiculo AND ult.max_data = c.data_abast
        WHERE v.situacao = 1
        ORDER BY c.quilometragem ASC
        LIMIT 1
    ";

    return $this->db->query($sql)->row();
}

	function count($table){
		return $this->db->count_all($table);
	}
}