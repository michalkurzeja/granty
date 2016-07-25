<?php

namespace AppBundle\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static ApplicationStatus CREATED
 * @method static ApplicationStatus SUBMITTED
 * @method static ApplicationStatus ACCEPTED
 * @method static ApplicationStatus REJECTED
 * @method static ApplicationStatus APPEALED
 */
class ApplicationStatus extends Enum
{
    const CREATED   = 'created';
    const SUBMITTED = 'submitted';
    const ACCEPTED  = 'accepted';
    const REJECTED  = 'rejected';
    const APPEALED  = 'appealed';

    /**
     * @return string[]
     */
    static public function reviewableStatuses()
    {
        return [
            static::SUBMITTED,
            static::APPEALED,
        ];
    }
}