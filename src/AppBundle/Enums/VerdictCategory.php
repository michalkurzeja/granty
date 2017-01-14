<?php
declare(strict_types = 1);
namespace AppBundle\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static VerdictCategory A
 * @method static VerdictCategory B
 * @method static VerdictCategory C
 */
class VerdictCategory extends Enum
{
    public const A = 'A';
    public const B = 'B';
    public const C = 'C';
}
