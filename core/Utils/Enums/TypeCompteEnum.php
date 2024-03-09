<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`TypeCompteEnum`***
 *
 * This class represents the type that type_de_compte can have
 *
 * The default type_de_compte is set to `generale`.
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
enum TypeCompteEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the type_de_compte "generale".
     *
     * @var string
     */
    case GENERALE = 'generale';

    /**
     * Represents the type_de_compte "generale".
     *
     * @var string
     */
    case ANALYTIQUE = 'analytique';
     
    /**
     * The default type_de_compte value.
     * 
     * @return string
     */
    public const DEFAULT          = self::GENERALE->value; //self::GENERALE;
    
    /**
     * The fallback type_de_compte value.
     * 
     * @return string
     */
    public const FALLBACK         = self::GENERALE->value; //self::GENERALE;

    /**
     * Get the labels for the type_de_compte.
     *
     * @return array The labels for the type_de_compte.
     */
    public static function labels(): array
    {
        return [
            self::GENERALE->value           => 'Generale',
            self::ANALYTIQUE->value         => 'Analytique',

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
            self::GENERALE->value           => 'Compte de la comptabilite generale.',
            self::ANALYTIQUE->value         => 'Compte de la comptabilite analytique.'
        ];
        
    }

}