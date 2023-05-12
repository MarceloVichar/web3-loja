<?php

namespace Controlador;

use \Modelo\Usuario;

class UsuarioControlador extends Controlador
{
    public function criar()
    {
        $this->verificarNaoLogado();
        $this->visao('usuarios/criar.php', [], 'auth.php');
    }

    public function armazenar()
    {
        $this->verificarNaoLogado();
        $usuario = new Usuario($_POST['nome'], $_POST['email'], $_POST['senha']);

        $email = Usuario::buscarEmail($usuario->getEmail());

        if ($email) {
            $this->setErros(['email' => 'Email já cadastrado.']);
            $this->visao('usuarios/criar.php', [], 'auth.php');
        }

        if ($usuario->isValido() && !$email) {
            $usuario->salvar();
            $this->redirecionar(URL_RAIZ . 'usuarios/sucesso');

        } else {
            $this->setErros($usuario->getValidacaoErros());
            $this->visao('usuarios/criar.php', [], 'auth.php');
        }
    }

    public function sucesso()
    {
        $this->verificarNaoLogado();
        $this->visao('usuarios/sucesso.php', [], 'auth.php');
    }
}
