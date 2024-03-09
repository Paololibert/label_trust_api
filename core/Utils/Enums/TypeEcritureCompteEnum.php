<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`TypeEcritureCompteEnum`***
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
enum TypeEcritureCompteEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the type_de_compte "debit".
     *
     * @var string
     */
    case DEBIT = 'debit';

    /**
     * Represents the type_de_compte "debit".
     *
     * @var string
     */
    case CREDIT = 'credit';
     
    /**
     * The default type_de_compte value.
     * 
     * @return string
     */
    public const DEFAULT          = self::DEBIT->value; //self::DEBIT;
    
    /**
     * The fallback type_de_compte value.
     * 
     * @return string
     */
    public const FALLBACK         = self::DEBIT->value; //self::DEBIT;

    /**
     * Get the labels for the type_de_compte.
     *
     * @return array The labels for the type_de_compte.
     */
    public static function labels(): array
    {
        return [
            self::DEBIT->value          => 'Ecriture en debit',
            self::CREDIT->value         => 'Ecriture en credit',

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
            self::DEBIT->value          => 'Ecriture en debit sur un compte.',
            self::CREDIT->value         => 'Ecriture en credit sur un compte.'
        ];
        
    }

}