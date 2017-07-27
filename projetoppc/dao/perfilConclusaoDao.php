<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirPerfilConclusao($ppccod, $compcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoperfil = $conn->prepare("insert into perfilconclusao (ppccod, compcod) values (:ppccod, :compcod)");
    $insercaoperfil->bindParam(":ppccod", $ppccod);
    $insercaoperfil->bindParam(":compcod", $compcod);
    $resultado = $insercaoperfil->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirPerfilConclusao($ppccod, $compcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delperfil = $conn->prepare("delete from perfilconclusao where ppccod = :ppccod and compcod = :compcod");
    $delperfil->bindParam(":ppccod", $ppccod);
    $delperfil->bindParam(":compcod", $compcod);
    $resultado = $delperfil->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarPerfilConclusaoPorPpc($ppccod, &$conn = null)
{
    $perfil = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaperfil = $conn->prepare("select * from perfilconclusao where ppccod = :ppccod ");
    $consultaperfil->bindParam(":ppccod", $ppccod);
    if ($consultaperfil->execute()) {
        $numregistros = $consultaperfil->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $perfil[$i] = $consultaperfil->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $perfil;
        }
    }
    desconectarDoBanco($conn);
    return $perfil;
}

function buscarPerfisConclusao(&$conn = null)
{
    $perfil = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaperfil = $conn->query("select * from perfilconclusao ");
    if ($consultaperfil->execute()) {
        $numregistros = $consultaperfil->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $perfil[$i] = $consultaperfil->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $perfil;
        }
    }
    desconectarDoBanco($conn);
    return $perfil;
}

function buscarPerfilConclusaoPorId($ppccod, $compcod, &$conn = null)
{
    $perfil = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaperfil = $conn->prepare("select * from perfilconclusao where ppccod = :ppccod and compcod = :compcod");
    $consultaperfil->bindParam(":ppccod", $ppccod);
    $consultaperfil->bindParam(":compcod", $compcod);
    if ($consultaperfil->execute()) {
        $numregistros = $consultaperfil->rowCount();
        if ($numregistros == 1) {
            $perfil = $consultaperfil->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $perfil;
        }
    }
    desconectarDoBanco($conn);
    return $perfil;
}

?>