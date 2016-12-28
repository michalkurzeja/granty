<?php
namespace AppBundle\Service\Filters;

use Symfony\Component\HttpFoundation\ParameterBag;

class Filters extends ParameterBag
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        parent::__construct($this->sanitizeValues($parameters));
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

}
