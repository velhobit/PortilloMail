<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url https://velhobit.com.br
	******************************/
	include "header.php";
	include "libs/seguranca.php";        //Conexão com o banco de dados.
	include "functions.php";
	protegePagina();
?>
<?php
	//MANIPULAR ITENS
	$existe = 	isset($_REQUEST["titulo"]) &&
				isset($_REQUEST['descricao']);

	if($existe){
		if($_REQUEST['acao'] == '2'){
			$sql = "UPDATE grupos SET titulo='".$_REQUEST['titulo']."',descricao='".$_REQUEST['descricao']."' WHERE id='".$_REQUEST['id']."';";
			$msg = "Grupo ".$_REQUEST['titulo']." Atualizado com Sucesso";
		}else if($_REQUEST['acao'] == '3'){
			$sql = "DELETE FROM grupos WHERE id='".$_REQUEST['id']."';";
			$msg = "Grupo ".$_REQUEST['titulo']." foi excluído";
		}
		else if($_REQUEST['acao'] == '1'){
			$sql = "INSERT INTO grupos VALUES(DEFAULT,'".$_REQUEST['titulo']."','".$_REQUEST['descricao']."')";
			$msg = "Grupo ".$_REQUEST['titulo']." foi inserido";
		}
		
		$rsSql = mysqli_query($con,$sql);
	}
?>
<?php
	//SELECIONAR ITENS PARA PREENCHER A GRID
	$strSQL = "SELECT * FROM grupos ORDER BY titulo";   //Variável que armazena strings para extrair os dados da tabela.
	$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.
?>
<?php
	if($rsSql && isset($_REQUEST["id"])){
		echo "<div class='alert wrap'>$msg</div>";
	}else{
		//echo "<h2>Erro ao Atualizar o Cadastro de Grupos</h2><h3>".mysqli_error($con)."</h3>";
	}
?>
<div class="wrap grupos">
	<!--Crud-->
	<h1>Cadastro de Grupos de Emails</h1>
	<div class="area_crud">
		<div class="crud">
			<form method="post" action="#" id="formulario">
				<input type="hidden" name="acao" id="acao" value="1"  />
				<input type="text" name="id" id="id" placeholder="ID" />
				<input type="text" name="titulo"  id="titulo" placeholder="Nome do Grupo" required="true"/>
				<input type="text" name="descricao" id="descricao" placeholder="Descrição" required="true"/>
				<div class="botoes">
					<button type="submit">Salvar</button>
					<button type="reset" onclick="limpar()">Novo Grupo</button>
				</div>
			</form>

		</div>
		<div class="area_tabela_crud ">
			<table>
				<caption>Grupos</caption>
				<thead>
					<th>ID</th>
					<th>Grupo</th>
					<th>Descrição</th>
					<th>Ação</th>
				</thead>
				<tbody>
					<?php
						while($row = mysqli_fetch_array($rs)):
					?>
					<tr>
						<td rel="id"><?php echo $row['id']?></td>
						<td rel="titulo"><?php echo $row['titulo']?></td>
						<td rel="descricao"><?php echo $row['descricao']?></td>
						<td>
							<img onclick="editar(event)" src="<?php echo $caminhoURL; ?>assets/editar.png" title="Editar Grupo">
							<img onclick="excluir(event)" src="<?php echo $caminhoURL; ?>assets/delete.png" title="Excluir Grupo">
						</td>
					</tr>
					<?php
						endwhile;
					?>
				</tbody>
			</table>
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
		relacionar();
		$("#acao").val("2"); // Ação 2 = Editar
	}
	
	function excluir(event){
		var titulo = $(event.target).parent().parent().find("td[rel='titulo']").html();
		var r = confirm("Tem certeza que deseja excluir o grupo "+titulo+"?");
		
		if (r == true) {
			relacionar();
		    $("#acao").val("3"); // Ação 3 = Excluir
		    $("form#formulario").submit();
		} else {
		   //NADA
		}
	}
	
	function relacionar(){
		var pai = $(event.target).parent().parent();
		//relacionar
		$(pai).find("td").each(function(){
			var campo = $(this).attr("rel");
			//AdicionarValor
			$("form#formulario").find("#"+campo).val($(this).html());
		});
	}
	
	function visualizar(event){
		var pai = $(event.target).parent().parent();
		
		
	}
	
	$(".ajax").colorbox({width:"80%", height:"70%",className:"caixaBranca"});
</script>

<?php include "footer.php"; ?>