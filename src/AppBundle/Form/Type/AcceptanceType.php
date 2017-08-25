<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\ApplicationResponse\Acceptance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcceptanceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'granted',
                MoneyType::class,
                [
                    'label'              => 'acceptance_type.granted',
                    'translation_domain' => 'forms',
                    'currency'           => 'PLN',
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label'              => 'acceptance_type.message',
                    'translation_domain' => 'forms',
                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', Acceptance::class);
    }
}
