<?php
include("conexao.php");

$_SG['paginaLogin'] = 'index.php'; // Página de login
$_SG['tabela'] = 'usuarios';       // Nome da tabela onde os usuários são salvos
$_SG['caseSensitive'] = false;  // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'
$_SG['validaSempre'] = true;	// Deseja validar o usuário e a senha a cada carregamento de página?
$_SG['abreSessao'] = true;      // Inicia a sessão com um session_start()?
// ==============================

// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================


// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
	session_start();
}

/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
	global $_SG,$con;
	
	$cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
	
	// Usa a função addslashes para escapar as aspas
	$nusuario = addslashes($usuario);
	$nsenha = md5(addslashes($senha));
	//die($nsenha);
	
	// Monta uma consulta SQL (query) para procurar um usuário
	$sql = "SELECT id,email FROM ".$_SG['tabela']." WHERE ".$cS." email = '".$nusuario."' AND ".$cS." senha = '".$nsenha."' LIMIT 1";
	$query = mysqli_query($con,$sql);
	$resultado = mysqli_fetch_assoc($query);
	
	// Verifica se encontrou algum registro
	if (empty($resultado)) {
		// Nenhum registro foi encontrado => o usuário é inválido
		return false;

	} else {
		// O registro foi encontrado => o usuário é valido	
		// Definimos dois valores na sessão com os dados do usuário
		$_SESSION['usuarioID'] = $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL

		$_SESSION['usuarioNome'] = $resultado['email']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
		
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
	} else if (isset($_SESSION['usuarioID'])) {
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
?>