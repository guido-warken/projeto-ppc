<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirCompetencia($compdes, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $insercaocompetencia = $conn->prepare("insert into competencia (compdes) values (:compdes)");
    $insercaocompetencia->bindParam(":compdes", $compdes);
    $resultado = $insercaocompetencia->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarCompetencia($compdes, $compcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $atualizacaocompetencia = $conn->prepare("update competencia set compdes = :compdes where compcod = :compcod");
    $atualizacaocompetencia->bindParam(":compdes", $compdes);
    $atualizacaocompetencia->bindParam(":compcod", $compcod);
    $resultado = $atualizacaocompetencia->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirCompetencia($compcod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $delcompetencia = $conn->prepare("delete from competencia where compcod = :compcod");
    $delcompetencia->bindParam(":compcod", $compcod);
    $resultado = $delcompetencia->execute();
    ajustarChavesPrimariasCompetencia();
    ajustarAutoIncrementoCompetencia();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarCompetenciaPorId($compcod, &$conn = null)
{
    $informacoescomp = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacomp = $conn->prepare("select * from competencia where compcod = :compcod");
    $consultacomp->bindParam(":compcod", $compcod);
    if ($consultacomp->execute()) {
        $numregistros = $consultacomp->rowCount();
        if ($numregistros == 1) {
            $informacoescomp = $consultacomp->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoescomp;
        }
    }
    desconectarDoBanco($conn);
    return $informacoescomp;
}

function buscarCompetencias(&$conn = null)
{
    $informacoescomp = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacomp = $conn->query("select * from competencia");
    if ($consultacomp->execute()) {
        $numregistros = $consultacomp->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoescomp[$i] = $consultacomp->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoescomp;
        }
    }
    desconectarDoBanco($conn);
    return $informacoescomp;
}

function buscarCompetenciasOrdenadasPorDescricao(&$conn = null)
{
    $informacoescomp = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacomp = $conn->query("select * from competencia order by compdes");
    if ($consultacomp->execute()) {
        $numregistros = $consultacomp->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $informacoescomp[$i] = $consultacomp->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $informacoescomp;
        }
    }
    desconectarDoBanco($conn);
    return $informacoescomp;
}

function buscarCompetenciaPorDescricao($compdes, &$conn = null)
{
    $informacoescomp = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $consultacomp = $conn->prepare("select * from competencia where compdes = :compdes");
    $consultacomp->bindParam(":compdes", $compdes);
    if ($consultacomp->execute()) {
        $numregistros = $consultacomp->rowCount();
        if ($numregistros == 1) {
            $informacoescomp = $consultacomp->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $informacoescomp;
        }
    }
    desconectarDoBanco($conn);
    return $informacoescomp;
}

function ajustarChavesPrimariasCompetencia(&$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $competencias = buscarCompetencias();
    $query = $conn->prepare("update competencia set compcod = :compcod where compcod = :compcod2");
    $chave = 0;
    $numregistros = 0;
    foreach ($competencias as $competencia) {
        $chave ++;
        $query->bindParam(":compcod", $chave);
        $query->bindParam(":compcod2", $competencia["compcod"]);
        if ($query->execute())
            $numregistros ++;
    }
    desconectarDoBanco($conn);
    return $numregistros;
}

function ajustarAutoIncrementoCompetencia(&$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $competencias = buscarCompetencias();
    $autoincrement = count($competencias) + 1;
    $query = $conn->query("alter table competencia auto_increment = " . $autoincrement);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

?>