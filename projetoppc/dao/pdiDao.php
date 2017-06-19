<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirPdi(int $unicod, int $pdianoini, int $pdianofim, string $pdipesquisa, string $pdiensino, string $pdimetodo, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaopdi = $conn->prepare ( "insert into pdi (unicod, pdianoini, pdianofim, pdiensino, pdipesquisa, pdimetodo) values (:unicod, :pdianoini, :pdianofim, :pdiensino, :pdipesquisa, :pdimetodo)" );
	$insercaopdi->bindParam ( ":unicod", $unicod );
	$insercaopdi->bindParam ( ":pdianoini", $pdianoini );
	$insercaopdi->bindParam ( ":pdianofim", $pdianofim );
	$insercaopdi->bindParam ( ":pdiensino", $pdiensino );
	$insercaopdi->bindParam ( ":pdipesquisa", $pdipesquisa );
	$insercaopdi->bindParam ( ":pdimetodo", $pdimetodo );
	$resultado = $insercaopdi->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarPdi(int $pdicod, int $unicod, int $pdianoini, int $pdianofim, string $pdipesquisa, string $pdiensino, string $pdimetodo, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaopdi = $conn->prepare ( "update pdi set unicod = :unicod, pdianoini = :pdianoini, pdianofim = :pdianofim, pdiensino = :pdiensino, pdipesquisa = :pdipesquisa, pdimetodo = :pdimetodo where pdicod = :pdicod" );
	$atualizacaopdi->bindParam ( ":unicod", $unicod );
	$atualizacaopdi->bindParam ( ":pdianoini", $pdianoini );
	$atualizacaopdi->bindParam ( ":pdianofim", $pdianofim );
	$atualizacaopdi->bindParam ( ":pdiensino", $pdiensino );
	$atualizacaopdi->bindParam ( ":pdipesquisa", $pdipesquisa );
	$atualizacaopdi->bindParam ( ":pdimetodo", $pdimetodo );
	$atualizacaopdi->bindParam ( ":pdicod", $pdicod );
	$resultado = $atualizacaopdi->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirPDI(int $pdicod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delpdi = $conn->prepare ( "delete from pdi where pdicod = :pdicod" );
	$delpdi->bindParam ( ":pdicod", $pdicod );
	$resultado = $delpdi->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarPdiPorId(int $pdicod, PDO &$conn = null): array {
	$informacoesPdi = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultapdi = $conn->prepare ( "select * from pdi where pdicod = :pdicod" );
	$consultapdi->bindParam ( ":pdicod", $pdicod );
	if (! $consultapdi->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesPdi;
	} elseif ($consultapdi->execute () && $consultapdi->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesPdi;
	} elseif ($consultapdi->execute () && $consultapdi->rowCount () == 1) {
		$informacoesPdi = $consultapdi->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoesPdi;
}
function buscarPdis(PDO &$conn = null): array {
	$informacoesPdi = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultapdi = $conn->query ( "select * from pdi" );
	if (! $consultapdi->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesPdi;
	} elseif ($consultapdi->execute () && $consultapdi->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesPdi;
	} elseif ($consultapdi->execute () && $consultapdi->rowCount () > 0) {
		for($i = 0; $i < $consultapdi->rowCount (); $i ++) {
			$informacoesPdi [$i] = $consultapdi->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesPdi;
}
function buscarPdisPorUnidade(int $unicod, PDO &$conn = null): array {
	$informacoesPdi = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultapdi = $conn->prepare ( "select pdi.*, unidadesenac.* from pdi inner join unidadesenac on pdi.unicod = unidadesenac.unicod where unidadesenac.unicod = :unicod" );
	$consultapdi->bindParam ( ":unicod", $unicod );
	if (! $consultapdi->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesPdi;
	} elseif ($consultapdi->execute () && $consultapdi->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesPdi;
	} elseif ($consultapdi->execute () && $consultapdi->rowCount () > 0) {
		for($i = 0; $i < $consultapdi->rowCount (); $i ++) {
			$informacoesPdi [$i] = $consultapdi->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesPdi;
}

?>