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

?>