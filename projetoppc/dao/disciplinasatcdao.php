<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionfactory.php';

function vincularAtividadeComplementarAUmConteudoCurricular($ppccod, $discod, $atccod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("insert into disciplinasatc (ppccod, discod, atccod) values (:ppccod, :discod, :atccod)");
    $query->bindParam(":ppccod", $ppccod);
    $query->bindParam(":discod", $discod);
    $query->bindParam(":atccod", $atccod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function desvincularAtividadeComplementarDeUmConteudoCurricular($ppccod, $discod, $atccod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("delete from disciplinasatc where ppccod = :ppccod and discod = :discod and atccod = :atccod");
    $query->bindParam(":ppccod", $ppccod);
    $query->bindParam(":discod", $discod);
    $query->bindParam(":atccod", $atccod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarVinculosPorPpc($ppccod, &$conn = null)
{
    $vinculo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select disciplinasatc.*, atividadecomplementar.atcdesc from disciplinasatc inner join atividadecomplementar on disciplinasatc.atccod = atividadecomplementar.atccod and disciplinasatc.ppccod = :ppccod");
    $consulta->bindParam(":ppccod", $ppccod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $vinculo[$i] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $vinculo;
        }
    }
    desconectarDoBanco($conn);
    return $vinculo;
}

function buscarVinculosPorPpcEDisciplina($ppccod, $discod, &$conn = null)
{
    $vinculo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select disciplinasatc.*, atividadecomplementar.atcdesc from disciplinasatc inner join atividadecomplementar on disciplinasatc.atccod = atividadecomplementar.atccod and disciplinasatc.ppccod = :ppccod and disciplinasatc.discod = :discod");
    $consulta->bindParam(":ppccod", $ppccod);
    $consulta->bindParam(":discod", $discod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $vinculo[$i] = $consulta->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $vinculo;
        }
    }
    desconectarDoBanco($conn);
    return $vinculo;
}

function buscarVinculoPorId($ppccod, $discod, $atccod, &$conn = null)
{
    $vinculo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consulta = $conn->prepare("select * from disciplinasatc where ppccod = :ppccod and discod = :discod and atccod = :atccod");
    $consulta->bindParam(":ppccod", $ppccod);
    $consulta->bindParam(":discod", $discod);
    $consulta->bindParam(":atccod", $atccod);
    if ($consulta->execute()) {
        $numregistros = $consulta->rowCount();
        if ($numregistros == 1) {
            $vinculo = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $vinculo;
        }
    }
    desconectarDoBanco($conn);
    return $vinculo;
}

?>