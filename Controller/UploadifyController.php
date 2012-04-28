<?php
namespace Ruian\UploadifyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UploadifyController extends Controller
{
    public function uploadAction(Request $request)
    {
        // Get options from the DIC
        $options = $this->container->getParameter('ruian.uploadify.options');

        $filename = $options['fileObjName'];
        $folder   = $options['folderUpload'];
        $web_dir  = $this->container->getParameter('kernel.root_dir') . '/../web/';


        $file = $request->files->get($filename);
        $name = $file->getFilename();
        $extension = $file->getExtension();

        $file->move($web_dir. '/' .$folder, $name . $extension);
        
        $response = new Response();

        return $response;
    }
}