<?php
namespace AppBundle\Service\Filters;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FiltersFormCreator
{
    /** @var FormFactoryInterface */
    private $formFactory;
    /** @var RequestStack */
    private $requestStack;
    /** @var ParamConverterManager */
    private $paramConverterManager;

    /**
     * @param FormFactoryInterface  $formFactory
     * @param RequestStack          $requestStack
     * @param ParamConverterManager $paramConverterManager
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RequestStack $requestStack,
        ParamConverterManager $paramConverterManager
    ) {
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
        $this->paramConverterManager = $paramConverterManager;
    }

    /**
     * @param string $formTypeName
     * @return FormInterface
     */
    public function create(string $formTypeName): FormInterface
    {
        return $this->formFactory->create($formTypeName, $this->getFilters());
    }

    /**
     * @return Filters
     */
    private function getFilters(): Filters
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request instanceof Request) {
            return $this->getRequestFilters($request);
        }

        return new Filters();
    }

    /**
     * @param Request $request
     * @return Filters
     */
    private function getRequestFilters(Request $request): Filters
    {
        $filters = $request->attributes->get('filters');

        if (!$filters instanceof Filters) {
            $this->convertFilters($request);
            $filters = $request->attributes->get('filters');
        }

        return $filters;
    }

    /**
     * @param Request $request
     */
    private function convertFilters(Request $request): void
    {
        $this->paramConverterManager->apply(
            $request,
            new ParamConverter([
                'name' => 'filters',
                'class' => Filters::class
            ])
        );
    }
}
