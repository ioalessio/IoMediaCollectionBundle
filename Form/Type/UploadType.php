<?php


namespace Io\MediaCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\RouterInterface;
use Io\MediaCollectionBundle\Form\DataTransformer\UploadTransformer;

class UploadType extends AbstractType
{
 /**
     * @var ObjectManager
     */
    private $om;

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {

        $view->vars['attr'] = array('data-upload' => $this->router->generate($options['upload_route']),
                                    'data-path' => $view->vars['id'].'_path',
            
                                    'class' => 'io_media_upload'
                                   );
        
    }
    
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
        $builder->add('id');

       
        $transformer = new UploadTransformer($this->om);
        $builder->addModelTransformer($transformer);
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('upload_route', 'upload_route_parameters'));
        
        $resolver->setDefaults(array(
            'upload_route' => 'io_media_upload',
            'upload_route_parameters' => array(),
            'data_class' => 'Io\MediaCollectionBundle\Entity\Upload',
            'invalid_message' => 'The selected upload does not exist'
        ));        
    }
    
    public function getName()
    {
        return 'io_media_upload';
    }
}