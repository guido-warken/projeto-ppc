<?php
require_once 'c:\wamp64\www\projetoppc\dao\cursoDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
$conn = conectarAoBanco("localhost", "dbdep", "root", "");
?>
<script src="js/redirectppc.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
		<form action="" method="post">
		<h2>Cadastro de PPC</h2>
		<br>
		<div class="form-group">
			<label>Selecione a modalidade do curso: </label><br> <label>presencial
				<input class="form-check" type="radio" name="ppcmodal"
				value="presencial">
			</label><br> <label>À distância<input class="form-check" type="radio"
				name="ppcmodal" value="À distância">
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
    $cursos = buscarCursos($conn);
    if (count($cursos) > 0) :
        ?>
				<label for="curcod">Selecione o curso vinculado ao PPC: </label> <select
				class="form-control" name="curcod" id="curcod">
			<?php
        foreach ($cursos as $curso) :
            ?>
			<option value="<?= $curso['curcod']; ?>">
			<?=$curso["curnome"]; ?>
			</option>
			<?php
        endforeach
        ;
        ?>
			</select>
			<?php
     elseif (count($cursos) == 0) :
        ?>
						<h1>Nenhum curso cadastrado.</h1>
			<br> <a href="../curso/gerenciaCurso.php?opcao=cadastrar">Clique aqui
				para cadastrar um novo curso</a><br>
						<?php
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
			<input type="submit" value="salvar" class="btn btn-default">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("ppcmodal", $_POST) && ! array_key_exists("ppcobj", $_POST) && ! array_key_exists("ppcdesc", $_POST) && ! array_key_exists("ppcestagio", $_POST) && ! array_key_exists("curcod", $_POST) && ! array_key_exists("ppcanoini", $_POST))
        return;
    try {
        if (inserirPpc($_POST["ppcmodal"], $_POST["ppcobj"], $_POST["ppcdesc"], $_POST["ppcestagio"], $_POST["curcod"], $_POST["ppcanoini"], $conn)) {
            echo "<h1 class= 'text-success'>Ppc cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=ppc&opcao=consultar'>Clique aqui para visualizar os Ppcs cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    ?>
		<h2>Consultando os PPCs cadastrados</h2>
	<br> <a href="?pagina=ppc&opcao=cadastrar">Novo ppc</a><br>
	<form action="" method="post">
		<div class="form-group">
			<?php
    $cursos = buscarCursos($conn);
    if (count($cursos) > 0) :
        ?>
				<label for="curcod">Selecione o curso para visualizar os PPCs: </label>
			<select class="form-control" name="curcod" id="curcod">
<?php
        foreach ($cursos as $curso) :
            ?>
<option value="<?=$curso['curcod']; ?>">
<?=$curso["curnome"]; ?>
</option>
<?php
        endforeach
        ;
        ?>
				</select>
<?php
     elseif (count($cursos) == 0) :
        ?>
<h1>Não há cursos cadastrados</h1>
			<br> <a href="?pagina=curso&opcao=cadastrar">Clique aqui para
				cadastrar um curso</a><br>
<?php
    endif;
    ?>
			</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="enviar">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("curcod", $_POST))
        return;
    $ppcsPorCurso = buscarPpcsPorCurso($_POST["curcod"], $conn);
    if (count($ppcsPorCurso) > 0) :
        ?>
		<h2>Número de PPcs encontrados: <?=count($ppcsPorCurso); ?></h2>
	<br>
	<p>Clique em um dos PPCs abaixo para ler seu conteúdo.</p>
	<br>
	<ol class="list-group">
		<?php
        foreach ($ppcsPorCurso as $ppc) :
            ?>
		<li class="list-group-item"><a
			href="?pagina=ppc&opcao=ler&ppccod=<?=$ppc['ppccod']; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></a>
		</li>
			<?php
        endforeach
        ;
        ?>
		</ol>
		<?php
    else :
        ?>
		<h1>Não há nenhum ppc cadastrado com este curso</h1>
	<br>
	<p>Clique no link acima para cadastrar um novo ppc</p>
	<br>
		<?php
    endif;
 
elseif ($_GET["opcao"] == "ler") :
    $ppc = buscarPpcPorId($_GET["ppccod"], $conn);
    ?>
	<h1><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></h1>
	<br>
	<div style="resize: both;">
		<h2>Modalidade do ppc:</h2>
		<br>
		<p><?=$ppc["ppcmodal"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>Objetivo do ppc:</h2>
		<br>
		<pre>
		<?=$ppc["ppcobj"]; ?>
		</pre>
	</div>
	<br>
	<div style="resize: both;">
		<h2>Descrição da estrutura curricular do ppc:</h2>
		<br>
		<pre>
		<?=$ppc["ppcdesc"]; ?>
		</pre>
	</div>
	<br>
	<div style="resize: both;">
		<h2>Normas de estágio do ppc:</h2>
		<br>
		<pre>
	<?=$ppc["ppcestagio"]; ?>	
		</pre>
	</div>
	<br>
	<div style="resize: both;">
		<a href="?pagina=ppc&opcao=alterar&ppccod=<?=$ppc['ppccod']; ?>">Alterar
			conteúdo</a>
	</div>
	<div style="resize: both;">
		<a href="?pagina=ppc&opcao=excluir&ppccod=<?=$ppc['ppccod']; ?>">Excluir
			ppc</a>
	</div>
					<?php
 elseif ($_GET["opcao"] == "alterar") :
    $ppc = buscarPpcPorId($_GET["ppccod"], $conn);
    ?>
	<h2>Alteração de ppc</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<label>Selecione a modalidade do curso: </label> <br>
				<?php
    if ($ppc["ppcmodal"] == "presencial") :
        ?>
				<label>presencial <input class="form-check" type="radio"
				name="ppcmodal" value="presencial" checked="checked">
			</label><br> <label>À distância<input class="form-check" type="radio"
				name="ppcmodal" value="À distância">
			</label>
				<?php
     elseif ($ppc["ppcmodal"] == "À distância") :
        ?>
				<label>presencial <input class="form-check" type="radio"
				name="ppcmodal" value="presencial">
			</label><br> <label>À distância<input class="form-check" type="radio"
				name="ppcmodal" value="À distância" checked="checked">
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
					<?=$ppc["ppcobj"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcdesc">Descreva a estrutura curricular do PPC: </label>
			<textarea rows="3" cols="3" id="ppcdesc" name="ppcdesc"
				class="form-control">
					<?=$ppc["ppcdesc"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcestagio">Descreva o estágio do curso: </label>
			<textarea rows="3" cols="3" id="ppcestagio" name="ppcestagio"
				class="form-control">
					<?=$ppc["ppcestagio"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<?php
    $curso = buscarCursoPorId($ppc["curcod"], $conn);
    ?>
				<label for="curcod">Selecione o curso vinculado ao PPC: </label> <select
				class="form-control" name="curcod" id="curcod">
				<option value="<?= $curso['curcod']; ?>" selected="selected">
			<?=$curso["curnome"]; ?>
			</option>
			<?php
    $cursos = buscarCursosExceto($curso["curcod"], $conn);
    if (count($cursos) > 0) :
        foreach ($cursos as $curso) :
            ?>
			<option value="<?=$curso['curcod']; ?>">
			<?=$curso["curnome"]; ?>
			</option>
			<?php
        endforeach
        ;
						endif;
    
    ?>
			</select>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcanoini">Ano de início de vigência do ppc: </label> <input
				type="number" name="ppcanoini" id="ppcanoini"
				value="<?=$ppc['ppcanoini']; ?>">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" class="btn btn-success">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("ppcmodal", $_POST) && ! array_key_exists("ppcobj", $_POST) && ! array_key_exists("ppcdesc", $_POST) && ! array_key_exists("ppcestagio", $_POST) && ! array_key_exists("curcod", $_POST) && ! array_key_exists("ppcanoini", $_POST))
        return;
    try {
        if (atualizarPpc($_POST["curcod"], $_POST["ppcmodal"], $_POST["ppcobj"], $_POST["ppcdesc"], $_POST["ppcestagio"], $_GET["ppccod"], $_POST["ppcanoini"], $conn)) {
            echo "<h1 class= 'text-success'>PPC alterado com êxito! </h1><br>";
            echo "<a href= '?pagina=ppc&opcao=consultar'>Voltar à tela de consulta de ppc</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $ppc = buscarPpcPorId($_GET["ppccod"], $conn);
    $curso = buscarCursoPorId($ppc["curcod"], $conn);
    ?>
	<h2>Exclusão de ppc</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<p class="text-warning">
				Você está prestes a excluir o ppc <?=$ppc["ppcanoini"]; ?> - <?= $curso["curnome"]; ?>. Você tem certeza de que deseja
				realmente executar esta operação?<br>Após a confirmação, a operação
				não poderá ser desfeita.
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
            if (excluirPpc($_GET["ppccod"], $conn)) {
                echo "<h1 class= 'text-success'>Ppc excluído com êxito! </h1><br>";
                echo "<a href= '?pagina=ppc&opcao=consultar'>Clique aqui para voltar à consulta de ppcs</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o ppc não será excluído.</p>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Clique aqui para voltar à tela de consulta de ppc</button>";
    }
endif;
?>
	</div>
