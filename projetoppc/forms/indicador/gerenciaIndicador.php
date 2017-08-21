<?php
require_once 'c:\wamp64\www\projetoppc\dao\indicadorDao.php';
?>
<script src="js/redirectindicador.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center">Cadastro de indicadores</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="inddesc">Digite o indicador: </label>
			<textarea rows="3" cols="3" id="inddesc" name="inddesc"
				class="form-control"></textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" class="btn btn-default">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("inddesc", $_POST))
        return;
    try {
        if (inserirIndicador($_POST["inddesc"])) {
            echo "<h1 class= 'text-warning'>Indicador cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=indicador&opcao=consultar'>Clique aqui para consultar os indicadores</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $indicadores = buscarIndicadores();
    $totalindicadores = count($indicadores);
    ?>
	<h2 class="text-center">Consulta de indicadores</h2>
	<br> <a href="?pagina=indicador&opcao=cadastrar">Novo indicador</a><br>
	<?php
    if ($totalindicadores > 0) :
        ?>
	<h2>Número de indicadores encontrados: <?=$totalindicadores; ?></h2>
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
					href="?pagina=indicador&opcao=alterar&indcod=<?=$indicador['indcod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=indicador&opcao=excluir&indcod=<?=$indicador['indcod']; ?>">Excluir
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
        <div class="text-warning">
		<h1>Nenhum indicador cadastrado no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo indicador</p>
	</div>
	<br>
		<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $indicador = buscarIndicadorPorId($_GET["indcod"]);
    ?>
	<h2 class="text-center">Alteração do indicador selecionado</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="inddesc">Digite o indicador: </label>
			<textarea rows="3" cols="3" id="inddesc" name="inddesc"
				class="form-control">
					<?= $indicador["inddesc"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" class="btn btn-default">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("inddesc", $_POST))
        return;
    try {
        if (atualizarIndicador($indicador["indcod"], $_POST["inddesc"])) {
            echo "<h1 class= 'text-success'>Indicador atualizado com êxito!</h1><br>";
            echo "<a href= '?pagina=indicador&opcao=consultar'>Clique aqui para consultar novamente os indicadores cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $indicador = buscarIndicadorPorId($_GET["indcod"]);
    ?>
	<h2 class="text-center">Exclusão do indicador selecionado</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir o indicador <?=$indicador["inddesc"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, a operação não poderá ser desfeita.
			</p>
		</div>
		<div class="form-group">
			<input type="submit" name="escolha" class="btn btn-default"
				value="sim">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" name="escolha" class="btn btn-default"
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
                echo "<h1 class= 'text-success'>Indicador excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=indicador&opcao=consultar'>Clique aqui para consultar novamente os indicadores</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o indicador não será excluído</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de indicadores</button><br>";
    }
endif;
?>
	</div>
