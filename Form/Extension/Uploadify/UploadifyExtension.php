<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify;

use Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;
use Ruian\UploadifyBundle\Model\Encrypt;
use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Routing\RouterInterface;

class UploadifyExtension extends AbstractExtension
{
    protected $router;

    protected $token;

    protected $options;

    public function __construct(RouterInterface $router, Encrypt $token, array $options)
    {
        $this->router = $router;
        $this->token = $token;
        $this->options = $options;
    }

    protected function loadTypeExtensions()
    {
        return array(
            new Type\FormTypeUploadifyExtension($this->router, $this->token, $this->options),
        );
    }
}
