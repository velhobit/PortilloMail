<?php
	include "header.php";
	include "libs/conexao.php";        //Conexão com o banco de dados.

	$strSQL = "SELECT men.id as id,men.assunto as assunto,men.mensagem as mensagem,men.url as url,(SELECT email FROM usuarios WHERE id=men.email_envio) as email_envio,(SELECT nome FROM usuarios WHERE id=men.email_envio) as nome, emails_adicionais, (SELECT titulo FROM grupos WHERE id = men.grupos) as grupos, data_envio_ini,data_envio_fin,data_atualizacao, grupos as id_grupo,men.status as status, (SELECT count(id) FROM cliques WHERE mensagem=men.id) as cliques FROM mensagens men ORDER BY id DESC LIMIT 100";   //Variável que armazena strings para extrair os dados da tabela.
	$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.
	
?>
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
			<th>D/H Início</th>
			<th>D/H Atualizado</th>
			<th>D/H Fim</th>
			<th>Ação</th>
		</thead>
		<tbody>
			<?php
				while($row = mysqli_fetch_array($rs)):
				
				if($row['status'] == 0){
					$status = 'Não Enviado';
					$class = 'nao_enviado';
				}else if($row['status'] == 1){
					$status = 'Ainda Enviando';
					$class = 'enviando';
				}else if($row['status'] == 2){
					$status = 'Enviado com Sucesso';
					$class = 'enviado';
				}else if($row['status'] == 3){
					$status = 'Erro ao Enviar';
					$class = 'erro';
				}
				
				//Verifica se o Processo foi interrompido por algum motivo
				$processoInterrompido = false;
				if($row['status'] == 1){
					$segundos = 60/($emailsHora/60);
					$dataComparacao = date('d-m-Y H:i:s', strtotime($row['data_atualizacao'].' +'.(segundos*2).' second')); // Momento que deveria ocorrer a próxima atualização com margem de segurança
					$dataAtual = date('d-m-Y H:i:s');
					if($dataAtual > $dataComparacao){
						$processoInterrompido = true;
						$status = "Processo Interrompido";
						$class = "erro";
					}
				}
			?>
			<tr>
				<td rel="id"><?php echo $row['id']?></td>
				<td><a href="subtelas/emails_grupo.php?id_grupo=<?php echo $row['id_grupo']?>" class="ajax"><?php echo $row['grupos']?></a></td>
				<td><a target="_blank" href="emails/<?php echo $row['url']?>.html" title="Visualizar Email"><?php echo $row['assunto']; ?></a></td>
				<td><?php echo $row['email_envio']?></td>
				<td class="<?php echo $class;?>"><?php echo $status?></td>
				<td><a href="subtelas/cliques.php?mensagem=<?php echo $row['id']?>" class="ajax"><?php echo $row['cliques']?></a></td>
				<td><?php echo $row['data_envio_ini']?></td>
				<td><?php echo $row['data_atualizacao']?></td>
				<td><?php echo $row['data_envio_fin']?></td>
				<!--<td><a href="editar.php?id=<?php echo $row['id']?>">Editar</a></td>-->
                <td>
                	<a onClick="reeditar(event)">Editar</a>
                	<?php if($processoInterrompido):?>
                		<a href="enviar.php?id=<?php echo $row['id']?>&acao=1&continuar=1" class="ajax"><b>Continuar Processo</b></a>
                	<?php endif;?>
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
<script>
	$(".ajax").colorbox({width:"80%", height:"70%",className:"caixaBranca"});
	
	function reeditar(event){
		var pai = $(event.target).parent().parent();
		//relacionar
		$("form#formulario").find("#id_mail").val($(pai).find("td[rel='id']").html());
		$("form#formulario").submit();
	}
</script>

<?php
	include "footer.php";
	?>