<?php
	/*****************************
		PortilloMail
		Projeto Iniciado por Rodrigo Portillo em 2015
		Projeto colocado sob Licença Mozilla
		@author Rodrigo Portillo
		@url http://portillodesign.com.br/projeto-mail/
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
	<h1>Enviar Email <?php echo " - ".$id; ?></h1>
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
				<option value="0">Todos os Grupos</option>
			</select>
            <?php if ($edicao):?>
				<input id="emails_adicionais" name="emails_adicionais" class="emails" placeholder="Insira Emails Adicionais (separado por ',')" value="<?php echo $dadosMensagem['emails_adicionais']?>"/>
				<input id="assunto" type="text" name="assunto" placeholder="Digite o Assunto do Email" value="<?php echo $dadosMensagem['assunto']?>"/>
				<div class="botoes">
					<button onclick="enviar()">Enviar</button>
					<button type="reset">Limpar Tudo</button>
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
					<button type="reset">Limpar Tudo</button>
				</div>
			</div>
			<div class="area_mensagem">
				<textarea id="mensagem" name="mensagem" class="textarea" placeholder="Escreva Sua Mensagem">
				</textarea>
			</div>
            <?php endif;?>
		</div>

	</form>
	</div>
	
</div>
<script type="text/javascript">
    
    function validarCampos(){
        var mensagem = "Os seguintes campos estão com erro: \n", valido = true;
        if (formulario.origem.value=="0"){
            mensagem += "O campo Selecionar Email de Envio está vazio.";
            valido = false;
        }
        
        if (formulario.grupo.value=="0"){
           mensagem += "O campo Selecionar Grupo está vazio.";
            valido = false;
        }
        
        if (!valido){
            alert(mensagem);
            return false;
        }
        
    }
    
    function editor(){
		//Inicializar instância
		tinymce.init({
		    selector: "textarea#mensagem",
            relative_urls : false,
            remove_script_host : false,
            document_base_url : "http://www.najaturismo.com.br/mail",
		    theme: "modern",
		    language: "pt_BR",
		    height: "450px",
		    width: "700px",
            extended_valid_elements:"",
            convert_fonts_to_spans: false,
            forced_root_block: false,
            convert_urls: false,
            images_upload_url: "postAcceptor.php",
            images_upload_base_path: "/emails/imagens",
            valid_elements: "*[*]",
            paste_data_images: true,
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
		    plugins: ["advlist autolink lists link image charmap print preview anchor",
							"searchreplace visualblocks code fullscreen",
							"insertdatetime media table contextmenu paste imagetools"],
		   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
		});
	} 	
	editor();
	
	
	
	
	function enviar(){
		$("#mensagem").val(tinyMCE.activeEditor.getContent());
		$("form#emails").submit();
		return false;
	}
</script>
<?php
	include "footer.php";
	?>