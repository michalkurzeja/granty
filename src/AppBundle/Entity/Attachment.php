<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({"AppBundle\Listener\Attachment\RemoveHandler\ApplicationAssociationHandler"})
 * @Vich\Uploadable
 */
class Attachment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="attachment", fileNameProperty="name")
     *
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $originalName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="Application", inversedBy="attachment")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Application
     */
    private $application;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return File|UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File|UploadedFile $file
     */
    public function setFile(?File $file)
    {
        $this->file = $file;

        if ($file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName)
    {
        $this->originalName = $originalName;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication(?Application $application)
    {
        $this->application = $application;
    }
}
