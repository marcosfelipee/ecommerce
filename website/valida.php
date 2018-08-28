<?php
session_start ();
include_once ("conexao.php");
$enviar = filter_input (INPUT_POST, 'enviarlog', FILTER_SANITIZE_STRING);
if ($enviar) {
	$emaill = filter_input (INPUT_POST, 'emaillgn', FILTER_SANITIZE_STRING);
	$senhal = filter_input (INPUT_POST, 'senhalgn', FILTER_SANITIZE_STRING);
	if ((!empty($emaill)) AND (!empty($senhal))) {
		$hash = password_hash ($senhal, PASSWORD_DEFAULT);
		$options = [
			'cost' => 7,
			'salt' => 'BCryptRequires22Chrcts',
		];
		$result_email = "SELECT id, nome, senha FROM clientes WHERE email='$emaill'";
		$resultado_email = mysqli_query ($mysqlii, $result_email);
		if ($resultado_email) {
			$row_email = mysqli_fetch_assoc ($resultado_email);
			if ($senhal == $row_email['senha']) {
				$_SESSION['id'] = $row_email['id'];
				$_SESSION['nome'] = $row_email['nome'];
				$_SESSION['email'] = $row_email['email'];
				header ("Location: checkout.php");
			}
			else {
				$_SESSION['msg'] = "Login e Senha incorretos!";
				header ("Location: login_register.php");
			}
		}
	}
else {
	$_SESSION['msg'] = "Login e Senha incorretos!";
	header ("Location: login_register.php");
}
}
else {
	$_SESSION['msg'] = "Página não encontrada";
	header ("Location: login_register.php");
}