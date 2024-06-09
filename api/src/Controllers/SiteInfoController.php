<?php

namespace App\Controllers;

use App\Class\SiteInfo;
use App\Http\Request;
use App\Http\Response;
use App\Middleware\UserAuth;
use App\Models\SiteInfoDAO;
use Exception;

class SiteInfoController {
    public function create(Request $request, Response $response) {
        try {
            if(UserAuth::validUserModLogged($request, $response)) {
                $data = $request::body();
                $siteInfo = new SiteInfo($data);

                if(empty($siteInfo->getId())) {
                    $siteInfo->save();
                } else {
                    SiteInfoDAO::update($siteInfo);
                }

                $response::json([
                    'success' => true,
                    'message' => "Informações do site salva com sucesso."
                ], 201);
            }
        } catch (Exception $e) {
            $response::json([
                'error'   => true,
                'message' => "Falha ao salvar as informações do site."
            ], 500);
        }
    }

    public function update(Request $request, Response $response) {
        try {
            $data = $request::body();
            $siteInfo = new SiteInfo($data);
            SiteInfoDAO::update($siteInfo);

            $response::json([
                'success' => true,
                'message' => "Informações do site atualizadas com sucesso."
            ], 201);

        } catch (Exception $e) {
            $response::json([
                'error'   => true,
                'message' => "Falha ao atualizar as informações do site."
            ], 500);
        }
    }

    public function fetch(Request $request, Response $response) {
        try {
            return $response::json(SiteInfoDAO::fetchAll());
            
        } catch (Exception $e) {
            $response::json([
                'error'   => true,
                'message' => "Falha ao buscar as informações do site."
            ], 500);
        }
    }
}