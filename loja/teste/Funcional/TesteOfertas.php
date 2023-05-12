<?php
namespace Teste\Funcional;

use \Teste\Teste;
use \Modelo\Oferta;
use \Modelo\Usuario;
use \Framework\DW3BancoDeDados;

class TesteOfertas extends Teste
{
    public function testeListagemDisponiveisDeslogado()
    {
        $resposta = $this->get(URL_RAIZ . 'ofertas');
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeListagemComprasDeslogado()
    {
        $resposta = $this->get(URL_RAIZ . 'ofertas/compras');
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeListagemVendasDeslogado()
    {
        $resposta = $this->get(URL_RAIZ . 'ofertas/vendas');
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeListagemAtivasDeslogado()
    {
        $resposta = $this->get(URL_RAIZ . 'ofertas/ativas');
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeListagemDisponiveisOutrosUsuarios()
    {
        $this->logar();
        $outroUsuario = new Usuario('outro', 'teste2@teste2.com', '123');
        $outroUsuario->salvar();
        (new Oferta($outroUsuario->getId(), 'minha-oferta', '1'))->salvar();
        $resposta = $this->get(URL_RAIZ . 'ofertas');
        $this->verificarContem($resposta, 'disponíveis');
        $this->verificarContem($resposta, 'minha-oferta');
    }

    public function testeListagemVendidoLogado()
    {
        $this->logar();
        $outroUsuario = new Usuario('outro', 'teste2@teste2.com', '123');
        $outroUsuario->salvar();
        (new Oferta($this->usuarioLogadoId, 'vendida', '1', null, null, $outroUsuario->getId()))->salvar();
        $resposta = $this->get(URL_RAIZ . 'ofertas/vendas');
        $this->verificarContem($resposta, 'vendas');
        $this->verificarContem($resposta, 'vendida');
    }

    public function testeListagemCompradoLogado()
    {
        $this->logar();
        $outroUsuario = new Usuario('outro', 'teste2@teste2.com', '123');
        $outroUsuario->salvar();
        (new Oferta($outroUsuario->getId(), 'comprada', '1', null, null, $this->usuario->getId()))->salvar();
        $resposta = $this->get(URL_RAIZ . 'ofertas/compras');
        $this->verificarContem($resposta, 'compras');
        $this->verificarContem($resposta, 'comprada');
    }

    public function testeListagemDisponivelLogado()
    {
        $this->logar();
        (new Oferta($this->usuario->getId(), 'disponivel', '1'))->salvar();
        $resposta = $this->get(URL_RAIZ . 'ofertas/ativas');
        $this->verificarContem($resposta, 'ativas');
        $this->verificarContem($resposta, 'disponivel');
    }

    public function testeArmazenarDeslogado()
    {
        $resposta = $this->post(URL_RAIZ . 'ofertas/criar', [
            'vendedor_id' => $this->usuario->getId(),
            'descricao' => 'deslogado querendo cadastrar oferta',
            'preco' => '1'
        ]);
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
    }

    public function testeArmazenar()
    {
        $this->logar();
        $resposta = $this->post(URL_RAIZ . 'ofertas/criar', [
            'vendedor_id' => $this->usuario->getId(),
            'descricao' => 'deslogado querendo cadastrar oferta',
            'preco' => '1'
        ]);
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'ofertas/ativas');
        $query = DW3BancoDeDados::query('SELECT * FROM ofertas WHERE vendedor_id = ' . $this->usuario->getId());
        $bdOfertas = $query->fetchAll();
        $this->verificar(count($bdOfertas) == 1);
    }

    public function testeComprar()
    {
        $this->logar();
        $outroUsuario = new Usuario('outro', 'teste2@teste2.com', '123');
        $outroUsuario->salvar();
        $oferta = new Oferta($outroUsuario->getId(), 'oferta', '1');
        $oferta->salvar();
        $resposta = $this->patch(URL_RAIZ . 'ofertas/' . $oferta->getId());
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'ofertas/compras');
        $query = DW3BancoDeDados::query('SELECT * FROM ofertas WHERE comprador_id IS NOT NULL');
        $bdOfertas = $query->fetch();
        $this->verificar($bdOfertas !== false);
    }

    public function testeComprarDoMesmoUsuario()
    {
        $this->logar();
        $oferta = new Oferta($this->usuario->getId(), 'oferta', '1');
        $oferta->salvar();
        $resposta = $this->patch(URL_RAIZ . 'ofertas/' . $oferta->getId());
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'ofertas/compras');
        $query = DW3BancoDeDados::query('SELECT * FROM ofertas WHERE comprador_id IS NOT NULL');
        $bdOfertas = $query->fetch();
        $this->verificar($bdOfertas === false);
    }

    public function testeDestruir()
    {
        $this->logar();
        $oferta = new Oferta($this->usuario->getId(), 'oferta', '1');
        $oferta->salvar();
        $resposta = $this->delete(URL_RAIZ . 'ofertas/' . $oferta->getId());
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'ofertas/ativas');
        $query = DW3BancoDeDados::query('SELECT * FROM ofertas');
        $bdOfertas = $query->fetch();
        $this->verificar($bdOfertas === false);
    }

    public function testeDestruirDeOutroUsuario()
    {
        $this->logar();
        $outroUsuario = new Usuario('outro', 'teste2@teste2.com', '123');
        $outroUsuario->salvar();
        $oferta = new Oferta($outroUsuario->getId(), 'ofertinha', '2');
        $oferta->salvar();
        $resposta = $this->delete(URL_RAIZ . 'ofertas/' . $oferta->getId());
        $this->verificarRedirecionar($resposta, URL_RAIZ . 'ofertas/ativas');
        $query = DW3BancoDeDados::query('SELECT * FROM ofertas');
        $bdOfertas = $query->fetch();
        $this->verificar($bdOfertas !== false);
    }
}
