<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function vincularIndicador($indcod, $discod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoavalia = $conn->prepare("insert into avalia (indcod, discod) values (:indcod, :discod)");
    $insercaoavalia->bindParam(":indcod", $indcod);
    $insercaoavalia->bindParam(":discod", $discod);
    $resultado = $insercaoavalia->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function desvincularIndicador($indcod, $discod)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delavalia = $conn->prepare("delete from avalia where indcod = :indcod and discod = :discod");
    $delavalia->bindParam(":indcod", $indcod);
    $delavalia->bindParam(":discod", $discod);
    $resultado = $delavalia->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarVinculoPorDisciplina($discod, &$conn = null)
{
    $informacoesvinculo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaavalia = $conn->prepare("select * from avalia where discod = :discod");
    $consultaavalia->bindParam(":discod", $discod);
    if ($consultaavalia->execute()) {
        $numregistros = $consultaavalia->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesvinculo[$i] = $consultaavalia->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesvinculo;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesvinculo;
}

function buscarVinculoPorId($indcod, $discod, &$conn = null)
{
    $informacoesvinculo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaavalia = $conn->prepare("select * from avalia where discod = :discod and indcod = :indcod");
    $consultaavalia->bindParam(":discod", $discod);
    $consultaavalia->bindParam(":indcod", $indcod);
    if ($consultaavalia->execute()) {
        $numregistros = $consultaavalia->rowCount();
        if ($numregistros == 1) {
            $informacoesvinculo = $consultaavalia->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesvinculo;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesvinculo;
}

?>