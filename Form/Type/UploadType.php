<?php


namespace Io\MediaCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Bsv\CmsBundle\Form\Type\ArticleLangType;
use Doctrine\Common\Persistence\ObjectManager;
use Io\MediaCollectionBundle\Form\DataTransformer\UploadTransformer;

class UploadType extends AbstractType
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
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new UploadTransformer($this->om);
        $builder->addModelTransformer($transformer);
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Io\MediaCollectionBundle\Entity\Upload',
//        ));
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected upload does not exist'
        ));        
    }

    public function getParent()
    {
        return 'hidden';
    }

    
    public function getName()
    {
        return 'io_media';
    }
}