<?php
namespace AppBundle\Twig;

use AppBundle\Service\Filters\Filters;
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
    /** @var TranslatorInterface */
    private $translator;
    /** @var RequestStack */
    private $requestStack;
    /** @var ParamConverterManager */
    private $paramConverterManager;

    /**
     * @param TranslatorInterface   $translator
     * @param RequestStack          $requestStack
     * @param ParamConverterManager $paramConverterManager
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack,
        ParamConverterManager $paramConverterManager
    ) {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
        $this->paramConverterManager = $paramConverterManager;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('filter_text', [$this, 'text'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new Twig_SimpleFunction('filter_select', [$this, 'select'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
            new Twig_SimpleFunction('translate_options', [$this, 'translateOptions']),
            new Twig_SimpleFunction('get_filter_value', [$this, 'getFilterValue']),
        ];
    }

    /**
     * @param Twig_Environment $env
     * @param string           $label
     * @param string           $name
     * @return string
     */
    public function text(Twig_Environment $env, string $label, string $name): string
    {
        return $env->render('layout/elements/filters/text.html.twig', [
            'label' => $label,
            'name' => $name,
        ]);
    }

    /**
     * @param Twig_Environment $env
     * @param array            $options
     * @param string           $label
     * @param string           $name
     * @return string
     */
    public function select(Twig_Environment $env, array $options, string $label, string $name): string
    {
        return $env->render('layout/elements/filters/select.html.twig', [
            'options' => $options,
            'label' => $label,
            'name' => $name,
        ]);
    }

    /**
     * @param array       $values
     * @param string      $idPrefix
     * @param null|string $translationDomain
     * @return array
     */
    public function translateOptions(array $values, string $idPrefix, ?string $translationDomain): array
    {
        $options = [];

        foreach ($values as $value) {
            $options[(string) $value] = $this->translator->trans(sprintf('%s.%s', $idPrefix, $value), [], $translationDomain);
        }

        return $options;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getFilterValue(string $name): ?string
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request instanceof Request) {
            return $this->getRequestFilters($request)->get($name);
        }

        return null;
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
