<?php

namespace Teste\Funcional;

use \Teste\Teste;
use \Framework\DW3Sessao;

class TesteRaiz extends Teste
{
    public function testeAcessar()
    {
        $resposta = $this->get(URL_RAIZ);
        if (DW3Sessao::get('usuario') == null) {
            $this->verificarRedirecionar($resposta, URL_RAIZ . 'login');
        } else {
            $this->verificarRedirecionar($resposta, URL_RAIZ . 'ofertas');
        }
    }
}
