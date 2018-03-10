<?php

	session_start();
	
	include_once("libs/config.php");
	if(isset($_SESSION["usuarioNome"])==null){
		header("location:".$caminhoURL."index.php");
	}
  if(isset($_FILES)){
	   $image = $_FILES['image'];
	   $path = $_SERVER['DOCUMENT_ROOT'] . $pastaURL .'images/'; //Set your upload path here
	   $tmpName = $image['tmp_name'];
	   $ext = array_pop(explode('.',$image['name']));
	   $name = hash("crc32b", str_replace(' ','-',$image['name']));
		move_uploaded_file($tmpName, $path . '/'.$name.'.'.$ext);
	   $weburl = $caminhoURL.'images/'.$name.'.'.$ext;
	echo "<script>top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('". $weburl ."').closest('.mce-window').find('.mce-primary').click();</script>";
  }	
?>