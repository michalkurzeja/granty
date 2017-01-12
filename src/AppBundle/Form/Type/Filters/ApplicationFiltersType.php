<?php
namespace AppBundle\Form\Type\Filters;

use AppBundle\Enums\ApplicationStatus;
use AppBundle\Form\Type\Filters\Base\FiltersType;
use AppBundle\Form\Type\Simple\EnumType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ApplicationFiltersType extends FiltersType
{
    /** @var TranslatorInterface */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function addChildren(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, [
                'label' => '#',
                'required' => false,
            ])
            ->add('topic', TextType::class, [
                'label' => 'application.topic',
                'required' => false,
            ])
            ->add('status', EnumType::class, [
                'label' => 'application.status',
                'required' => false,
                'enum' => ApplicationStatus::class,
            ])
        ;
    }
}
