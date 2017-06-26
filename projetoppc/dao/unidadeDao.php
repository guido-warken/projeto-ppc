<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirUnidade(string $uninome, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaounidade = $conn->prepare ( "insert into unidadesenac (uninome) values (:uninome)" );
	$insercaounidade->bindParam ( ":uninome", $uninome );
	$resultado = $insercaounidade->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarUnidade(int $unicod, string $uninome, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaounidade = $conn->prepare ( "update unidadesenac set uninome = :uninome where unicod = :unicod" );
	$atualizacaounidade->bindParam ( ":uninome", $uninome );
	$atualizacaounidade->bindParam ( ":unicod", $unicod );
	$resultado = $atualizacaounidade->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirUnidade(int $unicod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delunidade = $conn->prepare ( "delete from unidadesenac where unicod = :unicod" );
	$delunidade->bindParam ( ":unicod", $unicod );
	$resultado = $delunidade->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarUnidadePorId(int $unicod, PDO &$conn = null): array {
	$informacoesunidade = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaunidade = $conn->prepare ( "select * from unidadesenac where unicod = :unicod" );
	$consultaunidade->bindParam ( ":unicod", $unicod );
	if (! $consultaunidade->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () == 1) {
		$informacoesunidade = $consultaunidade->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoesunidade;
}
function buscarUnidades(PDO &$conn = null): array {
	$informacoesunidade = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaunidade = $conn->query ( "select * from unidadesenac" );
	if (! $consultaunidade->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () > 0) {
		for($i = 0; $i < $consultaunidade->rowCount (); $i ++) {
			$informacoesunidade [$i] = $consultaunidade->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesunidade;
}
function buscarUnidadesPorPdi(PDO &$conn = null): array {
	$informacoesunidade = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaunidade = $conn->query ( "select unidadesenac.unicod, unidadesenac.uninome from unidadesenac inner join pdi on unidadesenac.unicod = pdi.unicod" );
	if (! $consultaunidade->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () > 0) {
		for($i = 0; $i < $consultaunidade->rowCount (); $i ++) {
			$informacoesunidade [$i] = $consultaunidade->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesunidade;
}
function buscarUnidadesExceto(int $unicod, PDO &$conn = null): array {
	$informacoesunidade = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaunidade = $conn->prepare ( "select * from unidadesenac where unicod <> :unicod" );
	$consultaunidade->bindParam ( ":unicod", $unicod );
	if (! $consultaunidade->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () > 0) {
		for($i = 0; $i < $consultaunidade->rowCount (); $i ++) {
			$informacoesunidade [$i] = $consultaunidade->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesunidade;
}
function buscarUnidadesPorOferta(PDO &$conn = null): array {
	$informacoesunidade = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaunidade = $conn->query ( "select * from unidadesenac inner join oferta on unidadesenac.unicod = oferta.unicod" );
	if (! $consultaunidade->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesunidade;
	} elseif ($consultaunidade->execute () && $consultaunidade->rowCount () > 0) {
		for($i = 0; $i < $consultaunidade->rowCount (); $i ++) {
			$informacoesunidade [$i] = $consultaunidade->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesunidade;
}

?>