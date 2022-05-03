<?php
//require_once 'CidadesDoBrasil.sql';

class Conexao
{
/*********************************
Atributos da Classe (CONEXAO)
**********************************/
    /*
    private $db_host = 'mysql.hostinger.com.br'; // servidor
    private $db_user = 'u470817199_tito'; // usuario do banco
    private $db_pass = 'rebeca2017'; // senha do usuario do banco
    private $db_name = 'u470817199_doar'; // nome do banco
    private $con = false;
    */
    private $db_host = 'localhost'; // servidor
    private $db_user = 'root'; // usuario do banco
    private $db_pass = ''; // senha do usuario do banco
    private $db_name = 'u470817199_doar'; // nome do banco
    private $con = false;
    
    
/*********************************
Funcoes da Classe (CONEXAO)
**********************************/ 
    public function connect() // Cria uma conexao
    {
    /*      //Criar a conexao
    $conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
        //echo "Conexao realizada com sucesso";
    } 
        
       */
        if(!$this->con)
        {
            $myconn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            if($myconn)
            {
                $_SESSION['conex'] = $myconn;
                    $this->con = true;
                    return true;
            }
           else
            {
                return false;
            }
        }            
        else
        {
            return true;
        }
        
        
    }
    public function disconnect() // fecha conexao
    {
		if($this->con)
		{
			if(@mysqli_close())
			{
				$this->con = false;
				return true;
			}
			else
			{
				return false;
			}
		}
    }
     
}

?>