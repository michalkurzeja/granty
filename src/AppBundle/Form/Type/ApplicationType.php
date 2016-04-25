<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class
        ]);
    }
}