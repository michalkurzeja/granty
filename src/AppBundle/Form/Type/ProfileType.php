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
    private const YEAR_MIN = 1900;
    private const YEAR_OFFSET = 150;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'user.firstName'])
            ->add('lastName', TextType::class, ['label' => 'user.lastName'])
            ->add('department', TextType::class, ['label' => 'user.department'])
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
    public function getParent(): string
    {
        return ProfileFormType::class;
    }

    /**
     * @return int[]
     */
    private function getYears(): array
    {
        $currentYear = $this->getCurrentYear();
        $range = range($this->getStartingYear($currentYear), $currentYear);

        return array_combine($range, $range);
    }

    /**
     * @return int
     */
    private function getCurrentYear(): int
    {
        return (int) (new DateTime)->format('Y');
    }

    /**
     * @param int $currentYear
     * @return int
     */
    private function getStartingYear(int $currentYear): int
    {
        $start = $currentYear - self::YEAR_OFFSET;

        if ($start < self::YEAR_MIN) {
            return self::YEAR_MIN;
        }

        return $start;
    }
}
