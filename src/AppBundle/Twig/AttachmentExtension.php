<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Attachment;
use AppBundle\Service\Attachment\AttachmentLinkProvider;
use Twig_Extension;
use Twig_SimpleFunction;

class AttachmentExtension extends Twig_Extension
{
    /**
     * @var AttachmentLinkProvider
     */
    private $attachmentLinkProvider;

    /**
     * @param AttachmentLinkProvider $attachmentLinkProvider
     */
    public function __construct(AttachmentLinkProvider $attachmentLinkProvider)
    {
        $this->attachmentLinkProvider = $attachmentLinkProvider;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('attachment_link', [$this, 'attachmentLink']),
        ];
    }

    /**
     * @param Attachment $attachment
     * @return string
     */
    public function attachmentLink(Attachment $attachment)
    {
        return $this->attachmentLinkProvider->getAttachmentLink($attachment);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'attachment';
    }
}