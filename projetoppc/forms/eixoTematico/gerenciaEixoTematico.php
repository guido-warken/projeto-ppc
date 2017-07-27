<?php
require_once 'c:\wamp64\www\projetoppc\dao\eixoTematicoDao.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de eixos temáticos</title>
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
	<h2>Cadastro de eixos temáticos</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label for="eixtdes">Eixo temático: </label> <input type="text"
					name="eixtdes" id="eixtdes" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="salvar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("eixtdes", $_POST))
        return;
    try {
        if (inserirEixoTem($_POST["eixtdes"])) {
            echo "<h1>Eixo Temático cadastrado com êxito!</h1><br>";
            echo "<a href= 'gerenciaEixoTematico.php?opcao=consultar'>Clique aqui para consultar os eixos temáticos cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $eixostematicos = buscarEixosTem();
    ?>
	<h2>Consultando os eixos temáticos</h2>
		<br> <a href="gerenciaEixoTematico.php?opcao=cadastrar">Novo eixo
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
						href="gerenciaEixoTematico.php?opcao=alterar&eixtcod=<?=$eixo['eixtcod']; ?>">Alterar
							dados</a></td>
					<td><a
						href="gerenciaEixoTematico.php?opcao=excluir&eixtcod=<?=$eixo['eixtcod']; ?>">Excluir
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
	<h1>Nenhum eixo temático cadastrado no sistema</h1>
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
				<input type="submit" class="btn btn-success" value="alterar">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("eixtdes", $_POST))
        return;
    try {
        if (atualizarEixoTem($eixotematico["eixtcod"], $_POST["eixtdes"])) {
            echo "<h1>Eixo temático atualizado com êxito!</h1><br>";
            echo "<a href= 'gerenciaEixoTematico.php?opcao=consultar'>Clique aqui para consultar novamente os eixos temáticos</a><br>";
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
				<p>
	Você está prestes a excluir o eixo temático <?=$eixotematico["eixtdes"]; ?>.<br>
					Você realmente deseja executar esta operação?<br> Após a
					confirmação, esta operação não poderá ser desfeita.
				</p>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="sim"
					class="btn btn-success">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="não"
					class="btn btn-success">
			</div>
			<br>
		</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirEixoTematico($eixotematico["eixtcod"])) {
                echo "<h1>Eixo temático excluído com êxito!</h1><br>";
                echo "<a href= 'gerenciaEixoTematico.php?opcao=consultar'>Clique aqui para consultar novamente os eixos temáticos</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        header("Location: gerenciaEixoTematico.php?opcao=consultar");
    }
endif;
?>
	</div>
</body>
</html>