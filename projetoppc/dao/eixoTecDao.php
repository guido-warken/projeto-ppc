<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function buscarEixos(PDO &$conn):PDOStatement {
	if (is_null($conn))
		$conn = conectarAoBanco("localhost", "dbdep", "root", "");
	$consulta = $conn->prepare("select * from eixotec");
	return $consulta;
}

function buscarEixoPorId(PDO &$conn, int $eixcod):PDOStatement {
	if (is_null($conn))
		$conn = conectarAoBanco("localhost", "dbdep", "root", "");
	$consulta = $conn->prepare("select * from eixotec where eixcod = :eixcod");
	$consulta->bindParam(":eixcod", $eixcod);
	return $consulta;
}

function buscarEixosexceto(PDO &$conn, int $eixcod):PDOStatement {
	if (is_null($conn))
		$conn = conectarAoBanco("localhost", "dbdep", "root", "");
	$consulta = $conn->prepare("select * from eixotec where eixcod <> :eixcod");
$consulta->bindParam(":eixcod", $eixcod);
return $consulta;
}


?>