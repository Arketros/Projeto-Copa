<?php
	define('HOST', 'localhost:3306');
	define('USER', 'root');
	define('PASS', '');
	define('BASE', 'pedido_copa');

	$conn = new MySQLi(HOST, USER, PASS, BASE);

	// if($conn->connect_error){
	// 	die("Falha de conexão" . $conn->connect_error);
	// }else{
	// 	print "Conectou com sucesso!";
	// }