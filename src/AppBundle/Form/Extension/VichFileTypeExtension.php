<?php

namespace AppBundle\Form\Extension;

use AppBundle\Entity\Attachment;
use AppBundle\Service\Attachment\AttachmentLinkProvider;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Routing\RouterInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;

class VichFileTypeExtension extends AbstractTypeExtension
{
    /** @var AttachmentLinkProvider */
    private $attachmentLinkProvider;

    /**
     * @param AttachmentLinkProvider $attachmentLinkProvider
     */
    public function __construct(AttachmentLinkProvider $attachmentLinkProvider)
    {
        $this->attachmentLinkProvider = $attachmentLinkProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if ($this->canDisplayDownloadLink($form, $options)) {
            /** @var Attachment $attachment */
            $attachment = $form->getParent()->getData();

            $view->vars['original_name'] = $attachment->getOriginalName();
            $view->vars['download_uri'] = $this->attachmentLinkProvider->getAttachmentLink($attachment);
        }
    }

    private function canDisplayDownloadLink(FormInterface $form, array $options): bool
    {
        $attachment = $form->getParent()->getData();

        return $attachment instanceof Attachment
            && $attachment->getId()
            && $options['download_link'];
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType(): string
    {
        return VichFileType::class;
    }
}
