<?php
const DRIVER = 'mysql';
const HOST = 'localhost';
const DB_NAME = 'vitrine_pw2';
const USER = 'root';
const PASSWORD = 'root';

if(!($conn = mysqli_connect(HOST,USER,PASSWORD)))
{
    echo "Erro ao conectar ao MySQL.";
    exit;
}
// Selecionamos nossa base de dados MySQL
if(!($conn = mysqli_select_db ($conn,DB_NAME)))
{
    echo "Erro ao selecionar ao MySQL.";
    exit;
}
?>