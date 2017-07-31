<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirUnidade($uninome, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaounidade = $conn->prepare("insert into unidadesenac (uninome) values (:uninome)");
    $insercaounidade->bindParam(":uninome", $uninome);
    $resultado = $insercaounidade->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarUnidade($unicod, $uninome, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaounidade = $conn->prepare("update unidadesenac set uninome = :uninome where unicod = :unicod");
    $atualizacaounidade->bindParam(":uninome", $uninome);
    $atualizacaounidade->bindParam(":unicod", $unicod);
    $resultado = $atualizacaounidade->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirUnidade($unicod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delunidade = $conn->prepare("delete from unidadesenac where unicod = :unicod");
    $delunidade->bindParam(":unicod", $unicod);
    $resultado = $delunidade->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarUnidadePorId($unicod, &$conn = null)
{
    $informacoesunidade = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaunidade = $conn->prepare("select * from unidadesenac where unicod = :unicod");
    $consultaunidade->bindParam(":unicod", $unicod);
    if ($consultaunidade->execute()) {
        $numregistros = $consultaunidade->rowCount();
        if ($numregistros == 1) {
            $informacoesunidade = $consultaunidade->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesunidade;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesunidade;
}

function buscarUnidades(&$conn = null)
{
    $informacoesunidade = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaunidade = $conn->query("select * from unidadesenac order by uninome");
    if ($consultaunidade->execute()) {
        $numregistros = $consultaunidade->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesunidade[$i] = $consultaunidade->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesunidade;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesunidade;
}

function buscarUnidadesPorPdi(&$conn = null)
{
    $informacoesunidade = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaunidade = $conn->query("select unidadesenac.unicod, unidadesenac.uninome from unidadesenac inner join pdi on unidadesenac.unicod = pdi.unicod");
    if ($consultaunidade->execute()) {
        $numregistros = $consultaunidade->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesunidade[$i] = $consultaunidade->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesunidade;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesunidade;
}

function buscarUnidadesExceto($unicod, &$conn = null)
{
    $informacoesunidade = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaunidade = $conn->prepare("select * from unidadesenac where unicod <> :unicod");
    $consultaunidade->bindParam(":unicod", $unicod);
    if ($consultaunidade->execute()) {
        $numregistros = $consultaunidade->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesunidade[$i] = $consultaunidade->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesunidade;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesunidade;
}

?>