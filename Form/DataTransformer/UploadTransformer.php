<?php

namespace Io\MediaCollectionBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\TaskBundle\Entity\Issue;

class UploadTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Upload|null $issue
     * @return string
     */
    public function transform($upload)
    {
        if (null === $upload) {
            return "";
         }
                
        return $upload->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $number
     *
     * @return Upload|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }
        
        $upload = $this->om
            ->getRepository('IoMediaCollectionBundle:Upload')
            ->findOneBy(array('id' => $id))
        ;

        if (null === $upload) {
            throw new TransformationFailedException(sprintf(
                'Upload "%s" does not exist!',
                $id
            ));
        }

        return $upload;
    }
}?>
