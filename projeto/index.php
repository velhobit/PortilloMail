<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
	******************************/
	session_start();
	include("libs/seguranca.php");
	//include "functions.php";
	$nome = $_REQUEST["nome"];
	$senha = $_REQUEST["senha"];
	//Verificar Usuário
	//$senha = md5($senha);
	$validado = validaUsuario($nome, $senha);
	//echo $validado;
	
	if(!$validado):
		$msg = 'Nome de Usuário o Senha Inválido';
	else:
		header("location:email.php");
	endif;
	/*include "libs/conexao.php";        //Conexão com o banco de dados.
	$sqlLogin = "SELECT * FROM usuarios WHERE email='$nome' AND senha='$senha' LIMIT 1;";
	$rs = mysqli_query($con,$sqlLogin); 
	print_r($rs->num_rows);
	if($rs->num_rows < 1):
		$msg = 'Nome de Usuário o Senha Inválido';
	else:
		$_SESSION["usuario"] = $nome;
		echo $_SESSION["usuario"];
		header("location:email.php");
	endif;*/
	
 ?>
<!DOCTYPE>
<html lang="pt_br">
	<header>
		<meta charset="utf-8"/>
		<title>Enviar Email em Lote</title>
		<link rel="stylesheet" href="css/estilo.css">
	</header>
	<body>
		<div class="login">
			<h1>Entre Para Enviar Emails</h1>
			<form action="#" method="post">
				<input type="text" name="nome" placeholder="Nome de Usuário / email"/>
				<input type="password" name="senha" placeholder="Senha"/>
				<button type="submit">Entrar</button>
			</form>
			<?php echo $msg; ?>
		</div>
	</body>
</html>