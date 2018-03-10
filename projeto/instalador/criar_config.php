<?php
ini_set('display_errors', 0); 

$host = $_REQUEST["host"];
$user = $_REQUEST["user"];
$pswd = $_REQUEST["pswd"];
$dbname = $_REQUEST["dbname"];

//Testar conexão
$con 	= null; // Conexão
$con = mysqli_connect($host, $user, $pswd);
if (!$con) {
	echo "<div style='background-color: #FFFF99;border: 2px solid #EFAD40;color: #5C5013;text-align: center;padding: .5em 1em;box-sizing: border-box;border-radius: 10px;margin: 0 auto; margin-top:10px;max-width:800px; width:80%;'>Não foi possível conectar. Por favor, verifique as configuraçoes para conexão ao Banco de Dados.</div>";
	include_once("index.php");
}
else{
	$fp = fopen('../libs/config.php','w');
	fwrite($fp, '<?php

		/*****************************
			PortilloMail
			Projeto Iniciado por Rodrigo Portillo em 2015
			Projeto colocado sob Licença Mozilla
			@author Rodrigo Portillo
			@url http://portillodesign.com.br/projetos/portillo-mail.html
		******************************/

		//Dados globais para configuração do sistema de emails.
		$currentURL = "";
		$pastaURL = "";
		$caminhoURL = "";
		$nomeEmpresa = "";

		//Caso use SMTP, coloque como true, caso contrário, usará a função mail nativa. O SMTP é provido pelo projeto PHPMAiler: https://github.com/PHPMailer/PHPMailer
		$usarSMTP = true;
		$charset = "UTF-8";
		$smtp = "";
		$porta = "";
		$seguranca = "";
		$autenticacao = true;

		$emailResposta = "";
		$nomeEmailResposta = "";

		$emailsHora = 0; //Valor aproximado, pois o resultado final vai ser convertido 
		$emailsHoraNaoComercial = 0;
		$horarioComercial_ini = 0;
		$horarioComercial_fin = 0;

		$host	= "'.$host.'"; // IP do Banco
		$user 	= "'.$user.'"; // Usuário
		$pswd 	= "'.$pswd.'"; // Senha
		$dbname	= "'.$dbname.'"; // Banco
		$con 	= null; // Conexão


		$con = mysqli_connect($host, $user, $pswd);
		if (!$con) {
			die("Não foi possível conectar: " . mysqli_error());
		}
		mysqli_select_db($con, $dbname);
		mysqli_set_charset($con, "utf-8"); //Corrigir UTF8

		//Preencher Configurações Globais
		$SQLConfig = "SELECT * from config;";   //Variável que armazena strings para extrair os dados da tabela.
		$rsConfig = mysqli_query($con,$SQLConfig);        //$rs = returnset. Retorno
		while($rConfig = mysqli_fetch_array($rsConfig)){
			//Dados globais para configuração do sistema de emails.
			$currentURL = $rConfig["url"];
			$pastaURL = "/".$rConfig["pasta"]."/";
			$caminhoURL = $currentURL . $pastaURL;
			$nomeEmpresa = $rConfig["nome_empresa"];

			//Caso use SMTP, coloque como true, caso contrário, usará a função mail nativa. O SMTP é provido pelo projeto PHPMAiler: https://github.com/PHPMailer/PHPMailer
			$smtp = $rConfig["smtp"];
			$porta = $rConfig["porta"];
			$seguranca = $rConfig["seguranca"];
			$autenticacao = $rConfig["autenticacao"];

			$emailResposta = $rConfig["email_resposta"];
			$nomeEmailResposta = $rConfig["nome_email_resposta"];

			$emailsHora = $rConfig["emails_por_hora"]; //Valor aproximado, pois o resultado final vai ser convertido 
			$emailsHoraNaoComercial = $rConfig["emails_por_hora_nao_comercial"];
			$horarioComercial_ini = $rConfig["horario_comercial_ini"];
			$horarioComercial_fin = $rConfig["horario_comercial_fin"];
		}
	?>');
	fclose($fp);

	$templine = '';
	
	$lines = file("modelo_banco.sql");
	
	mysqli_select_db($con, $dbname);
	mysqli_set_charset($con, "utf-8"); //Corrigir UTF8
	foreach ($lines as $line)
	{
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		$templine .= $line;

		if (substr(trim($line), -1, 1) == ';')
		{
			$rs = mysqli_query($con,$templine);
			$templine = '';
		}
	}
	echo('<META http-equiv="refresh" content="1;URL=passo2.php">');
}
?>