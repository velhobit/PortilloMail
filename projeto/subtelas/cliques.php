<?php
	//include "header.php";
	include "../libs/conexao.php";        //Conexão com o banco de dados.
	include "../functions.php";
	
	$id = $_REQUEST["mensagem"];
?>
<?php
	//SELECIONAR ITENS PARA PREENCHER A GRID
	$strSQL = "SELECT * FROM cliques WHERE mensagem = '$id'";   //Variável que armazena strings para extrair os dados da tabela.
	$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.
?>
	<table>
		<caption>Contatos que Clicaram em Algum Link do Email</caption>
		<thead>
			<th>ID</th>
			<th>Email</th>
			<th>Link</th>
			<th>Horário</th>
		</thead>
		<tbody>
			<?php
				while($row = mysqli_fetch_array($rs)):
			?>
			<tr>
				<td rel="id"><?php echo $row['id']?></td>
				<td rel="email"><?php echo $row['contato']?></td>
				<td rel="link"><?php echo $row['link']?></td>
				<td rel="horario"><?php echo date('d/m/Y H:i',strtotime($row['data_hora']))?></td>
			</tr>
			<?php
				endwhile;
			?>
		</tbody>
	</table>
	<h3>
		<?php 
			if(isset($_REQUEST[$titulo])){
				$titulo = "";
			}
		?>
	</h3>