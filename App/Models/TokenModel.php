<?php

namespace App\Models;

final class TokenModel
{
    private $id;
    private $usuario_id;
    private $token;
    private $refresh_token;
    private $expired_at;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id): self
    {
        $this->usuario_id = $usuario_id;
        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token): self
    {
        $this->token = $token;
        return $this;
    }
    public function getRefresh_token()
    {
        return $this->refresh_token;
    }

    public function setRefresh_token($refresh_token): self
    {
        $this->refresh_token = $refresh_token;
        return $this;
    }
     
    public function getExpired_at()
    {
        return $this->expired_at;
    }

    public function setExpired_at($expired_at): self
    {
        $this->expired_at = $expired_at;
        return $this;
    }
}
