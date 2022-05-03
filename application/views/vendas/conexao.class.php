<?php
//require_once 'CidadesDoBrasil.sql';

class Conexao
{
/*********************************
Atributos da Classe (CONEXAO)
**********************************/
   
    private $db_host = 'mysql.hostinger.com.br'; // servidor
    private $db_user = 'u344891621_tito'; // usuario do banco
    private $db_pass = 'rebeca1980'; // senha do usuario do banco
    private $db_name = 'u344891621_doar'; // nome do banco
    private $con = false;
    /*
    private $db_host = 'localhost'; // servidor
    private $db_user = 'root'; // usuario do banco
    private $db_pass = ''; // senha do usuario do banco
    private $db_name = 'u470817199_doar'; // nome do banco
    private $con = false;
    */
    
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
public function criarBD() // Cria banco e Tabela se não existir
{		/*
		$db_user = 'u470817199_tito'; 
		$db_pass   = 'rebeca2017'; 
		$db_host    = 'mysql.hostinger.com.br'; 
		$con = null; // Nossa conexão PDO 
		*/
        $db_host = 'localhost'; // servidor
        $db_user = 'root'; // usuario do banco
        $db_pass = ''; // senha do usuario do banco
        $con = null;

		//Concatenação das variáveis para detalhes da classe PDO 
		$doar = "mysql:host = $db_host;"; 
    
		// Tenta conectar
		try 
		{	// Cria a conexão 
			$con = new PDO($doar, $db_user, $db_pass);
		}  		
		catch (PDOException $e) 
		{	
			print "Erro: " . $e->getMessage() . "<br/>";   	
			die();
		}  
			$bd = "u470817199_doar";
			// Cria o banco de dados e da permissão para nosso usuário no mesmo
			$verifica = $con->exec
	(	// Cria o banco de dados e Tabelas após verificar se já existem 	  
			" CREATE DATABASE IF NOT EXISTS `$bd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
			GRANT ALL ON `$bd`.* TO '$db_user'@'localhost';
			FLUSH PRIVILEGES;
						
			CREATE TABLE IF NOT EXISTS `$bd`.`congregacao` 
			(
				codC int(10) NOT NULL AUTO_INCREMENT,
				nome varchar(60) UNIQUE NOT NULL,
				area varchar(15) NOT NULL,
				cidade varchar(15) DEFAULT NULL,
				bairro varchar(25) DEFAULT NULL,
				logradouro varchar(50) DEFAULT NULL,
				numero varchar(10) DEFAULT NULL,				
				PontoRef varchar(120) DEFAULT NULL,
				campo char(1) NOT NULL,		
				atendente varchar(15) NOT NULL,
				PRIMARY KEY ( codC )
			)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			
			CREATE TABLE IF NOT EXISTS `$bd`.`funcionarios` 
			(
				codF int(10) NOT NULL AUTO_INCREMENT,
				nomeF varchar(60) UNIQUE NOT NULL,
				usuario varchar(50) NOT NULL,
				senha varchar(50) NOT NULL,
				fone varchar(15) NOT NULL,
				cidade varchar(25) DEFAULT NULL,
				bairro varchar(25) DEFAULT NULL,
				logradouro varchar(50) DEFAULT NULL,
				numero varchar(10) DEFAULT NULL,
				sexo char(1) NOT NULL,
				funcao varchar(20) not NULL,  
				PRIMARY KEY ( codF )
			)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			
			CREATE TABLE IF NOT EXISTS `$bd`.`pedidos` 
			(
				codP int (10) NOT NULL AUTO_INCREMENT,
				codC int(10) NOT NULL,
				codF varchar(20) NOT NULL,
				cupom1 int(5) DEFAULT NULL,
				cupom2 int(5) DEFAULT NULL,
				cupom3 int(5) DEFAULT NULL,
				cupom4 int(5) DEFAULT NULL,
				valtotal float(5) DEFAULT NULL,				   
				dataPed varchar(15) NOT NULL,												
				PRIMARY KEY ( codP ),
				FOREIGN KEY ( codC ) REFERENCES `congregacao` ( codC )
			)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			
			CREATE TABLE IF NOT EXISTS `$bd`.`pais` (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  nome varchar(60) DEFAULT NULL,
			  sigla varchar(10) DEFAULT NULL,
			  PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


			CREATE TABLE IF NOT EXISTS `$bd`.`estado` (
				idE int (10) NOT NULL AUTO_INCREMENT,			   
				nome varchar(15) NOT NULL,												
				uf varchar(15) NOT NULL,												
				pais int(11) NOT NULL,												
				PRIMARY KEY ( idE ),
				FOREIGN KEY ( pais ) REFERENCES `pais` ( id )
			)ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;
			
			CREATE TABLE IF NOT EXISTS `$bd`.`cidade` (
			  idC int(11) NOT NULL AUTO_INCREMENT,
			  nome varchar(120) DEFAULT NULL,
			  estado int(10) NOT NULL,
			  PRIMARY KEY (idC),
			  FOREIGN KEY ( estado ) REFERENCES `estado` ( idE )
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5565 ;
			
			
			INSERT INTO `$bd`.`pais` (`id`, `nome`, `sigla`) VALUES (1, 'Brasil', 'BR');
			
			INSERT INTO `$bd`.`estado` (`idE`, `nome`, `uf`, `pais`) VALUES
				
				(16, 'Pernambuco', 'PE', 1);
				
			
				
			
			
			"
			
	 );
	
	// Verificamos se a base de dados foi criada com sucesso
	if ( $verifica ) 
	{
		echo 'ok!';
	} else 
	{
		echo 'Falha na execução do comando de BANCO DE DADOS!';
	}
	$conexao = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db("doar",$conexao);
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