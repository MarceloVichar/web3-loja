<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A Melhor Loja</title>
    <link rel="stylesheet" href="<?= URL_CSS . 'reset.css' ?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'global.css' ?>">
    <link rel="stylesheet" href="<?= URL_CSS . 'auth.css' ?>">
</head>
<body>
<div class="page-content">
    <div class="merchan">
        <img class="logo" src="<?= URL_IMG . 'logo.png' ?>" alt="loja">
        <span>A melhor loja LTDA</span>
    </div>
    <div class="auth-container">
        <div class="auth-box">
            <?php $this->imprimirConteudo() ?>
        </div>
    </div>
</div>
</body>
</html>
