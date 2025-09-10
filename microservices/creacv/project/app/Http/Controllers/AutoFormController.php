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

    public function compilaDocumento(Request $request): JsonResponse
    {
        $constraints = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'file_template' => new Assert\Optional(self::getRules('file', ['.doc', '.docx', 'dotx'])),
            'file_xml' => new Assert\Optional(self::getRules('file', ['.xml'])),
            'resultPerPage' => new Assert\Optional(self::getRules('resultPerPage')),
            'ordine' => new Assert\Optional(self::getRules('ordine'))
        ]);
        # WithValidationTrait
        $errors = self::valida($request->all, $constraints);

        if (count($errors)) {
            $temp = [
                'code' => self::HTTP_BAD_REQUEST,
                'response' => ["errors" => $errors],
                'fileTemplate' => $_FILES['file_template'],
                'fileXml' => $_FILES['file_xml'],
                'errors' => $errors
            ];
            return response()->json($temp, $temp['code']);
        }

        try {
            //$request->file->move(public_path('uploads'), $fileName);
            $doc = new XmlDocument();
            $xml = $doc->readXml($_FILES['file']['tmp_name']);
            $temp = [
                'code' => self::HTTP_OK,
                'fileTemplate' => $request['file_template'],
                'fileXml' => $request['file_xml']
            ];

            

            $doc = new XmlDocument();
            $response = $doc->compilaDocumento($request->all);
            array_push($temp, ['response' => $response]);
            return response()->json($temp, $temp['code']);
        } catch (Exception $e) {
            $temp = [
                'code' => $e->getCode(),
                'response' => $e->getMessage(),
                'fileTemplate' => $_FILES['file_template'],
                'fileXml' => $_FILES['file_xml'],
                'errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]
            ];
            return response()->json($temp, $temp['code']);
        }
    }
}
