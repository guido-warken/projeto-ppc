<?php
require_once 'c:\xampp\htdocs\projetoppc\factory\connectionFactory.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\cursoDao.php';
require_once 'c:\xampp\htdocs\projetoppc\dao\ppcDao.php';
$conn = conectarAoBanco ( "localhost", "dbdep", "root", "" );

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gerenciamento de PPC</title>
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
			<h2>Cadastro de PPC</h2>
			<br>
			<div class="form-group">
				<label>Selecione a modalidade do curso: </label><br> <label>presencial
					<input class="form-check" type="radio" name="ppcmodal"
					value="presencial">
				</label><br> <label>À distância<input class="form-check"
					type="radio" name="ppcmodal" value="À distância">
				</label>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcobj">Objetivo do plano pedagógico do curso: </label>
				<textarea rows="3" cols="3" class="form-control" id="ppcobj"
					name="ppcobj"></textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcdesc">Descreva a estrutura curricular do PPC: </label>
				<textarea rows="3" cols="3" id="ppcdesc" name="ppcdesc"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcestagio">Descreva o estágio do curso: </label>
				<textarea rows="3" cols="3" id="ppcestagio" name="ppcestagio"
					class="form-control"></textarea>
			</div>
			<br>
			<div class="form-group">
			<?php
		$consultacurso = buscarCursosPorEixo ( $conn );
		if ($consultacurso->execute () && $consultacurso->rowCount () > 0) :
			?>
				<label for="curcod">Selecione o curso vinculado ao PPC: </label> <select
					class="form-control" name="curcod" id="curcod">
			<?php
			while ( $row = $consultacurso->fetch ( PDO::FETCH_ASSOC ) ) :
				?>
			<option value="<?= $row['curcod']; ?>">
			<?=$row["curnome"]; ?>
			</option>
			<?php
			endwhile
			;
			?>
			</select>
			<?php
			$consultacurso->closeCursor ();
		 elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) :
			?>
						<h1>Nenhum curso cadastrado.</h1>
				<br> <a href="../curso/gerenciaCurso.php?opcao=cadastrar">Clique
					aqui para cadastrar um novo curso</a><br>
						<?php
			$consultacurso->closeCursor ();
		endif;
		?>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcanoini">Ano de início de vigência do ppc: </label> <input
					type="number" name="ppcanoini" id="ppcanoini">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="salvar" class="btn btn-success">
			</div>
			<br>
		</form>
		<?php
		if (! array_key_exists ( "ppcmodal", $_POST ) && ! array_key_exists ( "ppcobj", $_POST ) && ! array_key_exists ( "ppcdesc", $_POST ) && ! array_key_exists ( "ppcestagio", $_POST ) && ! array_key_exists ( "curcod", $_POST ) && ! array_key_exists ( "ppcanoini", $_POST ))
			return;
		try {
			if (inserirPpc ( $conn, $_POST ["ppcmodal"], $_POST ["ppcobj"], $_POST ["ppcdesc"], $_POST ["ppcestagio"], $_POST ["curcod"], $_POST ["ppcanoini"] )) {
				echo "<h1>Ppc cadastrado com êxito!</h1><br>";
				echo "<a href= 'gerenciaPpc.php?opcao=consultar'>Clique aqui para visualizar os Ppcs cadastrados</a><br>";
			}
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
		}
		desconectarDoBanco ( $conn );
	 
	elseif ($_GET ["opcao"] == "consultar") :
		?>
		<h2>Consultando os PPCs cadastrados</h2>
		<br> <a href="gerenciaPpc.php?opcao=cadastrar">Novo ppc</a><br>
		<form action="" method="post">
			<div class="form-group">
			<?php
		$consultacurso = buscarCursoPorPpc ( $conn );
		if ($consultacurso->execute () && $consultacurso->rowCount () > 0) :
			?>
				<label for="curcod">Selecione o curso para visualizar os PPCs: </label>
				<select class="form-control" name="curcod" id="curcod">
<?php
			while ( $row = $consultacurso->fetch ( PDO::FETCH_ASSOC ) ) :
				?>
<option value="<?=$row['curcod']; ?>">
<?=$row["curnome"]; ?>
</option>
<?php
			endwhile
			;
			?>
				</select>
