<?php
declare(strict_types=1);

namespace AppBundle\Twig;

use AppBundle\Entity\ApplicationResponse\AbstractApplicationResponse;
use AppBundle\Entity\ApplicationResponse\Acceptance;
use AppBundle\Entity\ApplicationResponse\Appeal;
use AppBundle\Entity\ApplicationResponse\RejectionCause;
use Twig_Extension;
use Twig_SimpleFunction;

class ApplicationResponseExtension extends Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('application_response_class', [$this, 'getApplicationResponseClass']),
        ];
    }

    /**
     * @param AbstractApplicationResponse $response
     *
     * @return string
     */
    public function getApplicationResponseClass(AbstractApplicationResponse $response): string
    {
        switch (get_class($response)) {
            case Acceptance::class:
                return 'success';

            case Appeal::class:
                return 'warning';

            case RejectionCause::class:
                return 'alert';
        }

        return 'warning';
    }
}
