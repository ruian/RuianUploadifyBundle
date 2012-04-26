<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Ruian\UploadifyBundle\Model\Encrypt;

class FormTypeUploadifyExtension extends AbstractTypeExtension
{
    protected $router;

    protected $token;

    protected $options;

    protected $container;

    public function __construct(RouterInterface $router, Encrypt $token, ContainerInterface $container)
    {
        $this->router = $router;
        $this->token = $token;
        $this->container = $container;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        if (!$options['uploadify_enabled']) {
            return;
        }
        // var_dump($options);
        $uploadify_attr = $this->createAttributes($options['uploadify']);

        $builder
            ->setAttribute('attr', array_merge($options['attr'], $uploadify_attr))
        ;
    }

    /**
     * Get the default value by the config
     */
    public function getDefaultOptions()
    {
        return array(
            'uploadify_enabled' => false,
            'uploadify'         => array(
                'auto'              => $this->container->getParameter('ruian.uploadify.auto'),
                'buttonClass'       => $this->container->getParameter('ruian.uploadify.buttonClass'),
                'buttonCursor'      => $this->container->getParameter('ruian.uploadify.buttonCursor'),
                'buttonImage'       => $this->container->getParameter('ruian.uploadify.buttonImage'),
                'buttonText'        => $this->container->getParameter('ruian.uploadify.buttonText'),
                'checkExisting'     => $this->container->getParameter('ruian.uploadify.checkExisting'),
                'debug'             => $this->container->getParameter('ruian.uploadify.debug'),
                'fileObjName'       => $this->container->getParameter('ruian.uploadify.fileObjName'),
                'fileSizeLimit'     => $this->container->getParameter('ruian.uploadify.fileSizeLimit'),
                'fileTypeDesc'      => $this->container->getParameter('ruian.uploadify.fileTypeDesc'),
                'fileTypeExts'      => $this->container->getParameter('ruian.uploadify.fileTypeExts'),
                'formData'          => $this->container->getParameter('ruian.uploadify.formData'),
                'height'            => $this->container->getParameter('ruian.uploadify.height'),
                'method'            => $this->container->getParameter('ruian.uploadify.method'),
                'multi'             => $this->container->getParameter('ruian.uploadify.multi'),
                'overrideEvents'    => $this->container->getParameter('ruian.uploadify.overrideEvents'),
                'preventCaching'    => $this->container->getParameter('ruian.uploadify.preventCaching'),
                'progressData'      => $this->container->getParameter('ruian.uploadify.progressData'),
                'queueID'           => $this->container->getParameter('ruian.uploadify.queueID'),
                'queueSizeLimit'    => $this->container->getParameter('ruian.uploadify.queueSizeLimit'),
                'removeCompleted'   => $this->container->getParameter('ruian.uploadify.removeCompleted'),
                'removeTimeout'     => $this->container->getParameter('ruian.uploadify.removeTimeout'),
                'requeueErrors'     => $this->container->getParameter('ruian.uploadify.requeueErrors'),
                'successTimeout'    => $this->container->getParameter('ruian.uploadify.successTimeout'),
                'swf'               => $this->container->getParameter('ruian.uploadify.swf'),
                'uploader'          => $this->container->getParameter('ruian.uploadify.uploader'),
                'uploadLimit'       => $this->container->getParameter('ruian.uploadify.uploadLimit'),
                'width'             => $this->container->getParameter('ruian.uploadify.width')
            )
        );
    }

    protected function createAttributes(array $options_uploadify)
    {
        $default_options = $this->getDefaultOptions();
        $options = array_merge($default_options['uploadify'], $options_uploadify);

        return array('data-uploadify', json_encode($options));
    }

    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'text';
    }
}
