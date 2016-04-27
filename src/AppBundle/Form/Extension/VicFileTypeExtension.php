<?php

namespace AppBundle\Form\Extension;

use AppBundle\Entity\Attachment;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Routing\RouterInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;

class VicFileTypeExtension extends AbstractTypeExtension
{
    /** @var RouterInterface */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($this->canDisplayDownloadLink($form, $options)) {
            /** @var Attachment $attachment */
            $attachment = $form->getParent()->getData();

            $view->vars['original_name'] = $attachment->getOriginalName();
            $view->vars['download_uri'] = $this->router->generate('attachment_download', [
                'attachment' => $attachment->getId()
            ]);
        }
    }

    private function canDisplayDownloadLink(FormInterface $form, array $options)
    {
        return $form->getParent()->getData() instanceof Attachment
            && $options['download_link'];
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return VichFileType::class;
    }
}