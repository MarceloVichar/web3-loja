<div class="title-container">
    <h1>Nova oferta</h1>
</div>
<div class="body-content">
    <form action="<?= URL_RAIZ . 'ofertas/criar' ?>" method="post" class="form" enctype="multipart/form-data">
        <div class="field <?= $this->getErroCss('descricao') ?>">
            <label class="ha-screen-reader" for="descricao">Descrição</label>
            <input class="field__input" id="descricao" name="descricao" type="text"
                   placeholder="Insira a descrição do produto" value="<?= $this->getPost('descricao') ?>">
            <span class="field__label-wrap" aria-hidden="true">
                <span class="field__label">Descrição</span>
            </span>
        </div>
        <div class="field <?= $this->getErroCss('preco') ?>">
            <label class="ha-screen-reader" for="preco">Preço</label>
            <input class="field__input" id="preco" name="preco" type="number" step="0.01"
                   placeholder="Insira o preço do produto" value="<?= $this->getPost('preco') ?>">
            <span class="field__label-wrap" aria-hidden="true">
                <span class="field__label">Preço</span>
            </span>
        </div>
        <div class="field <?= $this->getErroCss('imagem') ?>">
            <label class="ha-screen-reader" for="imagem">Imagem (Máx. 500kb)</label>
            <input class="field__input" id="imagem" name="imagem" type="file"
                   placeholder="Insira a imagem da oferta">
            <span class="field__label-wrap" aria-hidden="true">
                <span class="field__label">Imagem da oferta</span>
            </span>
        </div>
        <div class="text-center" style="margin-top: 10px; display: grid; gap: 10px">
            <?php $this->incluirVisao('util/formErro.php', ['campo' => 'descricao']) ?>
            <?php $this->incluirVisao('util/formErro.php', ['campo' => 'preco']) ?>
            <?php $this->incluirVisao('util/formErro.php', ['campo' => 'imagem']) ?>
        </div>
        <div class="form-actions">
            <a href="<?= URL_RAIZ . 'ofertas' ?>">
                <button type="button" class="button-error">Cancelar</button>
            </a>
            <button type="submit" class="button-primary">Cadastrar</button>
        </div>
</div>
