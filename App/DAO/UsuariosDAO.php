<?php

namespace App\DAO;

use App\Models\UsuarioModel;

class UsuariosDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserByEmail(string $email):?UsuarioModel
    {
        $stmt = $this->pdo
            ->prepare('SELECT 
            id,
            nome,
            email,
            senha 
            FROM usuarios WHERE email =:email');
        $stmt->bindParam('email', $email);
        $stmt->execute();
        $usuarios = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$usuarios) return null;

        $usuario = new UsuarioModel();
        $usuario->setId($usuarios['id']);
        $usuario->setNome($usuarios['nome']);
        $usuario->setEmail($usuarios['email']);
        $usuario->setSenha($usuarios['senha']);
        return $usuario;
    }
}
