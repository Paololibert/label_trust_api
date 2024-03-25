<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`TypePartnerEnum`***
 *
 * This class represents the type that typePartner can have
 *
 * The default typePartner is set to `commercial_partner`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the typePartner constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the typePartner.
 *     Returns an array with the available typePartner descriptions.
 * 
 * @method string resolveGender()
 *     Returns the appropriate title based on the `typePartner` enum instance.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum TypePartnerEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the typePartner "client".
     *
     * @var string
     */
    case CLIENT = 'client';

    /**
     * Represents the typePartner "supplier".
     *
     * @var string
     */
    case SUPPLIER = 'supplier';


    /**
     * The default typePartner value.
     * 
     * @return string
     */
    public const DEFAULT          = self::CLIENT->value; //self::CLIENT;
    
    /**
     * The fallback typePartner value.
     * 
     * @return string
     */
    public const FALLBACK         = self::CLIENT->value; //self::CLIENT;

    /**
     * Get the labels for the typePartner.
     *
     * @return array The labels for the typePartner.
     */
    public static function labels(): array
    {
        return [
            self::CLIENT->value                 => 'regulier',
            self::SUPPLIER->value               => 'non_regulier',
        ];
    }

    /**
     * Get all the typePartner enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::CLIENT->value     => 'Represents the "regulier".',
            self::SUPPLIER->value   => 'Represents the "non_regulier".',
        ];
        
    }

}