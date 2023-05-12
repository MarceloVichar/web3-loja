<form method="get">
    <div class="search-container">
        <div class="field">
            <label class="ha-screen-reader" for="description">Pesquisar descrição</label>
            <input class="field__input" id="description" name="descricao" type="text"
                   placeholder="Pesquise pela descrição do produto" value="<?= $this->getGet('descricao') ?>">
            <span class="field__label-wrap" aria-hidden="true">
                <span class="field__label">Pesquisar descrição</span>
            </span>
        </div>
        <button type="submit" class="button-primary">Pesquisar</button>
    </div>
    <div class="text-center" style="margin-top: 12px">
        <?php if ($pagina > 1) : ?>
            <button type="submit" class="button-primary" name="p" value="<?= intval($pagina) - 1 ?>">página anterior
            </button>
        <?php endif ?>
        <?php if ($pagina < $ultimaPagina) : ?>
            <button type="submit" class="button-primary" name="p" value="<?= intval($pagina) + 1 ?>">proxima página
            </button>
        <?php endif ?>
    </div>
</form>