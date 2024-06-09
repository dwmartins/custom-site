<?php 

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Validators\UserValidators;
use App\Models\UserDAO;
use App\Class\User;
use App\Http\JWTManager;
use App\Middleware\UserAuth;
use Exception;

class UserController {

    public function auth(Request $request, Response $response) {
        try {
            $data = Request::authorization();

            if(!empty($data)) {
                $user = UserDAO::fetchById($data['userId']);
                $user = new User($user);
                
                if(!empty($user)) {
                    $tokenDecode = JWTManager::validate($data['token'], $user);
                    
                    if(!empty($tokenDecode) && !isset($tokenDecode->expired)) {
                        return $response::json([
                            'success' => true,
                            'role'    => $user->getRole()
                        ]);

                    } else if(isset($tokenDecode->expired)) {
                        return $response::json([
                            'error'        => true,
                            'expiredToken' => "Sua sessão expirou, realize o login novamente."
                        ], 401);
                    }
                }
            }

            return $response::json([
                'error'        => true,
                'invalidToken' => "Realize o login para acessar esta área."
            ], 401);

        } catch (Exception $e) {
            $response::json([
                'error'   => true,
                'message' => "Falha ao validar o usuário logado."
            ], 500);
        }
    }

    public function create(Request $request, Response $response) {

        if(UserAuth::validUserAdminLogged($request, $response)) {
            try {
                $body = $request::body();
                
                UserValidators::create($body);
    
                if(UserDAO::fetchByEmail($body['email']) != false) {
                    return $response::json([
                        'error'     => true,
                        'message'   => "Este e-mail já está em uso."
                    ], 409);
                }
                
                $user = new User($body);
                $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
                $user->setRole("mod");
                $user->setToken(JWTManager::newCrypto());
                $user->setActive("Y");
    
                $result = UserDAO::save($user);
                $user->setId($result);
    
                $response::json([
                    'success' => true,
                    'message' => "Usuário criado com sucesso."
                ], 201);
    
            } catch (Exception $e) {
                $response::json([
                    'error'   => true,
                    'message' => "Falha ao criar o usuário."
                ], 500);
            }
        }
    }

    public function update(Request $request, Response $response) {
        try {
            $body = $request::body();

            UserValidators::update($body);

            $emailExists = UserDAO::fetchByEmail($body['email']);

            if($emailExists != false && $emailExists['id'] != $body['id']) {
                return $response::json([
                    'error'     => true,
                    'message'   => "Este e-mail já está em uso."
                ], 409);
            }

            $user = new User($body);
            UserDAO::update($user);

            return $response::json([
                'success'   => true,
                'message'   => "Usuário atualizado com sucesso."
            ], 201);

        } catch (Exception $e) {
            $response::json([
                'error'   => true,
                'message' => "Falha ao atualizar o usuário."
            ], 500);
        }
    }

    public function remove(Request $request, Response $response, $id) {

        if(UserAuth::validUserAdminLogged($request, $response)) {
            try {
                UserDAO::delete($id[0]);
    
                return $response::json([
                    'success'   => true,
                    'message'   => "Usuário deletado com sucesso."
                ], 200);
    
            } catch (Exception $e) {
                $response::json([
                    'error'   => true,
                    'message' => "Falha ao deletar o usuário."
                ], 500);
            }
        }
    }

    public function fetch(Request $request, Response $response) {

        if(UserAuth::validUserAdminLogged($request, $response)) {
            try {

                $filters = $request::body();
                $activeFilter = isset($filters['active']) ? $filters['active'] : "";
    
                return $response::json(
                    UserDAO::fetchAll($activeFilter)
                , 200); 
    
            } catch (Exception $e) {
                $response::json([
                    'error'   => true,
                    'message' => "Falha ao buscar os usuários."
                ], 500);
            }
        }
    }

    public function login(Request $request, Response $response) {
        try {
            $data = $request::body();

            $userExists = UserDAO::fetchByEmail($data['email']);

            if(!empty($userExists)) {
                $user = new User($userExists);

                if($user->getActive() === "Y") {
                    if(password_verify($data['password'], $user->getPassword())) {
                        $userData = array(
                            "id"        => $user->getId(),
                            "name"      => $user->getName(),
                            "lastName"  => $user->getLastName(),
                            "email"     => $user->getEmail(),
                            "role"      => $user->getRole(),
                            "photo"     => $user->getPhoto(),
                            "token"     => JWTManager::generate($user),
                            "createdAt" => $user->getCreatedAt(),
                            "updatedAt" => $user->getUpdatedAt()
                        );

                        return $response::json($userData, 200);
                    }
                }
            } 

            return $response::json([
                'error'   => true,
                'message'    => "Usuário ou senha inválidos."
            ], 401); 
            
        } catch (Exception $e) {
            $response::json([
                'error' => true,
                'message' => "Falha ao Realizar o login"
            ], 500);
        }
    }
}