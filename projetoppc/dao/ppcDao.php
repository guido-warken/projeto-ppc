<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirPpc(PDO &$conn, string $ppcmodal, string $ppcobj, string $ppcdesc, string $ppcestagio, int $curcod, int $ppcanoini): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoppc = $conn->prepare ( "insert into ppc (curcod, ppcmodal, ppcobj, ppcdesc, ppcestagio, ppcanoini) values (:curcod, :ppcmodal, :ppcobj, :ppcdesc, :ppcestagio, :ppcanoini)" );
	$insercaoppc->bindParam ( ":curcod", $curcod );
	$insercaoppc->bindParam ( ":ppcmodal", $ppcmodal );
	$insercaoppc->bindParam ( ":ppcobj", $ppcobj );
	$insercaoppc->bindParam ( ":ppcdesc", $ppcdesc );
	$insercaoppc->bindParam ( ":ppcestagio", $ppcestagio );
	$insercaoppc->bindParam ( ":ppcanoini", $ppcanoini );
		return $insercaoppc->execute ();
}
function buscarPpcsPorCurso(PDO &$conn, int $curcod): PDOStatement {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultappc = $conn->prepare ( "select ppc.*, curso.* from ppc inner join curso on ppc.curcod = curso.curcod where curso.curcod = :curcod" );
	$consultappc->bindParam ( ":curcod", $curcod );
	return $consultappc;
}
function buscarPpcPorId(PDO &$conn, int $ppccod): PDOStatement {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultappc = $conn->prepare ( "select * from ppc where ppccod = :ppccod" );
$consultappc->bindParam ( ":ppccod", $ppccod );
	return $consultappc;
}		
function atualizarPpc(PDO &$conn, int $curcod, string $ppcmodal, string $ppcobj, string $ppcdesc, string $ppcestagio, int $ppccod, int $ppcanoini): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaoppc = $conn->prepare ( "update ppc set curcod = :curcod, ppcmodal = :ppcmodal, ppcobj = :ppcobj, ppcdesc = :ppcdesc, ppcestagio = :ppcestagio, ppcanoini = :ppcanoini where ppccod = :ppccod" );
	$atualizacaoppc->bindParam ( ":curcod", $curcod );
	$atualizacaoppc->bindParam ( ":ppcmodal", $ppcmodal );
	$atualizacaoppc->bindParam ( ":ppcobj", $ppcobj );
	$atualizacaoppc->bindParam ( ":ppcdesc", $ppcdesc );
	$atualizacaoppc->bindParam ( ":ppcestagio", $ppcestagio );
	$atualizacaoppc->bindParam(":ppcanoini", $ppcanoini);
	$atualizacaoppc->bindParam ( ":ppccod", $ppccod );
	return $atualizacaoppc->execute ();
}
function excluirPpc(PDO &$conn, int $ppccod): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delppc = $conn->prepare ( "delete from ppc where ppccod = :ppccod" );
	$delppc->bindParam ( ":ppccod", $ppccod );
	return $delppc->execute ();
}

?>