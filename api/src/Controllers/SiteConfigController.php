<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Middleware\UserAuth;
use App\Utils\ConvertImage;
use App\Utils\DeleteDirectory;
use App\Utils\UploadFile;
use App\Validators\FileValidators;
use Exception;

class SiteCOnfigController {
    private static $folderImagens = "site";

    public function setImages(Request $request, Response $response) {
        if(UserAuth::validUserModLogged($request, $response)) {
            try {
                $requestFiles = $request::files();
                $files = [
                    "logoImage"    => isset($requestFiles['logoImage']) ? $requestFiles['logoImage'] : null,
                    "coverImage"   => isset($requestFiles['coverImage']) ? $requestFiles['coverImage'] : null,
                    "ico"          => isset($requestFiles['ico']) ? $requestFiles['ico'] : null,
                    "defaultImage" => isset($requestFiles['defaultImage']) ? $requestFiles['defaultImage'] : null
                ];

                foreach ($files as $key => $value) {
                    if(empty($value)) {
                        continue;
                    }

                    if($key == "ico") {
                        $fileInfo = FileValidators::validIcon($value);
                    } else {
                        $fileInfo = FileValidators::validImage($value);
                    }

                    if(isset($fileInfo['invalid'])) {
                        $response::json([
                            'error'   => true,
                            'message' => $fileInfo['invalid']
                        ], 400);

                        return;
                    }
                }

                foreach ($files as $key => $value) {
                    if(empty($value)) {
                        continue;
                    }

                    if($key == "ico") {
                        $fileInfo = FileValidators::validIcon($value);
                    } else {
                        $fileInfo = FileValidators::validImage($value);
                    }

                    $fileName = "";
                    $deleteCache = false;

                    switch ($key) {
                        case 'logoImage':
                            $fileName = "logo-image.png";
                            break;
                        case 'coverImage':
                            $fileName = "cover-image.png";
                            break;
                        case 'ico':
                            $fileName = "icon.ico";
                            break;
                        case 'defaultImage':
                            $fileName = "default-image.png";
                            break;
                        default:
                            break;
                    }

                    if($fileInfo['mimeType'] != "png" && $key != "ico") {
                        $imagePNG = ConvertImage::convertToPNG($value);
                        UploadFile::uploadFile($imagePNG, self::$folderImagens, $fileName);
                        $deleteCache = true;
                    } else {
                        UploadFile::uploadFile($value, self::$folderImagens, $fileName);
                    }
                }

                if($deleteCache) {
                    DeleteDirectory::deleteCacheImg();
                }

                return $response::json([
                    'error'   => false,
                    'message' => "Imagem(ns) atualizada(s) com sucesso."
                ]);

            } catch (Exception $e) {
                return $response::json([
                    'error'   => true,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }
}