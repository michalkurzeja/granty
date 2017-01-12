<?php
namespace AppBundle\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static ApplicationCategory DOCTORAL
 * @method static ApplicationCategory POSTDOCTORAL
 * @method static ApplicationCategory SPECIALTY
 */
class ApplicationCategory extends Enum
{
    public const DOCTORAL  = 'doctoral';
    public const POSTDOCTORAL = 'postdoctoral';
    public const SPECIALTY  = 'specialty';
}
