<?php
declare(strict_types = 1);
namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class EnumToChoicesTransformer implements DataTransformerInterface
{
    /** @var string */
    private $enumClass;

    /**
     * @param string $enumClass
     */
    public function __construct(string $enumClass)
    {
        $this->enumClass = $enumClass;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return (string) $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        return new $this->enumClass($value);
    }
}
