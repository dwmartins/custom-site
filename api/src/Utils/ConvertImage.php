<?php

namespace App\Utils;

use Exception;
use Gregwar\Image\Image;

class ConvertImage {
    static function convertToPNG($file) {
        // Abrir a imagem e converter para PNG diretamente
        $image = Image::open($file['tmp_name']);
        $pngDataImage = $image->png();
    
        return $pngDataImage;
    }
}