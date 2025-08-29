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


class UploadController extends BaseController
{
    use WithRestUtilsTrait,
        ConstraintsTrait,
        DBUtilitiesTrait,
        WithValidationTrait;

    public function upload(Request $request): mixed
    {
        $constraints = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'file' => new Assert\Optional(self::getRules('file')),
            'resultPerPage' => new Assert\Optional(self::getRules('resultPerPage')),
            'ordine' => new Assert\Optional(self::getRules('ordine'))
        ]);

        # WithValidationTrait
        $errors = self::valida($request['file'], $constraints);

        if (count($errors)) {
            $temp = [
                'code' => self::HTTP_BAD_REQUEST,
                'response' => ["errors" => $errors]
            ];
            return response()->json($temp, $temp['code']);
        }


        try {
            $fileName = time() . '.' . $request->file;
            $request->file->move(public_path('uploads'), $fileName);
            $ris = back()->with('success', 'File uploaded successfully!')
                ->with('file', $fileName);
        } catch (Exception $e) {
            $temp = [
                'code' => self::HTTP_BAD_REQUEST,
                'response' => ["errors" => $errors]
            ];
            $ris=response()->json($temp, $temp['code']);
        }

        return $ris;
    }
}
