<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`TypeContratEnum`***
 *
 * This class represents the type that typecontrat can have
 *
 * The default typecontrat is set to `article`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the typecontrat constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the typecontrat.
 *     Returns an array with the available typecontrat descriptions.
 * 
 * @method string resolveGender()
 *     Returns the appropriate title based on the `typecontrat` enum instance.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum TypeContratEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the typecontrat "cdd".
     *
     * @var string
     */
    case CDD = 'cdd';

    /**
     * Represents the typecontrat "cdi".
     *
     * @var string
     */
    case CDI = 'cdi';

    /**
     * Represents the typecontrat "alternance".
     *
     * @var string
     */
    case ALTERNANCE = 'alternance';

    /**
     * Represents the typecontrat "resilier".
     *
     * @var string
     */
    case RESILIER = 'resilier';

    /**
     * Represents the typecontrat "ctt".
     *
     * @var string
     */
    case CTT = 'ctt';
     
    /**
     * The default typecontrat value.
     * 
     * @return string
     */
    public const DEFAULT          = self::CDD->value; //self::CDD;
    
    /**
     * The fallback typecontrat value.
     * 
     * @return string
     */
    public const FALLBACK         = self::CDD->value; //self::EN_SERVICE;

    /**
     * Get the labels for the typecontrat.
     *
     * @return array The labels for the typecontrat.
     */
    public static function labels(): array
    {
        return [
            self::CDD->value                => 'en_cours',
            self::CDI->value                => 'cdi',
            self::ALTERNANCE->value         => 'alternance',
            self::CTT->value                => 'ctt',

        ];
    }

    /**
     * Get all the typecontrat enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::CDD->value            => 'Represents the "cdi".',
            self::CDI->value            => 'Represents the "cdd".',
            self::ALTERNANCE->value     => 'Represents the "alternance".',
            self::CTT->value            => 'Represents the "ctt".',
        ];
        
    }

}