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
use App\Models\Documents;
use App\Models\XmlDocument;


class AutoFormController extends BaseController
{
    use WithRestUtilsTrait,
        ConstraintsTrait,
        DBUtilitiesTrait,
        WithValidationTrait;

    public function compilaDocumento(Request $request): JsonResponse|RedirectResponse
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
            $url="http://172.17.0.1:8000/"; //ip docker da ifconfig
            $urldoc=$url."api/upload";
            $urlxml=$url."api/uploadXml";
            $files = $_FILES;
            //request UploadController upload
            $responseDoc=self::callHttp("post",$urldoc, ['form_params' => $files['filedoc']]);
            //request XmlController uploadXml
            $responseXml=self::callHttp("post",$urlxml, ['form_params' => $files['filexml']]);

            // TODO : codice che sostituisce tutte le che iniziano con "$_" prendendo "dall'xml"

            return response()->json(["document" => $responseDoc, "xml" => $responseXml], self::HTTP_OK); 
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
