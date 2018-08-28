<?php
session_start();
if ($_SESSION['Logado'] != 1){
	header ("Location: /admin/login.php");
}
include __DIR__ . '/../conexao.php';
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8" lang="pt-br">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="/admin/estilo.css">
    <link rel="shortcut icon" href="../Logo%20(2).ico" type="image/x-icon"/>

</head>
<body>
	<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/produtos/lista.php">PRODUTOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/categorias/lista.php">CATEGORIAS</a></li>
                    <li class="nav-item" style="margin-left: 900px"><a class="btn btn-danger" href="/admin/logout.php">LOGOUT</a></li>
            </ul>
		</nav>
	</header>
    <div class="center">


