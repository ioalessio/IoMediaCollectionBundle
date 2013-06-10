<?php

namespace Io\MediaCollectionBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;


class MediaUpload {
    
    /**
     * Assert\Valid
     */
    protected $embed;
        
    /**
     * @Assert\Choice(choices = {"embed", "blank"}, message = "Invalid value")
     * Assert\NotBlank
     */    
    protected $action;
    

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getEmbed() {
        return $this->embed;
    }

    public function setEmbed($embed = null) {
        $this->embed = $embed;
    }



    public function render() {
        
        switch($this->getAction()) {
            //case 'add':
            //    $value = $this->getAdd();
            //break;
            case 'embed':
                $value = $this->getEmbed();
            break;
            //case 'choice':
            //    $value = $this->getChoice();
            //break;
            case 'blank':
                $value = null;
            break;
            default:
                throw new \Exception("action missing");
            break;
        }

        return $value;        
    }
    
    function __construct($value = null) {
        
        //$this->choice = $value; 
        $this->embed = $value; 
        
        //$this->add = null;
        
        if($value) {
            $this->action = 'embed';
        }
        else {
            $this->action = 'blank';
            
        }
    }    
    
}

?>