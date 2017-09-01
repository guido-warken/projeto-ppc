<?php
require_once 'c:\wamp64\www\projetoppc\dao\eixoTecDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\cursoDao.php';
$conn = conectarAoBanco("localhost", "dbdep", "root", "");
?>
<script src="js/redirectcurso.js"></script>
<script src="js/validaformcurso.js"></script>
<div class="container">
<?php
if ($_GET["opcao"] == "cadastrar") :
    $eixostec = buscarEixosTec();
    ?>
    <h2 class="text-center text-primary bg-primary">Cadastro de cursos</h2>
	<br>
	<p class="text-info">Para cadastrar um curso, preencha os campos
		marcados com um asterisco e pintados em vermelho.</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="curnome">Nome do curso: <span>*</span></label> <input
				type="text" class="form-control" name="curnome" id="curnome"
				style="color: red;" placeholder="Nome do curso" required>
		</div>
		<br>
		<div class="form-group">
			<label for="curtit">Titulação obtida no término do curso: <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" name="curtit"
				id="curtit" placeholder="Titulação obtida no término do curso"
				style="color: red;" required></textarea>
		</div>
		<br>
		<div class="form-group">
			<?php
    $totaleixostec = count($eixostec);
    if ($totaleixostec > 0) :
        ?>
				<label for="eixcod">Selecione o eixo tecnológico: <span>*</span></label>
			<select class="form-control" name="eixcod" id="eixcod"
				style="color: red;">
				<option value="-1">Selecione</option>
<?php
        foreach ($eixostec as $eixotec) :
            ?>
			<option value="<?=$eixotec['eixcod']; ?>"><?=$eixotec["eixdesc"]; ?></option>
				<?php
        endforeach
        ;
        ?>
</select>
<?php
    else :
        ?>
        <div class="text-warning bg-info">
				<h1 class="text-center">Nenhum eixo tecnológico cadastrado no
					sistema</h1>
				<br> <a href="?pagina=eixotec&opcao=cadastrar">Cadastrar um novo
					eixo tecnológico</a>
			</div>
			<br>
