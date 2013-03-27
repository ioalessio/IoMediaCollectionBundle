<?php

namespace Io\MediaCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Filesystem\Exception\IOException;
use Io\MediaCollectionBundle\Entity\Media;

class UploadController extends Controller
{
    /**
     * @Route("/upload.json", name="media_upload")
     */
    public function indexAction()
    {
        try {
            $response = $this->doUpload();  
            //posso salvare in db

        } catch (IOException $e) {
            $response = new $response-($e->getMessage() );
        }
        
        return $response;
    }

/**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws IOException
     */
    public function doUpload() {        
        
        
        try {
            $targetDir = $this->container->getParameter('kernel.root_dir')."/../web/media/uploads";        
            
            $file = $this->getRequest()->files->get('file');
            $media = new Media();
            $media->setPath(preg_replace('/[^\w\._]+/', '_', $file->getClientOriginalName()));
            $media->upload($file, $targetDir);
           
            $out = array('jsonrpc' => "2.0", "id" => "id", "result" => $media->getJsonArray() );
            $response = new Response(json_encode($out));
            $response->headers->set('Content-type', 'application/json');
            return $response;

        } catch (IOException $e) {
            throw new IOException('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        }   
    }    
}
