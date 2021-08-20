<?php

require_once "controllers/CategoriaController.php";
require_once "controllers/ProdutoController.php";

$lstProdutos = ProdutoController::getInstance()->getTodos();
$lstCategorias = CategoriaController::getInstance()->getTodos();

$lstProdutos = null;
if (isset($_GET['categoria'])){
    $lstProdutos = ProdutoController::getInstance()->getProdutosByCategoria($_GET['categoria']);
}

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Fixed top navbar example · Bootstrap v5.0</title>





    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="css/navbar-top-fixed.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Lista produtos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown03">
                        <?php
                        foreach ($lstCategorias as $categoria) {
                            echo "<li><a class='dropdown-item' href='lista-produtos.php?categoria=".$categoria->getId()."'>".$categoria->getDescricao()."</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="CustomerLogin.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="viewCarrinho.php">Carrinho</a>
                </li>

            </ul>

        </div>
    </div>
</nav>
<br><br><br>
<main class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        foreach($lstProdutos as $produto){
            echo "<div class='col'>
                            <div class='card h-100'>
                                <img src='../images/products/".$produto->getImagem()."' class='card-img-top' alt='...' width='356' height='279'>
                                <div class='card-body'>
                                    <h5 class='card-title'>".$produto->getNome()."</h5>
                                    <h5 class='card-title'>".$produto->getDescricao()."</h5>
                                    <h3 class='card-text text-center'><b>R$ ".number_format($produto->getValor(), 2, ",", ".")."</b></h3>
                                    <p class='text-center'><a href='' class='btn btn-primary'>Adicionar ao carrinho</a></p>
                                </div>
                            </div>
                        </div>";
        }
        ?>
    </div>
</main>
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>
</html>