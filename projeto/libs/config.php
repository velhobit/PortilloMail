<?php
	
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
	******************************/
	
	//Dados globais para configuração do sistema de emails.
	$caminhoURL = "http://meusite.com.br/mailmarketing/"; //Caminho Completo, URL DO SITE + Pasta de instalação
	$nomeEmpresa = "MeuSite"; // Título do site -> Empresa
	
	//Caso use SMTP, coloque como true e os dados. Caso contrário, usará a função mail nativa. O SMTP é provido pelo projeto PHPMAiler: https://github.com/PHPMailer/PHPMailer
	$usarSMTP = true;
	$charset = 'UTF-8';
	$smtp = "smtp.gmail.com";
	$porta = "465";
	$seguranca = "ssl";
	$autenticacao = true;
	
	$emailResposta = "resposta@meusite.comb.br"; 
	$nomeEmailResposta = "Nome do Responsável";
	
	$emailsHora = 120; //Valor aproximado, pois o resultado final vai ser convertido 
	$emailsHoraNaoComercial = 200; // Ainda não funciona
	$horarioComercial[] = 8; // Ainda não funciona
	$horarioComercial[] = 18; // Ainda não funciona
	
	//Dados do Banco
	$host	= "localhost"; // IP do Banco
	$user 	= "usuario"; // Usuário
	$pswd 	= "senha"; // Senha
	$dbname	= "banco"; // Banco
	$con 	= null; // Conexão
?>