<?php
require_once 'c:\wamp64\www\projetoppc\dao\indicadorDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de indicadores</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2>Cadastro de indicadores</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="inddesc">Digite o indicador: </label>
				<textarea rows="3" cols="3" id="inddesc" name="inddesc"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("inddesc", $_POST))
        return;
    try {
        if (inserirIndicador($_POST["inddesc"])) {
            echo "<h1>Indicador cadastrado com êxito!</h1><br>";
            echo "<a href= 'gerenciaIndicador.php?opcao=consultar'>Clique aqui para consultar os indicadores</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $indicadores = buscarIndicadores();
    $totalindicadores = count($indicadores);
    ?>
	<h2>Consulta de indicadores</h2>
		<br> <a href="gerenciaIndicador.php?opcao=cadastrar">Novo indicador</a><br>
	<?php
    if ($totalindicadores > 0) :
        ?>
	<h2>Numero de indicadores encontrados: <?=$totalindicadores; ?></h2>
		<br>
		<table class="table table-bordered">
			<caption>Indicadores</caption>
			<thead>
				<tr>
					<th>indicador</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
	<?php
        foreach ($indicadores as $indicador) :
            ?>
	<tr>
					<td><?=$indicador["inddesc"]; ?></td>
					<td><a
						href="gerenciaIndicador.php?opcao=alterar&indcod=<?=$indicador['indcod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="gerenciaIndicador.php?opcao=excluir&indcod=<?=$indicador['indcod']; ?>">Excluir
							indicador</a></td>
				</tr>
	<?php
        endforeach
        ;
        ?>
	</tbody>
		</table>
	<?php
    else :
        ?>
	<h1>Nenhum indicador cadastrado no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo indicador</p>
	<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $indicador = buscarIndicadorPorId($_GET["indcod"]);
    ?>
	<h2>Alteração do indicador selecionado</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="inddesc">Digite o indicador: </label>
				<textarea rows="3" cols="3" id="inddesc" name="inddesc"
					class="form-control">
					<?=$indicador["inddesc"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="alterar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("inddesc", $_POST))
        return;
    try {
        if (atualizarIndicador($indicador["indcod"], $_POST["inddesc"])) {
            echo "<h1>Indicador atualizado com êxito!</h1><br>";
            echo "<a href= 'gerenciaIndicador.php?opcao=consultar'>Clique aqui para consultar novamente os indicadores cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $indicador = buscarIndicadorPorId($_GET["indcod"]);
    ?>
	<h2>Exclusão do indicador selecionado</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p>
	Você está prestes a excluir o indicador <?=$indicador["inddesc"]; ?>.<br>
					Você tem certeza de que deseja executar esta operação?<br> Após a
					confirmação, a operação não poderá ser desfeita.
				</p>
			</div>
			<div class="form-group">
				<input type="submit" name="escolha" class="btn btn-success"
					value="sim">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" class="btn btn-success"
					value="não">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirIndicador($indicador["indcod"])) {
                echo "<h1>Indicador excluído com êxito!</h1><br>";
                echo "<a href= 'gerenciaIndicador.php?opcao=consultar'>Clique aqui para consultar novamente os indicadores</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        header("Location: gerenciaIndicador.php?opcao=consultar");
    }
endif;
?>
	</div>
</body>
</html>