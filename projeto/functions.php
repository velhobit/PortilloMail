<?php
	
	/**
	* Incluir Dados em uma Tabela
	**/
	function incluir($tabela, $campos, $dados){
		$sql = "INSERT INTO $tabela ($campos) VALUES ($dados);";
		$result = mysql_query($sql, $con); //Executar a SQL
		return $result;
	}
	
	/**
	* Atualizar Dados em uma Tabela
	**/
	function atualizar($tabela,$atualizacoes, $id){
		$sql = "UPDATE $tabela SET $atualizacoes WHERE id = '$id';";
		$result = mysql_query($sql, $con); //Executar a SQL
		return $result;
	}
	
	/**
	* Excluir Dados em uma Tabela
	**/
	function excluir($tabela, $id){
		$sql = "DELETE FROM $tabela WHERE id = '$id';";
		$result = mysql_query($sql, $con); //Executar a SQL
		return $result;
	}
?>
<?php
	function novoGrupo($dados){
		$dadosStr  = "'".$dados["titulo"]."',";
		$dadosStr .= "'".$dados["descricao"]."'";
		
		incluir("grupos", "titulo,descricao", $dadosStr);
	}
	
	function atualizarGrupo($dados, $id){
		$dadosStr  = "titulo = '".$dados["titulo"]."',";
		$dadosStr .= "descricao = '".$dados["descricao"]."'";
		
		atualizar("grupos", $dadosStr, $id);
	}
	
	function novoMensagem($dados){
		$dadosStr  = "'".$dados["grupos"]."',";
		$dadosStr .= "'".$dados["emails_adicionais"]."',";
		$dadosStr .= "'".$dados["mensagem"]."',";
		$dadosStr .= "'".$dados["assunto"]."',";
		$dadosStr .= "'".$dados["email_envio"]."',";
		$dadosStr .= "'".$dados["status"]."',";
		$dadosStr .= "'".$dados["data_envio"]."',";
		$dadosStr .= "'".$dados["data_atualizacao"]."',";
		$dadosStr .= "'".$dados["obs"]."'";
		
		incluir("mensagens", "grupos,emails_adicionais,mensagem,assunto,email_envio,status,data_envio,data_atualizacao,obs", $dadosStr);
	}
	
	function atualizarMensagem($dados, $id){
		$dadosStr  = "grupos = '".$dados["grupos"]."',";
		$dadosStr .= "emails_adicionais = '".$dados["emails_adicionais"]."',";
		$dadosStr .= "mensagem = '".$dados["mensagem"]."',";
		$dadosStr .= "assunto = '".$dados["assunto"]."',";
		$dadosStr .= "email_envio = '".$dados["email_envio"]."',";
		$dadosStr .= "status = '".$dados["status"]."',";
		$dadosStr .= "data_envio = '".$dados["data_envio"]."',";
		$dadosStr .= "data_atualizacao = '".$dados["data_atualizacao"]."',";
		$dadosStr .= "obs = '".$dados["obs"]."'";
		
		atualizar("mensagens", $dadosStr, $id);
	}
	
	function novoSetor($dados){
		$dadosStr  = "'".$dados["nome"]."',";
		$dadosStr .= "'".$dados["email"]."',";
		$dadosStr .= "'".$dados["obs"]."'";
		
		incluir("setores", "nome,email,obs", $dadosStr);
	}
	
	function atualizarSetor($dados, $id){
		$dadosStr  = "nome = '".$dados["nome"]."',";
		$dadosStr .= "email = '".$dados["email"]."',";
		$dadosStr .= "obs = '".$dados["obs"]."'";
		
		atualizar("setores", $dadosStr, $id);
	}
	
	function novoUsuario($dados){
		$dadosStr  = "'".$dados["nome"]."',";
		$dadosStr .= "'".$dados["email"]."',";
		$dadosStr .= "'".$dados["setores"]."'";
		
		incluir("usuarios", "nome,email,setores", $dadosStr);
	}
	
	function atualizarUsuario($dados, $id){
		$dadosStr  = "nome = '".$dados["nome"]."',";
		$dadosStr .= "email = '".$dados["email"]."',";
		$dadosStr .= "setores = '".$dados["setores"]."'";
		
		atualizar("setores", $dadosStr, $id);
	}
	
	
	function criarSlug($url)
	{
	    # Prep string with some basic normalization
	    $url = strtolower($url);
	    $url = strip_tags($url);
	    $url = stripslashes($url);
	    $url = html_entity_decode($url);
	
	    # Remove quotes (can't, etc.)
	    $url = str_replace('\'', '', $url);
	
	    # Replace non-alpha numeric with hyphens
	    $match = '/[^a-z0-9]+/';
	    $replace = '-';
	    $url = preg_replace($match, $replace, $url);
	
	    $url = trim($url, '-');
	
	    return $url;
	}
	
	function gerarCancelamento($email){
		GLOBAL $con;
			$link = "";
		$link;
	}
?>