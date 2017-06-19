<?php
function conectarAoBanco(string $host, string $nome_banco, string $nome_usuario, string $senha):PDO {
	$conn = new PDO("mysql:host=$host;dbname=$nome_banco;charset=utf8", $nome_usuario, $senha);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $conn;
}

function desconectarDoBanco(PDO &$connection) {
	$connection = null;
}

?>