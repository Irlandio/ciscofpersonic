<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendas_model extends CI_Model {

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
            if(array_key_exists('pesquisa',$where)){ $this->db->select('historico');
               $this->db->like('historico',$where['pesquisa']);
                $this->db->order_by('dataFin','desc');
                $this->db->limit(40);
                $clientes = $this->db->get('aenpfin')->result();

                foreach ($clientes as $c) {
                    array_push($lista_clientes,$c->historico);
                }
            }
        }
        $this->db->select($fields.', caixas.nome_caixa, caixas.id_caixa');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.conta');
        $this->db->order_by('id_fin','desc');
      //  if($where){ $this->db->where($where);   }
// condicionais da pesquisa
        // condicional de clientes
        if(array_key_exists('pesquisa',$where)){
            if($lista_clientes != null){
                $this->db->where_in('aenpfin.historico',$lista_clientes);
            }
        }        
        // condicional de Cod
        if(array_key_exists('cod',$where)){
            $this->db->where('id_fin',$where['cod']);
        }
        
        // condicional de Conta
        if(array_key_exists('status',$where)){
            $this->db->where('conta',$where['status']);
        }

        // condicional data inicial
        if(array_key_exists('de',$where)){
            $this->db->where('dataFin >=' ,$where['de']);
        }
        // condicional data final
        if(array_key_exists('ate',$where)){

            $this->db->where('dataFin <=', $where['ate']);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    
    function get0($table,$fields,$contaU,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.', caixas.nome_caixa, caixas.id_caixa');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.conta');
        $this->db->order_by('id_fin','desc');
        $this->db->where('aenpfin.conta',$contaU);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    
    function get1($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.', caixas.nome_caixa, caixas.id_caixa');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('caixas', 'caixas.id_caixa = '.$table.'.conta');
        $this->db->order_by('id_fin','desc');
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function get3($table,$fields,$fields2){
        
        $this->db->order_by($fields2,'desc');
        $this->db->order_by($fields);
        return $this->db->get($table)->result();
    }

    function get2($table){
        
        return $this->db->get($table)->result();
    }

    function getPresente($id_ouProtocolo, $ent_Sai){
        $this->db->select('presentes_especiais.*');
        $this->db->from('presentes_especiais');
        if($ent_Sai == 1)
        {//Seleciona todos os presentes especiais referentes ao lançamento de entrada com o id recebido
        $this->db->where('id_entrada',$id_ouProtocolo);    
         $this->db->order_by('n_protocolo','id_presente');
        } else if($ent_Sai == 0)
        {
        $this->db->where('n_protocolo',$id_ouProtocolo);        
        $this->db->order_by('id_presente');
        }
        $affect  =   $this->db->affected_rows();
        return $this->db->get()->result();
   
    }

    function getByIdPre($id){
        $this->db->select('presentes_especiais.*');
        $this->db->from('presentes_especiais');
        {
        $this->db->where('n_protocolo',$id);        
        $this->db->order_by('id_presente');
        }
        $this->db->limit(1);
        return $this->db->get()->row();
   
    }

    function getProtocPres($protoc){
        $this->db->select('presentes_especiais.*');
        $this->db->from('presentes_especiais');
        $this->db->where('protocolo',$protoc);
        return $this->db->get()->result();
   
    }

    function getS_antesFin($table,$datainicioLimite,$dia_1_mes,$conta,$tipoCont_Atual){
        $this->db->select('aenpfin.id_fin, aenpfin.saldo, aenpfin.dataFin');
        $this->db->from($table);
        $this->db->where('dataFin >',$datainicioLimite);
        $this->db->where('dataFin <',$dia_1_mes);
        $this->db->where('conta',$conta);
        $this->db->where('tipo_Conta',$tipoCont_Atual);
        $this->db->where('saldo_Mes','S');
        $this->db->order_by('dataFin','desc');   
        $this->db->limit(1);
        return $this->db->get()->row();
    }
     public function getLancPosSaldo($table,$fields,$data_saldo_Penultimo,$conta,$tipoCont_Atual){
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('dataFin >',$data_saldo_Penultimo);
        $this->db->where('conta',$conta);
        $this->db->where('tipo_Conta',$tipoCont_Atual);
        $this->db->order_by('dataFin');         
        $this->db->order_by('id_fin');
        return $this->db->get()->result();
    }


    
     public function getIdultimo($conta,$t_conta){
        $this->db->select('aenpfin.*');
        $this->db->from('aenpfin');
        $this->db->where('conta',$conta);
        $this->db->where('tipo_Conta',$t_conta);
        $this->db->where('saldo_Mes',"S");
        $this->db->order_by('id_fin','desc');         
        $this->db->limit(1);
        return $this->db->get()->row();
    }


    function getById1($id){
	  
        $this->db->select('aenpfin.*');
        $this->db->from('aenpfin');
        $this->db->where('aenpfin.id_fin',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    function getById($id){
	  //  $this->db->select('aenpfin.*, caixas.*,cod_compassion.*,cod_compassion.descricao as codDescricao, cod_assoc.*, aenpfin.descricao as finDescricao, usuarios.nome');
        $this->db->select('aenpfin.*, caixas.*, aenpfin.descricao as finDescricao, usuarios.nome');
        $this->db->from('aenpfin');
        $this->db->join('caixas',' caixas.id_caixa = aenpfin.conta');
   //     $this->db->join('cod_compassion',' cod_compassion.cod_Comp = aenpfin.cod_compassion');
     //   $this->db->join('cod_assoc',' cod_assoc.cod_Ass = aenpfin.cod_assoc');
        $this->db->join('usuarios',' usuarios.idUsuarios = aenpfin.cadastrante');
        $this->db->where('aenpfin.id_fin',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    function getByIdChek($id){
	    $this->db->select('reconc_bank.* ');
        $this->db->from('reconc_bank');
        $this->db->where('reconc_bank.id_aenp',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
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
    
    
     public function getCodIead($id = null){
        $this->db->select('itens_de_vendas.*, produtos.*');
        $this->db->from('itens_de_vendas');
        $this->db->join('produtos','produtos.idProdutos = itens_de_vendas.produtos_id');
        $this->db->where('vendas_id',$id);
        return $this->db->get()->result();
    }
    
    public function getPresentes($conta){
        $this->db->select('presentes_especiais.*, aenpfin.*');
        $this->db->from('presentes_especiais');
        $this->db->join('aenpfin','presentes_especiais.id_entrada = aenpfin.id_fin');
        $this->db->where('presentes_especiais.id_saida','0');
        $this->db->where('aenpfin.conta',$conta);
        $this->db->order_by('dataFin');          
        return $this->db->get()->result();
    }
    
    public function anexar( $fin_id, $anexo, $url, $thumb, $path){
        
        $this->db->set('anexo',$anexo);
        $this->db->set('thumb',$thumb);
        $this->db->set('url',$url);
        $this->db->set('path',$path);
        $this->db->set('fin_id',$fin_id);

        return $this->db->insert('anexos');
    }

    public function getAnexos($idFin){
        
        $this->db->where('fin_id', $idFin);
        return $this->db->get('anexos')->result();
    }
   
    
    public function getProdutos($id = null){
        $this->db->select('itens_de_vendas.*, produtos.*');
        $this->db->from('itens_de_vendas');
        $this->db->join('produtos','produtos.idProdutos = itens_de_vendas.produtos_id');
        $this->db->where('vendas_id',$id);
        return $this->db->get()->result();
    }

    
    function add($table,$data,$returnId = false){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
                        if($returnId == true){
                            return $this->db->insert_id($table);
                        }
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

    public function autoCompleteProduto($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descricao', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoVenda'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoVenda']);
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteCliente($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nomeCliente', $q);
        $query = $this->db->get('clientes');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nomeCliente'].' | Telefone: '.$row['telefone'],'id'=>$row['idClientes']);
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteUsuario($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nome', $q);
        $this->db->where('situacao',1);
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | Telefone: '.$row['telefone'],'id'=>$row['idUsuarios']);
            }
            echo json_encode($row_set);
        }
    }



}

/* End of file vendas_model.php */
/* Location: ./application/models/vendas_model.php */