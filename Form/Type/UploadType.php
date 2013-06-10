<?php


namespace Io\MediaCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Io\MediaCollectionBundle\Form\DataTransformer\UploadTransformer;


class UploadType extends AbstractType
{
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
//        $builder->add('id', 'text', array('required' => true));
//        $builder->add('file', 'text', array('required' => true));
        
        $transformer = new UploadTransformer($this->om);
        $builder->addModelTransformer($transformer);
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
        $resolver->setDefaults(array(
            //'data_class' => 'Io\MediaCollectionBundle\Entity\Upload',                        
        ));        
    }
    
    public function getParent()
    {
        return 'hidden';
    }
    
    public function getName()
    {
        return 'io_upload';
    }
}