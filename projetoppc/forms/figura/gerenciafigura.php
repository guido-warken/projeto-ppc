<script src="js/validaformfigura.js"></script>
<div class="container">
<?php
require_once 'c:\wamp64\www\projetoppc\dao\figuraDao.php';
if ($_GET["opcao"] == "cadastrar") :
    ?>
<h2 class="text-center text-primary bg-primary">Cadastro de figuras</h2>
	<br>
	<p>Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" enctype="multipart/form-data"
		onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="figdesc">Descrição da figura: <span>*</span></label> <input
				type="text" id="figdesc" name="figdesc" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label for="figcont">Selecione o arquivo de imagem a ser inserido: <span>*</span></label>
			<input type="hidden" name="max_file_size" value="30000"> <input
				type="file" id="figcont" name="figcont" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<input type="submit" value="salvar" name="bt-form-salvar">
		</div>
		<br>
	</form>
<?php
    if (! array_key_exists("bt-form-salvar", $_POST))
        return;
    $figdesc = isset($_POST["figdesc"]) ? $_POST["figdesc"] : "";
    $max_file_size = $_POST["max_file_size"];
    $imagem = $_FILES["figcont"];
    if (empty($figdesc)) :
        ?>
<div class="text-danger">
		<p>Por favor Preencha uma descricao para a figura.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $figura = buscarFiguraPorDescricao($figdesc);
    if (! empty($figura)) :
        ?>
<div class="text-danger">
		<p>
			Já existe uma figura cadastrada com esta descrição.<br> Por favor,
			digite outra descrição para a figura.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if (empty($imagem["tmp_name"])) :
        ?>
<div class="text-danger">
		<p>
			Nenhum arquivo selecionado.<br> Por favor, selecione uma imagem do
			seu computador para ser cadastrada.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if ($imagem["size"] > $max_file_size) :
        ?>
<div class="text-danger">
		<p>
			Arquivo maior do que o permitido.<br> Comprima o arquivo e tente
			novamente.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $ext = pathinfo($imagem["name"], PATHINFO_EXTENSION);
    
    if ($ext != "jpg" && $ext != "png") :
        ?>
