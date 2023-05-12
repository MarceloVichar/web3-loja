<?php

namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;
use \Framework\DW3ImagemUpload;

class Oferta extends Modelo
{
    const BUSCAR_NAO_VENDIDOS_OUTROS_USUARIOS = 'SELECT o.descricao, o.id o_id, o.preco, u.id vendedor_id, u.email vendedor_email, u.nome vendedor_nome, comp.id comprador_id, comp.email comprador_email, comp.nome comprador_nome FROM ofertas o JOIN usuarios u ON (o.vendedor_id = u.id) LEFT JOIN usuarios comp ON (o.comprador_id = comp.id) WHERE o.comprador_id IS NULL AND o.vendedor_id <> ?';

    const CONTAR_NAO_VENDIDOS_OUTROS_USUARIOS = 'SELECT count(id) FROM ofertas WHERE comprador_id IS NULL AND vendedor_id <> ?';

    const BUSCAR_COMPRADOS_USUARIO_LOGADO = 'SELECT o.descricao, o.id o_id, o.preco, u.id vendedor_id, u.email vendedor_email, u.nome vendedor_nome, comp.id comprador_id, comp.email comprador_email, comp.nome comprador_nome FROM ofertas o JOIN usuarios u ON (o.vendedor_id = u.id) LEFT JOIN usuarios comp ON (o.comprador_id = comp.id) WHERE o.comprador_id = ?';

    const CONTAR_COMPRADOS_USUARIO_LOGADO = 'SELECT count(id) FROM ofertas WHERE comprador_id = ?';

    const BUSCAR_DISPONIVEIS_USUARIO_LOGADO = 'SELECT o.descricao, o.id o_id, o.preco, u.id vendedor_id, u.email vendedor_email, u.nome vendedor_nome, comp.id comprador_id, comp.email comprador_email, comp.nome comprador_nome FROM ofertas o JOIN usuarios u ON (o.vendedor_id = u.id) LEFT JOIN usuarios comp ON (o.comprador_id = comp.id) WHERE comprador_id IS NULL AND o.vendedor_id = ?';

    const CONTAR_DISPONIVEIS_USUARIO_LOGADO = 'SELECT count(id) FROM ofertas WHERE comprador_id IS NULL AND vendedor_id = ?';

    const BUSCAR_VENDIDOS_USUARIO_LOGADO = 'SELECT o.descricao, o.id o_id, o.preco, u.id vendedor_id, u.email vendedor_email, u.nome vendedor_nome, comp.id comprador_id, comp.email comprador_email, comp.nome comprador_nome FROM ofertas o JOIN usuarios u ON (o.vendedor_id = u.id) LEFT JOIN usuarios comp ON (o.comprador_id = comp.id) WHERE o.comprador_id IS NOT NULL AND o.vendedor_id = ?';

    const CONTAR_VENDIDOS_USUARIO_LOGADO = 'SELECT count(id) FROM ofertas WHERE comprador_id IS NOT NULL AND vendedor_id = ?';

    const BUSCAR_ID = 'SELECT * FROM ofertas WHERE id = ? LIMIT 1';
    const INSERIR = 'INSERT INTO ofertas(vendedor_id, descricao, preco, comprador_id) VALUES (?, ?, ?, ?)';

    const ATUALIZAR = 'UPDATE ofertas SET comprador_id = ? WHERE id = ?';
    const DELETAR = 'DELETE FROM ofertas WHERE id = ?';
    private $id;
    private $vendedorId;
    private $descricao;

    private $preco;
    private $vendedor;

    private $compradorId;

    private $comprador;

    private $imagem;

