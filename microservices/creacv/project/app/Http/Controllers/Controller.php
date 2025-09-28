<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Connessione;
use App\Traits\WithRestUtilsTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class Controller extends BaseController
{
    use WithRestUtilsTrait;


    public function home(): Factory|View
    {
        return view('welcome');
    }

    public function xdebug(): Factory|View
    {
        return view("xdebug");
    }

    public function testconnessione(Request $request): JsonResponse
    {
        try {
            $model = new Connessione();
            $ris = $model->test($request->all());
        } catch (Exception $e) {
            $code = (int) $e->getCode();
            $ris = [
                'response' => $e->getMessage(),
                'code' => self::validateErrorCode($code)
            ];
        }
        return response()->json($ris, $ris['code']);
    }

    public function allheader(): JsonResponse
    {
        $ris=[];
        try {
            $headers =  getallheaders();
            foreach($headers as $key=>$val){
                array_push($ris, [$key . ': ' . $val . '<br>']);
            }
        } catch (Exception $e) {
            $code = (int) $e->getCode();
            $ris = [
                'response' => $e->getMessage(),
                'code' => self::validateErrorCode($code)
            ];
        }
        return response()->json($ris, 200);
    }
}