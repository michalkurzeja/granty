<?php
namespace AppBundle\Form\Transformer;

use AppBundle\Entity\RejectionCause;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;

class ApplicationRejectionDataTransformer implements DataTransformerInterface
{
    /** @var Collection */
    private $originalData;

    /**
     * {@inheritdoc}
     */
    public function transform($value): RejectionCause
    {
        $this->originalData = $value;

        return new RejectionCause();
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value): Collection
    {
        $transformedValue = new ArrayCollection($this->originalData->toArray());
        $transformedValue->add($value);

        return $transformedValue;
    }
}
