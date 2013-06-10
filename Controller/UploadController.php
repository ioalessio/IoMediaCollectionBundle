<?php

namespace Io\MediaCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Filesystem\Exception\IOException;
use Io\MediaCollectionBundle\Entity\Media;
use Io\MediaCollectionBundle\Entity\Upload;

class UploadController extends Controller
{
    /**
     * @Route("/upload.json", name="io_media_upload")
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
            $upload = new Upload();
            $upload->setFile($this->getRequest()->get('fileid'));
 
            $upload->setPath($upload->getFile().'.'.$file->guessExtension());
            //$upload->setPath(preg_replace('/[^\w\._]+/', '_', $file->getClientOriginalName()));
            
            
            $validator = $this->get('validator');
            if( $validator->validate($upload))
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($upload);
                $em->flush();
                
                $upload->upload($file, $targetDir);
                
                
                $cachePathResolver = $this->get('imagine.cache.path.resolver');
                $path = $upload->getWeb();
                $cachedImage = $cachePathResolver->getBrowserPath($path, 'tumb');
        
                $result = array(
                    'id'  => $upload->getId(),
                    'file' => $upload->getFile(),
                    'path' => $upload->getPath(),
                    'image' => $cachedImage
                    //'image' => $this->generateUrl('io_media_show_upload', array('id' => $upload->getId(), 'format' => 'small'))
                    );
                
                $out = array('jsonrpc' => "2.0", "id" => "id", "result" => $result );
                $response = new Response(json_encode($out));
                $response->headers->set('Content-type', 'application/json');
                return $response;
            }
            else
                throw new IOException('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to save file data in your database."}, "id" : "id"}');

        } catch (IOException $e) {
            throw new IOException('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        }   
    }    
}
