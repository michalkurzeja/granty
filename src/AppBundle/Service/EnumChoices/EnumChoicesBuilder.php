<?php
declare(strict_types = 1);
namespace AppBundle\Service\EnumChoices;

use MyCLabs\Enum\Enum;
use ReflectionClass;
use Symfony\Component\Translation\TranslatorInterface;

class EnumChoicesBuilder
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
     * @param string | Enum $enumClass
     * @param string | null $keyPrefix
     *
     * @return array
     */
    public function buildChoices(string $enumClass, ?string $keyPrefix = null): array
    {
        if (null === $keyPrefix) {
            $keyPrefix = $this->generatePrefix($enumClass);
        }

        $choices = [];

        foreach ($enumClass::values() as $value) {
            $label = $this->translator->trans("$keyPrefix.$value", [], 'enums');
            $choices[$label] = (string) $value;
        }

        return $choices;
    }

    /**
     * @param string $enumClass
     *
     * @return string
     */
    private function generatePrefix(string $enumClass): string
    {
        $reflection = new ReflectionClass($enumClass);

        return lcfirst($reflection->getShortName());
    }
}
