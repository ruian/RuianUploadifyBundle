<?php
namespace Ruian\UploadifyBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Ruian\UploadifyBundle\Model\Encryption;

/**
 * Adds session to uploadify request
 *
 * @author ruian
 */
class RequestListener
{
    protected $encryption;

    public function __construct(Encryption $encryption)
    {
        $this->encryption = $encryption;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        
        $request = $event->getRequest();
        
        if ($request->request->has('_uploadify_sessionid')) {
            $request->cookies->set(session_name(), 1);
            session_id($this->decrypt($request->request->get('_uploadify_sessionid')));
        }
    }

    protected function decrypt($string)
    {
        $string = preg_replace('/ /', '+', $string);

        return $this->encryption->decrypt($string);
    }
}
