<h2>Registrar-se</h2>
<form action="<?= URL_RAIZ . 'usuarios' ?>" method="post">
    <div class="field <?= $this->getErroCss('nome') ?>">
        <label class="ha-screen-reader" for="nome">Nome</label>
        <input class="field__input" id="nome" name="nome" type="text"
               placeholder="Nome de usuário" autofocus value="<?= $this->getPost('nome') ?>">
        <span class="field__label-wrap" aria-hidden="true">
            <span class="field__label">Nome</span>
        </span>
    </div>
    <div class="field <?= $this->getErroCss('email') ?>">
        <label class="ha-screen-reader" for="email">Email</label>
        <input class="field__input" id="email" name="email" type="text"
               placeholder="Email de usuário" autofocus value="<?= $this->getPost('email') ?>">
        <span class="field__label-wrap" aria-hidden="true">
            <span class="field__label">Email</span>
        </span>
    </div>
    <div class="field <?= $this->getErroCss('senha') ?>">
        <label class="ha-screen-reader" for="senha">Senha</label>
        <input class="field__input" id="senha" type="text"
               placeholder="Insira a senha" name="senha">
        <span class="field__label-wrap" aria-hidden="true">
            <span class="field__label">Senha</span>
        </span>
    </div>
    <div class="text-center" style="margin-top: 10px">
        <?php $this->incluirVisao('util/formErro.php', ['campo' => 'nome']) ?>
        <?php $this->incluirVisao('util/formErro.php', ['campo' => 'email']) ?>
        <?php $this->incluirVisao('util/formErro.php', ['campo' => 'senha']) ?>
    </div>
    <div class="form-actions">
        <button class="button-primary" type="submit">Registrar</button>
    </div>
    <div class="back">
        <a href="<?= URL_RAIZ . 'login' ?>">Voltar para o login</a>
    </div>
</form>


