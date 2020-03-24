<?php

namespace App\DAO;

abstract class Conexao
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct()
    {
        $host = getenv('CODEEASY_HOST');
        $port = getenv('CODEEASY_PORT');
        $user = getenv('CODEEASY_USER');
        $pass = getenv('CODEEASY_PASSWORD');
        $dbname = getenv('CODEEASY_DBNAME');

        $dsn = "mysql:host={$host};dbname={$dbname};port={$port}";

        $this->pdo = new \PDO($dsn,$user,$pass);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}

