<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirCurso(PDO &$conn, string $curnome, string $curtit, int $eixcod): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoCurso = $conn->prepare ( "insert into curso (curnome, curtit, eixcod) values (:curnome, :curtit, :eixcod)" );
	$insercaoCurso->bindParam ( ":curnome", $curnome );
	$insercaoCurso->bindParam ( ":curtit", $curtit );
	$insercaoCurso->bindParam ( ":eixcod", $eixcod );
	return $insercaoCurso->execute ();
}
function buscarCursosPorEixo(PDO &$conn): PDOStatement {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->query ( "select curso.curcod, curso.curnome, curso.curtit, eixotec.eixdesc from curso inner join eixotec on curso.eixcod = eixotec.eixcod" );
	return $consultacurso;
}
function buscarCursoPorId(int $curcod, PDO &$conn = null): PDOStatement {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->prepare ( "select * from curso where curcod = :curcod" );
	$consultacurso->bindParam ( ":curcod", $curcod );
	return $consultacurso;
}
function buscarTodosOsCursos(PDO &$conn): PDOStatement {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->query ( "select * from curso" );
	return $consultacurso;
}
function atualizarCurso(PDO &$conn, string $curnome, string $curtit, int $eixcod, int $curcod): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaocurso = $conn->prepare ( "update curso set curnome = :curnome, curtit = :curtit, eixcod = :eixcod where curcod = :curcod" );
	$atualizacaocurso->bindParam ( ":curnome", $curnome );
	$atualizacaocurso->bindParam ( ":curtit", $curtit );
	$atualizacaocurso->bindParam ( ":eixcod", $eixcod );
	$atualizacaocurso->bindParam ( ":curcod", $curcod );
	return $atualizacaocurso->execute ();
}
function excluirCurso(PDO &$conn, int $curcod): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delcurso = $conn->prepare ( "delete from curso where curcod = :curcod" );
	$delcurso->bindParam ( ":curcod", $curcod );
	return $delcurso->execute ();
}
function buscarCursoPorPpc(PDO &$conn): PDOStatement {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->query ( "select curso.curcod, curso.curnome from curso inner join ppc on curso.curcod = ppc.curcod" );
	return $consultacurso;
}
function buscarCursosExceto(PDO &$conn, int $curcod): PDOStatement {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacurso = $conn->prepare ( "select * from curso where curcod <> :curcod" );
	$consultacurso->bindParam ( ":curcod", $curcod );
	return $consultacurso;
}

?>