    public function __construct(
        $vendedorId,
        $descricao,
        $preco,
        $imagem = null,
        $vendedor = null,
        $compradorId = null,
        $comprador = null,
        $id = null
    )
    {
        $this->id = $id;
        $this->vendedorId = $vendedorId;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
        $this->vendedor = $vendedor;
        $this->compradorId = $compradorId;
        $this->comprador = $comprador;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function getImagem()
    {
        $imagemNome = "{$this->id}.png";
        if (!DW3ImagemUpload::existe($imagemNome)) {
            $imagemNome = 'padrao.png';
        }
        return $imagemNome;
    }

    public function getVendedor()
    {
        return $this->vendedor;
    }

    public function getVendedorId()
    {
        return $this->vendedorId;
    }

    public function getComprador()
    {
        return $this->comprador;
    }

    public function getCompradorId()
    {
        return $this->compradorId;
    }

    public function salvar()
    {
        $this->inserir();
        $this->salvarImagem();
    }

    private function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->vendedorId, PDO::PARAM_INT);
        $comando->bindValue(2, $this->descricao, PDO::PARAM_STR);
        $comando->bindValue(3, $this->preco, PDO::PARAM_STR);
        $comando->bindValue(4, $this->compradorId, PDO::PARAM_INT);
        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }

    private function salvarImagem()
    {
        if (DW3ImagemUpload::isValida($this->imagem)) {
        print_r('<pre>');
        print_r($this->imagem);
        print_r('</pre>');
            $nomeCompleto = PASTA_PUBLICO . "img/{$this->id}.png";
            print_r($nomeCompleto);
//            move_uploaded_file($this->imagem['tmp_name'], $nomeCompleto);
//            exit();
            DW3ImagemUpload::salvar($this->imagem, $nomeCompleto);
        }
    }

    public static function buscarId($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $objeto = null;
        $registro = $comando->fetch();
        if ($registro) {
            $objeto = new Oferta(
                $registro['vendedor_id'],
                $registro['descricao'],
                $registro['preco'],
                null,
                null,
                $registro['comprador_id'],
                null,
                $registro['id']
            );
        }
        return $objeto;
    }

    public static function buscarNaoVendidosOutrosUsuarios($idUsuario, $limit = 4, $offset = 0, $filtro = [])
    {
        return self::buscarComFiltros(self::BUSCAR_NAO_VENDIDOS_OUTROS_USUARIOS, $idUsuario, $limit, $offset, $filtro);
    }

    public static function buscarCompradosUsuarioLogado($idUsuario, $limit = 4, $offset = 0, $filtro = [])
    {
        return self::buscarComFiltros(self::BUSCAR_COMPRADOS_USUARIO_LOGADO, $idUsuario, $limit, $offset, $filtro);
    }

    public static function buscarVendidosUsuarioLogado($idUsuario, $limit = 4, $offset = 0, $filtro = [])
    {
        return self::buscarComFiltros(self::BUSCAR_VENDIDOS_USUARIO_LOGADO, $idUsuario, $limit, $offset, $filtro);
    }

    public static function buscarNaoVendidosUsuarioLogado($idUsuario, $limit = 4, $offset = 0, $filtro = [])
    {
        return self::buscarComFiltros(self::BUSCAR_DISPONIVEIS_USUARIO_LOGADO, $idUsuario, $limit, $offset, $filtro);
    }

    private static function buscarComFiltros($busca, $idUsuario, $limit = 4, $offset = 0, $filtro = [])
    {
        $sqlWhere = '';
        if (array_key_exists('descricao', $filtro) && $filtro['descricao'] != '') {
            $sqlWhere .= ' AND INSTR(descricao, ?) > 0';
        }
        $sql = $busca . $sqlWhere . ' ORDER BY o.id LIMIT ? OFFSET ?';
        $comando = DW3BancoDeDados::prepare($sql);
        $comando->bindValue(1, $idUsuario, PDO::PARAM_INT);
        if (!empty($sqlWhere)) {
            $comando->bindValue(2, $filtro['descricao'], PDO::PARAM_STR);
            $comando->bindValue(3, $limit, PDO::PARAM_INT);
            $comando->bindValue(4, $offset, PDO::PARAM_INT);
        } else {
            $comando->bindValue(2, $limit, PDO::PARAM_INT);
            $comando->bindValue(3, $offset, PDO::PARAM_INT);
        }
        $comando->execute();
        $registros = $comando->fetchAll();
        $objetos = [];
        foreach ($registros as $registro) {
            $vendedor = new Usuario(
                $registro['vendedor_nome'],
                $registro['vendedor_email'],
                '',
                $registro['vendedor_id']
            );
            $comprador = new Usuario(
                $registro['comprador_nome'],
                $registro['comprador_email'],
                '',
                $registro['comprador_id']
            );
            $objetos[] = new Oferta(
                $registro['vendedor_id'],
                $registro['descricao'],
                $registro['preco'],
                null,
                $vendedor,
                $registro['comprador_id'],
                $comprador,
                $registro['o_id']
            );
        }
        return $objetos;
    }

    public static function contarNaoVendidosOutrosUsuarios($idUsuario, $filtro = [])
    {
        return self::contarComFiltros(self::CONTAR_NAO_VENDIDOS_OUTROS_USUARIOS, $idUsuario, $filtro);
    }

    public static function contarCompradosUsuarioLogado($idUsuario, $filtro = [])
    {
        return self::contarComFiltros(self::CONTAR_COMPRADOS_USUARIO_LOGADO, $idUsuario, $filtro);
    }

    public static function contarVendidosUsuarioLogado($idUsuario, $filtro = [])
    {
        return self::contarComFiltros(self::CONTAR_VENDIDOS_USUARIO_LOGADO, $idUsuario, $filtro);
    }

    public static function contarNaoVendidosUsuarioLogado($idUsuario, $filtro = [])
    {
        return self::contarComFiltros(self::CONTAR_DISPONIVEIS_USUARIO_LOGADO, $idUsuario, $filtro);
    }

    public static function contarComFiltros($busca, $idUsuario, $filtro = [])
    {
        $sqlWhere = '';
        if (array_key_exists('descricao', $filtro) && $filtro['descricao'] != '') {
            $sqlWhere .= ' AND INSTR(descricao, ?) > 0';
        }
        $sql = $busca . $sqlWhere;
        $comando = DW3BancoDeDados::prepare($sql);
        $comando->bindValue(1, $idUsuario, PDO::PARAM_INT);
        if (!empty($sqlWhere)) {
            $comando->bindValue(2, $filtro['descricao'], PDO::PARAM_STR);
        }
        $comando->execute();
        $registros = $comando->fetchAll();
        $count = $registros[0][0];
        return $count;
    }

    public static function comprar($vendedorId, $id)
    {
        $comando = DW3BancoDeDados::prepare(self::ATUALIZAR);
        $comando->bindValue(1, $vendedorId, PDO::PARAM_INT);
        $comando->bindValue(2, $id, PDO::PARAM_INT);
        $comando->execute();
    }

    public static function destruir($id)
    {
        $comando = DW3BancoDeDados::prepare(self::DELETAR);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
    }

    protected function verificarErros()
    {
        if (isset($this->descricao) &&strlen($this->descricao) < 3) {
            $this->setErroMensagem('descricao', 'Descrição Mínima 3 caracteres.');
        }
        if (!is_numeric($this->preco) || $this->preco <= 0) {
            $this->setErroMensagem('preco', 'Preencha com um preço maior que 0.');
        }
        if (DW3ImagemUpload::existeUpload($this->imagem)
            && !DW3ImagemUpload::isValida($this->imagem)) {
            $this->setErroMensagem('imagem', 'A imagem deve ser de no máximo 500 KB.');
        }
    }
}
