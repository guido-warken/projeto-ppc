<?php
require_once 'c:\wamp64\www\projetoppc\dao\perfilConclusaoDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\competenciaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\cursoDao.php';
?>
<script src="js/validaformperfil.js"></script>
<script src="js/filtroperfil.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $competencias = buscarCompetencias();
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de perfil de
		conclusão de curso</h2>
	<br>
	<form action="" method="post">
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
	<h1 class="text-warning">
				Nenhum <abbr class="text-uppercase">ppc</abbr> cadastrado no sistema
			</h1>
			<br> <a href="?pagina=ppc&opcao=cadastrar">Clique aqui para cadastrar
				um novo ppc</a><br>
					<?php
    endif;
    ?>
			</div>
		<br>
		<div class="form-group">
	<?php
    $totalcompetencias = count($competencias);
    if ($totalcompetencias > 0) :
        ?>
	<label for="compcod">Selecione a competência: </label> <select
				class="form-control" id="compcod" name="compcod">
	<?php
        foreach ($competencias as $competencia) :
            ?>
	<option value="<?=$competencia['compcod']; ?>">
	<?=$competencia["compdes"]; ?>
	</option>
	<?php
        endforeach
        ;
        ?>
	</select>
	<?php
    else :
        ?>
	<h1 class="text-warning">Nenhuma competência cadastrada no sistema</h1>
			<br> <a href="?pagina=competencia&opcao=cadastrar">Clique aqui para
				cadastrar uma nova competência</a><br>
					<?php
    endif;
    ?>
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
    $compcod = isset($_POST["compcod"]) ? $_POST["compcod"] : "";
    try {
        if (inserirPerfilConclusao($ppccod, $compcod)) {
            echo "<h1 class= 'text-center text-success'>Perfil de Conclusão cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=perfil&opcao=consultar'>Clique aqui para consultar os perfis de conclusão cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $ppcs = buscarPpcs();
    $competencias = buscarCompetencias();
    ?>
		<h2 class="text-center text-primary bg-primary">Consulta de perfis de
		conclusão de curso</h2>
	<br> <a href="?pagina=perfil&opcao=cadastrar">Novo perfil de conclusão
		de curso</a><br>
	<form action="" method="post">
		<div class="form-group">
			<label>Selecione a opção: </label><br> <label class="label-check">
				listar perfis de conclusão por <abbr class="text-uppercase">ppc</abbr>:
				<input type="radio" name="escolha" value="ppc" class="form-check"
				id="opt1" onclick="gerenciarFiltro()">
			</label><br> <label class="label-check">listar perfis de conclusão
				por competência: <input type="radio" name="escolha"
				value="competencia" class="form-check" id="opt2"
				onclick="gerenciarFiltro()">
			</label>
		</div>
		<br>
		<div class="form-group" id="div-ppc">
		<?php
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
        ?>
		<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
			</label> <select id="ppccod" name="ppccod" class="form-control">
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
		<h1 class="text-warning">
				Nenhum <abbr class="text-uppercase">ppc</abbr> foi cadastrado no
				sistema
			</h1>
			<br> <a href="?pagina=ppc&opcao=cadastrar">Clique aqui para cadastrar
				um novo <abbr class="text-uppercase">ppc</abbr>
			</a><br>
		<?php
    endif;
    ?>
		</div>
		<div class="form-group" id="div-competencia">
		<?php
    $totalcompetencias = count($competencias);
    if ($totalcompetencias > 0) :
        ?>
		<label for="compcod">Selecione a competência: </label> <select
				id="compcod" name="compcod" class="form-control">
		<?php
        foreach ($competencias as $competencia) :
            ?>
		<option value="<?=$competencia['compcod']; ?>">
		<?=$competencia["compdes"]; ?> 
		</option>
		<?php
        endforeach
        ;
        ?>
		</select>
		<?php
    else :
        ?>
		<h1 class="text-warning">Nenhuma competência foi cadastrada no sistema</h1>
			<br> <a href="?pagina=competencia&opcao=cadastrar">Clique aqui para
				cadastrar uma nova competência</a><br>
		<?php
    endif;
    ?>
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="enviar" class="btn btn-default">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    $opcao = $_POST["escolha"];
    if ($opcao == "ppc") :
        $perfis = buscarPerfilConclusaoPorPpc($_POST["ppccod"]);
        $ppc = buscarPpcPorId($_POST["ppccod"]);
        $totalperfis = count($perfis);
        ?>
    <h2 class="text-center"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></h2>
    <?php
        if ($totalperfis > 0) :
            ?>
	<br>
	<h2 class="text-center">
		Número de perfis de conclusão de curso encontrados com este <abbr
			class="text-uppercase">ppc</abbr>: <?=$totalperfis; ?>
	</h2>
	<br>
	<table class="table table-bordered">
		<caption>
			Perfil de Conclusão de curso por <abbr class="text-uppercase">ppc</abbr>
		</caption>
		<thead>
			<tr>
				<th>Competência</th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>
			<?php
            foreach ($perfis as $perfil) :
                $competencia = buscarCompetenciaPorId($perfil["compcod"]);
                ?>
				<tr>
				<td><?=$competencia["compdes"]; ?></td>
				<td><a
					href="?pagina=perfil&opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>">Excluir</a>
				</td>
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
			Nenhum perfil de conclusão de curso cadastrado com este <abbr
				class="text-uppercase">ppc</abbr>
		</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo perfil de conclusão de
			curso</p>
	</div>
	<br>
			<?php
        endif;
     elseif ($opcao == "competencia") :
        $perfis = buscarPerfilConclusaoPorCompetencia($_POST["compcod"]);
        $competencia = buscarCompetenciaPorId($_POST["compcod"]);
        $totalperfis = count($perfis);
        if ($totalperfis > 0) :
            ?>
	        <h2 class="text-center"><?=$competencia["compdes"]; ?></h2>
	<br>
	<h2 class="text-center">
		Número de perfis de conclusão de curso encontrados com esta competência: <?= $totalperfis; ?>
	</h2>
	<br>
	<table class="table table-bordered">
		<caption>Perfil de Conclusão de curso por competência</caption>
		<thead>
			<tr>
				<th>Ano de vigência do <abbr class="text-uppercase">ppc</abbr></th>
				<th>Curso</th>
				<th>Visualizar <abbr class="text-uppercase">ppc</abbr></th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>
			<?php
            foreach ($perfis as $perfil) :
                $ppc = buscarPpcPorId($perfil["ppccod"]);
                ?>
				<tr>
				<td><?=$ppc["ppcanoini"]; ?></td>
				<td><?=$ppc["curnome"]; ?></td>
				<td><a href="?pagina=ppc&opcao=ler&ppccod=<?=$ppc["ppccod"]; ?>">Visualizar
						<abbr class="text-uppercase">ppc</abbr>
				</a></td>
				<td><a
					href="?pagina=perfil&opcao=excluir&ppccod=<?=$perfil['ppccod']; ?>&compcod=<?=$perfil['compcod']; ?>">Excluir</a>
				</td>
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
		<h1>Nenhum perfil de conclusão de curso cadastrado com esta
			competência</h1>
		<br>
		<p>Clique no link acima para cadastrar um novo perfil de conclusão de
			curso</p>
	</div>
	<br>
		<?php
        endif;
    endif;
 elseif ($_GET["opcao"] == "excluir") :
    $perfil = buscarPerfilConclusaoPorId($_GET["ppccod"], $_GET["compcod"]);
    $ppc = buscarPpcPorId($perfil["ppccod"]);
    $competencia = buscarCompetenciaPorId($perfil["compcod"]);
    $curso = buscarCursoPorId($ppc["curcod"]);
    ?>
	<h2 class="text-center text-primary bg-primary">Exclusão de Perfil de
		conclusão de curso</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir o perfil de conclusão de curso com a competência <?=$competencia["compdes"]; ?>, do <?=$curso["curnome"]; ?>, com o ano de vigência de <?=$ppc["ppcanoini"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação?<br> Ao
				confirmar, a operação não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="sim" onclick="submeterExclusao()">
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="não" onclick="negarExclusao()">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirPerfilConclusao($perfil["ppccod"], $perfil["compcod"])) {
                echo "<h1 class= 'text-center text-success'>Perfil de conclusão de curso excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=perfil&opcao=consultar'>Voltar à tela de consulta de perfil de conclusão</a>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o perfil de conclusão de curso não será excluído</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de cursos</button><br>";
    }
endif;
?>
			</div>
