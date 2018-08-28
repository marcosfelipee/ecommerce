<?php
session_start ();
if (!empty($_SESSION['Logado'])) {
	header ("Location: /admin/index.php");
}
if (!empty($_POST)) {
	$login = 'admin';
	$senha = '1234';
	if ($login == $_POST['login'] && $senha == $_POST['senha']) {
		$_SESSION['Logado'] = 1;
		header ("Location: /admin/index.php");
	}
	else
		echo "<script>alert('LOGIN INVÁLIDO');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" lang="pt-br">
    <title>ADMIN</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="/admin/login.css">
</head>
<body>
<div class="login-page">
    <div class="form">
        <form class="login-form" action="login.php" method="post">
            <input type="text" id="login" name="login" placeholder="LOGIN">
            <input type="password" id="senha" name="senha" placeholder="SENHA">
            <input name="enviar" type="submit" id="enviar" value="ENVIAR">
        </form>
</body>
</html>

