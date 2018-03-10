<?php
if(isset($_REQUEST["excluir"])){
	function delTree($dir) { 
		$files = array_diff(scandir($dir), array('.','..')); 
		foreach ($files as $file) { 
		  (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
		} 
		return rmdir($dir); 
	}

	delTree("../instalador");
	echo('<META http-equiv="refresh" content="1;URL=../">');
}
?>
<!DOCTYPE>
<html lang="pt_br">
	<header>
		<meta charset="utf-8"/>
		<title>Enviar Email em Lote</title>
		<link rel="stylesheet" href="../css/estilo.css">
	</header>
	<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.7&appId=1566786350223509";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	
		<div class="login" style="width:80%; max-width:700px; margin-top:10px;">
			<center>
				<img style="max-width:250px;" src="../assets/logo_maior.png"/>
			</center>
			<h1>Está Tudo Completo! Obrigado por instalar o PortilloMail.</h1>
			<p>Para sua segurança, a pasta do instalador será automaticamente excluída e você será encaminhado para a tela de login. Caso deseje fazer mudanças nas configurações, acesse a área correspondente no sistema.</p>
			<p>Caso possua dúvidas, acesse o site da PortilloDesign, ou procure-nos na página Facebook.</p>
			<p><b><a href="http://portillodesign.com.br/projetos/portillo-mail.html">Página do PortilloMail, no blog PortilloDesign.</a></b></p>
			
			<p><b><a href="http://portillodesign.com.br/ajude-um-desenvolvedor.html">Considere fazer uma doação para um humilde desenvolvedor. :). Existem várias formas de ajudar.</a></b></p>
			<form action="excluir.php">
				<center>
					<input type="hidden" name="excluir" value="true"/>
					<button type="submit">Finalizar Instalador e Entrar no PortilloMail</button>
				</center>
			</form>
			
			<center>
			<div class="fb-page" data-href="https://www.facebook.com/portillodesign/" data-tabs="timeline" data-width="800" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/portillodesign/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/portillodesign/">PortilloDesign</a></blockquote></div>
			</center>
		</div>
		
		<div class="powered" style="position: fixed;right: 5px;bottom: 5px;text-align: right;color:lightgrey; font-size:16px;">
		<em>Powered By</em><a href="http://portillodesign.com.br" title="PortilloDesign" itemprop="url" target="_blank"><img style="height: 32px;
			margin-bottom:-10px;width: auto;border-radius:5px;margin-left:5px;margin-right:5px" itemprop="logo" class="logo" src="http://portillodesign.com.br/images/logo/apple-icon-114x114.png" alt="Logo da PortilloDesign" title="PortilloDesign"></a><span itemprop="name">0.9</span>
		</div>
		
	</body>
</html>