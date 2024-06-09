<?php

namespace App\Controllers;

use App\Class\SelectedProjects;
use App\Http\Request;
use App\Http\Response;
use App\Middleware\UserAuth;
use App\Models\SelectedProjectsDAO;
use Exception;

class SelectedProjectsController {

    public function create(Request $request, Response $response) {

        if(UserAuth::validUserModLogged($request, $response)) {
            try {
                $data = $request::body();

                $existsProjects = SelectedProjectsDAO::fetchAll();

                if(!empty($existsProjects)) {
                    foreach ($existsProjects as $key) {
                        SelectedProjectsDAO::delete($key['id']);
                    }
                }
    
                foreach ($data['selectedProjects'] as $key => $value) {
                    $selectedProject = new SelectedProjects($value);
                    $selectedProject->save();
                }
    
                $response::json([
                    'success' => true,
                    'message' => "Projetos selecionados salvos com sucesso."
                ], 201);

            } catch (Exception $e) {
                $response::json([
                    'error'   => true,
                    'message' => "Falha ao salvar os projetos selecionados."
                ], 500);
            }
        }
    }

    public function fetch(Request $request, Response $response) {
        try {
            $response::json(SelectedProjectsDAO::fetchAll());
        } catch (Exception $e) {
            $response::json([
                'error'   => true,
                'message' => "Falha ao buscar os projetos selecionados."
            ], 500);
        }
    }
}