<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Service\AssociationSetter\AssociationSetterInterface;
use AppBundle\Service\Util\CurrentUserProvider\CurrentUserProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType implements EventSubscriberInterface
{
    /** @var CurrentUserProvider */
    private $currentUserProvider;
    /** @var AssociationSetterInterface */
    private $associationSetter;

    /**
     * @param CurrentUserProvider $currentUserProvider
     * @param AssociationSetterInterface $associationSetter
     */
    public function __construct(CurrentUserProvider $currentUserProvider, AssociationSetterInterface $associationSetter)
    {
        $this->currentUserProvider = $currentUserProvider;
        $this->associationSetter = $associationSetter;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', NumberType::class)
            ->add('topic', TextType::class)
            ->add('meritoricJustification', TextareaType::class, ['required' => false])
            ->add('currentKnowledge', TextareaType::class, ['required' => false])
            ->add('scientificAchievements', TextareaType::class, ['required' => false])
            ->add('applicantsProjects', TextareaType::class, ['required' => false])
            ->add('forseeableGoals', TextareaType::class, ['required' => false])
            ->add('scheduleOfWork', TextareaType::class, ['required' => false])
            ->add('financialSources', TextareaType::class, ['required' => false])
            ->add('plannedExpensesTotal', NumberType::class)
            ->add('plannedExpensesInCurrentYear', NumberType::class)
            ->add('expensesExplanation', TextareaType::class)
            ->add('projectDirector', TextType::class)
            ->add('organizationDirector', TextType::class)
        ;

        $builder->addEventSubscriber($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class
        ]);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    /**
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event)
    {
        /** @var Application $application */
        $application = $event->getData();
        $user = $this->currentUserProvider->getCurrentUser();

        $this->associationSetter->set($user, $application);
    }

    /**
     * @return User|null
     */
    private function getCurrentUser()
    {
        return $this->currentUserProvider->getCurrentUser();
    }
}