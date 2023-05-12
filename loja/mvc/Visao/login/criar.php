<h2>Entrar</h2>
<form action="<?= URL_RAIZ . 'login' ?>" method="post">
    <div class="field <?= $this->getErroCss('login') ?>">
        <label class="ha-screen-reader" for="email">Email</label>
        <input class="field__input" id="email" name="email" type="text"
               placeholder="Email do usuario" autofocus value="<?= $this->getPost('email') ?>">
        <span class="field__label-wrap" aria-hidden="true">
            <span class="field__label">Email</span>
        </span>
    </div>
    <div class="field <?= $this->getErroCss('login') ?>">
        <label class="ha-screen-reader" for="senha">Senha</label>
        <input class="field__input" id="senha" name="senha" type="password"
               placeholder="Insira a senha">
        <span class="field__label-wrap" aria-hidden="true">
                    <span class="field__label">Senha</span>
                </span>
    </div>
    <div class="text-center" style="margin-top: 10px">
        <?php $this->incluirVisao('util/formErro.php', ['campo' => 'login']) ?>
    </div>
    <div class="form-actions">
        <button class="button-primary">Entrar</button>
    </div>
    <div class="back">
        Não tem uma conta?
        <a href="<?= URL_RAIZ . 'usuarios/criar' ?>">Registrar</a>
    </div>
</form>
