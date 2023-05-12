<?php
namespace Teste\Unitario;

use \Teste\Teste;
use \Modelo\Usuario;
use \Framework\DW3BancoDeDados;

class TesteUsuario extends Teste
{
	public function testeInserir()
	{
        $usuario = new Usuario('nome-teste', 'emaildeteste@email.com', 'senha');
        $usuario->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM usuarios WHERE email = 'emaildeteste@email.com'");
        $bdUsuairo = $query->fetch();
        $this->verificar($bdUsuairo !== false);
	}

    public function testeBuscarEmail()
    {
        $usuario = new Usuario('nome-teste', 'emailteste@email.com', 'senha');
        $usuario->salvar();
        $usuario = Usuario::buscarEmail('emailteste@email.com');
        $this->verificar($usuario !== false);
    }
}
