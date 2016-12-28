<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Service\AssociationSetter\AssociationSetterInterface;
use AppBundle\Service\AssociationSetter\Implementation\ApplicationAttachmentsSetter;
use AppBundle\Service\AssociationSetter\Implementation\UserApplicationsSetter;
use AppBundle\Service\Util\CurrentUserProvider\CurrentUserProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType implements EventSubscriberInterface
{
    /** @var ApplicationAttachmentsSetter */
    private $applicationAttachmentsSetter;

    /**
     * @param ApplicationAttachmentsSetter $applicationAttachmentsSetter
     */
    public function __construct(ApplicationAttachmentsSetter $applicationAttachmentsSetter)
    {
        $this->applicationAttachmentsSetter = $applicationAttachmentsSetter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', NumberType::class, [
                'label' => 'application.year',
                'helper_text' => 'description.application.year',
            ])
            ->add('topic', TextType::class, [
                'label' => 'application.topic',
            ])
            ->add('meritoricalJustification', TextareaType::class, [
                'required' => false,
                'label' => 'application.meritoricalJustification',
                'helper_text' => 'description.application.meritoricalJustification',
            ])
            ->add('currentKnowledge', TextareaType::class, [
                'required' => false,
                'label' => 'application.currentKnowledge',
                'helper_text' => 'description.application.currentKnowledge',
            ])
            ->add('scientificAchievements', TextareaType::class, [
                'required' => false,
                'label' => 'application.scientificAchievements',
                'helper_text' => 'description.application.scientificAchievements',
            ])
            ->add('applicantsProjects', TextareaType::class, [
                'required' => false,
                'label' => 'application.applicantsProjects',
                'helper_text' => 'description.application.applicantsProjects',
            ])
            ->add('foreseeableGoals', TextareaType::class, [
                'required' => false,
                'label' => 'application.foreseeableGoals',
                'helper_text' => 'description.application.foreseeableGoals',
            ])
            ->add('scheduleOfWork', TextareaType::class, [
                'required' => false,
                'label' => 'application.scheduleOfWork',
                'helper_text' => 'description.application.scheduleOfWork',
            ])
            ->add('externalFinancing', CheckboxType::class, [
                'required' => false,
                'label' => 'application.externalFinancing',
                'helper_text' => 'description.application.externalFinancing',
            ])
            ->add('plannedExpensesTotal', NumberType::class, [
                'label' => 'application.plannedExpensesTotal',
                'helper_text' => 'description.application.plannedExpensesTotal',
            ])
            ->add('plannedExpensesInCurrentYear', NumberType::class, [
                'label' => 'application.plannedExpensesInCurrentYear',
                'helper_text' => 'description.application.plannedExpensesInCurrentYear',
            ])
            ->add('expensesExplanation', TextareaType::class, [
                'required' => false,
                'label' => 'application.expensesExplanation',
                'helper_text' => 'description.application.expensesExplanation',
            ])
            ->add('projectDirector', TextType::class, [
                'label' => 'application.projectDirector',
            ])
            ->add('organizationDirector', TextType::class, [
                'required' => false,
                'label' => 'application.organizationDirector',
            ])
            ->add('attachment', AttachmentType::class, [
                'required' => false,
                'label' => 'application.attachment'
            ])
        ;

        $builder->addEventSubscriber($this);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class
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

        $this->applicationAttachmentsSetter->set($application, $application->getAttachment());
    }
}
