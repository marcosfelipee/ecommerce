<?php
session_start ();
include __DIR__.'/../website/conexao.php';
include 'topo.php';
if (!empty($_SESSION['id'])) {
	echo "<br>Olá, <h6>".$_SESSION['nome']."</h6> Bem Vindo.";
}
else {
	$_SESSION['msg'] = "Área restrita";
	header ("Location: login_register.php");
}
?>

<?php
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <link href="botao.css" rel="stylesheet">
    <title>Checkout</title>
    <a class="nav-item" style="margin-left: 700px"><a class="btn btn-danger" href="sair.php">LOGOUT</a></a>
</head>
<body>

<script>
	function Carrinho() {
		var id;
		var produto;
		var preco;
		var qtd;
		var items = [];

		this.exibirCarrinho = function (id, produto, preco, qtd) {
			var cart = localStorage.getItem('cart');
			if (cart)
				cart = JSON.parse(cart);
			for (key in cart) {

				var product = document.write("<br>" + cart[key].produto.bold() + "<br>");
				var precc = document.write(cart[key].preco.toLocaleString('pt-BR', {
					style: 'currency',
					currency: 'BRL'
				}) + "<br>");
				var quant = document.write("Quantidade: " + cart[key].qtd + "<br>");
			}
		}
		this.valorTotal = function (preco, qtd) {
			var cart = localStorage.getItem('cart');
			if (cart)
				cart = JSON.parse(cart);
			var total = 0;
			for (key in cart) {
				total += cart[key].preco * cart[key].qtd;
			}
			return total.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});

		}

	}

</script>
<hr>

<script>
	let carrinho = new Carrinho();
	carrinho.exibirCarrinho();
	document.write("<br><b>VALOR TOTAL:</b> " + carrinho.valorTotal());

	function submitValue() {
		var cart = localStorage.getItem('cart');
		document.getElementById("cart").value = cart;
		localStorage.clear();
	}
</script>

<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="cart" id="cart" hidden="hidden">
    <br>
    <hr>
    <input type="submit" class="btn btn-success" value="Comprar" onclick="submitValue()">
</form>
<?php
if (!empty($_POST)) {
	$cart = json_decode ($_POST['cart']);
	$clientes_id = $_SESSION['id'];
	$total = 0;
	$mysqli->begin_transaction ();
	try {
		$stmt = $mysqli->stmt_init ();
		$stmt->prepare ("INSERT INTO pedidos (data_dia,valor_final,clientes_id) VALUES (CURRENT_DATE, ?,?)");
		$stmt->bind_param ("ii", $total, $clientes_id);
		$stmt->execute ();

		$id_pedido = mysqli_insert_id ($mysqli);
		$total_pedido = 0;

		foreach ($cart as $key => $value) {

			$stmt = $mysqli->stmt_init ();
			$stmt->prepare ("select * from produtos WHERE id = ?");
			$stmt->bind_param ("i", $value->id);
			$stmt->execute ();
			$result = $stmt->get_result ();
			$produto = $result->fetch_array (MYSQLI_ASSOC);

			if ($value->qtd > $produto['estoque']) {
				throw new Exception("Quantidade em estoque não disponível");
			}

            $total = $produto['preco'] * $value->qtd;
			$total_pedido += $total;

			$stmt = $mysqli->stmt_init ();
			$stmt->prepare ("insert into pedidos_item(id_pedido,id_produto,quantidade,valor_unit,valor_total) VALUES  (?,?,?,?,?)");
			$stmt->bind_param ("iiidd", $id_pedido, $value->id, $value->qtd, $produto['preco'], $total);
			$stmt->execute ();

			$new_estoque = $produto['estoque'] - $value->qtd;

			$stmt = $mysqli->stmt_init ();
			$stmt->prepare ("update produtos set estoque = ? where id = ?");
			$stmt->bind_param ("ii", $new_estoque, $value->id);
			$stmt->execute ();

			$stmt = $mysqli->stmt_init ();
			$stmt->prepare ("update pedidos set valor_final = ? where id = ?");
			$stmt->bind_param ("ii", $total, $id_pedido);
			$stmt->execute ();

		}
		$mysqli->commit ();
	} catch (\Exception $e) {
		$mysqli->rollback ();
		echo $e->getMessage ();
	}
	if ($id_pedido){
		header ("Location:sucesso.php");
	}
}




?>
<?php
include 'rodape.php';
?>
</body>
</html>
