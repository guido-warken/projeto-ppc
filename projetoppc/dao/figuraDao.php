<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirFigura($figdesc, $figcont, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("insert into figura (figdesc, figcont) values (:figdesc, :figcont)");
    $query->bindParam(":figdesc", $figdesc);
    $query->bindParam(":figcont", $figcont, PDO::PARAM_LOB);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarFigura($figdesc, $figcont, $figcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("update figura set figdesc = :figdesc, figcont = :figcont where figcod = :figcod");
    $query->bindParam(":figdesc", $figdesc);
    $query->bindParam(":figcont", $figcont);
    $query->bindParam(":figcod", $figcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirFigura($figcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("delete from figura where figcod = :figcod");
    $query->bindParam(":figcod", $figcod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
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