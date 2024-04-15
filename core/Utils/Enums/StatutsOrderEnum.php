<?php

declare(strict_types=1);

namespace Core\Utils\Enums;

use Core\Utils\Enums\Contract\EnumContract;
use Core\Utils\Traits\IsEnum;

/**
 * Class ***`StatutsOrderEnum`***
 *
 * This class represents the type that Statuts can have
 *
 * The default Statuts is set to `article`.
 *
 * @method static array labels()
 *     Get the labels for the type.
 *     Returns an array with the labels for the type, where the keys are the Statuts constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the Statuts.
 *     Returns an array with the available Statuts descriptions.
 * 
 * @method string resolveGender()
 *     Returns the appropriate title based on the `Statuts` enum instance.
 * 
 * @package ***`\Core\Utils\Enums\Users`***
 */
enum StatutsOrderEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the Statuts "livrer".
     *
     * @var string
     */
    case LIVRER = 'livrer';

    /**
     * Represents the Statuts "en_retard".
     *
     * @var string
     */
    case EN_RETARD = 'en_retard';

    /**
     * Represents the Statuts "en_cours".
     *
     * @var string
     */
    case EN_COURS = 'en_cours';

    /**
     * The default Statuts value.
     * 
     * @return string
     */
    public const DEFAULT          = self::EN_COURS->value; //self::EN_COURS;
    
    /**
     * The fallback Statuts value.
     * 
     * @return string
     */
    public const FALLBACK         = self::EN_COURS->value; //self::EN_COURS;

    /**
     * Get the labels for the Statuts.
     *
     * @return array The labels for the Statuts.
     */
    public static function labels(): array
    {
        return [
            self::EN_RETARD->value          => 'en_retard',
            self::LIVRER->value             => 'livrer',
            self::EN_COURS->value           => 'en_cours'
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
            self::EN_RETARD->value      => 'Represents the "en_retard".',
            self::LIVRER->value         => 'Represents the "livrer".',
            self::EN_COURS->value       => 'Represents the "en_cours".'
        ];
        
    }

}