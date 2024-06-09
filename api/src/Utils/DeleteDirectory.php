<?php

namespace App\Utils;

class DeleteDirectory {
    static function deleteCacheImg($dir = "cache") {

        if (!file_exists($dir)) {
            return true;
        }
    
        if (!is_dir($dir)) {
            return false;
        }
    
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::deleteCacheImg("$dir/$file") : unlink("$dir/$file");
        }
    
        return rmdir($dir);
    }
}