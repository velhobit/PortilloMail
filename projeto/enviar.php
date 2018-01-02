<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
	******************************/
	include "header.php";
	ini_set('error_reporting', E_ALL);     //Reporta todos os erros.
	date_default_timezone_set('America/Sao_Paulo');
	
	$id = $_REQUEST["id"];
	$acao = $_REQUEST["acao"];

	$continuar = false;
	$dt = new DateTime();
    $horarioEnvio = $dt->format('Y-m-d H:i:s');

	if($horarioComercial_ini != ""){
		$horaAtual = $dt->format('H');
		if($horaAtual >= $horarioComercial_ini && $horaAtual <= $horarioComercial_fin){
			$emailsHora = $emailsHoraNaoComercial;
		}
	}

    $imediato = false;

	$assunto;
	$email_envio;
	$emails_adicionais;
	$grupo;
	$mensagem;
	$status;
	$data_envio;
	$data_atualizacao;
	$obs;
	$email = "";
	$enviados = "";
	$emailsRestantes = "";
	include "libs/conexao.php";        //Conexão com o banco de dados.

	if(isset($_REQUEST["imediato"])){
		$imediato = true;
	}


	if(isset($_REQUEST["continuar"])){
		$continuar = true;
	}else{
	    //Registrar o Início do Envio
		$sql = "UPDATE mensagens SET data_envio_ini='".$horarioEnvio."', status='1' WHERE id='$id';";
	    $rs = mysqli_query($con,$sql);
	}

	$EmailsEnviados = array();
	$EmailsFaltantes = array();
	$arrEmailsComp = array();
	$arrEmail = array();
//die();
?>

