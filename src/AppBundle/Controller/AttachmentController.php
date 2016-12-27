<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attachment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/attachment")
 */
class AttachmentController extends Controller
{
    /**
     * @param Attachment $attachment
     * @return Response
     *
     * @Route("/{attachment}/download", name="attachment_download")
     */
    public function downloadAction(Attachment $attachment): Response
    {
        $downloadHandler = $this->get('vich_uploader.download_handler');

        return $downloadHandler->downloadObject($attachment, 'file', null, $attachment->getOriginalName());
    }
}
