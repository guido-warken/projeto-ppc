<?php
require_once 'c:\wamp64\www\projetoppc\dao\pdiDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\unidadeDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de Pdi</title>
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
	<h2>Cadastro de Pdi</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
<?php
    $unidades = buscarUnidades();
    if (count($unidades) > 0) :
        ?>
<label for="unicod">Selecione a unidade SENAC, a qual será associado o
					novo PDI</label> <select class="form-control" id="unicod"
					name="unicod">
<?php
        foreach ($unidades as $unidade) :
            ?>
	<option value="<?=$unidade['unicod']; ?>"><?=$unidade["uninome"]; ?></option>
<?php
        endforeach
        ;
        ?>
				</select>
				<?php
     elseif (count($unidades) == 0) :
        ?>
				<h2>Não há unidades SENAC cadastradas no sistema</h2>
				<br> <a href="gerenciaUnidade.php?opcao=cadastrar">Cadastrar uma
					nova unidade SENAC</a><br>
				<?php
    endif;
    ?>
			</div>
			<br>
			<div class="form-group">
				<label for="pdianoini">Ano inicial do PDI</label> <input
					type="number" name="pdianoini" id="pdianoini" class="form-control"
					maxlength="4">
			</div>
			<br>
			<div class="form-group">
				<label for="pdianofim">Ano de finalização do PDI</label> <input
					type="number" class="form-control" id="pdianofim" name="pdianofim"
					maxlength="4">
			</div>
			<br>
			<div class="form-group">
				<label for="pdiensino">Digite / cole a política de ensino presente
					no PDI</label>
				<textarea rows="3" cols="3" class="form-control" id="pdiensino"
					name="pdiensino"></textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="pdipesquisa">Digite / cole a política de pesquisa e
					extensão presente no PDI</label>
				<textarea rows="3" cols="3" class="form-control" id="pdipesquisa"
					name="pdipesquisa"></textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="pdimetodo">Digite / cole a metodologia presente no PDI</label>
				<textarea rows="3" cols="3" class="form-control" id="pdimetodo"
					name="pdimetodo"></textarea>

			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="salvar">
			</div>
			<br>
		</form>
		<?php
    if (! array_key_exists("unicod", $_POST) && ! array_key_exists("pdianoini", $_POST) && ! array_key_exists("pdianofim", $_POST) && ! array_key_exists("pdiensino", $_POST) && ! array_key_exists("pdipesquisa", $_POST) && ! array_key_exists("pdimetodo", $_POST))
        return;
    try {
        if (inserirPdi($_POST["unicod"], $_POST["pdianoini"], $_POST["pdianofim"], $_POST["pdipesquisa"], $_POST["pdiensino"], $_POST["pdimetodo"])) {
            echo "<h1>Pdi cadastrado com êxito! </h1><br>";
            echo "<a href= 'gerenciaPdi.php?opcao=consultar'>Clique aqui para consultar os Pdis cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $unidades = buscarUnidadesPorPdi();
    ?>
	<h2>Consulta de Pdi</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
	<?php
    if (count($unidades) > 0) :
        ?>
	<label for="unicod">Selecione a unidade para a visualização do Pdi: </label>
				<select class="form-control" id="unicod" name="unicod">
	<?php
        foreach ($unidades as $unidade) :
            ?>
	<option value="<?=$unidade['unicod']; ?>"><?=$unidade["uninome"]; ?></option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
     elseif (count($unidades) == 0) :
        ?>
	<h2>Nenhum Pdi cadastrado no sistema</h2>
				<br> <a href="gerenciaPdi.php?opcao=cadastrar">Cadastrar um novo Pdi</a><br>
				<?php
    endif;
    ?>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="enviar">
			</div>
			<br>
		</form>
		<?php
    if (! array_key_exists("unicod", $_POST))
        return;
    $pdis = buscarPdisPorUnidade($_POST["unicod"]);
    if (count($pdis) > 0) :
        ?>
			<h2>Número de Pdis encontrados: <?=count($pdis); ?></h2>
		<br>
		<ol class="list-group">
		<?php
        foreach ($pdis as $pdi) :
            ?>
		<li class="list-group-item"><a
				href="gerenciaPdi.php?opcao=ler&pdicod=<?=$pdi['pdicod']; ?>"><?=$pdi["pdianoini"]; ?> - <?=$pdi["pdianofim"]; ?> <?=$pdi["uninome"]; ?></a>
			</li>
		<?php
        endforeach
        ;
		endif;
    
    ?>
		</ol>
		<?php
 elseif ($_GET["opcao"] == "ler") :
    $pdi = buscarPdiPorId($_GET["pdicod"]);
    $unidade = buscarUnidadePorId($pdi["unicod"]);
    ?>
		<h2>Exibindo o conteúdo do Pdi</h2>
		<br>
		<h2>Ano inicial do Pdi</h2>
		<br>
		<p>
		<?=$pdi["pdianoini"]; ?>
		</p>
		<br>
		<h2>Ano final do Pdi</h2>
		<br>
		<p>
		<?=$pdi["pdianofim"]; ?>
		</p>
		<br>
		<h2>Unidade SENAC</h2>
		<br>
		<p>
		<?=$unidade["uninome"]; ?>
		</p>
		<br>
		<h2>Política de ensino do Pdi</h2>
		<br>
		<pre>
		<?=$pdi["pdiensino"]; ?>
		</pre>
		<br>
		<h2>Política de pesquisa do Pdi</h2>
		<br>
		<pre>
		<?=$pdi["pdipesquisa"]; ?>
		</pre>
		<br>
		<h2>Metodologia do Pdi</h2>
		<br>
		<pre>
		<?=$pdi["pdimetodo"]; ?>
		</pre>
		<br> <a
			href="gerenciaPdi.php?opcao=alterar&pdicod=<?=$pdi['pdicod']; ?>">Alterar
			conteúdo</a><br> <a
			href="gerenciaPdi.php?opcao=excluir&pdicod=<?=$pdi['pdicod']; ?>">excluir
			Pdi</a><br>
			<?php
 elseif ($_GET["opcao"] == "alterar") :
    $pdi = buscarPdiPorId($_GET["pdicod"]);
    $unidade = buscarUnidadePorId($pdi["unicod"]);
    ?>
		<h2>Alteração de Pdi</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
<?php
    $unidades = buscarUnidadesExceto($unidade["unicod"]);
    ?>
<label for="unicod">Selecione a unidade SENAC, a qual será associado o
					novo PDI</label> <select class="form-control" id="unicod"
					name="unicod">
					<option value="<?=$unidade['unicod']; ?>" selected="selected"><?=$unidade["uninome"]; ?></option>
<?php
    foreach ($unidades as $unidade) :
        ?>
			<option value="<?=$unidade['unicod']; ?>"><?=$unidade["uninome"]; ?></option>
			<?php
    endforeach
    ;
    ?>
				</select>
			</div>
			<br>
			<div class="form-group">
				<label for="pdianoini">Ano inicial do PDI</label> <input
					type="number" name="pdianoini" id="pdianoini" class="form-control"
					maxlength="4" value="<?=$pdi['pdianoini']; ?>">
			</div>
			<br>
			<div class="form-group">
				<label for="pdianofim">Ano de finalização do PDI</label> <input
					type="number" class="form-control" id="pdianofim" name="pdianofim"
					maxlength="4" value="<?=$pdi['pdianofim']; ?>">
			</div>
			<br>
			<div class="form-group">
				<label for="pdiensino">Política de ensino do PDI</label>
				<textarea rows="3" cols="3" class="form-control" id="pdiensino"
					name="pdiensino">
					<?=$pdi["pdiensino"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="pdipesquisa">Política de pesquisa e extensão do PDI</label>
				<textarea rows="3" cols="3" class="form-control" id="pdipesquisa"
					name="pdipesquisa">
					<?=$pdi["pdipesquisa"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="pdimetodo">Metodologia do PDI</label>
				<textarea rows="3" cols="3" class="form-control" id="pdimetodo"
					name="pdimetodo">
					<?=$pdi["pdimetodo"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="alterar">
			</div>
			<br>
		</form>
		<?php
    if (! array_key_exists("unicod", $_POST) && ! array_key_exists("pdianoini", $_POST) && ! array_key_exists("pdianofim", $_POST) && ! array_key_exists("pdiensino", $_POST) && ! array_key_exists("pdipesquisa", $_POST) && ! array_key_exists("pdimetodo", $_POST))
        return;
    try {
        if (atualizarPdi($pdi["pdicod"], $_POST["unicod"], $_POST["pdianoini"], $_POST["pdianofim"], $_POST["pdipesquisa"], $_POST["pdiensino"], $_POST["pdimetodo"])) {
            echo "<h1>Pdi alterado com êxito!</h1><br>";
            echo "<a href= 'gerenciaPdi.php?opcao=consultar'>Clique aqui para consultar novamente os Pdis</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $pdi = buscarPdiPorId($_GET["pdicod"]);
    ?>
		<h2>Excluindo o Pdi</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p>
					Você está prestes a excluir um Pdi.<br> Tem certeza de que deseja
					executar esta operação?<br> Após a confirmação, a operação não
					poderá ser desfeita.
				</p>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="sim" class="btn btn-success"
					name="escolha">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="não" class="btn btn-success"
					name="escolha">
			</div>
			<br>
		</form>
		<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirPDI($pdi["pdicod"])) {
                echo "<h1>Pdi excluído com êxito!</h1><br>";
                echo "<a href= 'gerenciaPdi.php?opcao=consultar'>Clique aqui para voltar à tela de consulta de Pdis</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } elseif ($_POST["escolha"] == "não") {
        header("Location: gerenciaPdi.php?opcao=consultar");
    }
endif;
?>
	</div>
</body>
</html>