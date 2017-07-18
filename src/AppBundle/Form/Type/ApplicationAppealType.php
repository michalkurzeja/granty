<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Application;
use AppBundle\Form\Transformer\ApplicationAppealDataTransformer;
use AppBundle\Service\AssociationSetter\Implementation\ApplicationAppealsSetter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationAppealType extends AbstractType implements EventSubscriberInterface
{
    /** @var ApplicationAppealsSetter */
    private $applicationAppealsSetter;

    /**
     * @param ApplicationAppealsSetter $applicationAppealsSetter
     */
    public function __construct(ApplicationAppealsSetter $applicationAppealsSetter)
    {
        $this->applicationAppealsSetter = $applicationAppealsSetter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            $builder
                ->create('appeals', AppealType::class, [
                    'label' => false
                ])
                ->addModelTransformer(new ApplicationAppealDataTransformer())
        );

        $builder->addEventSubscriber($this);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
            'attr' => [
                'data-confirm' => ''
            ]
        ]);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event): void
    {
        /** @var Application $application */
        $application = $event->getData();
        $newAppeal = $application->getAppeals()->last();

        $this->applicationAppealsSetter->set($application, $newAppeal);
    }
}
