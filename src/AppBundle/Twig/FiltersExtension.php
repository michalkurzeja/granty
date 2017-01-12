<?php
namespace AppBundle\Twig;

use AppBundle\Service\Filters\Filters;
use AppBundle\Service\Filters\FiltersFormCreator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

class FiltersExtension extends Twig_Extension
{
    /** @var FiltersFormCreator */
    private $filtersFormCreator;

    /**
     * @param FiltersFormCreator $filtersFormCreator
     */
    public function __construct(FiltersFormCreator $filtersFormCreator)
    {
        $this->filtersFormCreator = $filtersFormCreator;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('filters_form', [$this, 'filtersForm'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function filtersForm(Twig_Environment $env, string $formTypeName): string
    {
        $form = $this->filtersFormCreator->create($formTypeName);

        return $env->render('layout/elements/filters.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
