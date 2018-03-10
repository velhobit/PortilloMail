<?php
	include "header.php";
	include "libs/conexao.php";        //Conexão com o banco de dados.
	include "functions.php";
?>
<?php
	$grupoSelecionado = 0;
	$msg = false;

	if(isset($_REQUEST["grupos"])){
		$grupoSelecionado = $_REQUEST["grupos"];
	}
	//MANIPULAR ITENS
	$existe = 	isset($_REQUEST["email"]) &&
				isset($_REQUEST['nome']) &&
                isset($_REQUEST['telefone']) &&
                isset($_REQUEST['grupo']);

	if(isset($_REQUEST['acao'])){
		$grupoSelecionado = $_REQUEST["grupo"];
		if($_REQUEST['acao'] == '2'){
			$sql = "UPDATE contatos SET email='".$_REQUEST['email']."',nome='".$_REQUEST['nome']."',telefone='".$_REQUEST['telefone']."',grupo='".$_REQUEST['grupo']."' WHERE id='".$_REQUEST['id']."';";
			$msg = "Contato ".$_REQUEST['email']." atualizado com sucesso.";
		}else if($_REQUEST['acao'] == '3'){
			$sql = "DELETE FROM contatos WHERE id='".$_REQUEST['id']."' AND grupo = '".$_REQUEST['grupo']."';";
			$msg = "Contato ".$_REQUEST['email']." foi excluído com sucesso deste grupo (".$_REQUEST['grupo'].").";
		}
		else if($_REQUEST['acao'] == '1'){
			$strSQL = "SELECT email,aut FROM contatos WHERE email='".$_REQUEST['email']."' AND grupo='".$_REQUEST['grupo']."' LIMIT 1;";
			$strRes = mysqli_query($con,$strSQL);
			if(mysqli_num_rows($strRes) == 0){
				$sql = "INSERT INTO contatos VALUES(DEFAULT,'".$_REQUEST['email']."','".$_REQUEST['nome']."','".$_REQUEST['telefone']."','".$_REQUEST['grupo']."','1')";
				$msg = "Contato ".$_REQUEST['email']." foi inserido com sucesso.";
			}else{
				$msg = "Email já cadastrado neste grupo.";
				while($row = mysqli_fetch_array($strRes)){
					$aut = $row['aut'];
				}
				if($aut != 1){
					$msg = "Contato se descadastrou e não deseja mais receber emails";
				}
			}
		}
		//echo $sql;
        if($sql){
			$rsSql = mysqli_query($con,$sql);
		}
	}
?>
<?php
	if(isset($_REQUEST["grupos"]) || isset($_REQUEST['grupo'])){
		//SELECIONAR ITENS PARA PREENCHER A GRID
		$strSQL = "SELECT cont.id,cont.email,cont.nome,cont.telefone,cont.grupo, (SELECT titulo FROM grupos WHERE id = cont.grupo) AS titulo_grupo, cont.aut as aut FROM contatos cont WHERE grupo='".$grupoSelecionado."' GROUP BY cont.email ORDER BY aut DESC;" ;   //Variável que armazena strings para extrair os dados da tabela.
		$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.
	}
?>
<?php
	//SELECIONAR ITENS PARA PREENCHER OS GRUPOS
	$strSQLGrupos = "SELECT * FROM grupos ORDER BY titulo ASC";   //Variável que armazena strings para extrair os dados da tabela.
	$rsGrupos = mysqli_query($con,$strSQLGrupos);        //$rs = returnset. Retorno dos dados da tabela.
?>
<?php
	if($msg){
		echo "<div class='alert wrap'>$msg</div>";
	}else{
		//echo "<h2>Erro ao Atualizar o Cadastro de Contatos</h2><h3>".mysqli_error($con)."</h3>";
	}
