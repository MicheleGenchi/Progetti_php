<?php

namespace App\Http\Controllers;

use Carbon\Exceptions\InvalidFormatException;
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
use App\Models\Document;


class UploadController extends BaseController
{
    use WithRestUtilsTrait,
        ConstraintsTrait,
        DBUtilitiesTrait,
        WithValidationTrait;

    public function upload(Request $request): JsonResponse
    {
        $constraints = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'file' => new Assert\Optional(self::getRules('file', ['.doc', '.docx', '.dotx'])),
            'resultPerPage' => new Assert\Optional(self::getRules('resultPerPage')),
            'ordine' => new Assert\Optional(self::getRules('ordine'))
        ]);

        # WithValidationTrait
        $errors = self::valida($request->all, $constraints);

        if (count($errors)) {
            $temp = [
                'code' => self::HTTP_BAD_REQUEST,
                'response' => ["errors" => $errors],
                'file' => $_FILES['file'],
                'errors' => $errors
            ];
            return response()->json($temp, $temp['code']);
        }


        try {
            //$request->file->move(public_path('uploads'), $fileName);
            $doc = new Document();
            $response = $doc->read($_FILES['file']['tmp_name']);
            $doc->setProperties();
            $words=$doc->elabora($response['testo']);
            if ($response['code'] != 200)
                throw new InvalidFormatException();
            else {
                $temp = [
                    'code' => self::HTTP_OK,
                    'response' => 'File uploaded successfully!',
                    'file' => $_FILES['file'],
                    'testo' => $response['testo'],
                    'data' => Document::convertTextToArray($words)
                ];
                $fileName = public_path('uploads') . '/' . $_FILES['file']['name'];
                $temparray = explode(".", $fileName);
                $fileXmlSave = $temparray[0] . '.xml';//$_FILES['file']['name'];
                Document::scrivixml($temp['data'], $fileXmlSave);
                //move_uploaded_file($temp_file,$fileName);
                return response()->json($temp, $temp['code']);
            }
        } catch (Exception $e) {
            $temp = [
                'code' => 100,
                'response' => $e->getMessage(),
                'file' => $_FILES['file'],
                'errors' => ['code' => $e->getCode(), 'message' => $e->getMessage()]
            ];
            return response()->json($temp, $temp['code']);
        }
    }
}
