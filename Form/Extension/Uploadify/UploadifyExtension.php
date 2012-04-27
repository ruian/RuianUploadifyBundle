<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify;

use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Routing\RouterInterface;

use Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;
use Ruian\UploadifyBundle\Model\Encryption;

class UploadifyExtension extends AbstractExtension
{
    protected $router;

    protected $encryption;
    
    protected $default_options;

    public function __construct(RouterInterface $router, Encryption $encryption, array $default_options)
    {
        $this->router = $router;
        $this->encryption = $encryption;
        $this->default_options = $default_options;
    }

    protected function loadTypeExtensions()
    {
        return array(
            new Type\FormTypeUploadifyExtension($this->router, $this->encryption, $this->default_options),
        );
    }
}
