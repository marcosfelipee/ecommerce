<?php
include 'conexao.php';
include 'topo.php';
if (!empty($_POST)) {
	$nome_clt = $_POST['nome'];
	$cpf_clt = $_POST['cpf'];
	$cidade_clt = $_POST['cidade'];
	$estado_clt = $_POST['estado'];
	$endereco_clt = $_POST['endereco'];
	$cep_clt = $_POST['cep'];
	$email_clt = $_POST['email'];
	$senha_clt = $_POST['senha'];

	$stmt = $mysqli->stmt_init ();
	$stmt->prepare ("INSERT INTO clientes (nome,cpf,cidade,estado,endereco,cep,email,senha) VALUES (?,?,?,?,?,?,?,?)");
	$stmt->bind_param ("ssssssss", $nome_clt, $cpf_clt, $cidade_clt, $estado_clt, $endereco_clt, $cep_clt, $email_clt, $senha_clt);
	echo $mysqli->error;
	$id_cliente = $stmt->insert_id;
	$stmt->execute ();

	if (empty($error)) {
		?>
        <br>
        <div class="alert alert-success" role="alert">
            Cadastro realizado com sucesso!
        </div>
        <script>
			window.setTimeout("location.href='checkout.php'", 1000)
        </script>
		<?php
	}
	$stmt->prepare ("Select cpf,email from clientes where cpf = ?");
	$stmt->bind_param ("s", $cpf_clt);
	echo $mysqli->error;
	$stmt->execute ();
	echo $mysqli->error;
	$result = $stmt->get_result ();
	$cpfcpf = $result->fetch_array (MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="estilo.css">

</head>
<body>
<br>
<div class="div-forms">
    <form action="register.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" style="width: 400px">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="pwd" name="senha" placeholder="Senha" style="width: 200px">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="cpf" maxlength="14" placeholder="CPF"
                   OnKeyPress="formatar('###.###.###-##', this)"
                   style="width: 200px">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="nome" maxlength="75" placeholder="Nome Completo"
                   style="width: 400px">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="cep" maxlength="9" placeholder="CEP"
                   OnKeyPress="formatar('#####-###', this)"
                   style="width: 200px">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="endereco" placeholder="Endereço"
                   style="width: 400px">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" style="width: 200px">
            <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade"
                   style="width: 200px; margin-left: 250px; margin-top: -38px">
        </div>
        <input type="submit" class="btn btn-primary" name="enviar" style="margin-left: 40%">
    </form>

	<?php
	?>
</div>
<script>
	function formatar(mascara, documento) {
		var i = documento.value.length;
		var saida = mascara.substring(0, 1);
		var texto = mascara.substring(i)

		if (texto.substring(0, 1) != saida) {
			documento.value += texto.substring(0, 1);
		}

	}

</script>
<?php
include 'rodape.php';
?>
</body>

</html>