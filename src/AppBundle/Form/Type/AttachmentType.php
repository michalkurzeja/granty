<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Attachment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AttachmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', VichFileType::class, [
                'required' => $options['required'],
                'allow_delete' => $options['allow_delete'],
                'download_link' => $options['download_link'],
                'label' => 'attachment.file'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attachment::class,
            'allow_delete' => true,
            'download_link' => true,
        ]);
    }
}
