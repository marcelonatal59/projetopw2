<?php
session_start();
if (isset($_SESSION['vitrine-user'])){
    unset($_SESSION['vitrine-user']);
    header('Location: index.php');
}

?>
