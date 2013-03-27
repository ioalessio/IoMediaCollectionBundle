<?php

namespace Io\MediaCollectionBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use \DateTime;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class Media {
    
    protected $id;
    
    protected $path;
    
    /**
     * @Assert\File()
     */
    protected $file;    
    
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

     public function getFile() {
         return $this->file;
     }

     public function setFile($file) {
         $this->file = $file;
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

     public function getWeb() {
         return "/media/uploads/".$this->getPath();
     }
     public function upload(UploadedFile $file, $path = "") {
       
        $fs = new Filesystem; 
        // Create target dir
        if (!$fs->exists($path))
                $fs->mkdir($path);
        return $file->move($path, $this->getPath());
     }
     
     public function getJsonArray() {
         return array(
             'id' => $this->getId(),
             'path' => $this->getPath(),
             'web' => $this->getWeb()
         );
     }
}

?>