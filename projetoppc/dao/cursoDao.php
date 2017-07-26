<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirCurso($curnome, $curtit, $eixcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoCurso = $conn->prepare("insert into curso (curnome, curtit, eixcod) values (:curnome, :curtit, :eixcod)");
    $insercaoCurso->bindParam(":curnome", $curnome);
    $insercaoCurso->bindParam(":curtit", $curtit);
    $insercaoCurso->bindParam(":eixcod", $eixcod);
    $resultado = $insercaoCurso->execute();
    return $resultado;
}

function buscarCursoPorId($curcod, &$conn = null)
{
    $informacoescurso = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacurso = $conn->prepare("select * from curso where curcod = :curcod");
    $consultacurso->bindParam(":curcod", $curcod);
    if (! $consultacurso->execute()) {
        desconectarDoBanco($conn);
        return $informacoescurso;
    } elseif ($consultacurso->execute() && $consultacurso->rowCount() == 0) {
        desconectarDoBanco($conn);
        return $informacoescurso;
    } elseif ($consultacurso->execute() && $consultacurso->rowCount() == 1) {
        $informacoescurso = $consultacurso->fetch(PDO::FETCH_ASSOC);
    }
    return $informacoescurso;
}

function buscarTodosOsCursos(&$conn = null)
{
    $informacoescurso = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacurso = $conn->query("select * from curso");
    if (! $consultacurso->execute()) {
        desconectarDoBanco($conn);
        return $informacoescurso;
    } elseif ($consultacurso->execute() && $consultacurso->rowCount() == 0) {
        desconectarDoBanco($conn);
        return $informacoescurso;
    } elseif ($consultacurso->execute() && $consultacurso->rowCount() > 0) {
        for ($i = 0; $i < $consultacurso->rowCount(); $i ++) {
            $informacoescurso[$i] = $consultacurso->fetch(PDO::FETCH_ASSOC);
        }
    }
    desconectarDoBanco($conn);
    return $informacoescurso;
}

function atualizarCurso($curnome, $curtit, $eixcod, $curcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaocurso = $conn->prepare("update curso set curnome = :curnome, curtit = :curtit, eixcod = :eixcod where curcod = :curcod");
    $atualizacaocurso->bindParam(":curnome", $curnome);
    $atualizacaocurso->bindParam(":curtit", $curtit);
    $atualizacaocurso->bindParam(":eixcod", $eixcod);
    $atualizacaocurso->bindParam(":curcod", $curcod);
    $resultado = $atualizacaocurso->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirCurso($curcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delcurso = $conn->prepare("delete from curso where curcod = :curcod");
    $delcurso->bindParam(":curcod", $curcod);
    $resultado = $delcurso->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarCursosExceto($curcod, &$conn = null)
{
    $informacoescurso = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacurso = $conn->prepare("select * from curso where curcod <> :curcod");
    $consultacurso->bindParam(":curcod", $curcod);
    if (! $consultacurso->execute()) {
        desconectarDoBanco($conn);
        return $informacoescurso;
    } elseif ($consultacurso->execute() && $consultacurso->rowCount() == 0) {
        desconectarDoBanco($conn);
        return $informacoescurso;
    } elseif ($consultacurso->execute() && $consultacurso->rowCount() > 0) {
        for ($i = 0; $i < $consultacurso->rowCount(); $i ++) {
            $informacoescurso[$i] = $consultacurso->fetch(PDO::FETCH_ASSOC);
        }
    }
    desconectarDoBanco($conn);
    return $informacoescurso;
}

?>