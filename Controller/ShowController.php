<?php

namespace Io\MediaCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Avalanche\Bundle\ImagineBundle\Imagine\CachePathResolver;
use Avalanche\Bundle\ImagineBundle\Imagine\Filter\FilterManager;
use Imagine\Image\ImagineInterface;
use Io\MediaCollectionBundle\Entity\Upload;

class ShowController extends Controller
{
    /**
     * @Route("/show/{id}/{format}", name="io_media_show_upload")
     * @Cache(expires="tomorrow")
     */
    public function showAction($id, $format = "tumb")
    {       
        $em = $this->getDoctrine()->getManager();
        $upload = $em->createQuery("SELECT u FROM IoMediaCollectionBundle:Upload u WHERE u.id = :id")
                ->setParameter('id', $id)
                ->getSingleResult();     
        return $this->image($upload, $format);
    }    
    

    /**
     * This action applies a given filter to a given image, saves the image and
     * outputs it to the browser at the same time
     *
     * @param string $path
     * @param string $filter
     *
     * @return Response
     */
    public function image(Upload $upload, $filter)
    {
        $request = $this->getRequest();
        $cachePathResolver = $this->get('imagine.cache.path.resolver');
        $imagine = $this->get('imagine');
        $filterManager = $this->get('imagine.filter.manager');
        $fs = new \Symfony\Component\Filesystem\Filesystem;
                
        $path = $upload->getWeb();
        $cachedImage = $cachePathResolver->getBrowserPath($path, $filter);                
        $path = '/'.ltrim($path, '/');

        $webRoot = $this->container->getParameter('imagine.web_root');
        $sourceRoot = $this->container->getParameter('imagine.source_root');
        
        //TODO: find out why I need double urldecode to get a valid path
        $browserPath = urldecode(urldecode($cachePathResolver->getBrowserPath($path, $filter)));
        $basePath = $request->getBaseUrl();

        if (!empty($basePath) && 0 === strpos($browserPath, $basePath)) {
             $browserPath = substr($browserPath, strlen($basePath));
        }

         // if cache path cannot be determined, return 404
        if (null === $browserPath) {
            throw new NotFoundHttpException('Image doesn\'t exist');
        }

        $realPath = $webRoot.$browserPath;
        $sourcePath = $sourceRoot.$path;

        // if the file has already been cached, we're probably not rewriting
        // correctly, hence make a 301 to proper location, so browser remembers
        if ($fs->exists($realPath)) {
            return new Response('', 301, array(
                'location' => $request->getBasePath().$browserPath
            ));
        }

        if (!$fs->exists($sourcePath)) {
            throw new NotFoundHttpException(sprintf(
                'Source image not found in "%s"', $sourcePath
            ));
        }

        $dir = pathinfo($realPath, PATHINFO_DIRNAME);

        if (!is_dir($dir)) {
            if (false === $fs->mkdir($dir)) {
                throw new \RuntimeException(sprintf(
                    'Could not create directory %s', $dir
                ));
            }
        }

        ob_start();
        try {
            $format  = $filterManager->getOption($filter, "format", "png");

            // TODO: get rid of hard-coded quality and format
            $filterManager->get($filter)
                ->apply($imagine->open($sourcePath))
                ->save($realPath, array(
                    'quality' => $filterManager->getOption($filter, "quality", 100),
                    'format'  => $filterManager->getOption($filter, "format", null)
                ))
                ->show($format);

            $type    = 'image/' . $format;
            $length  = ob_get_length();
            $content = ob_get_clean();

            // TODO: add more media headers
            $response = new Response($content);
            $response->headers->set('content-type', $type);
            $response->headers->set('content-length', $length);            
            $response->setPublic();
            $date = new \DateTime();
            $date->modify('+600 seconds');
            $response->setExpires($date);            
            return $response;
            
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }
    }    
}
