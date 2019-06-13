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
	protegePagina();
?>
<?php
	
	if($_REQUEST["url"]){

		$sql = "UPDATE config SET ";						
		$sql .= " url='".$_REQUEST['url']. "',";
		$sql .= " pasta='".$_REQUEST['pasta']. "',";
		$sql .= " nome_empresa='".$_REQUEST['nome_empresa']. "',";
		$sql .= " smtp='".$_REQUEST['smtp']. "',";
		$sql .= " porta='".$_REQUEST['porta']. "',";
		$sql .= " seguranca='".$_REQUEST['seguranca']. "',";
		$sql .= " autenticacao=".$_REQUEST['autenticacao']. ",";
		$sql .= " email_resposta='".$_REQUEST['email_resposta']. "',";
		$sql .= " nome_email_resposta='".$_REQUEST['nome_email_resposta']. "',";
		$sql .= " emails_por_hora='".$_REQUEST['emails_por_hora']. "',";
		$sql .= " emails_por_hora_nao_comercial='".$_REQUEST['emails_por_hora_nao_comercial']. "',";
		$sql .= " horario_comercial_ini='".$_REQUEST['horario_comercial_ini']. "';";
		$msg = "Dados de Configuração foram Atualizados com Sucesso. Por favor, aguarde que até que a página seja recarregada automaticamente.";
		
		//echo $sql;
		
		$rsSql = mysqli_query($con,$sql);
		 echo "<meta http-equiv='refresh' content='5'>";
		$_REQUEST["url"] = false;
		die("<div class='alert wrap'>$msg</div>");
	}
