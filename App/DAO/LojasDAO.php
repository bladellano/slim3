<?php

namespace App\DAO;

use App\Models\LojaModel;

class LojasDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllLojas()
    {
        $lojas = $this->pdo
            ->query('SELECT id,nome,telefone,endereco FROM lojas')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return $lojas;
    }

    public function insertLoja(LojaModel $loja): ?String
    {

        try {
            $stmt = $this->pdo
                ->prepare('INSERT INTO lojas VALUES(
                null, :nome, :telefone, :endereco)');

            $data = array(
                'nome' => $loja->getNome(),
                'telefone' => $loja->getTelefone(),
                'endereco' => $loja->getEndereco()
            );

            $stmt->execute($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteLoja(int $id)
    {
        $stmt = $this->pdo
            ->prepare('DELETE FROM lojas WHERE id = :id');
        $data = ['id' => $id];
        $stmt->execute($data);
    }

    public function updateLoja(LojaModel $loja): void
    {
        $stmt = $this->pdo
            ->prepare('UPDATE lojas SET 
            nome = :nome, 
            telefone = :telefone, 
            endereco = :endereco  
            WHERE id = :id');

        $data = array(
            "nome" => $loja->getNome(),
            "telefone" => $loja->getTelefone(),
            "endereco" => $loja->getEndereco(),
            "id" => $loja->getId()
        );

        $stmt->execute($data);
    }
}
