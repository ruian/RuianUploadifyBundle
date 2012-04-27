<?php
namespace Ruian\UploadifyBundle\Form\Extension\Uploadify\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Ruian\UploadifyBundle\Model\Encrypt;

class FormTypeUploadifyExtension extends AbstractTypeExtension
{
    protected $router;

    protected $token;

    protected $default_options;

    public function __construct(RouterInterface $router, Encrypt $token, array $options)
    {
        $this->router = $router;
        $this->token = $token;
        $this->default_options = $this->createDefaultOptions($options);
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        if (!$options['uploadify_enabled']) {
            return;
        }

        // If an uploader action is given, generate the url
        if (true === isset($options['uploadify']['uploader']) && $route = $options['uploadify']['uploader']) {
            $options['uploadify']['uploader'] = $this->router->generate($route);
        }

        // If a check existing action is given, generate the url
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
        return $this->default_options;
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
        return 'text';
    }

    /**
     * Create the default options with options given by the DIC
     * @param  array  $options
     * @return array  $default_options
     */
    protected function createDefaultOptions(array $options)
    {
        $default_options = array();
        $default_options['uploadify_enabled'] = false;

        // add uploader route
        if (true === isset($options['uploader']) && $route = $options['uploader']) {
            $options['uploader'] = $this->router->generate($route);
        }
        // add uploader limit route
        if (true === isset($options['checkExisting']) && $route = $this->default_options['checkExisting']) {
            $options['checkExisting'] = $this->router->generate($route);
        }

        $default_options['uploadify'] = $options;

        return $default_options;
    }
}
