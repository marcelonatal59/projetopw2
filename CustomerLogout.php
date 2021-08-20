<?php
session_start();
if (isset($_SESSION['vitrine-customer'])){
     unset($_SESSION['vitrine-customer']);
     header('Location: finalizarPedido.php');
}
?>