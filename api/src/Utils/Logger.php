<?php 

namespace App\Utils;

class Logger {
    public static function logError($errorMessage) {
        // $logFilePath = './error.log';
        $logFilePath = "../../error.log";
        $formattedMessage = '[' . date('Y-m-d H:i:s') . '] ' . $errorMessage . "\n";
        file_put_contents($logFilePath, $formattedMessage, FILE_APPEND);
    }
}