<?php

namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;
use \Framework\DW3ImagemUpload;

class Usuario extends Modelo
{
    const BUSCAR_POR_EMAIL = 'SELECT * FROM usuarios WHERE email = ? LIMIT 1';
    const INSERIR = 'INSERT INTO usuarios(nome,email,senha) VALUES (?, ?, ?)';
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $senhaPlana;

    public function __construct(
        $nome,
        $email,
        $senhaPlana,
        $id = null
    )
    {
        $this->nome = $nome;
        $this->id = $id;
        $this->email = $email;
        $this->senhaPlana = $senhaPlana;
        if ($senhaPlana != null) {
            $this->senha = password_hash($senhaPlana, PASSWORD_BCRYPT);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function verificarSenha($senhaPlana)
    {
        return password_verify($senhaPlana, $this->senha);
    }

    protected function verificarErros()
    {
        if (strlen($this->nome) < 3) {
            $this->setErroMensagem('nome', 'Deve ter no mínimo 3 caracteres.');
        }
        if (strlen($this->email) < 3) {
            $this->setErroMensagem('email', 'Deve ter no mínimo 3 caracteres.');
        }
        if (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $this->email)) {
            $this->setErroMensagem('email', 'Endereço de e-mail inválido.');
        }
        if (strlen($this->senhaPlana) < 3) {
            $this->setErroMensagem('senha', 'Deve ter no mínimo 3 caracteres.');
        }
    }

    public function salvar()
    {
        $this->inserir();
    }

    private function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->nome, PDO::PARAM_STR);
        $comando->bindValue(2, $this->email, PDO::PARAM_STR);
        $comando->bindValue(3, $this->senha, PDO::PARAM_STR);
        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }

    public static function buscarEmail($email)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_POR_EMAIL);
        $comando->bindValue(1, $email, PDO::PARAM_STR);
        $comando->execute();
        $objeto = null;
        $registro = $comando->fetch();
        if ($registro) {
            $objeto = new Usuario(
                $registro['nome'],
                $registro['email'],
                '',
                $registro['id']
            );
            $objeto->senha = $registro['senha'];
        }
        return $objeto;
    }
}
