<?php

namespace App\Controllers;

use App\Http\Response;
use App\Http\Request;

class NotFoundController {
    public function index(Request $request, Response $response) {
        $response::json([
            'error'   => true,
            'message' => 'Sorry, route not found.'
        ], 405);
    }
}