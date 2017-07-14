<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirConteudoCurricular(int $ppccod, int $discod, int $eixtcod, int $contfase, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoConteudo = $conn->prepare ( "insert into conteudocurricular (ppccod, discod, eixtcod, contfase) values (:ppccod, :discod, :eixtcod, :contfase)" );
	$insercaoConteudo->bindParam ( ":ppccod", $ppccod );
	$insercaoConteudo->bindParam ( ":discod", $discod );
	$insercaoConteudo->bindParam ( ":eixtcod", $eixtcod );
	$insercaoConteudo->bindParam ( ":contfase", $contfase );
	$resultado = $insercaoConteudo->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function atualizarConteudoCurricular(int $ppccod, int $discod, int $eixtcod, int $contfase, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$atualizacaoconteudo = $conn->prepare ( "update conteudocurricular set eixtcod = :eixtcod, contfase = :contfase where ppccod = :ppccod and discod = :discod" );
	$atualizacaoconteudo->bindParam ( ":eixtcod", $eixtcod );
	$atualizacaoconteudo->bindParam ( ":contfase", $contfase );
	$atualizacaoconteudo->bindParam ( ":ppccod", $ppccod );
	$atualizacaoconteudo->bindParam ( ":discod", $discod );
	$resultado = $atualizacaoconteudo->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirConteudoCurricular(int $ppccod, int $discod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delconteudo = $conn->prepare ( "delete from conteudocurricular where ppccod = :ppccod and discod = :discod" );
	$delconteudo->bindParam ( ":ppccod", $ppccod );
	$delconteudo->bindParam ( ":discod", $discod );
	$resultado = $delconteudo->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarConteudoCurricularPorId(int $ppccod, int $discod, PDO &$conn = null): array {
	$informacoesconteudo = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaconteudo = $conn->prepare ( "select * from conteudocurricular where ppccod = :ppccod and discod = :discod" );
	$consultaconteudo->bindParam ( ":ppccod", $ppccod );
	$consultaconteudo->bindParam ( ":discod", $discod );
	if (! $consultaconteudo->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesconteudo;
	} elseif ($consultaconteudo->execute () && $consultaconteudo->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesconteudo;
	} elseif ($consultaconteudo->execute () && $consultaconteudo->rowCount () == 1) {
		$informacoesconteudo = $consultaconteudo->fetch ( PDO::FETCH_ASSOC );
	}
	desconectarDoBanco ( $conn );
	return $informacoesconteudo;
}
function buscarConteudosCurriculares(PDO &$conn = null): array {
	$informacoesconteudo = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaconteudo = $conn->query ( "select * from conteudocurricular" );
	if (! $consultaconteudo->execute ()) {
		desconectarDoBanco ( $conn );
		return $informacoesconteudo;
	} elseif ($consultaconteudo->execute () && $consultaconteudo->rowCount () == 0) {
		desconectarDoBanco ( $conn );
		return $informacoesconteudo;
	} elseif ($consultaconteudo->execute () && $consultaconteudo->rowCount () > 0) {
		for($i = 0; $i < $consultaconteudo->rowCount (); $i ++) {
			$informacoesconteudo [$i] = $consultaconteudo->fetch ( PDO::FETCH_ASSOC );
		}
	}
	desconectarDoBanco ( $conn );
	return $informacoesconteudo;
}

?>