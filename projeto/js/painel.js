/**
* Adicionar Evento de Clique para carregar o painel
* de acordo com a tag "rel"
*/
$("#menu ul li").each(function(){
	$(this).click(function(){
		$("#painel").css("opacity","0");
		$("#painel").load($(this).attr("rel")+".php",function(){
			$("#painel").css("opacity","1");
		});
	});
});