<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirFigura($figdesc, $figura, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = "insert into figura (figdesc, figcont) values ('" . $figdesc . "', '" . $figura . "')";
    $numregistrosins = $conn->exec($query);
    desconectarDoBanco($conn);
    return $numregistrosins;
}

function atualizarFigura($figdesc, $figura, $figcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = "update figura set figdesc = '" . $figdesc . "', figcont = '" . $figura . "' where figcod = " . $figcod;
    $numregistros = $conn->exec($query);
    desconectarDoBanco($conn);
    return $numregistros;
}

function excluirFigura($figcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = "delete from figura where figcod = " . $figcod;
    $numregistrosdel = $conn->exec($query);
    desconectarDoBanco($conn);
    return $numregistrosdel;
}

function buscarFiguraPorId($figcod, &$conn = null)
{
    $figura = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from figura where figcod = :figcod");
    $consulta->bindParam(":figcod", $figcod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $figura = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $figura;
        }
    }
    desconectarDoBanco($conn);
    return $figura;
}

function buscarFiguras(&$conn = null)
{
    $figuras = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->query("select * from figura");
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($contador = 0; $contador < $numregistros; $contador ++) {
                $figuras[$contador] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $figuras;
        }
    }
    desconectarDoBanco($conn);
    return $figuras;
}

function buscarFiguraPorDescricao($figdesc, &$conn = null)
{
    $figura = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from figura where figdesc = :figdesc");
    $consulta->bindParam(":figdesc", $figdesc);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $figura = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $figura;
        }
    }
    desconectarDoBanco($conn);
    return $figura;
}

?>