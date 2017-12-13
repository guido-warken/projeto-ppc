<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirDisciplina($disnome, $disobj, $disch, $discementa, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaodisciplina = $conn->prepare("insert into disciplina (disnome, disobj, disch, discementa) values (:disnome, :disobj, :disch, :discementa)");
    $insercaodisciplina->bindParam(":disnome", $disnome);
    $insercaodisciplina->bindParam(":disobj", $disobj);
    $insercaodisciplina->bindParam(":disch", $disch);
    $insercaodisciplina->bindParam(":discementa", $discementa);
    $resultado = $insercaodisciplina->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarDisciplina($discod, $disnome, $disobj, $disch, $discementa, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaodisciplina = $conn->prepare("update disciplina set disnome = :disnome, disobj = :disobj, disch = :disch, discementa = :discementa where discod = :discod");
    $atualizacaodisciplina->bindParam(":disnome", $disnome);
    $atualizacaodisciplina->bindParam(":disobj", $disobj);
    $atualizacaodisciplina->bindParam(":disch", $disch);
    $atualizacaodisciplina->bindParam(":discementa", $discementa);
    $atualizacaodisciplina->bindParam(":discod", $discod);
    $resultado = $atualizacaodisciplina->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirDisciplina($discod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $deldisciplina = $conn->prepare("delete from disciplina where discod = :discod");
    $deldisciplina->bindParam(":discod", $discod);
    $resultado = $deldisciplina->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarDisciplinaPorId($discod, &$conn = null)
{
    $informacoesdisciplina = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultadisciplina = $conn->prepare("select * from disciplina where discod = :discod");
    $consultadisciplina->bindParam(":discod", $discod);
    if ($consultadisciplina->execute()) {
        $numregistros = $consultadisciplina->rowCount();
        if ($numregistros == 1) {
            $informacoesdisciplina = $consultadisciplina->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesdisciplina;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesdisciplina;
}

function buscarDisciplinaPorNome($disnome, &$conn = null)
{
    $informacoesdisciplina = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultadisciplina = $conn->prepare("select * from disciplina where disnome = :disnome");
    $consultadisciplina->bindParam(":disnome", $disnome);
    if ($consultadisciplina->execute()) {
        $numregistros = $consultadisciplina->rowCount();
        if ($numregistros == 1) {
            $informacoesdisciplina = $consultadisciplina->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesdisciplina;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesdisciplina;
}

function buscarDisciplinas(&$conn = null)
{
    $informacoesdisciplina = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultadisciplina = $conn->query("select * from disciplina order by disnome");
    if ($consultadisciplina->execute()) {
        $numregistros = $consultadisciplina->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesdisciplina[$i] = $consultadisciplina->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesdisciplina;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesdisciplina;
}

function buscarDisciplinasExceto($discod, &$conn = null)
{
    $informacoesdisciplina = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultadisciplina = $conn->prepare("select * from disciplina where discod <> :discod");
    $consultadisciplina->bindParam(":discod", $discod);
    if ($consultadisciplina->execute()) {
        $numregistros = $consultadisciplina->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesdisciplina[$i] = $consultadisciplina->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesdisciplina;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesdisciplina;
}

?>