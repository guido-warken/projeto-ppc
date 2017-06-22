<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirCurso(string $curnome, string $curtit, int $eixcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoCurso = $conn->prepare ( "insert into curso (curnome, curtit, eixcod) values (:curnome, :curtit, :eixcod)" );
	$insercaoCurso->bindParam ( ":curnome", $curnome );
	$insercaoCurso->bindParam ( ":curtit", $curtit );
	$insercaoCurso->bindParam ( ":eixcod", $eixcod );
	$resultado = $insercaoCurso->execute ();
	return $resultado;
}
function buscarCursosPorEixo(PDO &$conn = null): array {
	$informacoescurso = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->query ( "select curso.curcod, curso.curnome, curso.curtit, eixotec.eixdesc from curso inner join eixotec on curso.eixcod = eixotec.eixcod" );
	if (! $consultacurso->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () > 0) {
		for($i = 0; $i < $consultacurso->rowCount (); $i ++) {
			$informacoescurso [$i] = $consultacurso->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoescurso;
}
function buscarCursoPorId(int $curcod, PDO &$conn = null): array {
	$informacoescurso = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->prepare ( "select * from curso where curcod = :curcod" );
	$consultacurso->bindParam ( ":curcod", $curcod );
	if (! $consultacurso->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () == 1) {
		$informacoescurso = $consultacurso->fetch ( PDO::FETCH_ASSOC );
	}
	return $informacoescurso;
}
function buscarTodosOsCursos(PDO &$conn = null): array {
	$informacoescurso = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->query ( "select * from curso" );
	if (! $consultacurso->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () > 0) {
		for($i = 0; $i < $consultacurso->rowCount (); $i ++) {
			$informacoescurso [$i] = $consultacurso->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoescurso;
}
function atualizarCurso(string $curnome, string $curtit, int $eixcod, int $curcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaocurso = $conn->prepare ( "update curso set curnome = :curnome, curtit = :curtit, eixcod = :eixcod where curcod = :curcod" );
	$atualizacaocurso->bindParam ( ":curnome", $curnome );
	$atualizacaocurso->bindParam ( ":curtit", $curtit );
	$atualizacaocurso->bindParam ( ":eixcod", $eixcod );
	$atualizacaocurso->bindParam ( ":curcod", $curcod );
	$resultado = $atualizacaocurso->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirCurso(int $curcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delcurso = $conn->prepare ( "delete from curso where curcod = :curcod" );
	$delcurso->bindParam ( ":curcod", $curcod );
	$resultado = $delcurso->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarCursoPorPpc(PDO &$conn = null): array {
	$informacoescurso = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->query ( "select curso.curcod, curso.curnome from curso inner join ppc on curso.curcod = ppc.curcod" );
	if (! $consultacurso->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () > 0) {
		for($i = 0; $i < $consultacurso->rowCount (); $i ++) {
			$informacoescurso [$i] = $consultacurso->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoescurso;
}
function buscarCursosExceto(int $curcod, PDO &$conn = null): array {
	$informacoescurso = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->prepare ( "select * from curso where curcod <> :curcod" );
	$consultacurso->bindParam ( ":curcod", $curcod );
	if (! $consultacurso->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoescurso;
	} elseif ($consultacurso->execute () && $consultacurso->rowCount () > 0) {
		for($i = 0; $i < $consultacurso->rowCount (); $i ++) {
			$informacoescurso [$i] = $consultacurso->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoescurso;
}

?>