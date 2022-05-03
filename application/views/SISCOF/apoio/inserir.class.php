<?php
 
  class Inserir
  {
		private $sql_ins="";
		private $tabela="";
		private $sql_sel="";
                
		 public function __construct($tabela) 
		 {
			  $this->tabela = $tabela;
			return $this->tabela;	 }
         
            
		public function inserir($campos, $valores) 
		{
            $conex = $_SESSION['conex'];
			$this->sql_ins = "INSERT INTO " . $this->tabela . " ($campos) VALUES ($valores)";
			if(!$this->ins = mysqli_query($conex, $this->sql_ins))
			{
				die ("<center>Erro na inclusão " . '<br>Linha: ' . __LINE__ . "<br>" . mysqli_error() . "<br>
					<a href='menuF.php'>Voltar ao Menu</a></center>");
			}else
			{
				if($this->tabela == "reconc_bank" )// URL=menuF.php'>
				{
				echo "<h5>Cadastro de cheque realizado com sucesso!</h5><br>"; 
					
				}else
                if($this->tabela == "presentes_especiais" )// URL=menuF.php'>
				{
				echo "<h5>Cadastro de presente realizado com sucesso!</h5>"; 
					
				}else
				if( $this->tabela == "aenpfin" )// URL=menuF.php'>
				{
				echo "<h5>Lançamento realizado com sucesso!</h5> "; 
					
				}else
                    if( $this->tabela == "funcionarios" )// URL=menuF.php'>
				{
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=menuF.php'>
						<script type=\"text/javascript\">
						alert(\"Cadastro realizado com sucesso. inserir.class  Linha: " . __LINE__ . "\");
						</script>";	 
					
				}else
                    if( $this->tabela == "funcionarios" )// URL=menuF.php'>
				{
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=PaginaCadastroI.php'>
						<script type=\"text/javascript\">
						alert(\"Cadastro realizado com sucesso. inserir.class  Linha: " . __LINE__ . "\");
						</script>";	 
					
				}else
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=menuF.php'>
						<script type=\"text/javascript\">
						alert(\"Cadastro realizado com sucesso. inserir.class  Linha: " . __LINE__ . "\");
						</script>";		
			}
		}
	}
?>