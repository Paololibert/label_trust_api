<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`StatusExerciceEnum`***
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
enum StatusExerciceEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the typecontrat "ouvert".
     *
     * @var string
     */
    case OPEN = 'ouvert';

    /**
     * Represents the typecontrat "fermer".
     *
     * @var string
     */
    case CLOSE = 'fermer';
     
    /**
     * The default typecontrat value.
     * 
     * @return string
     */
    public const DEFAULT          = self::OPEN->value; //self::OPEN;
    
    /**
     * The fallback typecontrat value.
     * 
     * @return string
     */
    public const FALLBACK         = self::OPEN->value; //self::EN_SERVICE;

    /**
     * Get the labels for the typecontrat.
     *
     * @return array The labels for the typecontrat.
     */
    public static function labels(): array
    {
        return [
            self::OPEN->value                => 'Exercice en cours',
            self::CLOSE->value               => 'Exercice cloturer'

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
            self::OPEN->value            => 'Exercice est toujours ouvert et en cours',
            self::CLOSE->value           => 'Exercice est cloturer donc fermer.'
        ];
        
    }

}