<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirConteudoCurricular($ppccod, $discod, $eixtcod, $contfase, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaoConteudo = $conn->prepare("insert into conteudocurricular (ppccod, discod, eixtcod, contfase) values (:ppccod, :discod, :eixtcod, :contfase)");
    $insercaoConteudo->bindParam(":ppccod", $ppccod);
    $insercaoConteudo->bindParam(":discod", $discod);
    $insercaoConteudo->bindParam(":eixtcod", $eixtcod);
    $insercaoConteudo->bindParam(":contfase", $contfase);
    $resultado = $insercaoConteudo->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarConteudoCurricular($ppccod, $discod, $eixtcod, $contfase, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaoconteudo = $conn->prepare("update conteudocurricular set eixtcod = :eixtcod, contfase = :contfase where ppccod = :ppccod and discod = :discod");
    $atualizacaoconteudo->bindParam(":eixtcod", $eixtcod);
    $atualizacaoconteudo->bindParam(":contfase", $contfase);
    $atualizacaoconteudo->bindParam(":ppccod", $ppccod);
    $atualizacaoconteudo->bindParam(":discod", $discod);
    $resultado = $atualizacaoconteudo->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirConteudoCurricular($ppccod, $discod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delconteudo = $conn->prepare("delete from conteudocurricular where ppccod = :ppccod and discod = :discod");
    $delconteudo->bindParam(":ppccod", $ppccod);
    $delconteudo->bindParam(":discod", $discod);
    $resultado = $delconteudo->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarConteudoCurricularPorId($ppccod, $discod, &$conn = null)
{
    $informacoesconteudo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaconteudo = $conn->prepare("select * from conteudocurricular where ppccod = :ppccod and discod = :discod");
    $consultaconteudo->bindParam(":ppccod", $ppccod);
    $consultaconteudo->bindParam(":discod", $discod);
    if ($consultaconteudo->execute()) {
        $numregistros = $consultaconteudo->rowCount();
        if ($numregistros == 1) {
            $informacoesconteudo = $consultaconteudo->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoesconteudo;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesconteudo;
}

function buscarConteudosCurriculares(&$conn = null)
{
    $informacoesconteudo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaconteudo = $conn->query("select * from conteudocurricular");
    if ($consultaconteudo->execute()) {
        $numregistros = $consultaconteudo->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesconteudo[$i] = $consultaconteudo->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesconteudo;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesconteudo;
}

function buscarConteudosCurricularesPorPpc($ppccod, &$conn = null)
{
    $informacoesconteudo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaconteudo = $conn->prepare("select * from conteudocurricular where ppccod = :ppccod");
    $consultaconteudo->bindParam(":ppccod", $ppccod);
    if ($consultaconteudo->execute()) {
        $numregistros = $consultaconteudo->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesconteudo[$i] = $consultaconteudo->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesconteudo;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesconteudo;
}

function buscarConteudosCurricularesPorDisciplina($discod, &$conn = null)
{
    $informacoesconteudo = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultaconteudo = $conn->prepare("select * from conteudocurricular where discod = :discod");
    $consultaconteudo->bindParam(":discod", $discod);
    if ($consultaconteudo->execute()) {
        $numregistros = $consultaconteudo->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoesconteudo[$i] = $consultaconteudo->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoesconteudo;
        }
    }
    desconectarDoBanco($conn);
    return $informacoesconteudo;
}

?>