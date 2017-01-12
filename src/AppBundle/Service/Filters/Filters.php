<?php
namespace AppBundle\Service\Filters;

use ArrayAccess;
use Symfony\Component\HttpFoundation\ParameterBag;

class Filters extends ParameterBag implements ArrayAccess
{
    /**
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        parent::__construct($this->sanitizeValues($filters));
    }

    /**
     * @param array $originalParameters
     * @return array
     */
    private function sanitizeValues(array $originalParameters): array
    {
        $parameters = [];

        foreach ($originalParameters as $key => $originalValue) {
            if (empty($originalValue)) {
                continue;
            }

            if (is_string($originalValue)) {
                $parameters[$key] = trim($originalValue);
            }
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }
}
