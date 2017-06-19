<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\eixoTecDao.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\cursoDao.php';
$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de cursos</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
<?php if ($_GET["opcao"] == "cadastrar"): ?>
<form action="" method="post">
			<h2>Cadastro de cursos</h2>
			<br>
			<div class="form-group">
				<label for="curnome">Nome do curso: </label> <input type="text"
					class="form-control" name="curnome" id="curnome">
			</div>
			<br>
			<div class="form-group">
				<label for="curtit">Titulação obtida no término do curso: </label>
				<textarea rows="3" cols="3" class="form-control" name="curtit"
					id="curtit"></textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="eixcod">Selecione o eixo tecnológico: </label> <select
					class="form-control" name="eixcod" id="eixcod">
<?php
	$consultaeixotec = buscarEixos ( $conn );
	if ($consultaeixotec->execute () && $consultaeixotec->rowCount () > 0) :
		while ( $row = $consultaeixotec->fetch ( PDO::FETCH_ASSOC ) ) :
			?>
			<option value="<?=$row['eixcod']; ?>"><?=$row["eixdesc"]; ?></option>
				<?php
		endwhile
		;
				endif;
	
	?>
</select>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="salvar">
			</div>
			<br>
		</form>
<?php
	if (! array_key_exists ( "curnome", $_POST ) && ! array_key_exists ( "curtit", $_POST ) && ! array_key_exists ( "eixcod", $_POST ))
		return;
	try {
		if (inserirCurso ( $conn, $_POST ["curnome"], $_POST ["curtit"], $_POST ["eixcod"] )) {
			echo "<h1>Curso cadastrado com êxito!</h1><br>";
			echo "<a href='gerenciaCurso.php?opcao=consultar'>Clique aqui para consultar os cursos cadastrados</a><br>";
		}
	} catch ( PDOException $e ) {
		echo "Erro ao cadastrar o curso. <br>";
		echo "Causa do erro: " . $e->getMessage ();
	}
	desconectarDoBanco ( $conn );
 elseif ($_GET ["opcao"] == "consultar") :
	?>
	<h2>Consultando os cursos cadastrados</h2>
		<br> <a href="gerenciaCurso.php?opcao=cadastrar">Cadastrar mais um
			curso</a> <br><br>
	<?php
	$consultacurso = buscarCursosPorEixo ( $conn );
	if ($consultacurso->execute () && $consultacurso->rowCount () > 0) :
		?>
	<h2>Número de cursos encontrados: <?= $consultacurso->rowCount();?></h2>
		<br>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Nome do Curso</th>
					<th>Titulação obtida do curso</th>
					<th>Eixo tecnológico</th>
					<th colspan="2">Ação</th>
				</tr>
			</thead>
			<tbody>
	<?php
		while ( $row = $consultacurso->fetch ( PDO::FETCH_ASSOC ) ) :
			?>
		<tr>
					<td><?= $row["curnome"];?></td>
					<td><?= $row["curtit"];?></td>
					<td><?= $row["eixdesc"];?></td>
					<td><a
						href="gerenciaCurso.php?opcao=alterar&curcod=<?= $row['curcod'];?>">alterar
							dados</a></td>
					<td><a
						href="gerenciaCurso.php?opcao=excluir&curcod=<?= $row['curcod'];?>">excluir
							curso</a></td>
				</tr>
		<?php endwhile;?>
		</tbody>
		</table>
	<?php
		$consultacurso->closeCursor ();
		desconectarDoBanco ( $conn );
	 elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) :
		?>
	<h1>Nenhum curso cadastrado no momento.</h1>
		<br> <a href="gerenciaCurso.php?opcao=cadastrar">Clique aqui para
			cadastrar um novo curso</a> <br>
	<?php
		$consultacurso->closeCursor ();
		desconectarDoBanco ( $conn );
	endif;
	?>
	<?php elseif ($_GET["opcao"] == "alterar"):?>
	<h2>Alterando os dados do curso selecionado</h2>
		<br>
	<?php
	$row = null;
	$consultacurso = buscarCursoPorId ( $conn, $_GET ["curcod"] );
	if ($consultacurso->execute () && $consultacurso->rowCount () > 0)
		$row = $consultacurso->fetch ( PDO::FETCH_ASSOC );
	?>
	<form action="" method="post">
			<div class="form-group">
				<label for="curnome">Nome do curso: </label> <input type="text"
					class="form-control" name="curnome" id="curnome"
					value="<?=$row['curnome']; ?>">
			</div>
			<br>
			<div class="form-group">
				<label for="curtit">Titulação obtida no término do curso: </label>
				<textarea rows="3" cols="3" class="form-control" name="curtit"
					id="curtit">
				<?= $row["curtit"]; ?>
				</textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="eixcod">Selecione o eixo tecnológico: </label> <select
					class="form-control" name="eixcod" id="eixcod">
