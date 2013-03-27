<?php


namespace Io\MediaCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Bsv\CmsBundle\Form\Type\ArticleLangType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path', 'text');
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Io\MediaCollectionBundle\Entity\Media',
        ));
    }

    public function getName()
    {
        return 'io_media';
    }
}