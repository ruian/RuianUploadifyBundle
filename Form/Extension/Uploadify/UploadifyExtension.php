<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify;

use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Routing\RouterInterface;

use Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;
use Ruian\UploadifyBundle\Model\Encrypt;

class UploadifyExtension extends AbstractExtension
{
    protected $router;

    protected $token;
    
    protected $default_options;

    public function __construct(RouterInterface $router, Encrypt $token, array $default_options)
    {
        $this->router = $router;
        $this->token = $token;
        $this->default_options = $default_options;
    }

    protected function loadTypeExtensions()
    {
        return array(
            new Type\FormTypeUploadifyExtension($this->router, $this->token, $this->default_options),
        );
    }
}
