<?php
declare(strict_types = 1);
namespace AppBundle\Form\Type\Simple;

use AppBundle\Form\Transformer\EnumToChoicesTransformer;
use AppBundle\Service\EnumChoices\EnumChoicesBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnumType extends AbstractType
{
    /** @var EnumChoicesBuilder */
    private $enumChoicesBuilder;

    /**
     * @param EnumChoicesBuilder $enumChoicesBuilder
     */
    public function __construct(EnumChoicesBuilder $enumChoicesBuilder)
    {
        $this->enumChoicesBuilder = $enumChoicesBuilder;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new EnumToChoicesTransformer($options['enum']));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $choices = function(Options $options) {
            return $this->enumChoicesBuilder->buildChoices($options['enum']);
        };

        $resolver
            ->setRequired('enum')
            ->setDefault('choices', $choices)
            ->setDefault('placeholder', '---')
            ->setAllowedTypes('enum', 'string')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
