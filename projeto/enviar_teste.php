<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url https://velhobit.com.br
	******************************/

	include "libs/conexao.php";        //Conexão com o banco de dados.
	include "functions.php";
	ini_set('error_reporting', E_ALL);     //Reporta todos os erros.

	$id = $_REQUEST["id"];
?>
	<!--<form action="#">
		<input type="id" name="id" placeholder="id" value="<?php echo $id; ?>"/>
		<input type="email" name="email" placeholder="Email de Teste"/>
		<button type="submit">Enviar Teste</button>
	</form>-->
<?php if(isset($_REQUEST['email'])): ?>
<?php
	$sql = "SELECT men.id as id,men.assunto as assunto,men.mensagem as mensagem,men.url as url,(SELECT email FROM usuarios WHERE id=men.email_envio) as email_envio,(SELECT nome FROM usuarios WHERE id=men.email_envio) as nome_envio,(SELECT nome FROM usuarios WHERE id=men.email_envio) as nome,(SELECT senha_email FROM usuarios WHERE id=men.email_envio) as senha_email, grupos, emails_adicionais FROM mensagens men WHERE id='$id'";
	$rs = mysqli_query($con,$sql);
	print_r(mysqli_error($con));
	while($row = mysqli_fetch_array($rs)){
		$id = $row["id"];
		$assunto = $row["assunto"];
		$envio = $row["email_envio"];
		$nome_envio = $row["nome_envio"];
		$nome = $row["nome"];
		$mensagem = $row["mensagem"];
		$url = $row["url"];
		$senha_email = $row["senha_email"];
	}
	//echo $sql;
	$destinatario = $_REQUEST['email'];
	$url = $caminhoURL."/emails/".$url.".html";
	//Montar Mensagem
	$urlCancelamento = $caminhoURL."/cancelamento.php?email=".$destinatario;
    //Montar Mensagem
	$emailCompleto = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>$assunto</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		</head>
		<body>';
	$emailCompleto .= $mensagem;
	$emailCompleto .= "<img src=\"".$caminhoURL."/contador.php?email=".$destinatario."&mensagem=".$id."\" height=\"90\" style=\"height: 90px; width: auto; text-align: center; border: none;\" alt=\"contador\" />";
	$emailCompleto .= "<center style='font-size:.8em;'>Caso você não consiga visualizar este email corretamente, <a href='$url' target='_blank'>clique aqui para acessar</a>.</center>";
	$emailCompleto .= "<center style='font-size:.8em;'><a href='$urlCancelamento' target='_blank'>Cancelar Inscrição</a></center>";
	$emailCompleto .= '</body></html>';

	$urlAtivaSimples = "href='".$caminhoURL."link.php?email=".$destinatario."&mensagem=$id&link=";
	$urlAtivaDupla = 'href="'.$caminhoURL."link.php?email=".$destinatario."&mensagem=$id&link=";
	$emailCompleto = str_replace("href='http://",$urlAtivaSimples, $emailCompleto);
	$emailCompleto = str_replace('href="http://',$urlAtivaDupla, $emailCompleto);

	// Cabeçalhos
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";        //Envia o email com codificação UTF-8.
	$headers .= 'From: '.$nome.' <'.$envio.'> '."\r\n".
	'Reply-To: '.$envio."\r\n" .
	'X-Mailer: PHP/' . phpversion();

	$errors = "";       //Variável onde os erros são armazenados.
	$retorno = false;
	if($usarSMTP){
		include_once("libs/phpmail/PHPMailerAutoload.php");
		$mail = new PHPMailer(true);
		
		try {

			//$mail->IsSMTP(); // telling the class to use SMTP
			$mail->CharSet = $charset;
			$mail->Host = $smtp; // SMTP server
			$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
			if($emailResposta != null && $emailResposta != ""){
				$mail->AddReplyTo($emailResposta, $nomeEmailResposta);
			}
			// 1 = errors and messages
			// 2 = messages only
			$mail->SMTPAuth = $autenticacao; // enable SMTP authentication
			$mail->SMTPSecure = $seguranca;
			$mail->Port = $porta; // set the SMTP port for the service server
			$mail->Username = $envio; // account username
			$mail->Password = $senha_email; // account password

			$mail->SetFrom($envio, $nome_envio);
			$mail->Subject = $assunto;
			$mail->MsgHTML($emailCompleto);
			$mail->AddAddress($destinatario, "");

			//echo $envio.$senha_email;
			/*echo "<textarea>";
			print_r($mail);
			echo "</textarea>";
			*/
			$retorno = $mail->Send();
			
		} catch (phpmailerException $e) {
		  echo $e->errorMessage(); //error messages from PHPMailer
		} catch (Exception $e) {
		  echo $e->getMessage();
		}
	
	}else{
		$retorno = @mail($destinatario, $assunto, $emailCompleto, $headers);
	}

	if(!$retorno || !isset($_REQUEST['email']) || $_REQUEST['email'] == ""){
		echo "<h1 class=\"mensagem_ruim\">Erro ao enviar Email. Verifique as configurações de e-mail estão corretas.</h1>";
	}else{
		echo "<h1 class=\"mensagem\">Email de Teste Enviado com Sucesso</h1>";
	}
?>
<style>

h1.mensagem{
	padding:1em;
	display:block;
	color: #0F3776;
	margin: 0;
	text-align: center;
	font-weight: normal;
}

h1.mensagem_ruim{
	padding:1em;
	display:block;
	color: #740B0C;
	margin: 0;
	text-align: center;
	font-weight: normal;
}
</style>
<?php endif;?>
