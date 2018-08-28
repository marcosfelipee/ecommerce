<?php
include '../website/conexao.php';
include 'topo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="botao.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <link href="botao.css" rel="stylesheet">
    <title>Carrinho de Compras</title>

</head>
<body>

<script type="text/javascript">
	function Carrinho() {
		var id;
		var produto;
		var preco;
		var qtd;
		var total = 0;
		var items = [];


		this.limparCarrinho = function () {
			localStorage.clear();
			location.reload();
		};

		this.removerItem = function (id) {
			var cart = localStorage.getItem('cart');
			if (cart)
				cart = JSON.parse(cart);
			else {
				cart = [];
			}

			var _index = null;
			var test = function (val, index) {
				if (id === val.id) {
					_index = index;
				}
			};
			cart.findIndex(test);

			if (_index >= 0) {
				cart.splice(_index, 1);
				location.reload();
			}

			localStorage.setItem('cart', JSON.stringify(cart));
			alert("Produto removido do carrinho!");
		};

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

		this.alterarQuantidade = function (id, add) {
			var cart = localStorage.getItem('cart');
			if (cart)
				cart = JSON.parse(cart);
			else {
				cart = [];
			}


			var input = document.getElementById(id);
			var valorAtual = parseInt(input.value);
			var novoValor = valorAtual + add;
			cart[key].qtd = novoValor;


			localStorage.setItem('cart', JSON.stringify(cart));
			location.reload();


		};

		this.exibirCarrinho = function (id, produto, preco, qtd) {
			var cart = localStorage.getItem('cart');
			if (cart)
				cart = JSON.parse(cart);

			var head_t = "<table class=\"table table-bordered\" >\n" + "<thead>\n" +
				" <tr>" + "<th scope='col' style='width: 307px'>Produto</th>" +
				"<th scope='col' style='width: 305px'>Preço</th>" +
				"<th scope='col' >Quantidade</th>";
			var v_total = "<div class=\"alert alert-success\" role=\"alert\" style='margin-left: 750px; margin-bottom: 30px; font-size: 15px'>VALOR TOTAL: " + carrinho.valorTotal().bold() + " </div>";
			if (cart.length > 0)
				document.write("<br><h3 style='color: #2e6da4'>Meu Carrinho</h3><br> " + head_t + v_total);
			document.write("<a href='checkout.php'><button type='button' class='btn btn-success' style='margin-top: -140px' >Checkout</button></a> <button type='button' class='btn btn-danger' onclick='carrinho.limparCarrinho()' style='margin-top: -140px; margin-left: 20px' >Limpar Carrinho</button>");
			for (key in cart) {
				var tabel = "<table class='table table-bordered'  > " +
					"<tr> " +
					"<td style='width: 307px'>" + cart[key].produto.bold() + "</td>" +
					"<td >" + cart[key].preco.toLocaleString("pt-BR", {
						minimumFractionDigits: 2,
						style: 'currency',
						currency: 'BRL'
					}).bold() + "</td>" +
					"<td style='width: 215px'>  " + "<div class='row' style='position: relative; left: 50px'> " +
					"<button onclick='carrinho.alterarQuantidade(\"qtdeA\",-1)' type=\"button\" class=\"btn btn-outline-danger\"> - </button> &nbsp; " +
					"   <input class=\"form-control\" style='width: 60px; text-align: center' readonly id='qtdeA' type='text' value=" + cart[key].qtd + " />&nbsp;" +
					" <button onclick='carrinho.alterarQuantidade(\"qtdeA\",+1)' type='button' class='btn btn-outline-danger'> + </button> </div> </td>" +
					"<td><button type='button' class='btn btn-outline-danger' style='position: relative; left: 55px' onclick='carrinho.removerItem(" + key + ")'> X </button></td>" +
					"</tr>";
				document.write(tabel);

			}

			if (cart.length == 0)
				document.write("<br><div class=\"alert alert-danger\" role=\"alert\">CARRINHO DE COMPRAS VAZIO<br></div>");
		};

	}
</script>
<div>
    <script>
		var carrinho = new Carrinho();
		carrinho.exibirCarrinho();
    </script>
</div>
<?php
include 'rodape.php';
?>

</body>
</html>
