<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cardapio da Copa</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#">Cardapio da Copa</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

	        <li class="nav-item">
	          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
	        </li>
	        
	        <li class="nav-item dropdown">
	          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            Usuarios
	          </a>
	          <ul class="dropdown-menu">
	            <li><a class="dropdown-item" href="?page=cadastrar-usuario">Cadastrar</a></li>
	            <li><a class="dropdown-item" href="?page=listar-usuario">Listar</a></li>
	          </ul>
	        </li>

	        <li class="nav-item dropdown">
	          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            Cardápio
	          </a>
	          <ul class="dropdown-menu">
	            <li><a class="dropdown-item" href="?page=cadastrar-cardapio">Cadastrar</a></li>
	            <li><a class="dropdown-item" href="?page=listar-cardapio">Listar</a></li>
	          </ul>
	        </li>

	        <li class="nav-item dropdown">
	          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            Pedido
	          </a>
	          <ul class="dropdown-menu">
	            <li><a class="dropdown-item" href="?page=cadastrar-pedido">Pedir</a></li>
	            <li><a class="dropdown-item" href="?page=listar-pedido">Produção</a></li>
	          </ul>
	        </li>
	        
	      </ul>
	      <form class="d-flex" role="search">
	        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
	        <button class="btn btn-outline-success" type="submit">Search</button>
	      </form>
	    </div>
	  </div>
	</nav>

	<div class="container">
		<div class="row mt-5">
			<div class="col">
				<?php
					//conexao
					include('config.php');

					switch (@$_REQUEST["page"]) {
						//usuario
						case 'cadastrar-usuario':
							include('cadastrar-usuario.php');
							break;
						case 'listar-usuario':
							include('listar-usuario.php');
							break;
						case 'editar-usuario':
							include('editar-usuario.php');
							break;
						case 'salvar-usuario':
							include('salvar-usuario.php');
							break;

						//cardapio
						case 'cadastrar-cardapio':
							include('cadastrar-cardapio.php');
							break;
						case 'listar-cardapio':
							include('listar-cardapio.php');
							break;
						case 'editar-cardapio':
							include('editar-cardapio.php');
							break;
						case 'salvar-cardapio':
							include('salvar-cardapio.php');
							break;

						//pedido
						case 'cadastrar-pedido':
							include('cadastrar-pedido.php');
							break;
						case 'listar-pedido':
							include('listar-pedido.php');
							break;
						case 'editar-pedido':
							include('editar-pedido.php');
							break;
						case 'salvar-pedido':
							include('salvar-pedido.php');
							break;

						default:
							print "<h1>Bem vindo ao sistema da Copa</h1>";
					}
				?>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>