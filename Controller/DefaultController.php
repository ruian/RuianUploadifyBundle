<?php

namespace Ruian\UploadifyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Ruian\UploadifyBundle\Model\Resource;

class DefaultController extends Controller
{       
    public function uploadAction()
    {
        $request = $this->get('request');

        $entity = new Resource();

        $entity->setFolder($request->request->get('folder'));
        $entity->setFile($request->files->get('Filedata'));

        $entity->upload();

        $response = new Response(json_encode($entity->toArray()));
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        return $response;
    }
}
