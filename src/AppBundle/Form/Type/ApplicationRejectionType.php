<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Application;
use AppBundle\Form\Transformer\ApplicationRejectionDataTransformer;
use AppBundle\Service\AssociationSetter\Implementation\ApplicationResponsesSetter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationRejectionType extends AbstractType implements EventSubscriberInterface
{
    /** @var ApplicationResponsesSetter */
    private $applicationResponsesSetter;

    /**
     * @param ApplicationResponsesSetter $applicationResponsesSetter
     */
    public function __construct(ApplicationResponsesSetter $applicationResponsesSetter)
    {
        $this->applicationResponsesSetter = $applicationResponsesSetter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            $builder
                ->create('responses', RejectionCauseType::class, [
                    'label' => false
                ])
                ->addModelTransformer(new ApplicationRejectionDataTransformer())
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
        $newRejectionCause = $application->getResponses()->last();

        $this->applicationResponsesSetter->set($application, $newRejectionCause);
    }
}
