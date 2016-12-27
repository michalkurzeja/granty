<?php

namespace AppBundle\Voter\Actions;

use MyCLabs\Enum\Enum;

class VoterActions extends Enum
{
    public const VIEW = 'view';
    public const CREATE = 'create';
    public const EDIT = 'edit';
    public const REMOVE = 'remove';
}
