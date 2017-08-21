<?php
require_once 'c:\wamp64\www\projetoppc\dao\competenciaDao.php';
?>
<script src= "js/redirectcompetencia.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
		<h2 class="text-center">Cadastro de competências</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="compdes">Competência: </label>
			<textarea rows="3" cols="3" id="compdes" name="compdes"
				class="form-control"></textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("compdes", $_POST))
        return;
    try {
        if (inserirCompetencia($_POST["compdes"])) {
            echo "<h1 class= 'text-success'>Competência cadastrada com êxito!</h1><br>";
            echo "<a href= '?pagina=competencia&opcao=consultar'>Clique aqui para consultar as competências cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $competencias = buscarCompetencias();
    ?>
		<h2 class="text-center">Consulta de competências</h2>
	<br> <a href="?pagina=competencia&opcao=cadastrar">Nova competência</a><br>
		<?php
    if (count($competencias) > 0) :
        ?>
		<h2>Número de competências encontradas: <?=count($competencias); ?></h2>
	<br>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Competência</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
		<?php
        foreach ($competencias as $competencia) :
            ?>
				<tr>
				<td><?=$competencia["compdes"]; ?></td>
				<td><a
					href="?pagina=competencia&opcao=alterar&compcod=<?=$competencia['compcod']; ?>">alterar
						dados</a></td>
				<td><a
					href="?pagina=competencia&opcao=excluir&compcod=<?=$competencia['compcod']; ?>">excluir</a>
				</td>
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
		<h2 class="text-warning">Nenhuma competência cadastrada</h2>
	<br> <a href="?pagina=competencia&opcao=cadastrar">Cadastrar uma nova
		competência</a><br>
		<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $competencia = buscarCompetenciaPorId($_GET["compcod"]);
    ?>
	<h2 class="text-center">Alteração de competência</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label for="compdes">Competência: </label>
			<textarea rows="3" cols="3" id="compdes" name="compdes"
				class="form-control">
					<?=$competencia["compdes"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="alterar">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("compdes", $_POST))
        return;
    try {
        if (atualizarCompetencia($_POST["compdes"], $competencia["compcod"])) {
            echo "<h1 class= 'text-success'>Competência atualizada com êxito!</h1><br>";
            echo "<a href= '?pagina=competencia&opcao=consultar'>Clique aqui para consultar novamente as competências</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $competencia = buscarCompetenciaPorId($_GET["compcod"]);
    ?>
	<h2 class= "text-center">Exclusão de competência</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<p class= "text-warning">
	Você está prestes a excluir a competência <?=$competencia["compdes"]; ?>. <br>Tem
				certeza de que deseja executar esta operação?<br> Após a
				confirmação, esta operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="sim" name="escolha"
				class="btn btn-default">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="não" name="escolha"
				class="btn btn-default">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirCompetencia($competencia["compcod"])) {
                echo "<h1 class= 'text-success'>Competência excluída com êxito!</h1><br>";
                echo "<a href= '?pagina=competencia&opcao=consultar'>Voltar à tela de competências</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, a competência não será excluída</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de competências</button><br>";
    }
endif;
?>
	</div>
