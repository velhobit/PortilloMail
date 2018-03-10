<?php

date_default_timezone_set('America/Sao_Paulo');
include "libs/conexao.php";        //Conexão com o banco de dados.
include "functions.php";

if(isset($_REQUEST["email"]) && isset($_REQUEST["mensagem"])){
	$link = "";
	$email = $_REQUEST["email"];
	$mensagem = $_REQUEST["mensagem"];
	$data_hora =  date("Y-m-d H:i:s");

	$sql = "INSERT INTO views VALUES(DEFAULT,'$email','$mensagem','$data_hora','$link');";
	//echo $sql;
	$rs = mysqli_query($con,$sql);
}


$file = 'assets/contador.jpg';
$type = 'image/jpeg';
header('Content-Type:'.$type);
header('Content-Length: ' . filesize($file));
readfile($file);

?>
