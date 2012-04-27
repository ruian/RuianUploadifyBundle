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
        $options = $this->container->get('uploadify.options');

        $filename = $options['fileObjName'];
        $folder   = $options['folderUpload'];
        $web_dir  = $this->container->getParameter('kernel_dir') . '/../web/';

        $file = $request->files->get($filename);
        $file->move($web_dir. '/' .$folder);

        $response = new Response($file->getFilename());

        return $response;
    }
}