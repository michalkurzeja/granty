<?php
namespace AppBundle\Form\Transformer;

use AppBundle\Entity\ApplicationResponse\Acceptance;
use Symfony\Component\Form\DataTransformerInterface;

class ApplicationAcceptanceDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value): Acceptance
    {
        return new Acceptance();
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value): Acceptance
    {
        return $value;
    }
}
