<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`TypeSoldeCompteEnum`***
 *
 * This class represents the type that type_de_compte can have
 *
 * The default type_de_compte is set to `debit`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the type_de_compte constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the type_de_compte.
 *     Returns an array with the available type_de_compte descriptions.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum TypeSoldeCompteEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the type_de_compte "debiteur".
     *
     * @var string
     */
    case DEBITEUR = 'debiteur';

    /**
     * Represents the type_de_compte "crediteur".
     *
     * @var string
     */
    case CREDITEUR = 'crediteur';
     
    /**
     * The default type_de_compte value.
     * 
     * @return string
     */
    public const DEFAULT          = self::DEBITEUR->value; //self::DEBITEUR;
    
    /**
     * The fallback type_de_compte value.
     * 
     * @return string
     */
    public const FALLBACK         = self::DEBITEUR->value; //self::DEBITEUR;

    /**
     * Get the labels for the type_de_compte.
     *
     * @return array The labels for the type_de_compte.
     */
    public static function labels(): array
    {
        return [
            self::DEBITEUR->value          => 'Solde debiteur',
            self::CREDITEUR->value         => 'Solde crediteur',

        ];
    }

    /**
     * Get all the type_de_compte enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::DEBITEUR->value          => "Solde debiteur d'un compte.",
            self::CREDITEUR->value         => "Solde crediteur d'un compte."
        ];
        
    }

}