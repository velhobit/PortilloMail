<!DOCTYPE html>
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
			<h1>Bem Vindo ao Instalador</h1>
			<h2>Para prosseguir, preencha os dados do Banco.</h2>
			<form action="criar_config.php" method="post">
				<!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
				<input style="display:none" type="text" name="fakeusernameremembered"/>
				<input style="display:none" type="password" name="fakepasswordremembered"/>
				
				<div>
					<p class="mini-info">Na maioria das vezes, o endereço é, simplesmente, <em>localhost</em>. Em caso de dúvida, consulte a hospedagem</p>
					<input type="text" name="host" placeholder="Endereço do Banco" autocomplete="off" required/>
				</div>
				<div>
					<p class="mini-info">Preencha com o nome do Banco de Dados criado para este </p>
					<input type="text" name="dbname" placeholder="Nome do Banco" autocomplete="off" required/>
				</div>
				<div>
					<p class="mini-info">Login do Usuário com acesso ao Banco de Dados</p>
					<input type="text" name="user" placeholder="Usuário do Banco" autocomplete="off" required/>
				</div>
				<div>
					<p class="mini-info">Senha do Usuário com acesso ao Banco de Dados</p>
					<input type="password" name="pswd" placeholder="Senha do Usuário" autocomplete="off" required/>
				</div>
				
				<button type="submit">Próximo Passo</button>
			</form>
			<div class="info">
				Para funcionamento correto do do PortilloMail, recomendamos que use, pelo menos, PHP 5.4 ou superior e é necessário que use um banco MySQL.<br/>
				Caso você tenha dificuldades, consulte sua hospedagem para saber como criar um novo banco de dados, usuário e senha.
			</div>
		</div>
		
		<div class="powered" style="position: fixed;right: 5px;bottom: 5px;text-align: right;color:lightgrey; font-size:16px;">
		<em>Powered By</em><a href="http://portillodesign.com.br" title="PortilloDesign" itemprop="url" target="_blank"><img style="height: 32px;
			margin-bottom:-10px;width: auto;border-radius:5px;margin-left:5px;margin-right:5px" itemprop="logo" class="logo" src="https://velhobit.com.br/images/logo/apple-icon-114x114.png" alt="Logo da PortilloDesign" title="PortilloDesign"></a><span itemprop="name">0.9</span>
		</div>
	</body>
</html>