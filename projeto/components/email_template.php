<?php
$view = false;
if(isset($_REQUEST["nome_contato"]) && isset($_REQUEST["dias_doacao"]) && isset($_REQUEST["email_contato"]) && isset($_REQUEST["id_mensagem"]) ){
	$view = true;
	$nome_contato = $_REQUEST["nome_contato"];
	$dias_doacao = $_REQUEST["dias_doacao"];
	$email_contato = $_REQUEST["email_contato"];
	$id_mensagem = $_REQUEST["id_mensagem"];
	
	echo '<!DOCTYPE html><html lang="pt-BR">
	<head>
<meta charset="utf-8"><title>IHENE - Instituto de Hematologia do Nordeste</title><meta name="author" content="Rodrigo Portillo"><meta name="keywords" content="doação, sangue, hemonucleo, hemocentro, plaquetas, doação de sangue, aférese, hemácias, hematologia"><meta name="description" content="Hemonúcleo em Pernambuco - Doação de Sangue, Aférese e Umbilical" />
		<link rel="shortcut icon" href="http://ihene.com.br/icon/favicon.png" /></head><body>';
}

$mensagem = '<div style="padding: 2em; box-shadow: 0 0 1em lightgrey; width: 100%; max-width: 670px; text-align: center; min-height: 500px; margin: 0 auto; font-family: Roboto,Helvetica,Arial, sans-serif;">
<h1 style="margin: 0; margin-bottom: 1em; background-color: red; padding: .5em; color: white; text-align: center; vertical-align: bottom;">Ol&aacute;,'.$nome_contato.'.&nbsp;</h1>
<br /> <img src="http://ihene.com.br/mailing/imagens/coracao.png" style="width: 100%; height: auto;" /> <br />
<h2 style="font-size: 1.5em; font-weight: normal; text-align: center; color: darkgreen;">J&aacute; faz mais de <br /><span style="font-weight: bold; font-size: 2em;">'.$dias_doacao.' dias</span><br />desde sua &uacute;ltima doa&ccedil;&atilde;o. Isso quer dizer que voc&ecirc; j&aacute; est&aacute; novamente <b>apto a doar sangue.</b></h2>
<br /> <a href="http://www.ihene.com.br" title="Site do Ihene" target="_blank"><img src="http://ihene.com.br/mailing/imagens/logo.php?email='.$email_contato.'&mensagem='.$id_mensagem.'" height="90" style="height: 90px; width: auto; text-align: center; border: none;" /></a> <br />
<h3 style="color: red; margin: 0; font-size: 2.5em; text-align: center;">Venha nos ajudar a salvar vidas !<br/><a href="http://www.ihene.com.br" style="font-size: 0.5em;text-decoration:none; color:red;" target="_blank" >Acesse nosso site para saber mais sobre doação de sangue.</a></h3>
<address style="font-size: 1.2em; font-weight: normal; text-align: center; color: darkgreen;">Instituto de Hematologia do Nordeste Rua Tabira, 54 - Boa Vista - Recife</address>
<h4 style="font-size: 1.1em; font-weight: bold; text-align: center; color: darkgreen;">Atendimento de Segunda &agrave; S&aacute;bado: 08h00 &agrave;s 18h00<br />Fone: 81 - 2138-3500</h4>
<a href="https://www.facebook.com/ihenepe/" title="Curta Nossa P&aacute;gina no Facebook" target="_blank"> <img src="http://ihene.com.br/mailing/imagens/facebook-like.png" height="40" style="height: 40px; width: auto; border: none;" /></a></div>';

if($view){
	$urlCancelamento = $caminhoURL."/cancelamento.php?email=".$email_contato;
	$mensagem .= "<br/><center style='font-size:.8em;'><a href='$urlCancelamento' target='_blank'>Clique Aqui caso não queira mais receber este email.</a></center>";
	
	$urlAtivaSimples = 'href="http://ihene.com.br/mailing/app/projeto/link.php?email='.$email_contato.'&mensagem=$id&link=';
	$mensagem = str_replace('href="http://',$urlAtivaSimples, $mensagem);
	
	echo $mensagem;
	echo '</body></html>';
}
?>