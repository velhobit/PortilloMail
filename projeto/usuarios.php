<?php
	include "header.php";
	include "libs/conexao.php";        //Conexão com o banco de dados.
	include "functions.php";
?>
<?php
	//MANIPULAR ITENS
	
	$existe = 	isset($_REQUEST["nome"]) &&
				isset($_REQUEST['email']);

	if($existe){
		if($_REQUEST['acao'] == '2'){
			if(isset($_REQUEST['senha']) &&  $_REQUEST['senha'] != ""){
				$sql = "UPDATE usuarios SET nome='".$_REQUEST['nome']."',email='".$_REQUEST['email'].", senha='".md5($_REQUEST['senha']). "' WHERE id='".$_REQUEST['id']."';";
			}else if(isset($_REQUEST['senha']) &&  $_REQUEST['senha'] != "" && isset($_REQUEST["senha_email"])){
				$sql = "UPDATE usuarios SET nome='".$_REQUEST['nome']."',email='".$_REQUEST['email']."',senha_email='".$_REQUEST['senha_email']."' WHERE id='".$_REQUEST['id']."';";
			}else if((!isset($_REQUEST['senha']) || $_REQUEST['senha'] == "") && isset($_REQUEST["senha_email"])){
				$sql = "UPDATE usuarios SET nome='".$_REQUEST['nome']."',senha_email='".$_REQUEST['senha_email']."' WHERE id='".$_REQUEST['id']."';";
			}else{
				$sql = "UPDATE usuarios SET nome='".$_REQUEST['nome']."',email='".$_REQUEST['email']."' WHERE id='".$_REQUEST['id']."';";
			}
			$msg = "usuario ".$_REQUEST['nome']." Atualizado com Sucesso";
		}else if($_REQUEST['acao'] == '3'){
			$sql = "DELETE FROM usuarios WHERE id='".$_REQUEST['id']."';";
			$msg = "Usuario ".$_REQUEST['nome']." foi excluído";
		}
		else if($_REQUEST['acao'] == '1'){
			$sql = "INSERT INTO usuarios VALUES(DEFAULT,'".$_REQUEST['nome']."','".$_REQUEST['email']."','','".md5($_REQUEST['senha'])."','".$_REQUEST['senha_mail']."')";
			$msg = "Usuario ".$_REQUEST['nome']." foi inserido";
		}
		
		$rsSql = mysqli_query($con,$sql);
	}
?>
<?php
	//SELECIONAR ITENS PARA PREENCHER A GRID
	$strSQL = "SELECT * FROM usuarios ORDER BY nome";   //Variável que armazena strings para extrair os dados da tabela.
	$rs = mysqli_query($con,$strSQL);        //$rs = returnset. Retorno dos dados da tabela.
?>
<div class="wrap grupos">
	<!--Crud-->
	<h1>Cadastro de Usuários de Emails</h1>
	<?php
		if($rsSql && isset($_REQUEST["id"])){
			echo "<div class='alert wrap'>$msg</div><br/>";
		}else{
			//echo "<h2>Erro ao Atualizar o Cadastro de usuarios</h2><h3>".mysqli_error($con)."</h3>";
		}
	?>
	<div class="area_crud">
	<div class="crud">
		<form method="post" action="#" id="formulario">
			<input type="hidden" name="acao" id="acao" value="1"  />
			<input type="text" name="id" id="id" placeholder="ID" />
			<input type="text" name="nome"  id="nome" placeholder="Nome do Usuário" required="true"/>
			<input type="text" name="email" id="email" placeholder="Email de Envio" required="true"/>
            <input type="password" name="senha" id="senha" placeholder="Senha para Login do Sistema" />
            <input type="password" name="senha_email" id="senha_email" placeholder="Senha de Envio do Email (SMTP)"/>
			<div class="botoes">
				<button type="submit">Gravar</button>
				<button type="reset" onclick="limpar()">Novo</button>
			</div>
		</form>
		<div class='alert'>Obs. A senha de envio será salva sem criptografia no banco de dados. É aconselhável usar uma conta de email criada apenas para mailmarketing.</div>
	</div>
	<div class="area_tabela_crud">
		<div class="tabela">
	<table>
		<caption>Emails</caption>
		<thead>
			<th>ID</th>
			<th>Usuarios</th>
			<th>Email</th>
			<th>Acao</th>
            
		</thead>
		<tbody>
			<?php
				while($row = mysqli_fetch_array($rs)):
			?>
			<tr>
				<td rel="id"><?php echo $row['id']?></td>
				<td rel="nome"><?php echo $row['nome']?></td>
				<td rel="email"><?php echo $row['email']?></td>
				<td>
					<img onclick="editar(event)" src="<?php echo $caminhoURL; ?>assets/editar.png" title="Editar conta de Usuário"/>
					<img onclick="excluir(<?php echo $row['id']?>,'<?php echo $row['nome']?>')" src="<?php echo $caminhoURL; ?>assets/delete.png" title="Excluir Conta de Usuário"/>
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
</div>
<script>
	function limpar(){
		$("#acao").val("1");
	}
	
	function editar(event){
		relacionar(event);
		$("#acao").val("2"); // Ação 2 = Editar
	}
	
	function excluir(id,nome){
		var r = confirm("Tem certeza que deseja excluir o usuário "+nome+"?");
		
		if (r == true) {
			$("#id").val(id); // Ação 3 = Excluir
			$("#nome").val(nome);
		    $("#acao").val("3"); // Ação 3 = Excluir
		    $("form#formulario").submit();
		} else {
		   alert("O usuário "+ nome +"  NÃO foi excluído.");
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
		
		$("input[type=password]").val("");
	}
	
	function visualizar(event){
		var pai = $(event.target).parent().parent();
		
		
	}
	
	$(".ajax").colorbox({width:"80%", height:"70%",className:"caixaBranca"});
</script>

<?php include "footer.php"; ?>