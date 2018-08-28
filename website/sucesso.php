<?php
session_start ();
include __DIR__.'/../website/conexao.php';
include 'topo.php';

$nome = explode (" ", $_SESSION['nome']);


?>
<br>
<div class="jumbotron">
    <h1 class="display-4">Obrigado, <?php echo $nome[0] ?>.</h1>
    <p class="lead">Seu pedido foi registrado e será enviado após confirmação do pagamento.</p>
</div>

<?php
include 'rodape.php';
?>