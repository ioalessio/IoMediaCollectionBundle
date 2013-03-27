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

     public function getJsonArray() {
         return array(
             'id' => $this->getId(),
             'path' => $this->getPath(),
             'web' => $this->getWeb()
         );
     }
     
     public function getWeb() {
         return "/media/uploads/".$this->getPath();
     }        
}

?>