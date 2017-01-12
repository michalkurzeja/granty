<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Interfaces\TraceableInterface;
use AppBundle\Entity\User;
use AppBundle\Service\Util\CurrentUserProvider\CurrentUserProvider;
use DateTime;
use Symfony\Component\Translation\TranslatorInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class TraceableExtension extends Twig_Extension
{
    private const DATE_FORMAT = 'd.m.Y';
    private const TIME_FORMAT = 'H:i';
    private const DATE_NEVER = 'misc.never';
    private const USER_YOU = 'misc.you';

    /** @var TranslatorInterface */
    private $translator;
    /** @var CurrentUserProvider */
    private $currentUserProvider;

    public function __construct(TranslatorInterface $translator, CurrentUserProvider $currentUserProvider)
    {
        $this->translator = $translator;
        $this->currentUserProvider = $currentUserProvider;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('created', [$this, 'created'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('updated', [$this, 'updated'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('created_by', [$this, 'createdBy'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('updated_by', [$this, 'updatedBy'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param TraceableInterface $object
     * @return string
     */
    public function created(TraceableInterface $object): string
    {
        return $this->formatDate($object->getCreated());
    }

    /**
     * @param TraceableInterface $object
     * @return string
     */
    public function updated(TraceableInterface $object): string
    {
        return $this->formatDate($object->getUpdated());
    }

    /**
     * @param TraceableInterface $object
     * @return string
     */
    public function createdBy(TraceableInterface $object): string
    {
        return $this->formatUser($object->getCreatedBy());
    }

    /**
     * @param TraceableInterface $object
     * @return string
     */
    public function updatedBy(TraceableInterface $object): string
    {
        return $this->formatUser($object->getUpdatedBy());
    }

    /**
     * @param DateTime $dateTime
     * @return string
     */
    private function formatDate(DateTime $dateTime = null): string
    {
        if ($dateTime instanceof DateTime) {
            return sprintf(
                '%s %s %s %s',
                '<i class="fa fa-calendar-o text-secondary" aria-hidden="true"></i>',
                $dateTime->format(self::DATE_FORMAT),
                '<i class="fa fa-clock-o text-secondary" aria-hidden="true"></i>',
                $dateTime->format(self::TIME_FORMAT)
            );
        }

        return $this->translate(self::DATE_NEVER);
    }

    /**
     * @param string $id
     * @param string $domain
     * @param array  $parameters
     * @return string
     */
    private function translate(string $id, string $domain = 'entities', array $parameters = []): string
    {
        return $this->translator->trans($id, $parameters, $domain);
    }

    /**
     * @param User|null $user
     * @return string
     */
    private function formatUser(User $user = null): string
    {
        if ($user instanceof User) {
            return sprintf(
                '%s %s',
                '<i class="fa fa-user-o text-secondary" aria-hidden="true"></i>',
                $this->getUserName($user)
            );
        }

        return '';
    }

    private function getUserName(User $user): string
    {
        if ($this->currentUserProvider->getCurrentUser() === $user) {
            return sprintf('<strong>%s</strong>', $this->translate(self::USER_YOU));
        }

        return $user->getFullName();
    }
}
