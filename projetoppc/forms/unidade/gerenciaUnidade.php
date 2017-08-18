<?php
require_once 'c:\wamp64\www\projetoppc\dao\unidadeDao.php';
?>
<script src="js/redirectunidade.js"></script>
	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2>Cadastro de unidades SENAC</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="uninome">Nome da unidade SENAC: </label> <input
					type="text" name="uninome" id="uninome" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar" class="btn btn-success">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("uninome", $_POST))
        return;
    try {
        if (inserirUnidade($_POST["uninome"])) {
            echo "<h1>Unidade SENAC cadastrada com êxito!</h1><br>";
            echo "<a href= '?pagina=unidade&opcao=consultar'>Clique aqui para ver as unidades cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    ?>
		<h2>Consultando as unidades SENAC cadastradas</h2>
		<br> <a href="?pagina=unidade&opcao=cadastrar">Nova unidade SENAC</a><br>
							<?php
    $unidades = buscarUnidades();
    if (count($unidades) > 0) :
        ?>
				<h2>Número de unidades SENAC encontradas: <?=count($unidades); ?></h2>
		<br>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>unidade</th>
					<th colspan="2">ação</th>
				</tr>
			</thead>
			<tbody>
				<?php
        foreach ($unidades as $unidade) :
            ?>
				<tr>
					<td><?=$unidade["uninome"]; ?></td>
					<td><a
						href="?pagina=unidade&opcao=alterar&unicod=<?=$unidade['unicod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="?pagina=unidade&opcao=excluir&unicod=<?=$unidade['unicod']; ?>">excluir
							unidade SENAC</a></td>
				</tr>
				<?php
        endforeach
        ;
        ?>
				</tbody>
		</table>
				<?php
     elseif (count($unidades) == 0) :
        ?>
				<h2 class="text-warning">Não há unidades SENAC cadastradas no momento</h2>
		<br>
		<p>Clique no link acima para cadastrar uma nova unidade do SENAC no sistema.</p>
		 <br>
				<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    ?>
	<h2>Alterando os dados da unidade selecionada</h2>
		<br>
	<?php
    $unidade = buscarUnidadePorId($_GET["unicod"]);
    ?>
	<form action="" method="post">
			<div class="form-group">
				<label for="uninome">Nome da unidade SENAC: </label> <input
					type="text" name="uninome" id="uninome" class="form-control"
					value="<?=$unidade["uninome"]; ?>">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar" class="btn btn-default">
			</div>
			<br>
		</form>
		<?php
    if (! array_key_exists("uninome", $_POST))
        return;
    try {
        if (atualizarUnidade($unidade["unicod"], $_POST["uninome"])) {
            echo "<h1 class= 'text-success'>Unidade SENAC atualizada com êxito!</h1><br>";
            echo "<a href= '?pagina=unidade&opcao=consultar'>Clique aqui para consultar novamente as unidades SENAC </a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    ?>
		<h2>Excluindo a unidade SENAC</h2>
		<br>
		<?php
    $unidade = buscarUnidadePorId($_GET["unicod"]);
    ?>
		<form action="" method="post">
			<div class="form-group">
				<p class="text-warning">
					Você está prestes a excluir uma unidade do SENAC.<br>Você tem certeza de que deseja excluir a unidade <?=$unidade["uninome"]; ?>?<br>
					Após a confirmação, esta operação não poderá ser desfeita.
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
            if (excluirUnidade($unidade["unicod"])) {
                echo "<h1 class= 'text-success'>Unidade SENAC excluída com êxito!</h1><br>";
                echo "<a href= '?pagina=unidade&opcao=consultar'>Voltar à tela de consulta de unidades SENAC</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, a unidade SENAC não será excluída.</p>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de unidades SENAC</button><br>";
    }
endif;
?>
	</div>
