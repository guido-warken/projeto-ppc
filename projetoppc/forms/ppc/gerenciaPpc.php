<?php
require_once 'c:\wamp64\www\projetoppc\dao\cursoDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
$conn = conectarAoBanco("localhost", "dbdep", "root", "");
?>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    $cursos = buscarCursos($conn);
    ?>
    <h2 class="text-center text-primary bg-primary">
		Cadastro de <abbr class="text-uppercase">ppc</abbr>
	</h2>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label>Selecione a modalidade do <abbr class="text-uppercase">ppc</abbr>:
				<span>*</span>
			</label><br> <label>presencial <input class="form-check" type="radio"
				name="ppcmodal" value="presencial" id="opt1" tabindex="1">
			</label><br> <label>À distância<input class="form-check" type="radio"
				name="ppcmodal" value="À distância" id="opt2" tabindex="2">
			</label>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcobj">Objetivo do <abbr class="text-uppercase">ppc</abbr>:
				<span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="ppcobj"
				name="ppcobj" placeholder="Objetivo do PPC" required tabindex="3"></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcdesc">Descreva a estrutura curricular do <abbr
				class="text-uppercase">ppc</abbr>: <span>*</span>
			</label>
			<textarea rows="3" cols="3" id="ppcdesc" name="ppcdesc"
				class="form-control" placeholder="Estrutura curricular do PPC"
				required tabindex="4"></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcestagio">Descreva o estágio do <abbr
				class="text-uppercase">ppc</abbr>: <span>*</span>
			</label>
			<textarea rows="3" cols="3" id="ppcestagio" name="ppcestagio"
				class="form-control" placeholder="Estágio do PPC" required
				tabindex="5"></textarea>
		</div>
		<br>
		<div class="form-group">
			<?php
    $totalcursos = count($cursos);
    if ($totalcursos > 0) :
        ?>
				<label for="curcod">Selecione o curso vinculado ao <abbr
				class="text-uppercase">ppc</abbr>: <span>*</span>
			</label> <select class="form-control" name="curcod" id="curcod"
				tabindex="6">
				<option value="-1">selecione</option>
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
    else :
        ?>
        <div class="text-warning bg-info">
				<h1 class="text-center">Nenhum curso cadastrado.</h1>
				<br> <a href="?pagina=curso&opcao=cadastrar">Clique aqui para
					cadastrar um novo curso</a>
			</div>
			<br>
						<?php
        return;
    endif;
    ?>
			</div>
		<br>
		<div class="form-group">
			<label for="ppcanoini">Ano de início de vigência do <abbr
				class="text-uppercase">ppc</abbr>: <span>*</span>
			</label> <input type="number" name="ppcanoini" id="ppcanoini"
				class="form-control" required tabindex="7">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" class="btn btn-default"
				name="bt-form-salvar" tabindex="8">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $ppcmodal = isset($_POST["ppcmodal"]) ? $_POST["ppcmodal"] : "";
    $ppcobj = isset($_POST["ppcobj"]) ? $_POST["ppcobj"] : "";
    $ppcdesc = isset($_POST["ppcdesc"]) ? $_POST["ppcdesc"] : "";
    $ppcestagio = isset($_POST["ppcestagio"]) ? $_POST["ppcestagio"] : "";
    $curcod = isset($_POST["curcod"]) ? $_POST["curcod"] : "";
    $ppcanoini = isset($_POST["ppcanoini"]) ? $_POST["ppcanoini"] : "";
    $ppcs = ! empty($curcod) ? buscarPpcsPorCurso($curcod, $conn) : [];
    if (empty($ppcmodal) || empty($ppcobj) || empty($ppcdesc) || empty($ppcestagio) || ! is_numeric($ppcanoini)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de cadastro de <abbr class='text-uppercase'>ppc</abbr> não foram preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if ($curcod == - 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, selecione um curso.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if (! empty($ppcs)) :
        foreach ($ppcs as $ppc) :
            if ($ppc["ppcanoini"] == $ppcanoini) :
                echo "<div class='text-danger'>";
                echo "<p>";
                echo "Já existe um <abbr class='text-uppercase'>ppc</abbr> cadastrado com este ano, referente ao curso " . $ppc["curnome"] . ".<br>";
                echo "por favor, selecione outro ano de vigência para o <abbr class='text-uppercase'>ppc</abbr> a ser cadastrado.";
                echo "</p>";
                echo "</div>";
                echo "<br>";
                return;
                    endif;
            
        endforeach
        ;
                    endif;
    
    try {
        if (inserirPpc($ppcmodal, $ppcobj, $ppcdesc, $ppcestagio, $curcod, $ppcanoini, $conn)) {
            echo "<h1 class= 'text-center text-success'><abbr class='text-uppercase'>ppc</abbr> cadastrado com êxito!</h1><br>";
            echo "<a href= '?pagina=ppc&opcao=consultar'>Clique aqui para visualizar os Ppcs cadastrados</a><br>";
        } else {
            echo "Não deu pra salvar";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    $cursos = buscarCursos($conn);
    ?>
		<h2 class="text-center text-primary bg-primary">
		Consultando os <abbr class="text-uppercase">ppc</abbr>s cadastrados
	</h2>
	<br> <a href="?pagina=ppc&opcao=cadastrar">Novo ppc</a><br>
	<form action="" method="post" onsubmit="return validarConsulta()">
		<div class="form-group">
			<?php
    $totalcursos = count($cursos);
    if ($totalcursos > 0) :
        ?>
				<label for="curcod">Selecione o curso para visualizar os <abbr
				class="text-uppercase">ppc</abbr>s: <span>*</span>
			</label> <select class="form-control" name="curcod" id="curcod"
				tabindex="1">
				<option value="-1">Selecione</option>
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
    else :
        ?>
        <div class="text-warning bg-info">
				<h1 class="text-center">Nenhum curso cadastrado</h1>
				<br> <a href="?pagina=curso&opcao=cadastrar">Clique aqui para
					cadastrar um curso</a>
			</div>
			<br>
<?php
        return;
    endif;
    ?>
			</div>
		<br>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="enviar"
				name="bt-form-consultar" tabindex="2">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("bt-form-consultar", $_POST))
        return;
    $curcod = isset($_POST["curcod"]) ? $_POST["curcod"] : "";
    if ($curcod == - 1) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, selecione um curso para visualizar os <abbr class='text-uppercase'>ppc</abbr>s vinculados.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    $ppcs = ! empty($curcod) ? buscarPpcsPorCurso($curcod, $conn) : [];
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
        ?>
		<h2 class="text-center text-info">Número de PPcs encontrados: <?=$totalppcs; ?></h2>
	<br>
	<p>
		Clique em um dos <abbr class="text-uppercase">ppc</abbr>s abaixo para
		ler seu conteúdo.
	</p>
	<br>
	<ol class="list-group">
		<?php
        foreach ($ppcs as $ppc) :
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
        <div class="text-warning bg-info">
		<h1 class="text-center">
			Nenhum <abbr class="text-uppercase">ppc</abbr> cadastrado com este
			curso
		</h1>
		<br>
		<p>
			Clique no link acima para cadastrar um novo <abbr
				class="text-uppercase">ppc</abbr>
		</p>
	</div>
	<br>
		<?php
    endif;
 
elseif ($_GET["opcao"] == "ler") :
    $ppc = buscarPpcPorId($_GET["ppccod"], $conn);
    ?>
	<h1 class="text-center text-primary bg-primary"><?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></h1>
	<br>
	<div style="resize: both;">
		<h2>
			Modalidade do <abbr class="text-uppercase">ppc</abbr>:
		</h2>
		<br>
		<p><?=$ppc["ppcmodal"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>
			Objetivo do <abbr class="text-uppercase">ppc</abbr>:
		</h2>
		<br>
		<pre>
		<?=$ppc["ppcobj"]; ?>
		</pre>
	</div>
	<br>
	<div style="resize: both;">
		<h2>
			Descrição da estrutura curricular do <abbr class="text-uppercase">ppc</abbr>:
		</h2>
		<br>
		<pre>
		<?=$ppc["ppcdesc"]; ?>
		</pre>
	</div>
	<br>
	<div style="resize: both;">
		<h2>
			Normas de estágio do <abbr class="text-uppercase">ppc</abbr>:
		</h2>
		<br>
		<pre>
	<?=$ppc["ppcestagio"]; ?>	
		</pre>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-4">
			<a href="?pagina=ppc&opcao=alterar&ppccod=<?=$ppc['ppccod']; ?>">Alterar
				conteúdo</a>
		</div>
		<div class="col-sm-4">
			<a href="?pagina=ppc&opcao=excluir&ppccod=<?=$ppc['ppccod']; ?>">Excluir
				ppc</a>
		</div>
	</div>
	<br>
					<?php
 elseif ($_GET["opcao"] == "alterar") :
    $ppc = buscarPpcPorId($_GET["ppccod"], $conn);
    $curso = buscarCursoPorId($ppc["curcod"], $conn);
    $cursos = buscarCursosExceto($curso["curcod"], $conn);
    ?>
	<h2 class="text-center text-primary bg-primary">Alteração de ppc</h2>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label>Selecione a modalidade do curso: </label> <br>
				<?php
    if ($ppc["ppcmodal"] == "presencial") :
        ?>
				<label>presencial <input class="form-check" type="radio"
				name="ppcmodal" value="presencial" checked="checked" id="opt1"
				tabindex="1">
			</label><br> <label>À distância<input class="form-check" type="radio"
				name="ppcmodal" value="À distância" id="opt2" tabindex="2">
			</label>
				<?php
     elseif ($ppc["ppcmodal"] == "À distância") :
        ?>
				<label>presencial <input class="form-check" type="radio"
				name="ppcmodal" value="presencial" id="opt1" tabindex="1">
			</label><br> <label>À distância<input class="form-check" type="radio"
				name="ppcmodal" value="À distância" checked="checked" id="opt2"
				tabindex="2">
			</label>
				<?php
    endif;
    ?>
			</div>
		<br>
		<div class="form-group">
			<label for="ppcobj">Objetivo do <abbr class="text-uppercase">ppc</abbr>:
				<span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="ppcobj"
				name="ppcobj" placeholder="Objetivo do ppc"
				onfocus="formatarCampo()" required tabindex="3">
					<?=$ppc["ppcobj"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcdesc">Descreva a estrutura curricular do <abbr
				class="text-uppercase">ppc</abbr>: <span>*</span></label>
			<textarea rows="3" cols="3" id="ppcdesc" name="ppcdesc"
				class="form-control" placeholder="Estrutura curricular do PPC"
				required tabindex="4">
					<?=$ppc["ppcdesc"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="ppcestagio">Descreva o estágio do <abbr
				class="text-uppercase">ppc</abbr>: <span>*</span></label>
			<textarea rows="3" cols="3" id="ppcestagio" name="ppcestagio"
				class="form-control" placeholder="estágio do PPC" required
				tabindex="5">
					<?=$ppc["ppcestagio"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="curcod">Selecione o curso vinculado ao <abbr
				class="text-uppercase">ppc</abbr>: <span>*</span></label> <select
				class="form-control" name="curcod" id="curcod" tabindex="6">
				<option value="<?= $curso['curcod']; ?>" selected="selected">
			<?=$curso["curnome"]; ?>
			</option>
			<?php
    $totalcursos = count($cursos);
    if ($totalcursos > 0) :
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
			<label for="ppcanoini">Ano de início de vigência do <abbr
				class="text-center">ppc</abbr>: <span>*</span>
			</label> <input type="number" name="ppcanoini" id="ppcanoini"
				value="<?=$ppc['ppcanoini']; ?>" class="form-control" tabindex="7">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" class="btn btn-default"
				name="bt-form-alterar" tabindex="8">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("bt-form-alterar", $_POST))
        return;
    $ppcmodal = isset($_POST["ppcmodal"]) ? $_POST["ppcmodal"] : "";
    $ppcobj = isset($_POST["ppcobj"]) ? $_POST["ppcobj"] : "";
    $ppcdesc = isset($_POST["ppcdesc"]) ? $_POST["ppcdesc"] : "";
    $ppcestagio = isset($_POST["ppcestagio"]) ? $_POST["ppcestagio"] : "";
    $curcod = isset($_POST["curcod"]) ? $_POST["curcod"] : "";
    $ppcanoini = isset($_POST["ppcanoini"]) ? $_POST["ppcanoini"] : "";
    if (empty($ppcmodal) || empty($ppcobj) || empty($ppcdesc) || empty($ppcestagio) || empty($curcod) || ! is_numeric($ppcanoini)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de alteração de <abbr class='text-uppercase'>ppc</abbr> não foram preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    try {
        if (atualizarPpc($curcod, $ppcmodal, $ppcobj, $ppcdesc, $ppcestagio, $ppc["ppccod"], $ppcanoini, $conn)) {
            echo "<h1 class= 'text-center text-success'><abbr class='text-uppercase'>ppc</abbr> alterado com êxito! </h1><br>";
            echo "<a href= '?pagina=ppc&opcao=consultar'>Voltar à tela de consulta de ppc</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $ppc = buscarPpcPorId($_GET["ppccod"], $conn);
    $curso = buscarCursoPorId($ppc["curcod"], $conn);
    ?>
	<h2 class="text-center text-primary bg-primary">Exclusão de ppc</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
				Você está prestes a excluir o ppc <?=$ppc["ppcanoini"]; ?> - <?= $curso["curnome"]; ?>. Você tem certeza de que deseja
				realmente executar esta operação?<br>Após a confirmação, a operação
				não poderá ser desfeita.
			</p>
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="sim" class="btn btn-default"
				onclick="submeterExclusao()">
		</div>
		<br>
		<div class="form-group">
			<input type="button" value="não" class="btn btn-default"
				onclick="negarExclusao()">
		</div>
		<br>
	</form>
			<?php
    if (! array_key_exists("escolha", $_POST))
        return;
    if ($_POST["escolha"] == "sim") {
        try {
            if (excluirPpc($_GET["ppccod"], $conn)) {
                echo "<h1 class= 'text-center text-success'>Ppc excluído com êxito! </h1><br>";
                echo "<a href= '?pagina=ppc&opcao=consultar'>Clique aqui para voltar à consulta de ppcs</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
	</div>
