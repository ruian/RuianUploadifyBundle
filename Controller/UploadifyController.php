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

        $response = new Response();

        if (true === $request->files->has($filename)) {
            $file = $request->files->get($filename);
            $name = $file->getFilename();
            $extension = $file->guessExtension();
            $data = sprintf('%s.%s', $name, $extension);

            $file->move($web_dir. '/' .$folder, $data);

            $response->setContent($data);
        }

        return $response;
    }
}