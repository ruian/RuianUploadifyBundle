<?php
namespace Ruian\UploadifyBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Routing\Router;
use Ruian\UploadifyBundle\Model\Encrypt;

class UploadifyExtension extends AbstractTypeExtension
{
    protected $router;
    protected $token;

    public function __construct(Router $router, Encrypt $token)
    {
        $this->router = $router;
        $this->token = $token;
    }

    /**
     * Adds an uploadify configuration if uploadify is enable
     *
     * @param FormBuilder   $builder The form builder
     * @param array         $options The options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        if (false === $options['uploadify_enabled']) {
            return;
        }

        $builder->setAttribute('uploadify', 'OK');
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOptions()
    {
        return array(
            'uploadify_enabled'   => false
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'text';
    }
}