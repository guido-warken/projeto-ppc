<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirEixoTem($eixtdes, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoeixotematico = $conn->prepare("insert into eixotematico (eixtdes) values (:eixtdes)");
    $insercaoeixotematico->bindParam(":eixtdes", $eixtdes);
    $resultado = $insercaoeixotematico->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarEixoTem($eixtcod, $eixtdes, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaoeixotematico = $conn->prepare("update eixotematico set eixtdes = :eixtdes where eixtcod = :eixtcod");
    $atualizacaoeixotematico->bindParam(":eixtdes", $eixtdes);
    $atualizacaoeixotematico->bindParam(":eixtcod", $eixtcod);
    $resultado = $atualizacaoeixotematico->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirEixoTem($eixtcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $deleixotematico = $conn->prepare("delete from eixotematico where eixtcod = :eixtcod");
    $deleixotematico->bindParam(":eixtcod", $eixtcod);
    $resultado = $deleixotematico->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarEixoTemPorId($eixtcod, &$conn = null)
{
    $informacoeseixotematico = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotematico = $conn->prepare("select * from eixotematico where eixtcod = :eixtcod");
    $consultaeixotematico->bindParam(":eixtcod", $eixtcod);
    if (! $consultaeixotematico->execute()) {
        desconectarDoBanco($conn);
        return $informacoeseixotematico;
    } elseif ($consultaeixotematico->execute() && $consultaeixotematico->rowCount() == 0) {
        desconectarDoBanco($conn);
        return $informacoeseixotematico;
    } elseif ($consultaeixotematico->execute() && $consultaeixotematico->rowCount() == 1) {
        $informacoeseixotematico = $consultaeixotematico->fetch(PDO::FETCH_ASSOC);
    }
    desconectarDoBanco($conn);
    return $informacoeseixotematico;
}

function buscarEixosTem(&$conn = null)
{
    $informacoeseixotematico = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotematico = $conn->query("select * from eixotematico");
    if (! $consultaeixotematico->execute()) {
        desconectarDoBanco($conn);
        return $informacoeseixotematico;
    } elseif ($consultaeixotematico->execute() && $consultaeixotematico->rowCount() == 0) {
        desconectarDoBanco($conn);
        return $informacoeseixotematico;
    } elseif ($consultaeixotematico->execute() && $consultaeixotematico->rowCount() > 0) {
        for ($i = 0; $i < $consultaeixotematico->rowCount(); $i ++) {
            $informacoeseixotematico[$i] = $consultaeixotematico->fetch(PDO::FETCH_ASSOC);
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotematico;
}

function buscarEixosTemExceto($eixtcod, &$conn = null)
{
    $informacoeseixotematico = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotematico = $conn->prepare("select * from eixotematico where eixtcod <> :eixtcod");
    $consultaeixotematico->bindParam(":eixtcod", $eixtcod);
    if (! $consultaeixotematico->execute()) {
        desconectarDoBanco($conn);
        return $informacoeseixotematico;
    } elseif ($consultaeixotematico->execute() && $consultaeixotematico->rowCount() == 0) {
        desconectarDoBanco($conn);
        return $informacoeseixotematico;
    } elseif ($consultaeixotematico->execute() && $consultaeixotematico->rowCount() > 0) {
        for ($i = 0; $i < $consultaeixotematico->rowCount(); $i ++) {
            $informacoeseixotematico[$i] = $consultaeixotematico->fetch(PDO::FETCH_ASSOC);
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotematico;
}

?>