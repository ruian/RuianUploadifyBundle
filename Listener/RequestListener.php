<?php
namespace Ruian\UploadifyBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Ruian\UploadifyBundle\Model\Encrypt;


/**
 * Adds session to uploadify request
 *
 * @author ruian
 */
class RequestListener
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        
        $request = $event->getRequest();
        
        if ($request->request->get('_sessionid') && $request->request->get('_uploadify')) {
            $request->cookies->set(session_name(), 1);
            session_id($this->decrypt($request->request->get('_sessionid')));
        }
    }

    protected function decrypt($string)
    {
        $crypt = new Encrypt($this->token);
        return $crypt->decrypt(preg_replace('/ /', '+', $string));
    }
}
