<?php
namespace AppBundle\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static ApplicationTransition SUBMIT
 * @method static ApplicationTransition ACCEPT
 * @method static ApplicationTransition REJECT
 * @method static ApplicationTransition APPEAL
 */
class ApplicationTransition extends Enum
{
    public const SUBMIT  = 'submit';
    public const ACCEPT = 'accept';
    public const REJECT  = 'reject';
    public const APPEAL  = 'appeal';
}
