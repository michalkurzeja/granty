<?php
namespace AppBundle\Form\Transformer;

use AppBundle\Entity\Appeal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;

class ApplicationAppealDataTransformer implements DataTransformerInterface
{
    /** @var Collection */
    private $originalData;

    /**
     * {@inheritdoc}
     */
    public function transform($value): Appeal
    {
        $this->originalData = $value;

        return new Appeal();
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
