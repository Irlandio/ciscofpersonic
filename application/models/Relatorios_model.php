<?php
class Relatorios_model extends CI_Model {


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
    
    function get2($table){
        
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

    function count($table) {
        return $this->db->count_all($table);
    }
    
    public function clientesCustom($dataInicial = null,$dataFinal = null){
        
        if($dataInicial == null || $dataFinal == null){
            $dataInicial = date('Y-m-d');
            $dataFinal = date('Y-m-d');
        }
        $query = "SELECT * FROM clientes WHERE dataCadastro BETWEEN ? AND ?";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }

    public function clientesRapid(){
        $this->db->order_by('nomeCliente','asc');
        return $this->db->get('clientes')->result();
    }

    public function produtosRapid(){
        $this->db->order_by('descricao','asc');
        return $this->db->get('produtos')->result();
    }

    public function servicosRapid(){
        $this->db->order_by('nome','asc');
        return $this->db->get('servicos')->result();
    }

    public function osRapid(){
        $this->db->select('os.*,clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes','clientes.idClientes = os.clientes_id');
        return $this->db->get()->result();
    }

    public function produtosRapidMin(){
        $this->db->order_by('descricao','asc');
        $this->db->where('estoque < estoqueMinimo');
        return $this->db->get('produtos')->result();
    }

    public function produtosCustom($precoInicial = null,$precoFinal = null,$estoqueInicial = null,$estoqueFinal = null){
        $wherePreco = "";
        $whereEstoque = "";
        if($precoInicial != null){
            $wherePreco = "AND precoVenda BETWEEN ".$this->db->escape($precoInicial)." AND ".$this->db->escape($precoFinal);
        }
        if($estoqueInicial != null){
            $whereEstoque = "AND estoque BETWEEN ".$this->db->escape($estoqueInicial)." AND ".$this->db->escape($estoqueFinal);
        }
        $query = "SELECT * FROM produtos WHERE estoque >= 0 $wherePreco $whereEstoque";
        return $this->db->query($query)->result();
    }

    public function servicosCustom($precoInicial = null,$precoFinal = null){
        $query = "SELECT * FROM servicos WHERE preco BETWEEN ? AND ?";
        return $this->db->query($query, array($precoInicial,$precoFinal))->result();
    }


    public function osCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null,$status = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if($dataInicial != null){
            $whereData = "AND dataInicial BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND clientes_id = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND usuarios_id = ".$this->db->escape($responsavel);
        }
        if($status != null){
            $whereStatus = "AND status = ".$this->db->escape($status);
        }
        $query = "SELECT os.*,clientes.nomeCliente FROM os LEFT JOIN clientes ON os.clientes_id = clientes.idClientes WHERE idOs != 0 $whereData $whereCliente $whereResponsavel $whereStatus";
        return $this->db->query($query)->result();
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
    function getByIdaenpfin($id){
        $this->db->from('aenpfin');
        $this->db->select('aenpfin.*');
        $this->db->where('id_fin',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
        
    } 
    /*
					$sql_Saldo_Ant = 'SELECT * FROM aenpfin 					
						WHERE dataFin >= "'.$data_mes_Anterior.'" and dataFin < "'.$data1.'" and 
						conta = "'.$caixa.'"  and "'.$adm.'" is Not Null and saldo_Mes = "S" ORDER BY dataFin ';
*/

    function getSaldo_Ant($conta,$dataInicial){
        /*$dataInicial = date('Y-m-01');
        
        $this->db->from('aenpfin');
        $this->db->select('aenpfin.*');
        $this->db->where('dataFin',$dataInicial);
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
        */
        $query = "SELECT * FROM aenpfin WHERE  conta = '.$conta.' and dataFin > '.$dataInicial.'  and saldo_Mes = 'S'  ORDER BY dataFin limit 1";
        return $this->db->query($query)->row();	
    } 
    /*
                $presentes_pagos = mysqli_query($conex, 'SELECT * FROM presentes_especiais
													WHERE SUBSTRING(n_beneficiario,1,6) LIKE "'.$contN.'"  and valor_pendente < 1  
                                                    and data_presente >= "'.$data_x1.'" and data_presente <= "'.$data_x2.'"
									               ORDER BY  SUBSTRING(n_beneficiario,4,6), month(data_presente), n_protocolo, id_presente ASC'); 

*/
    public function getChekPend($conta,$status){
        
        $this->db->select('reconc_bank.*, aenpfin.dataFin, aenpfin.valorFin, aenpfin.tipo_Conta ');
        $this->db->from('reconc_bank');
        $this->db->join('aenpfin','reconc_bank.id_aenp = aenpfin.id_fin');
        $this->db->order_by('data_Emissao');
       $this->db->where('status',$status);
        return $this->db->get()->result();        
        
		return $this->db->query($query)->result();	
    }
    public function presentes_pagos($conta,$cdiNome,$dataInicial,$dataFinal){
        
        $this->db->select('presentes_especiais.*, aenpfin.dataFin ');
        $this->db->from('presentes_especiais');
       // $this->db->where('SUBSTRING(n_beneficiario,1,6)',$n_Conta);
      //  $this->db->where('n_beneficiario', "'.$cdiNome.'%'");
     //   $this->db->where('data_presente', '> '.$dataInicial);
      //  $this->db->where('data_presente', '< '.$dataFinal);
        $this->db->join('aenpfin','presentes_especiais.id_entrada = aenpfin.id_fin');
        $this->db->order_by('month(data_presente)');
        $this->db->order_by('nome_beneficiario');
        $this->db->order_by('n_protocolo');
        $this->db->order_by('id_presente');
        return $this->db->get()->result();        
        
		return $this->db->query($query)->result();	
    }
	
    function qtdMeses($ts1,$ts2){       
        
            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);
            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);
            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);
            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
		return $diff;	
    }
    public function financeiroAjustarSaldos($conta){
        
            $this->db->select('aenpfin.*');        
            $this->db->from('aenpfin');
            $this->db->where('dataFin >',date("2019-12-31"));
            $this->db->where('conta',$conta);
        //    $this->db->where('tipo_Conta','Corrente');
            $this->db->order_by('tipo_Conta','asc');
            $this->db->order_by('dataFin','asc');
            $this->db->order_by('id_fin','asc');
            return $this->db->get()->result();   
    }
    public function financeiroSaldos($conta,$adminSal){
        $lista_lancI = array();
        $lista_ContasC = "4,5,6,7,8";
        $lista_ContasI = "1,2,9,10";
        $lista_Contas = "";
        $lista_l = "";
            $date1 = "2019-01-01";
            $date2 = date("Y-m-d");
            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);
            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);
            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);
            $qtdM = (($year2 - $year1) * 12) + ($month2 - $month1);
        //    $qtdM = 5;
        
        if($conta != 0) 
            if (preg_match("/{$conta}/", $lista_ContasC))
                $adminSal="cod_compassion"; else $adminSal="cod_assoc"; 
        $admInicio  = ("cod_compassion" == $adminSal) ? 4 : 1; // $r is set to 'Yes'
        $admFim     = (4 == $admInicio) ? 8 : 10; // $r is set to 'Yes'
        $lista_Contas= (4 == $admInicio) ? $lista_ContasC : $lista_ContasI; // $r is set to 'Yes'
        for($j = $admInicio; $j <= $admFim; $j++)  //Contas 
        {   
            if($conta != 0) $j = $conta;
            if (preg_match("/{$j}/", $lista_Contas)) //Se a conta pertence ao grupo selecionado
            for($y = 1; $y <= 4; $y++)  //Tipos de contas 
            {    
                switch ($y) 
                {						 
                    case 1:	$t_C = "Corrente"; break;  
                    case 2:	$t_C = "Suporte"; break;  
                    case 3:	$t_C = "Poupança"; break;  
                    case 4:	$t_C = "Investimento"; break;  		
                }	
                for($i = 0; $i < $qtdM; $i++)   
                {
                    $menos1M = date('m', strtotime("-".$i." month", strtotime( date('Y-m-d'))));
                    $menos1A = date('Y', strtotime("-".$i." month", strtotime( date('Y-m-d'))));
                    $this->db->from('aenpfin');
                    $this->db->select('id_fin');
                    $this->db->where("MONTH(dataFin)",$menos1M);
                    $this->db->where("YEAR(dataFin)",$menos1A);
                    $this->db->where('conta',$j);
                    $this->db->where('tipo_Conta',$t_C);
                    $this->db->order_by('dataFin','asc');
                    $this->db->order_by('id_fin','asc');
                    $this->db->limit(1);
                    $lancIniciais =  $this->db->get()->row();
                    if(!empty($lancIniciais))
                    {
                        $lista_l .= $lancIniciais->id_fin.",";
                    //    array_push($lista_lancI,$lancIniciais->id_fin);
                    }
                }
            }
            
            if($conta != 0) $j = $admFim+1;
        }  $lista_l .= "0";
        $query = "SELECT `aenpfin`.*, `caixas`.* FROM `aenpfin` 
                JOIN `caixas` ON `caixas`.`id_caixa` = `aenpfin`.`conta` 
                WHERE `conta` IN(".$lista_Contas.") 
                    AND (`aenpfin`.`id_fin` IN(".$lista_l.") 
                    OR (`saldo_Mes` = 'S' AND `dataFin` > '".$date1."' )) 
                ORDER BY `conta`, `tipo_Conta`, `dataFin` DESC, `id_fin` DESC";
    /*    $this->db->select('aenpfin.*, caixas.*');
        $this->db->from('aenpfin');
        $this->db->join('caixas','caixas.id_caixa = aenpfin.conta');
        $this->db->where_in('conta',$lista_Contas);        
        $this->db->or_where_in('aenpfin.id_fin',$lista_lancI);                
        $this->db->or_where('saldo_Mes','S');
        $this->db->order_by('conta'); 
        $this->db->order_by('tipo_Conta');        
        $this->db->order_by('dataFinn','desc');
        $this->db->order_by('id_fin','desc');
    */    
        return $this->db->query($query)->result();
    //    return $this->db->get()->result();
    }
    public function financeiroRapid($conta,$dataInicial,$dataFinal){
         $this->db->select('aenpfin.*, caixas.*, cod_assoc.*');
        $this->db->from('aenpfin');
        $this->db->join('caixas','caixas.id_caixa = aenpfin.conta');
        $this->db->join('cod_assoc', 'aenpfin.cod_assoc = cod_assoc.cod_Ass');
        if($conta != 0){
            $this->db->where('conta',$conta);
        }
        if($_SESSION['admini'] != "cod_contab")
        $this->db->order_by('tipo_Conta');
        
        $this->db->order_by('dataFin');
        $this->db->order_by('id_fin');
     //   $this->db->where('dataFin', '> '.$dataInicial);
      //  $this->db->where('dataFin', '< '.$dataFinal);
        return $this->db->get()->result();
        
       
    }
	
    public function financeiroCustom($dataInicial, $dataFinal, $tipo = null, $situacao = null){
        
        $whereTipo = "";
        $whereSituacao = "";

        if($dataInicial == null){
            $dataInicial = date('Y-m-01');
        }
        if($dataFinal == null){
            $dataFinal = date("Y-m-t");  
        }

        if($tipo == 'receita'){
            $whereTipo = "AND tipo = 'receita'";
        }
        if($tipo == 'despesa'){
            $whereTipo = "AND tipo = 'despesa'";
        }
        if($situacao == 'pendente'){
            $whereSituacao = "AND baixado = 0";
        }
        if($situacao == 'pago'){
            $whereSituacao = "AND baixado = 1";
        } 
        
        
        $query = "SELECT * FROM lancamentos WHERE data_vencimento BETWEEN ? and ? $whereTipo $whereSituacao";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }


    public function vendasRapid(){
        $this->db->select('aenpfin.*,cod_assoc.*');
        $this->db->from('aenpfin');
        $this->db->join('cod_assoc', 'cod_assoc.cod_Ass = aenpfin.cod_assoc', 'left');
          
        $this->db->order_by('ent_Sai','desc'); 
        $this->db->order_by('cod_assoc');  
        $this->db->order_by('dataFin');  
        return $this->db->get()->result();
    }



    public function vendasRapidX($dataInicial ,$dataFinal ){
        
        $whereData = "AND dataFin BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        
        $query = "SELECT aenpfin.*,cod_assoc.* FROM aenpfin  LEFT JOIN `cod_assoc` ON `cod_assoc`.`cod_Ass`=`aenpfin`.`cod_assoc` WHERE conta <> 0 $whereData ' ' ORDER BY `ent_Sai` desc,`cod_assoc`,dataFin";
        return $this->db->query($query)->result();
        
    }

    public function vendasSaldoAnterior($dataInicial = null,$dataFinal = null,$cliente = null,$conta = null){
        
        if($dataInicial == null){
            $dataInicial = date('Y-m-d');
        }
        $this->db->select('aenpfin.*');
        $this->db->from('aenpfin');
        $this->db->where('saldo_Mes','S');
        $this->db->where('dataFin < ',$dataInicial);
        
        if($conta != null)
        $this->db->where('conta',$conta);
            
      //  $this->db->group_by('conta, tipo_Conta');
      //  $this->db->select_max('dataFin');
        $this->db->order_by('dataFin', 'desc');  
        return $this->db->get()->result();
        
    }


    public function vendasCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if($dataInicial != null){
            $whereData = "AND dataFin BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND conta = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND cod_assoc = ".$this->db->escape($responsavel);
        }
        if($_SESSION['tipo'] == "")
            $orderBy = "ORDER BY `ent_Sai` desc,`cod_assoc`";else
              {  if($_SESSION['centr'] == "T-Contas")   $centros = "'T00-000','T00'"; else
                 if($_SESSION['centr'] == "T-Suporte")   $centros = "'T01-000','T01'"; else
                                                        $centros = "'T00-000','T00','T01-000','T01'";
            $orderBy = " AND cod_assoc IN (".$centros.") ORDER BY `dataFin`,`cod_assoc`, `num_Doc_Banco`";
              }
       
     //   $query = "SELECT vendas.*,clientes.nomeCliente,usuarios.nome FROM vendas LEFT JOIN clientes ON vendas.clientes_id = clientes.idClientes LEFT JOIN usuarios ON vendas.usuarios_id = usuarios.idUsuarios WHERE idVendas != 0 $whereData $whereCliente $whereResponsavel";
       $query = "SELECT aenpfin.*,cod_assoc.*,caixas.* FROM aenpfin LEFT JOIN `cod_assoc` ON `cod_assoc`.`cod_Ass`=`aenpfin`.`cod_assoc` LEFT JOIN `caixas` ON `caixas`.`id_caixa`=`aenpfin`.`conta` WHERE conta <> 0 $whereData $whereCliente $whereResponsavel ' ' $orderBy";
        return $this->db->query($query)->result();
    }
    public function vendasSimilares($idSimilar,$dat,$valor,$one=false  ){
        
        
       $menos2 = date('Y-m-d', strtotime("-2 day", strtotime( $dat)));
       $mais2 = date('Y-m-d', strtotime("+2 day", strtotime( $dat)));

        $this->db->select('*,caixas.*');
        $this->db->from('aenpfin');
        $this->db->join('caixas', 'caixas.id_caixa = aenpfin.conta', 'left');
        
        $this->db->where('valorFin',$valor);
      //  $this->db->where('dataFin',$dat);
        $this->db->where('dataFin >=',$menos2);
        $this->db->where('dataFin <=',$mais2);
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
        
    }
}