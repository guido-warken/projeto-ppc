<?php
require_once 'c:\wamp64\www\projetoppc\dao\eixoTematicoDao.php';
?>
<script src="js/redirecteixotem.js"></script>
	<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2>Cadastro de eixos temáticos</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="eixtdes">Eixo temático: </label> <input type="text"
					name="eixtdes" id="eixtdes" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-default" value="salvar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("eixtdes", $_POST))
        return;
    try {
        if (inserirEixoTem($_POST["eixtdes"])) {
            echo "<h1>Eixo Temático cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotem&opcao=consultar'>Clique aqui para consultar os eixos temáticos cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $eixostematicos = buscarEixosTem();
    ?>
	<h2>Consultando os eixos temáticos</h2>
		<br> <a href="?pagina=eixotem&opcao=cadastrar">Novo eixo
			temático</a><br>
	<?php
    if (count($eixostematicos) > 0) :
        ?>
	<h2>Número de eixos temáticos encontrados: <?=count($eixostematicos); ?></h2>
		<br>
		<table class="table table-bordered">
			<caption>Eixos Temáticos</caption>
			<thead>
				<tr>
					<th>Eixo Temático</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
	<?php
        foreach ($eixostematicos as $eixo) :
            ?>
	<tr>
					<td><?=$eixo["eixtdes"]; ?></td>
					<td><a
						href="?pagina=eixotem&opcao=alterar&eixtcod=<?=$eixo['eixtcod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="?pagina=eixotem&opcao=excluir&eixtcod=<?=$eixo['eixtcod']; ?>">Excluir
							eixo temático</a></td>
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
	<h1 class="text-warning">Nenhum eixo temático cadastrado no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo eixo temático</p>
		<br>
	<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $eixotematico = buscarEixoTemPorId($_GET["eixtcod"]);
    ?>
	<h2>Alteração do eixo temático selecionado</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="eixtdes">Eixo temático: </label> <input type="text"
					name="eixtdes" id="eixtdes" class="form-control"
					value="<?=$eixotematico['eixtdes'] ?>">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-default" value="alterar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("eixtdes", $_POST))
        return;
    try {
        if (atualizarEixoTem($eixotematico["eixtcod"], $_POST["eixtdes"])) {
            echo "<h1 class= 'text-success'>Eixo temático atualizado com êxito!</h1><br>";
            echo "<a href= '?pagina=eixotem&opcao=consultar'>Clique aqui para consultar novamente os eixos temáticos</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $eixotematico = buscarEixoTemPorId($_GET["eixtcod"]);
    ?>
	<h2>Exclusão de eixo temático</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p class="text-warning">
	Você está prestes a excluir o eixo temático <?=$eixotematico["eixtdes"]; ?>.<br>
					Você realmente deseja executar esta operação?<br> Após a
					confirmação, esta operação não poderá ser desfeita.
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
            if (excluirEixoTem($eixotematico["eixtcod"])) {
                echo "<h1 class= 'text-success'>Eixo temático excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=eixotem&opcao=consultar'>Clique aqui para consultar novamente os eixos temáticos</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o eixo temático não será excluído.</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de eixos temáticos</button><br>";
    }
endif;
?>
	</div>
</body>
</html>