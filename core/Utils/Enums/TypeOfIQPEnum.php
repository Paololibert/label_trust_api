<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`TypeOfIQPEnum`***
 *
 * This class represents the type that typeiqp can have
 *
 * The default typeiqp is set to `article`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the typeiqp constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the typeiqp.
 *     Returns an array with the available typeiqp descriptions.
 * 
 * @method string resolveGender()
 *     Returns the appropriate title based on the `typeiqp` enum instance.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum TypeOfIQPEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the typeiqp "performance".
     *
     * @var string
     */
    case PERFORMANCE = 'performance';

    /**
     * Represents the typeiqp "qualite".
     *
     * @var string
     */
    case QUALITE = 'qualite';

    /**
     * The default typeiqp value.
     * 
     * @return string
     */
    public const DEFAULT          = self::PERFORMANCE->value; //self::PERFORMANCE;
    
    /**
     * The fallback typeiqp value.
     * 
     * @return string
     */
    public const FALLBACK         = self::PERFORMANCE->value; //self::PERFORMANCE;

    /**
     * Get the labels for the typeiqp.
     *
     * @return array The labels for the typeiqp.
     */
    public static function labels(): array
    {
        return [
            self::QUALITE->value     => 'qualite',
            self::PERFORMANCE->value   => 'performance',
        ];
    }

    /**
     * Get all the typeiqp enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::QUALITE->value     => 'Represents the "qualite".',
            self::PERFORMANCE->value   => 'Represents the "performance".',
        ];
        
    }

}