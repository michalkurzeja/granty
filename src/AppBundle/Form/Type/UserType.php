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
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            $builder->create('roles', CheckboxType::class, [
                'required' => false,
                'label' => 'Is reviewer?'
            ])
            ->addModelTransformer(new RolesToReviewerBoolTransformer)
        );

        if (!$this->isPasswordRequired($options)) {
            $builder->remove('current_password');
        }
    }

    /**
     * @param array $options
     * @return bool
     */
    private function isPasswordRequired(array $options)
    {
        return $options['require_password'];
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('require_password', true)
            //->setDefault('action', 'user_edit')
            ->setAllowedTypes('require_password', 'bool');
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return ProfileType::class;
    }
}