<?php


namespace Io\MediaCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('upload', 'io_media_upload');        
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }
    
    public function getName()
    {
        return 'io_media';
    }
}