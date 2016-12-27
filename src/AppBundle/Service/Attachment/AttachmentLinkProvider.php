<?php
namespace AppBundle\Service\Attachment;

use AppBundle\Entity\Attachment;
use Symfony\Component\Routing\RouterInterface;

class AttachmentLinkProvider
{
    /** @var RouterInterface */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Attachment $attachment
     * @return string
     */
    public function getAttachmentLink(Attachment $attachment): string
    {
        return $this->router->generate('attachment_download', [
            'attachment' => $attachment->getId()
        ]);
    }
}
