<?php
require_once 'c:\wamp64\www\projetoppc\dao\disciplinaDao.php';
?>
<script src="js/redirectdisciplina.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2>Cadastro de disciplinas</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="disnome">Nome da disciplina: </label> <input type="text"
				class="form-control" id="disnome" name="disnome">
		</div>
		<br>
		<div class="form-group">
			<label for="disobj">Objetivos da disciplina: </label>
			<textarea rows="3" cols="3" id="disobj" name="disobj"
				class="form-control"></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="disch">Carga horária da disciplina: </label> <input
				type="number" id="disch" name="disch" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label for="discementa">Ementa da disciplina: </label>
			<textarea rows="3" cols="3" id="discementa" name="discementa"
				class="form-control"></textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("disnome", $_POST) && ! array_key_exists("disobj", $_POST) && ! array_key_exists("disch", $_POST) && ! array_key_exists("discementa", $_POST))
        return;
    try {
        if (inserirDisciplina($_POST["disnome"], $_POST["disobj"], $_POST["disch"], $_POST["discementa"])) {
            echo "<h1 class= 'text-success'>Disciplina cadastrada com êxito!</h1><br>";
            echo "<a href= '?pagina=disciplina&opcao=consultar'>Clique aqui para consultar as disciplinas cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $disciplinas = buscarDisciplinas();
    ?>
<h2>Exibição das disciplinas cadastradas</h2>
	<br> <a href="?pagina=disciplina&opcao=cadastrar">Nova disciplina</a><br>
<?php
    if (count($disciplinas) > 0) :
        ?>
<table class="table table bordered">
		<caption>Disciplinas</caption>
		<thead>
			<tr>
				<th>Nome da disciplina</th>
				<th>Objetivo da disciplina</th>
				<th>Carga horária da disciplina</th>
				<th>Ementa da disciplina</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
<?php
        foreach ($disciplinas as $disciplina) :
            ?>
<tr>
				<td><?=$disciplina["disnome"]; ?></td>
				<td><?=$disciplina["disobj"]; ?></td>
				<td><?=$disciplina["disch"]; ?></td>
				<td><?=$disciplina["discementa"]; ?></td>
				<td><a
					href="?pagina=disciplina&opcao=alterar&discod=<?=$disciplina['discod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=disciplina&opcao=excluir&discod=<?=$disciplina['discod']; ?>">Excluir
						disciplina</a></td>
			</tr>
<?php
        endforeach
        ;
        ?>
</tbody>
	</table>
<?php
     elseif (count($disciplinas) == 0) :
        ?>
        <div class="text-warning">
		<h2>Nenhuma disciplina cadastrada no momento</h2>
		<br>
		<p>Clique no link acima para cadastrar uma nova disciplina</p>
	</div>
	<br>
<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $disciplina = buscarDisciplinaPorId($_GET["discod"]);
    ?>
<h2 class="text-center">Alteração dos dados da disciplina selecionada</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="disnome">Nome da disciplina: </label> <input type="text"
				class="form-control" id="disnome" name="disnome"
				value="<?=$disciplina['disnome']; ?>">
		</div>
		<br>
		<div class="form-group">
			<label for="disobj">Objetivos da disciplina: </label>
			<textarea rows="3" cols="3" id="disobj" name="disobj"
				class="form-control">
					<?=$disciplina["disobj"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="disch">Carga horária da disciplina: </label> <input
				type="number" id="disch" name="disch" class="form-control"
				value="<?=$disciplina['disch']; ?>">
		</div>
		<br>
		<div class="form-group">
			<label for="discementa">Ementa da disciplina: </label>
			<textarea rows="3" cols="3" id="discementa" name="discementa"
				class="form-control">
					<?=$disciplina["discementa"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="alterar">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("disnome", $_POST) && ! array_key_exists("disobj", $_POST) && ! array_key_exists("disch", $_POST) && ! array_key_exists("discementa", $_POST))
        return;
    try {
        if (atualizarDisciplina($disciplina["discod"], $_POST["disnome"], $_POST["disobj"], $_POST["disch"], $_POST["discementa"])) {
            echo "<h1 class= 'text-success'>Disciplina atualizada com êxito!</h1><br>";
            echo "<a href= '?pagina=disciplina&opcao=consultar'>Clique aqui para consultar novamente as disciplinas</a>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $disciplina = buscarDisciplinaPorId($_GET["discod"]);
    ?>
	<h2>Exclusão da disciplina selecionada</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir a disciplina <?=$disciplina["disnome"]; ?>.<br>
				Você gostaria de executar esta operação?<br> Após a confirmação, a
				operação não poderá ser desfeita.<br>
			</p>
		</div>
		<br>
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
            if (excluirDisciplina($disciplina["discod"])) {
                echo "<h1 class= 'text-success'>Disciplina excluída com êxito!</h1><br>";
                echo "<a href= '?pagina=disciplina&opcao=consultar'>Clique aqui para voltar à tela de consulta de disciplinas</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, a disciplina não será excluída</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de disciplinas</button><br>";
    }
endif;
?>
	</div>
