<?php
ini_set('display_errors', 0); 
include_once("../libs/config.php");

	$nome = "";
	$email = "";
	$senha = "";
	$confSenha = "";
	$senhaEmail = "";

if(isset($_REQUEST["nome"])){
	$nome = trim($_REQUEST["nome"]);
	$email = trim($_REQUEST["email"]);
	$senha = trim($_REQUEST["senha"]);
	$confSenha = trim($_REQUEST["confSenha"]);
	$senhaEmail = trim($_REQUEST["senha_email"]);
	
	if($senha == $confSenha){
		$sql = "TRUNCATE usuarios;";
		$rsSql = mysqli_query($con,$sql);

		$sql = "INSERT INTO usuarios VALUES (DEFAULT,'$nome','$email','','".md5($senha)."','$senhaEmail')";

		$rsSql = mysqli_query($con,$sql);

		if($rsSql){
			echo('<META http-equiv="refresh" content="1;URL=excluir.php">');
		}else{
			echo "<div style='background-color: #FFFF99;border: 2px solid #EFAD40;color: #5C5013;text-align: center;padding: .5em 1em;box-sizing: border-box;border-radius: 10px;margin: 0 auto; margin-top:10px;max-width:800px; width:80%;'>Não foi possível atualizar o Banco de Dados. Por favor, verifique os dados que foram passados.</div>";
		}
	}else{
		echo "<div style='background-color: #FFFF99;border: 2px solid #EFAD40;color: #5C5013;text-align: center;padding: .5em 1em;box-sizing: border-box;border-radius: 10px;margin: 0 auto; margin-top:10px;max-width:800px; width:80%;'>A senha não bateu com a confirmação, por favor digite novamente.</div>";
	}
}
?><!DOCTYPE html>
<html lang="pt_br">
	<head>
	    <meta charset="utf-8"> 
		<link rel="stylesheet" href="../css/estilo.css">
        <title>Instalador PortilloMail</title>
        <meta name="description" content="Gerenciador de Mailmarketing">
        <link rel="publisher" href="https://plus.google.com/112684470634109423906"/>
        <link rel="author" href="https://www.facebook.com/profile.php?id=100008652127063"/>
        <meta name="robots" content="no-index" />
        <link rel="icon" type="image/png" href="../assets/simbolo.png" />
	</head>
	<body>
		<div class="login instalador">
			<center>
				<img src="../assets/logo_maior.png"/>
			</center>
			<h1>Está Quase Pronoto :D</h1>
			<h2>Cadastre o primeiro email!</h2>
			<p>Para finalizar a instalação, você deverá cadastrar o primeiro endereço de email por onde você enviará as mensagens. Você poderá cadastrar outros emails/usuários no sistema.</p>
			<form action="finalizar.php" method="post">
				<!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
				<input style="display:none" type="text" name="fakeusernameremembered"/>
				<input style="display:none" type="password" name="fakepasswordremembered"/>
				<div>
					<p class="mini-info">Nome do Usuário</p>
					<input type="text" name="nome" placeholder="ex: João da Silva" autocomplete="off" value="<?php echo $nome; ?>" required/>
				</div>
				<div>
					<p class="mini-info">Endereço de e-mail. Você deverá usar este email como login, no PortilloMail. Este endereço também poderá ser usado enviar as mensagens. Por segurança, considere usar uma conta de APENAS para esse fim.</p>
					<input type="email" name="email" placeholder="ex: mailing@meudominio.com.br" autocomplete="off"  value="<?php echo $email; ?>" required/>
				</div>
				<div>
					<p class="mini-info">Crie uma senha para acessar o PortilloMail. Esta é a senha que você usará no momento que fizer o login.</p>
					<input type="password" name="senha" placeholder="Senha" autocomplete="off" required/>
					<input type="password" name="confSenha" placeholder="Confirme a Senha" autocomplete="off" required/>
				</div>
				<div>
					<p class="mini-info">Digite a senha que é usada para acessar o email. Esta senha NÃO será criptografada no banco de dados, por isso é recomendado que este email seja usado APENAS para envio de mailmarketing</p>
					<input type="password" name="senha_email" placeholder="Senha para envio das mensagens" autocomplete="off"   value="<?php echo $senhaEmail; ?>"/>
				</div>
				<button type="submit">Próximo Passo</button>
			</form>
			<div class="info">
				Para funcionamento correto do do PortilloMail, recomendamos que use, pelo menos, PHP 5.4 ou superior e é necessário que use um banco MySQL.<br/>
				Caso você tenha dificuldades, consulte sua hospedagem para saber como criar um novo banco de dados, usuário e senha.
			</div>
		</div>
		
		<div class="powered" style="position: fixed;right: 5px;bottom: 5px;text-align: right;color:lightgrey; font-size:16px;">
		<em>Powered By</em><a href="hhttps://velhobit.com.br" title="PortilloDesign" itemprop="url" target="_blank"><img style="height: 32px;
			margin-bottom:-10px;width: auto;border-radius:5px;margin-left:5px;margin-right:5px" itemprop="logo" class="logo" src="http://portillodesign.com.br/images/logo/apple-icon-114x114.png" alt="Logo da PortilloDesign" title="PortilloDesign"></a><span itemprop="name">0.9</span>
		</div>
	</body>
</html>