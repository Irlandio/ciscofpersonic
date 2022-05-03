<?php
/**
* Sistema de segurança com acesso restrito
*
* Usado para restringir o acesso de certas páginas do seu site

/*Niveis de Permissão
0 - Sem logim 
1 - Consulta de movimentação financeira
2 - Consulta simples  e Lançamento de movimentação financeira;
3 - Consulta simples, Lançamento e Edição de movimentação financeira;
4 - Consulta simples, Lançamento, Edição e Exclusão de movimentação financeira;
5 -Consulta avançada, Lançamento, Edição e Exclusão de movimentação financeira, Cadastro de Cooperadores e Códigos Financeiros

Contas 
Uma - 1 a 10
todas - 99

Tipos de contas
1 - Suporte
2 - Corrnte
3 - Suporte e Corrnte
4 - Suporte, Corrnte, Poupança e Investimentos
* @version 1.0
* @package SistemaSeguranca 
*/
//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = false;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'
$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
/*
$_SG['servidor'] = 'mysql.hostinger.com.br';    // Servidor MySQL
$_SG['usuario'] = 'u470817199_tito';          // Usuário MySQL
$_SG['senha'] = 'rebeca2017';                // Senha MySQL
$_SG['banco'] = 'u470817199_doar';            // Banco de dados MySQL
*/
$_SG['servidor'] = 'localhost';    // Servidor MySQL
$_SG['usuario'] = 'root';          // Usuário MySQL
$_SG['senha'] = '';                // Senha MySQL
$_SG['banco'] = 'u470817199_doar';            // Banco de dados MySQL

$_SG['paginaLogin'] = 'login.php'; // Página de login
$_SG['tabela'] = 'funcionarios';       // Nome da tabela onde os usuários são salvos
// ==============================
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
  $_SG['link'] = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die("MySQLI: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
 // mysqli_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
}
// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true)
  session_start();
/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
  global $_SG;
  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
  // Usa a função addslashes para escapar as aspas
  $nusuario = addslashes($usuario);
  $nsenha = addslashes($senha);        
  /*        //Criar a conexao
    $conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
       // echo "Conexao realizada com sucesso";
    } 
    //O campo usuário e senha preenchido entra no if para validar
    if((isset($nusuario)) && (isset($nsenha))){
          
        //Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário
        $result_usuario = "SELECT `codF`, `nomeF`, `conta_acesso`,`tipo_conta_acesso`, `nivel_acesso` FROM `".$_SG['tabela']."` 
			WHERE ".$cS." `usuario` = '".$nusuario."' AND ".$cS." `senha` = '".$nsenha."' LIMIT 1";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        $resultado = mysqli_fetch_assoc($resultado_usuario);
        
        //Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
        if(isset($resultado)){
            $_SESSION['usuarioID'] = $resultado['codF']; // Pega o valor da coluna 'id do registro encontrado no MySQL
            $_SESSION['usuarioNome'] = $resultado['nomeF']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
            $_SESSION['conta_acesso'] = $resultado['conta_acesso']; // Pega o valor da coluna 'conta_acesso do registro encontrado no MySQL
            $_SESSION['tipo_conta_acesso'] = $resultado['tipo_conta_acesso']; // Pega o valor da coluna 'tipo_conta_acesso do registro encontrado no MySQL
            $_SESSION['nivel_acesso'] = $resultado['nivel_acesso']; // Pega o valor da coluna 'nivel_acesso' do registro encontrado no MySQL
           header("Location: menuF.php");return true;
        //Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
        //redireciona o usuario para a página de login
        }else{    
            //Váriavel global recebendo a mensagem de erro
            $_SESSION['loginErro'] = "'Usuário ou senha Inválido '".mysqli_connect_error() ;
         //   header("Location: paginaLogin.php");return false;
              
           header("Location: paginaLogin.php");return false;
        }
    //O campo usuário e senha não preenchido entra no else e redireciona o usuário para a página de login
    }else{
        $_SESSION['loginErro'] = "Usuário ou senha inválido";
        header("Location: paginaLogin.php");return false;         
    }
    */
    
  // Monta uma consulta SQL (query) para procurar um usuário
  require_once 'conexao.class.php';		
	$con = new Conexao();
	$con->connect(); $conex = $_SESSION['conex'];
  $sql = "SELECT `codF`, `nomeF`, `conta_acesso`,`tipo_conta_acesso`, `nivel_acesso` FROM `".$_SG['tabela']."` 
			WHERE ".$cS." `usuario` = '".$nusuario."' AND ".$cS." `senha` = '".$nsenha."' LIMIT 1";
  $query = mysqli_query($conex,$sql);
  $resultado = mysqli_fetch_assoc($query);
  // Verifica se encontrou algum registro
   $con-> disconnect();
  if (empty($resultado)) {
    // Nenhum registro foi encontrado => o usuário é inválido
    return false;
  } else {
    // Definimos dois valores na sessão com os dados do usuário
    $_SESSION['usuarioID'] = $resultado['codF']; // Pega o valor da coluna 'id do registro encontrado no MySQL
    $_SESSION['usuarioNome'] = $resultado['nomeF']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
    $_SESSION['conta_acesso'] = $resultado['conta_acesso']; // Pega o valor da coluna 'conta_acesso do registro encontrado no MySQL
    $_SESSION['tipo_conta_acesso'] = $resultado['tipo_conta_acesso']; // Pega o valor da coluna 'tipo_conta_acesso do registro encontrado no MySQL
    $_SESSION['nivel_acesso'] = $resultado['nivel_acesso']; // Pega o valor da coluna 'nivel_acesso' do registro encontrado no MySQL
    // Verifica a opção se sempre validar o login
    if ($_SG['validaSempre'] == true) {
      // Definimos dois valores na sessão com os dados do login
      $_SESSION['usuarioLogin'] = $usuario;
      $_SESSION['usuarioSenha'] = $senha;
    }
    return true;
  }
    
    
}
/**
* Função que protege uma página
*/
function protegePagina() {
  global $_SG;
  if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
    // Não há usuário logado, manda pra página de login
   expulsaVisitante();
  } else if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
    }
  }
}
/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
  global $_SG;
  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
  // Manda pra tela de login
  header("Location: ".$_SG['paginaLogin']);
}