<?php
namespace Controlador;

use \Framework\DW3Sessao;
use \Modelo\Usuario;

class LoginControlador extends Controlador
{
    public function criar()
    {
        $this->verificarNaoLogado();
        $this->visao('login/criar.php', [], 'auth.php');
    }

    public function armazenar()
    {
        $this->verificarNaoLogado();
        $usuario = Usuario::buscarEmail($_POST['email']);
        if ($usuario && $usuario->verificarSenha($_POST['senha'])) {
            DW3Sessao::set('usuario', $usuario->getId());
            $this->redirecionar(URL_RAIZ . 'ofertas');
        } else {
            $this->setErros(['login' => 'Email ou senha inválido.']);
            $this->visao('login/criar.php', [], 'auth.php');
        }
    }

    public function destruir()
    {
        DW3Sessao::deletar('usuario');
        $this->redirecionar(URL_RAIZ . 'login');
    }
}
