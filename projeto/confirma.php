<?php
	include "header.php";
	include "libs/conexao.php";        //Conexão com o banco de dados.
	include "functions.php";
	ini_set('error_reporting', E_ALL);     //Reporta todos os erros.  
	
	$email_envio = $_REQUEST['origem'];
	$grupo = $_REQUEST['grupo'];
	$emails_adicionais = $_REQUEST['emails_adicionais'];
	$assunto = $_REQUEST['assunto'];
	$mensagem = $_REQUEST['mensagem'];
	$slug = criarSlug($assunto);
	if($grupo = "todos"){
		$grupo = 0;
	}
	
	$nomeGrupo = "";

	if($grupo > 0){
		$strSQL = "SELECT titulo FROM grupos WHERE grupo = '" . $grupo . "'"; 
		$rs = mysqli_query($con,$sql);
		while($row = mysqli_fetch_array($rs)){
			$nomeGrupo = $row["titulo"];
		}
	}else{
		$nomeGrupo = "Todos";
	}
	
	if(isset($_REQUEST['id'])){
		$id = $_REQUEST['id'];
		$sql = "UPDATE mensagens SET grupos='$grupo',emails_adicionais='$emails_adicionais',mensagem='$mensagem',assunto='$assunto',email_envio='$email_envio',status='0',data_envio_ini=DEFAULT,data_envio_fin=DEFAULT,data_atualizacao=DEFAULT,obs='Preparando Para Envio',url='' WHERE id='$id'";
		$rs = mysqli_query($con,$sql);
	}else{
		//Gravar Dados
		$sql = "INSERT INTO mensagens VALUES(DEFAULT,'$grupo','$emails_adicionais','$mensagem','$assunto','$email_envio',0,DEFAULT,DEFAULT,DEFAULT,'Preparando Para Envio','')";
		$rs = mysqli_query($con,$sql);
		$id = mysqli_insert_id($con);
	}
	
	//Pegar Email por Extenso
	$sql = "SELECT * FROM usuarios WHERE id='$email_envio'";
	$rs = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($rs)){
		$email_envio = $row["nome"];
		$nome_contato = $row["nome"];
		$email_contato = $row["email"];
	}
	
	//Pegar Grupo por Extenso
	$sql = "SELECT titulo FROM grupos WHERE id='$grupo'";
	$rs = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($rs)){
		$grupo = $row["titulo"];
	}
	
	//$mensagem = str_replace("[NOME]", $email_envio, $mensagem);
	
	$url = 'id'.$id.'-'.$slug;
	
	$id_mensagem = $id;
	
		//Gravar URL
	$sql = "UPDATE mensagens SET url = '$url' WHERE id='$id'";
	//echo $sql;
	$rs = mysqli_query($con,$sql);
	
	
	//GERAR ARQUIVO HTML DO EMAIL
	$myfile = fopen("emails/".$url.".html", "w") or die("Não foi Possível Gerar o Email");
	
	$url = $caminhoURL."emails/$url.html"; //Corrigir URL para o Banco e Link completo
	
	$email = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<style>
			body{
				font-family: Helvetica, Roboto, Arial;
			}
			</style>
			<title>'.$assunto.'</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			</head>
			<body>';
	$email .= $mensagem;
	
	//Dados Template
	//include("components/email_template.php");
	$email .= "<center style='font-size:.8em;'>Caso não consiga visualizar corretamente este email, <a href='$url' target='_blank'>clique aqui para acessar</a>.</center>";
	$email .= '</body>';
	fwrite($myfile, $email);
	fclose($myfile);


	if($emails_adicionais == ""){
		$emails_adicionais = 'Nenhum Email Adicional';
	}

?>
<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
  
  function enviarTeste(evt){
	  var url="enviar_teste.php?";
	  url += "id=";
	  url += $("#teste_id").val();
	  url += "&email=";
	  url += $("#teste_email").val();
	  
	  $.colorbox({href:url});
  }
</script>
<div class="wrap confirma">
	<h1>Confirmação de Envio de Email</h1>
	<div class="enviarEmail">
		<div class="crud">
		<p>Por favor, verifique abaixo o resultado do email. Caso esteja tudo bem, clique em ENVIAR E-MAIL. Lembre-se que o formato do email pode sofrer algumas alterações dependendo do tipo do cliente de email e do navegador do destinatário.</p>
		<div class="buttons">

				<div>
					<input type="hidden" name="id" id="teste_id" value="<?php echo $id; ?>"/>
					<input type="email" name="email" id="teste_email" placeholder="Email de Teste" required="true"/>
					<button class="teste" onClick="enviarTeste(event)">Enviar Teste</button>
				</div>
				<form action="enviar.php">
					<input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
					<input type="hidden" name="acao" id="acao" value="1"/>
					<button>Enviar E-mail</button>
				</form>
				<button class="voltar">Voltar</button>

		</div>
		</div>
		<div class="resumo">
			<h2>Resumo</h2>
			<p><b>Enviado Por: </b><?php echo $email_envio ?></p>
			<p><b>Para Categoria: </b><?php echo $nomeGrupo ?></p>
			<p><b>Outros Destinatários: </b><?php echo $emails_adicionais ?></p>
			<p><b>Assunto: </b><?php echo $assunto?></p>
			<p><b>URL: </b><a href='<?php echo $url?>' target='_blank'><?php echo $url?></a></p>
			<iframe class="conferir" width="700" src="<?php echo $url ?>" frameborder="0" scrolling="no" onload="javascript:resizeIframe(this);" id="iframe" onload='javascript:resizeIframe(this);'/>
		</div>
	</div>		
</div>
<?php
	include "footer.php";
	?>