<?php

    namespace Io\MediaCollectionBundle\Form\Type;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;

    use Doctrine\Common\Persistence\ObjectManager;
    use Symfony\Component\Routing\RouterInterface;

    use Symfony\Component\Form\FormView;
    use Symfony\Component\Form\FormInterface;
    
    use Io\MediaCollectionBundle\Form\DataTransformer\MediaUploadTransformer;

class MediaType extends AbstractType
{
    private $om;
    private $router;
    
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, RouterInterface $router)
    {
        $this->om = $om;
        $this->router = $router;
    }        
    
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        //$view->vars['embedtype'] = $form->getConfig()->getAttribute('prototype')->createView($view);

        $view->vars['attr'] = array(
            'data-upload' => $this->router->generate($options['upload_route']),
            'class' => 'io_media_upload'
        );
        
    }   
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('upload', 'io_upload', array(
  //            'label_render'      => false,
  //            'widget_controls'   => false,
  //            'widget_control_group' => false

        ));
      
        $transformer = new MediaUploadTransformer($this->om);
        $builder->addModelTransformer($transformer);      
            
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('upload_route', 'upload_route_parameters'));
        
        $resolver->setDefaults(array(
            'upload_route' => 'io_media_upload',
            'upload_route_parameters' => array(),
        ));
    }

    
    public function getName()
    {
        return 'io_media';
    }
}