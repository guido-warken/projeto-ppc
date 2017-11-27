<?php
require_once 'c:\wamp64\www\projetoppc\dao\pdiDao.php';
require_once 'c:\wamp64\www\projetoppc\dao\unidadeDao.php';
?>
<script src="js/validaformpdi.js"></script>
<div class="container">
	<?php
if ($_GET["opcao"] == "cadastrar") :
    ?>
	<h2 class="text-center text-primary bg-primary">
		Cadastro de <abbr class="text-uppercase">pdi</abbr>
	</h2>
	<br>
	<p class="text-info">Campos com asterisco são obrigatórios</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="pdianoini">Ano inicial do <abbr class="text-uppercase">pdi</abbr>:
				<span>*</span></label> <input type="number" name="pdianoini"
				id="pdianoini" class="form-control" value="<?php echo date("Y"); ?>"
				required>
		</div>
		<br>
		<div class="form-group">
			<label for="pdianofim">Ano de finalização do <abbr
				class="text-uppercase">pdi</abbr>: <span>*</span></label> <input
				type="number" class="form-control" id="pdianofim" name="pdianofim"
				value="<?php echo date("Y", strtotime("+1 year"));?>" required>
		</div>
		<br>
		<div class="form-group">
			<label for="pdiensino">Política de ensino presente no <abbr
				class="text-uppercase">pdi</abbr>: <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="pdiensino"
				name="pdiensino" placeholder="Política de ensino do PDI" required></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="pdipesquisa">Política de pesquisa e extensão presente no
				PDI</label>
			<textarea rows="3" cols="3" class="form-control" id="pdipesquisa"
				name="pdipesquisa" placeholder="Política de pesquisa do PDI"
				required></textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="pdimetodo">Metodologia presente no <abbr
				class="text-uppercase">pdi</abbr>: <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="pdimetodo"
				name="pdimetodo" placeholder="Metodologia do PDI" required></textarea>

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
    $pdianoini = isset($_POST["pdianoini"]) ? $_POST["pdianoini"] : "";
    $pdianofim = isset($_POST["pdianofim"]) ? $_POST["pdianofim"] : "";
    $pdiensino = isset($_POST["pdiensino"]) ? $_POST["pdiensino"] : "";
    $pdipesquisa = isset($_POST["pdipesquisa"]) ? $_POST["pdipesquisa"] : "";
    $pdimetodo = isset($_POST["pdimetodo"]) ? $_POST["pdimetodo"] : "";
    $pdi = ! empty($pdianoini) ? buscarPdiPorAnoInicial($pdianoini) : [];
    if (! is_numeric($pdianoini) || ! is_numeric($pdianofim) || empty($pdiensino) || empty($pdipesquisa) || empty($pdimetodo)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de cadastro de <abbr class='text-uppercase'>pdi</abbr> não foram preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if ($pdianoini > date("Y")) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, insira o ano atual de início de <abbr class='text-uppercase'>pdi</abbr>.";
        echo "</p>";
        echo "</div>";
        return;
    endif;
    
    if ($pdianofim <= $pdianoini) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, insira um ano de término de vigência de <abbr class='text-uppercase'>pdi</abbr> não antes do ano de início da vigência do mesmo.";
        echo "</p>";
        echo "</div>";
        return;
    endif;
    
    if (! empty($pdi)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe um <abbr class='text-uppercase'>pdi</abbr>cadastrado com este ano de início.<br>";
        echo "Preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirPdi($pdianoini, $pdianofim, $pdipesquisa, $pdiensino, $pdimetodo)) {
            echo "<h1 class= 'text-success'>Pdi cadastrado com êxito! </h1><br>";
            echo "<a href= '?pagina=pdi&opcao=consultar'>Clique aqui para consultar os Pdis cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "consultar") :
    ?>
	<h2 class="text-center text-primary bg-primary">
		Consulta de <abbr class="text-uppercase">pdi</abbr>
	</h2>
	<br> <a href="?pagina=pdi&opcao=cadastrar">Novo <abbr
		class="text-uppercase">pdi</abbr></a><br>
	
		<?php
    $pdis = buscarPdis();
    $totalpdis = count($pdis);
    if ($totalpdis > 0) :
        ?>
			<h2 class="text-center text-info">
		Número de <abbr class="text-uppercase">pdi</abbr>s encontrados: <?=$totalpdis; ?></h2>
	<br>
	<p>
		Clique em um <abbr class="text-uppercase">pdi</abbr> para visualizar
		seu conteúdo.
	</p>
	<br>
	<ol class="list-group">
		<?php
        foreach ($pdis as $pdi) :
            ?>
		<li class="list-group-item"><a
			href="?pagina=pdi&opcao=ler&pdicod=<?=$pdi['pdicod']; ?>"><?=$pdi["pdianoini"]; ?> - <?=$pdi["pdianofim"]; ?> mantenedora</a>
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
		<p>
			Não há <abbr class="text-uppercase">pdi</abbr>s cadastrados no
			sistema.<br> Favor cadastrar apenas um <abbr class="text-uppercase">pdi</abbr>.
		</p>
	</div>
	<br>
		<?php
        return;
    endif;
    ?>
    
		<?php
 elseif ($_GET["opcao"] == "ler") :
    $pdi = buscarPdiPorId($_GET["pdicod"]);
    ?>
		<h2 class="text-center text-primary bg-primary">
		<abbr class="text-uppercase">senac sc</abbr>
	</h2>
	<br>
	<div class="text-info">
		<h2 class="text-center">
			Ano inicial do <abbr class="text-uppercase">pdi</abbr>
		</h2>
		<br>
		<p>
		<?=$pdi["pdianoini"]; ?>
		</p>
	</div>
	<br>
	<div class="text-info">
		<h2 class="text-center">Ano final do Pdi</h2>
		<br>
		<p>
		<?=$pdi["pdianofim"]; ?>
		</p>
	</div>
	<br>
	<div class="text-info">
		<h2 class="text-center">Política de ensino do Pdi</h2>
		<br>
		<pre class="pre-scrollable">
		<?=$pdi["pdiensino"]; ?>
		</pre>
	</div>
	<br>
	<div class="text-info">
		<h2 class="text-center">Política de pesquisa do Pdi</h2>
		<br>
		<pre class="pre-scrollable">
		<?=$pdi["pdipesquisa"]; ?>
		</pre>
	</div>
	<br>
	<div class="text-info">
		<h2 class="text-center">Metodologia do Pdi</h2>
		<br>
		<pre class="pre-scrollable">
		<?=$pdi["pdimetodo"]; ?>
		</pre>
	</div>
	<br> <a href="?pagina=pdi&opcao=alterar&pdicod=<?=$pdi['pdicod']; ?>">Alterar
		conteúdo</a><br> <a
		href="?pagina=pdi&opcao=excluir&pdicod=<?=$pdi['pdicod']; ?>">excluir
		Pdi</a><br>
			<?php
 elseif ($_GET["opcao"] == "alterar") :
    $pdi = buscarPdiPorId($_GET["pdicod"]);
    ?>
		<h2 class="text-center text-primary bg-primary">
		Alteração de <abbr class="text-uppercase">pdi</abbr>
	</h2>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="pdianoini">Ano inicial do <abbr class="text-uppercase">pdi</abbr>
				<span>*</span></label> <input type="number" name="pdianoini"
				id="pdianoini" class="form-control" value="<?=$pdi['pdianoini']; ?>"
				required>
		</div>
		<br>
		<div class="form-group">
			<label for="pdianofim">Ano de finalização do <abbr
				class="text-uppercase">pdi</abbr> <span>*</span></label> <input
				type="number" class="form-control" id="pdianofim" name="pdianofim"
				value="<?=$pdi['pdianofim']; ?>" required>
		</div>
		<br>
		<div class="form-group">
			<label for="pdiensino">Política de ensino do <abbr
				class="text-uppercase">pdi</abbr> <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="pdiensino"
				name="pdiensino" onfocus="formatarCampo()" required>
					<?=$pdi["pdiensino"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="pdipesquisa">Política de pesquisa e extensão do <abbr
				class="text-uppercase">pdi</abbr> <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="pdipesquisa"
				name="pdipesquisa" required>
					<?=$pdi["pdipesquisa"]; ?>
					</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="pdimetodo">Metodologia do <abbr class="text-uppercase">pdi</abbr>
				<span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="pdimetodo"
				name="pdimetodo" required>
					<?=$pdi["pdimetodo"]; ?>
					</textarea>
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
    $pdianoini = isset($_POST["pdianoini"]) ? $_POST["pdianoini"] : "";
    $pdianofim = isset($_POST["pdianofim"]) ? $_POST["pdianofim"] : "";
    $pdiensino = isset($_POST["pdiensino"]) ? $_POST["pdiensino"] : "";
    $pdipesquisa = isset($_POST["pdipesquisa"]) ? $_POST["pdipesquisa"] : "";
    $pdimetodo = isset($_POST["pdimetodo"]) ? $_POST["pdimetodo"] : "";
    if (! is_numeric($pdianoini) || ! is_numeric($pdianofim) || empty($pdiensino) || empty($pdipesquisa) || empty($pdimetodo)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de cadastro de <abbr class='text-uppercase'>pdi</abbr> não foram preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
        endif;
    
    if ($pdianoini > date("Y")) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, insira o ano atual de início de <abbr class='text-uppercase'>pdi</abbr>.";
        echo "</p>";
        echo "</div>";
        return;
        endif;
    
    if ($pdianofim <= $pdianoini) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, insira um ano de término de <abbr class='text-uppercase'>pdi</abbr> não antes do ano de início do mesmo.";
        echo "</p>";
        echo "</div>";
        return;
        endif;
    
    try {
        if (atualizarPdi($pdi["pdicod"], $pdianoini, $pdianofim, $pdipesquisa, $pdiensino, $pdimetodo)) {
            echo "<h1 class='text-success'>Pdi alterado com êxito!</h1><br>";
            echo "<a href= '?pagina=pdi&opcao=consultar'>Clique aqui para consultar novamente os Pdis</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $pdi = buscarPdiPorId($_GET["pdicod"]);
    ?>
		<h2 class="text-center text-primary bg-primary">
		Exclusão de <abbr class="text-uppercase">pdi</abbr>
	</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="form-group">
			<p class="text-warning">
				Você está prestes a excluir o <abbr class="text-uppercase">pdi</abbr> com vigência de <?=$pdi["pdianoini"]; ?> até <?=$pdi["pdianofim"]; ?>.<br>
				Tem certeza de que deseja executar esta operação?<br> Após a
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
            if (excluirPDI($pdi["pdicod"])) {
                echo "<h1 class= 'text-success'>Pdi excluído com êxito!</h1><br>";
                echo "<a href= '?pagina=pdi&opcao=consultar'>Clique aqui para voltar à tela de consulta de Pdis</a><br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<p>Ok, o <abbr class= 'text-uppercase'>pdi</abbr> não será excluído.</p><br>";
        echo "<button type='button' class='btn btn-default' onclick='redireciona()'>Voltar à tela de consulta de <abbr class= 'text-uppercase'>pdis</abbr></button><br>";
    }
 elseif ($_GET["opcao"] == "importar") :
    $pdiinfo = import();
    ?>
<h2 class="text-center text-primary bg-primary">Novo pdi a partir de um
		já existente</h2>
	<br>
	<p>
		Você poderá cadastrar um novo <abbr class="text-uppercase">pdi</abbr>,
		sem precisar copiar e colar as políticas de pesquisa e extensão do <abbr
			class="text-uppercase">pdi</abbr> antigo.<br> Basta digitar o ano de
		início e fim da vigência, e o sistema importará os dados das políticas
		de pesquisa e extensão.
	</p>
	<br>
	<p>Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="pdianoini">Ano inicial do <abbr class="text-uppercase">pdi</abbr>:
				<span>*</span></label> <input type="number" name="pdianoini"
				id="pdianoini" class="form-control" value="<?php echo date("Y"); ?>"
				required>
		</div>
		<br>
		<div class="form-group">
			<label for="pdianofim">Ano de finalização do <abbr
				class="text-uppercase">pdi</abbr>: <span>*</span></label> <input
				type="number" class="form-control" id="pdianofim" name="pdianofim"
				value="<?php echo date("Y", strtotime("+1 year"));?>" required>
		</div>
		<br>
		<div class="form-group">
			<label for="pdiensino">Política de ensino presente no <abbr
				class="text-uppercase">pdi</abbr>: <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="pdiensino"
				name="pdiensino" placeholder="Política de ensino do PDI" required
				onfocus="formatarCampo()">
				<?=$pdiinfo["pdiensino"]; ?>
				</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="pdipesquisa">Política de pesquisa e extensão presente no
				PDI</label>
			<textarea rows="3" cols="3" class="form-control" id="pdipesquisa"
				name="pdipesquisa" placeholder="Política de pesquisa do PDI"
				required>
				<?=$pdiinfo["pdipesquisa"]; ?>
				</textarea>
		</div>
		<br>
		<div class="form-group">
			<label for="pdimetodo">Metodologia presente no <abbr
				class="text-uppercase">pdi</abbr>: <span>*</span></label>
			<textarea rows="3" cols="3" class="form-control" id="pdimetodo"
				name="pdimetodo" placeholder="Metodologia do PDI" required>
				<?=$pdiinfo["pdimetodo"]; ?>
				</textarea>

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
    $pdianoini = isset($_POST["pdianoini"]) ? $_POST["pdianoini"] : "";
    $pdianofim = isset($_POST["pdianofim"]) ? $_POST["pdianofim"] : "";
    $pdiensino = isset($_POST["pdiensino"]) ? $_POST["pdiensino"] : "";
    $pdipesquisa = isset($_POST["pdipesquisa"]) ? $_POST["pdipesquisa"] : "";
    $pdimetodo = isset($_POST["pdimetodo"]) ? $_POST["pdimetodo"] : "";
    $pdi = ! empty($pdianoini) ? buscarPdiPorAnoInicial($pdianoini) : [];
    if (! is_numeric($pdianoini) || ! is_numeric($pdianofim) || empty($pdiensino) || empty($pdipesquisa) || empty($pdimetodo)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Dados incorretos.<br>";
        echo "Um ou mais campos do formulário de cadastro de <abbr class='text-uppercase'>pdi</abbr> não foram preenchidos corretamente.<br>";
        echo "Por favor, preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    if ($pdianoini > date("Y")) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, insira o ano atual de início de <abbr class='text-uppercase'>pdi</abbr>.";
        echo "</p>";
        echo "</div>";
        return;
    endif;
    
    if ($pdianofim <= $pdianoini) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Por favor, insira um ano de término de vigência de <abbr class='text-uppercase'>pdi</abbr> não antes do ano de início da vigência do mesmo.";
        echo "</p>";
        echo "</div>";
        return;
    endif;
    
    if (! empty($pdi)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Já existe um <abbr class='text-uppercase'>pdi</abbr>cadastrado com este ano de início.<br>";
        echo "Preencha novamente o formulário e clique no botão salvar.";
        echo "</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirPdi($pdianoini, $pdianofim, $pdipesquisa, $pdiensino, $pdimetodo)) {
            echo "<h1 class= 'text-success'>Pdi cadastrado com êxito! </h1><br>";
            echo "<a href= '?pagina=pdi&opcao=consultar'>Clique aqui para consultar os Pdis cadastrados</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
endif;
?>
	</div>
