<?php
namespace Ruian\UploadifyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Options;
use Ruian\UploadifyBundle\Model\Encrypt;

class ResourceType extends AbstractType
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getParent(array $options)
    {
        return 'file';
    }

    public function getDefaultOptions()
    {
        $self = $this;
        return array(
            'data_class' => function (Options $options) {
                return 'Ruian\UploadifyBundle\Model\Resource';
            },
            'attr' => function (Options $options) use ($self) {
                return array(
                    'data-session'  => urlencode($self->encrypt(session_id())),
                    'data-folder'   => $options['data']['folder'],
                    'data-preview'  => array_key_exists('preview', $options['data']) ? $options['data']['preview'] : null,
                    'data-path'     => $options['data']['path'],
                    'data-copy'     => $options['data']['copy'],
                );
            },
            'data_class' => function (Options $options) {
                return false;
            }
        );
    }

    public function getName()
    {
        return 'uploadify';
    }

    public function encrypt($string)
    {
        $crypt = new Encrypt($this->token);
        return $crypt->encrypt($string);
    }
}
