<?php

namespace AppBundle\Form\Type;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType;

class ProfileType extends AbstractType
{
    const YEAR_MIN = 1900;
    const YEAR_OFFSET = 150;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'user.firstName'])
            ->add('lastName', TextType::class, ['label' => 'user.lastName'])
            ->add('degree', TextType::class, ['label' => 'user.degree'])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'user.dateOfBirth',
                'years' => $this->getYears(),
                'placeholder' => ['day' => 'misc.day', 'month' => 'misc.month', 'year' => 'misc.year'],
            ])
        ;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return ProfileFormType::class;
    }

    /**
     * @return int[]
     */
    private function getYears()
    {
        $currentYear = $this->getCurrentYear();
        $range = range($this->getStartingYear($currentYear), $currentYear);

        return array_combine($range, $range);
    }

    /**
     * @return int
     */
    private function getCurrentYear()
    {
        return (int)(new DateTime)->format('Y');
    }

    /**
     * @param $currentYear
     * @return int
     */
    private function getStartingYear($currentYear)
    {
        $start = $currentYear - self::YEAR_OFFSET;

        if ($start < self::YEAR_MIN) {
            return self::YEAR_MIN;
        }

        return $start;
    }
}