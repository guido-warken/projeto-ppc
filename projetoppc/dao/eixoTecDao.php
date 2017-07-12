<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirEixoTecnológico(string $eixdesc, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoeixotec = $conn->prepare ( "insert into eixotec (eixdesc) values (:eixdesc)" );
	$insercaoeixotec->bindParam ( ":eixdesc", $eixdesc );
	$resultado = $insercaoeixotec->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarEixoTecnologico(int $eixcod, string $eixdesc, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaoeixotec = $conn->prepare ( "update eixotec set eixdesc = :eixdesc where eixcod = :eixcod" );
	$atualizacaoeixotec->bindParam ( ":eixdesc", $eixdesc );
	$atualizacaoeixotec->bindParam ( ":eixcod", $eixcod );
	$resultado = $atualizacaoeixotec->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirEixoTecnologico(int $eixcod): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$deleixotec = $conn->prepare ( "delete from eixotec where eixcod = :eixcod" );
	$deleixotec->bindParam ( ":eixcod", $eixcod );
	$resultado = $deleixotec->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarEixosTecnologicos(PDO &$conn = null): array {
	$informacoeseixotec = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaeixotec = $conn->query ( "select * from eixotec" );
	if ($consultaeixotec->execute ()) {
		$numregistros = $consultaeixotec->rowCount ();
		if ($numregistros > 0) {
			for($i = 0; $i < $numregistros; $i ++) {
				$informacoeseixotec [$i] = $consultaeixotec->fetch ( PDO::FETCH_ASSOC );
			}
		} else {
			desconectarDoBanco ( $conn );
			return $informacoeseixotec;
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoeseixotec;
}
function buscarEixoTecnologicoPorId(int $eixcod, PDO &$conn = null): array {
	$informacoeseixotec = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaeixotec = $conn->prepare ( "select * from eixotec where eixcod = :eixcod" );
	$consultaeixotec->bindParam ( ":eixcod", $eixcod );
	if ($consultaeixotec->execute ()) {
		$numregistros = $consultaeixotec->rowCount ();
		if ($numregistros == 1) {
			$informacoeseixotec = $consultaeixotec->fetch ( PDO::FETCH_ASSOC );
		} else {
			desconectarDoBanco ( $conn );
			return $informacoeseixotec;
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoeseixotec;
}
function buscarEixosTecnologicosExceto(int $eixcod, PDO &$conn = null): array {
	$informacoeseixotec = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaeixotec = $conn->prepare ( "select * from eixotec where eixcod <> :eixcod" );
	$consultaeixotec->bindParam ( ":eixcod", $eixcod );
	if ($consultaeixotec->execute ()) {
		$numregistros = $consultaeixotec->rowCount ();
		if ($numregistros > 0) {
			for($i = 0; $i < $numregistros; $i ++) {
				$informacoeseixotec [$i] = $consultaeixotec->fetch ( PDO::FETCH_ASSOC );
			}
		} else {
			desconectarDoBanco ( $conn );
			return $informacoeseixotec;
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoeseixotec;
}

?>