<?php

namespace App\Models;

final class ProdutoModel
{
    private $id;
    private $loja_id;
    private $nome;
    private $preco;
    private $quantidade;

    public function getId()
    {
        return $this->id;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getLoja_id()
    {
        return $this->loja_id;
    }

    public function setLoja_id($loja_id)
    {
        $this->loja_id = $loja_id;
        return $this;
    }
   
}
