<?php
	
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
	******************************/
	
	//Dados globais para configuração do sistema de emails.
	$currentURL = "";
	$pastaURL = "";
	$caminhoURL = "";
	$nomeEmpresa = "";
	
	//Caso use SMTP, coloque como true, caso contrário, usará a função mail nativa. O SMTP é provido pelo projeto PHPMAiler: https://github.com/PHPMailer/PHPMailer
	$usarSMTP = true;
	$charset = 'UTF-8';
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
	
	$host	= "localhost"; // IP do Banco
	$user 	= "porti750_mail"; // Usuário
	$pswd 	= "Coelho2026"; // Senha
	$dbname	= "porti750_mail"; // Banco
	$con 	= null; // Conexão

	
	$con = mysqli_connect($host, $user, $pswd);
	if (!$con) {
		die('Não foi possível conectar: ' . mysqli_error());
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
?>