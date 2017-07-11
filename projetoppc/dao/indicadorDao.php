<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirIndicador(string $inddesc, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoindicador = $conn->prepare ( "insert into indicador (inddesc) values (:inddesc)" );
	$insercaoindicador->bindParam ( ":inddesc", $inddesc );
	$resultado = $insercaoindicador->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarIndicador(int $indcod, string $inddesc, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaoindicador = $conn->prepare ( "update indicador set inddesc = :inddesc where indcod = :indcod" );
	$atualizacaoindicador->bindParam ( ":inddesc", $inddesc );
	$atualizacaoindicador->bindParam ( ":indcod", $indcod );
	$resultado = $atualizacaoindicador->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirIndicador(int $indcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delindicador = $conn->prepare ( "delete from indicador where indcod = :indcod" );
	$delindicador->bindParam ( ":indcod", $indcod );
	$resultado = $delindicador->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarIndicadorPorId(int $indcod, PDO &$conn = null): array {
	$informacoesindicador = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaindicador = $conn->prepare ( "select * from indicador where indcod = :indcod" );
	$consultaindicador->bindParam ( ":indcod", $indcod );
	if (! $consultaindicador->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesindicador;
	} elseif ($consultaindicador->execute () && $consultaindicador->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesindicador;
	} elseif ($consultaindicador->execute () && $consultaindicador->rowCount () == 1) {
		$informacoesindicador = $consultaindicador->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoesindicador;
}
function buscarIndicadores(PDO &$conn = null): array {
	$informacoesindicador = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaindicador = $conn->query ( "select * from indicador " );
	if ($consultaindicador->execute ()) {
		$total = $consultaindicador->rowCount ();
		if ($total > 0) {
			for($i = 0; $i < $total; $i ++) {
				$informacoesindicador [$i] = $consultaindicador->fetch ( PDO::FETCH_ASSOC );
			}
		} else {
			desconectarDoBanco ( $conn );
			return $informacoesindicador;
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesindicador;
}
?>