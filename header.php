<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"></a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
    <ul class="navbar-nav px-3">
        <?php
        $cliente = unserialize($_SESSION['vitrine-customer']);
        var_dump($cliente);
        echo "<p class='text-center' style='color: white  '> Seja bem vindo(a) ".$cliente->getnome()."</p>"
        ?>

        <li class="nav-item text-nowrap">
            <a class="nav-link" href="CustomerLogout.php">Sair</a>
        </li>
    </ul>
</header>
