<?php

function conectarAoBanco($host, $nome_banco, $nome_usuario, $senha)
{
    $conn = new PDO("mysql:host=$host;dbname=$nome_banco;charset=utf8", $nome_usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

function desconectarDoBanco(&$connection)
{
    $connection = null;
}

?>