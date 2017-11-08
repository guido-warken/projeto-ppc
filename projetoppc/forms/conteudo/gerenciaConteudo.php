<?php
require_once 'c:\wamp64\www\projetoppc\dao\conteudoCurricularDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\disciplinaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\eixoTematicoDao.php';
?>

<script src="js/filtroconteudo.js"></script>
<script src="js/validaformconteudo.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $disciplinas = buscarDisciplinas();
    $eixostematicos = buscarEixosTem();
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de conteúdo
		curricular</h2>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
	<?php
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
        ?>
	<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
			</label> <select class="form-control" id="ppccod" name="ppccod">
	<?php
        foreach ($ppcs as $ppc) :
            ?>
	<option value="<?=$ppc['ppccod']; ?>">
	<?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?>
	</option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
        <div class="text-warning">
				<h1 class="text-center">
					Nenhum <abbr class="text-center">ppc</abbr> cadastrado no sistema
				</h1>
				<br> <a href="?pagina=ppc&opcao=cadastrar">Clique aqui para
					cadastrar um ppc</a>
			</div>
			<br>
	<?php
        return;
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
	<?php
    $totaldisciplinas = count($disciplinas);
    if ($totaldisciplinas > 0) :
        ?>
	<label for="discod">Selecione a disciplina: </label> <select
				class="form-control" id="discod" name="discod">
	<?php
        foreach ($disciplinas as $disciplina) :
            ?>
	<option value="<?=$disciplina['discod']; ?>">
	<?=$disciplina["disnome"]; ?>
	</option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
        <div class="text-warning">
				<h1 class="text-center">Nenhuma disciplina cadastrada no sistema</h1>
				<br> <a href="?pagina=disciplina&opcao=cadastrar">Clique aqui para
					cadastrar uma disciplina</a>
			</div>
			<br>
	<?php
        return;
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
	<?php
    $totaleixostematicos = count($eixostematicos);
    if ($totaleixostematicos > 0) :
        ?>
	<label for="eixtcod">Selecione o eixo temático: </label> <select
				class="form-control" id="eixtcod" name="eixtcod">
	<?php
        foreach ($eixostematicos as $eixotematico) :
            ?>
	<option value="<?=$eixotematico['eixtcod']; ?>">
	<?=$eixotematico["eixtdes"]; ?>
	</option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
        <div class="text-warning">
				<h1 class="text-center">Nenhum eixo temático cadastrado no sistema</h1>
				<br> <a href="?pagina=eixotem&opcao=cadastrar">Clique aqui para
					cadastrar um eixo temático</a>
			</div>
			<br>
	<?php
        return;
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
			<label for="contfase">fase da disciplina: </label> <input
				type="number" id="contfase" name="contfase" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" class="btn btn-default"
				name="bt-form-salvar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $ppccod = isset($_POST["ppccod"]) ? $_POST["ppccod"] : "";
    $discod = isset($_POST["discod"]) ? $_POST["discod"] : "";
    $eixtcod = isset($_POST["eixtcod"]) ? $_POST["eixtcod"] : "";
    $contfase = isset($_POST["contfase"]) ? $_POST["contfase"] : "";
    if (! is_numeric($contfase)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "O campo fase da disciplina deve ser preenchido com número.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    try {
        if (inserirConteudoCurricular($ppccod, $discod, $eixtcod, $contfase)) {
            echo "<h1 class= 'text-center text-success'>Conteúdo curricular cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=conteudo&opcao=consultar'>Clique aqui para consultar os conteúdos curriculares cadastrados no sistema</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $ppcs = buscarPpcs();
    $disciplinas = buscarDisciplinas();
    ?>
		<h2 class="text-center text-primary bg-primary">Exibição dos conteúdos
		curriculares</h2>
	<br> <a href="?pagina=conteudo&opcao=cadastrar">Novo conteúdo
		curricular</a><br>
	<form action="" method="post">
		<label>Selecione a opção: </label><br>
		<div class="form-group">
			<label class="label-check">Pesquisar conteúdo curricular por <abbr
				class="text-uppercase">ppc</abbr>: <input type="radio"
				name="escolha" value="ppc" id="opt1" class="form-check"
				onclick="gerenciarFiltro()">
			</label><br> <label class="label-check">Pesquisar conteúdo curricular
				por disciplina: <input type="radio" name="escolha"
				value="disciplina" id="opt2" class="form-check"
				onclick="gerenciarFiltro()">
			</label>
		</div>
		<br>
		<div class="form-group" id="div-ppc">
			<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
			</label> <select name="ppccod" id="ppccod" class="form-control">
			<?php
    foreach ($ppcs as $ppc) :
        ?>
			<option value="<?=$ppc['ppccod']; ?>"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></option>
			<?php
    endforeach
    ;
    ?>
			</select>
		</div>
		<div class="form-group" id="div-disciplina">
			<label for="discod">Selecione a disciplina: </label> <select
				name="discod" id="discod" class="form-control">
			<?php
    foreach ($disciplinas as $disciplina) :
        ?>
			<option value="<?=$disciplina['discod']; ?>"><?=$disciplina["disnome"]; ?></option>
			<?php
    endforeach
    ;
    ?>
			</select>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="enviar" class="btn btn-default">
		</div>
	</form>
						<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $opcao = $_POST["escolha"];
    if ($opcao == "ppc") :
        $conteudos = buscarConteudosCurricularesPorPpc($_POST["ppccod"]);
        $ppc = buscarPpcPorId($_POST["ppccod"]);
        $totalconteudos = count($conteudos);
        if ($totalconteudos > 0) :
            ?>
<h2 class="text-center"><?= $ppc["ppcanoini"]; ?> - <?= $ppc["curnome"]; ?></h2>
	<table class="table table-bordered" style="resize: both;">
		<caption>
			Disciplinas por <abbr class="text-uppercase">ppc</abbr>
		</caption>
		<thead>
			<tr>
				<th>Disciplina</th>
				<th>Eixo temático</th>
				<th>Fase da disciplina</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
		<?php
            foreach ($conteudos as $conteudo) :
                $disciplina = buscarDisciplinaPorId($conteudo["discod"]);
                $eixotematico = buscarEixoTemPorId($conteudo["eixtcod"]);
                ?>
		<tr>
				<td><?=$disciplina["disnome"]; ?></td>
				<td><?=$eixotematico["eixtdes"]; ?></td>
				<td><?=$conteudo["contfase"]; ?>ª</td>
				<td><a
					href="?pagina=conteudo&opcao=alterar&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=conteudo&opcao=excluir&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Excluir
						conteudo curricular</a></td>
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
            <div class="text-warning">
		<h1>
			Nenhum conteúdo curricular cadastrado com este <abbr
				class="text-uppercase">ppc</abbr>
		</h1>
		<br>
		<p>Clique no link acima para cadastrar um conteúdo curricular</p>
	</div>
	<br>
		<?php
        endif;
     elseif ($opcao == "disciplina") :
        $conteudos = buscarConteudosCurricularesPorDisciplina($_POST["discod"]);
        $disciplina = buscarDisciplinaPorId($_POST["discod"]);
        $totalconteudos = count($conteudos);
        if ($totalconteudos > 0) :
            ?>
		<h2 class="text-center"><?=$disciplina["disnome"] ?></h2>
	<br>
	<table class="table table-bordered" style="resize: both;">
		<caption>
			<abbr class="text-uppercase">ppc</abbr>s por disciplina
		</caption>
		<thead>
			<tr>
				<th>ano de vigência do <abbr class="text-uppercase">ppc</abbr></th>
				<th>Nome do curso</th>
				<th colspan="3">Ação</th>
			</tr>
		</thead>
		<tbody>
		<?php
            foreach ($conteudos as $conteudo) :
                $ppc = buscarPpcPorId($conteudo["ppccod"]);
                ?>
		<tr>
				<td><?=$ppc["ppcanoini"]; ?></td>
				<td><?=$ppc["curnome"]; ?></td>
				<td><a href="?pagina=ppc&opcao=ler&ppccod=<?=$ppc['ppccod']; ?>">Visualizar
						<abbr class="text-uppercase">ppc</abbr>
				</a></td>
				<td><a
					href="?pagina=conteudo&opcao=alterar&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Alterar
						dados</a></td>
				<td><a
					href="?pagina=conteudo&opcao=excluir&ppccod=<?=$conteudo['ppccod']; ?>&discod=<?=$conteudo['discod']; ?>">Excluir
						conteudo curricular</a></td>
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
            <div class="text-warning">
		<h1>Nenhum conteúdo curricular cadastrado com esta disciplina</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo conteúdo curricular</p>
	</div>
	<br>
				<?php
        endif;
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $conteudo = buscarConteudoCurricularPorId($_GET["ppccod"], $_GET["discod"]);
    $eixotematico = buscarEixoTemPorId($conteudo["eixtcod"]);
    $eixostematicos = buscarEixosTemExceto($eixotematico["eixtcod"]);
    ?>
		<h2 class="text-center text-primary bg-primary">Alteração de conteúdo
		curricular</h2>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
	<?php
    $totaleixostematicos = count($eixostematicos);
    ?>
	<label for="eixtcod">Selecione o eixo temático: </label> <select
				class="form-control" id="eixtcod" name="eixtcod">
				<option value="<?=$eixotematico['eixtcod']; ?>" selected="selected">
					<?=$eixotematico["eixtdes"]; ?>
					</option>
	<?php
    if ($totaleixostematicos > 0) :
        foreach ($eixostematicos as $eixotematico) :
            ?>
	<option value="<?=$eixotematico['eixtcod']; ?>">
	<?=$eixotematico["eixtdes"]; ?>
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
			<label for="contfase">Número da fase da disciplina: </label> <input
				type="number" id="contfase" name="contfase" class="form-control"
				value="<?=$conteudo['contfase']; ?>">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" class="btn btn-default"
				name="bt-form-alterar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $eixtcod = isset($_POST["eixtcod"]) ? $_POST["eixtcod"] : "";
    $contfase = isset($_POST["contfase"]) ? $_POST["contfase"] : "";
    if (! is_numeric($contfase)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "O campo fase da disciplina deve ser preenchido com número.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    try {
        if (atualizarConteudoCurricular($conteudo["ppccod"], $conteudo["discod"], $eixtcod, $contfase)) {
            echo "<h1 class= 'text-success'>Conteúdo curricular atualizado com êxito!</h1><br>";
            echo "<a href= '?pagina=conteudo&opcao=consultar'>Clique aqui para consultar novamente os conteúdos curriculares</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $conteudo = buscarConteudoCurricularPorId($_GET["ppccod"], $_GET["discod"]);
    $ppc = buscarPpcPorId($conteudo["ppccod"]);
    $disciplina = buscarDisciplinaPorId($conteudo["discod"]);
    $eixotematico = buscarEixoTemPorId($conteudo["eixtcod"]);
    ?>
	<h2 class="text-center text-primary bg-primary">Exclusão de conteúdo
		curricular</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
				Você está prestes a excluir o conteudo curricular, referente ao <abbr
					class="text-uppercase">ppc</abbr> do curso <?=$ppc["curnome"]; ?>, com ano inicial de vigência em <?=$ppc["ppcanoini"]; ?>, com a disciplina <?=$disciplina["disnome"]; ?>, dada na <?=$conteudo["contfase"]; ?>ª fase.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, esta operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="button" class="btn btn-default" value="sim"
				onclick="submeterExclusao()">
		</div>
		<br>
		<div class="form-group">
			<input type="button" class="btn btn-default" value="não"
				onclick="negarExclusao()">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirConteudoCurricular($conteudo["ppccod"], $conteudo["discod"])) {
                echo "<h1 class= 'text-success'>Conteúdo curricular excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=conteudo&opcao=consultar'>Clique aqui para voltar à tela de consulta de conteúdos curriculares</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o conteúdo curricular não será excluído</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de conteúdos curriculares</button><br>";
    }
endif;
?>
	</div>