?>
<?php
	$strSQL = "SELECT * FROM config LIMIT 1";
	$rs = mysqli_query($con,$strSQL);

	while($row = mysqli_fetch_array($rs)){
		$cUrl = $row["url"];
		$cPasta = $row["pasta"];
		$cNomeEmpresa = $row["nome_empresa"];
		$cSmtp = $row["smtp"];
		$cPorta = $row["porta"];
		$cSeguranca = $row["seguranca"];
		$cAutenticacao = $row["autenticacao"];
		$cEmailResposta = $row["email_resposta"];
		$cNomeEmailResposta = $row["nome_email_resposta"];
		$cEmailsPorHora = $row["emails_por_hora"];
		$cEmailsPorHoraNaoComercial = $row["emails_por_hora_nao_comercial"];
		$cHorarioComercialIni = $row["horario_comercial_ini"];
		$cHorarioComercialFin = $row["horario_comercial_fin"];
	}
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
	<h1>Configurações de PortilloMail</h1>
	<div class="area_crud">
		<div class="crud">
			<form method="post" action="configuracoes.php" id="formulario">
				<input type="hidden" name="acao" id="acao" value="1"  />
				<input type="text" name="url"  id="url" placeholder="https://DigiteSeuSite.com.br" required="true" value="<?php echo  $cUrl ; ?>"/>
				<input type="text" name="pasta"  id="pasta" placeholder="Pasta onde está instalado o PortilloMail" required="true" value="<?php echo  $cPasta ; ?>"/>
				<input type="text" name="nome_empresa"  id="nome_empresa" placeholder="Nome da Empresa" required="true" value="<?php echo  $cNomeEmpresa;?>"/>
				<input type="text" name="smtp"  id="smtp" placeholder="Endereço STMP" required="true" value="<?php echo  $cSmtp;?>"/>
				<input type="text" name="porta"  id="porta" placeholder="Porta STMP" required="true" value="<?php echo $cPorta ;?>"/>
				<select name="seguranca" id="seguranca" placeholder="Tipo de Segurança" required value="<?php echo $cSeguranca ;?>">
					<option value="ssl" default>SSL</option>
					<option value="tls">TLS</option>
					<option value="">Nenhuma</option>
				</select>
				<select name="autenticacao" id="autenticacao" placeholder="Tipo de Autenticação" required value="<?php echo  $cAutenticacao;?>">
					<option value="1" default>Requer Autenticação</option>
					<option value="0">Não Requer Autenticação</option>
				</select>
				<input type="text" name="email_resposta"  id="email_resposta" placeholder="Email Padrão para Respostas" required="true" value="<?php echo $cEmailResposta ;?>"/>
				<input type="text" name="nome_email_resposta"  id="nome_email_resposta" placeholder="Nome Padrão para Respostas" required="true" value="<?php echo  $cNomeEmailResposta;?>"/>
				<input type="number" name="emails_por_hora"  id="emails_por_hora" placeholder="Emails Enviados por Hora" required="true" value="<?php echo  $cEmailsPorHora;?>"  min="0" />
				<input type="number" name="emails_por_hora_nao_comercial"  id="emails_por_hora_nao_comercial" placeholder="Emails Enviados por Hora Não Comercial" required="true" value="<?php echo  $cEmailsPorHoraNaoComercial;?>"  min="0" />
				<input type="number" name="horario_comercial_ini"  id="horario_comercial_ini" placeholder="Início do Horário Comercial (Brasília)" required="true" value="<?php echo  $cHorarioComercialIni;?>" min="0" max="23"/>
				<input type="number" name="horario_comercial_fin"  id="horario_comercial_fin" placeholder="Fim do Horário Comercial (Brasília)" required="true" value="<?php echo  $cHorarioComercialFin;?>"  min="0" max="23"/>
				<div class="botoes" >
					<button type="submit">Salvar</button>
				</div>
			</form>

		</div>
		<div class="area_tabela_crud ">
			<form class="importar" id="formCSV">
				<h3>Importar Arquivo CSV para os Contatos</h3>
				<select name="grupo" id="grupo">
					<option value="0" selected="selected" required>Selecione o Grupo</option>
					<?php
						//SELECIONAR ITENS PARA PREENCHER OS GRUPOS
						$strSQLGrupos = "SELECT * FROM grupos ORDER BY titulo ASC";   //Variável que armazena strings para extrair os dados da tabela.
						$rsGrupos = mysqli_query($con,$strSQLGrupos);        //$rs = returnset. Retorno dos dados da tabela.
						while($row = mysqli_fetch_array($rsGrupos)):
					?>
					<option value="<?php echo $row['id']?>"><?php echo $row['titulo']?></option>
				<?php
					endwhile;
				?>
				</select>
				<input type="file" name="arquivoCSV" id="arquivoCSV" accept="text/*"/>
				<button type="submit">Importar</button>
				<h4 class="retorno" id="retornoDados"></h4>
				<div class="instrucoes">
					<p><b>Instruções:</b></p>
					<p>Para importar corretamente os dados, importe o arquivo CSV separado por ";" (ponto e vírgula).</p>
					<p>Utilize o programa de planilhas de sua preferência (como Calc ou Excel) para facilitar a organização das colunas do seu arquivo CSV.</p>
					<p>
						Coloque as colunas nas seguintes ordens:<br/>
						<b>email;nome;telefone</b>
					</p>
					<p>Quando você importa os emails, automaticamente todos estarão autorizados para envio e disponíveis no grupo selecionado acima. Caso você queira utilizar o email em mais de um grupo, faça uma nova importação no grupo correspondente.
					</p>
					<p>
						Exemplo do Documento:
						<p class="pre">rodrigo@portillodesign.com.br;Rodrigo Portillo;81 986xx-xxxx<br/>yanka@portillodesign.com.br;Yanka;<br/>contato@portillodesign.com.br;;81 986xx-xxxx</p>
					</p>
					<p class="obs">
						Obs. Deixe vazio o campo que você não possua o dado. A importação passa por uma verificaçao de email, para que não sejam importados emails repetidos. Por isso, a importação pode demorar um pouco.
					</p>
					<p class="alert">
						NÃO IMPORTE DADOS ENQUANTO AINDA ESTIVER EM PROCESSO DE ENVIO DE EMAILS.<br/>
						Dependendo das configurações de sua hospedagem, ou servidor, isso pode deixa-lo lento ou cair.
					</p>
				</div>
			</form>
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
	$("#formCSV").submit(function(){
		if($("#grupo").val() == 0 || $("#arquivoCSV").val() == ''){
			alert("Selecione um Grupo e um Arquivo para Prosseguir");
		}else{
			var formData = new FormData(this);
			$("#retornoDados").html( "Enviando Dados. Por favor Aguarde." );	

			$.ajax({
			  method: "POST",
			  url: "importCSV.php",
			  data: formData,
				cache: false,
				contentType: false,
				processData: false,
				xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
					myXhr.upload.addEventListener('progress', function () {
						/* faz alguma coisa durante o progresso do upload */
					}, false);
					}
				return myXhr;
				}
			})
			.done(function( msg ) {
				$("#retornoDados").html( msg );
				$("#formCSV")[0].reset();
			});
		}
		return false;
	});
</script>

<?php include "footer.php"; ?>