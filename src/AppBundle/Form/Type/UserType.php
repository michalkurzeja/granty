<?php
namespace AppBundle\Form\Type;

use AppBundle\Form\Transformer\RolesToReviewerBoolTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            $builder->create('roles', CheckboxType::class, [
                'required' => false,
                'label' => 'Is reviewer?'
            ])
            ->addModelTransformer(new RolesToReviewerBoolTransformer)
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return ProfileType::class;
    }
}