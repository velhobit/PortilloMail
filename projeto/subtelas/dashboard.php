<?php

	include "../libs/conexao.php";        //Conexão com o banco de dados.

	include "../functions.php";

	date_default_timezone_set('America/Sao_Paulo');

	$dt = new DateTime();

	if($horarioComercial_ini != ""){

		$horaAtual = $dt->format('H');

		if($horaAtual >= $horarioComercial_ini && $horaAtual <= $horarioComercial_fin){

			$emailsHora = $emailsHoraNaoComercial;

		}

	}

?>	

<?php
if(isset($_REQUEST["mensagem"])){
	$id_mensagem = $_REQUEST["mensagem"];
}else{
	$sql = "SELECT id FROM mensagens ORDER BY id DESC LIMIT 1";
	$rs = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($rs);
	$id_mensagem = $row[0];
}
?>


<div class="area" id="loadArea">

	<div class="wrap so_tabela">
		<style>
			.tabela h2{
				font-size: 1em;
				font-weight: normal;
				text-align: center;
				border-bottom: 1px solid #255ED1;
			}
			
			.tabela .pie{
				margin: 0 auto;
			}
			
			.tabela .tabs{
				display: flex;
				justify-content: space-between;
				
				margin-bottom: 40px;
			}
			
			.tabela .tabs .form{
				width: 400px;
			}
			
			.tabela .tabs .area{
				overflow: hidden;
				overflow-y: scroll;
				width: calc(100% - 500px);
				max-height: 400px;
			}
			
			.tabela .tabs table{
				
			}
			
			.tabela .tabs .vermelho{
				background-color: #FCE3E3;
			}
			.tabela .tabs .verde{
				background-color: #DAFFF3;
			}
			.tabela .tabs .amarelo{
				background-color: #F8FFDD;
			}
			.tabela .tabs .apenas{
				background-color: #C4DCFC;
			}
			
			.tabela .tabs tr{
				border-bottom: white 1px solid;
			}
			
			.relato{
				display: flex;
				justify-content: space-between;
			}
			
			.relato input[type=text]{
				width: 30%;
			}
			
			.relato  div{
				display: flex;
				justify-content: space-between;
			}
			
			.relato div label,.relato div input{
				width: auto;
				padding: 0;
				margin: 0;
			}
			
			.relato div label{
				margin-left: 5px;
			}
			
			.relato div input{
				margin-left: 1.5em;
				margin-top: 3.5px;
			}
		</style>
		<h1>Dashboard</h1>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<?php
			$mSql = "SELECT * FROM mensagens WHERE id='$id_mensagem' ";
			$mRs = mysqli_query($con,$mSql);   
			while($mRow = mysqli_fetch_array($mRs)):
		?>
			<div class="area_tabela">
				<div class="tabela">
					<h2><a target="_blank" href="emails/<?php echo $mRow['url']?>.html" title="Visualizar Email"><?php echo $mRow["id"]; ?> - <?php echo $mRow["assunto"]; ?><?php
					if($mRow['status'] == 0){

						$status = '<img src="'.$caminhoURL.'assets/alerta.png" title="Não Enviado"/>';

						$class = 'nao_enviado';

					}else if($mRow['status'] == 1){

						$status = '<img src="'.$caminhoURL.'assets/enviando.png" title="Ainda Enviando"/>';

						$class = 'enviando';

					}else if($mRow['status'] == 2){

						$status = '<img src="'.$caminhoURL.'assets/enviado.png" title="Emails Enviados Com Sucesso"/>';

						$class = 'enviado';

					}else if($mRow['status'] == 3){

						$status = '<img src="'.$caminhoURL.'assets/alerta.png" title="Erro ao Enviar"/>';

						$class = 'erro';

					}



					//Verifica se o Processo foi interrompido por algum motivo

					$processoInterrompido = false;

					if($mRow['status'] == 1){

	

						$agora = date('d-m-Y H:i:s');

						$segundos = 60/($emailsHora/60);

						

						$proxAtualizacao = strtotime($mRow['data_atualizacao'] . ' +'. ($segundos).' second');

						$proxAtualizacao = date('Y-m-d', $proxAtualizacao);

					

						if($proxAtualizacao < $agora){

							$processoInterrompido = true;

							$status = '<img src="'.$caminhoURL.'assets/alerta.png" title="Envio dos Interrompidos pelo Servidor. Clique em Continuar Envios para prosseguir."/>';

							$class = "erro";

						}
					}
				?></a></h2>
				    <script type="text/javascript">
					  google.charts.load('current', {'packages':['corechart']});
					  google.charts.setOnLoadCallback(drawChart<?php echo $mRow["id"]; ?>);
					  function drawChart<?php echo $mRow["id"]; ?>() {
						  <?php
						  	$sqlTotal = "SELECT (SELECT count(id) FROM restantes WHERE mensagem = '".$mRow["id"]."' AND enviado='1') as total,(SELECT count(id) FROM cliques WHERE mensagem = '".$mRow["id"]."') as clicados,(SELECT count(id) FROM cliques WHERE link LIKE '%cancelamento%'  AND mensagem = '".$mRow["id"]."' ) as cancelados,(SELECT count(id) FROM views WHERE mensagem = '".$mRow["id"]."' ) as visualizados;";
						  
						  	$tRs = mysqli_query($con,$sqlTotal);   
							while($tRow = mysqli_fetch_array($tRs)){
								$total = $tRow["total"];
								$clicados = $tRow["clicados"];
								$cancelados = $tRow["cancelados"];
								$visualizados = $tRow["visualizados"];
							}
						  	$apenasVisualizados = $visualizados - ($clicados + $cancelados);
						  	$ignorados = $total - $visualizados;
						  ?>
						var data = google.visualization.arrayToDataTable([
						  ['Total de Emails:', '<?php echo $total ?>'],
						  ['Apenas Visualizados',     <?php echo $apenasVisualizados; ?> ],
						  ['Cancelados',  <?php echo $cancelados ?>],
						  ['Ignorados',  <?php echo $ignorados ?>],
						  ['Clicados',      <?php echo $clicados ?>]
						]);

						var options = {
						  title: 'Total de Emails: <?php echo $total ?>'
						};

						var chart = new google.visualization.PieChart(document.getElementById('piechart<?php echo $mRow["id"]; ?>'));

						chart.draw(data, options);
					  }
					</script>
					<div class="relato">
					<?php //echo $sqlTotal; ?>
					<input type="text" id="input<?php echo $mRow["id"]; ?>" onkeyup="buscar(<?php echo $mRow["id"]; ?>,0)" placeholder="Busque por Email ou Domínio">
					<div class="opcoes">
						<div>
							<input type="radio" name="rr<?php echo $mRow["id"]; ?>" id="check<?php echo $mRow["id"]; ?>" rel="clicou" value="Clicou :D" onclick="filtrar(<?php echo $mRow["id"]; ?>,2,'')"/>
							<label for="check<?php echo $mRow["id"]; ?>">Abriu o Site</label>
						</div>
						<div>
							<input type="radio" name="rr<?php echo $mRow["id"]; ?>" id="check<?php echo $mRow["id"]; ?>a" value="Cancelou" onclick="filtrar('<?php echo $mRow["id"]; ?>',2,'a')"/>
							<label for="check<?php echo $mRow["id"]; ?>a">Cancelou</label>
						</div>
						<div>
							<input type="radio" name="rr<?php echo $mRow["id"]; ?>" id="check<?php echo $mRow["id"]; ?>b" value="Abriu Web" onclick="filtrar('<?php echo $mRow["id"]; ?>',2,'b')"/>
							<label for="check<?php echo $mRow["id"]; ?>b">Não conseguiu abrir no Email</label>
						</div>
						<div>
							<input type="radio" name="rr<?php echo $mRow["id"]; ?>" id="check<?php echo $mRow["id"]; ?>x" value="Apenas Visualizado" onclick="filtrar('<?php echo $mRow["id"]; ?>',2,'x')"/>
							<label for="check<?php echo $mRow["id"]; ?>x">Apenas Viu</label>
						</div>
						<div>
							<input type="radio" name="rr<?php echo $mRow["id"]; ?>" id="check<?php echo $mRow["id"]; ?>x" value="Ignorado" onclick="filtrar('<?php echo $mRow["id"]; ?>',2,'x')"/>
							<label for="check<?php echo $mRow["id"]; ?>x">Ignorados</label>
						</div>
						<div>
							<input type="radio" name="rr<?php echo $mRow["id"]; ?>" id="check<?php echo $mRow["id"]; ?>c" value="" onclick="filtrar('<?php echo $mRow["id"]; ?>',2,'c')"/>
							<label for="check<?php echo $mRow["id"]; ?>c">Todos</label>
						</div>
						</div>
				</div>
					<div class="tabs">
					<div class="form">
						<div id="piechart<?php echo $mRow["id"]; ?>" style="width: 500px; height: 435px;" class="pie"></div>
					</div>
					<div class="area">
						<table id="tabela<?php echo $mRow["id"]; ?>">
							<thead>
								<th>Email</th>
								<th>Link</th>
								<th>Status</th>
								<th>Data/Hora</th>
							</thead>
							<tbody>
								<?php
									$cSql = "SELECT * FROM cliques WHERE mensagem = '".$mRow["id"]."' GROUP BY contato ORDER BY link;";
									$cRs = mysqli_query($con,$cSql);   
									while($cRow = mysqli_fetch_array($cRs)):

									$estilo = "";
									$status = "";
									if (strpos($cRow["link"], 'cancelamento.php') !== false) {
										$estilo = "vermelho";
										$status = "Cancelou";
										$cRow["link"] = "-";
									}
									else if (strpos($cRow["link"], '/emails/') !== false) {
										$estilo = "amarelo";
										$status = "Abriu Web";
										$cRow["link"] = "-";
									}else{
										$estilo = "verde";
										$status = "Clicou :D";
									}
								?>
								<tr class="<?php echo $estilo?>">
									<td><?php echo $cRow["contato"];?></td>
									<td><?php echo $cRow["link"];?></td>
									<td><?php echo $status;?></td>
									<td><?php echo $cRow["data_hora"];?></td>
								</tr>
								<?php endwhile; ?>
								<?php
									$cSql = "SELECT *
											FROM views v
											WHERE mensagem = '".$mRow["id"]."'
											AND NOT EXISTS
											(SELECT 1 FROM cliques r WHERE v.contato = r.contato AND  mensagem = '".$mRow["id"]."') GROUP BY v.contato;";
								//echo $cSql;
									$cRs = mysqli_query($con,$cSql);   
									while($cRow = mysqli_fetch_array($cRs)):
								?>
								<tr class="apenas">
									<td><?php echo $cRow["contato"];?></td>
									<td> -- </td>
									<td>Apenas Visualizado</td>
									<td><?php echo $cRow["data_hora"];?></td>
								</tr>
								<?php endwhile; ?>
								<?php
									$cSql = "SELECT *
											FROM restantes v
											WHERE mensagem = '".$mRow["id"]."'
											AND NOT EXISTS
											(SELECT 1 FROM cliques r WHERE v.email = r.contato AND  mensagem = '".$mRow["id"]."')
											AND NOT EXISTS
											(SELECT 1 FROM views r WHERE v.email = r.contato AND  mensagem = '".$mRow["id"]."') GROUP BY v.email;";
								//echo $cSql;
									$cRs = mysqli_query($con,$cSql);   
									while($cRow = mysqli_fetch_array($cRs)):
								?>
								<tr style="opacity: .85;">
									<td><?php echo $cRow["email"];?></td>
									<td> -- </td>
									<td>Ignorado</td>
									<td> -- </td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
					<!--<table>
						<thead>
							<th>Email</th>
							<th>Hora</th>
						</thead>
						<tbody>
							<?php
								$cSql = "SELECT * FROM views WHERE mensagem = '".$mRow["id"]."' GROUP BY contato ORDER BY data_hora;";
								$cRs = mysqli_query($con,$cSql);   
								while($cRow = mysqli_fetch_array($cRs)):
							?>
							<tr>
								<td><?php echo $cRow["contato"];?></td>
								<td><?php echo $cRow["data_hora"];?></td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>-->
					</div>
				</div>
			</div>
		<?php
			endwhile;
		?>
	</div>
</div>
<script>
function buscar(id,col) {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("input"+id);
  filter = input.value.toUpperCase();
  table = document.getElementById("tabela"+id);
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[col];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
	
function filtrar(id,col,el) {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("check"+id+el);
  filter = input.value.toUpperCase();
  table = document.getElementById("tabela"+id);
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[col];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
	
	$("input[rel='clicou']").trigger("click");
</script>
<?php

	//include "footer.php";

	?>