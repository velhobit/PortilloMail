<?php
header("Content-Type: text/plain");
include_once("libs/config.php");

if(!$_REQUEST["email"]){
	die("{\"erro\": \"Preencha um email para continuar.\"}");
}

$strSQL = "SELECT email,aut FROM contatos WHERE email='".$_REQUEST['email']."' AND grupo='4' LIMIT 1;";
$strRes = mysqli_query($con,$strSQL);

if(mysqli_num_rows($strRes) == 0){
	$sql = "INSERT INTO contatos VALUES(DEFAULT,'".$_REQUEST['email']."','".$_REQUEST['nome']."','','4','1')";
	mysqli_query($con,$sql);
	$msg = "Seu e-mail ".$_REQUEST['email']." foi inserido com sucesso. A partir de agora você vai receber todas as novidades da K For You em seu e-email.";
}else{
	$sql = "UPDATE contatos SET aut='1' WHERE email = '".$_REQUEST['email']."'";
	mysqli_query($con,$sql);
	$msg = "Contato ".$_REQUEST['email']." atualizado! A partir de agora você voltará a receber todas as novidades da K For You em seu e-mail.";
}

echo "{";
echo "\"mensagem\" : \"". $msg ."\"";
echo "}";
?>