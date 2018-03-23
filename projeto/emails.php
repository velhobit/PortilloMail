<?php

	include "header.php";



	date_default_timezone_set('America/Sao_Paulo');

	$dt = new DateTime();

	if($horarioComercial_ini != ""){

		$horaAtual = $dt->format('H');

		if($horaAtual >= $horarioComercial_ini && $horaAtual <= $horarioComercial_fin){

			$emailsHora = $emailsHoraNaoComercial;

		}

	}

?>	

<?php if(isset($_REQUEST["id_men"])): ?>

	<?php

		$strSQL = "DELETE FROM mensagens WHERE id = '". $_REQUEST["id_men"] ."'";

		$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.

	?>

	<div class="alert wrap">Mensagem de código <?php echo $_REQUEST["id_men"] ?> apagada com sucesso.</div>

<?php endif;

	$strSQL = "SELECT men.id as id,men.assunto as assunto,men.mensagem as mensagem,men.url as url,(SELECT email FROM usuarios WHERE id=men.email_envio) as email_envio,(SELECT nome FROM usuarios WHERE id=men.email_envio) as nome, emails_adicionais, (SELECT titulo FROM grupos WHERE id = men.grupos) as grupos, data_envio_ini,data_envio_fin,data_atualizacao, grupos as id_grupo,men.status as status, (SELECT count(id) FROM cliques WHERE mensagem=men.id) as cliques,(SELECT count(id) FROM views WHERE mensagem=men.id) as visualizacoes FROM mensagens men ORDER BY id DESC";   //Variável que armazena strings para extrair os dados da tabela.

	$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.

?>

<div class="area" id="loadArea">

	<div class="wrap so_tabela">

		<h1>Emails Enviados</h1>

		<div class="area_tabela">

			<div class="tabela">

		<table>

			<thead>

				<th>ID</th>

				<th>Grupo</th>

				<th>Assunto</th>

				<th>Enviado Por</th>

				<th>Status</th>

				<th>Cliques</th>

				<th>Views</th>

				<th>D/H Início</th>

				<!-- <th>D/H Atualizado</th>-->

				<th>D/H Fim</th>

				<th>Ação</th>

			</thead>

			<tbody>

				<?php

					while($row = mysqli_fetch_array($rs)):



					if($row['status'] == 0){

						$status = '<img src="'.$caminhoURL.'assets/alerta.png" title="Não Enviado"/>';

						$class = 'nao_enviado';

					}else if($row['status'] == 1){

						$status = '<img src="'.$caminhoURL.'assets/enviando.png" title="Ainda Enviando"/>';

						$class = 'enviando';

					}else if($row['status'] == 2){

						$status = '<img src="'.$caminhoURL.'assets/enviado.png" title="Emails Enviados Com Sucesso"/>';

						$class = 'enviado';

					}else if($row['status'] == 3){

						$status = '<img src="'.$caminhoURL.'assets/alerta.png" title="Erro ao Enviar"/>';

						$class = 'erro';

					}
				
					



					//Verifica se o Processo foi interrompido por algum motivo

					$processoInterrompido = false;

					if($row['status'] == 1){

	

						$agora = date('d-m-Y H:i:s');

						$segundos = 60/($emailsHora/60);

						

						$proxAtualizacao = strtotime($row['data_atualizacao'] . ' +'. ($segundos+
						30).' second');

						$proxAtualizacao = date('d-m-Y H:i:s', $proxAtualizacao);


						if($proxAtualizacao < $agora){

							$processoInterrompido = true;

							$status = '<img src="'.$caminhoURL.'assets/alerta.png" title="Envio dos Interrompidos pelo Servidor. Clique em Continuar Envios para prosseguir."/>';

							$class = "erro";

						}

					}
					
				if($row['id_grupo'] == "" || $row['id_grupo'] == 0){
						$row['grupos'] = "Todos";
					}
				?>

				<tr>

					<td rel="id"><?php echo $row['id']?></td>

					<td><a href="subtelas/emails_grupo.php?id_grupo=<?php echo $row['id_grupo']?>" class="ajax"><?php echo $row['grupos']?></a></td>

					<td><a target="_blank" href="emails/<?php echo $row['url']?>.html" title="<?php echo $row['assunto']; ?>"><?php echo substr($row['assunto'], 0, 25)."..."; ?></a></td>

					<td><?php echo $row['email_envio']?></td>

					<td class="<?php echo $class;?>" style="cursor:help"><?php echo $status?></td>

					<td><a href="subtelas/cliques.php?mensagem=<?php echo $row['id']?>" class="ajax"><?php echo $row['cliques']?></a></td>

					<td><a href="subtelas/visualizacoes.php?mensagem=<?php echo $row['id']?>" class="ajax"><?php echo $row['visualizacoes']?></a></td>

					<td><?php echo date('d/m/Y H:i',strtotime( $row['data_envio_ini']));?></td>

					<!--<td><?php echo date('d/m/Y H:i',strtotime($row['data_atualizacao']));?></td>-->

					<td>

					<?php if($row['data_envio_fin'] > 0): ?>

						<?php echo date('d/m/Y H:i',strtotime($row['data_envio_fin']));?>

					<?php else: ?>
						Enviando
					<?php endif;?>

					</td>

					<td>

						<?php if($processoInterrompido):?>

							<a href="enviar.php?id=<?php echo $row['id']?>&acao=1&continuar=1" class="ajax"><b>Continuar Envios</b>&nbsp;</a>

						<?php endif;?>
						
						<a href="subtelas/dashboard.php?mensagem=<?php echo $row['id']?>" class="ajax"><img src="<?php echo $caminhoURL; ?>assets/chart.png" title="Editar Email"/>&nbsp;</a>

						<a onClick="reeditar(<?php echo $row['id']?>)" href="#"><img src="<?php echo $caminhoURL; ?>assets/editar.png" title="Editar Email"/>&nbsp;</a>

						<a onClick="deletar(<?php echo $row['id']?>)" href="#"><img src="<?php echo $caminhoURL; ?>assets/delete.png" title="Excluir Mensagem"/></a>

					</td>

				</tr>

				<?php

					endwhile;

				?>

			</tbody>

		</table>

			</div>

		</div>

	</div>

	<form action="email.php" method="post" id="formulario">

		<input type="hidden" name="id_mail" id="id_mail"/>

	</form>

	<form action="emails.php" method="post" id="excluir">

		<input type="hidden" name="id_men" id="id_men"/>

	</form>

</div>

<?php

	include "footer.php";

	?>