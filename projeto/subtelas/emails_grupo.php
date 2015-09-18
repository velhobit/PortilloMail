<?php
	//include "header.php";
	include "../libs/conexao.php";        //Conexão com o banco de dados.
	include "../functions.php";
	
	$idGrupo = $_REQUEST["id_grupo"];
?>
<?php
	//SELECIONAR ITENS PARA PREENCHER A GRID
	$strSQL = "SELECT cont.id,cont.email,cont.nome,cont.telefone,cont.grupo, (SELECT titulo FROM grupos WHERE id = cont.grupo) AS titulo_grupo FROM contatos cont WHERE cont.aut = 1 AND cont.grupo = $idGrupo";   //Variável que armazena strings para extrair os dados da tabela.
	$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.
?>
	<table>
		<caption>Contatos</caption>
		<thead>
			<th>ID</th>
			<th>Email</th>
			<th>Nome</th>
			<th>Telefone</th>
		</thead>
		<tbody>
			<?php
				while($row = mysqli_fetch_array($rs)):
			?>
			<tr>
				<td rel="id"><?php echo $row['id']?></td>
				<td rel="email"><?php echo $row['email']?></td>
				<td rel="nome"><?php echo $row['nome']?></td>
				<td rel="telefone"><?php echo $row['telefone']?></td>
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