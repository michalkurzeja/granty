<?php
namespace AppBundle\Form\Type\Filters\Base;

use AppBundle\Service\Filters\Filters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class FiltersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected abstract function addChildren(FormBuilderInterface $builder, array $options): void;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addChildren($builder, $options);

        /** @var FormBuilderInterface $child */
        foreach ($builder->all() as $name => $child) {
            $child->setPropertyPath("[$name]");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filters::class,
            'property_path' => 'filters',
            'label' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'filters';
    }
}
