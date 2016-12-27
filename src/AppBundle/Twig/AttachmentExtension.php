<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Attachment;
use AppBundle\Service\Attachment\AttachmentLinkProvider;
use Twig_Environment;
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

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('attachment_link', [$this, 'attachmentLink']),
            new Twig_SimpleFunction(
                'attachment_download',
                [$this, 'attachmentDownload'],
                [
                    'needs_environment' => true,
                    'is_safe'           => ['html'],
                ]
            ),
        ];
    }

    /**
     * @param Attachment $attachment
     * @return string
     */
    public function attachmentLink(Attachment $attachment): string
    {
        return $this->attachmentLinkProvider->getAttachmentLink($attachment);
    }

    /**
     * @param Twig_Environment $env
     * @param Attachment       $attachment
     * @return string
     */
    public function attachmentDownload(Twig_Environment $env, Attachment $attachment): string
    {
        return $env->render('layout/elements/attachment_download.html.twig', [
            'attachment' => $attachment
        ]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'attachment';
    }
}
