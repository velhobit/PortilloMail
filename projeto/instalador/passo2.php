<?php
ini_set('display_errors', 0); 
include_once("../libs/config.php");
if(isset($_REQUEST["url"])){
	$cUrl = trim($_REQUEST["url"]);
	$cPasta = trim($_REQUEST["pasta"]);
	$cNomeEmpresa = trim($_REQUEST["nome_empresa"]);
	$cSmtp = trim($_REQUEST["smtp"]);
	$cPorta = trim($_REQUEST["porta"]);
	$cSeguranca = trim($_REQUEST["seguranca"]);
	$cAutenticacao = trim($_REQUEST["autenticacao"]);
	$cEmailResposta = trim($_REQUEST["email_resposta"]);
	$cNomeEmailResposta = trim($_REQUEST["nome_email_resposta"]);
	$cEmailsPorHora = trim($_REQUEST["emails_por_hora"]);
	$cEmailsPorHoraNaoComercial = trim($_REQUEST["emails_por_hora_nao_comercial"]);
	$cHorarioComercialIni = trim($_REQUEST["horario_comercial_ini"]);
	$cHorarioComercialFin = trim($_REQUEST["horario_comercial_fin"]);
	
	$sql = "TRUNCATE config;";
	$rsSql = mysqli_query($con,$sql);
	
	$sql = "INSERT INTO config VALUES ('$cUrl','$cPasta','$cNomeEmpresa','$cSmtp','$cPorta','$cSeguranca','$cAutenticacao','$cEmailResposta','$cNomeEmailResposta','$cEmailsPorHora','$cEmailsPorHoraNaoComercial','$cHorarioComercialIni','$cHorarioComercialFin')";
	
	//echo $sql;
	
	$rsSql = mysqli_query($con,$sql);
	
	if($rsSql){
		echo('<META http-equiv="refresh" content="1;URL=finalizar.php">');
	}else{
		echo "<div style='background-color: #FFFF99;border: 2px solid #EFAD40;color: #5C5013;text-align: center;padding: .5em 1em;box-sizing: border-box;border-radius: 10px;margin: 0 auto; margin-top:10px;max-width:800px; width:80%;'>Não foi possível atualizar o Banco de Dados. Por favor, verifique os dados que foram passados. Também certifique-se que o usuário que você digitou tem permissões para modificar este banco de dados.</div>";
	}
}
?>
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
			<h1>Banco Criado com Sucesso!</h1>
			<h2>Agora, por favor, preencha as informações básicas para a operação do PortilloMail.</h2>
			<form action="passo2.php" method="post">
				<div>
					<p class="mini-info">Preencha com a URL correta do site. Esse caminho é importante para definir onde os links, contadores e imagens irão referenciar.</p>
					<input type="text" name="url" placeholder="http://meusite.com.br" value="http://<?php echo $_SERVER['HTTP_HOST']; ?>" autocomplete="off" required/>
				</div>
				<div>
					<p class="mini-info">Preencha com o nome da pasta onde você enviou os arquivos do PortilloMail</p>
					<?php
						$uri = $_SERVER['REQUEST_URI'];
						$uri = str_replace("/instalador/passo2.php","",$uri);
						$uri = ltrim($uri, '/');
					?>
					<input type="text" name="pasta" placeholder="mailing" autocomplete="off" value="<?php echo $uri; ?>" required/>
				</div>
				<div>
					<p class="mini-info">Digite o nome da Empresa ou Instituição que usará o PortilloMail</p>
					<input type="text" name="nome_empresa" placeholder="PortilloDesign" autocomplete="off" required/>
				</div>
				<h4>Dados de Emails</h4>
				<p>Todos os emails que serão cadastrados usarão os mesmos dados de acesso. Essa decisão visa diminuir a incidência de uso do sistema para spammers. Consulte sua hospedagem ou servidor de emails para verificar esses dados. Você pode deixar para prrencher esses itens depois, mas é altamente recomendável que faça isso agora.</p>
				<div>
					<p class="mini-info">Digite o endereço do SMTP dos emails que serão usados para envio.</p>
					<input type="text" name="smtp" placeholder="smtp.servidor.com" autocomplete="off"/>
				</div>
				<div>
					<p class="mini-info">Digite a porta do SMTP dos emails</p>
					<input type="text" name="porta" placeholder="465" autocomplete="off"/>
				</div>
				<div>
					<p class="mini-info">Escolha o tipo de segurança. É altamente recomendado usar um tipo de segurança.</p>
					<select name="seguranca" id="seguranca" placeholder="Tipo de Segurança">
						<option value="ssl" default>SSL</option>
						<option value="tls">TLS</option>
						<option value="">Nenhuma</option>
					</select>
				</div>
				<div>
					<p class="mini-info">Servidor requer autenticação?</p>
					<select name="autenticacao" id="autenticacao" placeholder="Tipo de Autenticação">
						<option value="1" default>Requer Autenticação</option>
						<option value="0">Não Requer Autenticação</option>
					</select>
				</div>
				<div>
					<p class="mini-info">Quando as pessoas responderem seus emails, elas responderão para qual email?</p>
					<input type="email" name="email_resposta" placeholder="emailresposta@meudominio.com" autocomplete="off"/>
				</div>
				<div>
					<p class="mini-info">Nome que irá aparecer para as pessoas no email resposta.</p>
					<input type="text" name="nome_email_resposta" placeholder="Contato da Empresa" autocomplete="off"/>
				</div>
				<div>
					<p class="mini-info">Quantidade de emails que serão enviados por hora. Verifique com seu servidor de emails quantos emails você pode enviar por hora. A maioria varia entre 300 e 500 emails. Recomenda-se utilizar de metade a dois terços dos emails permitidos por hora para evitar que seu servidor fique inoperante temporariamente.</p>
					<input type="number" name="emails_por_hora" placeholder="Apenas Números" autocomplete="off" value="200" min="0" />
				</div>
				<div>
					<p class="mini-info">Quantidade de emails que serão enviados por hora FORA DO HORÁRIO COMERCIAL. <b>Mantenha vazio caso não queira utilizar</b> Para agilizar o envio dos emails, mantenha o número de emails permitidos por hora maior em relação a este. Este email visa uma segurança para que pessoas que usam o mesmo servidor de emails para o trabalho, possam utilizar sem correr riscos de cair. Recomenda-se usar um terço da quantidade total permitida.</p>
					<input type="number" name="emails_por_hora_nao_comercial" placeholder="Apenas Números" autocomplete="off" value="300" min="0" />
				</div>
				<div>
					<p class="mini-info">Digite a hora que se inicia o horário comercial na sua empresa ou instituição. Considere APENAS a hora, em formato de 0 a 23 horas.</p>
					<input type="number" name="horario_comercial_ini" placeholder="Apenas Números" autocomplete="off" value="8" min="0" max="23"/>
				</div>
				<div>
					<p class="mini-info">Digite a hora que é finalizado o horário comercial na sua empresa ou instituição. Considere APENAS a hora, em formato de 0 a 23 horas.</p>
					<input type="number" name="horario_comercial_fin" placeholder="Apenas Números" autocomplete="off" value="18" min="0" max="23"/>
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
			margin-bottom:-10px;width: auto;border-radius:5px;margin-left:5px;margin-right:5px" itemprop="logo" class="logo" src="http://portillodesign.com.br/images/logo/apple-icon-114x114.png" alt="Logo da PortilloDesign" title="PortilloDesign"></a><span itemprop="name">0.9</span>
		</div>
	</body>
</html>