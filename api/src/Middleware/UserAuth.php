<?php

namespace App\Middleware;

use App\Class\User;
use App\Http\JWTManager;
use App\Http\Request;
use App\Http\Response;
use App\Models\UserDAO;

class UserAuth {
    public static function validUserAdminLogged(Request $request, Response $response) {
        $headers = Request::authorization();

        $token  = $headers['token'] ?? '';
        $userId = $headers['userId'] ?? '';

        if(!$token) {
            return $response::json([
                'error'        => true,
                'invalidToken' => "Realize o login para acessar esta área."
            ], 401);
        }

        $user = UserDAO::fetchById($userId);
        $user = new User($user);

        if(!empty($user)) {
            $decoded = JWTManager::validate($token, $user);

            if(!$decoded) {
                return $response::json([
                    'error'        => true,
                    'invalidToken' => "Realize o login para acessar esta área."
                ], 401);
            }

            if(isset($decoded->expired)) {
                return $response::json([
                    'error'        => true,
                    'expiredToken' => "Sua sessão expirou, realize o login novamente."
                ], 401);
            }

            if($user->getRole() != "admin") {
                return $response::json([
                    'error'             => true,
                    'invalidPermission' => "Você não tem permissão para executar essa ação."
                ], 403);
            }

            return true;

        } else {
            return $response::json([
                'error'        => true,
                'invalidToken' => "Realize o login para acessar esta área."
            ], 401);
        }
    }

    public static function validUserModLogged(Request $request, Response $response) {
        $headers = Request::authorization();

        $token  = $headers['token'] ?? '';
        $userId = $headers['userId'] ?? '';

        if(!$token) {
            return $response::json([
                'error'        => true,
                'invalidToken' => "Realize o login para acessar esta área."
            ], 401);
        }

        $user = UserDAO::fetchById($userId);
        $user = new User($user);

        if(!empty($user)) {
            $decoded = JWTManager::validate($token, $user);

            if(!$decoded) {
                return $response::json([
                    'error'        => true,
                    'invalidToken' => "Realize o login para acessar esta área."
                ], 401);
            }

            if(isset($decoded->expired)) {
                return $response::json([
                    'error'        => true,
                    'expiredToken' => "Sua sessão expirou, realize o login novamente."
                ], 401);
            }

            if($user->getRole() != "mod" && $user->getRole() != "admin") {
                return $response::json([
                    'error'             => true,
                    'invalidPermission' => "Você não tem permissão para executar essa ação."
                ], 403);
            }

            return true;

        } else {
            return $response::json([
                'error'        => true,
                'invalidToken' => "Realize o login para acessar esta área."
            ], 401);
        }
    }
}