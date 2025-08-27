<?php

namespace App\Models;

use App\Traits\ConstraintsTrait;
use App\Traits\DBUtilitiesTrait;
use App\Traits\WithRestUtilsTrait;
use App\Traits\WithValidationTrait;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;
use Illuminate\Support\Facades\DB;


/**
 * @property string $database
 * @property string $username
 * @property string $password
 */
class Connessione extends Model
{
 use HasFactory, 
        WithRestUtilsTrait, 
        ConstraintsTrait, 
        DBUtilitiesTrait, 
        WithValidationTrait;
        
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'database',
        'username',
        'password'
    ];

    public function test(array $filters): array
    {
        include_once 'HttpCodeResponse.php';

        if (isset($filter)) {
            # valida i campi
            $constraints = new Assert\Collection([
                // the keys correspond to the keys in the input array
            ]);

            # WithValidationTrait
            $errors = self::valida($filters, $constraints);
            if (count($errors)) {
                return [
                    'code' => self::HTTP_BAD_REQUEST,
                    'response' => ["errors" => $errors]
                ];
            }
        }

        # testa connessione 
        try {
            $dbconnect = DB::connection()->getPDO();
            $dbname = DB::connection()->getDatabaseName() ?? null;
            return [
                'code' => self::HTTP_OK,
                'response' => (isset($dbname))?"Connesso a ".$dbname:"Non connesso a ".$dbname
            ];
        } catch(Exception $e) {
            echo "Errore di connessione al database";
            return [
                'code' => self::HTTP_INTERNAL_SERVER_ERROR,
                'response' => "Errore di connessione al database"
            ];
        }
    }
}