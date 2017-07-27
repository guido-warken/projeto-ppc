<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirIndicador($inddesc, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoindicador = $conn->prepare("insert into indicador (inddesc) values (:inddesc)");
    $insercaoindicador->bindParam(":inddesc", $inddesc);
    $resultado = $insercaoindicador->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarIndicador($indcod, $inddesc, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaoindicador = $conn->prepare("update indicador set inddesc = :inddesc where indcod = :indcod");
    $atualizacaoindicador->bindParam(":inddesc", $inddesc);
    $atualizacaoindicador->bindParam(":indcod", $indcod);
    $resultado = $atualizacaoindicador->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirIndicador($indcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delindicador = $conn->prepare("delete from indicador where indcod = :indcod");
    $delindicador->bindParam(":indcod", $indcod);
    $resultado = $delindicador->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarIndicadorPorId($indcod, &$conn = null)
{
    $informacoesindicador = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaindicador = $conn->prepare("select * from indicador where indcod = :indcod");
    $consultaindicador->bindParam(":indcod", $indcod);
    if ($consultaindicador->execute()) {
        $numregistros = $consultaindicador->rowCount();
        if ($numregistros == 1) {
            $informacoesindicador = $consultaindicador->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesindicador;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesindicador;
}

function buscarIndicadores(&$conn = null)
{
    $informacoesindicador = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaindicador = $conn->query("select * from indicador ");
    if ($consultaindicador->execute()) {
        $numregistros = $consultaindicador->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesindicador[$i] = $consultaindicador->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesindicador;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesindicador;
}

?>