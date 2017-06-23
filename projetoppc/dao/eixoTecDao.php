<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function buscarEixos(PDO &$conn = null): array {
	$informacoeseixotec = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaeixotec = $conn->query ( "select * from eixotec" );
	if (! $consultaeixotec->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoeseixotec;
	} elseif ($consultaeixotec->execute () && $consultaeixotec->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoeseixotec;
	} elseif ($consultaeixotec->execute () && $consultaeixotec->rowCount () > 0) {
		for($i = 0; $i < $consultaeixotec->rowCount (); $i ++) {
			$informacoeseixotec [$i] = $consultaeixotec->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoeseixotec;
}
function buscarEixoPorId(int $eixcod, PDO &$conn = null): array {
	$informacoeseixotec = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaeixotec = $conn->prepare ( "select * from eixotec where eixcod = :eixcod" );
	$consultaeixotec->bindParam ( ":eixcod", $eixcod );
	if (! $consultaeixotec->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoeseixotec;
	} elseif ($consultaeixotec->execute () && $consultaeixotec->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoeseixotec;
	} elseif ($consultaeixotec->execute () && $consultaeixotec->rowCount () == 1) {
		$informacoeseixotec = $consultaeixotec->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoeseixotec;
}
function buscarEixosexceto(int $eixcod, PDO &$conn = null): array {
	$informacoeseixotec = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaeixotec = $conn->prepare ( "select * from eixotec where eixcod <> :eixcod" );
	$consultaeixotec->bindParam ( ":eixcod", $eixcod );
	if (! $consultaeixotec->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoeseixotec;
	} elseif ($consultaeixotec->execute () && $consultaeixotec->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoeseixotec;
	} elseif ($consultaeixotec->execute () && $consultaeixotec->rowCount () > 0) {
		for($i = 0; $i < $consultaeixotec->rowCount (); $i ++) {
			$informacoeseixotec [$i] = $consultaeixotec->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoeseixotec;
}

?>