<?php
	if($acao==1):

		//--INICIO DA EXPLICAÇÃO
		// SELECIONE
		// os campos (men.id, men.assunto, men.etc...), onde men é a referência da tabela, ou seja, eu quero esses itens DESSA tabela men
		// A PARTIR DA TABELA mensagens men (men é a referência)
		// ONDE o campo id for igual ao id que estou passando no PHP
		$sql = "SELECT men.id as id,men.assunto as assunto,men.mensagem as mensagem,men.url as url,(SELECT email FROM usuarios WHERE id=men.email_envio) as email_envio,(SELECT nome FROM usuarios WHERE id=men.email_envio) as nome_envio,(SELECT nome FROM usuarios WHERE id=men.email_envio) as nome,(SELECT senha_email FROM usuarios WHERE id=men.email_envio) as senha_email, grupos, emails_adicionais FROM mensagens men WHERE id='$id'";
		//Como eu não lembrava o nome do campo, fui lá no PHPMYADMIN e olhei qual era o nome do campo dos emails complementares, no caso é o campo emails_complementares, então adicionei no final do select, antes do FROM

        $rs = mysqli_query($con,$sql);
        while($row = mysqli_fetch_array($rs)){
            $id = $row["id"];
			$assunto = $row["assunto"];
			$envio = $row["email_envio"];
			$nome_envio = $row["nome_envio"];
			$nome = $row["nome"];
			$mensagem = $row["mensagem"];
			$url = $row["url"];
			$senha_email = $row["senha_email"];
			$grupo = $row["grupos"];
			// Aqui eu coloco os emails complementares em uma variável
            $emailsComp = $row["emails_adicionais"]; // O nome é igual ao do campo, poruq eue usei o msqli_ FETCH ARRAY (ou seja, transforma em uma array associativo)
        }

        //PORÉM, o $emailsComp retorna uma STRING, logo, eu preciso separar essa String
        // Os emails complementares chegam da seguinte forma: email@dominio.com, outroemail@dominio.com, maisumemail@dominio.com, só que em linha única, então temos que dividir em um vetor, e vamos usar o vírgula como divisor
        if(trim($emailsComp) != "" ){
        	$arrEmailsComp = explode(",", $emailsComp); //Explodo (em algumas linguagens é split) a string de emails e a transformo em vetor, usando o vírgula como divisão
        }

        //Caso o email já tenha sido enviado anterioremente, continue os emails pela tabela restante
        if($continuar){
	        $strSQL = "SELECT email FROM restantes WHERE mensagem='".$id."' AND enviado='0' GROUP BY email LIMIT 10;";//Query da Tabela Restantes //Enviado 0 representa que não foi enviado ainda
	    }else{
			if($grupo > 0){
				//Capturar Emails do Grupo
				$strSQL = "SELECT email FROM contatos WHERE grupo='".$grupo."' AND aut='1' ";//Query da Tabela Contatos
				/*$strSQL = "SELECT m.email FROM contatos m WHERE grupo='3' AND aut='1' AND NOT EXISTS
				        (
				        SELECT  1
				        FROM    views e
				        WHERE   e.contato = m.email
				        )";*/
			}else{
				$strSQL = "SELECT email FROM contatos WHERE aut='1';";
			}
			//echo $strSQL;
		}
		//print_r($strSQL);
		$rs = mysqli_query($con,$strSQL);

		//$grupo = "";
        $i = 0;
		while($row = mysqli_fetch_array($rs)){
			$arrEmail[$i] = $row["email"];
			if(!$continuar){
				if (!filter_var($arrEmail[$i], FILTER_VALIDATE_EMAIL) === false) { //Verifica se é email de verdade
					$sqlLog = "INSERT INTO restantes VALUES(DEFAULT,'$id','".$arrEmail[$i]."','0');";
					mysqli_query($con,$sqlLog);
				}
			}
            $i++;
		}

		if(!$continuar){
			for($i=0;$i<count($arrEmailsComp);$i++){
				if (!filter_var($arrEmailsComp[$i], FILTER_VALIDATE_EMAIL) === false) {
					$sqlLog = "INSERT INTO restantes VALUES(DEFAULT,'$id','".$arrEmailsComp[$i]."','0');";
					mysqli_query($con,$sqlLog);
				}
			}
		}


		//Capturar Nome do Grupo
		$strSQL = "SELECT titulo FROM grupos WHERE id='".$grupo."' LIMIT 1";//Query da Tabela Grupos
		$rs = mysqli_query($con,$strSQL);
		while($row = mysqli_fetch_array($rs)){
			$grupo = $row["titulo"];
		}

		//echo count($arrEmail)."<br/>";

		//Agora precisamos adicionar os emails complementares aos emails que serão utilizados
		if(trim($emailsComp) != "" && !$continuar){
			$arrEmail = array_merge($arrEmailsComp,$arrEmail);//Estou fundindo as duas arrays em uma, sendo que estou usando a mesma variável da array de emails, para poder otimizar a semântica e reaproveitar o espaço reservado na memória
		}
		//echo count($arrEmail)."<br/>";
		//print_r($arrEmail);


		//---FIM DA EXPLICAÇÃO
		$url = $caminhoURL."/emails/".$url.".html";
	    for($i=0;$i < count($arrEmail); $i++){        //Inicia o laço para construir os emails.

		    if($i < 1){  // Manipular para enviar mais de um email no mesmo processo
			    $urlCancelamento = $caminhoURL."/cancelamento.php?email=".$arrEmail[$i];
			    //Montar Mensagem
				$emailCompleto = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<style>
					body{
						font-family: Helvetica, Roboto, Arial;
					}
					</style>
					<title>$assunto</title>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					</head>
					<body>';
				$emailCompleto .= $mensagem;
        		$emailCompleto .= "<img src=\"".$caminhoURL."/contador.php?email=".$arrEmail[$i]."&mensagem=".$id."\" height=\"90\" style=\"height: 90px; width: auto; text-align: center; border: none;\" />";
				$emailCompleto .= "<center style='font-size:.8em;'>Caso você não consiga visualizar este email corretamente, <a href='$url' target='_blank'>clique aqui para acessar</a>.</center>";
				$emailCompleto .= "<center style='font-size:.8em;'><a href='$urlCancelamento' target='_blank'>Cancelar Inscrição</a></center>";
				$emailCompleto .= '</body>';

				$urlAtivaSimples = "href='".$caminhoURL."link.php?email=".$arrEmail[$i]."&mensagem=$id&link=";
				$urlAtivaDupla = 'href="'.$caminhoURL."link.php?email=".$arrEmail[$i]."&mensagem=$id&link=";
				$emailCompleto = str_replace("href='http://",$urlAtivaSimples, $emailCompleto);
				$emailCompleto = str_replace('href="http://',$urlAtivaDupla, $emailCompleto);

				// Cabeçalhos
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";        //Envia o email com codificação UTF-8.
				$headers .= 'From: '.$nome.' <'.$envio.'> '."\r\n".
				'Reply-To: '.$envio."\r\n" .
				'X-Mailer: PHP/' . phpversion();

				$errors = "";       //Variável onde os erros são armazenados.


				if($usarSMTP){{
					include_once("libs/phpmail/PHPMailerAutoload.php");
					
					$mail = new PHPMailer();
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->CharSet = $charset;
					$mail->Host = $smtp; // SMTP server
					$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
					if($emailResposta != null && $emailResposta != ""){
						$mail->AddReplyTo($emailResposta, $nomeEmailResposta);
					}
					// 1 = errors and messages
					// 2 = messages only
					$mail->SMTPAutoTLS = false;
					$mail->SMTPAuth = $autenticacao; // enable SMTP authentication
					$mail->SMTPSecure = $seguranca;
					$mail->Port = $porta; // set the SMTP port for the service server
					$mail->Username = $envio; // account username
					$mail->Password = $senha_email; // account password
					
					/***
					Inclua o DKIM se necessário
					$mail->DKIM_domain = 'dominio.com.br';
					$mail->DKIM_private = 'chaves/private.dominio.com.br';
					$mail->DKIM_selector = 'phpmailer';
					$mail->DKIM_passphrase = 'senha';
					$mail->DKIM_identity = 'identidade@dominio.com.br';
					****/
					
					$mail->SetFrom($envio, $nome_envio);
					$mail->Subject = $assunto;
					$mail->MsgHTML($emailCompleto);
					$mail->AddAddress($arrEmail[$i], "");
					
					//echo $envio.$senha_email;
					
					$retorno = $mail->Send();
				}else{
					$retorno = @mail($arrEmail[$i], $assunto, $emailCompleto, $headers);
				}

				//echo $local;
				//kill_the_process();//this will kill the running process launched by script
				//	connection_aborted();
				// die();
				//shell_exec("(sleep 5; php $local)");
				if($retorno){
					$sqlEnviado = "UPDATE restantes SET enviado='1' WHERE mensagem='$id' AND email='".$arrEmail[$i]."';"; // Enviado 1 representa sucesso

				}else{
					$sqlEnviado = "UPDATE restantes SET enviado='2' WHERE mensagem='$id' AND email='".$arrEmail[$i]."';"; //Enviado 2 representa erro
				}

				//print_r($sqlEnviado);
				//echo "<br/>";
				//Atualizar Tabela de Enviados
				mysqli_query($con,$sqlEnviado);
				//echo "<br/>";
				//print_r($con);
			}
			//else{
				//$emailsRestantes = str_replace($emailsEnviados, "", $_POST);
				//file_put_contents("temp.txt", $emailsRestantes);                   //Salva os emails restantes no documento temp.txt.
		//	}
        }

        //die();



       /* if(count($EmailsEnviados) > 0 && count($EmailsFaltantes) == 0){
	        $sql = "UPDATE mensagens SET data_envio_ini='".$horarioEnvio."', status='2' WHERE id='$id';";
        }elseif(count($EmailsFaltantes)==0){
	        $sql = "UPDATE mensagens SET data_envio_ini='".$horarioEnvio."', status='3' WHERE id='$id';";
        }else{
	        $sql = "UPDATE mensagens SET data_envio_ini='".$horarioEnvio."', status='1' WHERE id='$id';";
        }
        $rs = mysqli_query($con,$sql);*/
?>
<?php
	endif;
	
	if($grupo > 0){
		$strSQL = "SELECT titulo FROM grupos WHERE grupo = '" . $grupo . "'"; 
		$rs = mysqli_query($con,$sql);
		while($row = mysqli_fetch_array($rs)){
			$nomeGrupo = $row["titulo"];
		}
	}else{
		$nomeGrupo = "Todos";
	}
?>
<?php if(!$continuar): ?>
<div class="wrap so_tabela tela_confirmacao">
	<h1 class="sucesso">Iniciado Processo de Envio de Emails</h1>
    <center>
		<p>Utilize a Tela de <a href="<?php echo $caminhoURL; ?>emails.php">Emails Enviados</a> para 
    <div class="area_tabela">
	   	<center>
	    <h3>Assunto: <?php echo $assunto; ?></h3>
	    <h3>Grupo: <?php echo $nomeGrupo; ?></h3>
	    <h3>Processo Iniciado em: <?php echo date('d/m/Y H:i',strtotime($horarioEnvio)); ?></h3>
	    <!--<h3>Enviados: <?php echo count($EmailsEnviados); ?></h3>
	    <h3>Não Enviados: <?php echo count($EmailsFaltantes); ?></h3>-->
	    <div class="tabela">
	<!--<?php if(count($EmailsFaltantes) > 0):?>
	<table class="resultado">
		<caption style="background-color: #d69a03">Faltou</caption>
		<thead>
			<th>Email</th>
		</thead>
		<tbody>
			<?php
				for($i=0; count($EmailsFaltantes)> $i; $i++):
			?>
			<tr>
				<td><?php echo $EmailsFaltantes[$i]?></td>
			</tr>
			<?php
				endfor;
			?>
		</tbody>
	</table>
	<?php endif;?>
	<?php if(count($EmailsEnviados) > 0):?>
	<table class="resultado">
		<caption style="background-color: #00ce8d">Enviados com Sucesso</caption>
		<thead>
			<th>Email</th>
		</thead>
		<tbody>
			<?php
				for($i=0; count($EmailsEnviados)> $i; $i++):
			?>
			<tr>
				<td><?php echo $EmailsEnviados[$i]?></td>
			</tr>
			<?php
				endfor;
			?>
		</tbody>
	</table>-->
	<?php endif;?>
	    </div>

    </div>
</div>
<?php
	endif;
?>
<?php
		//print_r($arrEmail);
		//die();

	//Registrar o Atualização do Envio -- Retirar caso pese muito no servidor
	$sql = "UPDATE mensagens SET data_atualizacao='".$horarioEnvio."', status='1',obs='Enviando' WHERE id='$id';";
    $rs = mysqli_query($con,$sql);

	include "footer.php";

	if(count($arrEmail) != 0){
		$local = $caminhoURL."enviar.php?id=".$id."\&acao=".$acao."\&continuar=1";
		$logFile = realpath(dirname(__FILE__)).".log";
		//echo $local;
		//echo count($arrEmail);
		$segundos= 60/($emailsHora/60);
		if($continuar):?>
			<h1>Envios Retomados</h1>
		<?php
			sleep(round($segundos)); // 30 = 2 emails por minuto
		endif;
		$exec = exec("curl --request GET $local > /dev/null 2>/dev/null &"); //Executar de forma de assínscrona e em background
		//set_time_limit(0);

	}else{
		//Registrar o Fim do Envio
		$sql = "UPDATE mensagens SET data_envio_fin='".$horarioEnvio."', status='2',obs='Terminado' WHERE id='$id';";
        $rs = mysqli_query($con,$sql);
	}
?>
