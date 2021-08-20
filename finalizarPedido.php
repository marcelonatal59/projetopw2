<?php
session_start();
require_once 'ItemCarrinho.php';
require_once 'models/Cliente.php';
require_once 'controllers/PedidoController.php';

$cliente = new Cliente();

if (!isset($_SESSION['vitrine-customer'])){
    header('Location: CustomerLogin.php');
}else {
    $cliente = unserialize($_SESSION['vitrine-customer']);
    PedidoController::getInstance()->inserir($cliente->getId());
    $pedido_id = PedidoController::getInstance()->getIdPedido($cliente->getId(), date('Y-m-d'));
    echo $pedido_id;

    $carrinho = array();
    if (isset($_SESSION['shopping-cart'])) {
        $carrinho = unserialize($_SESSION['shopping-cart']);
        foreach ($carrinho as $item) {
              PedidoController::getInstance()->inserirItensPedido($pedido_id, $item->getProduto()->getId(),$item->getQuantidade(), $item->getProduto()->getValor());
              }
        if (isset($_SESSION['shopping-cart'])){
            unset($_SESSION['shopping-cart']);
            header('Location: index.php');
        }
    }else{
        echo "<p class='text-center'><h2>Carrinho vazio</h2></p>";
    }
}
?>
