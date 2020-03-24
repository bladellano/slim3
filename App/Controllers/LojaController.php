<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\LojasDAO;
use App\Models\LojaModel;

final class LojaController
{
	public function getLojas(Request $request, Response $response, array $args)
	{
		$lojasDAO = new LojasDAO();
		$lojas = $lojasDAO->getAllLojas();
		$response = $response->withJson($lojas);
		return $response;
	}

	public function insertLoja(Request $request, Response $response, array $args)
	{
		$data = $request->getParsedBody();

		$lojasDAO = new LojasDAO();
		$loja = new LojaModel();

		$loja->setNome($data['nome']);
		$loja->setEndereco($data['endereco']);
		$loja->setTelefone($data['telefone']);

		$lojasDAO->insertLoja($loja);

		$response = $response->withJson([
			'message' => 'Loja inserida com sucesso!'
		]);

		return $response;
	}

	public function updateLoja(Request $request, Response $response, array $args)
	{
		$response = $response->withJson([
			'message' => 'Hello World!'
		]);

		return $response;
	}

	public function deleteLoja(Request $request, Response $response, array $args)
	{
		$data = $request->getParsedBody();
		$lojasDAO = new LojasDAO();
		$lojasDAO->deleteLoja($data['id']);

		$response = $response->withJson([
			'message' => 'Loja excluída com sucesso!'
		]);

		return $response;
	}
}
