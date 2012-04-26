<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify;

use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;
use Ruian\UploadifyBundle\Model\Encrypt;

class UploadifyExtension extends AbstractExtension
{
    protected $router;

    protected $token;
    
    protected $container;

    public function __construct(RouterInterface $router, Encrypt $token, ContainerInterface $container)
    {
        $this->router = $router;
        $this->token = $token;
        $this->container = $container;
    }

    protected function loadTypeExtensions()
    {
        return array(
            new Type\FormTypeUploadifyExtension($this->router, $this->token, $this->container),
        );
    }
}