<?php
	$consultaeixotec = buscarEixoPorId ( $conn, $row ["eixcod"] );
	if ($consultaeixotec->execute () && $consultaeixotec->rowCount () > 0) :
		while ( $opcao = $consultaeixotec->fetch ( PDO::FETCH_ASSOC ) ) :
			?>
	<option value="<?= $opcao['eixcod']; ?>" selected="selected">
	<?=$opcao["eixdesc"]; ?>
	</option>
	<?php
		endwhile
		;
	endif;
	
	$consultaeixotec = buscarEixosexceto ( $conn, $row ["eixcod"] );
	if ($consultaeixotec->execute () && $consultaeixotec->rowCount () > 0) :
		while ( $row = $consultaeixotec->fetch ( PDO::FETCH_ASSOC ) ) :
			?>
	<option value="<?=$row['eixcod']; ?>">
	<?=$row["eixdesc"]; ?>
	</option>
	<?php
		endwhile
		;
	endif;
	
	?>
</select>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="alterar">
			</div>
			<br>
		</form>
	<?php
	if (! array_key_exists ( "curnome", $_POST ) && ! array_key_exists ( "curtit", $_POST ) && array_key_exists ( "eixcod", $_POST ))
		return;
	try {
		if (atualizarCurso ( $conn, $_POST ["curnome"], $_POST ["curtit"], $_POST ["eixcod"], $_GET ["curcod"] )) {
			echo "<h1>Curso atualizado com êxito!</h1><br>";
			echo "<a href = 'gerenciacurso.php?opcao=consultar'>Voltar à consulta de cursos</a><br>";
		}
	} catch ( PDOException $e ) {
		echo $e->getMessage ();
	}
	desconectarDoBanco ( $conn );
 elseif ($_GET ["opcao"] == "excluir") :
	$consultacurso = buscarCursoPorId ( $conn, $_GET ["curcod"] );
	if ($consultacurso->execute () && $consultacurso->rowCount () > 0)
		$row = $consultacurso->fetch ( PDO::FETCH_ASSOC );
	?>
	<h2>Excluindo um curso</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p class="text-warning">
				Você está prestes a excluir um Curso. Você tem certeza de que deseja
				realmente excluir o curso <?=$row["curnome"]; ?>? <br>Ao executar
					esta operação, ela não poderá mais ser desfeita.
				</p>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="sim">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" name="escolha" value="não">
			</div>
			<br>
		</form>
	<?php
	if (! array_key_exists ( "escolha", $_POST ))
		return;
	if ($_POST ["escolha"] == "sim") :
		try {
			if (excluirCurso ( $conn, $_GET ["curcod"] )) {
				echo "<h1>Curso excluído com êxito</h1><br>";
				echo "<a href='gerenciaCurso.php?opcao=consultar'>Consultar novamente os cursos cadastrados</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	 elseif ($_POST ["escolha"] == "não") :
		echo "<p>Ok, o curso não será excluído. </p><br>";
		echo "<a href='gerenciaCurso.php?opcao=consultar'>Voltar à consulta de cursos</a>";
	endif;
	?>
	<?php
	desconectarDoBanco($conn);
	endif;?>
	</div>
</body>
</html>