<?php
namespace AppBundle\Service\Filters;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class FiltersParamConverter implements ParamConverterInterface
{
    /**
     * @param Request        $request
     * @param ParamConverter $configuration
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $filters = $this->createFilters($request);

        $request->attributes->set($configuration->getName(), $filters);

        return true;
    }

    private function createFilters(Request $request): Filters
    {
        return new Filters($request->query->get('filters', []));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Filters::class;
    }
}