<?php
			$consultacurso->closeCursor ();
		 elseif ($consultacurso->execute () && $consultacurso->rowCount () == 0) :
			?>
<h1>Não há ppcs cadastrados</h1>
				<br> <a href="gerenciaPpc.php?opcao=cadastrar">Clique aqui para
					cadastrar um ppc</a><br>
<?php
			$consultacurso->closeCursor ();
		endif;
		?>
			</div>
			<br>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="enviar">
			</div>
			<br>
		</form>
		<?php
		if (! array_key_exists ( "curcod", $_POST ))
			return;
		$consultappc = buscarPpcsPorCurso ( $conn, $_POST ["curcod"] );
		if ($consultappc->execute () && $consultappc->rowCount () > 0) :
			?>
		<h2>Número de PPcs encontrados: <?=$consultappc->rowCount(); ?></h2>
		<br>
		<p>Clique em um dos PPCs abaixo para ler seu conteúdo.</p>
		<br>
		<ol class="list-group">
		<?php
			while ( $row = $consultappc->fetch ( PDO::FETCH_ASSOC ) ) :
				?>
		<li><a href="gerenciaPpc.php?opcao=ler&ppccod=<?=$row['ppccod']; ?>"><?=$row["ppcanoini"]; ?> - <?=$row["curnome"]; ?></a>
			</li>
			<?php
			endwhile
			;
			?>
		</ol>
		<?php
			$consultappc->closeCursor ();
					endif;
		
		desconectarDoBanco ( $conn );
	 elseif ($_GET ["opcao"] == "ler") :
		?>
	<h2>Apresentando o conteúdo do ppc selecionado:</h2>
		<br>
		<?php
		$consultappc = buscarPpcPorId ( $conn, $_GET ["ppccod"] );
		if ($consultappc->execute () && $consultappc->rowCount () > 0) :
			$row = $consultappc->fetch ( PDO::FETCH_ASSOC );
			?>
						<h2>Modalidade do ppc:</h2>
		<br>
		<p><?=$row["ppcmodal"]; ?></p>
		<br>
		<h2>Objetivo do ppc:</h2>
		<br>
		<pre>
		<?=$row["ppcobj"]; ?>
		</pre>
		<br>
		<h2>Descrição da estrutura curricular do ppc:</h2>
		<br>
		<pre>
		<?=$row["ppcdesc"]; ?>
		</pre>
		<br>
		<h2>Normas de estágio do ppc:</h2>
		<br>
		<pre>
	<?=$row["ppcestagio"]; ?>	
		</pre>
		<br> <a
			href="gerenciaPpc.php?opcao=alterar&ppccod=<?=$row['ppccod']; ?>">Alterar
			conteúdo</a><br> <a
			href="gerenciaPpc.php?opcao=excluir&ppccod=<?=$row['ppccod']; ?>">Excluir
			ppc</a><br> <a href="gerenciaPpc.php?opcao=consultar">Voltar à tela
			de consulta de ppc</a><br>
				<?php
	endif;
		
		$consultappc->closeCursor ();
		desconectarDoBanco ( $conn );
	 elseif ($_GET ["opcao"] == "alterar") :
		$consultappc = buscarPpcPorId ( $conn, $_GET ["ppccod"] );
		if ($consultappc->execute () && $consultappc->rowCount () > 0) :
			$row = $consultappc->fetch ( PDO::FETCH_ASSOC );
			?>
	<h2>Alterando o ppc</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<label>Selecione a modalidade do curso: </label> <br>
				<?php
			if ($row ["ppcmodal"] == "presencial") :
				?>
				<label>presencial <input class="form-check" type="radio"
					name="ppcmodal" value="presencial" checked="checked">
				</label><br> <label>À distância<input class="form-check"
					type="radio" name="ppcmodal" value="À distância">
				</label>
				<?php
			 elseif ($row ["ppcmodal"] == "À distância") :
				?>
				<label>presencial <input class="form-check" type="radio"
					name="ppcmodal" value="presencial">
				</label><br> <label>À distância<input class="form-check"
					type="radio" name="ppcmodal" value="À distância" checked="checked">
				</label>
				<?php
			endif;
			?>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcobj">Objetivo do plano pedagógico do curso: </label>
				<textarea rows="3" cols="3" class="form-control" id="ppcobj"
					name="ppcobj">
					<?=$row["ppcobj"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcdesc">Descreva a estrutura curricular do PPC: </label>
				<textarea rows="3" cols="3" id="ppcdesc" name="ppcdesc"
					class="form-control">
					<?=$row["ppcdesc"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcestagio">Descreva o estágio do curso: </label>
				<textarea rows="3" cols="3" id="ppcestagio" name="ppcestagio"
					class="form-control">
					<?=$row["ppcestagio"]; ?>
					</textarea>
			</div>
			<br>
			<div class="form-group">
			<?php
			$consultacurso = buscarCursoPorId ( $conn, $row ["curcod"] );
			if ($consultacurso->execute () && $consultacurso->rowCount () > 0) :
				?>
				<label for="curcod">Selecione o curso vinculado ao PPC: </label> <select
					class="form-control" name="curcod" id="curcod">
			<?php
				while ( $opcao = $consultacurso->fetch ( PDO::FETCH_ASSOC ) ) :
					?>
			<option value="<?= $opcao['curcod']; ?>" selected="selected">
			<?=$opcao["curnome"]; ?>
			</option>
			<?php
				endwhile
				;
				$consultacurso->closeCursor ();
			endif;
			
			$consultacurso = buscarCursosExceto ( $conn, $row ["curcod"] );
			if ($consultacurso->execute () && $consultacurso->rowCount () > 0) :
				while ( $opcoes = $consultacurso->fetch ( PDO::FETCH_ASSOC ) ) :
					?>
			<option value="<?=$opcoes['curcod']; ?>">
			<?=$opcoes["curnome"]; ?>
			</option>
			<?php
				endwhile
				;
				$consultacurso->closeCursor ();
			endif;
			
			?>
			</select>
			</div>
			<br>
			<div class="form-group">
				<label for="ppcanoini">Ano de início de vigência do ppc: </label> <input
					type="number" name="ppcanoini" id="ppcanoini"
					value="<?=$row['ppcanoini']; ?>">
			</div>
			<br>
			<div class="form-group">
				<input type="submit" value="alterar" class="btn btn-success">
			</div>
			<br>
		</form>
		<?php
			if (! array_key_exists ( "ppcmodal", $_POST ) && ! array_key_exists ( "ppcobj", $_POST ) && ! array_key_exists ( "ppcdesc", $_POST ) && ! array_key_exists ( "ppcestagio", $_POST ) && ! array_key_exists ( "curcod", $_POST ) && ! array_key_exists ( "ppcanoini", $_POST ))
				return;
			try {
				if (atualizarPpc ( $conn, $_POST ["curcod"], $_POST ["ppcmodal"], $_POST ["ppcobj"], $_POST ["ppcdesc"], $_POST ["ppcestagio"], $_GET ["ppccod"], $_POST ["ppcanoini"] )) {
					echo "<h1>PPC alterado com êxito! </h1><br>";
					echo "<a href= 'gerenciaPpc.php?opcao=consultar'>Voltar à tela de consulta de ppc</a><br>";
				}
			} catch ( PDOException $e ) {
				echo $e->getMessage ();
			}
			?>
	<?php
	endif;
		
		desconectarDoBanco ( $conn );
	 elseif ($_GET ["opcao"] == "excluir") :
		
		?>
	<h2>Exclusão de ppc</h2>
		<br>
		<form action="" method="post">
			<div class="form-group">
				<p>
					Você está prestes a excluir um ppc. Você tem certeza de que deseja
					realmente executar esta operação?<br>Após a confirmação, a operação
					não poderá ser desfeita.
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
		if (! array_key_exists ( "escolha", $_POST ))
			return;
		if ($_POST ["escolha"] == "sim") {
			try {
				if (excluirPpc ( $conn, $_GET ["ppccod"] )) {
					echo "<h1>Ppc excluído com êxito! </h1><br>";
					echo "<a href= 'gerenciaPpc.php?opcao=consultar'>Clique aqui para voltar à consulta de ppcs</a><br>";
				}
			} catch ( PDOException $e ) {
				echo $e->getMessage ();
			}
		} elseif ($_POST ["escolha"] == "não") {
			echo "<p>Ok, o ppc não será excluído</p><br>";
			header ( "Location: gerenciaPpc.php?opcao=consultar" );
		}
		desconectarDoBanco ( $conn );
	endif;
	?>
	</div>
</body>
</html>