<div class="text-danger">
		<p>Por favor, selecione imagens do tipo JPG ou PNG.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $arquivo = fopen($imagem["tmp_name"], "rb");
    $tamanho = $imagem["size"];
    $figcont = fread($arquivo, $tamanho);
    fclose($arquivo);
    $figura = buscarFiguraPorConteudo($figcont);
    if (! empty($figura)) :
        echo "<div class='text-danger'>";
        echo "<p>";
        echo "Esta imagem já existe.</p>";
        echo "</div>";
        echo "<br>";
        return;
    endif;
    
    try {
        if (inserirFigura($figdesc, $figcont)) {
            echo "<h1 class='text-success text-center'>Figura inserida com êxito!</h1><br>";
            echo "<a href='?pagina=figura&opcao=consultar'>Clique aqui para consultar as figuras cadastradas</a><br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 
elseif ($_GET["opcao"] == "consultar") :
    $imagens = buscarFiguras();
    $totalimagens = count($imagens);
    ?>
<h2 class="text-center text-primary bg-primary">Consulta de figuras</h2>
	<br> <a href="?pagina=figura&opcao=cadastrar">Nova figura</a><br>
<?php
    if ($totalimagens > 0) :
        ?>
<h2 class="text-center text-info">Total de figuras cadastradas: <?=$totalimagens; ?></h2>
	<br>
	<table class="table table-bordered" style="resize: both;">
		<caption>Figuras</caption>
		<thead>
			<tr>
				<th>Descrição da figura</th>
				<th>figura</th>
				<th colspan="2">Ação</th>
			</tr>
		</thead>
		<tbody>
<?php
        foreach ($imagens as $imagem) :
            ?>
<tr>
				<td><?=$imagem["figdesc"]; ?></td>
				<td><img alt="<?=$imagem["figdesc"]; ?>"
					src="http://localhost/projetoppc/forms/figura/verfigura.php?figcod=<?=$imagem["figcod"]; ?>"
					class="img-responsive"></td>
				<td><a
					href="?pagina=figura&opcao=alterar&figcod=<?=$imagem["figcod"]; ?>">alterar
						dados</a></td>
				<td><a
					href="?pagina=figura&opcao=excluir&figcod=<?=$imagem["figcod"]; ?>">excluir
						figura</a></td>
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
		<h1 class="text-center">Nenhuma figura cadastrada no sistema</h1>
		<br>
		<p>Clique no link acima para cadastrar uma nova figura.</p>
	</div>
	<br>
<?php
    endif;
 elseif ($_GET["opcao"] == "alterar") :
    $figura = buscarFiguraPorId($_GET["figcod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Alteração de figura</h2>
	<br>
	<p>Campos com asterisco são obrigatórios.</p>
	<br>
	<form action="" method="post" enctype="multipart/form-data"
		onsubmit="return validarFormulario()">
		<div class="form-group">
			<label for="figdesc">Descrição da figura: <span>*</span></label> <input
				type="text" id="figdesc" name="figdesc" class="form-control"
				value="<?=$figura["figdesc"]; ?>">
		</div>
		<br>
		<div class="form-group">
			<label for="figcont">Selecione o arquivo de imagem a ser inserido: <span>*</span></label>
			<input type="hidden" name="max_file_size" value="30000"> <input
				type="file" id="figcont" name="figcont" class="form-control">
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
    $figdesc = isset($_POST["figdesc"]) ? $_POST["figdesc"] : "";
    $max_file_size = $_POST["max_file_size"];
    $imagem = $_FILES["figcont"];
    if (empty($figdesc)) :
        ?>
<div class="text-danger">
		<p>Por favor Preencha uma descricao para a figura.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $figpordesc = buscarFiguraPorDescricao($figdesc);
    if (! empty($figpordesc)) :
        if ($figpordesc["figdesc"] != $figura["figdesc"]) :
            ?>
<div class="text-danger">
		<p>
			Já existe uma figura cadastrada com esta descrição.<br> Por favor,
			digite outra descrição para a figura.
		</p>
	</div>
	<br>
<?php
            return;
endif;
endif;
        
    
    if (empty($imagem["tmp_name"])) :
        ?>
<div class="text-danger">
		<p>
			Nenhum arquivo selecionado.<br> Por favor, selecione uma imagem do
			seu computador para ser cadastrada.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    if ($imagem["size"] > $max_file_size) :
        ?>
<div class="text-danger">
		<p>
			Arquivo maior do que o permitido.<br> Comprima o arquivo e tente
			novamente.
		</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $ext = pathinfo($imagem["name"], PATHINFO_EXTENSION);
    
    if ($ext != "jpg" && $ext != "png") :
        ?>
<div class="text-danger">
		<p>Por favor, selecione imagens do tipo JPG ou PNG.</p>
	</div>
	<br>
<?php
        return;
endif;
    
    $arquivo = fopen($imagem["tmp_name"], "rb");
    $tamanho = $imagem["size"];
    $figcont = fread($arquivo, $tamanho);
    fclose($arquivo);
    $figporcont = buscarFiguraPorConteudo($figcont);
    if (! empty($figporcont)) :
        if ($figporcont["figcont"] != $figura["figcont"]) :
            echo "<div class='text-danger'>";
            echo "<p>";
            echo "Esta imagem já existe.</p>";
            echo "</div>";
            echo "<br>";
            return;
    endif;
    endif;
        
    
    try {
        if (atualizarFigura($figdesc, $figcont, $figura["figcod"])) {
            echo "<h1 class='text-success text-center'>Figura atualizada com êxito!</h1><br>";
            echo "<a href='?pagina=figura&opcao=consultar'>Clique aqui para consultar as figuras cadastradas</a>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 elseif ($_GET["opcao"] == "excluir") :
    $figura = buscarFiguraPorId($_GET["figcod"]);
    ?>
<h2 class="text-center text-primary bg-primary">Exclusão de figura</h2>
	<br>
	<form action="" method="post" id="frm-escolha">
		<div class="text-warning">
			<p>Você está prestes a excluir a figura com a descrição <?=$figura["figdesc"]; ?>. Veja a figura abaixo.<br>
				<br> <img alt="<?=$figura["figdesc"]; ?>"
					src="http://localhost/projetoppc/forms/figura/verfigura.php?figcod=<?=$figura["figcod"]; ?>"
					class="img-responsive"><br> <br> Você tem certeza de que deseja
				executar esta operação?<br> Após a confirmação, esta operação não
				poderá ser desfeita.
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
    $escolha = $_POST["escolha"];
    if ($escolha == "sim") {
        try {
            if (excluirFigura($figura["figcod"])) {
                echo "<h1 class='text-center text-success'>Figura excluída com êxito!</h2><br>";
                echo "<a href='?pagina=figura&opcao=consultar'>Clique aqui para consultar as figuras cadastradas</a>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
endif;
?>
</div>