<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirPdi($pdianoini, $pdianofim, $pdipesquisa, $pdiensino, $pdimetodo, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaopdi = $conn->prepare("insert into pdi (pdianoini, pdianofim, pdiensino, pdipesquisa, pdimetodo) values (:pdianoini, :pdianofim, :pdiensino, :pdipesquisa, :pdimetodo)");
    $insercaopdi->bindParam(":pdianoini", $pdianoini);
    $insercaopdi->bindParam(":pdianofim", $pdianofim);
    $insercaopdi->bindParam(":pdiensino", $pdiensino);
    $insercaopdi->bindParam(":pdipesquisa", $pdipesquisa);
    $insercaopdi->bindParam(":pdimetodo", $pdimetodo);
    $resultado = $insercaopdi->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarPdi($pdicod, $pdianoini, $pdianofim, $pdipesquisa, $pdiensino, $pdimetodo, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaopdi = $conn->prepare("update pdi set pdianoini = :pdianoini, pdianofim = :pdianofim, pdiensino = :pdiensino, pdipesquisa = :pdipesquisa, pdimetodo = :pdimetodo where pdicod = :pdicod");
    $atualizacaopdi->bindParam(":pdianoini", $pdianoini);
    $atualizacaopdi->bindParam(":pdianofim", $pdianofim);
    $atualizacaopdi->bindParam(":pdiensino", $pdiensino);
    $atualizacaopdi->bindParam(":pdipesquisa", $pdipesquisa);
    $atualizacaopdi->bindParam(":pdimetodo", $pdimetodo);
    $atualizacaopdi->bindParam(":pdicod", $pdicod);
    $resultado = $atualizacaopdi->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirPDI($pdicod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delpdi = $conn->prepare("delete from pdi where pdicod = :pdicod");
    $delpdi->bindParam(":pdicod", $pdicod);
    $resultado = $delpdi->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarPdiPorId($pdicod, &$conn = null)
{
    $informacoesPdi = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultapdi = $conn->prepare("select * from pdi where pdicod = :pdicod");
    $consultapdi->bindParam(":pdicod", $pdicod);
    if ($consultapdi->execute()) {
        $numregistros = $consultapdi->rowCount();
        if ($numregistros == 1) {
            $informacoesPdi = $consultapdi->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesPdi;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesPdi;
}

function buscarPdis(&$conn = null)
{
    $informacoesPdi = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultapdi = $conn->query("select * from pdi");
    if ($consultapdi->execute()) {
        $numregistros = $consultapdi->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesPdi[$i] = $consultapdi->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesPdi;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesPdi;
}

function buscarPdiPorAnoInicial($pdianoini, &$conn = null)
{
    $pdi = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultapdi = $conn->prepare("select * from pdi where pdianoini = :pdianoini");
    $consultapdi->bindParam(":pdianoini", $pdianoini);
    if ($consultapdi->execute()) {
        $numregistros = $consultapdi->rowCount();
        if ($numregistros == 1) {
            $pdi = $consultapdi->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $pdi;
        }
    }
    desconectarDoBanco($conn);
    return $pdi;
}

function import(&$conn = null)
{
    $pdiinfo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->query("select pdiensino, pdipesquisa, pdimetodo from pdi where pdicod = (select max(pdicod) from pdi)");
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $pdiinfo = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $pdiinfo;
        }
    }
    desconectarDoBanco($conn);
    return $pdiinfo;
}

?>