<?php
namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait TraceableTrait
{
    use BlameableTrait, TimestampableTrait;
}
