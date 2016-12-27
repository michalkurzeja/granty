<?php
namespace AppBundle\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static ApplicationTransition SUBMIT
 * @method static ApplicationTransition ACCEPT
 * @method static ApplicationTransition REJECT
 */
class ApplicationTransition extends Enum
{
    public const SUBMIT  = 'submit';
    public const ACCEPT = 'accept';
    public const REJECT  = 'reject';
}
