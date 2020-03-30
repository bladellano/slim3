<?php

namespace App\Controllers;

use App\DAO\TokensDAO;
use App\DAO\UsuariosDAO;
use App\Models\TokenModel;
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
        $expireDate = $data['expire_date'];

        $usuarioDAO = new UsuariosDAO();
        $usuario = $usuarioDAO->getUserByEmail($email);

        if (is_null($usuario))
            return $response->withStatus(401);

        if (!password_verify($senha, $usuario->getSenha()))
            return $response->withStatus(401);

        $tokenPayload = [
            'sub' => $usuario->getId(),
            'name' => $usuario->getNome(),
            'email' => $usuario->getEmail(),
            'expired_at' => $expireDate
        ];

        $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));
        $refreshTokenPayload = [
            'email' => $usuario->getEmail()
        ];

        $refreshToken = JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));

        $tokenModel = new TokenModel();

        $tokenModel
        ->setExpired_at($expireDate)
        ->setRefresh_token($refreshToken)
        ->setToken($token)
        ->setUsuario_id($usuario->getId());

        $tokenDAO = new TokensDAO();
        $tokenDAO->createToken($tokenModel);

        $response = $response->withJson([
            'token'=>$token,
            'refresh_token'=>$refreshToken
        ]);

        return $response;
    }
}
