<?php


namespace Io\MediaCollectionBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MediaUploadValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $this->context->addViolation($constraint->message, array('%string%' => $value));
    }
}