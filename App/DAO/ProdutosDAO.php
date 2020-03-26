<?php

namespace App\DAO;

use App\Models\ProdutoModel;

class ProdutosDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllProdutos()
    {
        $produtos = $this->pdo
            ->query('SELECT * FROM produtos')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return $produtos;
    }

    public function insertProduto(ProdutoModel $produto)
    {
        try {
            $stmt = $this->pdo
                ->prepare('INSERT INTO produtos VALUES(null,:loja_id,:nome,:preco,:quantidade)');
            $stmt->execute([
                "loja_id" => $produto->getLoja_id(),
                "nome" => $produto->getNome(),
                "preco" => $produto->getPreco(),
                "quantidade" => $produto->getQuantidade()
            ]);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}
