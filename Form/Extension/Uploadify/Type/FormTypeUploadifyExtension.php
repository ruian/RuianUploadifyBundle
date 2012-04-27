<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

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

        if (true === isset($options['uploadify']['uploader']) && $route = $options['uploadify']['uploader']) {
            $options['uploadify']['uploader'] = $this->router->generate($route);
        }

        if (true === isset($options['uploadify']['checkExisting']) && $route = $options['uploadify']['checkExisting']) {
            $options['uploadify']['checkExisting'] = $this->router->generate($route);
        }

        $uploadify_attr = $this->createAttributes($options['uploadify']);

        $builder
            ->setAttribute('data_uploadify', $uploadify_attr)
        ;
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        if ($form->hasAttribute('data_uploadify')) {
            $view->set('data_uploadify', $form->getAttribute('data_uploadify'));
        }
    }

    /**
     * Get the default value by the config
     */
    public function getDefaultOptions()
    {
        return array(
            'uploadify_enabled' => false,
            'uploadify'         => $this->getUploadifyOptions()
        );
    }

    protected function createAttributes(array $options_uploadify)
    {
        $default_options = $this->getDefaultOptions();
        $options = array_merge($default_options['uploadify'], $options_uploadify);

        return json_encode($options);
    }

    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'field';
    }

    protected function getUploadifyOptions()
    {
        // Retrieve parameter from container (DIC)
        $uploadify_options = array(
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
                'width'             => $this->container->getParameter('ruian.uploadify.width')
        );
        // add uploader route
        if ($route = $this->container->getParameter('ruian.uploadify.uploader')) {
            $uploadify_options['uploader'] = $this->router->generate($route);
        }
        // add uploader limit route
        if ($route = $this->container->getParameter('ruian.uploadify.checkExisting')) {
            $uploadify_options['checkExisting'] = $this->router->generate($route);
        }        
        return $uploadify_options;
    }
}
