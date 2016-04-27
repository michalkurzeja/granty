<?php

namespace AppBundle\Voter\Actions;

use MyCLabs\Enum\Enum;

class VoterActions extends Enum
{
    const VIEW = 'view';
    const CREATE = 'create';
    const EDIT = 'edit';
    const REMOVE = 'remove';
}