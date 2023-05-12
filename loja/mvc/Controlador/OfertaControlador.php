<?php

namespace Controlador;

use \Framework\DW3Sessao;
use \Modelo\Oferta;

class OfertaControlador extends Controlador
{
    private function calcularPaginacao()
    {
        $pagina = array_key_exists('p', $_GET) ? intval($_GET['p']) : 1;
        $limit = 8;
        $offset = ($pagina - 1) * $limit;
        return compact('pagina', 'limit', 'offset');
    }

    public function index()
    {
        $this->verificarLogado();
        $paginacao = $this->calcularPaginacao();
        $ofertas = Oferta::buscarNaoVendidosOutrosUsuarios($this->getUsuario(), $paginacao['limit'], $paginacao['offset'], $_GET);
        $ultimaPagina = ceil(Oferta::contarNaoVendidosOutrosUsuarios($this->getUsuario(), $_GET) / $paginacao['limit']);
        $this->visao('ofertas/index.php', [
            'ofertas' => $ofertas,
            'pagina' => $paginacao['pagina'],
            'ultimaPagina' => $ultimaPagina,
            'ofertaFlash' => DW3Sessao::getFlash('ofertaFlash')
        ]);
    }

    public function criar()
    {
        $this->visao('ofertas/criar.php');
    }

    public function armazenar()
    {
        $this->verificarLogado();
        $imagem = array_key_exists('imagem', $_FILES) ? $_FILES['imagem'] : null;
        $oferta = new Oferta(
            DW3Sessao::get('usuario'),
            $_POST['descricao'],
            $_POST['preco'],
            $imagem
        );
        if ($oferta->isValido()) {
            $oferta->salvar();
            DW3Sessao::setFlash('ofertaFlash', 'Oferta cadastrada.');
            $this->redirecionar(URL_RAIZ . 'ofertas/ativas');

        } else {
            $this->setErros($oferta->getValidacaoErros());
            $this->visao('ofertas/criar.php');
        }
    }

    public function comprar($id)
    {
        $this->verificarLogado();
        $oferta = Oferta::buscarId($id);
        if ($oferta->getCompradorId() == null && $oferta->getVendedorId() != $this->getUsuario()) {
            Oferta::comprar($this->getUsuario(), $id);
            DW3Sessao::setFlash('ofertaFlash', 'Oferta comprada.');
        } else {
            DW3Sessao::setFlash('ofertaFlash', 'Você não pode comprar uma oferta sua ou já vendida.');
        }
        $this->redirecionar(URL_RAIZ . 'ofertas/compras');
    }

    public function compras()
    {
        $this->verificarLogado();
        $paginacao = $this->calcularPaginacao();
        $ofertas = Oferta::buscarCompradosUsuarioLogado($this->getUsuario(), $paginacao['limit'], $paginacao['offset'], $_GET);
        $ultimaPagina = ceil(Oferta::contarCompradosUsuarioLogado($this->getUsuario(), $_GET) / $paginacao['limit']);
        $this->visao('ofertas/compras.php', [
            'ofertas' => $ofertas,
            'pagina' => $paginacao['pagina'],
            'ultimaPagina' => $ultimaPagina,
            'ofertaFlash' => DW3Sessao::getFlash('ofertaFlash')
        ]);
    }

    public function vendas()
    {
        $this->verificarLogado();
        $paginacao = $this->calcularPaginacao();
        $ofertas = Oferta::buscarVendidosUsuarioLogado($this->getUsuario(), $paginacao['limit'], $paginacao['offset'], $_GET);
        $ultimaPagina = ceil(Oferta::contarVendidosUsuarioLogado($this->getUsuario(), $_GET) / $paginacao['limit']);
        $this->visao('ofertas/vendas.php', [
            'ofertas' => $ofertas,
            'pagina' => $paginacao['pagina'],
            'ultimaPagina' => $ultimaPagina,
            'ofertaFlash' => DW3Sessao::getFlash('ofertaFlash')
        ]);
    }

    public function ativas()
    {
        $this->verificarLogado();
        $paginacao = $this->calcularPaginacao();
        $ofertas = Oferta::buscarNaoVendidosUsuarioLogado($this->getUsuario(), $paginacao['limit'], $paginacao['offset'], $_GET);
        $ultimaPagina = ceil(Oferta::contarNaoVendidosUsuarioLogado($this->getUsuario(), $_GET) / $paginacao['limit']);
        $this->visao('ofertas/ativas.php', [
            'ofertas' => $ofertas,
            'pagina' => $paginacao['pagina'],
            'ultimaPagina' => $ultimaPagina,
            'ofertaFlash' => DW3Sessao::getFlash('ofertaFlash')
        ]);
    }

    public function destruir($id)
    {
        $this->verificarLogado();
        $oferta = Oferta::buscarId($id);
        if ($oferta->getCompradorId() === null && $oferta->getVendedorId() == $this->getUsuario()) {
            Oferta::destruir($id);
            DW3Sessao::setFlash('ofertaFlash', 'Oferta destruida.');
        } else {
            DW3Sessao::setFlash('ofertaFlash', 'Você não pode deletar as ofertas dos outros.');
        }
        $this->redirecionar(URL_RAIZ . 'ofertas/ativas');
    }
}
