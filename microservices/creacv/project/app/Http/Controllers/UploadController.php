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
class UploadController extends BaseController
{

    use WithRestUtilsTrait;

    public function upload(Request $request): JsonResponse
    {
        //$filename = $_POST['file'];
        $data=$request->all();
        try {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'];
            $uploadDir.='..\resources\uploads';
            foreach ($_FILES as $file) {
                if (UPLOAD_ERR_OK === $file['error']) {
                    $fileName = basename($file['name']);
                    move_uploaded_file($file['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $fileName);
                }
            }
            $ris = ['response' => $fileName, 'code' => 200];
        } catch (Exception $e) {
            $code = (int) $e->getCode();
            $ris = [
                'response' => $e->getMessage(),
                'code' => self::validateErrorCode($code)
            ];
        }
        return response()->json($ris, $ris['code']);
    }
}