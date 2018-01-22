<?php
require_once 'c:\wamp64\www\projetoppc\dao\ofertaDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\ppcDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\unidadeDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\cursoDao.php';
?>
<script src="js/validaformoferta.js"></script>
<script src="js/filtrooferta.js"></script>

<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    $ppcs = buscarPpcs();
    $unidades = buscarUnidades();
    ?>
	<h2 class="text-center text-primary bg-primary">Cadastro de oferta de
		curso</h2>
	<br>
	<p>Campos com asterisco são obrigatórios</p>
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
        <div class="text-warning bg-info">
				<h1 class="text-center">Nenhum ppcCadastrado</h1>
				<br> <a href="?pagina=ppc&opcao=cadastrar">Clique aqui para
					cadastrar um novo Ppc</a>
			</div>
			<br>
		<?php
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
	<?php
    $totalunidades = count($unidades);
    if ($totalunidades > 0) :
        ?>
	<label>Selecione a unidade SENAC de oferta: </label> <select
				class="form-control" id="unicod" name="unicod">
	<?php
        foreach ($unidades as $unidade) :
            ?>
	<option value="<?=$unidade['unicod']; ?>">
	<?=$unidade["uninome"]; ?>
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
				<h1>Nenhuma unidade SENAC cadastrada</h1>
				<br> <a href="?pagina=unidade&opcao=cadastrar">Clique aqui para
					cadastrar uma nova unidade SENAC</a>
			</div>
			<br>
	<?php
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
			<label for="ofecont">Contexto educacional</label>
			<textarea rows="3" cols="3" id="ofecont" name="ofecont"
				class="form-control" required></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="ofevagasmat">Número de vagas matutinas: </label> <input
				type="number" id="ofevagasmat" name="ofevagasmat"
				class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label for="ofevagasvesp">Número de vagas vespertinas: </label> <input
				type="number" id="ofevagasvesp" name="ofevagasvesp"
				class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label for="ofevagasnot">Número de vagas noturnas: </label> <input
				type="number" id="ofevagasnot" name="ofevagasnot"
				class="form-control">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" class="btn btn-default"
				name="bt-form-salvar">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-salvar", $_POST)) :
        return;
    else :
        $ppccod = isset($_POST["ppccod"]) ? $_POST["ppccod"] : "";
        $unicod = isset($_POST["unicod"]) ? $_POST["unicod"] : "";
        $ofecont = isset($_POST["ofecont"]) ? $_POST["ofecont"] : "";
        $ofevagasmat = isset($_POST["ofevagasmat"]) ? $_POST["ofevagasmat"] : "";
        $ofevagasvesp = isset($_POST["ofevagasvesp"]) ? $_POST["ofevagasvesp"] : "";
        $ofevagasnot = isset($_POST["ofevagasnot"]) ? $_POST["ofevagasnot"] : "";
        $oferta = buscarOfertaPorId($ppccod, $unicod);
        if (empty($ofecont) || ! is_numeric($ofevagasmat) || ! is_numeric($ofevagasvesp) || ! is_numeric($ofevagasnot)) :
            echo "<div class= 'text-danger'>";
            echo "<p>Dados incorretos.<br> Um ou mais campos do formulário de cadastro de oferta de curso não foram preenchidos corretamente.<br> Preencha corretamente o formulário e clique no botão salvar.</p><br>";
            echo "</div>";
            return;
        endif;
        
        if (! empty($oferta)) :
            echo "<div class='text-danger'>";
            echo "<p>Já existe uma oferta cadastrada com o <abbr class='text-uppercase'>ppc</abbr> e com a unidade SENAC informados</p><br>";
            echo "<p>Por favor, selecione outro <abbr class='text-uppercase'>ppc</abbr> e outra unidade SENAC</p>";
            echo "</div>";
            return;
        endif;
        
        try {
            if (inserirOferta($ppccod, $unicod, $ofecont, $ofevagasmat, $ofevagasvesp, $ofevagasnot)) {
                echo "<h1 class= 'text-center text-success'>Oferta cadastrada com êxito!</h1><br>";
                echo "<a href = '?pagina=oferta&opcao=consultar'>Clique aqui para ver as ofertas de curso cadastradas</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    endif;
 elseif ($_GET["opcao"] == "consultar") :
    $ppcs = buscarPpcs();
    $unidades = buscarUnidades();
    ?>
	<h2 class="text-center text-primary bg-primary">Consulta de oferta</h2>
	<br> <a href="?pagina=oferta&opcao=cadastrar">Nova oferta</a><br>
	<form action="" method="post">
		<div class="form-group">
			<label>Selecione a opção: </label><br> <label class="label-check">Listar
				unidades SENAC por ppc: <input type="radio" name="escolha"
				class="form-check" value="ppc" id="opt1" onclick="gerenciarFiltro()">
			</label><br> <label class="label-check">Listar ppcs por unidades
				SENAC: <input type="radio" name="escolha" class="form-check"
				value="unidade" id="opt2" onclick="gerenciarFiltro()">
			</label>
		</div>
		<br>
		<div class="form-group" id="div-ppc" hidden="true">
	<?php
    $totalppcs = count($ppcs);
    if ($totalppcs > 0) :
        ?>
	<label for="ppccod">Selecione o <abbr class="text-uppercase">ppc</abbr>:
			</label> <select class="form-control" name="ppccod" id="ppccod">
				<option value="selecione">selecione</option>
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
        <div class="text-warning bg-info">
				<h1 class="text-center">
					Nenhum <abbr class="text-uppercase">ppc</abbr> cadastrado no
					sistema
				</h1>
				<br> <a href="?pagina=ppc&opcao=cadastrar">Cadastrar um novo <abbr
					class="text-uppercase">ppc</abbr></a>
			</div>
			<br>
	<?php
    endif;
    ?>
	</div>
		<div class="form-group" id="div-unidade" hidden="true">
	<?php
    $totalunidades = count($unidades);
    if ($totalunidades > 0) :
        ?>
	<label for="unicod">Selecione a unidade SENAC: </label> <select
				class="form-control" name="unicod" id="unicod">
				<option value="selecione">selecione</option>
	<?php
        foreach ($unidades as $unidade) :
            ?>
	<option value="<?=$unidade['unicod']; ?>">
	<?=$unidade["uninome"]; ?> 
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
				<h1 class="text-center">Nenhuma unidade SENAC cadastrada no sistema</h1>
				<br> <a href="?pagina=unidade&opcao=cadastrar">Cadastrar uma nova
					unidade SENAC</a>
			</div>
			<br>
	<?php
    endif;
    ?>
	</div>
		<br>
		<div class="form-group">
			<input type="submit" value="enviar" class="btn btn-default"
				name="bt-form-escolha">
		</div>
		<br>
	</form>
	<?php
    if (! array_key_exists("bt-form-escolha", $_POST)) :
        return;
    else :
        $opcao = isset($_POST["escolha"]) ? $_POST["escolha"] : "";
        if ($opcao == "ppc") :
            $ofertas = buscarOfertasPorPpc($_POST["ppccod"]);
            $ppc = buscarPpcPorId($_POST["ppccod"]);
            $totalofertas = count($ofertas);
            if ($totalofertas > 0) :
                ?>
            <div class="text-info">
		<h2 class="text-center">
			Número de unidades que ofertam este <abbr class="text-uppercase">ppc</abbr>: <?=$totalofertas; ?></h2>
		<br>
		<p>
			Clique em uma unidade abaixo para visualizar a sua oferta do <abbr
				class="text-uppercase">ppc</abbr>
		</p>
	</div>
	<br>
	<ol class="list-group">
<?php
                foreach ($ofertas as $oferta) :
                    $unidade = buscarUnidadePorId($oferta["unicod"]);
                    ?>
<li class="list-group-item"><a
			href="?pagina=oferta&opcao=ler&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>"><?=$unidade["uninome"]; ?></a>
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
			Nenhuma oferta encontrada com este <abbr class="text-uppercase">ppc</abbr>
		</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova oferta</p>
	</div>
	<br>
<?php
            endif;
         elseif ($opcao == "unidade") :
            $ofertas = buscarOfertasPorUnidade($_POST["unicod"]);
            $unidade = buscarUnidadePorId($_POST["unicod"]);
            $totalofertas = count($ofertas);
            if ($totalofertas > 0) :
                ?>
            <div class="text-info">
		<h2 class="text-center">
			Número de <abbr class="text-uppercase">ppc</abbr>s ofertados na unidade SENAC <?=$unidade["uninome"]; ?>: <?=$totalofertas; ?></h2>
		<br>
		<p>
			Clique em um <abbr class="text-uppercase">ppc</abbr> abaixo para
			visualizar a sua oferta
		</p>
	</div>
	<br>
	<ol class="list-group">
<?php
                foreach ($ofertas as $oferta) :
                    $ppc = buscarPpcPorId($oferta["ppccod"]);
                    ?>
<li class="list-group-item"><a
			href="?pagina=oferta&opcao=ler&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>"><?=$ppc["ppcanoini"];?> - <?=$ppc["curnome"]; ?></a>
		</li>
<?php
                endforeach
                ;
                ?>
</ol>
<?php
            else :
                ?>
            <div class="text-warning">
		<h1 class="text-center">Nenhuma oferta cadastrada com esta unidade
			SENAC</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova oferta</p>
	</div>
	<br>
<?php
            endif;
        else :
            ?>
        <div class="text-danger">
		<p>Impossível de pesquisar as ofertas. Por favor, selecione uma das
			duas opções acima.</p>
	</div>
	<br>
        <?php
            return;
        endif;
    endif;
 elseif ($_GET["opcao"] == "ler") :
    $oferta = buscarOfertaPorId($_GET["ppccod"], $_GET["unicod"]);
    $ppc = buscarPpcPorId($oferta["ppccod"]);
    $unidade = buscarUnidadePorId($oferta["unicod"]);
    ?>
<h2 class="text-center text-primary bg-primary"><?=$unidade["uninome"]; ?>, <?=$ppc["ppcanoini"]; ?> - <?=$ppc["curnome"]; ?></h2>
	<br>
	<div style="resize: both;">
		<h2>
			Ano de vigência do <abbr class="text-uppercase">ppc</abbr>
		</h2>
		<br>
		<p><?=$ppc["ppcanoini"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>unidade SENAC</h2>
		<br>
		<p><?=$unidade["uninome"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>curso</h2>
		<br>
		<p><?=$ppc["curnome"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>Contexto educacional</h2>
		<br>
		<p><?=$oferta["ofecont"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>Número de vagas matutinas</h2>
		<br>
		<p><?=$oferta["ofevagasmat"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>Número de vagas vespertinas</h2>
		<br>
		<p><?=$oferta["ofevagasvesp"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<h2>Número de vagas noturnas</h2>
		<br>
		<p><?=$oferta["ofevagasnot"]; ?></p>
	</div>
	<br>
	<div style="resize: both;">
		<a
			href="?pagina=oferta&opcao=alterar&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>">Alterar
			conteúdo</a>
	</div>
	<div style="resize: both;">
		<a
			href="?pagina=oferta&opcao=excluir&ppccod=<?=$oferta['ppccod']; ?>&unicod=<?=$oferta['unicod']; ?>">excluir
			oferta de <abbr class="text-uppercase">ppc</abbr>
		</a>
	</div>
	<div style="resize: both;">
		<a href="?pagina=oferta&opcao=consultar">Voltar à tela de consulta de
			ofertas</a>
	</div>
		<?php
 elseif ($_GET["opcao"] == "alterar") :
    $oferta = buscarOfertaPorId($_GET["ppccod"], $_GET["unicod"]);
    ?>
	<h2 class="text-center text-primary bg-primary">Alteração de oferta de
		cursos</h2>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="ofecont">Contexto educacional</label>
			<textarea rows="3" cols="3" id="ofecont" name="ofecont"
				class="form-control" onfocus="formatarCampo()" required>
					<?=$oferta["ofecont"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-control">
			<label for="ofevagasmat">Número de vagas matutinas: </label> <input
				type="number" id="ofevagasmat" name="ofevagasmat"
				class="form-control" value="<?=$oferta['ofevagasmat']; ?>">
		</div>
		<br>
		<div class="form-control">
			<label for="ofevagasvesp">Número de vagas vespertinas: </label> <input
				type="number" id="ofevagasvesp" name="ofevagasvesp"
				class="form-control" value="<?=$oferta['ofevagasvesp']; ?>">
		</div>
		<br>
		<div class="form-control">
			<label for="ofevagasnot">Número de vagas noturnas: </label> <input
				type="number" id="ofevagasnot" name="ofevagasnot"
				class="form-control" value="<?=$oferta['ofevagasnot']; ?>">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="alterar" class="btn btn-default"
				name="bt-form-alterar">
		</div>
		<br>
	</form>
		<?php
    if (! array_key_exists("bt-form-alterar", $_POST)) :
        return;
    else :
        $ofecont = isset($_POST["ofecont"]) ? $_POST["ofecont"] : "";
        $ofevagasmat = isset($_POST["ofevagasmat"]) ? $_POST["ofevagasmat"] : "";
        $ofevagasvesp = isset($_POST["ofevagasvesp"]) ? $_POST["ofevagasvesp"] : "";
        $ofevagasnot = isset($_POST["ofevagasnot"]) ? $_POST["ofevagasnot"] : "";
        if (empty($ofecont) || ! is_numeric($ofevagasmat) || ! is_numeric($ofevagasvesp) || ! is_numeric($ofevagasnot)) :
            echo "<div class= 'text-danger'>";
            echo "<p>Dados incorretos.<br> Um ou mais campos do formulário de alteração de oferta de curso não foram preenchidos corretamente.<br> Preencha corretamente o formulário e clique no botão salvar.</p><br>";
            echo "</div>";
            return;
		endif;
        
        try {
            if (atualizarOferta($oferta["ppccod"], $oferta["unicod"], $ofecont, $ofevagasmat, $ofevagasvesp, $ofevagasnot)) {
                echo "<h1 class='text-center text-success'>Oferta atualizada com êxito!</h1><br>";
                echo "<a href= '?pagina=oferta&opcao=consultar'>Voltar à tela de consulta de ofertas</a>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    endif;
 elseif ($_GET["opcao"] == "excluir") :
    $oferta = buscarOfertaPorId($_GET["ppccod"], $_GET["unicod"]);
    $unidade = buscarUnidadePorId($oferta["unicod"]);
    $ppc = buscarPpcPorId($oferta["ppccod"]);
    ?>
	<h2 class="text-center text-primary bg-primary">Exclusão de oferta de
		curso</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
	Você está prestes a excluir a oferta do curso <?=$ppc["curnome"]; ?>, com o <abbr
					class="text-uppercase">ppc</abbr> do ano de <?=$ppc["ppcanoini"]; ?>, na unidade SENAC <?=$unidade["uninome"]; ?>.<br>
				Você tem certeza de que deseja executar esta operação?<br> Após a
				confirmação, a operação não poderá ser desfeita.
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
            if (excluirOferta($oferta["ppccod"], $oferta["unicod"])) {
                echo "<h1 class='text-success'>Oferta excluída com êxito!</h1><br>";
                echo "<a href= '?pagina=oferta&opcao=consultar'>Voltar à tela de consulta de oferta</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, a oferta não será excluída.</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de ofertas de <abbr class='text-uppercase'>ppc</abbr></button><br>";
    }
endif;
?>
</div>
