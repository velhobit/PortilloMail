<?php

	session_start();
	
	include_once("libs/config.php");
	if(isset($_SESSION["usuarioNome"])==null){
		header("location:".$caminhoURL."index.php");
	}
  	//Upload File
	if (isset($_FILES['arquivoCSV'])) {
		if (is_uploaded_file($_FILES['arquivoCSV']['tmp_name'])) {
			echo ("O arquivo foi enviado com sucesso.<br/>");
		}else{
			die ("Arquivo Não Pôde Ser Enviado ao Servidor.");
		}

		//Import uploaded file to Database
		$handle = fopen($_FILES['arquivoCSV']['tmp_name'], "r");
		
		$total = 0;
		$sucesso = 0;
		$erros = 0;
		$repetidos = 0;

		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			
			$strSQL = "SELECT email,aut FROM contatos WHERE email='".$data[0]."' AND grupo='".$_REQUEST['grupo']."' LIMIT 1;";
			$strRes = mysqli_query($con,$strSQL);
			if(mysqli_num_rows($strRes) == 0){
				$sql="INSERT INTO contatos(email,nome,telefone,grupo,aut) values('$data[0]','$data[1]','$data[2]','".$_REQUEST['grupo']."',1)";

				$result = mysqli_query($con,$sql);
				if($result){
					$sucesso ++;
				}else{
					$erros++;
				}
			}else{
				$erros++;
				$repetidos++;
			}
			
			$total ++;
		}

		echo "Importação finalizada com:<br/> " ;
		if($sucesso > 0){
			echo $sucesso ." sucessos; <br/>";
		}
		if($erros > 0){
			echo $erros .  " erros";
			if($repetidos >0){
				echo ", sendo que " . $repetidos . " foram causados por emails repetidos";
			}
			echo ".<br/>";
		}
		
		fclose($handle);
		//view upload form
	}else {
		echo "Erro na Importação";
	}
?>