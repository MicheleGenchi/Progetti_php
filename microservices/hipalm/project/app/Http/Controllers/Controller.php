<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Exception;


class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function testconnection(): JsonResponse
    {
        try {
            $databases=[];
            foreach (DB::select('SHOW DATABASES') as $database) 
                array_push($databases, $database);
            $ris = [
                'response' => $databases,
                'code' => 200
            ];
            return response()->json($ris["response"], $ris['code']);

        } catch (\PDOException $e) {
            $ris = [
                'response' => $e->getMessage(),
                'code' => $e->getCode()
            ];
            return response()->json($ris['response'], $ris['code']);
        }
    }
}
