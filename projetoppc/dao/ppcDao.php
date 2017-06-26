<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirPpc(string $ppcmodal, string $ppcobj, string $ppcdesc, string $ppcestagio, int $curcod, int $ppcanoini, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoppc = $conn->prepare ( "insert into ppc (curcod, ppcmodal, ppcobj, ppcdesc, ppcestagio, ppcanoini) values (:curcod, :ppcmodal, :ppcobj, :ppcdesc, :ppcestagio, :ppcanoini)" );
	$insercaoppc->bindParam ( ":curcod", $curcod );
	$insercaoppc->bindParam ( ":ppcmodal", $ppcmodal );
	$insercaoppc->bindParam ( ":ppcobj", $ppcobj );
	$insercaoppc->bindParam ( ":ppcdesc", $ppcdesc );
	$insercaoppc->bindParam ( ":ppcestagio", $ppcestagio );
	$insercaoppc->bindParam ( ":ppcanoini", $ppcanoini );
	$resultado = $insercaoppc->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarPpcsPorCurso(int $curcod, PDO &$conn = null): array {
	$informacoesppc = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultappc = $conn->prepare ( "select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod where curso.curcod = :curcod" );
	$consultappc->bindParam ( ":curcod", $curcod );
	if (! $consultappc->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () > 0) {
		for($i = 0; $i < $consultappc->rowCount (); $i ++) {
			$informacoesppc [$i] = $consultappc->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesppc;
}
function buscarPpcPorId(int $ppccod, PDO &$conn = null): array {
	$informacoesppc = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultappc = $conn->prepare ( "select * from ppc where ppccod = :ppccod" );
	$consultappc->bindParam ( ":ppccod", $ppccod );
	if (! $consultappc->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () == 1) {
		$informacoesppc = $consultappc->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoesppc;
}
function atualizarPpc(int $curcod, string $ppcmodal, string $ppcobj, string $ppcdesc, string $ppcestagio, int $ppccod, int $ppcanoini, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaoppc = $conn->prepare ( "update ppc set curcod = :curcod, ppcmodal = :ppcmodal, ppcobj = :ppcobj, ppcdesc = :ppcdesc, ppcestagio = :ppcestagio, ppcanoini = :ppcanoini where ppccod = :ppccod" );
	$atualizacaoppc->bindParam ( ":curcod", $curcod );
	$atualizacaoppc->bindParam ( ":ppcmodal", $ppcmodal );
	$atualizacaoppc->bindParam ( ":ppcobj", $ppcobj );
	$atualizacaoppc->bindParam ( ":ppcdesc", $ppcdesc );
	$atualizacaoppc->bindParam ( ":ppcestagio", $ppcestagio );
	$atualizacaoppc->bindParam ( ":ppcanoini", $ppcanoini );
	$atualizacaoppc->bindParam ( ":ppccod", $ppccod );
	$resultado = $atualizacaoppc->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirPpc(int $ppccod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delppc = $conn->prepare ( "delete from ppc where ppccod = :ppccod" );
	$delppc->bindParam ( ":ppccod", $ppccod );
	$resultado = $delppc->execute ();
	return $resultado;
}
function buscarPpcs(PDO &$conn = null): array {
	$informacoesppc = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultappc = $conn->query ( "select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod" );
	if (! $consultappc->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () > 0) {
		for($i = 0; $i < $consultappc->rowCount (); $i ++) {
			$informacoesppc [$i] = $consultappc->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesppc;
}
function buscarPpcsPorOferta(PDO &$conn = null): array {
	$informacoesppc = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultappc = $conn->query ( "select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod inner join oferta on ppc.ppccod = oferta.ppccod" );
	if (! $consultappc->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesppc;
	} elseif ($consultappc->execute () && $consultappc->rowCount () > 0) {
		for($i = 0; $i < $consultappc->rowCount (); $i ++) {
			$informacoesppc [$i] = $consultappc->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesppc;
}

?>