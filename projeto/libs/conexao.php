<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
	******************************/
	
include_once("config.php");

$con = mysqli_connect($host, $user, $pswd);
if (!$con) {
    die('Não foi possível conectar: ' . mysqli_error());
}
mysqli_select_db($con, $dbname);
mysqli_set_charset($con, "utf-8"); //Corrigir UTF8
?>