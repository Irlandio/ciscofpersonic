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

    
    
    function get($table,$fields,$contN,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        // if($where){
        //     if(isset($where['contas'])){
        //         $this->db->like('n_beneficiario',$where['contas']);
        //     }
        //     if(isset($where['benef'])){
        //         $this->db->where('n_beneficiario',$where['benef']);
        //     }
        // }else 
        // if($contN != 99)
        //     $this->db->like('n_beneficiario',$contN);
        $this->db->order_by('quilometragem','desc');
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
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
	
	function count($table){
		return $this->db->count_all($table);
	}
}