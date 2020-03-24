<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ProdutoController
{
	public function getProdutos(Request $request, Response $response, array $args)
	{
		$response = $response->withJson([
			'message' => 'Hello World!'
		]);
		return $response;
	}

	public function insertProduto(Request $request, Response $response, array $args)
	{
		$response = $response->withJson([
			'message' => 'Hello World!'
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
