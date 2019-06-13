<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url https://velhobit.com.br
	******************************/
	
	include "header.php";
	include "libs/conexao.php";        //Conexão com o banco de dados.
	include "functions.php";
	
	$edicao = false;
	$dadosMensagem = [];
	
	if(isset($_REQUEST["id_mail"])){
		$id = $_REQUEST["id_mail"];
		$strMail = "SELECT * FROM mensagens WHERE id='$id'";
		$rs = mysqli_query($con,$strMail);
		$dadosMensagem = mysqli_fetch_array($rs);
		
		//Registrar Atualização
		$sql = "UPDATE mensagens SET data_atualizacao='".$horarioEnvio."' WHERE id='$id';";
        $rs = mysqli_query($con,$sql);
        //Obs. Sim, eu sei que deve ser feita apenas após a confirmação. Mas no momento isso não é prioridade.
		
		$edicao = true;
	}
?>
<div class="wrap confirma">
	<h1>Enviar Email <b><?php echo $id; ?></b></h1>
	<div class="emails">
	<form name="formulario" action="confirma.php" method="POST" id="emails"  onsubmit="return validarCampos()">
		<div class="enviarEmail">
			<div class="crud">
			<?php if(isset($_REQUEST["id_mail"])):?>
			<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<?php endif;?>
			<select name="origem" id="origem">
				<option value="0">Selecione o email de Envio</option>
				<?php
					$strSQL = "SELECT * FROM usuarios";//Query da Tabela Grupos
					$rs = mysqli_query($con,$strSQL);
				?>
				<?php while($row = mysqli_fetch_array($rs)):?>
                	<?php if($row['id']==$dadosMensagem['email_envio']):?>
                   		<option name="emailEnvio" value="<?php echo $row['id']; ?>" title="<?php echo $row['obs']; ?>" selected><?php echo $row['nome']; ?> - <?php echo $row['email']; ?></option>
                    <?php else:?>
						<option name="emailEnvio" value="<?php echo $row['id']; ?>" title="<?php echo $row['obs']; ?>" ><?php echo $row['nome']; ?> - <?php echo $row['email']; ?></option>
                    <?php endif;?>
				<?php endwhile; ?>
			</select>
			<select name="grupo" id="grupo">
				<option value="0">Selecione o Grupo</option>
				<?php
					$strSQL = "SELECT * FROM grupos";//Query da Tabela Grupos
					$rs = mysqli_query($con,$strSQL);
				?>
				<?php while($row = mysqli_fetch_array($rs)):?>
                	<?php if($row['id']==$dadosMensagem['grupos']):?>
					<option name="selecionarGrupo" value="<?php echo $row['id']; ?>" selected><?php echo $row['titulo']; ?></option>
                    <?php else:?>
                    <option name="selecionarGrupo" value="<?php echo $row['id']; ?>"><?php echo $row['titulo']; ?></option>
                    <?php endif;?>
					
				<?php endwhile; ?>
				<option value="todos">Todos os Grupos</option>
			</select>
            <?php if ($edicao):?>
				<input id="emails_adicionais" name="emails_adicionais" class="emails" placeholder="Insira Emails Adicionais (separado por ',')" value="<?php echo $dadosMensagem['emails_adicionais']?>"/>
				<input id="assunto" type="text" name="assunto" placeholder="Digite o Assunto do Email" value="<?php echo $dadosMensagem['assunto']?>"/>
				<div class="botoes">
					<button onclick="enviar()">Enviar</button>
					<!--<button type="reset">Limpar Tudo</button>-->
				</div>
			</div>
			<div class="area_mensagem">
				<textarea id="mensagem" name="mensagem" class="textarea" placeholder="Escreva Sua Mensagem">
                <?php echo $dadosMensagem['mensagem']?>
				</textarea>
			</div>
            <?php else:?>
            	<input id="emails_adicionais" name="emails_adicionais" class="emails" placeholder="Insira Emails Adicionais (separado por ',')" />
				<input id="assunto" type="text" name="assunto" placeholder="Digite o Assunto do Email"/>
				
				<div class="botoes">
					<button onclick="enviar()">Enviar</button>
					<!--<button type="reset">Limpar Tudo</button>-->
				</div>
			</div>
			<div class="area_mensagem">
				<textarea id="mensagem" name="mensagem" class="textarea" placeholder="Escreva Sua Mensagem">
				</textarea>
			</div>
            <?php endif;?>
            
            
		</div>

	</form>
		<iframe id="form_target" name="form_target" style="display:none"></iframe>
		<form id="uploadForm" action="postAcceptor.php" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
			<input name="image" type="file"  accept="image/*"  onchange="$('#uploadForm').submit();this.value='';">
		</form>
	</div>
	
</div>
<?php
	include "footer.php";
	?>