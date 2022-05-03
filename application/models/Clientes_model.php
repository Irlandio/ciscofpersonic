<?php
class Clientes_model extends CI_Model {

    /**
     * author:  Irlândio Oliveira 
     * email: irlandiooliveira@gmail.com
     * 
     */
    
    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){
            
            if(array_key_exists('pesquisa',$where)){
                
                if( $where['tipo'] <> 3)
                {
                $this->db->select('nomeCliente');
                if( $where['tipo'] == 1)
               $this->db->like('nomeCliente',$where['pesquisa']);
                if( $where['tipo'] == 2)
               $this->db->like('documento',$where['pesquisa']);              
                
                $this->db->limit(5);
                $clientes = $this->db->get('clientes')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->nomeCliente);
                }
                }
            }
        }
        $this->db->select($fields.', caixas.nome_caixa, caixas.id_caixa');
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.telefone');
        $this->db->order_by('nomeCliente','asc');
        $this->db->limit($perpage,$start);
        
        // condicional de clientes
        if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in('clientes.nomeCliente',$lista_clientes);
            }
            if( $where['tipo'] == 3)                
               $this->db->like('documento',$where['pesquisa']); 
        }
        

        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function get0($table,$fields,$contaU,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $lista_clientes = array();
        if($where){
            
            if(array_key_exists('pesquisa',$where)){
                
                if( $where['tipo'] <> 3)
                {
                $this->db->select('nomeCliente');
                if( $where['tipo'] == 1)
               $this->db->like('nomeCliente',$where['pesquisa']);
                if( $where['tipo'] == 2)
               $this->db->like('documento',$where['pesquisa']);              
                
                $this->db->limit(5);
                $clientes = $this->db->get('clientes')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->nomeCliente);
                }
                }
            }
        }
        $this->db->select($fields.', caixas.nome_caixa, caixas.id_caixa');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.telefone');
        $this->db->order_by('nomeCliente','asc');
        $this->db->where($table.'.telefone',$contaU);
       
        // condicional de clientes
       if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in($table.'.nomeCliente',$lista_clientes);
            }
        }
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    

    function get2($table,$fields){
        
        $this->db->order_by($fields);
        return $this->db->get($table)->result();
    }

    function getById($id){
        $this->db->where('idClientes',$id);
        $this->db->limit(1);
        return $this->db->get('clientes')->row();
    }
    
    
    function getByIdUser($id){
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao, caixas.*');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
        $this->db->join('caixas', 'usuarios.conta_Usuario = caixas.id_caixa', 'left');
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
        
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

    function count($table) {
        return $this->db->count_all($table);
    }
    
    public function getOsByCliente($id){
        $this->db->where('clientes_id',$id);
        $this->db->order_by('idOs','desc');
        $this->db->limit(10);
        return $this->db->get('os')->result();
    }

}