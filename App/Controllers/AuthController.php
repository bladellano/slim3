<?php

namespace App\Controllers;

use App\DAO\UsuariosDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

final class AuthController
{

    public function login(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        $email = $data['email'];
        $senha = $data['senha'];

        $usuarioDAO = new UsuariosDAO();
        $usuario = $usuarioDAO->getUserByEmail($email);

        if (is_null($usuario))
            return $response->withStatus(401);

        if (!password_verify($senha, $usuario->getSenha()))
            return $response->withStatus(401);

        $tokenPayload = [
            'sub'=>$usuario->getId(),
            'name'=>$usuario->getNome(),
            'email'=>$usuario->getEmail(),
            'expired_at'=>(new \DateTime())->modify('+2 days')
            ->format('Y-m-d H:i:s')
        ];

        var_dump($tokenPayload);
        // var_dump($usuario);

        return $response;
    }
}
