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


$(".ajax").colorbox({width:"80%", height:"70%",className:"caixaBranca",close:"Fechar"});

function reeditar(id){
	$("form#formulario").find("#id_mail").val(id);
	$("form#formulario").submit();
}

function deletar(id){
	var r = confirm("Você tem certeza que quer excluir permanentemente a mensagem de ID: "+id+"?");
	if (r == true) {
		$("form#excluir").find("#id_men").val(id);
		$("form#excluir").submit();
	} else {
		alert("A mensagem NÃO foi apagada");
	}
}

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
		theme: "modern",
		language: "pt_BR",
		height: "500",
		width: "100%",
		convert_fonts_to_spans: false,
		forced_root_block: false,
		convert_urls: false,
		file_browser_callback: function(field_name, url, type, win) {
            if(type=='image') $('#uploadForm input').click();
        },
		imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
		plugins: ["autolink lists link image charmap preview anchor searchreplace code table contextmenu paste imagetools"],
	   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview emoticons"
	});
} 	


function enviar(){
	$("#mensagem").val(tinyMCE.activeEditor.getContent());
	$("form#emails").submit();
	return false;
}

editor();
sumirALerta();