?>
<div class="wrap contatos">
	<!--Crud-->
	<h1>Cadastro de Contatos</h1>
	<div class="area_crud">
		<div class="crud">
			<form method="post" action="#" id="formulario">
				<input type="hidden" name="acao" id="acao" value="1"  />
				<input type="text" name="id" id="id" placeholder="ID" />
				<input type="email" name="email" id="email" placeholder="Email" required="true"/>
				<input type="text" name="nome" id="nome" placeholder="Nome" required="true"/>
				<input type="text" name="telefone" id="telefone" placeholder="Telefone"/>
				<select name="grupo" id="grupo">
					<option value="0" selected="selected">Selecione o Grupo</option>
				<?php
					while($row = mysqli_fetch_array($rsGrupos)):
				?>
					<option value="<?php echo $row['id']?>"><?php echo $row['titulo']?></option>
				<?php
					endwhile;
				?>
				</select>

				<div class="botoes">
					<button type="submit">Gravar</button>
					<button type="reset" onclick="limpar()">Novo</button>
				</div>
			</form>
			<?php $rsGrupos = mysqli_query($con,$strSQLGrupos);?>
		</div>
		<div class="area_tabela_crud ">
			<form class="filtro" method="post" id="filtro">
				<label for="grupos">Filtrar por Grupos</label>
				<select name="grupos">
					<option value="0" selected="selected">Selecione o Grupo</option>
					<?php
						while($row = mysqli_fetch_array($rsGrupos)):
					?>
						<option value="<?php echo $row['id']?>"><?php echo $row['titulo']?></option>
					<?php
						endwhile;
					?>
				</select>
				<button type="submit">Filtrar</button>
			</form>
		<?php if(isset($_REQUEST["grupos"]) || isset($_REQUEST["grupo"])):?>
			<?php
				//SELECIONAR ITENS PARA PREENCHER OS GRUPOS
				$strCont = "SELECT count(aut) as aut, (SELECT count(id) FROM contatos) as tot FROM contatos WHERE aut = '1';";   //Variável que armazena strings para extrair os dados da tabela.
				$rsCont = mysqli_query($con,$strCont);        //$rs = returnset. Retorno dos dados da tabela.
				while($rowC = mysqli_fetch_array($rsCont)){
					echo "<p>Total de Emails Cadastrados Neste Grupo: ". $rowC["tot"] .".";
					echo "Desses, ". ( $rowC["tot"] - $rowC["aut"]) ." desautorizaram o envio de emails</p>";
				}
			?>
			<div class="tabela">
			<table>
				<caption>Contatos</caption>
				<thead>
					<th>ID</th>
					<th>Email</th>
					<th>Nome</th>
					<th>Telefone</th>
					<th>Grupo</th>
					<th>Ação</th>
				</thead>
				<tbody>
					<?php
						$total = 0;
						while($row = mysqli_fetch_array($rs)):
					?>
					<tr <?php if($row['aut'] != '1'):?> style="opacity:.5; cursor:help" title="Este contato desautorizou o recebimento de emails." <?php endif; ?> >
						<td rel="id"><?php echo $row['id']?></td>
						<td rel="email"><?php echo $row['email']?></td>
						<td rel="nome"><?php echo $row['nome']?></td>
						<td rel="telefone"><?php echo $row['telefone']?></td>
						<td rel="grupo" id="<?php echo $row['grupo']?>"><?php echo $row['titulo_grupo']?></td>
						<td>
							<img onclick="editar(event)" src="<?php echo $caminhoURL; ?>assets/editar.png" title="Editar Contato"/>
							<img src="<?php echo $caminhoURL; ?>assets/delete.png" title="Exluir Contato" onclick="excluir(<?php echo $row['id']?>,'<?php echo $row['email']?>',<?php echo $row['grupo']?>)"/>
						</td>
					</tr>
					<?php
						$total = $total+1;
						endwhile;
					?>
				</tbody>
			</table>

			</div>
			
		<?php endif;?>
		</div>
	</div>
	<h3>
		<?php 
			if(isset($_REQUEST[$titulo])){
				$titulo = "";
			}
		?>
	</h3>
</div>
<script>
	function limpar(){
		$("#acao").val("1");
	}
	
	function editar(event){
		relacionar(event);
		$("#acao").val("2"); // Ação 2 = Editar
	}
	
	function excluir(id,email,grupo){
		var r = confirm("Tem certeza que deseja excluir o contato "+email+"?");
		
		if (r == true) {
			$("#id").val(id);
			$("#email").val(email);
			$("#grupo").val(grupo);
		    $("#acao").val("3"); // Ação 3 = Excluir
		    $("form#formulario").submit();
		} else {
		   alert("O contato " + email + " não foi excluído deste grupo.")
		}
	}
	
	function relacionar(event){
		var pai = $(event.target).parent().parent();
		//relacionar
		$(pai).find("td").each(function(){
			var campo = $(this).attr("rel");
			//AdicionarValor
			$("form#formulario").find("#"+campo).val($(this).html());
		});
         $("form#formulario").find("#grupo").val($(pai).find("td[rel=grupo]").attr("id"));
	}
</script>

<?php include "footer.php"; ?>