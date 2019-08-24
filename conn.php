<?php
	$endereco = "localhost";
	$login = "root";
	$senha = "usbw";
	$banco = "db_loja";
	$mysqli = new mysqli($endereco, $login, $senha, $banco);
	if(mysqli_connect_errno()){
		echo $mysqli->mysql_error();
	}
	$mysqli->set_charset("utf8");
?>