<?php 

namespace Io\MediaCollectionBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MediaUpload extends Constraint
{
    public $message = 'Invalid media upload object';
}