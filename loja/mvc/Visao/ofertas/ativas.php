<div class="title-container">
    <h1>Minhas ofertas ativas</h1>
</div>

<?php $this->incluirVisao('util/alert.php', ['flash' => $ofertaFlash]) ?>

<?php $this->incluirVisao('util/filtrosOferta.php', ['pagina' => $pagina, 'ultimaPagina' => $ultimaPagina]) ?>

<div class="product-list">
    <?php foreach ($ofertas as $oferta) : ?>
        <div class="product-card-box">
            <div class="product-card">
                <img class="img-card" src="<?= URL_IMG . $oferta->getImagem() ?>" alt="Imagem do produto">
                <p class="card-amount">R$ <?= $oferta->getPreco() ?></p>
                <p class="card-description"><?= $oferta->getDescricao() ?></p>
                <form action="<?= URL_RAIZ . 'ofertas/' . $oferta->getId() ?>" method="post" class="card-actions">
                    <input type="hidden" name="_metodo" value="DELETE">
                    <a href="" class="button button-error" title="Deletar"
                       onclick="event.preventDefault(); this.parentNode.submit()">
                        <span>Deletar</span>
                    </a>
                </form>
            </div>
        </div>
    <?php endforeach ?>
</div>

<?php $this->incluirVisao('util/addProduct.php') ?>
