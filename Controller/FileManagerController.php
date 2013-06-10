<?php

namespace Io\MediaCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Avalanche\Bundle\ImagineBundle\Imagine\CachePathResolver;
use Avalanche\Bundle\ImagineBundle\Imagine\Filter\FilterManager;
use Imagine\Image\ImagineInterface;
use Io\MediaCollectionBundle\Entity\Upload;

class FileManagerController extends Controller
{
    
    /**
     * @Route("/filemanager", name="io_media_list_upload")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $uploads = $em->createQuery("SELECT u FROM IoMediaCollectionBundle:Upload u")->getArrayResult();     
        return array('uploads' => $uploads);
    }
    
    /**
     * @Route("/filemanager/upload", name="io_media_list_upload")
     * @Template()
     */
    public function uploadAction() {


    }    
}
