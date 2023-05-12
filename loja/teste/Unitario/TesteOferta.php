<?php
namespace Teste\Unitario;

use \Teste\Teste;
use \Modelo\Usuario;
use \Modelo\Oferta;
use \Framework\DW3BancoDeDados;

class TesteOferta extends Teste
{
    private $usuarioId;
    /**
     * @var mixed|null
     */
    private $outroUsuarioId;

    public function antes()
    {
        $usuario = new Usuario('teste', 'emailteste@teste.com', '123');
        $outrousuario = new Usuario('teste', 'emailteste2@teste.com', '123');
        $usuario->salvar();
        $outrousuario->salvar();
        $this->usuarioId = $usuario->getId();
        $this->outroUsuarioId = $outrousuario->getId();
    }

    public function testeInserir()
    {
        $oferta = new Oferta($this->usuarioId, 'Ola pessoal', '21.00');
        $oferta->salvar();
        $query = DW3BancoDeDados::query("SELECT * FROM ofertas WHERE id = " . $oferta->getId());
        $bdOfertas = $query->fetch();
        $this->verificar($bdOfertas['descricao'] === $oferta->getDescricao());
        $this->verificar($bdOfertas['preco'] === $oferta->getPreco());
    }

    public function testeBuscarDisponiveisOutrosUsuarios()
    {
        (new Oferta($this->outroUsuarioId, 'produto 1', '1'))->salvar();
        $ofertas = Oferta::buscarNaoVendidosOutrosUsuarios($this->usuarioId);
        $this->verificar(count($ofertas) == 1);
    }

    public function testeContarDisponiveisOutrosUsuarios()
    {
        (new Oferta($this->outroUsuarioId, 'produto 1', '1'))->salvar();
        $total = Oferta::contarNaoVendidosOutrosUsuarios($this->usuarioId);
        $this->verificar($total == 1);
    }

     public function testeBuscarVendidosLogado()
    {
        (new Oferta($this->usuarioId, 'produto vendido 2', '4', null, null, $this->outroUsuarioId))->salvar();
        $ofertas = Oferta::buscarVendidosUsuarioLogado($this->usuarioId);
        $this->verificar(count($ofertas) == 1);
    }

    public function testeContarVendidosLogado()
    {
        (new Oferta($this->usuarioId, 'produto vendido 2', '4', null, null, $this->outroUsuarioId))->salvar();
        $total = Oferta::contarVendidosUsuarioLogado($this->usuarioId);
        $this->verificar($total == 1);
    }

    public function testeBuscarCompradosLogado()
    {
        (new Oferta($this->outroUsuarioId, 'produto vendido 2', '2.34', null, null, $this->usuarioId))->salvar();
        $ofertas = Oferta::buscarCompradosUsuarioLogado($this->usuarioId);
        $this->verificar(count($ofertas) == 1);
    }

    public function testeContarCompradosLogado()
    {
        (new Oferta($this->outroUsuarioId, 'produto vendido 2', '2.34', null, null, $this->usuarioId))->salvar();
        $total = Oferta::contarCompradosUsuarioLogado($this->usuarioId);
        $this->verificar($total == 1);
    }

    public function testeBuscarDisponiveisLogado()
    {
        (new Oferta($this->usuarioId, 'produto vendido 2', '4'))->salvar();
        $ofertas = Oferta::buscarNaoVendidosUsuarioLogado($this->usuarioId);
        $this->verificar(count($ofertas) == 1);
    }

    public function testeContarDisponiveisLogado()
    {
        (new Oferta($this->usuarioId, 'produto vendido 2', '4'))->salvar();
        $total = Oferta::contarNaoVendidosUsuarioLogado($this->usuarioId);
        $this->verificar($total == 1);
    }

    public function testeComprar()
    {
        $oferta = new Oferta($this->outroUsuarioId, 'oferta', '2');
        $oferta->salvar();
        Oferta::comprar($this->usuarioId , $oferta->getId());
        $ofertas = Oferta::buscarCompradosUsuarioLogado($this->usuarioId);
        $this->verificar(count($ofertas) == 1);
    }

    public function testeDestruir()
    {
        $oferta = new Oferta($this->usuarioId, 'Ola pessoal', '1');
        $oferta->salvar();
        Oferta::destruir($oferta->getId());
        $query = DW3BancoDeDados::query('SELECT * FROM ofertas');
        $bdOfertas = $query->fetch();
        $this->verificar($bdOfertas === false);
    }
}
