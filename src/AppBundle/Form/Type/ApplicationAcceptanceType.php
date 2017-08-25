<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Application;
use AppBundle\Entity\ApplicationResponse\Acceptance;
use AppBundle\Form\Transformer\ApplicationAcceptanceDataTransformer;
use AppBundle\Service\AssociationSetter\Implementation\ApplicationResponsesSetter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationAcceptanceType extends AbstractType implements EventSubscriberInterface
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
        $nextIndex = $builder->getData()->getResponses()->count();

        $builder->add(
            $builder
                ->create('responses', AcceptanceType::class, [
                    'label' => false,
                    'error_bubbling' => false,
                    'property_path' => "responses[$nextIndex]",
                ])
                ->addModelTransformer(new ApplicationAcceptanceDataTransformer())
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
        $newAppeal = $application->getResponses()->last();

        $this->applicationResponsesSetter->set($application, $newAppeal);
    }
}