<?php
    endif;
    ?>
			</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="salvar"
				name="bt-form-salvar">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $curnome = isset($_POST["curnome"]) ? $_POST["curnome"] : "";
    $curtit = isset($_POST["curtit"]) ? $_POST["curtit"] : "";
    $eixcod = isset($_POST["eixcod"]) ? $_POST["eixcod"] : "";
    $curso = ! empty($curnome) ? buscarCursoPorNome($curnome) : [];
    if (! empty($curso)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe um curso cadastrado com este nome.<br>";
        echo "Por favor, informe um novo nome de curso.</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if (empty($curnome) || empty($curtit)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de cadastro de cursos não foram preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    $curso = ! empty($curtit) ? buscarCursoPorTitulacao($curtit) : [];
    if (! empty($curso)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe um curso cadastrado com esta titulação.<br>";
        echo "Por favor, informe uma nova titulação para o curso a ser cadastrado.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if ($eixcod == - 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Selecione o eixo tecnológico vinculado ao curso a ser cadastrado.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirCurso($curnome, $curtit, $eixcod, $conn)) {
            echo "<h1 class= 'text-success'>Curso cadastrado com êxito!</h1><br>";
            echo "<a href='?pagina=curso&opcao=consultar'>Clique aqui para consultar os cursos cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo "Erro ao cadastrar o curso. <br>";
        echo "Causa do erro: " . $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    ?>
	<h2 class="text-center text-primary bg-primary">Consultando os cursos
		cadastrados</h2>
	<br> <a href="?pagina=curso&opcao=cadastrar">Cadastrar mais um curso</a>
	<br> <br>
	<?php
    $cursos = buscarCursos($conn);
    $totalcursos = count($cursos);
    if ($totalcursos > 0) :
        ?>
	<h2 class="text-center text-info">Número de cursos encontrados: <?= $totalcursos; ?></h2>
	<br>
	<table class="table table-bordered">
		<caption>Cursos</caption>
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
        foreach ($cursos as $curso) :
            $eixotec = buscarEixoTecPorId($curso["eixcod"], $conn);
            ?>
		<tr>
				<td><?= $curso["curnome"];?></td>
				<td><?= $curso["curtit"];?></td>
				<td><?= $eixotec["eixdesc"];?></td>
				<td><a
					href="?pagina=curso&opcao=alterar&curcod=<?= $curso['curcod'];?>">alterar
						dados</a></td>
				<td><a
					href="?pagina=curso&opcao=excluir&curcod=<?= $curso['curcod'];?>">excluir
						curso</a></td>
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
        <div class="text-warning bg-info">
		<h1 class="text-center">Nenhum curso cadastrado no momento.</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo curso.</p>
	</div>
	<br>
	<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $curso = buscarCursoPorId($_GET["curcod"], $conn);
    $eixotec = buscarEixoTecPorId($curso["eixcod"], $conn);
    $eixostec = buscarEixosTecExceto($eixotec["eixcod"], $conn);
    ?>
	<h2 class="text-center text-primary bg-primary">Alteração dos dados do
		curso selecionado</h2>
	<br>
	<p>Para alterar os dados do curso, altere os valores dos campos
		marcados com um asterisco, e pintados de vermelho.</p>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="curnome">Nome do curso: <span>*</span></label> <input
				type="text" class="form-control" name="curnome" id="curnome"
				value="<?=$curso['curnome']; ?>" style="color: red;" required>
		</div>
		<br>
		<div class="form-group">
			<label for="curtit">Titulação obtida no término do curso: <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" name="curtit"
				id="curtit" style="color: red;" required>
				<?= $curso["curtit"]; ?>
				</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="eixcod">Altere o eixo tecnológico: <span>*</span></label>
			<select class="form-control" name="eixcod" id="eixcod"
				style="color: red;">
				<option value="<?= $eixotec['eixcod']; ?>" selected="selected">
	<?=$eixotec["eixdesc"]; ?>
	</option>
	<?php
    $totaleixostec = count($eixostec);
    if ($totaleixostec > 0) :
        foreach ($eixostec as $eixotec) :
            ?>
	<option value="<?=$eixotec['eixcod']; ?>">
	<?=$eixotec["eixdesc"]; ?>
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
			<input type="submit" class="btn btn-default" value="alterar"
				name="bt-form-alterar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $curnome = isset($_POST["curnome"]) ? $_POST["curnome"] : "";
    $curtit = isset($_POST["curtit"]) ? $_POST["curtit"] : "";
    $eixcod = isset($_POST["eixcod"]) ? $_POST["eixcod"] : "";
    if (empty($curnome) || empty($curtit)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de alteração de cursos não foram preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário e clique no botão salvar";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (atualizarCurso($_POST["curnome"], $_POST["curtit"], $_POST["eixcod"], $curso["curcod"], $conn)) {
            echo "<h1 class='text-success'>Curso atualizado com êxito!</h1><br>";
            echo "<a href = '?pagina=curso&opcao=consultar'>Voltar à consulta de cursos</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $curso = buscarCursoPorId($_GET["curcod"], $conn);
    ?>
	<h2 class="text-center text-primary bg-primary">Exclusão do curso
		selecionado</h2>
	<br>
	<form action="" method="post">
		<div class="form-group">
			<p class="text-warning">
				Você está prestes a excluir o Curso <?=$curso["curnome"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação? <br>Ao
				executar esta operação, ela não poderá mais ser desfeita.
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
    if ($_POST["escolha"] == "sim") :
        try {
            if (excluirCurso($curso["curcod"], $conn)) {
                echo "<h1 class= 'text-success'>Curso excluído com êxito</h1><br>";
                echo "<a href='?pagina=curso&opcao=consultar'>Consultar novamente os cursos cadastrados</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    else :
        echo "<p>Ok, o curso não será excluído</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de cursos</button><br>";
    endif;
endif;
?>
	</div>
