<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
function inserirPerfilConclusao(int $ppccod, int $compcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$insercaoperfil = $conn->prepare ( "insert into perfilconclusao (ppccod, compcod) values (:ppccod, :compcod)" );
	$insercaoperfil->bindParam ( ":ppccod", $ppccod );
	$insercaoperfil->bindParam ( ":compcod", $compcod );
	$resultado = $insercaoperfil->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function excluirPerfilConclusao(int $ppccod, int $compcod, PDO &$conn = null): bool {
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$delperfil = $conn->prepare ( "delete from perfilconclusao where ppccod = :ppccod and compcod = :compcod" );
	$delperfil->bindParam ( ":ppccod", $ppccod );
	$delperfil->bindParam ( ":compcod", $compcod );
	$resultado = $delperfil->execute ();
	desconectarDoBanco ( $conn );
	return $resultado;
}
function buscarPerfilConclusaoPorId(int $ppccod, int $compcod, PDO &$conn = null): array {
	$perfil = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaperfil = $conn->prepare ( "select * from perfilconclusao where ppccod = :ppccod and compcod = :compcod" );
	$consultaperfil->bindParam ( ":ppccod", $ppccod );
	$consultaperfil->bindParam ( ":compcod", $compcod );
	if ($consultaperfil->execute ()) {
		$numregistros = $consultaperfil->rowCount ();
		if ($numregistros == 1) {
			$perfil = $consultaperfil->fetch ( PDO::FETCH_ASSOC );
		} else {
			desconectarDoBanco ( $conn );
			return $perfil;
		}
	}
	desconectarDoBanco ( $conn );
	return $perfil;
}
function buscarPerfisConclusao(PDO &$conn = null): array {
	$perfil = [ ];
	if (is_null ( $conn ))
		$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );
	$consultaperfil = $conn->query ( "select * from perfilconclusao " );
	if ($consultaperfil->execute ()) {
		$numregistros = $consultaperfil->rowCount ();
		if ($numregistros > 0) {
			for($i = 0; $i < $numregistros; $i ++) {
				$perfil [$i] = $consultaperfil->fetch ( PDO::FETCH_ASSOC );
			}
		} else {
			desconectarDoBanco ( $conn );
			return $perfil;
		}
	}
	desconectarDoBanco ( $conn );
	return $perfil;
}

?>