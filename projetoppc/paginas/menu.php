
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Sistema PPC</a>
		</div>
		<ul class="nav navbar-nav">
			<li <?php echo active($pagina, $opcao); ?>><a href="index.php">Home</a></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Curso <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "curso", "cadastrar"); ?>><a
						href="?pagina=curso&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "curso", "consultar"); ?>><a
						href="?pagina=curso&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Ppc <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php  echo active($pagina, $opcao, "ppc", "cadastrar"); ?>><a
						href="?pagina=ppc&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "ppc", "consultar"); ?>><a
						href="?pagina=ppc&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Unidade SENAC <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "unidade", "cadastrar"); ?>><a
						href="?pagina=unidade&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "unidade", "consultar"); ?>><a
						href="?pagina=unidade&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Eixo Tecnologico <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "eixotec", "cadastrar"); ?>><a
						href="?pagina=eixotec&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "eixotec", "consultar"); ?>><a
						href="?pagina=eixotec&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Eixo Temático <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "eixotem", "cadastrar"); ?>><a
						href="?pagina=eixotem&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "eixotem", "consultar"); ?>><a
						href="?pagina=eixotem&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">PDI <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "pdi", "cadastrar"); ?>><a
						href="?pagina=pdi&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "pdi", "consultar"); ?>><a
						href="?pagina=pdi&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Disciplina <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li
						<?php echo active($pagina, $opcao, "disciplina", "cadastrar"); ?>><a
						href="?pagina=disciplina&opcao=cadastrar">Cadastrar</a></li>
					<li
						<?php echo active($pagina, $opcao, "disciplina", "consultar"); ?>><a
						href="?pagina=disciplina&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Competência <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li
						<?php echo active($pagina, $opcao, "competencia", "cadastrar"); ?>><a
						href="?pagina=competencia&opcao=cadastrar">Cadastrar</a></li>
					<li
						<?php echo active($pagina, $opcao, "competencia", "consultar"); ?>><a
						href="?pagina=competencia&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Indicador <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li
						<?php echo active($pagina, $opcao, "indicador", "cadastrar"); ?>><a
						href="?pagina=indicador&opcao=cadastrar">Cadastrar</a></li>
					<li
						<?php echo active($pagina, $opcao, "indicador", "consultar"); ?>><a
						href="?pagina=indicador&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Certificação <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li
						<?php echo active($pagina, $opcao, "certificacao", "cadastrar"); ?>><a
						href="?pagina=certificacao&opcao=cadastrar">Cadastrar</a></li>
					<li
						<?php echo active($pagina, $opcao, "certificacao", "consultar"); ?>><a
						href="?pagina=certificacao&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Conteúdo Curricular <span
					class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "conteudo", "cadastrar"); ?>><a
						href="?pagina=conteudo&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "conteudo", "consultar"); ?>><a
						href="?pagina=conteudo&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Perfil de conclusão de curso <span
					class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "perfil", "cadastrar"); ?>><a
						href="?pagina=perfil&opcao=cadastrar">Cadastrar</a></li>
					<li
						<?php
    
    echo active($pagina, $opcao, "perfil", "consultar");
    ?><a
						href="?pagina=perfil&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Perfil de certificações de curso <span
					class="caret"></span></a>
				<ul class="dropdown-menu">
					<li
						<?php echo active($pagina, $opcao, "perfilcert", "cadastrar"); ?>><a
						href="?pagina=perfilcert&opcao=cadastrar">Cadastrar</a></li>
					<li
						<?php echo active($pagina, $opcao, "perfilcert", "consultar"); ?>><a
						href="?pagina=perfilcert&opcao=consultar">Consultar</a></li>
				</ul></li>
			<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">Oferta <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li <?php echo active($pagina, $opcao, "oferta", "cadastrar"); ?>><a
						href="?pagina=oferta&opcao=cadastrar">Cadastrar</a></li>
					<li <?php echo active($pagina, $opcao, "oferta", "consultar"); ?>><a
						href="?pagina=oferta&opcao=consultar">Consultar</a></li>
				</ul></li>
		</ul>
	</div>
</nav>