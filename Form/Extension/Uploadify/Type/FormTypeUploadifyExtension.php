<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Ruian\UploadifyBundle\Model\Encrypt;

class FormTypeUploadifyExtension extends AbstractTypeExtension
{
    protected $router;

    protected $token;

    protected $options;

    public function __construct(RouterInterface $router, Encrypt $token, array $options)
    {
        $this->router = $router;
        $this->token = $token;
        $this->setDefaultOptions($options);
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        if (!$options['uploadify_enabled']) {
            return;
        }

        $uploadify_attr = $this->createAttributes($options['uploadify']);

        $builder
            ->setAttribute('attr', array_merge($options['attr'], $uploadify_attr))
        ;
    }

    public function setDefaultOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get the default value by the config
     */
    public function getDefaultOptions()
    {
        return array(
            'uploadify_enabled' => false,
            'uploadify' => array(
                'auto'            => false,
                'buttonImg'       => '',
                'buttonText'      => '',
                'cancelImg'       => '',
                'checkScript'     => '',
                'displayData'     => '',
                'expressInstall'  => '',
                'fileDataName'    => '',
                'fileDesc'        => '',
                'fileExt'         => '',
                'folder'          => '',
                'height'          => '',
                'hideButton'      => '',
                'method'          => '',
                'multi'           => '',
                'queueID'         => '',
                'queueSizeLimit'  => '',
                'removeCompleted' => '',
                'rollover'        => '',
                'script'          => '',
                'scriptAccess'    => '',
                'scriptData'      => '',
                'simUploadLimit'  => '',
                'sizeLimit'       => '',
                'uploader'        => '',
                'width'           => '',
                'wmode'           => ''
            )
        );
    }

    protected function createAttributes(array $options_uploadify)
    {
        var_dump($options_uploadify);

        return array();
    }

    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'text';
    }
}
