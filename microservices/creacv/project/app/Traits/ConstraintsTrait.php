<?php

namespace App\Traits;

use Exception;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Type;
/**
 * Summary of ConstraintsTrait
 */
trait ConstraintsTrait
{
    use DBUtilitiesTrait;

    /**
     * Summary of getRules
     * @param string $column
     *   $column => un campo della tabella geo_nazione o geo del database mondial
     * @return array
     *  restituisce un array di assert per il campo richiesco $column
     */
    public static function getRules(string $column): array
    {
        $matched= match ($column) {
            'file' => [new Assert\NotBlank(), new Assert\File(extensions: ['doc', 'docx','dotx'], extensionsMessage:'Il tipo di file deve essere doc, dot, docx')],
            'resultPerPage' => [new Type('int'), 
                                new GreaterThanOrEqual(1),
                                new LessThanOrEqual(self::LIMITE_RISULTATI_PAGINA)],
            'ordine' => [ new Assert\All(new Assert\Choice(['ASC', 'DESC']))
            ],
            # cerchi di validare un campo che in realtà non ha una validazione
            default => throw new Exception("Campo $column inesistente!", 500)
        };
        
        return $matched;
    }

}
