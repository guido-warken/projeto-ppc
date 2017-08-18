<?php
require_once 'c:\wamp64\www\projetoppc\dao\eixoTecDao.php';
?>

	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2>Cadastro de eixos tecnológicos</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="eixdesc">eixo tecnológico</label> <input type="text"
					id="eixdesc" name="eixdesc" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar" class="btn btn-default">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("eixdesc", $_POST))
        return;
    try {
        if (inserirEixoTec($_POST["eixdesc"])) {
            echo "<h1 class= 'text=warning'>Eixo tecnológico cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotec&opcao=consultar'>Clique aqui para consultar os eixos tecnológicos cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $eixostec = buscarEixosTec();
    $totaleixostec = count($eixostec);
    ?>
	<h2>Consulta de eixos tecnológicos</h2>
		<br> <a href="?pagina=eixotec&opcao=cadastrar">Novo eixo
			tecnológico</a><br>
	<?php
    if ($totaleixostec > 0) :
        ?>
		<h2>Número de eixos tecnológicos encontrados: <?=$totaleixostec; ?></h2>
		<br>
		<table class="table table-bordered">
			<caption>Eixos Tecnológicos</caption>
			<thead>
				<tr>
					<th>Eixo Tecnológico</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
		<?php
        foreach ($eixostec as $eixotec) :
            ?>
		<tr>
					<td><?=$eixotec["eixdesc"]; ?></td>
					<td><a
						href="?pagina=eixotec&opcao=alterar&eixcod=<?=$eixotec['eixcod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="?pagina=eixotec&opcao=excluir&eixcod=<?=$eixotec['eixcod']; ?>">Excluir
							eixo tecnológico</a></td>
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
		<h1>Nenhum eixo tecnológico cadastrado no sistema.</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo eixo tecnológico.</p>
		<br>
		<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $eixotec = buscarEixoTecPorId($_GET["eixcod"]);
    ?>
	<h2>Alteração do eixo tecnológico selecionado</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="eixdesc">eixo tecnológico</label> <input type="text"
					id="eixdesc" name="eixdesc" class="form-control"
					value="<?=$eixotec['eixdesc']; ?>">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="alterar" class="btn btn-default">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("eixdesc", $_POST))
        return;
    try {
        if (atualizarEixoTec($eixotec["eixcod"], $_POST["eixdesc"])) {
            echo "<h1 class= 'text-success'>Eixo Tecnológico atualizado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotec&opcao=consultar'>Clique aqui para consultar novamente os eixos tecnológicos</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $eixotec = buscarEixoTecPorId($_GET["eixcod"]);
    ?>
	<h2>Exclusão do eixo tecnológico selecionado</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p class="text-info">
	Você está prestes a excluir o eixo tecnológico <?=$eixotec["eixdesc"]; ?>.<br>
					Você tem certeza de que deseja executar esta operação?<br> Após a
					confirmação, esta ação não poderá ser desfeita.
				</p>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="sim"
					class="btn btn-default">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="não"
					class="btn btn-default">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirEixoTec($eixotec["eixcod"])) {
                echo "<h1 class= 'text-success'>Eixo tecnológico excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=eixotec&opcao=consultar'>Clique aqui para consultar novamente os eixos tecnológicos</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o eixo tecnológico não será excluído.</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de eixos tecnológicos</button>";
    }
endif;
?>
	</div>
