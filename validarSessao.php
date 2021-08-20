<?php
session_start();

if(!isset($_SESSION['vitrine-user'])){
    header('Location: /views/login.php');
}