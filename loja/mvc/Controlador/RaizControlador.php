<?php
namespace Controlador;

class RaizControlador extends Controlador
{
    public function index()
    {
        $this->verificarLogado();
        $this->verificarNaoLogado();
    }
}
