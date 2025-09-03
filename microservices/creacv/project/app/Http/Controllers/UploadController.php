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
use App\Utilities\Documents;


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
            'file' => new Assert\Optional(self::getRules('file')),
            'resultPerPage' => new Assert\Optional(self::getRules('resultPerPage')),
            'ordine' => new Assert\Optional(self::getRules('ordine'))
        ]);

        # WithValidationTrait
        $errors = self::valida($request->all, $constraints);

        if (count($errors)) {
            $temp = [
                'code' => self::HTTP_BAD_REQUEST,
                'response' => ["errors" => $errors],
                'file' =>$_FILES['file']
            ];
            return response()->json($temp, $temp['code']);
        }


        try {
            
            //$request->file->move(public_path('uploads'), $fileName);
            $temp_file = $_FILES['file']['tmp_name'];
            rename($temp_file ,$temp_file.'.docx');
            $temp_file.='.docx';
            $doc=new Documents($temp_file);
            $testo= $doc->read();
            $doc->setProperties();
            
            
            $temp = [
                'code' => self::HTTP_OK,
                'response' => 'File uploaded successfully!',
                'file' =>$_FILES['file'],
                'testo' => Documents::convertTextToArray($testo)
            ];
            $ris=response()->json($temp, $temp['code']);
            $fileName = public_path('uploads').'/'.$_FILES['file']['name'];
            $filexmlSave=public_path('uploads').'/'.'test.xml';//$_FILES['file']['name'];
            Documents::scrivixml($temp['testo'],$filexmlSave);
            //move_uploaded_file($temp_file,$fileName);
        } catch (Exception $e) {
            $temp = [
                'code' => 100,
                'response' => $e->getMessage(),
                'file' =>$_FILES['file']
            ];
            $ris=response()->json($temp, $temp['code']);
        }
        return $ris;
    }
}
