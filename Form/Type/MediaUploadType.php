<?php
namespace Io\MediaCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Routing\RouterInterface;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Io\MediaCollectionBundle\Form\DataTransformer\MediaUploadTransformer;

class MediaUploadType extends AbstractType
{
    private $router;
    private $om;
    
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, RouterInterface $router)
    {
        $this->om = $om;
        $this->router = $router;
    }    
    
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }
    
    public function getParent()
    {
        return 'io_media_upload';
    }
    
    public function getName()
    {
        return 'io_media_upload';
    }
        
}