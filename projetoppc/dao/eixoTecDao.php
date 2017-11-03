<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirEixoTec($eixdesc, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoeixotec = $conn->prepare("insert into eixotec (eixdesc) values (:eixdesc)");
    $insercaoeixotec->bindParam(":eixdesc", $eixdesc);
    $resultado = $insercaoeixotec->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarEixoTec($eixcod, $eixdesc, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaoeixotec = $conn->prepare("update eixotec set eixdesc = :eixdesc where eixcod = :eixcod");
    $atualizacaoeixotec->bindParam(":eixdesc", $eixdesc);
    $atualizacaoeixotec->bindParam(":eixcod", $eixcod);
    $resultado = $atualizacaoeixotec->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirEixoTec($eixcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $deleixotec = $conn->prepare("delete from eixotec where eixcod = :eixcod");
    $deleixotec->bindParam(":eixcod", $eixcod);
    $resultado = $deleixotec->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarEixosTec(&$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->query("select * from eixotec order by eixdesc");
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoeseixotec[$i] = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function buscarEixoTecPorId($eixcod, &$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->prepare("select * from eixotec where eixcod = :eixcod");
    $consultaeixotec->bindParam(":eixcod", $eixcod);
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros == 1) {
            $informacoeseixotec = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function buscarEixosTecExceto($eixcod, &$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->prepare("select * from eixotec where eixcod <> :eixcod");
    $consultaeixotec->bindParam(":eixcod", $eixcod);
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoeseixotec[$i] = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

function buscarEixoTecPorDescricao($eixdesc, &$conn = null)
{
    $informacoeseixotec = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaeixotec = $conn->prepare("select * from eixotec where eixdesc = :eixdesc");
    $consultaeixotec->bindParam(":eixdesc", $eixdesc);
    if ($consultaeixotec->execute()) {
        $numregistros = $consultaeixotec->rowCount();
        if ($numregistros == 1) {
            $informacoeseixotec = $consultaeixotec->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoeseixotec;
        }
    }
    desconectarDoBanco($conn);
    return $informacoeseixotec;
}

?>