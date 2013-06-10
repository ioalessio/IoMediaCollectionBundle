<?php

namespace Io\MediaCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use \DateTime;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity()
 * @ORM\Table(name="media_uploads")
 **/
class Upload {
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;
    
    /**
     * @ORM\Column(name="file", type="string", unique=true)
     */    
    protected $file;
    
    /**
     * @ORM\Column(name="path", type="string")
     */
    protected $path;


    
     function __construct() {
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

     
     public function getFile() {
         return $this->file;
     }

     public function setFile($file) {
         $this->file = $file;
     }

    public function upload(UploadedFile $file, $path = "") {
       
        $fs = new Filesystem; 
        // Create target dir
        if (!$fs->exists($path))
                $fs->mkdir($path);
        
        return $file->move($path, $this->getPath());
     }
     
    
     public function __toString() {
         return (string)$this->getFile();
     }
     

     public function getJsonArray() {
         return array(
             'id' => $this->getId(),
             'file' => $this->getFile(),
             
             'path' => $this->getPath(),
             'web' => $this->getWeb()
         );
     }
     
     public function getWeb() {
         return "/media/uploads/".$this->getPath();
     }        
     
}

?>