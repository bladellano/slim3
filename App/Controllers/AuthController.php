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

    public function login(Request $request, Response $response, array $args): Response
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

        $tokenPayload = $this->setTokenPayload($usuario, $expireDate);

        $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

        $refreshToken = $this->setRefreshTokenPayload($usuario->getEmail());

        $response = $response->withJson(
            $this->saveTokenRefreshToken(
                $expireDate,
                $refreshToken,
                $token,
                $usuario->getId()
            )
        );

        return $response;
    }


    public function refreshToken(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $refreshToken = $data['refresh_token'];

        $expireDate = $data['expire_date'];

        $refreshTokenDecoded = JWT::decode(
            $refreshToken,
            getenv('JWT_SECRET_KEY'),
            ['HS256']
        );

        $tokensDAO = new TokensDAO();
        
        $refresTokenExist = $tokensDAO->verifyRefreshToken($refreshToken);

        if (!$refresTokenExist)
            return $response->withStatus(401);
        $usuariosDAO = new UsuariosDAO();
        $usuario = $usuariosDAO->getUserByEmail($refreshTokenDecoded->email);
        if (is_null($usuario))
            return $response->withStatus(401);
            
        $tokensDAO->changeStatusToken($refreshToken);

        $tokenPayload = $this->setTokenPayload($usuario, $expireDate);

        $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

        $refreshToken = $this->setRefreshTokenPayload($usuario->getEmail());

        $response = $response->withJson(
            $this->saveTokenRefreshToken(
                $expireDate,
                $refreshToken,
                $token,
                $usuario->getId()
            )
        );

        return $response;
    }


    //Funções auxiliares

    public function setTokenPayload(Object $usuario, String $expireDate)
    {
        $tokenPayload = [
            'sub' => $usuario->getId(),
            'name' => $usuario->getNome(),
            'email' => $usuario->getEmail(),
            'expired_at' => $expireDate
        ];
        return $tokenPayload;
    }

    public function setRefreshTokenPayload(String $usuarios_email)
    {
        $refreshTokenPayload = [
            'email' => $usuarios_email,
            'random' => uniqid()
        ];

        return JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));
    }

    public function saveTokenRefreshToken($expireDate, $refreshToken, $token, $usuarios_id)
    {
        $tokenModel = new TokenModel();
        $tokenModel
            ->setExpired_at($expireDate)
            ->setRefresh_token($refreshToken)
            ->setToken($token)
            ->setUsuario_id($usuarios_id);

        $tokenDAO = new TokensDAO();
        $tokenDAO->createToken($tokenModel);

        return [
            'token' => $token,
            'refresh_token' => $refreshToken
        ];
    }
}
