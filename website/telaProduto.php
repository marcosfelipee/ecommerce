<link href="botao.css" rel="stylesheet">
<?php
include '../admin/conexao.php';
include 'topo.php';
$stmt = $mysqli->stmt_init ();
$sql = "select * from produtos
";
if (!empty($_GET['produto'])) {
	$tela_produto = $_GET['produto'];
	$sql .= "WHERE id = $tela_produto";
}
$stmt->prepare ($sql);
$stmt->execute ();
$result = $stmt->get_result ();
$produto = $result->fetch_array();
?>
<div class="container">
    <div class="col-esq">
        <div id="foto-produto">
            <img src="../admin/produtos/uploads/<?php echo $produto['id']?>.jpg" class="imagem-tela" alt="principal"
                 title="principal">
        </div>
    </div>
    <div class="col-dir">

                <div class="produto-nome" align="center" id="produto-nome">
                    <hr />
                    <?php echo $produto['titulo'] ?>
                </div>
                    <div class="produto-preco" align="center">
                        <hr/>
                        R$ <?php echo number_format ($produto['preco'], 2, ',', '.') ?>
                    </div>
                <div align="center">
                    <hr />
                    <h3>Quantidade:</h3> <input type="number" class="inserir-sim" value="1" min="1" max="10" id="qtd1">
                    <br>
                    <button type="button" class="btn-buy  btn-lg btn btn-success" style=" font-size: 26px"
                            onclick="carrinho.addItem(<?php echo $produto['id'] ?>,'<?php echo $produto['titulo'] ?>',<?php echo $produto['preco'] ?>, document.getElementById('qtd1').value)">
                        Comprar
                    </button>

                </div>

        <script>
			function Carrinho() {
				var id;
				var produto;
				var preco;
				var qtd;
				var total = 0;
				var item = [];


				this.addItem = function (id, produto, preco, qtd) {

					var cart = localStorage.getItem('cart');
					if (cart)
						cart = JSON.parse(cart);
					 else {
					    cart = [];
					}

					var _index = -1;
					var test = function (val, index) {
                        if (id === val.id) {
							_index = index;
                        }
					}
					cart.findIndex(test);

					 var item = {
						"id": id,
						"produto" :  produto,
						"preco" :  preco
					};


					if (_index >= 0){
						item['qtd'] = parseInt(qtd) + parseInt(cart[_index]['qtd']);
						cart[_index] = item;
					} else {
						item['qtd'] = qtd;
						cart.push(item);
					}
					localStorage.setItem('cart', JSON.stringify(cart));
					alert("Produto adicionado ao carrinho!");
				}

			}
			var carrinho = new Carrinho();


        </script>
    </div>
</div>
<?php
include 'rodape.php';
?>


