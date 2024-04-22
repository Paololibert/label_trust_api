<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`AdjustementCategoryEnum`***
 *
 * This class represents the type that adjustment category can have
 *
 * The default adjustment category is set to `augmentation`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the adjustment category constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the adjustment category.
 *     Returns an array with the available adjustment category descriptions.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum AdjustementCategoryEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the adjustment category "augmentation".
     *
     * @var string
     */
    case AUGMENTATION = 'augmentation';

    /**
     * Represents the adjustment category "fermer".
     *
     * @var string
     */
    case DIMINUTION = 'diminution';
     
    /**
     * The default adjustment category value.
     * 
     * @return string
     */
    public const DEFAULT          = self::AUGMENTATION->value; //self::AUGMENTATION;
    
    /**
     * The fallback adjustment category value.
     * 
     * @return string
     */
    public const FALLBACK         = self::AUGMENTATION->value; //self::AUGMENTATION;

    /**
     * Get the labels for the adjustment category.
     *
     * @return array The labels for the adjustment category.
     */
    public static function labels(): array
    {
        return [
            self::AUGMENTATION->value             => 'Augmentation',
            self::DIMINUTION->value               => 'Diminution'
        ];
    }

    /**
     * Get all the adjustment category enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::AUGMENTATION->value         => 'Augmentation',
            self::DIMINUTION->value           => 'Diminution.'
        ];
        
    }

}