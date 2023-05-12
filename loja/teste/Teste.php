<?php
namespace Teste;

use \Modelo\Usuario;
use \Framework\DW3Teste;
use \Framework\DW3Sessao;

class Teste extends DW3Teste
{
	protected $usuario;
    public $usuarioLogadoId;

	public function logar()
	{
		$this->usuario = new Usuario('nome-teste', 'emailteste@teste.com', '123');
		$this->usuario->salvar();
        $this->usuarioLogadoId = $this->usuario->getId();
		DW3Sessao::set('usuario', $this->usuario->getId());
	}
}
