<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`StatusOperationDisponibleEnum`***
 *
 * This class represents the type that status operation disponible can have
 *
 * The default status operation disponible is set to `article`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the status operation disponible constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the status operation disponible.
 *     Returns an array with the available status operation disponible descriptions.
 * 
 * @method string resolveGender()
 *     Returns the appropriate title based on the `status operation disponible` enum instance.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum StatusOperationDisponibleEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the status operation disponible "ouvert".
     *
     * @var string
     */
    case EN_ATTENTE = 'en_attente';

    /**
     * Represents the status operation disponible.
     *
     * @var string
     */
    case VALIDER = 'valider';

    /**
     * Represents the status operation disponible.
     *
     * @var string
     */
    case REJETER = 'rejeter';
     
    /**
     * The default status operation disponible value.
     * 
     * @return string
     */
    public const DEFAULT          = self::EN_ATTENTE->value; //self::EN_ATTENTE;
    
    /**
     * The fallback status operation disponible value.
     * 
     * @return string
     */
    public const FALLBACK         = self::EN_ATTENTE->value; //self::EN_SERVICE;

    /**
     * Get the labels for the status operation disponible.
     *
     * @return array The labels for the status operation disponible.
     */
    public static function labels(): array
    {
        return [
            self::EN_ATTENTE->value            => 'Operation disponible',
            self::VALIDER->value               => 'Operation valider',
            self::REJETER->value               => 'Operation rejeter'

        ];
    }

    /**
     * Get all the status operation disponible enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::EN_ATTENTE->value        => 'Operation comptable disponile en attente de validation.',
            self::VALIDER->value           => 'Operation comptable disponile valider.',
            self::REJETER->value           => 'Operation comptable disponile rejeter',
        ];
        
    }

}