<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`AdjustementTypeEnum`***
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the adjustment type constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the adjustment type.
 *     Returns an array with the available adjustment type descriptions.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum AdjustementTypeEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the adjustment type "bonus".
     *
     * @var string
     */
    case BONUS = 'bonus';

    /**
     * Represents the adjustment type "heures_supplémentaires".
     *
     * @var string
     */
    case HEURES_SUPPLEMENTAIRES = 'heures_supplémentaires';

    /**
     * Represents the adjustment type "allocation".
     *
     * @var string
     */
    case ALLOCATION = 'allocation';
     
    /**
     * The default adjustment type value.
     * 
     * @return string
     */
    public const DEFAULT          = self::BONUS->value; //self::BONUS;
    
    /**
     * The fallback adjustment type value.
     * 
     * @return string
     */
    public const FALLBACK         = self::BONUS->value; //self::BONUS;

    /**
     * Get the labels for the adjustment type.
     *
     * @return array The labels for the adjustment type.
     */
    public static function labels(): array
    {
        return [
            self::BONUS->value                      => 'Bonus',
            self::HEURES_SUPPLEMENTAIRES->value     => 'Heures supplémentaires',
            self::ALLOCATION->value                 => 'Allocation'
        ];
    }

    /**
     * Get all the adjustment type enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::BONUS->value                      => 'Bonus',
            self::HEURES_SUPPLEMENTAIRES->value     => 'Heures supplémentaires',
            self::ALLOCATION->value                 => 'Allocation'
        ];
        
    }

}