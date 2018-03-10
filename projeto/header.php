<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
	******************************/
	session_start();
	
	include_once("libs/config.php");
	if(isset($_SESSION["usuarioNome"])==null){
		header("location:".$caminhoURL."index.php");
	}
	?>
<!DOCTYPE html>
<html lang="pt_br">
	<head>
	    <meta charset="utf-8"> 
		<link rel="stylesheet" href="<?php echo $caminhoURL; ?>css/estilo.css">
        <link rel="stylesheet" href="http://tinymce.cachefly.net/4.2/skins/lightgray/skin.min.css">
		<script src="<?php echo $caminhoURL; ?>js/advanced.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>	
		<script src="<?php echo $caminhoURL; ?>js/tinymce/tinymce.min.js"></script>
        <script src="<?php echo $caminhoURL; ?>js/jquery.colorbox-min.js"></script>
        
        <title>MailMarketing por PortilloDesign</title>
        <meta name="description" content="Gerenciador de Mailmarketing">
        <link rel="publisher" href="https://plus.google.com/112684470634109423906"/>
        <link rel="author" href="https://www.facebook.com/profile.php?id=100008652127063"/>
        <meta name="robots" content="no-index" />
        <link rel="icon" type="image/png" href="assets/simbolo.png" />
	</head>
	<body>
		<header class="cabecalho">
			<center>
				<a href="http://portillodesign.com.br/projestos/portillo-mail.html" title="Link para o Projeto Portillo Mail" target="_blank"><img src="<?php echo $caminhoURL; ?>assets/simbolo.png"/></a>
				<h1><?php echo $nomeEmpresa; ?></h1>
			</center>
			<div class="menu">
			<nav>
				<ul>
					<li><a href="<?php echo $caminhoURL; ?>email.php">Novo Email</a></li>
					<li><a href="<?php echo $caminhoURL; ?>emails.php">Emails Enviados</a></li>
					<li><a href="<?php echo $caminhoURL; ?>grupos.php">Grupos</a></li>
					<li><a href="<?php echo $caminhoURL; ?>clientes.php">Contatos</a></li>
					<li><a href="<?php echo $caminhoURL; ?>usuarios.php">Usuários</a></li>
					<li><a href="<?php echo $caminhoURL; ?>configuracoes.php">Configurações</a></li>
				</ul>
			</nav>
		</div>
		</header>
		<p class="green"><?php echo $enviados;?></p>
		