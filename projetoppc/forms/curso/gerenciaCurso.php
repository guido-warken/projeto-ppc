<?php
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
<?php
if ($_GET ["opcao"] == "cadastrar") :
	?>
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
	$eixostec = buscarEixos ( $conn );
	foreach ( $eixostec as $eixotec ) :
		?>
			<option value="<?=$eixotec['eixcod']; ?>"><?=$eixotec["eixdesc"]; ?></option>
				<?php
	endforeach
	;
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
		if (inserirCurso ( $_POST ["curnome"], $_POST ["curtit"], $_POST ["eixcod"], $conn )) {
			echo "<h1>Curso cadastrado com êxito!</h1><br>";
			echo "<a href='gerenciaCurso.php?opcao=consultar'>Clique aqui para consultar os cursos cadastrados</a><br>";
		}
	} catch ( PDOException $e ) {
		echo "Erro ao cadastrar o curso. <br>";
		echo "Causa do erro: " . $e->getMessage ();
	}
 elseif ($_GET ["opcao"] == "consultar") :
	?>
	<h2>Consultando os cursos cadastrados</h2>
		<br> <a href="gerenciaCurso.php?opcao=cadastrar">Cadastrar mais um
			curso</a> <br> <br>
	<?php
	$cursos = buscarCursosPorEixo ( $conn );
	if (count ( $cursos ) > 0) :
		?>
	<h2>Número de cursos encontrados: <?= count($cursos); ?></h2>
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
		foreach ( $cursos as $curso ) :
			?>
		<tr>
					<td><?= $curso["curnome"];?></td>
					<td><?= $curso["curtit"];?></td>
					<td><?= $curso["eixdesc"];?></td>
					<td><a
						href="gerenciaCurso.php?opcao=alterar&curcod=<?= $curso['curcod'];?>">alterar
							dados</a></td>
					<td><a
						href="gerenciaCurso.php?opcao=excluir&curcod=<?= $curso['curcod'];?>">excluir
							curso</a></td>
				</tr>
		<?php
		endforeach
		;
		?>
		</tbody>
		</table>
	<?php
	 elseif (count ( $cursos ) == 0) :
		?>
	<h1>Nenhum curso cadastrado no momento.</h1>
		<br> <a href="gerenciaCurso.php?opcao=cadastrar">Clique aqui para
			cadastrar um novo curso</a> <br>
	<?php
	endif;
 elseif ($_GET ["opcao"] == "alterar") :
	?>
	<h2>Alteração dos dados do curso selecionado</h2>
		<br>
	<?php
	$curso = buscarCursoPorId ( $_GET ["curcod"], $conn );
	?>
	<form action="" method="post">
			<div class="form-group">
				<label for="curnome">Nome do curso: </label> <input type="text"
					class="form-control" name="curnome" id="curnome"
					value="<?=$curso['curnome']; ?>">
			</div>
			<br>
			<div class="form-group">
				<label for="curtit">Titulação obtida no término do curso: </label>
				<textarea rows="3" cols="3" class="form-control" name="curtit"
					id="curtit">
				<?= $curso["curtit"]; ?>
				</textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="eixcod">Selecione o eixo tecnológico: </label> <select
					class="form-control" name="eixcod" id="eixcod">
<?php
	$eixotec = buscarEixoPorId ( $curso ["eixcod"], $conn );
	?>
	<option value="<?= $eixotec['eixcod']; ?>" selected="selected">
	<?=$eixotec["eixdesc"]; ?>
	</option>
	<?php
	$eixostec = buscarEixosexceto ( $eixotec ["eixcod"], $conn );
	foreach ( $eixostec as $eixotec ) :
		?>
	<option value="<?=$eixotec['eixcod']; ?>">
	<?=$eixotec["eixdesc"]; ?>
	</option>
	<?php
	endforeach
	;
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
		if (atualizarCurso ( $_POST ["curnome"], $_POST ["curtit"], $_POST ["eixcod"], $_GET ["curcod"], $conn )) {
			echo "<h1>Curso atualizado com êxito!</h1><br>";
			echo "<a href = 'gerenciacurso.php?opcao=consultar'>Voltar à consulta de cursos</a><br>";
		}
	} catch ( PDOException $e ) {
		echo $e->getMessage ();
	}
 elseif ($_GET ["opcao"] == "excluir") :
	$curso = buscarCursoPorId ( $_GET ["curcod"], $conn );
	?>
	<h2>Exclusão do curso selecionado</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p class="text-warning">
				Você está prestes a excluir um Curso. Você tem certeza de que deseja
				realmente excluir o curso <?=$curso["curnome"]; ?>? <br>Ao executar
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
			if (excluirCurso ( $_GET ["curcod"], $conn )) {
				echo "<h1>Curso excluído com êxito</h1><br>";
				echo "<a href='gerenciaCurso.php?opcao=consultar'>Consultar novamente os cursos cadastrados</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
	 elseif ($_POST ["escolha"] == "não") :
		header ( "Location: gerenciaCurso.php?opcao=consultar" );
	endif;
endif;
?>
	</div>
</body>
</html>