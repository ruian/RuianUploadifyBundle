<?php
namespace Ruian\UploadifyBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


/**
 * Adds session to uploadify request
 *
 * @author ruian
 */
class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        
        $request = $event->getRequest();

        if ($request->request->get('_session') && $request->request->get('_uploadify')) {
            $_COOKIE[ini_get('session.name')] = $request->request->get('_session');
            $request->cookies->set(ini_get('session.name'), $request->request->get('_session'));
        }
    }
}
