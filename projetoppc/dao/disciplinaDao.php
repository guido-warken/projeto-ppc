<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirDisciplina(string $disnome, string $disobj, int $disch, string $discementa, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaodisciplina = $conn->prepare ( "insert into disciplina (disnome, disobj, disch, discementa) values (:disnome, :disobj, :disch, :discementa)" );
	$insercaodisciplina->bindParam ( ":disnome", $disnome );
	$insercaodisciplina->bindParam ( ":disobj", $disobj );
	$insercaodisciplina->bindParam ( ":disch", $disch );
	$insercaodisciplina->bindParam ( ":discementa", $discementa );
	$resultado = $insercaodisciplina->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarDisciplina(int $discod, string $disnome, string $disobj, int $disch, string $discementa, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaodisciplina = $conn->prepare ( "update disciplina set disnome = :disnome, disobj = :disobj, disch = :disch, discementa = :discementa where discod = :discod" );
	$atualizacaodisciplina->bindParam ( ":disnome", $disnome );
	$atualizacaodisciplina->bindParam ( ":disobj", $disobj );
	$atualizacaodisciplina->bindParam ( ":disch", $disch );
	$atualizacaodisciplina->bindParam ( ":discementa", $discementa );
	$atualizacaodisciplina->bindParam ( ":discod", $discod );
	$resultado = $insercaodisciplina->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirDisciplina(int $discod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$deldisciplina = $conn->prepare ( "delete from disciplina where discod = :discod" );
	$deldisciplina->bindParam ( ":discod", $discod );
	$resultado = $deldisciplina->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarDisciplinaPorId(int $discod, PDO &$conn = null): array {
	$informacoesdisciplina = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultadisciplina = $conn->prepare ( "select * from disciplina where discod = :discod" );
	$consultadisciplina->bindParam ( ":discod", $discod );
	if (! $consultadisciplina->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesdisciplina;
	} elseif ($consultadisciplina->execute () && $consultadisciplina->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesdisciplina;
	} elseif ($consultadisciplina->execute () && $consultadisciplina->rowCount () == 1) {
		$informacoesdisciplina = $consultadisciplina->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoesdisciplina;
}
function buscarDisciplinas(PDO &$conn = null): array {
	$informacoesdisciplina = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultadisciplina = $conn->query ( "select * from disciplina" );
	if (! $consultadisciplina->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesdisciplina;
	} elseif ($consultadisciplina->execute () && $consultadisciplina->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesdisciplina;
	} elseif ($consultadisciplina->execute () && $consultadisciplina->rowCount () > 0) {
		for($i = 0; $i < $consultadisciplina->rowCount (); $i ++) {
			$informacoesdisciplina [$i] = $consultadisciplina->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesdisciplina;
}

?>