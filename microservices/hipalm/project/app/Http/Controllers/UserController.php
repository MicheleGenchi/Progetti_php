<?php

namespace App\Http\Controllers;

use App\Models\User as UserModel;
use App\Traits\WithRestUtilsTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;


/**
 * Summary of GeoNazioneController
 */
class UserController extends Controller
{
    use WithRestUtilsTrait;

 
   /**
     * Summary of get
     * @param Request $request
     *     array country_code   // 2 caratteri che indicano la nazione 'IT'
     *     array country         
     * @return JsonResponse
     *     {
     *         "nazione_code": "IT",
     *         "nazione": "Italy",
     *     }
     */
    public function get(Request $request):JsonResponse
    {
        try {
            $model = new UserModel();
            $ris=$model->get($request->all());

        } catch (Exception $e) {
            $code = (int) $e->getCode();
            $ris = [
                'response' => $e->getMessage(),
                'code' => self::validateErrorCode($code)
            ];
        }

        return response()->json($ris['response'], $ris['code']);

    }
}