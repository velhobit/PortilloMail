<!--	<div class="alerta" id="alerta">
		<h3></h3>
		<div class="conteudo" id="conteudo">
		</div>
		<div class="botoes">
			<button id="sim">
			Sim
			</button>
			<button id="nao" onclick="sumirALerta()">
			Não
			</button>
		</div>
	</div>-->
	
	<script>
		function aparecerAlerta(titulo,conteudo){
			$("#alerta").css("top","80px");
			$("#alerta h3").html(titulo);
			$("#alerta #conteudo").html(conteudo);
		}
		
		function sumirALerta(){
			$("#alerta").css("top",$(document).height()+$("#alerta").height());
			$("#alerta h3").html("");
			$("#alerta #conteudo").html("");
		}
		
		sumirALerta();
		
	</script>
	<div class="powered" style="position: fixed;right: 5px;bottom: 5px;text-align: right;color:lightgrey;">
		<em>Powered By</em><a href="http://portillodesign.com.br" title="PortilloDesign" itemprop="url" target="_blank"><img style="height: 1.8em;
			margin-bottom:-13px;width: auto;" itemprop="logo" class="logo" src="http://portillodesign.com.br/imagens/portillodesign-logo.png" alt="Logo da PortilloDesign" title="PortilloDesign"></a><span itemprop="name">0.2.1</span>
	</div>
</body>