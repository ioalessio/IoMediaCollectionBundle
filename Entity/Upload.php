<?php

namespace Io\MediaCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use \DateTime;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Io\MediaCollectionBundle\Entity\Media;

/**
 * @ORM\Entity()
 * @ORM\Table(name="media_uploads")
 **/
class Upload {
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="NONE")
     */    
    protected $id;
    
    /**
     * @ORM\Column(name="path", type="string")
     */
    protected $path;

    /**
     * @Assert\NotBlank()
     * @Assert\DateTime
     */
    protected $createdAt;
    
    /**
     * @Assert\NotBlank()
     * @Assert\DateTime
     */
     protected $updatedAt;

     /**
      *
      */
     protected $media;
    
     function __construct() {
         $this->updatedAt = new DateTime;
         $this->createdAt = new DateTime;
     }

     public function getId() {
         return $this->id;
     }

     public function setId($id) {
         $this->id = $id;
     }

     public function getPath() {
         return $this->path;
     }

     public function setPath($path) {
         $this->path = $path;
     }

     public function getCreatedAt() {
         return $this->createdAt;
     }

     public function setCreatedAt($createdAt) {
         $this->createdAt = $createdAt;
     }

     public function getUpdatedAt() {
         return $this->updatedAt;
     }

     public function setUpdatedAt($updatedAt) {
         $this->updatedAt = $updatedAt;
     }

     public function upload(UploadedFile $file, $path = "") {
       
        $fs = new Filesystem; 
        // Create target dir
        if (!$fs->exists($path))
                $fs->mkdir($path);
        return $file->move($path, $this->getPath());
     }
     
     public function getMedia() {
         $this->media = new Media;
         $this->media->setId($this->getId());
         $this->media->setPath($this->getPath());         
         return $this->media;
     }
}

?>