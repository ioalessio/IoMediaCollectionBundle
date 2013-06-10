<?php

namespace Io\MediaCollectionBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Doctrine\Common\Persistence\ObjectManager;

class MediaUploadTransformer implements DataTransformerInterface
{    
    
    private $om;
    
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }  
    
    /**
     * @param  Object|null $value
     * @return MediaUpload
     */
    public function transform($value)
    {
        return $value;
        
    }

    /**
     * Transforms a array to an object .
     *
     * @param  MediaUpload $mediaUpload
     *
     * @return Object|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($value)
    {
        if(!$value->getUpload())
            return null;
        else
            return $value;        
    }   
}

?>