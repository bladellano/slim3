<?php

namespace App\DAO;

use App\Models\TokenModel;

class TokensDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }
    public function createToken(TokenModel $token): void
    {
        $stmt = $this->pdo
            ->prepare('INSERT INTO tokens
        (
        token,
        refresh_token,
        expired_at,
        usuarios_id
        ) VALUES (
            :token,
            :refresh_token,
            :expired_at,
            :usuarios_id
        )');
        $stmt->execute([
            'token' => $token->getToken(),
            'refresh_token' => $token->getRefresh_token(),
            'expired_at' => $token->getExpired_at(),
            'usuarios_id' => $token->getUsuario_id()
        ]);
    }
}
