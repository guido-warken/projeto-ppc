<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function vincularFiguraAPpc($figcod, $ppccod, $figordem, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("insert into figurappc (ppccod, figcod, figordem) values (:ppccod, :figcod, :figordem)");
    $query->bindParam(":ppccod", $ppccod);
    $query->bindParam(":figcod", $figcod);
    $query->bindParam(":figordem", $figordem);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarVinculo($ppccod, $figcod, $figordem, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("update figurappc set figordem = :figordem where ppccod = :ppccod and figcod = :figcod");
    $query->bindParam(":figordem", $figordem);
    $query->bindParam(":ppccod", $ppccod);
    $query->bindParam(":figcod", $figcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function desvincularFigura($ppccod, $figcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("delete from figurappc where ppccod = :ppccod and figcod = :figcod");
    $query->bindParam(":ppccod", $ppccod);
    $query->bindParam(":figcod", $figcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarVinculosPorPpc($ppccod, &$conn = null)
{
    $figurappc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select figurappc.*, figura.figdesc, figura.figcont from figurappc inner join figura on figurappc.figcod = figura.figcod where figurappc.ppccod = :ppccod");
    $consulta->bindParam(":ppccod", $ppccod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $figurappc[$i] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $figurappc;
        }
    }
    desconectarDoBanco($conn);
    return $figurappc;
}

function buscarVinculosPorFigura($figcod, &$conn = null)
{
    $figurappc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from figurappc where figcod = :figcod");
    $consulta->bindParam(":figcod", $figcod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $figurappc[$i] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $figurappc;
        }
    }
    desconectarDoBanco($conn);
    return $figurappc;
}

function buscarVinculoPorId($ppccod, $figcod, &$conn = null)
{
    $figurappc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from figurappc where ppccod = :ppccod and figcod = :figcod");
    $consulta->bindParam(":ppccod", $ppccod);
    $consulta->bindParam(":figcod", $figcod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $figurappc = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $figurappc;
        }
    }
    desconectarDoBanco($conn);
    return $figurappc;
}

function buscarVinculoPorOrdem($figordem, $ppccod, &$conn = null)
{
    $figurappc = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from figurappc where ppccod = :ppccod and figordem = :figordem");
    $consulta->bindParam(":ppccod", $ppccod);
    $consulta->bindParam(":figordem", $figordem);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $figurappc = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $figurappc;
        }
    }
    desconectarDoBanco($conn);
    return $figurappc;
}
?>