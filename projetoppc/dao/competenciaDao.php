<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirCompetencia(string $compdes, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaocompetencia = $conn->prepare ( "insert into competencia (compdes) values (:compdes)" );
	$insercaocompetencia->bindParam ( ":compdes", $compdes );
	$resultado = $insercaocompetencia->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarCompetencia(string $compdes, int $compcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaocompetencia = $conn->prepare ( "update competencia set compdes = :compdes where compcod = :compcod" );
	$atualizacaocompetencia->bindParam ( ":compdes", $compdes );
	$atualizacaocompetencia->bindParam ( ":compcod", $compcod );
	$resultado = $atualizacaocompetencia->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirCompetencia(int $compcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delcompetencia = $conn->prepare ( "delete from competencia where compcod = :compcod" );
	$delcompetencia->bindParam ( ":compcod", $compcod );
	$resultado = $delcompetencia->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarCompetenciaPorId(int $compcod, PDO &$conn = null): array {
	$informacoescomp = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacomp = $conn->prepare ( "select * from competencia where compcod = :compcod" );
	$consultacomp->bindParam ( ":compcod", $compcod );
	if (! $consultacomp->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoescomp;
	} elseif ($consultacomp->execute () && $consultacomp->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoescomp;
	} elseif ($consultacomp->execute () && $consultacomp->rowCount () == 1) {
		$informacoescomp = $consultacomp->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoescomp;
}
function buscarCompetencias(PDO &$conn = null): array {
	$informacoescomp = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultacomp = $conn->query ( "select * from competencia" );
	if (! $consultacomp->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoescomp;
	} elseif ($consultacomp->execute () && $consultacomp->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoescomp;
	} elseif ($consultacomp->execute () && $consultacomp->rowCount () > 0) {
		for($i = 0; $i < $consultacomp->rowCount (); $i ++) {
			$informacoescomp [$i] = $consultacomp->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoescomp;
}

?>