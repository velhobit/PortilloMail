<!DOCTYPE>
<?php if(isset($_REQUEST['email']) && isset($_REQUEST['acao'])):?>
<?php
	include "libs/conexao.php";        //Conexão com o banco de dados.
	include "functions.php";
	$sql = "UPDATE contatos SET aut='0' WHERE email='".$_REQUEST['email']."';";
    $rs = mysqli_query($con,$sql);
	?>
	<center>
		<?php echo $_REQUEST['email']; ?> retirado de nossa base.
	</center>
<?php else:?>
	<center>
		<h2>Deseja realmente remover o seu email de nossa base de dados?</h2>
		<form action="#" method="post">
			<input type="hidden" name="acao" value='1'/>
			<input type="email" name="email" value="<?php echo $_REQUEST['email']; ?>" />
			<button type="submit">Confirmar</button>
		</form>
	</center>
<?php endif;?>