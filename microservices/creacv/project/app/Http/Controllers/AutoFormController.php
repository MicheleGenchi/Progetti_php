<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Traits\WithRestUtilsTrait;
use App\Traits\ConstraintsTrait;
use App\Traits\DBUtilitiesTrait;
use App\Traits\WithValidationTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class AutoFormController extends BaseController
{
    use WithRestUtilsTrait,
        ConstraintsTrait,
        DBUtilitiesTrait,
        WithValidationTrait;

    public function compilaDocumento(Request $request):JsonResponse|BinaryFileResponse
    {
        $constraints = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'filedoc' => new Assert\Optional(self::getRules('file', ['.doc', '.docx', 'dotx'])),
            'filexml' => new Assert\Optional(self::getRules('file', ['.xml'])),
            'resultPerPage' => new Assert\Optional(self::getRules('resultPerPage')),
            'ordine' => new Assert\Optional(self::getRules('ordine'))
        ]);
        # WithValidationTrait
        $errors = self::valida($request->all, $constraints);

        if (count($errors)) {
            $temp = [
                'code' => self::HTTP_BAD_REQUEST,
                'response' => ["errors" => $errors],
                'filedoc' => $_FILES['filedoc'],
                'filexml' => $_FILES['filexml'],
                'errors' => $errors
            ];
            return response()->json($temp, $temp['code']);
        }

        try {
            $url="http://localhost:8000/"; //ip docker da ifconfig
            $urldoc=$url."api/upload";
            $urlxml=$url."api/uploadXml";
            $files = $_FILES;
            $filedoc=$files['filedoc'];
            $filexml=$files['filexml'];
            
            $response=self::mergeXmlDocument($filedoc['tmp_name'], $filexml['tmp_name']);
            //return response()->download($filedoc['tmp_name']);
            return response()->json($response, self::HTTP_OK); 
        } catch (Exception $e) {
            $temp = [
                'code' => $e->getCode(),
                'response' => $e->getMessage(),
                'filedoc' => $files['filedoc'],
                'filexml' => $files['filexml'],
                'errors' => ['code' => $e->getCode(), 'message' => "$url problem\n".$e->getMessage()]
            ];
            return response()->json($temp['errors'], status: self::HTTP_OK);
        }
    }
}
