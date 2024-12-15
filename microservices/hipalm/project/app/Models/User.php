<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ConstraintsTrait;
use App\Traits\DBUtilitiesTrait;
use App\Traits\WithRestUtilsTrait;
use App\Traits\WithValidationTrait;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\QueryException;
use Symfony\Component\Validator\Constraints as Assert;
class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, 
    WithRestUtilsTrait, 
    ConstraintsTrait, 
    DBUtilitiesTrait, 
    WithValidationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'userid',
        'nome',
        'cognome',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function get(array $filters): array
    {
        include_once 'HttpCodeResponse.php';

        # converte il campo ordine in maiuscolo "asc"="ASC", "desc"="DESC"
        # self::initFieldsUpperCase($filters, $fieldUpper=['ordine']);

        # validi o trasformi
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            /*
            'country_code' => new Assert\Optional(new Assert\All(self::getRules('country_code'))),
            'country' => new Assert\Optional(new Assert\All(self::getRules('country'))),
            'resultPerPage' => new Assert\Optional(self::getRules('resultPerPage')),
            'ordine' => new Assert\Optional(self::getRules('ordine'))
            */
        ]);

        # WithValidationTrait
        /*$errors = self::valida($filters, $constraint);

        if (count($errors)) {
            return [
                'code' => self::HTTP_BAD_REQUEST,
                'response' => ["errors" => $errors]
            ];
        }
        */

        try 
        {
            $query=self::select('*');
            # filtra i dati
            $query = (isset($filters["country_code"])) ? 
                        $query->whereIn("{$this->table}.country_code", $filters["country_code"]) : $query;
            $query = (isset($filters["country"])) ? 
                        $query->whereIn("{$this->table}.country", $filters["country"]) : $query;

            # ordina
            $query = isset($filters['ordine']) ? self::ordina($query, $filters['ordine']) : $query;

            # DBUTilitities::paginate 
            # se $resultPerPage>LIMITE_RISULTATI_PAGINA prende il limite
            $rows=$query->paginate(self::paginate($filters["resultPerPage"]));
    
            return [
                'code' => self::HTTP_OK,
                'response' => ['data' => $rows]
            ];
        } catch (QueryException | Exception $e)  {
          rollback();
          return [
                "code" => self::HTTP_INTERNAL_SERVER_ERROR,
                "response" => ["message" => ERRORE_DATABASE]
            ];  
        }
    }
}
