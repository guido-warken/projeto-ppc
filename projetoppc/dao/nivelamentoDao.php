<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirNivelamento($nivdes, $nivch, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("insert into nivelamento (nivdes, nivch) values (:nivdes, :nivch)");
    $query->bindParam(":nivdes", $nivdes);
    $query->bindParam(":nivch", $nivch);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarNivelamento($nivcod, $nivdes, $nivch, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("update nivelamento set nivdes = :nivdes, nivch = :nivch where nivcod = :nivcod");
    $query->bindParam(":nivdes", $nivdes);
    $query->bindParam(":nivch", $nivch);
    $query->bindParam(":nivcod", $nivcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirNivelamento($nivcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("delete from nivelamento where nivcod = :nivcod");
    $query->bindParam(":nivcod", $nivcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarNivelamentoPorId($nivcod, &$conn = null)
{
    $nivelamento = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from nivelamento where nivcod = :nivcod");
    $consulta->bindParam(":nivcod", $nivcod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $nivelamento = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $nivelamento;
        }
    }
    desconectarDoBanco($conn);
    return $nivelamento;
}

function buscarNivelamentoPorDescricao($nivdes, &$conn = null)
{
    $nivelamento = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from nivelamento where nivdes = :nivdes");
    $consulta->bindParam(":nivdes", $nivdes);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $nivelamento = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $nivelamento;
        }
    }
    desconectarDoBanco($conn);
    return $nivelamento;
}

function buscarNivelamentos(&$conn = null)
{
    $nivelamentos = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->query("select * from nivelamento");
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $nivelamentos[$i] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $nivelamentos;
        }
    }
    desconectarDoBanco($conn);
    return $nivelamentos;
}

?>