<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\ProdutosDAO;
use App\Models\ProdutoModel;

final class ProdutoController
{
	public function getProdutos(Request $request, Response $response, array $args)
	{
		$produtosDAO = new ProdutosDAO();
		$produtos = $produtosDAO->getAllProdutos();
		$response = $response->withJson($produtos);
		return $response;
	}

	public function insertProduto(Request $request, Response $response, array $args)
	{

		$data = $request->getParsedBody();
		
		$produtoDao = new ProdutosDAO();
		$produto = new ProdutoModel();
		
		$produto->setLoja_id($data["loja_id"]);
		$produto->setNome($data["nome"]);
		$produto->setPreco($data["preco"]);
		$produto->setQuantidade($data["quantidade"]);

		$produtoDao->insertProduto($produto);

		$response = $response->withJson([
			'message' => 'Produto inserido com sucesso!'
		]);
		return $response;
	}

	public function updateProduto(Request $request, Response $response, array $args)
	{
		$response = $response->withJson([
			'message' => 'Hello World!'
		]);
		return $response;
	}

	public function deleteProduto(Request $request, Response $response, array $args)
	{
		$response = $response->withJson([
			'message' => 'Hello World!'
		]);
		return $response;
	}
}
