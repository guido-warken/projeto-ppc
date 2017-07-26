<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirCertificacao($cerdes, $cerreq, $cerch, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaocert = $conn->prepare("insert into certificacao (cerdes, cerreq, cerch) values (:cerdes, :cerreq, :cerch)");
    $insercaocert->bindParam(":cerdes", $cerdes);
    $insercaocert->bindParam(":cerreq", $cerreq);
    $insercaocert->bindParam(":cerch", $cerch);
    $resultado = $insercaocert->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarCert($cercod, $cerdes, $cerreq, $cerch, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaocert = $conn->prepare("update certificacao set cerdes = :cerdes, cerreq = :cerreq, cerch = :cerch where cercod = :cercod");
    $atualizacaocert->bindParam(":cerdes", $cerdes);
    $atualizacaocert->bindParam(":cerreq", $cerreq);
    $atualizacaocert->bindParam(":cerch", $cerch);
    $atualizacaocert->bindParam(":cercod", $cercod);
    $resultado = $atualizacaocert->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirCert($cercod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delcert = $conn->prepare("delete from certificacao where cercod = :cercod");
    $delcert->bindParam(":cercod", $cercod);
    $resultado = $insercaocert->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarCertPorId($cercod, &$conn = null)
{
    $certificacao = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacert = $conn->prepare("select * from certificacao where cercod = :cercod");
    $consultacert->bindParam(":cercod", $cercod);
    if ($consultacert->execute()) {
        $numregistros = $consultacert->rowCount();
        if ($numregistros == 1) {
            $certificacao = $consultacert->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $certificacao;
        }
    }
    desconectarDoBanco($conn);
    return $certificacao;
}

function buscarCert(&$conn = null)
{
    $certificacao = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacert = $conn->query("select * from certificacao");
    if ($consultacert->execute()) {
        $numregistros = $consultacert->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $certificacao[$i] = $consultacert->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $certificacao;
        }
    }
    desconectarDoBanco($conn);
    return $certificacao;
}

?>