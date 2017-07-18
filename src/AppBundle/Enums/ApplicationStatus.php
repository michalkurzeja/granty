<?php

namespace AppBundle\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static ApplicationStatus DRAFT
 * @method static ApplicationStatus SUBMITTED
 * @method static ApplicationStatus ACCEPTED
 * @method static ApplicationStatus REJECTED
 * @method static ApplicationStatus APPEALED
 */
class ApplicationStatus extends Enum
{
    public const DRAFT     = 'draft';
    public const SUBMITTED = 'submitted';
    public const ACCEPTED  = 'accepted';
    public const REJECTED  = 'rejected';
    public const APPEALED  = 'appealed';
}
