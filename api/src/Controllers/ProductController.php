<?php

namespace App\Controllers;

use App\Class\Product;
use App\Http\Request;
use App\Http\Response;
use App\Middleware\UserAuth;
use App\Models\ProductDAO;
use App\Utils\UploadFile;
use App\Validators\FileValidators;
use App\Validators\ProductValidators;
use Exception;

class ProductController {

    /**
     * $type = "Cadeiras e Banquetas" || "Conjuntos" || "Mesas";
     * 
     */

    private static $folderProducts = "products";

    public function create(Request $request, Response $response) {
        if(UserAuth::validUserModLogged($request, $response)) {
            try {
                $data = $request::body();
                $file = $request::files();
                $fileData = false;

                if(isset($file['photo'])) {
                    $fileData = FileValidators::validImage($file['photo']);

                    if(isset($fileData['invalid'])) {
                        $response::json([
                            'error'   => true,
                            'message' => $fileData['invalid']
                        ], 400);

                        return;
                    }
                }
                
                if(!ProductValidators::create($data)) {
                    return;
                }
                
                $product = new Product($data);
                $productId = ProductDAO::save($product);

                if(isset($file['photo']) && !isset($fileData["invalid"])) {
                    $fileFolder = 'products';

                    $fileName = $productId . "." . $fileData['mimeType'];

                    UploadFile::uploadFile($file['photo'], $fileFolder, $fileName);
                    ProductDAO::updatePhoto($fileName, $productId);
                }
    
                $response::json([
                    'success' => true,
                    'message' => "Produto salvo com sucesso."
                ], 201);
    
            } catch (Exception $e) {
                $response::json([
                    'error'   => true,
                    'message' => "Falha ao salvar o produto."
                ], 500);
            }
        }
    }

    public function update(Request $request, Response $response) {
        if(UserAuth::validUserModLogged($request, $response)) {
            try {
                $data = $request::body();
    
                if(!ProductValidators::update($data)) {
                    return;
                }
    
                $product = new Product($data);
                ProductDAO::update($product);
    
                $response::json([
                    'success' => true,
                    'message' => "Produto editado com sucesso."
                ], 201);
    
            } catch (Exception $e) {
                $response::json([
                    'error'   => true,
                    'message' => "Falha ao editar o produto."
                ], 500);
            }
        }
    }

    public function delete(Request $request, Response $response, $id) {
        if(UserAuth::validUserModLogged($request, $response)) {
            try {

                $product = new Product(ProductDAO::fetchById($id[0]));

                if(!empty($product->getPhoto())) {
                    $fileFolder = 'products';

                    UploadFile::removeFile($product->getPhoto(), $fileFolder);
                }

                ProductDAO::delete($product->getId());
    
                $response::json([
                    'success' => true,
                    'message' => "Produto deletado com sucesso."
                ], 201);
    
            } catch (Exception $e) {
                $response::json([
                    'error'   => true,
                    'message' => "Falha ao deletar o produto."
                ], 500);
            }
        }
    }

    public function fetch(Request $request, Response $response) {
        try {
            $filters = $request::body();
            $activeFilter = isset($filters['active']) ? $filters['active'] : "";

            return $response::json(ProductDAO::fetchAll($activeFilter)); 

        } catch (Exception $e) {
            $response::json([
                'error'   => true,
                'message' => "Falha ao buscar os produtos."
            ], 500);
        }
    }
}