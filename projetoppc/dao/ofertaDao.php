<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirOferta(int $ppccod, int $unicod, string $ofecont, string $ofevagasmat, string $ofevagasvesp, string $ofevagasnot, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaooferta = $conn->prepare ( "insert into oferta (ppccod, unicod, ofecont, ofevagasmat, ofevagasvesp, ofevagasnot) values (:ppccod, :unicod, :ofecont, :ofevagasmat, :ofevagasvesp, :ofevagasnot)" );
	$insercaooferta->bindParam ( ":ppccod", $ppccod );
	$insercaooferta->bindParam ( ":unicod", $unicod );
	$insercaooferta->bindParam ( ":ofecont", $ofecont );
	$insercaooferta->bindParam ( ":ofevagasmat", $ofevagasmat );
	$insercaooferta->bindParam ( ":ofevagasvesp", $ofevagasvesp );
	$insercaooferta->bindParam ( ":ofevagasnot", $ofevagasnot );
	$resultado = $insercaooferta->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarOferta(int $ppccod, int $unicod, string $ofecont, string $ofevagasmat, string $ofevagasvesp, string $ofevagasnot, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaooferta = $conn->prepare ( "update oferta set ofecont = :ofecont, ofevagasmat = :ofevagasmat, ofevagasvesp = :ofevagasvesp, ofevagasnot = :ofevagasnot where ppccod = :ppccod and unicod = :unicod" );
	$atualizacaooferta->bindParam ( ":ofecont", $ofecont );
	$atualizacaooferta->bindParam ( ":ofevagasmat", $ofevagasmat );
	$atualizacaooferta->bindParam ( ":ofevagasvesp", $ofevagasvesp );
	$atualizacaooferta->bindParam ( ":ofevagasnot", $ofevagasnot );
	$atualizacaooferta->bindParam ( ":ppccod", $ppccod );
	$atualizacaooferta->bindParam ( ":unicod", $unicod );
	$resultado = $atualizacaooferta->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirOferta(int $ppccod, int $unicod): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$deloferta = $conn->prepare ( "delete from oferta where ppccod = :ppccod and unicod = :unicod" );
	$deloferta->bindParam ( ":ppccod", $ppccod );
	$deloferta->bindParam ( ":unicod", $unicod );
	$resultado = $deloferta->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarOfertas(int $ppccod, int $unicod, PDO &$conn = null): array {
	$informacoesoferta = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaoferta = $conn->prepare ( "select * from oferta where ppccod = :ppccod and unicod = :unicod" );
	$consultaoferta->bindParam ( ":ppccod", $ppccod );
	$consultaoferta->bindParam ( ":unicod", $unicod );
	if (! $consultaoferta->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesoferta;
	} elseif ($consultaoferta->execute () && $consultaoferta->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesoferta;
	} elseif ($consultaoferta->execute () && $consultaoferta->rowCount () > 0) {
		$informacoesoferta = $consultaoferta->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoesoferta;
}

?>