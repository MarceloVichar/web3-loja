<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A melhor loja</title>
    <link rel="stylesheet" href="<?= URL_CSS . 'reset.css' ?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'global.css' ?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'custom-field.css' ?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'nova-oferta.css' ?>">
</head>
<body>
<div class="navbar">
    <div class="logo-container">
        <a href="<?= URL_RAIZ . 'ofertas' ?>">
            <img class="logo" src="<?= URL_IMG . 'logo.png' ?>" alt="loja">
        </a>
    </div>
    <div class="menu">
        <a href="<?= URL_RAIZ . 'ofertas' ?>" class="menu-item">Início</a>
        <a href="<?= URL_RAIZ . 'ofertas/vendas' ?>" class="menu-item">Minhas vendas</a>
        <a href="<?= URL_RAIZ . 'ofertas/compras' ?>" class="menu-item">Minhas compras</a>
        <a href="<?= URL_RAIZ . 'ofertas/ativas' ?>" class="menu-item">Minhas ofertas ativas</a>
    </div>
    <div class="exit-container">
        <form action="<?= URL_RAIZ . 'login' ?>" method="post">
            <input type="hidden" name="_metodo" value="DELETE">
            <button type="submit" class="button-error">Sair</button>
        </form>
    </div>
</div>
<div class="page-content">
    <?php $this->imprimirConteudo() ?>
</div>
<footer>
    <div class="merchan">
        <img class="logo" src="<?= URL_IMG . 'logo.png' ?>" alt="loja">
        <span>A melhor loja LTDA</span>
    </div>
    <p class="copy">&copy; 2023 Marcelo Marcos Vichar Junior</p>
</footer>
</body>
</html>

