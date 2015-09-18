<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
	******************************/
	session_start();
	if(isset($_SESSION["usuarioNome"])==null){
		header("location:index.php");
	}
	include("libs/config.php");
	?>
<!DOCTYPE html>
<html lang="pt_br">
	<head>
	    <meta charset="utf-8"> 
		<link rel="stylesheet" href="css/estilo.css">
        <link rel="stylesheet" href="http://tinymce.cachefly.net/4.2/skins/lightgray/skin.min.css">
		<script src="js/advanced.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>	
		<script src="js/tinymce/tinymce.min.js"></script>
        <script src="js/jquery.colorbox-min.js"></script>
        
        <title>MailMarketing por PortilloDesign</title>
        <meta name="description" content="Gerenciador de Mailmarketing">
        <link rel="publisher" href="https://plus.google.com/112684470634109423906"/>
        <link rel="author" href="https://www.facebook.com/profile.php?id=100008652127063"/>
        <meta name="robots" content="no-index" />
        <link rel="icon" type="image/png" href="/favicon.png" />
	</head>
	<body>
		<header class="cabecalho">
			<center>
				<img src="images/logo.png"/>
				<h1><?php echo $nomeEmpresa; ?></h1>
			</center>
			<div class="menu">
			<nav>
				<ul>
					<li><a href="email.php">Novo Email</a></li>
					<li><a href="emails.php">Emails Enviados</a></li>
					<li><a href="grupos.php">Grupos</a></li>
					<li><a href="clientes.php">Contatos</a></li>
					<li><a href="usuarios.php">Usuários</a></li>
				</ul>
			</nav>
		</div>
		</header>
		<p class="green"><?php echo $enviados;?></p>
		