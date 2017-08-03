<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirPerfilCert($ppccod, $compcod, $cercod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoPerfilCert = $conn->prepare("insert into perfildacertificacao (ppccod, compcod, cercod) values (:ppccod, :compcod, :cercod)");
    $insercaoPerfilCert->bindParam(":ppccod", $ppccod);
    $insercaoPerfilCert->bindParam(":compcod", $compcod);
    $insercaoPerfilCert->bindParam(":cercod", $cercod);
    $resultado = $insercaoPerfilCert->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirPerfilCert($ppccod, $compcod, $cercod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delPerfilCert = $conn->prepare("delete from perfildacertificacao where ppccod = :ppccod and compcod = :compcod and cercod = :cercod");
    $delPerfilCert->bindParam(":ppccod", $ppccod);
    $delPerfilCert->bindParam(":compcod", $compcod);
    $delPerfilCert->bindParam(":cercod", $cercod);
    $resultado = $delPerfilCert->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarPerfilCertPorPpc($ppccod, &$conn = null)
{
    $perfil = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaPerfilCert = $conn->prepare("select * from perfildacertificacao where ppccod = :ppccod");
    $consultaPerfilCert->bindParam(":ppccod", $ppccod);
    if ($consultaPerfilCert->execute()) {
        $numregistros = $consultaPerfilCert->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $perfil[$i] = $consultaPerfilCert->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $perfil;
        }
    }
    desconectarDoBanco($conn);
    return $perfil;
}

function buscarPerfilCertPorCompetencia($compcod, &$conn = null)
{
    ;
    $perfil = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaPerfilCert = $conn->prepare("select * from perfildacertificacao where compcod = :compcod");
    $consultaPerfilCert->bindParam(":compcod", $compcod);
    if ($consultaPerfilCert->execute()) {
        $numregistros = $consultaPerfilCert->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $perfil[$i] = $consultaPerfilCert->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $perfil;
        }
    }
    desconectarDoBanco($conn);
    return $perfil;
}

function buscarPerfilCertPorCertificacao($cercod, $conn = null)
{
    $perfil = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaPerfilCert = $conn->prepare("select * from perfildacertificacao where cercod = :cercod");
    $consultaPerfilCert->bindParam(":cercod", $cercod);
    if ($consultaPerfilCert->execute()) {
        $numregistros = $consultaPerfilCert->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $perfil[$i] = $consultaPerfilCert->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $perfil;
        }
    }
    desconectarDoBanco($conn);
    return $perfil;
}

function buscarPerfilCertPorId($ppccod, $compcod, $cercod, $conn = null)
{
    $perfil = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaPerfilCert = $conn->prepare("select * from perfildacertificacao where ppccod = :ppccod and compcod = :compcod and cercod = :cercod");
    $consultaPerfilCert->bindParam(":ppccod", $ppccod);
    $consultaPerfilCert->bindParam(":compcod", $compcod);
    $consultaPerfilCert->bindParam(":cercod", $cercod);
    if ($consultaPerfilCert->execute()) {
        $numregistros = $consultaPerfilCert->rowCount();
        if ($numregistros == 1) {
            $perfil = $consultaPerfilCert->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $perfil;
        }
    }
    desconectarDoBanco($conn);
    return $perfil;
}
?>