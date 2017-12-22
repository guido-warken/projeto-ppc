<?php
require_once 'c:\wamp64\www\projetoppc\factory\connectionFactory.php';

function inserirAtividadeComplementar($atcdesc, $atcch, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("insert into atividadecomplementar (atcdesc, atcch) values (:atcdesc, :atcch)");
    $query->bindParam(":atcdesc", $atcdesc);
    $query->bindParam(":atcch", $atcch);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function atualizarAtividadeComplementar($atccod, $atcdesc, $atcch, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("update atividadecomplementar set atcdesc = :atcdesc, atcch = :atcch where atccod = :atccod");
    $query->bindParam(":atcdesc", $atcdesc);
    $query->bindParam(":atcch", $atcch);
    $query->bindParam(":atccod", $atccod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function excluirAtividadeComplementar($atccod, &$conn = null)
{
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("delete from atividadecomplementar where atccod = :atccod");
    $query->bindParam(":atccod", $atccod);
    $resultado = $query->execute();
    desconectarDoBanco($conn);
    return $resultado;
}

function buscarAtividadeComplementarPorId($atccod, &$conn = null)
{
    $atividade = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("select * from atividadecomplementar where atccod = :atccod");
    $query->bindParam(":atccod", $atccod);
    if ($query->execute()) {
        $numregistros = $query->rowCount();
        if ($numregistros == 1) {
            $atividade = $query->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $atividade;
        }
    }
    desconectarDoBanco($conn);
    return $atividade;
}

function buscarAtividadeComplementarPorDescricao($atcdesc, &$conn = null)
{
    $atividade = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->prepare("select * from atividadecomplementar where atcdesc = :atcdesc");
    $query->bindParam(":atcdesc", $atcdesc);
    if ($query->execute()) {
        $numregistros = $query->rowCount();
        if ($numregistros == 1) {
            $atividade = $query->fetch(PDO::FETCH_ASSOC);
        } else {
            desconectarDoBanco($conn);
            return $atividade;
        }
    }
    desconectarDoBanco($conn);
    return $atividade;
}

function buscarAtividadesComplementares(&$conn = null)
{
    $atividades = [];
    if (is_null($conn))
        $conn = conectarAoBanco("localhost", "dbdep", "root", "");
    $query = $conn->query("select * from atividadecomplementar order by atcdesc");
    if ($query->execute()) {
        $numregistros = $query->rowCount();
        if ($numregistros > 0) {
            for ($i = 0; $i < $numregistros; $i ++) {
                $atividades[$i] = $query->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            desconectarDoBanco($conn);
            return $atividades;
        }
    }
    desconectarDoBanco($conn);
    return $atividades;
}

?>