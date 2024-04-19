<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`TypeOrderEnum`***
 *
 * This class represents the type that TypeOrder can have
 *
 * The default TypeOrder is set to `article`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the TypeOrder constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the TypeOrder.
 *     Returns an array with the available TypeOrder descriptions.
 * 
 * @method string resolveGender()
 *     Returns the appropriate title based on the `TypeOrder` enum instance.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum TypeOrderEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the TypeOrder "achat".
     *
     * @var string
     */
    case ACHAT = 'achat';

    /**
     * Represents the TypeOrder "vente".
     *
     * @var string
     */
    case VENTE = 'vente';

    /**
     * The default TypeOrder value.
     * 
     * @return string
     */
    public const DEFAULT          = self::ACHAT->value; //self::ACHAT;
    
    /**
     * The fallback TypeOrder value.
     * 
     * @return string
     */
    public const FALLBACK         = self::ACHAT->value; //self::ACHAT;

    /**
     * Get the labels for the Type.
     *
     * @return array The labels for the Type.
     */
    public static function labels(): array
    {
        return [
            self::VENTE->value         => 'vente',
            self::ACHAT->value         => 'achat',
        ];
    }

    /**
     * Get all the Statuts enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::VENTE->value          => 'Represents the "vente".',
            self::ACHAT->value          => 'Represents the "achat".'
        ];
        
    }

}