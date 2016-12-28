<?php
namespace AppBundle\Form\Type;

use AppBundle\Form\Transformer\RolesToReviewerBoolTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            $builder
                ->create('roles', CheckboxType::class, [
                    'required' => false,
                    'label' => 'user.reviewer'
                ])
                ->addModelTransformer(new RolesToReviewerBoolTransformer())
        );

        if (!$this->isPasswordRequired($options)) {
            $builder->remove('current_password');
        }
    }

    /**
     * @param array $options
     * @return bool
     */
    private function isPasswordRequired(array $options): bool
    {
        return $options['require_password'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('require_password', true)
            ->setAllowedTypes('require_password', 'bool');
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return ProfileType::class;
    }
}
